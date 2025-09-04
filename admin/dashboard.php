<?php
session_start();
// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "resume";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



if(!isset( $_SESSION['admin_login'])){
  header('location:../login.php');
}

// Fetch statistics
// Total Resumes
$stmt = $pdo->query("SELECT COUNT(*) as total_resumes FROM resumes");
$total_resumes = $stmt->fetch()['total_resumes'];

// Active Users (users who have created resumes)
$stmt = $pdo->query("SELECT COUNT(DISTINCT email) as active_users FROM resumes");
$active_users = $stmt->fetch()['active_users'];

// Templates Used (distinct templates from history)
$stmt = $pdo->query("SELECT COUNT(DISTINCT template) as templates_used FROM history");
$templates_used = $stmt->fetch()['templates_used'];

// Completion Rate (assuming resumes with all required fields are complete)
$stmt = $pdo->query("SELECT COUNT(*) as completed FROM resumes WHERE full_name != '' AND email != '' AND phone != ''");
$completed_resumes = $stmt->fetch()['completed'];
$completion_rate = $total_resumes > 0 ? round(($completed_resumes / $total_resumes) * 100) : 0;

// Fetch recent resume history with user details
$stmt = $pdo->query("
    SELECT 
        r.full_name,
        r.email,
        h.template,
        h.created_at,
        r.professional_field,
        CASE 
            WHEN r.full_name != '' AND r.email != '' AND r.phone != '' AND r.professional_summary != '' THEN 'Completed'
            ELSE 'Draft'
        END as status
    FROM history h
    JOIN resumes r ON h.resume_id = r.id
    ORDER BY h.created_at DESC
    LIMIT 10
");
$recent_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get initials from name
function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper($word[0]);
        }
        if (strlen($initials) >= 2) break;
    }
    return $initials ?: 'U';
}

// Function to format template name
function formatTemplateName($template) {
    return ucfirst(str_replace(['template', '_'], ['', ' '], strtolower($template)));
}

// Function to get template badge class
function getTemplateBadgeClass($template) {
    $template_lower = strtolower($template);
    if (strpos($template_lower, 'modern') !== false || strpos($template_lower, '1') !== false) {
        return 'badge-modern';
    } elseif (strpos($template_lower, 'professional') !== false || strpos($template_lower, '2') !== false) {
        return 'badge-professional';
    } else {
        return 'badge-creative';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResumeCraft Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background: var(--background-light);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        :root {
            /* Elegant Color Palette - Updated */
            --primary: #29353C;
            --primary-light: #44576D;
            --primary-dark: #1C252B;
            --secondary: #768A96;
            --secondary-light: #9AA9B3;
            --secondary-dark: #5E717D;
            --accent: #AAC7D8;
            --accent-light: #C4DAE8;
            --accent-dark: #8FB4CB;
            --background-light: #DFEBF6;
            --background-dark: #111827;
            --surface: #FFFFFF;
            --surface-dark: #1F2937;
            --text-primary: #1F2937;
            --text-secondary: #5E717D;
            --text-light: #FFFFFF;
            --text-on-primary: #FFFFFF;
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
            --info: #3B82F6;
            --frosted-bg: rgba(255, 255, 255, 0.85);
            --frosted-border: rgba(255, 255, 255, 0.25);
            --frosted-shadow: rgba(0, 0, 0, 0.1);
            --dark-frosted-bg: rgba(17, 24, 39, 0.85);
            --dark-frosted-border: rgba(255, 255, 255, 0.15);
            --dark-frosted-shadow: rgba(0, 0, 0, 0.25);
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-light) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            --gradient-hero: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            --gradient-subtle: linear-gradient(135deg, rgba(41, 53, 60, 0.1) 0%, rgba(118, 138, 150, 0.1) 100%);
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-mono: 'Fira Code', monospace;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.15);
            --shadow-primary: 0 4px 20px rgba(41, 53, 60, 0.2);
            --shadow-secondary: 0 4px 20px rgba(118, 138, 150, 0.2);
            --shadow-accent: 0 4px 20px rgba(170, 199, 216, 0.2);
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 50px;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--primary);
            color: var(--text-on-primary);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
            padding: 0 12px;
        }

        .logo-icon {
            font-size: 28px;
            margin-right: 12px;
            color: var(--accent);
        }

        .logo-text {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 22px;
        }

          .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            margin: 6px 0;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-on-primary);
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--text-on-primary);
        }

        .nav-link.active {
            background: var(--primary-light);
            position: relative;
            color: var(--text-on-primary);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--accent);
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .nav-icon {
            margin-right: 12px;
            font-size: 20px;
            width: 24px;
            text-align: center;
            color: var(--text-on-primary);
        }

        .nav-text {
            color: var(--text-on-primary);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .page-title {
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--surface);
            padding: 10px 16px;
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-sm);
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            padding: 4px 8px;
            width: 220px;
            color: var(--text-primary);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: var(--radius-full);
            transition: var(--transition);
        }

        .user-profile:hover {
            background: var(--frosted-bg);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-on-primary);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface);
            padding: 24px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 16px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-primary {
            background: var(--gradient-primary);
            color: var(--text-on-primary);
        }

        .icon-accent {
            background: var(--gradient-accent);
            color: var(--primary);
        }

        .icon-secondary {
            background: var(--gradient-secondary);
            color: var(--text-on-primary);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: var(--success);
        }

        /* History Table */
        .history-section {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 32px;
        }

        .section-header {
            padding: 24px;
            border-bottom: 1px solid var(--frosted-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .filters {
            display: flex;
            gap: 12px;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: var(--radius);
            border: 1px solid var(--frosted-border);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover {
            border-color: var(--accent);
            color: var(--primary);
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 24px;
            text-align: left;
            border-bottom: 1px solid var(--frosted-border);
        }

        th {
            background: var(--frosted-bg);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: var(--frosted-bg);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-on-primary);
            font-weight: 500;
        }

        .template-badge {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 500;
        }

        .badge-modern {
            background: var(--accent-light);
            color: var(--primary);
        }

        .badge-professional {
            background: var(--primary-light);
            color: var(--text-on-primary);
        }

        .badge-creative {
            background: var(--secondary-light);
            color: var(--text-on-primary);
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 500;
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .status-draft {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .action-btn {
            padding: 8px;
            border-radius: var(--radius);
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--frosted-bg);
            color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }
            
            .logo-text, .nav-text {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: 16px;
            }
            
            .nav-icon {
                margin-right: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .user-menu {
                width: 100%;
                justify-content: space-between;
            }
            
            .filters {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon"><i class="fas fa-file-alt"></i></div>
            <div class="logo-text">ResumeCraft</div>
        </div>
        
             <a href="../admin/dashboard.php" class="nav-link active">
            <div class="nav-icon"><i class="fas fa-home"></i></div>
            <div class="nav-text">Dashboard</div>
        </a>
        
        <a href="../admin/history.php" class="nav-link">
            <div class="nav-icon"><i class="fas fa-history"></i></div>
            <div class="nav-text">Resume History</div>
        </a>
        
        <a href="../admin/users.php" class="nav-link">
            <div class="nav-icon"><i class="fas fa-users"></i></div>
            <div class="nav-text">Users</div>
        </a>
        
        <a href="../admin/settings.php" class="nav-link ">
            <div class="nav-icon"><i class="fas fa-cog"></i></div>
            <div class="nav-text">Settings</div>
        </a>
        
        <a href="../admin/logout.php" class="nav-link" style="margin-top: auto;">
            <div class="nav-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="nav-text">Logout</div>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="header">
            <h1 class="page-title">Resume Creation History</h1>
            <div class="user-menu">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search resumes...">
                </div>
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div>Admin User</div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Resumes</div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo number_format($total_resumes); ?></div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>Active resumes in system</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Active Users</div>
                    <div class="stat-icon icon-accent">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo number_format($active_users); ?></div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>Users with resumes</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Templates Used</div>
                    <div class="stat-icon icon-secondary">
                        <i class="fas fa-palette"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo number_format($templates_used); ?></div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>Different templates</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Completion Rate</div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $completion_rate; ?>%</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>Complete profiles</span>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="history-section">
            <div class="section-header">
                <h2 class="section-title">Recent Resume Creations</h2>
                
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Template</th>
                            <th>Created</th>
                            <th>Field</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_history as $history): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar"><?php echo getInitials($history['full_name']); ?></div>
                                    <div>
                                        <div><?php echo htmlspecialchars($history['full_name']); ?></div>
                                        <div style="font-size: 12px; color: var(--text-secondary);"><?php echo htmlspecialchars($history['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="template-badge <?php echo getTemplateBadgeClass($history['template']); ?>">
                                    <?php echo formatTemplateName($history['template']); ?>
                                </div>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($history['created_at'])); ?></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $history['professional_field'])); ?></td>
                            <td>
                                <div class="status status-<?php echo strtolower($history['status']); ?>">
                                    <i class="fas fa-<?php echo $history['status'] == 'Completed' ? 'check-circle' : 'pencil-alt'; ?>"></i>
                                    <span><?php echo $history['status']; ?></span>
                                </div>
                            </td>
                           
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($recent_history)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                                No resume history found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Simple JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event to nav items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Simulate loading data
            const statsCards = document.querySelectorAll('.stat-card');
            statsCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'translateY(-5px)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(0)';
                    }, 300);
                });
            });
        });
    </script>
</body>
</html>