<?php
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

// Fetch all resumes with their latest template information
$stmt = $pdo->query("
    SELECT 
        r.*,
        h.template,
        h.created_at as template_created,
        CASE 
            WHEN r.full_name != '' AND r.email != '' AND r.phone != '' AND r.professional_summary != '' THEN 'Completed'
            ELSE 'Draft'
        END as status,
        COUNT(DISTINCT h.id) as template_count
    FROM resumes r
    LEFT JOIN history h ON r.id = h.resume_id
    GROUP BY r.id
    ORDER BY r.created_at DESC
");
$resumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total statistics
$total_resumes = count($resumes);
$completed_resumes = count(array_filter($resumes, function($r) { return $r['status'] == 'Completed'; }));
$draft_resumes = $total_resumes - $completed_resumes;

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

// Function to format professional field
function formatProfessionalField($field) {
    return ucwords(str_replace('_', ' ', $field));
}

// Function to get random profile color
function getProfileColor($index) {
    $colors = [
        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
        'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
        'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
        'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
        'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
        'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
        'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
    ];
    return $colors[$index % count($colors)];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume History - ResumeCraft</title>
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

        /* Stats Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface);
            padding: 20px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Filter Section */
        .filter-section {
            background: var(--surface);
            padding: 20px 24px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .filter-controls {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
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

        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--accent);
            color: var(--primary);
            background: var(--frosted-bg);
        }

        .view-toggle {
            display: flex;
            gap: 8px;
        }

        .toggle-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius);
            border: 1px solid var(--frosted-border);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-btn:hover,
        .toggle-btn.active {
            border-color: var(--accent);
            background: var(--accent-light);
            color: var(--primary);
        }

        /* Resume Cards Grid */
        .resume-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .resume-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .resume-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid var(--frosted-border);
        }

        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 600;
            color: white;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .user-email {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .card-body {
            padding: 24px;
        }

        .field-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .field-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            background: var(--gradient-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .field-text {
            font-size: 16px;
            font-weight: 500;
            color: var(--primary);
        }

        .resume-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--primary);
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .status-draft {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .card-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            background: transparent;
            border: 1px solid var(--frosted-border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            border-color: var(--accent);
            background: var(--frosted-bg);
            color: var(--primary);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--text-secondary);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-message {
            font-size: 16px;
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
            
            .resume-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .user-menu {
                width: 100%;
                justify-content: space-between;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .resume-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-overview {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-overview {
                grid-template-columns: 1fr;
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
        
             <a href="../admin/dashboard.php" class="nav-link">
            <div class="nav-icon"><i class="fas fa-home"></i></div>
            <div class="nav-text">Dashboard</div>
        </a>
        
        <a href="../admin/history.php" class="nav-link active">
            <div class="nav-icon"><i class="fas fa-history"></i></div>
            <div class="nav-text">Resume History</div>
        </a>
        
        <a href="../admin/users.php" class="nav-link ">
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
            <h1 class="page-title">Resume History</h1>
            <div class="user-menu">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search resumes..." id="searchInput">
                </div>
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div>Admin User</div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_resumes; ?></div>
                <div class="stat-label">Total Resumes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $completed_resumes; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $draft_resumes; ?></div>
                <div class="stat-label">Drafts</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-controls">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-list"></i>
                    <span>All Resumes</span>
                </button>
                <button class="filter-btn" data-filter="completed">
                    <i class="fas fa-check-circle"></i>
                    <span>Completed</span>
                </button>
                <button class="filter-btn" data-filter="draft">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Drafts</span>
                </button>
                <button class="filter-btn" data-filter="recent">
                    <i class="fas fa-clock"></i>
                    <span>Recent</span>
                </button>
            </div>
            <div class="view-toggle">
                <button class="toggle-btn active" data-view="grid">
                    <i class="fas fa-th"></i>
                </button>
                <button class="toggle-btn" data-view="list">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <!-- Resume Cards Grid -->
        <div class="resume-grid" id="resumeGrid">
            <?php if (empty($resumes)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="empty-title">No Resumes Found</div>
                    <div class="empty-message">No resumes have been created yet.</div>
                </div>
            <?php else: ?>
                <?php foreach ($resumes as $index => $resume): ?>
                    <div class="resume-card" data-status="<?php echo strtolower($resume['status']); ?>" data-created="<?php echo $resume['created_at']; ?>">
                        <div class="card-header">
                            <?php if (!empty($resume['profile_image'])): ?>
                                <img src="<?php echo htmlspecialchars($resume['profile_image']); ?>" alt="Profile" class="profile-image">
                            <?php else: ?>
                                <div class="profile-image" style="background: <?php echo getProfileColor($index); ?>">
                                    <?php echo getInitials($resume['full_name']); ?>
                                </div>
                            <?php endif; ?>
                            <div class="user-info">
                                <div class="user-name"><?php echo htmlspecialchars($resume['full_name']); ?></div>
                                <div class="user-email"><?php echo htmlspecialchars($resume['email']); ?></div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="field-info">
                                <div class="field-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="field-text"><?php echo formatProfessionalField($resume['professional_field']); ?></div>
                            </div>
                            
                            <div class="resume-details">
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value"><?php echo htmlspecialchars($resume['phone'] ?: 'Not provided'); ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Created</div>
                                    <div class="detail-value"><?php echo date('M d, Y', strtotime($resume['created_at'])); ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Templates Used</div>
                                    <div class="detail-value"><?php echo $resume['template_count'] ?: 0; ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Last Updated</div>
                                    <div class="detail-value"><?php echo date('M d, Y', strtotime($resume['updated_at'])); ?></div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="status-badge status-<?php echo strtolower($resume['status']); ?>">
                                    <i class="fas fa-<?php echo $resume['status'] == 'Completed' ? 'check-circle' : 'pencil-alt'; ?>"></i>
                                    <span><?php echo $resume['status']; ?></span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation functionality
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Filter functionality
            const filterBtns = document.querySelectorAll('.filter-btn');
            const resumeCards = document.querySelectorAll('.resume-card');
            
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.dataset.filter;
                    
                    resumeCards.forEach(card => {
                        const status = card.dataset.status;
                        const created = new Date(card.dataset.created);
                        const weekAgo = new Date();
                        weekAgo.setDate(weekAgo.getDate() - 7);
                        
                        let show = false;
                        
                        switch(filter) {
                            case 'all':
                                show = true;
                                break;
                            case 'completed':
                                show = status === 'completed';
                                break;
                            case 'draft':
                                show = status === 'draft';
                                break;
                            case 'recent':
                                show = created >= weekAgo;
                                break;
                        }
                        
                        card.style.display = show ? 'block' : 'none';
                    });
                });
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                resumeCards.forEach(card => {
                    const name = card.querySelector('.user-name').textContent.toLowerCase();
                    const email = card.querySelector('.user-email').textContent.toLowerCase();
                    const field = card.querySelector('.field-text').textContent.toLowerCase();
                    
                    const matches = name.includes(searchTerm) || 
                                  email.includes(searchTerm) || 
                                  field.includes(searchTerm);
                    
                    card.style.display = matches ? 'block' : 'none';
                });
            });

            // View toggle functionality
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            const resumeGrid = document.getElementById('resumeGrid');
            
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    toggleBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const view = this.dataset.view;
                    
                    if (view === 'list') {
                        resumeGrid.style.gridTemplateColumns = '1fr';
                        resumeCards.forEach(card => {
                            card.style.maxWidth = 'none';
                        });
                    } else {
                        resumeGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
                        resumeCards.forEach(card => {
                            card.style.maxWidth = '';
                        });
                    }
                });
            });

            // Card hover effects
            resumeCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Action buttons functionality
            document.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    const action = this.querySelector('i').classList.contains('fa-eye') ? 'view' :
                                 this.querySelector('i').classList.contains('fa-edit') ? 'edit' :
                                 this.querySelector('i').classList.contains('fa-download') ? 'download' : 'delete';
                    
                    const card = this.closest('.resume-card');
                    const userName = card.querySelector('.user-name').textContent;
                    
                    switch(action) {
                        case 'view':
                            console.log('Viewing resume for:', userName);
                            break;
                        case 'edit':
                            console.log('Editing resume for:', userName);
                            break;
                        case 'download':
                            console.log('Downloading resume for:', userName);
                            break;
                        case 'delete':
                            if (confirm(`Are you sure you want to delete ${userName}'s resume?`)) {
                                console.log('Deleting resume for:', userName);
                            }
                            break;
                    }
                });
            });
        });
    </script>
</body>
</html>