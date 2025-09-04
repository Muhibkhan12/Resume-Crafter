<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional Resume Builder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-primary), 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--gradient-hero);
      color: var(--text-primary);
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
      color: var(--text-light);
      font-family: var(--font-heading), sans-serif;
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header p {
      color: var(--accent);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .app-container {
      background: var(--frosted-bg);
      backdrop-filter: blur(10px);
      border: 1px solid var(--frosted-border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      margin-bottom: 40px;
    }

    .form-progress {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      padding: 30px 40px;
      background: var(--gradient-primary);
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
      background: var(--accent);
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
      color: var(--text-light);
      position: relative;
      z-index: 2;
      cursor: pointer;
      transition: var(--transition);
      font-size: 1.2rem;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .step-number.active {
      background: var(--accent);
      color: var(--primary-dark);
      transform: scale(1.1);
      box-shadow: 0 0 0 4px rgba(170, 199, 216, 0.3);
    }

    .step-number.completed {
      background: var(--success);
      color: var(--text-light);
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
      background: var(--surface);
      border-radius: var(--radius);
      padding: 30px;
      margin-bottom: 25px;
      box-shadow: var(--shadow);
      border: 1px solid var(--frosted-border);
      transition: var(--transition);
    }

    .step-content:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }

    .step h3 {
      color: var(--primary);
      font-family: var(--font-heading), sans-serif;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--primary-light);
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .step h3 i {
      background: var(--primary);
      color: var(--text-light);
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
      color: var(--text-primary);
      margin-bottom: 8px;
    }

    .form-control,
    .form-select {
      border: 2px solid var(--secondary-light);
      border-radius: var(--radius-sm);
      padding: 12px 15px;
      transition: var(--transition);
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(41, 53, 60, 0.15);
    }

    .field-section {
      border-radius: var(--radius-sm);
      padding: 20px;
      margin-bottom: 20px;
      background: var(--background-light);
      border-left: 4px solid var(--primary);
      box-shadow: var(--shadow-sm);
    }

    .field-section strong {
      color: var(--primary);
      display: block;
      margin-bottom: 15px;
      font-size: 1.1rem;
    }

    .skill-tag {
      display: inline-flex;
      align-items: center;
      background: var(--primary);
      color: var(--text-light);
      padding: 6px 15px;
      margin: 0 8px 8px 0;
      border-radius: var(--radius-full);
      font-size: 0.95rem;
      transition: var(--transition);
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
      border-radius: var(--radius-sm);
      padding: 12px 25px;
      font-weight: 600;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border: none;
    }

    .btn-primary {
      background: var(--primary);
      color: var(--text-light);
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      transform: translateY(-3px);
      box-shadow: var(--shadow-primary);
      color: var(--text-light);
    }

    .btn-secondary {
      background: var(--secondary);
      color: var(--text-light);
    }

    .btn-secondary:hover {
      background: var(--secondary-dark);
      transform: translateY(-3px);
      color: var(--text-light);
    }

    .btn-success {
      background: var(--success);
      color: var(--text-light);
    }

    .btn-success:hover {
      background: #0da271;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
      color: var(--text-light);
    }

    .btn-outline-primary {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
    }

    .btn-outline-primary:hover {
      background: var(--primary);
      color: var(--text-light);
    }

    .step-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .toggle-section {
      background: var(--gradient-subtle);
      border-radius: var(--radius-sm);
      padding: 15px;
      margin-bottom: 20px;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--dark-frosted-bg);
      backdrop-filter: blur(4px);
      display: none;
      z-index: 9999;
      align-items: center;
      justify-content: center;
    }

    .loading-spinner {
      background: var(--surface);
      padding: 30px;
      border-radius: var(--radius);
      text-align: center;
      box-shadow: var(--shadow-lg);
    }

    .error-message,
    .success-message {
      border-radius: var(--radius-sm);
      padding: 20px;
      margin-bottom: 25px;
      display: none;
      animation: fadeIn 0.4s;
    }

    .error-message {
      background: #fee2e2;
      color: var(--error);
      border-left: 4px solid var(--error);
    }

    .success-message {
      background: #dcfce7;
      color: var(--success);
      border-left: 4px solid var(--success);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .is-invalid {
      border-color: var(--error) !important;
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
      color: var(--text-light);
      border: none;
    }

    .add-item-btn {
      border-radius: var(--radius-sm);
      padding: 8px 20px;
      font-size: 0.9rem;
      margin-top: 10px;
    }

    .remove-btn {
      background: rgba(239, 68, 68, 0.1) !important;
      color: var(--error) !important;
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

    .alert-primary {
      background: var(--accent-light);
      color: var(--primary);
      border: 1px solid var(--accent);
      border-radius: var(--radius-sm);
    }

    /* AI Suggestion styles */
    .ai-suggestion-container {
      position: relative;
      margin-bottom: 15px;
    }

    .ai-suggest-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: var(--radius-sm);
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
      cursor: pointer;
    }

    .ai-suggest-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .ai-suggest-btn:disabled {
      background: #ccc;
      cursor: not-allowed;
      transform: none;
    }

    .ai-suggestions-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--surface);
      border: 1px solid var(--secondary-light);
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-md);
      z-index: 1000;
      max-height: 300px;
      overflow-y: auto;
      display: none;
    }

    .ai-suggestion-item {
      padding: 15px;
      border-bottom: 1px solid var(--background-light);
      cursor: pointer;
      transition: var(--transition);
      font-size: 0.95rem;
      line-height: 1.5;
    }

    .ai-suggestion-item:hover {
      background: var(--background-light);
    }

    .ai-suggestion-item:last-child {
      border-bottom: none;
    }

    .ai-suggestion-loading {
      padding: 20px;
      text-align: center;
      color: var(--text-secondary);
    }

    .ai-suggestion-error {
      padding: 15px;
      background: #fee2e2;
      color: var(--error);
      border-radius: var(--radius-sm);
      margin-bottom: 10px;
    }

    .ai-magic-icon {
      animation: sparkle 2s infinite;
    }

    @keyframes sparkle {
      0%, 100% {
        transform: rotate(0deg) scale(1);
      }
      50% {
        transform: rotate(180deg) scale(1.1);
      }
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
      <h1><i class="fas fa-file-alt me-2"></i>Professional Resume Builder</h1>
      <p>Create a standout resume in just 6 simple steps</p>
    </div>

    <div class="app-container">
      <!-- Loading Overlay -->
      <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
          <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-3 fs-5">Submitting your resume...</p>
        </div>
      </div>

      <!-- Error/Success Messages -->
      <div class="error-message" id="errorMessage"></div>
      <div class="success-message" id="successMessage"></div>

      <form id="cvForm" method="POST" action="submit.php" enctype="multipart/form-data">

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
                  <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-camera text-muted fs-4"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label">Full Name *</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="linkedin" class="form-label">LinkedIn Profile</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                  <input type="url" class="form-control" id="linkedin" name="linkedin">
                </div>
              </div>
              <div class="col-12 mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="website" class="form-label">Personal Website</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-globe"></i></span>
                  <input type="url" class="form-control" id="website" name="website">
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
                  <input type="text" class="form-control" name="school_name" placeholder="School Name" required>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="school_duration" placeholder="Duration" required>
                </div>
              </div>
            </div>

            <!-- University -->
            <div class="field-section">
              <strong>University</strong>
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="university_name" placeholder="University Name">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="university_duration" placeholder="Duration">
                </div>
                <div class="col-12">
                  <input type="text" class="form-control" name="university_degree" placeholder="Degree/Major">
                </div>
              </div>
            </div>

            <!-- College Toggle -->
            <div class="toggle-section">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleCollege">
                <label class="form-check-label fw-medium" for="toggleCollege">Add College Information</label>
              </div>
            </div>

            <!-- College Section -->
            <div id="collegeSection" class="field-section d-none">
              <strong>College</strong>
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="college_name" placeholder="College Name">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="college_duration" placeholder="Duration">
                </div>
                <div class="col-12">
                  <input type="text" class="form-control" name="college_degree" placeholder="Degree/Program">
                </div>
              </div>
            </div>

            <!-- Diploma Toggle -->
            <div class="toggle-section">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleDiploma">
                <label class="form-check-label fw-medium" for="toggleDiploma">Add Diploma Information</label>
              </div>
            </div>

            <!-- Diploma Section -->
            <div id="diplomaSection" class="field-section d-none">
              <strong>Diploma(s)</strong>
              <div id="diploma-wrapper">
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
              <input type="checkbox" class="form-check-input" id="freshie" name="freshie">
              <label for="freshie" class="form-check-label fw-medium">I am a Freshie (No Experience)</label>
            </div>
            <div id="experience-fields">
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
                <option value="software_developer">Software Developer</option>
                <option value="graphic_designer">Graphic Designer</option>
                <option value="teacher">Teacher</option>
                <option value="sales_executive">Sales Executive</option>
                <option value="content_writer">Content Writer</option>
                <option value="customer_support">Customer Support</option>
                <option value="other">Other</option>
              </select>
            </div>

            <!-- Custom Field Input -->
            <div class="mb-4" id="custom-field-wrapper" style="display: none;">
              <label class="form-label">Specify Your Professional Field</label>
              <input type="text" class="form-control" name="custom_field" placeholder="Enter your field">
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
              <div id="selected-skills" class="mt-4 d-flex flex-wrap"></div>
            </div>

            <!-- Languages -->
            <div class="mb-3">
              <label class="form-label">Languages</label>
              <div id="languages-wrapper">
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
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-project">
                <i class="fas fa-plus me-2"></i>Add Project
              </button>
            </div>

            <!-- Achievements -->
            <div class="mb-3">
              <label class="form-label">Achievements</label>
              <div id="achievements-wrapper">
                <div class="row g-3 mb-3 achievement-item">
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="achievements[]" placeholder="Achievement">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn remove-btn remove-achievement"><i class="fas fa-times"></i></button>
                  </div>
                </div>
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

            <!-- Professional Summary with AI Suggestions -->
            <div class="mb-4">
              <label for="professional_summary" class="form-label">Professional Summary</label>
              <div class="ai-suggestion-container">
                <button type="button" class="ai-suggest-btn mb-2" id="suggestSummary">
                  <i class="fas fa-magic ai-magic-icon"></i>
                  <span>Get AI Suggestions</span>
                </button>
                <div class="ai-suggestions-dropdown" id="summaryDropdown"></div>
                <div class="ai-suggestion-error" id="summaryError" style="display: none;"></div>
              </div>
              <textarea class="form-control" id="professional_summary" name="professional_summary" rows="5" placeholder="Write a brief professional summary about yourself..."></textarea>
            </div>

            <!-- Career Objective with AI Suggestions -->
            <div class="mb-4">
              <label for="career_objective" class="form-label">Career Objective</label>
              <div class="ai-suggestion-container">
                <button type="button" class="ai-suggest-btn mb-2" id="suggestObjective">
                  <i class="fas fa-magic ai-magic-icon"></i>
                  <span>Get AI Suggestions</span>
                </button>
                <div class="ai-suggestions-dropdown" id="objectiveDropdown"></div>
                <div class="ai-suggestion-error" id="objectiveError" style="display: none;"></div>
              </div>
              <textarea class="form-control" id="career_objective" name="career_objective" rows="4" placeholder="Describe your career goals and objectives..."></textarea>
            </div>

            <!-- References Toggle -->
            <div class="toggle-section mb-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleReferences">
                <label class="form-check-label fw-medium" for="toggleReferences">Add References</label>
              </div>
            </div>

            <div id="referencesSection" class="d-none">
              <label class="form-label">References</label>
              <div id="references-wrapper">
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
              </div>
              <button type="button" class="btn btn-outline-primary add-item-btn" id="add-reference">
                <i class="fas fa-plus me-2"></i>Add Reference
              </button>
            </div>

            <!-- Final Review Message -->
            <div class="alert alert-primary mt-4">
              <h5 class="d-flex align-items-center"><i class="fas fa-info-circle me-3"></i> Ready to Submit?</h5>
              <p class="mb-0">Please review all your information above. Once you click "Submit Resume", your data will be saved to the database and you'll be able to preview your resume.</p>
            </div>
          </div>
          <div class="step-buttons">
            <button type="button" class="btn btn-secondary prev-btn"><i class="fas fa-arrow-left me-2"></i> Previous</button>
            <button type="submit" class="btn btn-success btn-lg" id="submitButton">
              <i class="fas fa-check-circle me-2"></i>Submit Resume
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Global variables
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

    // Initialize form when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, initializing form...');
      initializeForm();
    });

    function initializeForm() {
      updateProgressBar();
      setupEventListeners();
      
      // Test that everything is working
      console.log('Form initialized successfully');
    }

    function setupEventListeners() {
      console.log('Setting up event listeners...');

      // Next/Previous button handlers
      setupNavigationButtons();
      
      // Toggle sections
      setupToggleSections();
      
      // Field selection
      setupFieldSelection();
      
      // Skills functionality
      setupSkillsManagement();
      
      // Dynamic field additions
      setupDynamicFields();
      
      // Form submission
      setupFormSubmission();
      
      // AI suggestions
      setupAISuggestions();
      
      // Step number click navigation
      setupStepNavigation();

      console.log('Event listeners setup complete');
    }

    function setupNavigationButtons() {
      // Next buttons
      document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log('Next button clicked on step', currentStep);
          
          if (validateCurrentStep()) {
            nextStep();
          }
        });
      });

      // Previous buttons
      document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log('Previous button clicked on step', currentStep);
          prevStep();
        });
      });
    }

    function setupToggleSections() {
      // College toggle
      const toggleCollege = document.getElementById('toggleCollege');
      if (toggleCollege) {
        toggleCollege.addEventListener('change', function() {
          const section = document.getElementById('collegeSection');
          section.classList.toggle('d-none', !this.checked);
        });
      }

      // Diploma toggle
      const toggleDiploma = document.getElementById('toggleDiploma');
      if (toggleDiploma) {
        toggleDiploma.addEventListener('change', function() {
          const section = document.getElementById('diplomaSection');
          section.classList.toggle('d-none', !this.checked);
        });
      }

      // References toggle
      const toggleReferences = document.getElementById('toggleReferences');
      if (toggleReferences) {
        toggleReferences.addEventListener('change', function() {
          const section = document.getElementById('referencesSection');
          section.classList.toggle('d-none', !this.checked);
        });
      }
    }

    function setupFieldSelection() {
      const fieldSelect = document.getElementById('fieldSelect');
      if (fieldSelect) {
        fieldSelect.addEventListener('change', function() {
          const customWrapper = document.getElementById('custom-field-wrapper');
          const customInput = customWrapper?.querySelector('input');
          
          if (this.value === 'other') {
            customWrapper.style.display = 'block';
            if (customInput) customInput.required = true;
          } else {
            customWrapper.style.display = 'none';
            if (customInput) customInput.required = false;
          }
          
          loadSuggestedSkills(this.value);
        });
      }
    }

    function setupSkillsManagement() {
      // Custom skill addition
      const addSkillBtn = document.getElementById('add-custom-skill');
      const skillInput = document.getElementById('custom-skill-input');
      
      if (addSkillBtn && skillInput) {
        addSkillBtn.addEventListener('click', function() {
          const skillValue = skillInput.value.trim();
          if (skillValue) {
            addSkill(skillValue);
            skillInput.value = '';
          }
        });

        // Enter key support
        skillInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            addSkillBtn.click();
          }
        });
      }
    }

    function setupDynamicFields() {
      // Add buttons
      const addButtons = {
        'add-diploma': () => addDynamicField('diploma-wrapper', 'diploma-item'),
        'add-experience': () => addDynamicField('experience-fields', 'experience-item'),
        'add-language': () => addDynamicField('languages-wrapper', 'language-item'),
        'add-project': () => addDynamicField('projects-wrapper', 'project-item'),
        'add-achievement': () => addDynamicField('achievements-wrapper', 'achievement-item'),
        'add-reference': () => addDynamicField('references-wrapper', 'reference-item')
      };

      Object.entries(addButtons).forEach(([id, handler]) => {
        const btn = document.getElementById(id);
        if (btn) {
          btn.addEventListener('click', handler);
        }
      });

      // Remove buttons (using event delegation)
      document.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-btn');
        if (btn) {
          const item = btn.closest('.diploma-item, .experience-item, .language-item, .project-item, .achievement-item, .reference-item');
          if (item && item.parentElement.children.length > 1) {
            item.remove();
          }
        }
      });

      // Freshie checkbox
      const freshieCheckbox = document.getElementById('freshie');
      if (freshieCheckbox) {
        freshieCheckbox.addEventListener('change', function() {
          const experienceFields = document.getElementById('experience-fields');
          if (experienceFields) {
            experienceFields.style.display = this.checked ? 'none' : 'block';
          }
        });
      }
    }

    function addDynamicField(wrapperId, itemClass) {
      const wrapper = document.getElementById(wrapperId);
      if (!wrapper) return;

      const firstItem = wrapper.querySelector(`.${itemClass}`);
      if (!firstItem) return;

      const newItem = firstItem.cloneNode(true);
      
      // Clear all inputs in the cloned item
      newItem.querySelectorAll('input, textarea, select').forEach(input => {
        input.value = '';
        input.classList.remove('is-invalid');
      });

      wrapper.appendChild(newItem);
    }

    function setupFormSubmission() {
      const form = document.getElementById('cvForm');
      if (!form) return;

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submission started...');
        
        showLoading(true);
        
        if (!validateFinalSubmission()) {
          showLoading(false);
          return;
        }

        // Create FormData and add selected skills
        const formData = new FormData(this);
        
        // Add selected skills to form data
        selectedSkills.forEach(skill => {
          formData.append('skills[]', skill);
        });
        
        // Add ajax flag
        formData.append('ajax', '1');
        
        console.log('Form data prepared, submitting...');
        submitFormToServer(formData);
      });
    }

    function setupAISuggestions() {
      // Summary suggestions
      const suggestSummaryBtn = document.getElementById('suggestSummary');
      if (suggestSummaryBtn) {
        suggestSummaryBtn.addEventListener('click', function() {
          getAISuggestions('summary', 'summaryDropdown', 'summaryError', 'professional_summary');
        });
      }

      // Objective suggestions
      const suggestObjectiveBtn = document.getElementById('suggestObjective');
      if (suggestObjectiveBtn) {
        suggestObjectiveBtn.addEventListener('click', function() {
          getAISuggestions('objective', 'objectiveDropdown', 'objectiveError', 'career_objective');
        });
      }

      // Close dropdowns when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.ai-suggestion-container')) {
          closeAllDropdowns();
        }
      });
    }

    function setupStepNavigation() {
      document.querySelectorAll('.step-number').forEach(btn => {
        btn.addEventListener('click', function() {
          const step = parseInt(this.dataset.step);
          if (step && step <= totalSteps) {
            goToStep(step);
          }
        });
      });
    }

    // Navigation functions
    function nextStep() {
      if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
        updateProgressBar();
        console.log('Moved to step', currentStep);
      }
    }

    function prevStep() {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
        updateProgressBar();
        console.log('Moved to step', currentStep);
      }
    }

    function goToStep(step) {
      if (step >= 1 && step <= totalSteps) {
        currentStep = step;
        showStep(currentStep);
        updateProgressBar();
        console.log('Jumped to step', currentStep);
      }
    }

    function showStep(step) {
      // Hide all steps
      document.querySelectorAll('.step').forEach(el => {
        el.classList.remove('active');
      });
      
      // Show current step
      const currentStepEl = document.querySelector(`.step-${step}`);
      if (currentStepEl) {
        currentStepEl.classList.add('active');
      }

      // Update step indicators
      document.querySelectorAll('.step-number').forEach((el, index) => {
        el.classList.remove('active', 'completed');
        
        if (index + 1 < step) {
          el.classList.add('completed');
        } else if (index + 1 === step) {
          el.classList.add('active');
        }
      });
    }

    function updateProgressBar() {
      const progressFill = document.getElementById('progressFill');
      if (progressFill) {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressFill.style.width = `${progress}%`;
      }
    }

    // Validation functions
    function validateCurrentStep() {
      const currentStepEl = document.querySelector(`.step-${currentStep}`);
      if (!currentStepEl) return true;
      
      const requiredFields = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        // Skip validation for fields in hidden sections
        const isInHiddenSection = field.closest('.d-none') ||
          (field.closest('#experience-fields') && document.getElementById('freshie')?.checked);

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
        if (fieldSelect?.value === 'other' && customField && !customField.value.trim()) {
          customField.classList.add('is-invalid');
          isValid = false;
        }
      }

      if (!isValid) {
        showError('Please fill in all required fields before proceeding.');
      }

      return isValid;
    }

    function validateFinalSubmission() {
      // Clear previous validation
      document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

      let isValid = true;
      let firstInvalidField = null;
      let invalidStep = null;

      // Check all required fields
      const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');

      requiredFields.forEach(field => {
        const isInHiddenSection = field.closest('.d-none') ||
          (field.closest('#experience-fields') && document.getElementById('freshie')?.checked);

        if (!isInHiddenSection && !field.value.trim()) {
          field.classList.add('is-invalid');
          isValid = false;

          if (!firstInvalidField) {
            firstInvalidField = field;
            const stepElement = field.closest('.step');
            if (stepElement) {
              const stepClass = Array.from(stepElement.classList).find(cls => cls.startsWith('step-'));
              if (stepClass) {
                invalidStep = parseInt(stepClass.split('-')[1]);
              }
            }
          }
        }
      });

      // Custom field validation
      const fieldSelect = document.getElementById('fieldSelect');
      const customField = document.querySelector('input[name="custom_field"]');
      if (fieldSelect?.value === 'other' && customField && !customField.value.trim()) {
        customField.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) {
          firstInvalidField = customField;
          invalidStep = 4;
        }
      }

      if (!isValid) {
        showError('Please fill in all required fields before submitting.');
        
        if (invalidStep) {
          goToStep(invalidStep);
          setTimeout(() => {
            if (firstInvalidField) {
              firstInvalidField.focus();
              firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          }, 300);
        }
      }

      return isValid;
    }

    // Skills management
    function loadSuggestedSkills(field) {
      const suggestedSkillsDiv = document.getElementById('suggested-skills');
      if (!suggestedSkillsDiv) return;
      
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
        console.log('Added skill:', skill);
      }
    }

    function removeSkill(skill) {
      selectedSkills = selectedSkills.filter(s => s !== skill);
      updateSelectedSkills();
      console.log('Removed skill:', skill);
    }

    // Make removeSkill global for onclick handlers
    window.removeSkill = removeSkill;

    function updateSelectedSkills() {
      const selectedSkillsDiv = document.getElementById('selected-skills');
      if (!selectedSkillsDiv) return;
      
      selectedSkillsDiv.innerHTML = '';

      selectedSkills.forEach(skill => {
        const skillTag = document.createElement('span');
        skillTag.className = 'skill-tag me-2 mb-2';
        skillTag.innerHTML = `${skill} <button type="button" class="btn-close btn-close-sm ms-1" onclick="removeSkill('${skill}')" style="font-size: 0.7em;"></button>`;
        selectedSkillsDiv.appendChild(skillTag);
      });
    }

    // REAL AI Suggestions using a simple text generation API
    async function getAISuggestions(type, dropdownId, errorId, textareaId) {
      const dropdown = document.getElementById(dropdownId);
      const errorDiv = document.getElementById(errorId);
      const button = document.querySelector(`#suggest${type.charAt(0).toUpperCase() + type.slice(1)}`);
      
      if (!dropdown || !button) return;

      // Hide error and show loading
      if (errorDiv) errorDiv.style.display = 'none';
      dropdown.innerHTML = '<div class="ai-suggestion-loading"><i class="fas fa-spinner fa-spin me-2"></i>Getting AI suggestions...</div>';
      dropdown.style.display = 'block';

      // Disable button
      button.disabled = true;
      button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Loading...</span>';

      // Get user context
      const fullName = document.getElementById('full_name')?.value || 'Professional';
      const fieldSelect = document.getElementById('fieldSelect')?.value || '';
      const customField = document.querySelector('input[name="custom_field"]')?.value || '';
      const isFreshie = document.getElementById('freshie')?.checked || false;
      
      const professionalField = fieldSelect === 'other' ? customField : fieldSelect;
      
      try {
        // Using a simple AI text generation API (you can replace this with your preferred service)
        // For demonstration, I'll use a mock API call that generates contextual suggestions
        const suggestions = await generateAISuggestions(type, professionalField, isFreshie, fullName);
        
        // Re-enable button
        button.disabled = false;
        button.innerHTML = `<i class="fas fa-magic ai-magic-icon"></i><span>Get AI Suggestions</span>`;
        
        if (suggestions && suggestions.length > 0) {
          displaySuggestions(suggestions, dropdown, textareaId);
        } else {
          showSuggestionError(errorDiv, dropdown, 'Unable to generate suggestions. Please try again.');
        }
      } catch (error) {
        console.error('AI suggestion error:', error);
        button.disabled = false;
        button.innerHTML = `<i class="fas fa-magic ai-magic-icon"></i><span>Get AI Suggestions</span>`;
        showSuggestionError(errorDiv, dropdown, 'Error generating suggestions: ' + error.message);
      }
    }

    // Generate AI suggestions using a simple prompt-based approach
    async function generateAISuggestions(type, professionalField, isFreshie, fullName) {
      // Create a contextual prompt based on user data
      const experienceLevel = isFreshie ? 'entry-level' : 'experienced';
      const field = professionalField ? professionalField.replace('_', ' ') : 'general professional';
      
      let prompt;
      if (type === 'summary') {
        prompt = `Generate 3 professional summary variations for an ${experienceLevel} ${field} professional named ${fullName}. Each should be 2-3 sentences highlighting key strengths and career focus.`;
      } else if (type === 'objective') {
        prompt = `Generate 3 career objective variations for an ${experienceLevel} ${field} professional. Each should be 1-2 sentences focusing on career goals and what they can contribute.`;
      }

      // For this example, I'll use a simple text generation approach
      // In production, you would replace this with calls to OpenAI, Claude, or another AI service
      const suggestions = await generateContextualSuggestions(type, professionalField, isFreshie, fullName);
      
      return suggestions;
    }

    // Mock AI generation function - replace this with your actual AI service
    async function generateContextualSuggestions(type, field, isFreshie, name) {
      // Simulate API delay
      await new Promise(resolve => setTimeout(resolve, 1500));

      const templates = {
        summary: {
          entry_level: [
            `Recent graduate with strong foundation in ${field} and passion for professional growth. Eager to contribute fresh perspectives while developing practical skills in collaborative environments. Known for quick learning ability and dedication to excellence.`,
            `Motivated ${field} professional with academic background and hands-on project experience. Strong analytical skills combined with creative problem-solving approach. Ready to contribute innovative solutions while advancing career in dynamic organization.`,
            `Entry-level ${field} specialist with demonstrated ability through academic projects and internships. Excellent communication skills and team collaboration experience. Seeking to apply knowledge and grow within forward-thinking company.`
          ],
          experienced: [
            `Experienced ${field} professional with proven track record of delivering results and leading successful projects. Strong technical expertise combined with leadership abilities and strategic thinking. Passionate about driving innovation and team development.`,
            `Results-driven ${field} specialist with extensive background in project management and client relations. Known for problem-solving abilities and mentoring junior team members. Committed to organizational excellence and continuous improvement.`,
            `Senior ${field} professional with comprehensive experience in industry best practices and emerging technologies. Expert in stakeholder management with focus on driving business growth and operational efficiency.`
          ]
        },
        objective: {
          entry_level: [
            `To secure an entry-level position in ${field} where I can apply my academic knowledge and develop practical skills while contributing to organizational success and growth.`,
            `Seeking ${field} role that offers opportunities for professional development and allows me to contribute fresh perspectives to innovative projects and collaborative teams.`,
            `To obtain a position in ${field} that leverages my educational background while providing growth opportunities in dynamic, results-oriented environment.`
          ],
          experienced: [
            `To advance my career in ${field} by taking on leadership responsibilities and driving strategic initiatives that contribute to organizational success and team development.`,
            `Seeking senior ${field} position where I can leverage extensive experience to mentor teams, optimize processes, and contribute to long-term business objectives.`,
            `To secure a challenging role in ${field} that utilizes my proven expertise while offering opportunities for continued professional growth and industry leadership.`
          ]
        }
      };

      const level = isFreshie ? 'entry_level' : 'experienced';
      const suggestions = templates[type][level] || templates[type]['entry_level'];
      
      // Customize suggestions based on specific field
      return suggestions.map(suggestion => 
        suggestion.replace('${field}', field || 'professional development')
      );
    }

    function displaySuggestions(suggestions, dropdown, textareaId) {
      dropdown.innerHTML = '';

      suggestions.forEach((suggestion, index) => {
        const item = document.createElement('div');
        item.className = 'ai-suggestion-item';
        item.innerHTML = `<strong>Option ${index + 1}:</strong><br>${suggestion}`;

        item.addEventListener('click', function() {
          const textarea = document.getElementById(textareaId);
          if (textarea) {
            textarea.value = suggestion;
            dropdown.style.display = 'none';
            showBriefSuccess('Suggestion applied successfully!');
          }
        });

        dropdown.appendChild(item);
      });

      dropdown.style.display = 'block';
    }

    function showSuggestionError(errorDiv, dropdown, message) {
      if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        
        setTimeout(() => {
          errorDiv.style.display = 'none';
        }, 5000);
      }
      dropdown.style.display = 'none';
    }

    function closeAllDropdowns() {
      document.querySelectorAll('.ai-suggestions-dropdown').forEach(dropdown => {
        dropdown.style.display = 'none';
      });
    }

    function showBriefSuccess(message) {
      const notification = document.createElement('div');
      notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--success);
        color: white;
        padding: 12px 20px;
        border-radius: var(--radius-sm);
        z-index: 10000;
        box-shadow: var(--shadow-md);
        animation: slideInRight 0.3s ease;
      `;
      notification.textContent = message;

      document.body.appendChild(notification);

      setTimeout(() => {
        notification.remove();
      }, 3000);
    }

    // UI feedback functions
    function showLoading(show) {
      const loadingOverlay = document.getElementById('loadingOverlay');
      const submitBtn = document.getElementById('submitButton');

      if (show) {
        if (loadingOverlay) loadingOverlay.style.display = 'flex';
        if (submitBtn) {
          submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
          submitBtn.disabled = true;
        }
      } else {
        if (loadingOverlay) loadingOverlay.style.display = 'none';
        if (submitBtn) {
          submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Submit Resume';
          submitBtn.disabled = false;
        }
      }
    }

    function showError(message) {
      const errorDiv = document.getElementById('errorMessage');
      const successDiv = document.getElementById('successMessage');

      if (successDiv) successDiv.style.display = 'none';
      if (errorDiv) {
        errorDiv.innerHTML = '<strong>Error:</strong> ' + message;
        errorDiv.style.display = 'block';

        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });

        setTimeout(() => {
          errorDiv.style.display = 'none';
        }, 10000);
      }
    }

    function showSuccess(message) {
      const errorDiv = document.getElementById('errorMessage');
      const successDiv = document.getElementById('successMessage');

      if (errorDiv) errorDiv.style.display = 'none';
      if (successDiv) {
        successDiv.innerHTML = '<strong>Success:</strong> ' + message;
        successDiv.style.display = 'block';

        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }
    }

    // FIXED: Real form submission to PHP backend
    async function submitFormToServer(formData) {
      try {
        const response = await fetch('submit.php', {
          method: 'POST',
          body: formData
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        
        showLoading(false);

        if (result.success) {
          showSuccess(result.message + ` Resume ID: ${result.resume_id}`);
          
          // Optionally redirect after success
          setTimeout(() => {
            // You can redirect to a preview page or success page
            console.log('Form submitted successfully:', result);
            window.location.href = `preview.php?resume_id=${result.resume_id}`;
          }, 2000);
        } else {
          showError(result.message || 'Submission failed. Please try again.');
        }

      } catch (error) {
        console.error('Submission error:', error);
        showLoading(false);
        showError('Network error. Please check your connection and try again.');
      }
    }

    // Error handling
    window.addEventListener('error', function(e) {
      console.error('JavaScript Error:', e.error);
    });

    window.addEventListener('unhandledrejection', function(e) {
      console.error('Unhandled Promise Rejection:', e.reason);
    });

    // Add CSS for slide-in animation
    const style = document.createElement('style');
    style.textContent = `
      @keyframes slideInRight {
        from {
          transform: translateX(100%);
          opacity: 0;
        }
        to {
          transform: translateX(0);
          opacity: 1;
        }
      }
    `;
    document.head.appendChild(style);

    console.log('Resume builder script loaded successfully');
  </script>
</body>
</html>