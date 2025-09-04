<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable CORS for testing
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Database configuration
$host = 'localhost';
$dbname = 'resume';
$username = 'root';
$password = '';
$port = 3306;

// AI Configuration (Optional - for real AI integration)
// Uncomment and configure these if you want to use real AI services
/*
$openai_api_key = 'your-openai-api-key-here';
$huggingface_api_key = 'your-huggingface-api-key-here';
*/

// Simple database connection test
function testConnection() {
    global $host, $dbname, $username, $password, $port;
    
    try {
        $connection = mysqli_connect($host, $username, $password, $dbname, $port);
        
        if (!$connection) {
            return [
                'success' => false, 
                'message' => "Connection failed: " . mysqli_connect_error(),
                'error_code' => mysqli_connect_errno()
            ];
        }
        
        // Test a simple query
        $result = mysqli_query($connection, "SELECT 1 as test");
        if (!$result) {
            mysqli_close($connection);
            return [
                'success' => false,
                'message' => "Query test failed: " . mysqli_error($connection)
            ];
        }
        
        mysqli_close($connection);
        return [
            'success' => true,
            'message' => 'Database connection successful',
            'host' => $host,
            'database' => $dbname
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Exception: ' . $e->getMessage(),
            'host' => $host,
            'database' => $dbname
        ];
    }
}

// Function to safely escape strings
function escapeString($connection, $value) {
    return mysqli_real_escape_string($connection, trim($value ?? ''));
}

// Function to insert education records
function insertEducation($connection, $resume_id, $postData) {
    // School (required)
    if (!empty($postData['school_name'])) {
        $school_name = escapeString($connection, $postData['school_name']);
        $school_duration = escapeString($connection, $postData['school_duration']);
        
        $query = "INSERT INTO education (resume_id, education_type, institution_name, duration) 
                  VALUES ($resume_id, 'school', '$school_name', '$school_duration')";
        if (!mysqli_query($connection, $query)) {
            error_log("School insert failed: " . mysqli_error($connection));
        }
    }
    
    // University
    if (!empty($postData['university_name'])) {
        $university_name = escapeString($connection, $postData['university_name']);
        $university_duration = escapeString($connection, $postData['university_duration']);
        $university_degree = escapeString($connection, $postData['university_degree']);
        
        $query = "INSERT INTO education (resume_id, education_type, institution_name, duration, degree_program) 
                  VALUES ($resume_id, 'university', '$university_name', '$university_duration', '$university_degree')";
        if (!mysqli_query($connection, $query)) {
            error_log("University insert failed: " . mysqli_error($connection));
        }
    }
    
    // College
    if (!empty($postData['college_name'])) {
        $college_name = escapeString($connection, $postData['college_name']);
        $college_duration = escapeString($connection, $postData['college_duration']);
        $college_degree = escapeString($connection, $postData['college_degree']);
        
        $query = "INSERT INTO education (resume_id, education_type, institution_name, duration, degree_program) 
                  VALUES ($resume_id, 'college', '$college_name', '$college_duration', '$college_degree')";
        if (!mysqli_query($connection, $query)) {
            error_log("College insert failed: " . mysqli_error($connection));
        }
    }
    
    // Diplomas (multiple)
    if (!empty($postData['diploma_name']) && is_array($postData['diploma_name'])) {
        for ($i = 0; $i < count($postData['diploma_name']); $i++) {
            if (!empty(trim($postData['diploma_name'][$i]))) {
                $diploma_name = escapeString($connection, $postData['diploma_name'][$i]);
                $diploma_duration = escapeString($connection, $postData['diploma_duration'][$i] ?? '');
                $diploma_institution = escapeString($connection, $postData['diploma_institution'][$i] ?? '');
                
                $query = "INSERT INTO education (resume_id, education_type, institution_name, duration, degree_program) 
                          VALUES ($resume_id, 'diploma', '$diploma_institution', '$diploma_duration', '$diploma_name')";
                if (!mysqli_query($connection, $query)) {
                    error_log("Diploma insert failed: " . mysqli_error($connection));
                }
            }
        }
    }
}

// Function to insert experience records
function insertExperience($connection, $resume_id, $postData) {
    if (!empty($postData['job_title']) && is_array($postData['job_title'])) {
        for ($i = 0; $i < count($postData['job_title']); $i++) {
            if (!empty(trim($postData['job_title'][$i]))) {
                $job_title = escapeString($connection, $postData['job_title'][$i]);
                $company_name = escapeString($connection, $postData['company_name'][$i] ?? '');
                $job_duration = escapeString($connection, $postData['job_duration'][$i] ?? '');
                $job_description = escapeString($connection, $postData['job_description'][$i] ?? '');
                
                $query = "INSERT INTO experience (resume_id, job_title, company_name, duration, job_description) 
                          VALUES ($resume_id, '$job_title', '$company_name', '$job_duration', '$job_description')";
                if (!mysqli_query($connection, $query)) {
                    error_log("Experience insert failed: " . mysqli_error($connection));
                }
            }
        }
    }
}

// Function to insert languages
function insertLanguages($connection, $resume_id, $postData) {
    if (!empty($postData['languages']) && is_array($postData['languages'])) {
        for ($i = 0; $i < count($postData['languages']); $i++) {
            if (!empty(trim($postData['languages'][$i]))) {
                $language_name = escapeString($connection, $postData['languages'][$i]);
                $proficiency = escapeString($connection, $postData['language_proficiency'][$i] ?? 'intermediate');
                
                $query = "INSERT INTO languages (resume_id, language_name, proficiency_level) 
                          VALUES ($resume_id, '$language_name', '$proficiency')";
                if (!mysqli_query($connection, $query)) {
                    error_log("Language insert failed: " . mysqli_error($connection));
                }
            }
        }
    }
}

// Function to insert projects
function insertProjects($connection, $resume_id, $postData) {
    if (!empty($postData['project_title']) && is_array($postData['project_title'])) {
        for ($i = 0; $i < count($postData['project_title']); $i++) {
            if (!empty(trim($postData['project_title'][$i]))) {
                $project_title = escapeString($connection, $postData['project_title'][$i]);
                $project_duration = escapeString($connection, $postData['project_duration'][$i] ?? '');
                $project_description = escapeString($connection, $postData['project_description'][$i] ?? '');
                $project_link = escapeString($connection, $postData['project_link'][$i] ?? '');
                
                $query = "INSERT INTO projects (resume_id, project_title, duration, project_description, project_link) 
                          VALUES ($resume_id, '$project_title', '$project_duration', '$project_description', '$project_link')";
                if (!mysqli_query($connection, $query)) {
                    error_log("Project insert failed: " . mysqli_error($connection));
                }
            }
        }
    }
}

// Function to insert achievements
function insertAchievements($connection, $resume_id, $postData) {
    error_log("=== PROCESSING ACHIEVEMENTS ===");
    error_log("Resume ID: $resume_id");
    error_log("Achievements array: " . print_r($postData['achievements'] ?? 'NOT SET', true));
    
    if (!empty($postData['achievements']) && is_array($postData['achievements'])) {
        foreach ($postData['achievements'] as $index => $achievement) {
            $achievement = trim($achievement ?? '');
            if (!empty($achievement)) {
                $achievement_esc = escapeString($connection, $achievement);
                $query = "INSERT INTO achievements (resume_id, achievement_description) VALUES ($resume_id, '$achievement_esc')";
                
                error_log("Executing achievement query: $query");
                
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    error_log("ACHIEVEMENT INSERT FAILED: " . mysqli_error($connection));
                } else {
                    error_log("ACHIEVEMENT INSERTED SUCCESSFULLY: $achievement");
                }
            } else {
                error_log("Skipping empty achievement at index $index");
            }
        }
    } else {
        error_log("No achievements data found or not an array");
        if (isset($postData['achievements'])) {
            error_log("Achievements data type: " . gettype($postData['achievements']));
        }
    }
    error_log("=== ACHIEVEMENTS PROCESSING COMPLETE ===");
}

// Function to insert references
function insertReferences($connection, $resume_id, $postData) {
    if (!empty($postData['reference_name']) && is_array($postData['reference_name'])) {
        for ($i = 0; $i < count($postData['reference_name']); $i++) {
            if (!empty(trim($postData['reference_name'][$i]))) {
                $ref_name = escapeString($connection, $postData['reference_name'][$i]);
                $ref_position = escapeString($connection, $postData['reference_position'][$i] ?? '');
                $ref_company = escapeString($connection, $postData['reference_company'][$i] ?? '');
                $ref_email = escapeString($connection, $postData['reference_email'][$i] ?? '');
                $ref_phone = escapeString($connection, $postData['reference_phone'][$i] ?? '');
                
                $query = "INSERT INTO resume_references (resume_id, reference_name, position, company, email, phone) 
                          VALUES ($resume_id, '$ref_name', '$ref_position', '$ref_company', '$ref_email', '$ref_phone')";
                if (!mysqli_query($connection, $query)) {
                    error_log("Reference insert failed: " . mysqli_error($connection));
                }
            }
        }
    }
}

// Function to get AI suggestions (Real AI integration)
function getAISuggestions($type, $context) {
    global $openai_api_key;
    
    // If you have an OpenAI API key, uncomment and use this
    /*
    if (isset($openai_api_key) && !empty($openai_api_key)) {
        return getOpenAISuggestions($type, $context, $openai_api_key);
    }
    */
    
    // Fallback to contextual templates if no API key
    return getContextualSuggestions($type, $context);
}

// Real OpenAI API integration (uncomment to use)
/*
function getOpenAISuggestions($type, $context, $api_key) {
    $field = $context['field'] ?? 'professional';
    $is_freshie = $context['is_freshie'] ?? false;
    $name = $context['name'] ?? 'Professional';
    
    $experience_level = $is_freshie ? 'entry-level' : 'experienced';
    
    if ($type === 'summary') {
        $prompt = "Generate 3 professional summary variations for an {$experience_level} {$field} professional. Each should be 2-3 sentences highlighting key strengths and career focus. Format as JSON array.";
    } else {
        $prompt = "Generate 3 career objective variations for an {$experience_level} {$field} professional. Each should be 1-2 sentences focusing on career goals. Format as JSON array.";
    }
    
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'max_tokens' => 500,
        'temperature' => 0.7
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ]
    ]);
    
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($http_code === 200 && $response) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $content = $result['choices'][0]['message']['content'];
            $suggestions = json_decode($content, true);
            return is_array($suggestions) ? $suggestions : [$content];
        }
    }
    
    // Fallback to contextual suggestions if API fails
    return getContextualSuggestions($type, $context);
}
*/

// Contextual suggestion generator (fallback)
function getContextualSuggestions($type, $context) {
    $field = $context['field'] ?? 'professional';
    $is_freshie = $context['is_freshie'] ?? false;
    $name = $context['name'] ?? 'Professional';
    
    $field_formatted = str_replace('_', ' ', $field);
    
    $templates = [
        'summary' => [
            'entry_level' => [
                "Recent graduate with strong foundation in {$field_formatted} and passion for professional growth. Eager to contribute fresh perspectives while developing practical skills in collaborative environments. Known for quick learning ability and dedication to excellence.",
                "Motivated {$field_formatted} professional with academic background and hands-on project experience. Strong analytical skills combined with creative problem-solving approach. Ready to contribute innovative solutions while advancing career in dynamic organization.",
                "Entry-level {$field_formatted} specialist with demonstrated ability through academic projects and internships. Excellent communication skills and team collaboration experience. Seeking to apply knowledge and grow within forward-thinking company."
            ],
            'experienced' => [
                "Experienced {$field_formatted} professional with proven track record of delivering results and leading successful projects. Strong technical expertise combined with leadership abilities and strategic thinking. Passionate about driving innovation and team development.",
                "Results-driven {$field_formatted} specialist with extensive background in project management and client relations. Known for problem-solving abilities and mentoring junior team members. Committed to organizational excellence and continuous improvement.",
                "Senior {$field_formatted} professional with comprehensive experience in industry best practices and emerging technologies. Expert in stakeholder management with focus on driving business growth and operational efficiency."
            ]
        ],
        'objective' => [
            'entry_level' => [
                "To secure an entry-level position in {$field_formatted} where I can apply my academic knowledge and develop practical skills while contributing to organizational success and growth.",
                "Seeking {$field_formatted} role that offers opportunities for professional development and allows me to contribute fresh perspectives to innovative projects and collaborative teams.",
                "To obtain a position in {$field_formatted} that leverages my educational background while providing growth opportunities in dynamic, results-oriented environment."
            ],
            'experienced' => [
                "To advance my career in {$field_formatted} by taking on leadership responsibilities and driving strategic initiatives that contribute to organizational success and team development.",
                "Seeking senior {$field_formatted} position where I can leverage extensive experience to mentor teams, optimize processes, and contribute to long-term business objectives.",
                "To secure a challenging role in {$field_formatted} that utilizes my proven expertise while offering opportunities for continued professional growth and industry leadership."
            ]
        ]
    ];
    
    $level = $is_freshie ? 'entry_level' : 'experienced';
    return $templates[$type][$level] ?? $templates[$type]['entry_level'];
}

// Handle AI suggestion requests
if (isset($_GET['ai_suggestions'])) {
    header('Content-Type: application/json');
    
    $type = $_GET['type'] ?? 'summary';
    $field = $_GET['field'] ?? '';
    $is_freshie = isset($_GET['is_freshie']) && $_GET['is_freshie'] === 'true';
    $name = $_GET['name'] ?? 'Professional';
    
    $context = [
        'field' => $field,
        'is_freshie' => $is_freshie,
        'name' => $name
    ];
    
    try {
        $suggestions = getAISuggestions($type, $context);
        echo json_encode([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error generating suggestions: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle connection test
if (isset($_GET['test_connection'])) {
    header('Content-Type: application/json');
    echo json_encode(testConnection());
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Log the submission attempt
    error_log("Form submission received at " . date('Y-m-d H:i:s'));
    error_log("POST data keys: " . implode(', ', array_keys($_POST)));
    
    // Test database connection first
    $connection_test = testConnection();
    if (!$connection_test['success']) {
        $response = [
            'success' => false,
            'message' => 'Database connection failed: ' . $connection_test['message']
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // Validate required fields
    $required_fields = ['full_name', 'email', 'phone', 'professional_field', 'school_name'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        $response = [
            'success' => false,
            'message' => 'Missing required fields: ' . implode(', ', $missing_fields)
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $response = [
            'success' => false,
            'message' => 'Invalid email format'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // Try to insert into database
    try {
        $connection = mysqli_connect($host, $username, $password, $dbname, $port);
        
        if (!$connection) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
        
        // Start transaction
        mysqli_autocommit($connection, FALSE);
        
        // Generate unique user ID
        $user_id = 'user_' . uniqid();
        
        // Handle file upload
        $profile_image = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $upload_dir = 'uploads/profile_images/';
            
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    error_log("Failed to create upload directory: $upload_dir");
                }
            }
            
            $file_extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($file_extension, $allowed_types) && $_FILES['profile_image']['size'] <= 5 * 1024 * 1024) {
                $new_filename = $user_id . '_profile.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                    $profile_image = $upload_path;
                }
            }
        }
        
        // Escape data for SQL injection prevention
        $user_id_esc = escapeString($connection, $user_id);
        $full_name_esc = escapeString($connection, $_POST['full_name']);
        $email_esc = escapeString($connection, $_POST['email']);
        $phone_esc = escapeString($connection, $_POST['phone']);
        $address_esc = escapeString($connection, $_POST['address'] ?? '');
        $linkedin_esc = escapeString($connection, $_POST['linkedin'] ?? '');
        $website_esc = escapeString($connection, $_POST['website'] ?? '');
        $profile_image_esc = escapeString($connection, $profile_image ?? '');
        $professional_field_esc = escapeString($connection, $_POST['professional_field']);
        $custom_field_esc = escapeString($connection, $_POST['custom_field'] ?? '');
        $professional_summary_esc = escapeString($connection, $_POST['professional_summary'] ?? '');
        $career_objective_esc = escapeString($connection, $_POST['career_objective'] ?? '');
        $is_freshie = isset($_POST['freshie']) ? 1 : 0;
        
        // Insert main record
        $query = "
            INSERT INTO resumes (
                user_id, full_name, email, phone, address, linkedin, website, 
                profile_image, professional_field, custom_field, professional_summary, 
                career_objective, is_freshie, created_at
            ) VALUES (
                '$user_id_esc', '$full_name_esc', '$email_esc', '$phone_esc', 
                '$address_esc', '$linkedin_esc', '$website_esc', '$profile_image_esc', 
                '$professional_field_esc', '$custom_field_esc', '$professional_summary_esc', 
                '$career_objective_esc', $is_freshie, NOW()
            )
        ";
        
        $result = mysqli_query($connection, $query);
        
        if (!$result) {
            throw new Exception("Main insert failed: " . mysqli_error($connection));
        }
        
        $resume_id = mysqli_insert_id($connection);
        error_log("Resume inserted with ID: $resume_id");
        
        // Insert skills if provided
        if (!empty($_POST['skills']) && is_array($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill) {
                if (!empty(trim($skill))) {
                    $skill_esc = escapeString($connection, trim($skill));
                    $skill_query = "INSERT INTO skills (resume_id, skill_name) VALUES ($resume_id, '$skill_esc')";
                    if (!mysqli_query($connection, $skill_query)) {
                        error_log("Skill insert failed: " . mysqli_error($connection));
                    }
                }
            }
        }
        
        // Insert education data
        insertEducation($connection, $resume_id, $_POST);
        error_log("Education data processed");
        
        // Insert experience data (only if not freshie)
        if (!$is_freshie) {
            insertExperience($connection, $resume_id, $_POST);
            error_log("Experience data processed");
        }
        
        // Insert languages
        insertLanguages($connection, $resume_id, $_POST);
        error_log("Languages processed");

        
        // Insert projects
        insertProjects($connection, $resume_id, $_POST);
        error_log("Projects processed");
        
        // Insert achievements - ENHANCED LOGGING
        error_log("About to process achievements...");
        insertAchievements($connection, $resume_id, $_POST);
        error_log("Achievements processing completed");
        
        // Insert references
        insertReferences($connection, $resume_id, $_POST);
        error_log("References processed");
        
        // Commit transaction
        mysqli_commit($connection);
        mysqli_close($connection);
        
        // Success response
        $response = [
            'success' => true,
            'message' => 'Resume submitted successfully! All data has been saved.',
            'resume_id' => $resume_id,
            'user_id' => $user_id,
            'redirect_url' => "preview.php?resume_id=$resume_id" // Optional redirect URL
        ];
        
        error_log("Resume submitted successfully - ID: $resume_id");
        
        header('Content-Type: application/json');
        echo json_encode($response);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        if (isset($connection)) {
            mysqli_rollback($connection);
            mysqli_close($connection);
        }
        
        error_log("Database error: " . $e->getMessage());
        
        $response = [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    exit;
}

// If not POST request, show info
echo "<!DOCTYPE html>
<html>
<head>
    <title>Resume Submission Handler</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .status { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .test-btn { background: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; }
        .test-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Resume Submission Handler</h1>
    <div class='info'>
        <strong>Status:</strong> Ready to receive form submissions<br>
        <strong>Current time:</strong> " . date('Y-m-d H:i:s') . "<br>
        <strong>PHP Version:</strong> " . PHP_VERSION . "
    </div>
    
    <h3>Database Connection Test:</h3>
    <div id='connection-result'>
        <button class='test-btn' onclick='testConnection()'>Test Connection</button>
    </div>
    
    <h3>AI Suggestions Test:</h3>
    <div id='ai-result'>
        <button class='test-btn' onclick='testAI()'>Test AI Suggestions</button>
    </div>
    
    <h3>Available Endpoints:</h3>
    <ul>
        <li><code>POST /</code> - Submit resume form</li>
        <li><code>GET /?test_connection=1</code> - Test database connection</li>
        <li><code>GET /?ai_suggestions=1&amp;type=summary&amp;field=software_developer</code> - Get AI suggestions</li>
    </ul>
    
    <h3>Database Schema Required:</h3>
    <pre>
-- Main resumes table
CREATE TABLE resumes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(50) UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    address TEXT,
    linkedin VARCHAR(255),
    website VARCHAR(255),
    profile_image VARCHAR(255),
    professional_field VARCHAR(100) NOT NULL,
    custom_field VARCHAR(255),
    professional_summary TEXT,
    career_objective TEXT,
    is_freshie BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Education table
CREATE TABLE education (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    education_type ENUM('school', 'university', 'college', 'diploma'),
    institution_name VARCHAR(255),
    duration VARCHAR(100),
    degree_program VARCHAR(255),
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- Experience table
CREATE TABLE experience (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    job_title VARCHAR(255),
    company_name VARCHAR(255),
    duration VARCHAR(100),
    job_description TEXT,
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- Skills table
CREATE TABLE skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    skill_name VARCHAR(255),
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- Languages table
CREATE TABLE languages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    language_name VARCHAR(255),
    proficiency_level ENUM('beginner', 'intermediate', 'advanced', 'native'),
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- Projects table
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    project_title VARCHAR(255),
    duration VARCHAR(100),
    project_description TEXT,
    project_link VARCHAR(255),
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- Achievements table
CREATE TABLE achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    achievement_description TEXT,
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);

-- References table
CREATE TABLE resume_references (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resume_id INT,
    reference_name VARCHAR(255),
    position VARCHAR(255),
    company VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE
);
    </pre>
    
    <script>
        function testConnection() {
            const resultDiv = document.getElementById('connection-result');
            resultDiv.innerHTML = '<div class=\"info\">Testing connection...</div>';
            
            fetch('?test_connection=1')
                .then(response => response.json())
                .then(data => {
                    const statusClass = data.success ? 'success' : 'error';
                    resultDiv.innerHTML = 
                        '<div class=\"' + statusClass + '\">' +
                        '<strong>' + (data.success ? 'SUCCESS' : 'FAILED') + '</strong><br>' +
                        'Message: ' + data.message + '<br>' +
                        (data.host ? 'Host: ' + data.host + '<br>' : '') +
                        (data.database ? 'Database: ' + data.database : '') +
                        '</div>';
                })
                .catch(error => {
                    resultDiv.innerHTML = 
                        '<div class=\"error\">' +
                        '<strong>ERROR:</strong> ' + error.message +
                        '</div>';
                });
        }
        
        function testAI() {
            const resultDiv = document.getElementById('ai-result');
            resultDiv.innerHTML = '<div class=\"info\">Testing AI suggestions...</div>';
            
            fetch('?ai_suggestions=1&type=summary&field=software_developer&is_freshie=false&name=Test User')
                .then(response => response.json())
                .then(data => {
                    const statusClass = data.success ? 'success' : 'error';
                    let content = '<div class=\"' + statusClass + '\">' +
                        '<strong>' + (data.success ? 'SUCCESS' : 'FAILED') + '</strong><br>';
                    
                    if (data.success && data.suggestions) {
                        content += 'Generated ' + data.suggestions.length + ' suggestions:<br>';
                        data.suggestions.forEach((suggestion, index) => {
                            content += '<br><strong>Option ' + (index + 1) + ':</strong><br>' + 
                                      suggestion.substring(0, 100) + '...';
                        });
                    } else if (data.message) {
                        content += 'Message: ' + data.message;
                    }
                    
                    content += '</div>';
                    resultDiv.innerHTML = content;
                })
                .catch(error => {
                    resultDiv.innerHTML = 
                        '<div class=\"error\">' +
                        '<strong>ERROR:</strong> ' + error.message +
                        '</div>';
                });
        }
        
        // Auto-test connection on page load
        window.onload = function() {
            testConnection();
        };
    </script>
</body>
</html>";
?>