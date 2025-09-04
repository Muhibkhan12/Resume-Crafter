<?php
session_start();

// Load Dompdf manually (without Composer)
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get parameters
$resume_id = isset($_GET['resume_id']) ? intval($_GET['resume_id']) : 0;
$template = $_GET['template'] ?? 'template1';

if ($resume_id === 0) {
    die("Invalid resume ID");
}

// Fetch resume data
$sql = "SELECT * FROM resumes WHERE id = $resume_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No resume found for this user.");
}

$resume = mysqli_fetch_assoc($result);

// Decode JSON fields
$diplomas = !empty($resume['diplomas']) ? json_decode($resume['diplomas'], true) : [];
$experience = !empty($resume['experience']) ? json_decode($resume['experience'], true) : [];
$skills = !empty($resume['skills']) ? json_decode($resume['skills'], true) : [];

// Generate HTML content for the resume
ob_start();
include "temp/{$template}.php";
$html = ob_get_clean();

// Configure Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);

// Load HTML content
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Get the generated PDF content
$pdfContent = $dompdf->output();

// Set headers for download
$filename = "resume_" . preg_replace('/[^a-zA-Z0-9]/', '_', $resume['full_name']) . ".pdf";

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($pdfContent));

// Output the PDF
echo $pdfContent;

exit;
?>