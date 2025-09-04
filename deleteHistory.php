<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_email = $_SESSION['email'] ?? '';
if (!$user_email) {
    die("⚠ Please log in first.");
}

$resume_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;
$template  = $_GET['template'] ?? '';

if ($resume_id > 0 && $template !== '') {
    // ✅ Delete history only if it belongs to logged-in user
    $sql = "
        DELETE h 
        FROM history h
        JOIN resumes r ON h.resume_id = r.id
        WHERE h.resume_id = $resume_id 
          AND h.template = '$template'
          AND r.email = '$user_email'
    ";
    mysqli_query($conn, $sql) or die("Delete Error: " . mysqli_error($conn));
}

header("Location: history.php");
exit();
