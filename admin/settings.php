<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResumeCraft - Settings</title>
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

        /* Settings Styles */
        .settings-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .settings-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 24px;
            transition: var(--transition);
        }

        .settings-card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--frosted-border);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-on-primary);
            font-size: 20px;
            margin-right: 16px;
        }

        .card-title {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--frosted-border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(170, 199, 216, 0.2);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--frosted-border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text-primary);
            transition: var(--transition);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%235E717D' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(170, 199, 216, 0.2);
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--frosted-border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text-primary);
            transition: var(--transition);
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(170, 199, 216, 0.2);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .form-check-input {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .form-check-label {
            font-weight: 500;
            color: var(--text-primary);
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--radius);
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: var(--text-on-primary);
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--gradient-secondary);
            color: var(--text-on-primary);
        }

        .btn-secondary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
            margin-right: 12px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--secondary-light);
            transition: .4s;
            border-radius: var(--radius-full);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--success);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        .color-picker {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .color-option {
            width: 40px;
            height: 40px;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.active {
            border-color: var(--primary);
            transform: scale(1.1);
        }

        .theme-primary {
            background: var(--primary);
        }

        .theme-secondary {
            background: var(--secondary);
        }

        .theme-accent {
            background: var(--accent);
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

            .settings-container {
                grid-template-columns: 1fr;
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
            
            .settings-container {
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
        
        <a href="../admin/history.php" class="nav-link">
            <div class="nav-icon"><i class="fas fa-history"></i></div>
            <div class="nav-text">Resume History</div>
        </a>
        
        <a href="../admin/users.php" class="nav-link">
            <div class="nav-icon"><i class="fas fa-users"></i></div>
            <div class="nav-text">Users</div>
        </a>
        
        <a href="../admin/settings.php" class="nav-link active">
            <div class="nav-icon"><i class="fas fa-cog"></i></div>
            <div class="nav-text">Settings</div>
        </a>
        
        <a href="../admin/logout.php" class="nav-link" style="margin-top: auto;">
            <div class="nav-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="nav-text">Logout</div>
        </a>
    </a>
        
        
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="header">
            <h1 class="page-title">Settings</h1>
            <div class="user-menu">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search settings...">
                </div>
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div>Admin User</div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="settings-container">
            <!-- General Settings Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h2 class="card-title">General Settings</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Application Name</label>
                    <input type="text" class="form-input" value="ResumeCraft">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Admin Email</label>
                    <input type="email" class="form-input" value="admin@resumecraft.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Timezone</label>
                    <select class="form-select">
                        <option>(UTC-05:00) Eastern Time</option>
                        <option>(UTC-06:00) Central Time</option>
                        <option>(UTC-07:00) Mountain Time</option>
                        <option>(UTC-08:00) Pacific Time</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Date Format</label>
                    <select class="form-select">
                        <option>MM/DD/YYYY</option>
                        <option>DD/MM/YYYY</option>
                        <option>YYYY-MM-DD</option>
                    </select>
                </div>
                
                <button class="btn btn-primary">Save General Settings</button>
            </div>

            <!-- Appearance Settings Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h2 class="card-title">Appearance</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Theme Color</label>
                    <div class="color-picker">
                        <div class="color-option theme-primary active"></div>
                        <div class="color-option theme-secondary"></div>
                        <div class="color-option theme-accent"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Sidebar Style</label>
                    <select class="form-select">
                        <option>Expanded</option>
                        <option>Collapsed</option>
                        <option>Floating</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Dashboard Layout</label>
                    <select class="form-select">
                        <option>Grid</option>
                        <option>List</option>
                        <option>Compact</option>
                    </select>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="darkMode" checked>
                    <label class="form-check-label" for="darkMode">Enable Dark Mode</label>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="animations" checked>
                    <label class="form-check-label" for="animations">Enable Animations</label>
                </div>
                
                <button class="btn btn-primary">Save Appearance Settings</button>
            </div>

            <!-- Notification Settings Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h2 class="card-title">Notifications</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Notifications</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="emailNotifs" checked>
                        <label class="form-check-label" for="emailNotifs">Enable email notifications</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Notification Types</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="newUser" checked>
                        <label class="form-check-label" for="newUser">New user registrations</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="resumeCreated" checked>
                        <label class="form-check-label" for="resumeCreated">Resume creations</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="systemAlerts" checked>
                        <label class="form-check-label" for="systemAlerts">System alerts</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Push Notifications</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pushNotifs">
                        <label class="form-check-label" for="pushNotifs">Enable push notifications</label>
                    </div>
                </div>
                
                <button class="btn btn-primary">Save Notification Settings</button>
            </div>

            <!-- Security Settings Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="card-title">Security</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Two-Factor Authentication</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="twoFactor">
                        <label class="form-check-label" for="twoFactor">Enable two-factor authentication</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Session Timeout</label>
                    <select class="form-select">
                        <option>15 minutes</option>
                        <option>30 minutes</option>
                        <option>1 hour</option>
                        <option>2 hours</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password Policy</label>
                    <select class="form-select">
                        <option>Standard (8+ characters)</option>
                        <option>Strong (12+ characters with complexity)</option>
                        <option>Very Strong (16+ characters with complexity)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">IP Whitelisting</label>
                    <textarea class="form-textarea" placeholder="Enter allowed IP addresses (one per line)"></textarea>
                </div>
                
                <button class="btn btn-primary">Save Security Settings</button>
            </div>

            <!-- Backup Settings Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h2 class="card-title">Backup & Restore</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Automatic Backups</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="autoBackup" checked>
                        <label class="form-check-label" for="autoBackup">Enable automatic backups</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Backup Frequency</label>
                    <select class="form-select">
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Backup Retention</label>
                    <select class="form-select">
                        <option>7 days</option>
                        <option>30 days</option>
                        <option>90 days</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Last Backup</label>
                    <p>August 26, 2023 14:30</p>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button class="btn btn-primary">Backup Now</button>
                    <button class="btn btn-secondary">Restore</button>
                </div>
            </div>

            <!-- System Info Card -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h2 class="card-title">System Information</h2>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Version</label>
                    <p>ResumeCraft v2.1.0</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Server</label>
                    <p>Apache/2.4.52 (Unix) - PHP 8.2.12</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Database</label>
                    <p>MySQL 10.4.32-MariaDB - 15.2 MB</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Last Update</label>
                    <p>August 20, 2023</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">System Status</label>
                    <p><span style="color: var(--success);">●</span> All systems operational</p>
                </div>
                
                <button class="btn btn-secondary">Check for Updates</button>
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
            
            // Color picker functionality
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    colorOptions.forEach(o => o.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Save buttons functionality
            const saveButtons = document.querySelectorAll('.btn-primary');
            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.settings-card');
                    const cardTitle = card.querySelector('.card-title').textContent;
                    
                    // Show a temporary success message
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Saved!';
                    this.style.background = 'var(--success)';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = '';
                    }, 2000);
                    
                    console.log(`${cardTitle} saved successfully`);
                });
            });
        });
    </script>
</body>
</html>