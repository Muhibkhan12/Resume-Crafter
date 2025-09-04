<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "resume"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from resumes table
$sql = "SELECT id, full_name, email, phone, professional_field, created_at FROM resumes ORDER BY created_at DESC";
$result = $conn->query($sql);

// Format professional field for display
function formatProfessionalField($field) {
    $field = str_replace('_', ' ', $field);
    return ucwords($field);
}

// Format date for display
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

// Get first letter for avatar
function getAvatarLetter($name) {
    return strtoupper(substr($name, 0, 1));
}

// Determine badge class based on field
function getBadgeClass($field) {
    if (stripos($field, 'design') !== false) {
        return 'badge-design';
    } elseif (stripos($field, 'developer') !== false) {
        return 'badge-development';
    } else {
        return 'badge-marketing';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResumeCraft - User Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #DFEBF6;
            color: #1F2937;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        :root {
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
            text-decoration: none;
            color: inherit;
        }

        .logo-icon {
            font-size: 28px;
            margin-right: 12px;
            color: var(--accent);
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
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
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-on-primary);
        }

        /* Layout Toggle */
        .layout-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            padding: 8px;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .layout-btn {
            padding: 8px 12px;
            border-radius: var(--radius);
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .layout-btn:hover {
            background: var(--frosted-bg);
            color: var(--primary);
        }

        .layout-btn.active {
            background: var(--primary);
            color: var(--text-on-primary);
        }

        /* User Table */
        .users-section {
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
            flex-wrap: wrap;
            gap: 16px;
        }

        .section-title {
            font-family: 'Space Grotesk', sans-serif;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-on-primary);
            font-weight: 500;
        }

        .field-badge {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 500;
        }

        .badge-design {
            background: var(--accent-light);
            color: var(--primary);
        }

        .badge-development {
            background: var(--primary-light);
            color: var(--text-on-primary);
        }

        .badge-marketing {
            background: var(--secondary-light);
            color: var(--text-on-primary);
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

        /* Grid Layout */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 24px;
        }

        .user-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 20px;
            transition: var(--transition);
        }

        .user-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--frosted-border);
        }

        .card-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-on-primary);
            font-weight: 600;
            font-size: 18px;
            margin-right: 12px;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body {
            margin-bottom: 16px;
        }

        .card-detail {
            display: flex;
            margin-bottom: 8px;
        }

        .detail-label {
            font-weight: 500;
            color: var(--text-secondary);
            width: 120px;
            flex-shrink: 0;
        }

        .detail-value {
            color: var(--text-primary);
            word-break: break-word;
        }

        .no-results {
            padding: 40px;
            text-align: center;
            color: var(--text-secondary);
            grid-column: 1 / -1;
        }

        .no-results i {
            font-size: 48px;
            margin-bottom: 16px;
            color: var(--secondary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }
            
            .logo-text, .nav-text {
                display: none;
            }
            
            .nav-link {
                justify-content: center;
                padding: 16px;
            }
            
            .nav-icon {
                margin-right: 0;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-menu {
                width: 100%;
                justify-content: space-between;
            }
            
            .layout-toggle {
                margin-left: 0;
            }
            
            .filters {
                flex-wrap: wrap;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .grid-container {
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
        
        <a href="../admin/users.php" class="nav-link active">
            <div class="nav-icon"><i class="fas fa-users"></i></div>
            <div class="nav-text">Users</div>
        </a>
        
        <a href="../admin/settings.php" class="nav-link ">
            <div class="nav-icon"><i class="fas fa-cog"></i></div>
            <div class="nav-text">Settings</div>
        </a>
        
        <a href="../admin/logout.php" class="nav-link " style="margin-top: auto;">
            <div class="nav-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="nav-text">Logout</div>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="header">
            <h1 class="page-title">User Management</h1>
            <div class="user-menu">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users..." oninput="filterUsers()">
                </div>
                
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div>Admin User</div>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="users-section">
            <div class="section-header">
                <h2 class="section-title">All Users</h2>
                <div class="layout-toggle">
                    <button class="layout-btn active" id="listLayout">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="layout-btn" id="gridLayout">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
            </div>
            
            <!-- Table View (Default) -->
            <div class="table-container" id="tableView">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Professional Field</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar"><?php echo getAvatarLetter($row['full_name']); ?></div>
                                            <div><?php echo htmlspecialchars($row['full_name']); ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td>
                                        <div class="field-badge <?php echo getBadgeClass($row['professional_field']); ?>">
                                            <?php echo formatProfessionalField($row['professional_field']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo formatDate($row['created_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="no-results">
                                    <i class="fas fa-users"></i>
                                    <h3>No users found</h3>
                                    <p>No resume data available in the database</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Grid View (Hidden by default) -->
            <div class="grid-container" id="gridView" style="display: none;">
                <?php if ($result->num_rows > 0): ?>
                    <?php 
                    // Reset pointer to beginning for grid view
                    $result->data_seek(0); 
                    while($row = $result->fetch_assoc()): ?>
                        <div class="user-card">
                            <div class="card-header">
                                <div class="card-avatar"><?php echo getAvatarLetter($row['full_name']); ?></div>
                                <div class="card-title"><?php echo htmlspecialchars($row['full_name']); ?></div>
                            </div>
                            <div class="card-body">
                                <div class="card-detail">
                                    <span class="detail-label">ID:</span>
                                    <span class="detail-value">#<?php echo $row['id']; ?></span>
                                </div>
                                <div class="card-detail">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($row['email']); ?></span>
                                </div>
                                <div class="card-detail">
                                    <span class="detail-label">Phone:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($row['phone']); ?></span>
                                </div>
                                <div class="card-detail">
                                    <span class="detail-label">Field:</span>
                                    <span class="detail-value">
                                        <span class="field-badge <?php echo getBadgeClass($row['professional_field']); ?>">
                                            <?php echo formatProfessionalField($row['professional_field']); ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="card-detail">
                                    <span class="detail-label">Created:</span>
                                    <span class="detail-value"><?php echo formatDate($row['created_at']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-users"></i>
                        <h3>No users found</h3>
                        <p>No resume data available in the database</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Layout Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const listLayoutBtn = document.getElementById('listLayout');
            const gridLayoutBtn = document.getElementById('gridLayout');
            const tableView = document.getElementById('tableView');
            const gridView = document.getElementById('gridView');
            
            // Set initial layout from localStorage or default to list
            const savedLayout = localStorage.getItem('userLayout') || 'list';
            setLayout(savedLayout);
            
            // Add event listeners to layout buttons
            listLayoutBtn.addEventListener('click', () => setLayout('list'));
            gridLayoutBtn.addEventListener('click', () => setLayout('grid'));
            
            function setLayout(layout) {
                if (layout === 'list') {
                    tableView.style.display = 'block';
                    gridView.style.display = 'none';
                    listLayoutBtn.classList.add('active');
                    gridLayoutBtn.classList.remove('active');
                } else {
                    tableView.style.display = 'none';
                    gridView.style.display = 'grid';
                    listLayoutBtn.classList.remove('active');
                    gridLayoutBtn.classList.add('active');
                }
                localStorage.setItem('userLayout', layout);
            }
            
            // Search functionality
            function filterUsers() {
                const searchInput = document.getElementById('searchInput');
                const searchTerm = searchInput.value.toLowerCase();
                
                // Filter table view
                const tableRows = document.querySelectorAll('#usersTableBody tr');
                tableRows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const phone = row.cells[3].textContent.toLowerCase();
                    const field = row.cells[4].textContent.toLowerCase();
                    const created = row.cells[5].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm) || 
                        phone.includes(searchTerm) || field.includes(searchTerm) || 
                        created.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Filter grid view
                const gridCards = document.querySelectorAll('.user-card');
                gridCards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
            
            // Make filterUsers function globally available
            window.filterUsers = filterUsers;
        });
    </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>