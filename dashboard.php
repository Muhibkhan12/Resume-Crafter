<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_email = $_SESSION['email'] ?? '';
if (!$user_email) {
    die("⚠ Please log in to view your dashboard.");
}

$resume_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;
$selected_template = $_GET['template'] ?? 'template1';

// ✅ Insert into history only when action=save
if (isset($_GET['action']) && $resume_id > 0) {
    $check = mysqli_query($conn, "SELECT id FROM resumes WHERE id=$resume_id AND email='$user_email'");
    if (mysqli_num_rows($check) > 0) {
        $sql = "INSERT INTO history (resume_id, template) VALUES ($resume_id, '$selected_template')";
        mysqli_query($conn, $sql);
    }
}

// ✅ Fetch dashboard stats
$stats_sql = "
    SELECT 
        COUNT(DISTINCT r.id) as total_resumes,
        COUNT(h.id) as total_saves,
        MAX(h.created_at) as last_activity
    FROM resumes r
    LEFT JOIN history h ON r.id = h.resume_id
    WHERE r.email = '$user_email'
";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

// ✅ Fetch recent history for dashboard
$sql_history = "
    SELECT h.*, r.full_name 
    FROM history h
    JOIN resumes r ON h.resume_id = r.id
    WHERE r.email = '$user_email'
    ORDER BY h.created_at DESC
    LIMIT 6
";
$result = mysqli_query($conn, $sql_history);

// ✅ Template info
function getTemplateInfo($template)
{
    $templates = [
        'template1' => ['name' => 'Modern Professional', 'image' => 'template1-preview.jpg', 'color' => '#29353C'],
        'template2' => ['name' => 'Creative Designer', 'image' => 'template2-preview.jpg', 'color' => '#44576D'],
        'template3' => ['name' => 'Minimal Clean', 'image' => 'template3-preview.jpg', 'color' => '#768A96'],
        'template4' => ['name' => 'Executive Style', 'image' => 'template4-preview.jpg', 'color' => '#1C252B'],
        'template5' => ['name' => 'Modern Compact', 'image' => 'template5-preview.jpg', 'color' => '#5E717D'],
        'template6' => ['name' => 'Academic Scholar', 'image' => 'template6-preview.jpg', 'color' => '#9AA9B3'],
        'template7' => ['name' => 'Tech Innovator', 'image' => 'template7-preview.jpg', 'color' => '#AAC7D8'],
        'template8' => ['name' => 'Artistic Portfolio', 'image' => 'template8-preview.jpg', 'color' => '#C4DAE8'],
        'template9' => ['name' => 'Corporate Executive', 'image' => 'template9-preview.jpg', 'color' => '#8FB4CB'],
        'template10' => ['name' => 'Minimalist Elegance', 'image' => 'template10-preview.jpg', 'color' => '#DFEBF6'],
        'template11' => ['name' => 'Creative Freelancer', 'image' => 'template11-preview.jpg', 'color' => '#1F2937'],
        'template12' => ['name' => 'Modern Developer', 'image' => 'template12-preview.jpg', 'color' => '#10B981'],
        'template13' => ['name' => 'Professional Manager', 'image' => 'template13-preview.jpg', 'color' => '#F59E0B'],
        'template14' => ['name' => 'Creative Marketer', 'image' => 'template14-preview.jpg', 'color' => '#EF4444'],
        'template15' => ['name' => 'Modern Educator', 'image' => 'template15-preview.jpg', 'color' => '#3B82F6'],
    ];
    return $templates[$template] ?? ['name' => 'Unknown Template', 'image' => 'default.jpg', 'color' => '#6c757d'];
}

// Check if dark mode is preferred
$is_dark_mode = false;
if (isset($_COOKIE['darkMode'])) {
    $is_dark_mode = $_COOKIE['darkMode'] === 'true';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ResumeBuilder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Color Palette */
            --primary: #29353C;
            --primary-light: #44576D;
            --primary-dark: #1C252B;
            --secondary: #768A96;
            --secondary-light: #9AA9B3;
            --secondary-dark: #5E717D;
            --accent: #AAC7D8;
            --accent-light: #C4DAE8;
            --accent-dark: #8FB4CB;

            /* Backgrounds */
            --background-light: #DFEBF6;
            --background-dark: #111827;
            --surface: #FFFFFF;
            --surface-dark: #1F2937;

            /* Text Colors */
            --text-primary: #1F2937;
            --text-secondary: #5E717D;
            --text-light: #FFFFFF;

            /* Status Colors */
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
            --info: #3B82F6;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-card: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            --gradient-stats: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);

            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.15);

            /* Fonts */
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;

            /* Transitions */
            --transition: all 0.3s ease;
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);

            /* Border Radius */
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        .dark-mode {
            --background-light: var(--background-dark);
            --surface: var(--surface-dark);
            --text-primary: var(--text-light);
            --text-secondary: var(--secondary-light);
            --gradient-card: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(31, 41, 55, 0.7) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background-light);
            color: var(--text-primary);
            font-family: var(--font-primary);
            transition: var(--transition);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: var(--gradient-primary);
            padding: 2rem 0;
            transform: translateX(0);
            transition: var(--transition);
            z-index: 1000;
            box-shadow: var(--shadow-lg);
        }

        .sidebar.collapsed {
            transform: translateX(-280px);
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-logo {
            color: var(--text-light);
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo i {
            color: var(--accent-light);
            font-size: 1.8rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav-item {
            margin: 0.5rem 1rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: var(--radius);
            transition: var(--transition);
            font-weight: 500;
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: var(--text-light);
            transform: translateX(5px);
        }

        .sidebar-nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: var(--transition);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--surface);
            padding: 1.5rem 2rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 1rem;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            background: var(--background-light);
            color: var(--text-primary);
        }

        .top-bar-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--text-primary);
            font-family: var(--font-heading);
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--gradient-stats);
            border-radius: var(--radius-xl);
            color: var(--primary-dark);
            font-weight: 500;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 2rem;
        }

        .welcome-section {
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-family: var(--font-heading);
        }

        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-stats);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--text-light);
        }

        .stat-card-icon.primary {
            background: var(--primary);
        }

        .stat-card-icon.success {
            background: var(--success);
        }

        .stat-card-icon.warning {
            background: var(--warning);
        }

        .stat-card-icon.info {
            background: var(--info);
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .stat-card-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .quick-actions-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            padding: 1.5rem 1rem;
            background: var(--gradient-card);
            border: 2px solid transparent;
            border-radius: var(--radius);
            text-decoration: none;
            transition: var(--transition);
            color: var(--text-primary);
        }

        .quick-action-btn:hover {
            transform: translateY(-3px);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: var(--shadow);
        }

        .quick-action-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            background: var(--gradient-stats);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--primary-dark);
        }

        .quick-action-text {
            font-weight: 500;
            text-align: center;
        }

        /* Recent Activity */
        .recent-section {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
        }

        .recent-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .recent-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .recent-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gradient-card);
            border-radius: var(--radius);
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .recent-item:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .recent-item-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--gradient-stats);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            flex-shrink: 0;
        }

        .recent-item-content {
            flex: 1;
        }

        .recent-item-title {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .recent-item-meta {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .recent-item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm-action {
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn-primary-sm {
            background: var(--primary);
            color: var(--text-light);
            border: none;
        }

        .btn-primary-sm:hover {
            background: var(--primary-dark);
            color: var(--text-light);
            transform: translateY(-1px);
        }

        .btn-outline-sm {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline-sm:hover {
            background: var(--primary);
            color: var(--text-light);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .empty-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .empty-text {
            margin-bottom: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-280px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 1rem;
            }

            .dashboard-content {
                padding: 1rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .recent-grid {
                grid-template-columns: 1fr;
            }

            .user-profile {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
            }
        }

        @media (max-width: 480px) {
            .recent-item {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .recent-item-actions {
                justify-content: center;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animation keyframes */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-content>* {
            animation: slideIn 0.6s ease-out;
            animation-fill-mode: backwards;
        }

        .dashboard-content>*:nth-child(1) {
            animation-delay: 0.1s;
        }

        .dashboard-content>*:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dashboard-content>*:nth-child(3) {
            animation-delay: 0.3s;
        }

        .dashboard-content>*:nth-child(4) {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body class="<?php echo $is_dark_mode ? 'dark-mode' : ''; ?>">
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <a href="index.php" style="text-decoration:none;">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-file-alt"></i>
                    Geeko CV
                </div>
            </div>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="dashboard.php" class="sidebar-nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="form.php" class="sidebar-nav-link">
                    <i class="fas fa-plus"></i>
                    Create Resume
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="index.php" class="sidebar-nav-link">
                    <i class="fas fa-th-large"></i>
                    Back To Website
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="dashboard.php" class="sidebar-nav-link">
                    <i class="fas fa-history"></i>
                    History
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="logout.php" class="sidebar-nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="top-bar-title">Dashboard</h1>
            </div>
            <div class="top-bar-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user_email, 0, 1)); ?>
                    </div>
                    <span><?php echo explode('@', $user_email)[0]; ?></span>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2 class="welcome-title">Welcome back!</h2>
                <p class="welcome-subtitle">Here's an overview of your resume building activity</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo $stats['total_resumes'] ?? 0; ?></div>
                            <div class="stat-card-label">Total Resumes</div>
                        </div>
                        <div class="stat-card-icon primary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value"><?php echo $stats['total_saves'] ?? 0; ?></div>
                            <div class="stat-card-label">Templates Saved</div>
                        </div>
                        <div class="stat-card-icon success">
                            <i class="fas fa-save"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value">15</div>
                            <div class="stat-card-label">Available Templates</div>
                        </div>
                        <div class="stat-card-icon warning">
                            <i class="fas fa-th-large"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-card-value">
                                <?php
                                if ($stats['last_activity']) {
                                    echo date('M j', strtotime($stats['last_activity']));
                                } else {
                                    echo 'Never';
                                }
                                ?>
                            </div>
                            <div class="stat-card-label">Last Activity</div>
                        </div>
                        <div class="stat-card-icon info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3 class="quick-actions-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
                <div class="quick-actions-grid">
                    <a href="form.php" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="quick-action-text">Create New Resume</div>
                    </a>

                    <a href="templates.php" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-th-large"></i>
                        </div>
                        <div class="quick-action-text">Browse Templates</div>
                    </a>

                    <a href="profile.php" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="quick-action-text">Edit Profile</div>
                    </a>

                    <a href="settings.php" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="quick-action-text">Export Resumes</div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-section">
                <div class="recent-title">
                    <span>
                        <i class="fas fa-history"></i>
                        Recent Activity
                    </span>
                    <a href="history.php" class="btn-outline-sm">View All</a>
                </div>

                <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                    <div class="recent-grid">
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            $info = getTemplateInfo($row['template']);
                        ?>
                            <div class="recent-item">
                                <div class="recent-item-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="recent-item-content">
                                    <div class="recent-item-title"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                    <div class="recent-item-meta">
                                        <?php echo $info['name']; ?> • <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                    </div>
                                </div>
                                <div class="recent-item-actions">
                                    <a href="preview.php?resume_id=<?php echo $row['resume_id']; ?>&template=<?php echo $row['template']; ?>" class="btn-sm-action btn-primary-sm">
                                        <i class="fas fa-eye"></i> Preview
                                    </a>
                                    <a href="download.php?resume_id=<?php echo $row['resume_id']; ?>&template=<?php echo $row['template']; ?>" class="btn-sm-action btn-outline-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <a href="deleteHistory.php?resume_id=<?php echo $row['resume_id']; ?>&template=<?php echo $row['template']; ?>" class="btn-sm-action btn-outline-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="far fa-folder-open"></i>
                        </div>
                        <h4 class="empty-title">No recent activity</h4>
                        <p class="empty-text">You haven't created any resumes yet. Start building your first professional resume!</p>
                        <a href="form.php" class="btn-primary-sm">
                            <i class="fas fa-plus"></i> Create Your First Resume
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('show');
            }
        });

        // Theme toggle functionality (if you want to add it back)
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('change', function() {
                document.body.classList.toggle('dark-mode');
                document.cookie = `darkMode=${this.checked}; path=/; max-age=${60*60*24*30}`;
            });
        }

        // Add smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add loading states for better UX (optional enhancement)
        document.querySelectorAll('.btn-sm-action, .quick-action-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add a subtle loading indication
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 300);
            });
        });

        // Initialize tooltips if Bootstrap is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Any additional initialization can go here
            console.log('Dashboard loaded successfully');
        });
    </script>
</body>

</html>