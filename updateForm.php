<?php
// Database connection
$servername = "127.0.0.1";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "resume";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get resume ID from URL parameter
$resume_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;

// Fetch resume data
$resume = [];
$education = [];
$experience = [];
$skills = [];
$languages = [];
$projects = [];
$achievements = [];
$references = [];

if ($resume_id > 0) {
    // Fetch basic resume info
    $sql = "SELECT * FROM resumes WHERE id = $resume_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $resume = $result->fetch_assoc();
    }
    
    // Fetch education
    $sql = "SELECT * FROM education WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $education[$row['education_type']][] = $row;
    }
    
    // Fetch experience
    $sql = "SELECT * FROM experience WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $experience[] = $row;
    }
    
    // Fetch skills
    $sql = "SELECT * FROM skills WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $skills[] = $row['skill_name'];
    }
    
    // Fetch languages
    $sql = "SELECT * FROM languages WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $languages[] = $row;
    }
    
    // Fetch projects
    $sql = "SELECT * FROM projects WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    
    // Fetch achievements
    $sql = "SELECT * FROM achievements WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $achievements[] = $row['achievement_description'];
    }
    
    // Fetch references
    $sql = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $references[] = $row;
    }
}

// Debug output to check what data was fetched
error_log("Resume data: " . print_r($resume, true));
error_log("Education data: " . print_r($education, true));
error_log("Experience data: " . print_r($experience, true));
error_log("Skills data: " . print_r($skills, true));

$conn->close();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional Resume Builder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #008080;          /* Teal */
      --primary-dark: #006666;     /* Darker teal */
      --secondary: #00b4d8;        /* Light blue */
      --accent: #90e0ef;           /* Light teal */
      --success: #38b000;          /* Green */
      --warning: #ffaa00;          /* Amber */
      --danger: #e5383b;           /* Red */
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #94a3b8;
      --card-bg: rgba(255, 255, 255, 0.95);
      --form-bg: #f0f8ff;          /* Light blue background */
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #0d1b2a, #1b3a4b);
      color: #334155;
      line-height: 1.6;
      min-height: 100vh;
      padding: 20px;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .header {
      text-align: center;
      padding: 30px 0;
      margin-bottom: 30px;
    }
    
    .header h1 {
      color: white;
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .header p {
      color: var(--accent);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .app-container {
      background: var(--form-bg);
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      margin-bottom: 40px;
    }
    
    .form-progress {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      padding: 30px 40px;
      background: linear-gradient(to right, var(--primary), var(--primary-dark));
    }
    
    .progress-bar {
      position: absolute;
      top: 50%;
      left: 40px;
      right: 40px;
      height: 6px;
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-50%);
      z-index: 1;
      border-radius: 3px;
      overflow: hidden;
    }
    
    .progress-fill {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      background: white;
      width: 16.6%;
      border-radius: 3px;
      transition: width 0.5s ease;
    }
    
    .step-number {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: white;
      position: relative;
      z-index: 2;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 1.2rem;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .step-number.active {
      background: white;
      color: var(--primary);
      transform: scale(1.1);
      box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
    }
    
    .step-number.completed {
      background: var(--success);
      color: white;
    }
    
    .step-number i {
      font-size: 1.2rem;
    }
    
    .step {
      display: none;
      animation: fadeIn 0.4s ease-in-out;
      padding: 30px;
    }
    
    .step.active {
      display: block;
    }
    
    .step-content {
      background: var(--card-bg);
      border-radius: 15px;
      padding: 30px;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .step-content:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .step h3 {
      color: var(--primary-dark);
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--primary);
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .step h3 i {
      background: var(--primary);
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }
    
    .form-label {
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 8px;
    }
    
    .form-control, .form-select {
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      padding: 12px 15px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(0, 128, 128, 0.15);
    }
    
    .field-section {
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      background: white;
      border-left: 4px solid var(--primary);
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
    }
    
    .field-section strong {
      color: var(--primary-dark);
      display: block;
      margin-bottom: 15px;
      font-size: 1.1rem;
    }
    
    .skill-tag {
      display: inline-flex;
      align-items: center;
      background: var(--primary);
      color: white;
      padding: 6px 15px;
      margin: 0 8px 8px 0;
      border-radius: 20px;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }
    
    .skill-tag .btn-close {
      filter: invert(1);
      opacity: 0.8;
      margin-left: 8px;
      font-size: 0.7rem;
    }
    
    .skill-tag:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }
    
    .btn {
      border-radius: 10px;
      padding: 12px 25px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .btn-primary {
      background: var(--primary);
      border-color: var(--primary);
    }
    
    .btn-primary:hover {
      background: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 128, 128, 0.3);
    }
    
    .btn-secondary {
      background: #64748b;
      border-color: #64748b;
      color: white;
    }
    
    .btn-secondary:hover {
      background: #475569;
      transform: translateY(-3px);
      color: white;
    }
    
    .btn-success {
      background: var(--success);
      border-color: var(--success);
    }
    
    .btn-success:hover {
      background: #2e8b57;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.3);
    }
    
    .step-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    
    .toggle-section {
      background: rgba(0, 128, 128, 0.1);
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(13, 27, 42, 0.8);
      display: none;
      z-index: 9999;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(4px);
    }
    
    .loading-spinner {
      background: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .error-message, .success-message {
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      display: none;
      animation: fadeIn 0.4s;
    }
    
    .error-message {
      background: #fee2e2;
      color: #b91c1c;
      border-left: 4px solid var(--danger);
    }
    
    .success-message {
      background: #dcfce7;
      color: #166534;
      border-left: 4px solid var(--success);
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    .is-invalid {
      border-color: var(--danger) !important;
    }
    
    .is-invalid:focus {
      box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.25) !important;
    }
    
    .form-check-input:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    
    .input-group-text {
      background: var(--primary);
      color: white;
      border: none;
    }
    
    .add-item-btn {
      border-radius: 10px;
      padding: 8px 20px;
      font-size: 0.9rem;
      margin-top: 10px;
    }
    
    .remove-btn {
      background: rgba(239, 68, 68, 0.1) !important;
      color: var(--danger) !important;
      border: none !important;
      width: 34px;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50% !important;
      padding: 0;
    }
    
    .remove-btn:hover {
      background: rgba(239, 68, 68, 0.2) !important;
      transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
      .form-progress {
        padding: 20px 15px;
      }
      
      .step-number {
        width: 40px;
        height: 40px;
        font-size: 1rem;
      }
      
      .step {
        padding: 20px;
      }
      
      .step-content {
        padding: 20px;
      }
      
      .header h1 {
        font-size: 2.2rem;
      }
      
      .progress-bar {
        left: 15px;
        right: 15px;
      }
    }
    
    @media (max-width: 576px) {
      .step-number {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
      }
      
      .btn {
        padding: 10px 18px;
        font-size: 0.9rem;
      }
      
      .step-buttons {
        flex-direction: column;
        gap: 10px;
      }
      
      .step-buttons .btn {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1><i class="fas fa-file-alt me-2"></i>Update Professional Resume</h1>
      <p>Update your resume information</p>
    </div>

    <div class="app-container">
      <!-- Loading Overlay -->
      <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
          <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-3 fs-5">Updating your resume...</p>
        </div>
      </div>

      <!-- Error/Success Messages -->
      <div class="error-message" id="errorMessage"></div>
      <div class="success-message" id="successMessage"></div>

      <form id="cvForm" method="POST" action="submit.php" enctype="multipart/form-data">
        <input type="hidden" name="resume_id" value="<?php echo $resume_id; ?>">
        <input type="hidden" name="update" value="1">

        <!-- Progress Indicator -->
        <div class="form-progress">
          <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
          </div>
          <div class="step-number active" data-step="1"><i class="fas fa-user"></i></div>
          <div class="step-number" data-step="2"><i class="fas fa-graduation-cap"></i></div>
          <div class="step-number" data-step="3"><i class="fas fa-briefcase"></i></div>
          <div class="step-number" data-step="4"><i class="fas fa-lightbulb"></i></div>
          <div class="step-number" data-step="5"><i class="fas fa-plus-circle"></i></div>
          <div class="step-number" data-step="6"><i class="fas fa-check-circle"></i></div>
        </div>

        <!-- Step 1: Personal Info -->
        <div class="step step-1 active">
          <div class="step-content">
            <h3><i class="fas fa-user"></i> Personal Information</h3>
            <div class="mb-4">
              <label for="profile_image" class="form-label">Upload Profile Image</label>
              <div class="d-flex align-items-center">
                <div class="me-3">
                  <?php if (!empty($resume['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($resume['profile_image']); ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                  <?php else: ?>
                    <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                      <i class="fas fa-camera text-muted fs-4"></i>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                  <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label">Full Name *</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required 
                       value="<?php echo htmlspecialchars($resume['full_name'] ?? ''); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($resume['email'] ?? ''); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" class="form-control" id="phone" name="phone" required 
                       value="<?php echo htmlspecialchars($resume['phone'] ?? ''); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="linkedin" class="form-label">LinkedIn Profile</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                  <input type="url" class="form-control" id="linkedin" name="linkedin"
                         value="<?php echo htmlspecialchars($resume['linkedin'] ?? ''); ?>">
                </div>
              </div>
              <div class="col-12 mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($resume['address'] ?? ''); ?></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="website" class="form-label">Personal Website</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-globe"></i></span>
                  <input type="url" class="form-control" id="website" name="website"
                         value="<?php echo htmlspecialchars($resume['website'] ?? ''); ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="step-buttons">
            <div></div>
            <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right ms-2"></i></button>
          </div>
        </div>

        <!-- Step 2: Education -->
        <div class="step step-2">
          <div class="step-content">
            <h3><i class="fas fa-graduation-cap"></i> Education</h3>

            <!-- School -->
            <div class="field-section">
              <strong>School *</strong>
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="school_name" placeholder="School Name" required
                         value="<?php echo isset($education['school'][0]) ? htmlspecialchars($education['school'][0]['institution_name']) : ''; ?>">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="school_duration" placeholder="Duration" required
                         value="<?php echo isset($education['school'][0]) ? htmlspecialchars($education['school'][0]['duration']) : ''; ?>">
                </div>
              </div>
            </div>

            <!-- University -->
            <div class="field-section">
              <strong>University</strong>
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="university_name" placeholder="University Name"
                         value="<?php echo isset($education['university'][0]) ? htmlspecialchars($education['university'][0]['institution_name']) : ''; ?>">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="university_duration" placeholder="Duration"
                         value="<?php echo isset($education['university'][0]) ? htmlspecialchars($education['university'][0]['duration']) : ''; ?>">
                </div>
                <div class="col-12">
                  <input type="text" class="form-control" name="university_degree" placeholder="Degree/Major"
                         value="<?php echo isset($education['university'][0]) ? htmlspecialchars($education['university'][0]['degree_program']) : ''; ?>">
                </div>
              </div>
            </div>

            <!-- College Toggle -->
            <div class="toggle-section">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleCollege" <?php echo isset($education['college'][0]) ? 'checked' : ''; ?>>
                <label class="form-check-label fw-medium" for="toggleCollege">Add College Information</label>
              </div>
            </div>

            <!-- College Section -->
            <div id="collegeSection" class="field-section <?php echo isset($education['college'][0]) ? '' : 'd-none'; ?>">
              <strong>College</strong>
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="college_name" placeholder="College Name"
                         value="<?php echo isset($education['college'][0]) ? htmlspecialchars($education['college'][0]['institution_name']) : ''; ?>">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="college_duration" placeholder="Duration"
                         value="<?php echo isset($education['college'][0]) ? htmlspecialchars($education['college'][0]['duration']) : ''; ?>">
                </div>
                <div class="col-12">
                  <input type="text" class="form-control" name="college_degree" placeholder="Degree/Program"
                         value="<?php echo isset($education['college'][0]) ? htmlspecialchars($education['college'][0]['degree_program']) : ''; ?>">
                </div>
              </div>
            </div>

            <!-- Diploma Toggle -->
            <div class="toggle-section">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleDiploma" <?php echo isset($education['diploma'][0]) ? 'checked' : ''; ?>>
                <label class="form-check-label fw-medium" for="toggleDiploma">Add Diploma Information</label>
              </div>
            </div>

            <!-- Diploma Section -->
            <div id="diplomaSection" class="field-section <?php echo isset($education['diploma'][0]) ? '' : 'd-none'; ?>">
              <strong>Diploma(s)</strong>
              <div id="diploma-wrapper">
                <?php if (isset($education['diploma']) && count($education['diploma']) > 0): ?>
                  <?php foreach ($education['diploma'] as $diploma): ?>
                    <div class="row g-3 mt-2 diploma-item align-items-center">
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="diploma_name[]" placeholder="Diploma Name"
                               value="<?php echo htmlspecialchars($diploma['institution_name']); ?>">
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="diploma_duration[]" placeholder="Duration"
                               value="<?php echo htmlspecialchars($diploma['duration']); ?>">
                      </div>
                      <div class="col-md-3">
                        <input type="text" class="form-control" name="diploma_institution[]" placeholder="Institution"
                               value="<?php echo htmlspecialchars($diploma['degree_program']); ?>">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn remove-btn remove-diploma"><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="row g-3 mt-2 diploma-item align-items-center">
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="diploma_name[]" placeholder="Diploma Name">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="diploma_duration[]" placeholder="Duration">
                    </div>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="diploma_institution[]" placeholder="Institution">
                    </div>
                    <div class="col-md-1">
                      <button type="button" class="btn remove-btn remove-diploma"><i class="fas fa-times"></i></button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-diploma">
                <i class="fas fa-plus me-2"></i>Add Another Diploma
              </button>
            </div>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right ms-2"></i></button>
          </div>
        </div>

        <!-- Step 3: Experience -->
        <div class="step step-3">
          <div class="step-content">
            <h3><i class="fas fa-briefcase"></i> Experience</h3>
            <div class="mb-4 form-check form-switch">
              <input type="checkbox" class="form-check-input" id="freshie" name="freshie" <?php echo isset($resume['is_freshie']) && $resume['is_freshie'] ? 'checked' : ''; ?>>
              <label for="freshie" class="form-check-label fw-medium">I am a Freshie (No Experience)</label>
            </div>
            <div id="experience-fields" style="<?php echo isset($resume['is_freshie']) && $resume['is_freshie'] ? 'display: none;' : ''; ?>">
              <?php if (count($experience) > 0): ?>
                <?php foreach ($experience as $exp): ?>
                  <div class="experience-item field-section">
                    <div class="row g-3 align-items-center">
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="job_title[]" placeholder="Job Title"
                               value="<?php echo htmlspecialchars($exp['job_title']); ?>">
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="company_name[]" placeholder="Company Name"
                               value="<?php echo htmlspecialchars($exp['company_name']); ?>">
                      </div>
                      <div class="col-md-3">
                        <input type="text" class="form-control" name="job_duration[]" placeholder="Duration"
                               value="<?php echo htmlspecialchars($exp['duration']); ?>">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn remove-btn remove-experience"><i class="fas fa-times"></i></button>
                      </div>
                      <div class="col-12">
                        <textarea class="form-control" name="job_description[]" placeholder="Job Description" rows="3"><?php echo htmlspecialchars($exp['job_description']); ?></textarea>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="experience-item field-section">
                  <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="job_title[]" placeholder="Job Title">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="company_name[]" placeholder="Company Name">
                    </div>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="job_duration[]" placeholder="Duration">
                    </div>
                    <div class="col-md-1">
                      <button type="button" class="btn remove-btn remove-experience"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="col-12">
                      <textarea class="form-control" name="job_description[]" placeholder="Job Description" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline-primary add-item-btn" id="add-experience">
              <i class="fas fa-plus me-2"></i>Add More Experience
            </button>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right ms-2"></i></button>
          </div>
        </div>

        <!-- Step 4: Skills & Field Selection -->
        <div class="step step-4">
          <div class="step-content">
            <h3><i class="fas fa-lightbulb"></i> Skills & Professional Field</h3>

            <!-- Field Selection -->
            <div class="mb-4">
              <label for="fieldSelect" class="form-label">Select Your Professional Field *</label>
              <select id="fieldSelect" name="professional_field" class="form-select" required>
                <option value="">-- Select Field --</option>
                <option value="software_developer" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'software_developer' ? 'selected' : ''; ?>>Software Developer</option>
                <option value="graphic_designer" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'graphic_designer' ? 'selected' : ''; ?>>Graphic Designer</option>
                <option value="teacher" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                <option value="sales_executive" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'sales_executive' ? 'selected' : ''; ?>>Sales Executive</option>
                <option value="content_writer" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'content_writer' ? 'selected' : ''; ?>>Content Writer</option>
                <option value="customer_support" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'customer_support' ? 'selected' : ''; ?>>Customer Support</option>
                <option value="other" <?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'other' ? 'selected' : ''; ?>>Other</option>
              </select>
            </div>

            <!-- Custom Field Input -->
            <div class="mb-4" id="custom-field-wrapper" style="<?php echo isset($resume['professional_field']) && $resume['professional_field'] == 'other' ? '' : 'display: none;'; ?>">
              <label class="form-label">Specify Your Professional Field</label>
              <input type="text" class="form-control" name="custom_field" placeholder="Enter your field"
                     value="<?php echo isset($resume['custom_field']) ? htmlspecialchars($resume['custom_field']) : ''; ?>">
            </div>

            <!-- Skills Section -->
            <div class="mb-4">
              <label class="form-label">Skills</label>
              <p class="text-muted mb-3">Select from suggested skills or add your own</p>
              <div id="suggested-skills" class="mb-4 d-flex flex-wrap gap-2"></div>
              <div class="input-group">
                <input type="text" class="form-control" id="custom-skill-input" placeholder="Add custom skill">
                <button type="button" class="btn btn-primary" id="add-custom-skill">
                  <i class="fas fa-plus me-2"></i>Add Skill
                </button>
              </div>
              <div id="selected-skills" class="mt-4 d-flex flex-wrap">
                <?php foreach ($skills as $skill): ?>
                  <span class="skill-tag me-2 mb-2 d-inline-flex align-items-center">
                    <?php echo htmlspecialchars($skill); ?>
                    <button type="button" class="btn-close btn-close-sm ms-1" style="font-size: 0.7em;" onclick="removeSkill('<?php echo htmlspecialchars($skill); ?>')"></button>
                    <input type="hidden" name="skills[]" value="<?php echo htmlspecialchars($skill); ?>">
                  </span>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Languages -->
            <div class="mb-3">
              <label class="form-label">Languages</label>
              <div id="languages-wrapper">
                <?php if (count($languages) > 0): ?>
                  <?php foreach ($languages as $lang): ?>
                    <div class="row g-3 mb-3 language-item">
                      <div class="col-md-5">
                        <input type="text" class="form-control" name="languages[]" placeholder="Language"
                               value="<?php echo htmlspecialchars($lang['language_name']); ?>">
                      </div>
                      <div class="col-md-5">
                        <select class="form-select" name="language_proficiency[]">
                          <option value="">Proficiency Level</option>
                          <option value="beginner" <?php echo $lang['proficiency_level'] == 'beginner' ? 'selected' : ''; ?>>Beginner</option>
                          <option value="intermediate" <?php echo $lang['proficiency_level'] == 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                          <option value="advanced" <?php echo $lang['proficiency_level'] == 'advanced' ? 'selected' : ''; ?>>Advanced</option>
                          <option value="native" <?php echo $lang['proficiency_level'] == 'native' ? 'selected' : ''; ?>>Native</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn remove-btn remove-language"><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="row g-3 mb-3 language-item">
                    <div class="col-md-5">
                      <input type="text" class="form-control" name="languages[]" placeholder="Language">
                    </div>
                    <div class="col-md-5">
                      <select class="form-select" name="language_proficiency[]">
                        <option value="">Proficiency Level</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="native">Native</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn remove-btn remove-language"><i class="fas fa-times"></i></button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-language">
                <i class="fas fa-plus me-2"></i>Add Language
              </button>
            </div>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right ms-2"></i></button>
          </div>
        </div>

        <!-- Step 5: Additional Information -->
        <div class="step step-5">
          <div class="step-content">
            <h3><i class="fas fa-plus-circle"></i> Additional Information</h3>

            <!-- Projects -->
            <div class="mb-4">
              <label class="form-label">Projects</label>
              <div id="projects-wrapper">
                <?php if (count($projects) > 0): ?>
                  <?php foreach ($projects as $project): ?>
                    <div class="project-item field-section">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="project_title[]" placeholder="Project Title"
                                 value="<?php echo htmlspecialchars($project['project_title']); ?>">
                        </div>
                        <div class="col-md-5">
                          <input type="text" class="form-control" name="project_duration[]" placeholder="Duration"
                                 value="<?php echo htmlspecialchars($project['duration']); ?>">
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn remove-btn remove-project"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-12">
                          <textarea class="form-control" name="project_description[]" placeholder="Project Description" rows="3"><?php echo htmlspecialchars($project['project_description']); ?></textarea>
                        </div>
                        <div class="col-12">
                          <input type="url" class="form-control" name="project_link[]" placeholder="Project Link (optional)"
                                 value="<?php echo htmlspecialchars($project['project_link']); ?>">
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="project-item field-section">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="project_title[]" placeholder="Project Title">
                      </div>
                      <div class="col-md-5">
                        <input type="text" class="form-control" name="project_duration[]" placeholder="Duration">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn remove-btn remove-project"><i class="fas fa-times"></i></button>
                      </div>
                      <div class="col-12">
                        <textarea class="form-control" name="project_description[]" placeholder="Project Description" rows="3"></textarea>
                      </div>
                      <div class="col-12">
                        <input type="url" class="form-control" name="project_link[]" placeholder="Project Link (optional)">
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-project">
                <i class="fas fa-plus me-2"></i>Add Project
              </button>
            </div>

            <!-- Achievements -->
            <div class="mb-3">
              <label class="form-label">Achievements</label>
              <div id="achievements-wrapper">
                <?php if (count($achievements) > 0): ?>
                  <?php foreach ($achievements as $achievement): ?>
                    <div class="row g-3 mb-3 achievement-item">
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="achievements[]" placeholder="Achievement"
                               value="<?php echo htmlspecialchars($achievement); ?>">
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn remove-btn remove-achievement"><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="row g-3 mb-3 achievement-item">
                    <div class="col-md-10">
                      <input type="text" class="form-control" name="achievements[]" placeholder="Achievement">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn remove-btn remove-achievement"><i class="fas fa-times"></i></button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-achievement">
                <i class="fas fa-plus me-2"></i>Add Achievement
              </button>
            </div>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right ms-2"></i></button>
          </div>
        </div>

        <!-- Step 6: Professional Summary & Review -->
        <div class="step step-6">
          <div class="step-content">
            <h3><i class="fas fa-check-circle"></i> Professional Summary & Review</h3>

            <!-- Professional Summary -->
            <div class="mb-4">
              <label for="professional_summary" class="form-label">Professional Summary</label>
              <textarea class="form-control" id="professional_summary" name="professional_summary" rows="5" placeholder="Write a brief professional summary about yourself..."><?php echo htmlspecialchars($resume['professional_summary'] ?? ''); ?></textarea>
            </div>

            <!-- Objective -->
            <div class="mb-4">
              <label for="career_objective" class="form-label">Career Objective</label>
              <textarea class="form-control" id="career_objective" name="career_objective" rows="4" placeholder="Describe your career goals and objectives..."><?php echo htmlspecialchars($resume['career_objective'] ?? ''); ?></textarea>
            </div>

            <!-- References Toggle -->
            <div class="toggle-section mb-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleReferences" <?php echo count($references) > 0 ? 'checked' : ''; ?>>
                <label class="form-check-label fw-medium" for="toggleReferences">Add References</label>
              </div>
            </div>

            <div id="referencesSection" class="<?php echo count($references) > 0 ? '' : 'd-none'; ?>">
              <label class="form-label">References</label>
              <div id="references-wrapper">
                <?php if (count($references) > 0): ?>
                  <?php foreach ($references as $reference): ?>
                    <div class="reference-item field-section">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="reference_name[]" placeholder="Reference Name"
                                 value="<?php echo htmlspecialchars($reference['reference_name']); ?>">
                        </div>
                        <div class="col-md-5">
                          <input type="text" class="form-control" name="reference_position[]" placeholder="Position"
                                 value="<?php echo htmlspecialchars($reference['position']); ?>">
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn remove-btn remove-reference"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="reference_company[]" placeholder="Company"
                                 value="<?php echo htmlspecialchars($reference['company']); ?>">
                        </div>
                        <div class="col-md-6">
                          <input type="email" class="form-control" name="reference_email[]" placeholder="Email"
                                 value="<?php echo htmlspecialchars($reference['email']); ?>">
                        </div>
                        <div class="col-12">
                          <input type="text" class="form-control" name="reference_phone[]" placeholder="Phone"
                                 value="<?php echo htmlspecialchars($reference['phone']); ?>">
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="reference-item field-section">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="reference_name[]" placeholder="Reference Name">
                      </div>
                      <div class="col-md-5">
                        <input type="text" class="form-control" name="reference_position[]" placeholder="Position">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn remove-btn remove-reference"><i class="fas fa-times"></i></button>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="reference_company[]" placeholder="Company">
                      </div>
                      <div class="col-md-6">
                        <input type="email" class="form-control" name="reference_email[]" placeholder="Email">
                      </div>
                      <div class="col-12">
                        <input type="text" class="form-control" name="reference_phone[]" placeholder="Phone">
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-reference">
                <i class="fas fa-plus me-2"></i>Add Reference
              </button>
            </div>

            <!-- Final Review Message -->
            <div class="alert alert-primary mt-4">
              <h5 class="d-flex align-items-center"><i class="fas fa-info-circle me-3"></i> Ready to Update?</h5>
              <p class="mb-0">Please review all your information above. Once you click "Update Resume", your data will be saved to the database and you'll be able to preview your resume.</p>
            </div>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="submit" class="btn btn-success btn-lg" id="submitButton">
              <i class="fas fa-check-circle me-2"></i>Update Resume
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    let currentStep = 1;
    const totalSteps = 6;
    let selectedSkills = [];

    // Skills data for different fields
    const skillsData = {
      software_developer: ['JavaScript', 'Python', 'Java', 'React', 'Node.js', 'SQL', 'Git', 'HTML/CSS', 'PHP', 'MongoDB'],
      graphic_designer: ['Photoshop', 'Illustrator', 'InDesign', 'Figma', 'CorelDRAW', 'Canva', 'Typography', 'Color Theory', 'Branding'],
      teacher: ['Curriculum Development', 'Classroom Management', 'Lesson Planning', 'Student Assessment', 'Educational Technology', 'Communication'],
      sales_executive: ['Lead Generation', 'CRM', 'Negotiation', 'Client Relationship', 'Sales Strategy', 'Market Analysis', 'Presentation'],
      content_writer: ['SEO Writing', 'Content Strategy', 'WordPress', 'Social Media', 'Copywriting', 'Research', 'Editing', 'Blogging'],
      customer_support: ['Zendesk', 'Live Chat', 'Problem Solving', 'Communication', 'Customer Service', 'Technical Support', 'CRM Tools']
    };

    // Initialize form
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, initializing form...');
      updateProgressBar();
      setupEventListeners();
      testConnection();
    });

    function setupEventListeners() {
      console.log('Setting up event listeners...');
      
      // Step navigation
      document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          console.log('Next button clicked');
          if (validateCurrentStep()) {
            nextStep();
          }
        });
      });

      document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          console.log('Previous button clicked');
          prevStep();
        });
      });

      // Toggle sections
      document.getElementById('toggleCollege').addEventListener('change', function() {
        document.getElementById('collegeSection').classList.toggle('d-none', !this.checked);
      });

      document.getElementById('toggleDiploma').addEventListener('change', function() {
        document.getElementById('diplomaSection').classList.toggle('d-none', !this.checked);
      });

      document.getElementById('toggleReferences').addEventListener('change', function() {
        document.getElementById('referencesSection').classList.toggle('d-none', !this.checked);
      });

      // Field selection
      document.getElementById('fieldSelect').addEventListener('change', function() {
        const customWrapper = document.getElementById('custom-field-wrapper');
        if (this.value === 'other') {
          customWrapper.style.display = 'block';
          customWrapper.querySelector('input').required = true;
        } else {
          customWrapper.style.display = 'none';
          customWrapper.querySelector('input').required = false;
        }
        loadSuggestedSkills(this.value);
      });

      // Freshie checkbox
      document.getElementById('freshie').addEventListener('change', function() {
        const experienceFields = document.getElementById('experience-fields');
        experienceFields.style.display = this.checked ? 'none' : 'block';
      });

      // Dynamic field additions
      setupDynamicFields();
      
      // Form submission
      setupFormSubmission();
    }

    function setupFormSubmission() {
      const form = document.getElementById('cvForm');
      
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submission initiated...');
        
        // Show loading
        showLoading(true);
        
        // Final validation
        if (!validateFinalSubmission()) {
          showLoading(false);
          return false;
        }
        
        // Debug: Log form data before submission
        const formData = new FormData(this);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
          console.log(key, value);
        }
        
        formData.append('ajax', '1');
        
        console.log('Submitting form data...');
        
        // Submit with fallback
        submitForm(formData);
      });
    }

    function submitForm(formData) {
      // Try different submission methods
      
      // Method 1: Fetch API (preferred)
      fetch('submit.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); // Get as text first
      })
      .then(text => {
        console.log('Raw response:', text);
        try {
          const data = JSON.parse(text);
          handleSubmissionResponse(data);
        } catch (e) {
          // If not JSON, might be HTML error or success page
          console.log('Response is not JSON, checking content...');
          if (text.includes('success') || text.includes('Success')) {
            handleSubmissionResponse({success: true, message: 'Form submitted successfully'});
          } else {
            throw new Error('Invalid response format: ' + text.substring(0, 200));
          }
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        
        // Method 2: Fallback to XMLHttpRequest
        submitWithXHR(formData);
      });
    }

    function submitWithXHR(formData) {
      console.log('Trying XMLHttpRequest fallback...');
      
      const xhr = new XMLHttpRequest();
      
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            try {
              const data = JSON.parse(xhr.responseText);
              handleSubmissionResponse(data);
            } catch (e) {
              // Check if it's a successful HTML response
              if (xhr.responseText.includes('success') || xhr.responseText.includes('Success')) {
                handleSubmissionResponse({success: true, message: 'Form submitted successfully'});
              } else {
                console.error('XHR Parse error:', e);
                console.log('XHR Response:', xhr.responseText);
                showError('Error parsing server response. Raw response: ' + xhr.responseText.substring(0, 200));
                showLoading(false);
              }
            }
          } else {
            console.error('XHR Error - Status:', xhr.status, 'Response:', xhr.responseText);
            
            // Method 3: Final fallback - standard form submission
            submitWithStandardForm();
          }
        }
      };
      
      xhr.onerror = function() {
        console.error('XHR network error');
        submitWithStandardForm();
      };
      
      xhr.open('POST', 'submit.php', true);
      xhr.send(formData);
    }

    function submitWithStandardForm() {
      console.log('Using standard form submission as final fallback...');
      showLoading(false);
      
      // Remove ajax flag and submit normally
      const form = document.getElementById('cvForm');
      const ajaxInput = form.querySelector('input[name="ajax"]');
      if (ajaxInput) {
        ajaxInput.remove();
      }
      
      // Set action and submit
      form.action = 'submit.php';
      form.submit();
    }

    function handleSubmissionResponse(data) {
      console.log('Handling response:', data);
      showLoading(false);
      
      if (data.success) {
        showSuccess(data.message || 'Resume submitted successfully!');
        
        // Redirect after success
        setTimeout(() => {
          if (data.resume_id) {
            window.location.href = `preview.php?resume_id=${data.resume_id}`;
          } else {
            window.location.href = 'preview.php';
          }
        }, 2000);
      } else {
        showError(data.message || 'Unknown error occurred');
      }
    }

    function showLoading(show) {
      const loadingOverlay = document.getElementById('loadingOverlay');
      const submitBtn = document.getElementById('submitButton');
      
      if (show) {
        loadingOverlay.style.display = 'flex';
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        submitBtn.disabled = true;
      } else {
        loadingOverlay.style.display = 'none';
        submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Submit Resume';
        submitBtn.disabled = false;
      }
    }

    function showError(message) {
      const errorDiv = document.getElementById('errorMessage');
      const successDiv = document.getElementById('successMessage');
      
      successDiv.style.display = 'none';
      errorDiv.innerHTML = '<strong>Error:</strong> ' + message;
      errorDiv.style.display = 'block';
      
      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      // Hide after 10 seconds
      setTimeout(() => {
        errorDiv.style.display = 'none';
      }, 10000);
    }

    function showSuccess(message) {
      const errorDiv = document.getElementById('errorMessage');
      const successDiv = document.getElementById('successMessage');
      
      errorDiv.style.display = 'none';
      successDiv.innerHTML = '<strong>Success:</strong> ' + message;
      successDiv.style.display = 'block';
      
      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateCurrentStep() {
      const currentStepElement = document.querySelector(`.step-${currentStep}`);
      const requiredFields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        // Skip validation for fields in hidden sections
        const isInHiddenSection = field.closest('.d-none') || 
                                  (field.closest('#experience-fields') && document.getElementById('freshie').checked);
        
        if (!isInHiddenSection && !field.value.trim()) {
          field.classList.add('is-invalid');
          isValid = false;
        } else {
          field.classList.remove('is-invalid');
        }
      });

      // Special validation for custom field in step 4
      if (currentStep === 4) {
        const fieldSelect = document.getElementById('fieldSelect');
        const customField = document.querySelector('input[name="custom_field"]');
        if (fieldSelect.value === 'other' && !customField.value.trim()) {
          customField.classList.add('is-invalid');
          isValid = false;
        }
      }

      if (!isValid) {
        showError('Please fill in all required fields before proceeding.');
      }

      return isValid;
    }

    function setupDynamicFields() {
      // Add diploma
      document.getElementById('add-diploma').addEventListener('click', function() {
        const wrapper = document.getElementById('diploma-wrapper');
        const newItem = wrapper.children[0].cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add experience
      document.getElementById('add-experience').addEventListener('click', function() {
        const wrapper = document.getElementById('experience-fields');
        const newItem = wrapper.children[0].cloneNode(true);
        newItem.querySelectorAll('input, textarea').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add language
      document.getElementById('add-language').addEventListener('click', function() {
        const wrapper = document.getElementById('languages-wrapper');
        const newItem = wrapper.children[0].cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add project
      document.getElementById('add-project').addEventListener('click', function() {
        const wrapper = document.getElementById('projects-wrapper');
        const newItem = wrapper.children[0].cloneNode(true);
        newItem.querySelectorAll('input, textarea').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add achievement
      document.getElementById('add-achievement').addEventListener('click', function() {
        const wrapper = document.getElementById('achievements-wrapper');
        const template = wrapper.querySelector('.achievement-item');
        const newItem = template.cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add reference
      document.getElementById('add-reference').addEventListener('click', function() {
        const wrapper = document.getElementById('references-wrapper');
        const newItem = wrapper.children[0].cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        wrapper.appendChild(newItem);
      });

      // Add custom skill
      document.getElementById('add-custom-skill').addEventListener('click', function() {
        const input = document.getElementById('custom-skill-input');
        if (input.value.trim()) {
          addSkill(input.value.trim());
          input.value = '';
        }
      });

      // Remove buttons (using event delegation)
      document.addEventListener('click', function(e) {
        // Handle remove buttons for all dynamic fields
        if (e.target.classList.contains('remove-diploma') || e.target.closest('.remove-diploma')) {
          const btn = e.target.classList.contains('remove-diploma') ? e.target : e.target.closest('.remove-diploma');
          const item = btn.closest('.diploma-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
        
        if (e.target.classList.contains('remove-experience') || e.target.closest('.remove-experience')) {
          const btn = e.target.classList.contains('remove-experience') ? e.target : e.target.closest('.remove-experience');
          const item = btn.closest('.experience-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
        
        if (e.target.classList.contains('remove-language') || e.target.closest('.remove-language')) {
          const btn = e.target.classList.contains('remove-language') ? e.target : e.target.closest('.remove-language');
          const item = btn.closest('.language-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
        
        if (e.target.classList.contains('remove-project') || e.target.closest('.remove-project')) {
          const btn = e.target.classList.contains('remove-project') ? e.target : e.target.closest('.remove-project');
          const item = btn.closest('.project-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
        
        if (e.target.classList.contains('remove-achievement') || e.target.closest('.remove-achievement')) {
          const btn = e.target.classList.contains('remove-achievement') ? e.target : e.target.closest('.remove-achievement');
          const item = btn.closest('.achievement-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
        
        if (e.target.classList.contains('remove-reference') || e.target.closest('.remove-reference')) {
          const btn = e.target.classList.contains('remove-reference') ? e.target : e.target.closest('.remove-reference');
          const item = btn.closest('.reference-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
      });
    }

    function nextStep() {
      if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
        updateProgressBar();
      }
    }

    function prevStep() {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
        updateProgressBar();
      }
    }

    function goToStep(step) {
      if (step >= 1 && step <= totalSteps) {
        currentStep = step;
        showStep(currentStep);
        updateProgressBar();
      }
    }

    function showStep(step) {
      document.querySelectorAll('.step').forEach(el => {
        el.classList.remove('active');
      });
      document.querySelector(`.step-${step}`).classList.add('active');

      document.querySelectorAll('.step-number').forEach(el => {
        el.classList.remove('active', 'completed');
      });
      
      document.querySelectorAll('.step-number').forEach((el, index) => {
        if (index + 1 < step) {
          el.classList.add('completed');
        } else if (index + 1 === step) {
          el.classList.add('active');
        }
      });
    }

    function updateProgressBar() {
      const progressFill = document.getElementById('progressFill');
      const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
      progressFill.style.width = `${progress}%`;
    }

    function loadSuggestedSkills(field) {
      const suggestedSkillsDiv = document.getElementById('suggested-skills');
      suggestedSkillsDiv.innerHTML = '';

      if (field && skillsData[field]) {
        skillsData[field].forEach(skill => {
          const skillButton = document.createElement('button');
          skillButton.type = 'button';
          skillButton.className = 'btn btn-outline-primary btn-sm me-2 mb-2';
          skillButton.textContent = skill;
          skillButton.addEventListener('click', function() {
            addSkill(skill);
          });
          suggestedSkillsDiv.appendChild(skillButton);
        });
      }
    }

    function addSkill(skill) {
      if (!selectedSkills.includes(skill)) {
        selectedSkills.push(skill);
        updateSelectedSkills();
      }
    }

    function removeSkill(skill) {
      selectedSkills = selectedSkills.filter(s => s !== skill);
      updateSelectedSkills();
    }

    function updateSelectedSkills() {
      const selectedSkillsDiv = document.getElementById('selected-skills');
      selectedSkillsDiv.innerHTML = '';

      selectedSkills.forEach(skill => {
        const skillTag = document.createElement('span');
        skillTag.className = 'skill-tag me-2 mb-2 d-inline-flex align-items-center';
        skillTag.innerHTML = `${skill} <button type="button" class="btn-close btn-close-sm ms-1" style="font-size: 0.7em;" onclick="removeSkill('${skill}')"></button>`;
        selectedSkillsDiv.appendChild(skillTag);

        // Create hidden input for form submission
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'skills[]';
        hiddenInput.value = skill;
        selectedSkillsDiv.appendChild(hiddenInput);
      });
    }

    function validateFinalSubmission() {
      // Clear all previous validation states
      document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      
      let isValid = true;
      let firstInvalidField = null;
      let invalidStep = null;

      // Validate required fields across all steps
      const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
      
      requiredFields.forEach(field => {
        // Skip validation for fields in hidden sections
        const isInHiddenSection = field.closest('.d-none') || 
                                  (field.closest('#experience-fields') && document.getElementById('freshie').checked);
        
        if (!isInHiddenSection && !field.value.trim()) {
          field.classList.add('is-invalid');
          isValid = false;
          
          if (!firstInvalidField) {
            firstInvalidField = field;
            // Find which step this field belongs to
            const stepElement = field.closest('.step');
            if (stepElement) {
              const stepClass = Array.from(stepElement.classList).find(cls => cls.startsWith('step-'));
              invalidStep = parseInt(stepClass.split('-')[1]);
            }
          }
        }
      });

      // Special validation for custom field
      const fieldSelect = document.getElementById('fieldSelect');
      const customField = document.querySelector('input[name="custom_field"]');
      if (fieldSelect.value === 'other' && !customField.value.trim()) {
        customField.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) {
          firstInvalidField = customField;
          invalidStep = 4;
        }
      }

      if (!isValid) {
        showError('Please fill in all required fields before submitting.');
        
        if (firstInvalidField && invalidStep) {
          // Navigate to the step with the first invalid field
          goToStep(invalidStep);
          
          // Focus on the first invalid field after a short delay
          setTimeout(() => {
            firstInvalidField.focus();
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }, 300);
        }
      }

      return isValid;
    }

    // Test connection function
    function testConnection() {
      console.log('Testing database connection...');
      fetch('submit.php?test_connection=1')
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('✅ Database connection successful');
          } else {
            console.error('❌ Database connection failed:', data.message);
            showError('Database connection issue: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Connection test failed:', error);
          console.warn('⚠️ Connection test failed, but form submission may still work');
        });
    }

    // Add Enter key handling for custom skill input
    document.getElementById('custom-skill-input')?.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('add-custom-skill').click();
      }
    });

    // Step number click navigation
    document.querySelectorAll('.step-number').forEach(btn => {
      btn.addEventListener('click', function() {
        const step = parseInt(this.dataset.step);
        goToStep(step);
      });
    });

    // Debug logging
    window.addEventListener('error', function(e) {
      console.error('JavaScript Error:', e.error);
    });

    window.addEventListener('unhandledrejection', function(e) {
      console.error('Unhandled Promise Rejection:', e.reason);
    });
  </script>
</body>
</html>