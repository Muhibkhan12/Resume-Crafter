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

// Get resume_id for fetching related data
$resume_id = $row['id'] ?? 0;

// Get all achievements for this resume
$sql1 = "SELECT * FROM achievements WHERE resume_id = $resume_id ORDER BY id DESC";
$run1 = mysqli_query($conn, $sql1);
$achievements = [];
while($achievement = mysqli_fetch_assoc($run1)) {
    $achievements[] = $achievement;
}

// Get all education for this resume
$sql2 = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY id DESC";
$run2 = mysqli_query($conn, $sql2);
$educations = [];
while($education = mysqli_fetch_assoc($run2)) {
    $educations[] = $education;
}

// Get all experience for this resume
$sql3 = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY id DESC";
$run3 = mysqli_query($conn, $sql3);
$experiences = [];
while($experience = mysqli_fetch_assoc($run3)) {
    $experiences[] = $experience;
}

// Get all languages for this resume
$sql4 = "SELECT * FROM languages WHERE resume_id = $resume_id ORDER BY id DESC";
$run4 = mysqli_query($conn, $sql4);
$languages = [];
while($language = mysqli_fetch_assoc($run4)) {
    $languages[] = $language;
}

// Get all projects for this resume
$sql5 = "SELECT * FROM projects WHERE resume_id = $resume_id ORDER BY id DESC";
$run5 = mysqli_query($conn, $sql5);
$projects = [];
while($project = mysqli_fetch_assoc($run5)) {
    $projects[] = $project;
}

// Get all references for this resume
$sql6 = "SELECT * FROM resume_references WHERE resume_id = $resume_id ORDER BY id DESC";
$run6 = mysqli_query($conn, $sql6);
$references = [];
while($reference = mysqli_fetch_assoc($run6)) {
    $references[] = $reference;
}

// Get all skills for this resume
$sql7 = "SELECT * FROM skills WHERE resume_id = $resume_id ORDER BY id DESC";
$run7 = mysqli_query($conn, $sql7);
$skills = [];
while($skill = mysqli_fetch_assoc($run7)) {
    $skills[] = $skill;
}

// Helper function to format professional field
function formatProfessionalField($field) {
    return ucwords(str_replace('_', ' ', $field));
}

// Helper function to capitalize proficiency level
function formatProficiency($level) {
    return ucfirst($level);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['full_name'] ?? 'Professional CV'); ?></title>
    <style>
        /* DomPDF compatible CSS - using only supported properties */
        @page {
            margin: 0.2in;
            size: letter;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            color: #2d3748;
            line-height: 1.4;
            padding: 0;
            background: #ffffff;
            font-size: 11px;
        }

        .cv-container {
            width: 100%;
            background: #ffffff;
            height: 100%;
            display: block;
        }

        /* Header */
        .header {
            background: #2563eb;
            color: white;
            padding: 25px 20px;
            text-align: center;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .title {
            font-size: 14px;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #e2e8f0;
        }

        /* Main Content */
        .main-content {
            display: block;
        }

        /* Two-column layout using floats */
        .left-column {
            width: 40%;
            float: left;
            padding: 20px;
            background: #f8fafc;
        }

        .right-column {
            width: 60%;
            float: right;
            padding: 20px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 25px;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 12px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 4px;
        }

        /* Items */
        .item {
            background: #ffffff;
            border-radius: 5px;
            margin-bottom: 12px;
            padding: 15px;
            border-left: 3px solid #2563eb;
        }

        .item-type {
            font-size: 10px;
            color: #4c51bf;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .item-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .item-subtitle {
            font-size: 11px;
            color: #4a5568;
            margin-bottom: 8px;
            font-style: italic;
        }

        .item-description {
            font-size: 11px;
            color: #4a5568;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .item-duration {
            display: inline-block;
            background: #dbeafe;
            color: #2563eb;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 12px;
        }

        /* Skills Section */
        .skills-list {
            list-style: none;
        }

        .skill-item {
            font-size: 11px;
            color: #4a5568;
            margin-bottom: 8px;
            padding-left: 18px;
            position: relative;
            display: flex;
            justify-content: space-between;
        }

        .skill-item::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #2563eb;
            font-size: 16px;
        }

        .skill-level {
            font-size: 10px;
            color: #2563eb;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Language Section */
        .language-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .language-item:last-child {
            border-bottom: none;
        }

        .language-name {
            font-size: 11px;
            color: #4a5568;
            font-weight: bold;
        }

        .language-level {
            font-size: 10px;
            color: #2563eb;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Text content */
        .summary-text, .objective-text {
            font-size: 11px;
            color: #4a5568;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        /* Freshie Notice */
        .freshie-notice {
            background: #dbeafe;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            margin-top: 15px;
            border: 1px solid #bfdbfe;
        }

        .freshie-title {
            font-size: 13px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .freshie-text {
            font-size: 11px;
            color: #4a5568;
            line-height: 1.4;
        }

        /* Reference Item */
        .reference-item {
            background: #ffffff;
            border-radius: 5px;
            margin-bottom: 12px;
            padding: 12px;
            border-left: 3px solid #2563eb;
        }

        .reference-name {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .reference-position {
            font-size: 11px;
            color: #4a5568;
            margin-bottom: 3px;
        }

        .reference-contact {
            font-size: 10px;
            color: #6b7280;
            margin-top: 5px;
        }

        /* No Data Message */
        .no-data {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 15px;
            font-size: 11px;
        }

        /* Utility classes */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        /* PDF download button styling */
        .pdf-download {
            position: fixed;
            top: 12px;
            right: 12px;
            background: #4a6491;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            z-index: 1000;
            font-size: 11px;
            font-weight: bold;
        }
        
        /* Hide download button in PDF */
        @media print {
            .pdf-download {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <!-- Header -->
        <header class="header">
            <h1 class="name"><?php echo htmlspecialchars($row['full_name'] ?? 'Your Name'); ?></h1>
            <div class="title">
                <?php echo htmlspecialchars(formatProfessionalField($row['professional_field'] ?? 'Professional')); ?>
                <?php if (!empty($row['custom_field'])): ?>
                    - <?php echo htmlspecialchars($row['custom_field']); ?>
                <?php endif; ?>
            </div>
            
            <div class="contact-info">
                <?php if (!empty($row['email'])): ?>
                <div class="contact-item">
                    <span>✉</span>
                    <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($row['phone'])): ?>
                <div class="contact-item">
                    <span>📞</span>
                    <?php echo htmlspecialchars($row['phone']); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    <span>📍</span>
                    <?php echo htmlspecialchars($row['address']); ?>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content clearfix">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Education -->
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">🎓</div>
                        <h2 class="section-title">Education</h2>
                    </div>
                    
                    <?php if (!empty($educations)): ?>
                        <?php foreach ($educations as $education): ?>
                        <div class="item">
                            <div class="item-type"><?php echo htmlspecialchars(ucfirst($education['education_type'])); ?></div>
                            <div class="item-title"><?php echo htmlspecialchars($education['institution_name']); ?></div>
                            <?php if (!empty($education['degree_program'])): ?>
                            <div class="item-subtitle"><?php echo htmlspecialchars($education['degree_program']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($education['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($education['duration']); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-data">No education information available</div>
                    <?php endif; ?>
                </section>

                <!-- Skills -->
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">⚙️</div>
                        <h2 class="section-title">Skills</h2>
                    </div>
                    
                    <?php if (!empty($skills)): ?>
                        <ul class="skills-list">
                            <?php foreach ($skills as $skill): ?>
                            <li class="skill-item">
                                <span><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                <span class="skill-level"><?php echo formatProficiency($skill['skill_level']); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="no-data">No skills information available</div>
                    <?php endif; ?>
                </section>

                <!-- Languages -->
                <?php if (!empty($languages)): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">🌐</div>
                        <h2 class="section-title">Languages</h2>
                    </div>
                    
                    <?php foreach ($languages as $language): ?>
                    <div class="language-item">
                        <span class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></span>
                        <span class="language-level"><?php echo formatProficiency($language['proficiency_level']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>
            </div>
            
            <!-- Right Column -->
            <div class="right-column">
                <!-- Professional Summary -->
                <?php if (!empty($row['professional_summary'])): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">👤</div>
                        <h2 class="section-title">Professional Summary</h2>
                    </div>
                    
                    <div class="summary-text">
                        <?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Career Objective -->
                <?php if (!empty($row['career_objective'])): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">🎯</div>
                        <h2 class="section-title">Career Objective</h2>
                    </div>
                    
                    <div class="objective-text">
                        <?php echo nl2br(htmlspecialchars($row['career_objective'])); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Experience -->
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">💼</div>
                        <h2 class="section-title">Experience</h2>
                    </div>
                    
                    <?php if (!empty($experiences)): ?>
                        <?php foreach ($experiences as $experience): ?>
                        <div class="item">
                            <div class="item-title"><?php echo htmlspecialchars($experience['job_title']); ?></div>
                            <?php if (!empty($experience['company_name'])): ?>
                            <div class="item-subtitle"><?php echo htmlspecialchars($experience['company_name']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($experience['job_description'])): ?>
                            <div class="item-description"><?php echo nl2br(htmlspecialchars($experience['job_description'])); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($experience['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($experience['duration']); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Check if user is a freshie -->
                        <?php if ($row['is_freshie'] == 1): ?>
                        <div class="freshie-notice">
                            <div class="freshie-title">Recent Graduate</div>
                            <div class="freshie-text">
                                Enthusiastic and motivated recent graduate ready to apply theoretical knowledge and innovative thinking to real-world challenges. Eager to contribute to meaningful projects and grow professionally in a dynamic environment.
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="no-data">No work experience information available</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </section>

                <!-- Projects -->
                <?php if (!empty($projects)): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">📁</div>
                        <h2 class="section-title">Projects</h2>
                    </div>
                    
                    <?php foreach ($projects as $project): ?>
                    <div class="item">
                        <div class="item-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                        <?php if (!empty($project['project_description'])): ?>
                        <div class="item-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></div>
                        <?php endif; ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                            <?php if (!empty($project['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($project['project_status'])): ?>
                        <div style="margin-top: 8px;">
                            <span style="font-size: 10px; color: <?php echo $project['project_status'] == 'completed' ? '#10b981' : ($project['project_status'] == 'ongoing' ? '#f59e0b' : '#6b7280'); ?>; font-weight: bold; text-transform: uppercase;">
                                <?php echo htmlspecialchars($project['project_status']); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>

                <!-- Achievements -->
                <?php if (!empty($achievements)): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">🏆</div>
                        <h2 class="section-title">Achievements</h2>
                    </div>
                    
                    <?php foreach ($achievements as $achievement): ?>
                    <div class="item">
                        <div class="item-description"><?php echo nl2br(htmlspecialchars($achievement['achievement_description'])); ?></div>
                    </div>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>

                <!-- References -->
                <?php if (!empty($references)): ?>
                <section class="section">
                    <div class="section-header">
                        <div class="section-icon">👥</div>
                        <h2 class="section-title">References</h2>
                    </div>
                    
                    <?php foreach ($references as $reference): ?>
                    <div class="reference-item">
                        <div class="reference-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                        <?php if (!empty($reference['position'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['position']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['company'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['company']); ?></div>
                        <?php endif; ?>
                        <div class="reference-contact">
                            <?php if (!empty($reference['email'])): ?>
                            <span>✉</span> <?php echo htmlspecialchars($reference['email']); ?>
                            <?php endif; ?>
                            <?php if (!empty($reference['phone'])): ?>
                            <br><span>📞</span> <?php echo htmlspecialchars($reference['phone']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>
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

// Close database connection
mysqli_close($conn);
?>