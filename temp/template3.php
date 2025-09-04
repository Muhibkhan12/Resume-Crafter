<?php
// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the latest resume
$sql = "SELECT * FROM resumes ORDER BY id DESC LIMIT 1";
$run = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($run);

if (!$row) {
    die("No resume data found");
}

$resume_id = $row['id'];

// Get data efficiently
$achievements = [];
$sql1 = "SELECT * FROM achievements WHERE resume_id = $resume_id";
$run1 = mysqli_query($conn, $sql1);
while ($achievement = mysqli_fetch_assoc($run1)) {
    $achievements[] = $achievement;
}

$education = [];
$sql2 = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY id DESC";
$run2 = mysqli_query($conn, $sql2);
while ($edu = mysqli_fetch_assoc($run2)) {
    $education[] = $edu;
}

$experience = [];
$sql3 = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY id DESC";
$run3 = mysqli_query($conn, $sql3);
while ($exp = mysqli_fetch_assoc($run3)) {
    $experience[] = $exp;
}

$languages = [];
$sql4 = "SELECT * FROM languages WHERE resume_id = $resume_id";
$run4 = mysqli_query($conn, $sql4);
while ($lang = mysqli_fetch_assoc($run4)) {
    $languages[] = $lang;
}

$projects = [];
$sql5 = "SELECT * FROM projects WHERE resume_id = $resume_id ORDER BY id DESC";
$run5 = mysqli_query($conn, $sql5);
while ($project = mysqli_fetch_assoc($run5)) {
    $projects[] = $project;
}

$references = [];
$sql6 = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
$run6 = mysqli_query($conn, $sql6);
while ($ref = mysqli_fetch_assoc($run6)) {
    $references[] = $ref;
}

$skills = [];
$sql7 = "SELECT * FROM skills WHERE resume_id = $resume_id";
$run7 = mysqli_query($conn, $sql7);
while ($skill = mysqli_fetch_assoc($run7)) {
    $skills[] = $skill;
}

function formatProfessionalField($field) {
    return ucwords(str_replace('_', ' ', $field));
}

// Check if we're generating a PDF
$is_pdf = isset($_GET['pdf']) && $_GET['pdf'] == 1;

// Include Dompdf at the top level
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// If generating PDF, start output buffering
if ($is_pdf) {
    ob_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* DomPDF compatible CSS */
        @page {
            margin: 15mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif; /* Use web-safe fonts */
            line-height: 1.5;
            color: #333;
            font-size: 11pt;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .cv-container {
            width: 100%;
            max-width: 100%;
        }

        .header {
            background: #2c3e50; /* Solid color instead of gradient for better PDF support */
            background-image: linear-gradient(135deg, #2c3e50, #4a6491); /* Fallback for browsers that support it */
            padding: 20px;
            text-align: center;
            color: white;
            margin-bottom: 15px;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 15px;
            background: #f5f5f5;
            text-align: center;
            font-size: 25px;
            color: #4a6491;
            overflow: hidden;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .title {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .contact-info {
            font-size: 10px;
        }

        .contact-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 10px;
            margin: 2px 5px;
            display: inline-block;
        }

        .main-content {
            padding: 15px;
        }

        .main-columns {
            width: 100%;
            display: block;
        }

        .left-column {
            width: 65%;
            float: left;
            padding-right: 20px;
        }

        .right-column {
            width: 35%;
            float: right;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eaeaea;
            position: relative;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 40px;
            height: 2px;
            background: #4a6491;
        }

        .profile-text {
            font-size: 11px;
            line-height: 1.6;
            color: #444;
        }

        .timeline {
            position: relative;
            padding-left: 15px;
            margin-left: 8px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 0;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background: #e0e0e0;
        }

        .item {
            position: relative;
            margin-bottom: 15px;
            padding: 12px;
            background: #ffffff;
            border-radius: 5px;
            border-left: 2px solid transparent;
        }

        .item::before {
            content: "";
            position: absolute;
            left: -20px;
            top: 15px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4a6491;
            border: 2px solid white;
        }

        .item-header {
            margin-bottom: 8px;
        }

        .item-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .item-subtitle {
            font-size: 11px;
            color: #4a6491;
            font-weight: 500;
        }

        .item-duration {
            font-size: 10px;
            color: #777;
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 500;
            display: inline-block;
            margin-top: 3px;
        }

        .item-description {
            font-size: 11px;
            color: #555;
            margin-top: 8px;
            line-height: 1.5;
        }

        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eaeaea;
        }

        .skills-grid {
            margin-top: 5px;
        }

        .skill-tag {
            background: #f8f9fa;
            color: #4a6491;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 6px;
            margin-right: 4px;
            display: inline-block;
            position: relative;
            border: 1px solid #e9ecef;
        }

        .skill-tag::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #4a6491;
        }

        .education-item {
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 8px;
            border-left: 2px solid #4a6491;
        }

        .degree {
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .university {
            font-size: 10px;
            color: #555;
            margin-bottom: 3px;
        }

        .edu-date {
            font-size: 9px;
            color: #777;
            margin-bottom: 3px;
        }

        .edu-details {
            font-size: 9px;
            line-height: 1.4;
            color: #666;
        }

        .achievements li {
            position: relative;
            padding-left: 12px;
            margin-bottom: 5px;
            font-size: 10px;
            line-height: 1.4;
            color: #555;
            list-style: none;
        }

        .achievements li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4a6491;
            font-weight: bold;
        }

        .project-status {
            display: inline-block;
            background: #e8f5e8;
            color: #2e7d32;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 500;
            margin-top: 5px;
        }

        .freshie-notice {
            background: #fff9f9;
            border-left: 3px solid #ff6b6b;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
        }

        .freshie-title {
            font-size: 11px;
            font-weight: bold;
            color: #ff6b6b;
            margin-bottom: 8px;
        }

        .freshie-text {
            font-size: 10px;
            color: #555;
            line-height: 1.5;
        }

        .languages {
            margin-top: 5px;
        }

        .language-item {
            background: #f8f9fa;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            margin-bottom: 5px;
            margin-right: 5px;
            display: inline-block;
            border: 1px solid #e9ecef;
        }
        
        /* PDF download button styling */
        .pdf-download {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4a6491;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .pdf-download:hover {
            background: #2c3e50;
        }
        
        /* Hide download button in PDF */
        @media print {
            .pdf-download {
                display: none;
            }
        }
        
        /* Clearfix for columns */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    
    <div class="cv-container">
        <header class="header">
            <div class="profile-image">
                <?php if (!empty($row['profile_image']) && file_exists($row['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile">
                <?php else: ?>
                    👤
                <?php endif; ?>
            </div>
            <h1 class="name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
            <div class="title"><?php echo formatProfessionalField($row['professional_field']); ?></div>
            
            <div class="contact-info">
                <div class="contact-item">
                    📧 <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <div class="contact-item">
                    📱 <?php echo htmlspecialchars($row['phone']); ?>
                </div>
                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    📍 <?php echo htmlspecialchars($row['address']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($row['linkedin'])): ?>
                <div class="contact-item">
                    🔗 LinkedIn
                </div>
                <?php endif; ?>
                <?php if (!empty($row['website'])): ?>
                <div class="contact-item">
                    🌐 Portfolio
                </div>
                <?php endif; ?>
            </div>
        </header>

        <div class="main-content">
            <?php if (!empty($row['professional_summary'])): ?>
                <section class="section">
                    <h2 class="section-title">🎯 Professional Summary</h2>
                    <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?></p>
                </section>
            <?php endif; ?>

            <?php if (!empty($row['career_objective'])): ?>
                <section class="section">
                    <h2 class="section-title">🎯 Career Objective</h2>
                    <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['career_objective'])); ?></p>
                </section>
            <?php endif; ?>

            <div class="main-columns clearfix">
                <div class="left-column">
                    <?php if (!empty($experience)): ?>
                        <section class="section">
                            <h2 class="section-title">💼 Work Experience</h2>
                            <div class="timeline">
                                <?php foreach ($experience as $exp): ?>
                                <div class="item">
                                    <div class="item-header">
                                        <div class="item-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                                        <?php if (!empty($exp['company_name'])): ?>
                                            <div class="item-subtitle"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($exp['duration'])): ?>
                                            <div class="item-duration"><?php echo htmlspecialchars($exp['duration']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($exp['job_description'])): ?>
                                        <p class="item-description"><?php echo nl2br(htmlspecialchars($exp['job_description'])); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($projects)): ?>
                        <section class="section">
                            <h2 class="section-title">📁 Key Projects</h2>
                            <div class="timeline">
                                <?php foreach ($projects as $project): ?>
                                <div class="item">
                                    <div class="item-header">
                                        <div class="item-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                                        <div class="item-subtitle">Status: <?php echo ucfirst($project['project_status']); ?></div>
                                        <?php if (!empty($project['duration'])): ?>
                                            <div class="item-duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($project['project_description'])): ?>
                                        <p class="item-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if (!empty($achievements)): ?>
                        <section class="section">
                            <h2 class="section-title">🏆 Achievements</h2>
                            <div class="timeline">
                                <?php foreach ($achievements as $achievement): ?>
                                <div class="item">
                                    <p class="item-description"><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if ($row['is_freshie'] == 1): ?>
                    <div class="freshie-notice">
                        <div class="freshie-title">🎓 Fresh Graduate</div>
                        <p class="freshie-text">
                            As a fresh graduate, I bring enthusiasm, up-to-date knowledge, and a strong willingness to learn 
                            and contribute to your organization. I am eager to apply my academic knowledge in a professional 
                            environment and grow with the company.
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="right-column">
                    <?php if (!empty($skills)): ?>
                        <section class="sidebar-section">
                            <h2 class="sidebar-title">⭐ Skills</h2>
                            <div class="skills-grid">
                                <?php foreach ($skills as $skill): ?>
                                <div class="skill-tag"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($education)): ?>
                        <section class="sidebar-section">
                            <h3 class="sidebar-title">🎓 Education</h3>
                            <?php foreach ($education as $edu): ?>
                            <div class="education-item">
                                <?php if (!empty($edu['degree_program'])): ?>
                                    <div class="degree"><?php echo htmlspecialchars($edu['degree_program']); ?></div>
                                <?php else: ?>
                                    <div class="degree"><?php echo ucfirst($edu['education_type']); ?></div>
                                <?php endif; ?>
                                <div class="university"><?php echo htmlspecialchars($edu['institution_name']); ?></div>
                                <?php if (!empty($edu['duration'])): ?>
                                    <div class="edu-date"><?php echo htmlspecialchars($edu['duration']); ?></div>
                                <?php endif; ?>
                                <div class="edu-details"><?php echo ucfirst($edu['education_type']); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($languages)): ?>
                        <section class="sidebar-section">
                            <h3 class="sidebar-title">🌐 Languages</h3>
                            <div class="languages">
                                <?php foreach ($languages as $language): ?>
                                <div class="language-item">
                                    <?php echo htmlspecialchars($language['language_name']); ?> 
                                    (<?php echo ucfirst($language['proficiency_level']); ?>)
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if (!empty($references)): ?>
                        <section class="sidebar-section">
                            <h3 class="sidebar-title">👥 References</h3>
                            <?php foreach ($references as $reference): ?>
                            <div class="education-item">
                                <div class="degree"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                                <?php if (!empty($reference['position'])): ?>
                                    <div class="university"><?php echo htmlspecialchars($reference['position']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($reference['company'])): ?>
                                    <div class="edu-date"><?php echo htmlspecialchars($reference['company']); ?></div>
                                <?php endif; ?>
                                <div class="edu-details">
                                    <?php if (!empty($reference['email'])): ?>
                                        📧 <?php echo htmlspecialchars($reference['email']); ?>
                                    <?php endif; ?>
                                    <?php if (!empty($reference['phone'])): ?>
                                        <?php if (!empty($reference['email'])) echo '<br>'; ?>
                                        📱 <?php echo htmlspecialchars($reference['phone']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Generate PDF if requested
if ($is_pdf) {
    $html = ob_get_clean();
    
    // Load HTML into Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html);
    
    // Render the PDF
    $dompdf->render();
    
    // Output the generated PDF
    $dompdf->stream('resume.pdf', array('Attachment' => 1));
    exit;
}

mysqli_close($conn);
?>