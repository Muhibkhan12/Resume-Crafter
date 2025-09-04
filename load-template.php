<?php
header('Content-Type: application/json');

// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['user_id']) || !isset($input['template'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request data']);
    exit;
}

$user_id = intval($input['user_id']);
$template = $input['template'];

// Validate template
$allowed_templates = ['template1', 'template2', 'template3', 'template4', 'template5'];
if (!in_array($template, $allowed_templates)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid template']);
    exit;
}

// Check if template file exists
$template_file = "templates/{$template}.php";
if (!file_exists($template_file)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Template file not found']);
    exit;
}

// Fetch resume data
$sql = "SELECT * FROM resumes WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'No resume found for this user']);
    exit;
}

$resume = mysqli_fetch_assoc($result);

// Decode JSON fields
$diplomas = !empty($resume['diplomas']) ? json_decode($resume['diplomas'], true) : [];
$experience = !empty($resume['experience']) ? json_decode($resume['experience'], true) : [];
$skills = !empty($resume['skills']) ? json_decode($resume['skills'], true) : [];

// Capture template output
ob_start();
try {
    include $template_file;
    $template_html = ob_get_clean();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'html' => $template_html,
        'template' => $template,
        'message' => 'Template loaded successfully'
    ]);
    
} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error loading template: ' . $e->getMessage()
    ]);
}

// Optional: Save user's template preference to database
try {
    $update_sql = "UPDATE resumes SET preferred_template = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "si", $template, $user_id);
    mysqli_stmt_execute($update_stmt);
} catch (Exception $e) {
    // Log error but don't fail the request
    error_log("Failed to save template preference: " . $e->getMessage());
}

mysqli_close($conn);
?>