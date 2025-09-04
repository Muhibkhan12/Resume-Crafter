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

// Get achievements for this resume
$sql1 = "SELECT * FROM achievements WHERE resume_id = $resume_id";
$run1 = mysqli_query($conn, $sql1);
$achievements = [];
while ($achievement = mysqli_fetch_assoc($run1)) {
    $achievements[] = $achievement;
}

// Get education for this resume
$sql2 = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY id DESC";
$run2 = mysqli_query($conn, $sql2);
$education = [];
while ($edu = mysqli_fetch_assoc($run2)) {
    $education[] = $edu;
}

// Get experience for this resume
$sql3 = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY id DESC";
$run3 = mysqli_query($conn, $sql3);
$experience = [];
while ($exp = mysqli_fetch_assoc($run3)) {
    $experience[] = $exp;
}

// Get languages for this resume
$sql4 = "SELECT * FROM languages WHERE resume_id = $resume_id";
$run4 = mysqli_query($conn, $sql4);
$languages = [];
while ($lang = mysqli_fetch_assoc($run4)) {
    $languages[] = $lang;
}

// Get projects for this resume
$sql5 = "SELECT * FROM projects WHERE resume_id = $resume_id ORDER BY id DESC";
$run5 = mysqli_query($conn, $sql5);
$projects = [];
while ($project = mysqli_fetch_assoc($run5)) {
    $projects[] = $project;
}

// Get references for this resume
$sql6 = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
$run6 = mysqli_query($conn, $sql6);
$resume_references = [];
while ($ref = mysqli_fetch_assoc($run6)) {
    $resume_references[] = $ref;
}

// Get skills for this resume
$sql7 = "SELECT * FROM skills WHERE resume_id = $resume_id";
$run7 = mysqli_query($conn, $sql7);
$skills = [];
while ($skill = mysqli_fetch_assoc($run7)) {
    $skills[] = $skill;
}

// Helper functions
function formatProfessionalField($field) {
    return ucwords(str_replace('_', ' ', $field));
}

function getSkillPercentage($level) {
    switch($level) {
        case 'beginner': return 25;
        case 'intermediate': return 50;
        case 'advanced': return 80;
        case 'expert': return 95;
        default: return 50;
    }
}

function formatLanguageLevel($level) {
    switch($level) {
        case 'native': return 'Native';
        case 'advanced': return 'Advanced';
        case 'intermediate': return 'Intermediate';
        case 'beginner': return 'Beginner';
        default: return ucfirst($level);
    }
}

// Calculate some statistics
$total_experience = count($experience);
$total_education = count($education);
$total_skills = count($skills);
$total_projects = count($projects);

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
    <title>Professional CV | <?php echo htmlspecialchars($row['full_name']); ?></title>
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

        /* Two-column layout */
        .sidebar {
            width: 35%;
            float: left;
            background: #2c3e50;
            color: #f8f9fa;
            padding: 15px;
            min-height: 10.6in;
        }

        .main-content {
            width: 65%;
            float: right;
            padding: 15px 20px;
            background: #ffffff;
        }

        /* Profile Section */
        .profile {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #3498db;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: white;
        }

        .title {
            font-size: 12px;
            color: #bdc3c7;
            margin-bottom: 10px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #ecf0f1;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
        }

        .main-section-title {
            font-size: 15px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
            text-transform: uppercase;
        }

        /* Contact Section */
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 10px;
            color: #e2e8f0;
        }

        .contact-icon {
            width: 14px;
            margin-right: 8px;
            color: #3498db;
            font-weight: bold;
            text-align: center;
        }

        /* Skills Section */
        .skill {
            margin-bottom: 12px;
        }

        .skill-name {
            display: block;
            margin-bottom: 4px;
            font-size: 10px;
        }

        .skill-bar {
            height: 5px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: #3498db;
            border-radius: 3px;
        }

        /* Languages Section */
        .language {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .language-name {
            font-size: 10px;
        }

        .language-level {
            color: #bdc3c7;
            font-size: 9px;
            text-transform: capitalize;
        }

        /* Interests Section */
        .interests-container {
            display: block;
            margin-top: 10px;
        }

        .interest-tag {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 9px;
            margin-bottom: 6px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Experience Section */
        .experience-item {
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 2px solid #e2e8f0;
        }

        .job-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .company-name {
            color: #3498db;
            margin-bottom: 4px;
            font-weight: bold;
            font-size: 11px;
        }

        .duration {
            color: #718096;
            font-size: 9px;
            margin-bottom: 8px;
        }

        .job-description {
            color: #4a5568;
            font-size: 10px;
            line-height: 1.4;
        }

        /* Education Section */
        .education-item {
            margin-bottom: 15px;
            padding: 12px;
            background: #f9fbfd;
            border-radius: 4px;
            border-left: 3px solid #3498db;
        }

        .institution-name {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .education-type {
            font-size: 10px;
            color: #9b59b6;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: capitalize;
        }

        /* Projects Section */
        .project-item {
            margin-bottom: 15px;
            padding: 12px;
            background: #f9fbfd;
            border-radius: 4px;
            border-left: 3px solid #9b59b6;
        }

        .project-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .project-status {
            color: #718096;
            font-size: 9px;
            margin-bottom: 6px;
        }

        /* Achievements Section */
        .achievements {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .achievement-item {
            background: #f8f9ff;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #edf2f7;
        }

        .achievement-value {
            font-size: 16px;
            font-weight: bold;
            color: #2b6cb0;
            margin-bottom: 3px;
        }

        .achievement-label {
            font-size: 9px;
            color: #4a5568;
        }

        /* Highlight boxes */
        .highlight {
            background: #f0f7ff;
            padding: 12px;
            border-radius: 4px;
            margin-top: 12px;
            border-left: 3px solid #3498db;
        }

        .highlight-title {
            font-weight: bold;
            color: #2c5282;
            margin-bottom: 6px;
        }

        /* Freshie Notice */
        .freshie-notice {
            background: #f0f7ff;
            padding: 12px;
            border-radius: 4px;
            margin-top: 15px;
            border-left: 3px solid #ff6b6b;
        }

        .freshie-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #2c3e50;
        }

        .freshie-text {
            font-size: 10px;
            line-height: 1.4;
            color: #4a5568;
        }

        /* Utility classes */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .icon {
            margin-right: 4px;
            width: 10px;
        }

        .no-margin {
            margin-bottom: 6px;
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
    <div class="cv-container clearfix">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <div class="avatar">
                    <?php if (!empty($row['profile_image'])): ?>
                        <!-- DomPDF can't handle external images well, so we'll just show initials -->
                        <?php 
                        $initials = '';
                        $name_parts = explode(' ', $row['full_name']);
                        foreach ($name_parts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper($part[0]);
                            }
                        }
                        echo substr($initials, 0, 2); 
                        ?>
                    <?php else: ?>
                        <?php 
                        $initials = '';
                        $name_parts = explode(' ', $row['full_name']);
                        foreach ($name_parts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper($part[0]);
                            }
                        }
                        echo substr($initials, 0, 2); 
                        ?>
                    <?php endif; ?>
                </div>
                <h1 class="name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
                <div class="title">
                    <?php echo formatProfessionalField($row['professional_field']); ?>
                    <?php if (!empty($row['custom_field'])): ?>
                        - <?php echo htmlspecialchars($row['custom_field']); ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="contact-section">
                <h3 class="section-title">Contact</h3>
                <div class="contact-item">
                    <span class="contact-icon">✉</span>
                    <span><?php echo htmlspecialchars($row['email']); ?></span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <span><?php echo htmlspecialchars($row['phone']); ?></span>
                </div>
                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <span><?php echo htmlspecialchars($row['address']); ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Skills Section -->
            <?php if (!empty($skills)): ?>
            <div class="skills-section">
                <h3 class="section-title">Skills</h3>
                <?php foreach ($skills as $skill): ?>
                <div class="skill">
                    <div class="skill-name"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: <?php echo getSkillPercentage($skill['skill_level']); ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Languages Section -->
            <?php if (!empty($languages)): ?>
            <div class="languages-section">
                <h3 class="section-title">Languages</h3>
                <?php foreach ($languages as $language): ?>
                <div class="language">
                    <span class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></span>
                    <span class="language-level"><?php echo formatLanguageLevel($language['proficiency_level']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- References Section -->
            <?php if (!empty($resume_references)): ?>
            <div class="interests-section">
                <h3 class="section-title">References</h3>
                <div class="interests-container">
                    <?php foreach ($resume_references as $reference): ?>
                    <div class="interest-tag"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Profile Summary -->
            <section class="main-section">
                <h2 class="main-section-title">Professional Profile</h2>
                <?php if (!empty($row['professional_summary'])): ?>
                <p class="job-description">
                    <?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?>
                </p>
                <?php endif; ?>
                
                <?php if (!empty($row['career_objective'])): ?>
                <div class="highlight">
                    <div class="highlight-title">Career Objective</div>
                    <p><?php echo nl2br(htmlspecialchars($row['career_objective'])); ?></p>
                </div>
                <?php endif; ?>
                
                <div class="achievements">
                    <div class="achievement-item">
                        <div class="achievement-value"><?php echo $total_experience; ?>+</div>
                        <div class="achievement-label">Work Experience</div>
                    </div>
                    <div class="achievement-item">
                        <div class="achievement-value"><?php echo $total_skills; ?>+</div>
                        <div class="achievement-label">Professional Skills</div>
                    </div>
                    <div class="achievement-item">
                        <div class="achievement-value"><?php echo $total_projects; ?>+</div>
                        <div class="achievement-label">Projects Completed</div>
                    </div>
                    <div class="achievement-item">
                        <div class="achievement-value"><?php echo $total_education; ?>+</div>
                        <div class="achievement-label">Educational Qualifications</div>
                    </div>
                </div>

                <!-- Freshie Notice -->
                <?php if ($row['is_freshie'] == 1): ?>
                <div class="freshie-notice">
                    <div class="freshie-title">Fresh Graduate</div>
                    <p class="freshie-text">
                        As a fresh graduate, I bring enthusiasm, up-to-date knowledge, and a strong willingness to learn 
                        and contribute to your organization. I am eager to apply my academic knowledge in a professional 
                        environment and grow with the company.
                    </p>
                </div>
                <?php endif; ?>
            </section>
            
            <!-- Experience Section -->
            <?php if (!empty($experience)): ?>
            <section class="main-section">
                <h2 class="main-section-title">Work Experience</h2>
                
                <?php foreach ($experience as $index => $exp): ?>
                <div class="experience-item">
                    <div class="experience-content">
                        <div class="job-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                        <?php if (!empty($exp['company_name'])): ?>
                            <div class="company-name"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($exp['duration'])): ?>
                            <div class="duration">
                                <span class="icon">📅</span>
                                <?php echo htmlspecialchars($exp['duration']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($exp['job_description'])): ?>
                            <p class="job-description">
                                <?php echo nl2br(htmlspecialchars($exp['job_description'])); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
            
            <!-- Projects Section -->
            <?php if (!empty($projects)): ?>
            <section class="main-section">
                <h2 class="main-section-title">Key Projects</h2>
                
                <?php foreach ($projects as $project): ?>
                <div class="project-item">
                    <div class="project-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                    <div class="project-status"><?php echo ucfirst($project['project_status']); ?></div>
                    <?php if (!empty($project['duration'])): ?>
                        <div class="duration">
                            <span class="icon">📅</span>
                            <?php echo htmlspecialchars($project['duration']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($project['project_description'])): ?>
                        <p class="job-description">
                            <?php echo nl2br(htmlspecialchars($project['project_description'])); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
            
            <!-- Education Section -->
            <?php if (!empty($education)): ?>
            <section class="main-section">
                <h2 class="main-section-title">Education</h2>
                
                <?php foreach ($education as $edu): ?>
                <div class="education-item">
                    <div class="education-content">
                        <div class="institution-name"><?php echo htmlspecialchars($edu['institution_name']); ?></div>
                        <div class="education-type">
                            <?php echo ucfirst($edu['education_type']); ?>
                            <?php if (!empty($edu['degree_program'])): ?>
                                - <?php echo htmlspecialchars($edu['degree_program']); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($edu['duration'])): ?>
                            <div class="duration">
                                <span class="icon">📅</span>
                                <?php echo htmlspecialchars($edu['duration']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
            
            <!-- Achievements Section -->
            <?php if (!empty($achievements)): ?>
            <section class="main-section">
                <h2 class="main-section-title">Achievements</h2>
                
                <?php foreach ($achievements as $achievement): ?>
                <div class="highlight">
                    <div class="highlight-title">Achievement</div>
                    <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <!-- References Section (Detailed) -->
            <?php if (!empty($resume_references)): ?>
            <section class="main-section">
                <h2 class="main-section-title">Professional References</h2>
                
                <?php foreach ($resume_references as $reference): ?>
                <div class="education-item">
                    <div class="education-content">
                        <div class="institution-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                        <?php if (!empty($reference['position'])): ?>
                            <div class="education-type"><?php echo htmlspecialchars($reference['position']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['company'])): ?>
                            <div class="company-name"><?php echo htmlspecialchars($reference['company']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['email']) || !empty($reference['phone'])): ?>
                            <div class="job-description">
                                <?php if (!empty($reference['email'])): ?>
                                    <div><span class="icon">✉</span><?php echo htmlspecialchars($reference['email']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($reference['phone'])): ?>
                                    <div><span class="icon">📞</span><?php echo htmlspecialchars($reference['phone']); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <!-- Additional Information -->
            <?php if ($row['is_freshie'] != 1 && (empty($experience) || empty($projects))) : ?>
            <section class="main-section">
                <h2 class="main-section-title">Professional Summary</h2>
                <div class="highlight">
                    <div class="highlight-title">Career Highlights</div>
                    <p>Dedicated professional with strong academic background and commitment to excellence. 
                    Seeking opportunities to apply knowledge and skills in a dynamic work environment. 
                    Ready to contribute to organizational success while continuing professional development.</p>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <?php if (!$is_pdf): ?>
    <a href="?pdf=1" class="pdf-download">Download PDF</a>
    <?php endif; ?>
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