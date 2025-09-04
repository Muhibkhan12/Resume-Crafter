<?php
// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the latest resume
$sql = "SELECT * FROM resumes ORDER BY id DESC LIMIT 1";
$run = mysqli_query($conn, $sql);
$resume = mysqli_fetch_assoc($run);

if (!$resume) {
    die("No resume found in database.");
}

$resume_id = $resume['id'];

// Get all related data for this resume
$sql_achievements = "SELECT * FROM achievements WHERE resume_id = $resume_id";
$achievements_result = mysqli_query($conn, $sql_achievements);

$sql_education = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY id";
$education_result = mysqli_query($conn, $sql_education);

$sql_experience = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY id";
$experience_result = mysqli_query($conn, $sql_experience);

$sql_languages = "SELECT * FROM languages WHERE resume_id = $resume_id";
$languages_result = mysqli_query($conn, $sql_languages);

$sql_projects = "SELECT * FROM projects WHERE resume_id = $resume_id";
$projects_result = mysqli_query($conn, $sql_projects);

$sql_references = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
$references_result = mysqli_query($conn, $sql_references);

$sql_skills = "SELECT * FROM skills WHERE resume_id = $resume_id";
$skills_result = mysqli_query($conn, $sql_skills);

// Function to get professional field display name
function getProfessionalFieldName($field) {
    $fields = [
        'software_developer' => 'Software Developer',
        'graphic_designer' => 'Graphic Designer',
        'teacher' => 'Teacher',
        'sales_executive' => 'Sales Executive',
        'customer_support' => 'Customer Support Specialist',
        'marketing' => 'Marketing Specialist'
    ];
    return isset($fields[$field]) ? $fields[$field] : ucwords(str_replace('_', ' ', $field));
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
    <title><?php echo htmlspecialchars($resume['full_name']); ?> - Professional CV</title>
    <style>
        /* DomPDF compatible CSS */
        @page {
            margin: 0.4in;
            size: letter;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif; /* Web-safe fonts for PDF */
        }

        body {
            color: #4a5568;
            line-height: 1.4;
            padding: 0;
            background: #ffffff;
            font-size: 11px;
        }

        .cv-container {
            width: 100%;
            background: #ffffff;
            height: 100%;
        }

        /* Header Section */
        .header {
            padding: 15px 20px;
            text-align: center;
            background: #2c3e50;
            color: white;
            margin-bottom: 10px;
        }

        .name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .title {
            font-size: 14px;
            font-weight: normal;
            color: #a0aec0;
            margin-bottom: 10px;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .contact-item {
            margin: 0 6px 3px;
            font-size: 11px;
            color: #e2e8f0;
        }

        /* Main Content */
        .main-content {
            display: flex;
            padding: 0 10px;
        }

        .left-column, .right-column {
            padding: 0 8px;
        }

        .left-column {
            width: 58%;
            border-right: 1px solid #e2e8f0;
        }

        .right-column {
            width: 42%;
            padding-left: 15px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Professional Summary */
        .professional-summary {
            background: #f8f9fa;
            padding: 12px;
            margin-bottom: 12px;
            border-left: 4px solid #4299e1;
            font-size: 11px;
            line-height: 1.4;
        }

        /* Education Section */
        .education-item, .experience-item, .project-item {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .education-item:last-child, .experience-item:last-child, .project-item:last-child {
            border-bottom: none;
        }

        .education-type {
            font-size: 10px;
            color: #718096;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .institution-name, .job-title, .project-title {
            font-size: 13px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .degree-program, .company-name {
            color: #4a5568;
            margin-bottom: 2px;
            font-weight: 500;
            font-size: 11px;
        }

        .duration {
            color: #718096;
            font-size: 10px;
            margin-bottom: 2px;
        }

        .job-description, .project-description {
            color: #4a5568;
            margin-top: 4px;
            line-height: 1.4;
            font-size: 11px;
        }

        /* Skills Section */
        .skills-container {
            display: block;
        }

        .skill-tag {
            background: #edf2f7;
            color: #2d3748;
            padding: 4px 7px;
            border-radius: 2px;
            font-size: 10px;
            display: inline-block;
            margin: 0 4px 4px 0;
            border: 1px solid #e2e8f0;
        }

        .field-highlight {
            background: #4299e1;
            color: white;
            padding: 5px 8px;
            border-radius: 2px;
            font-size: 11px;
            margin-bottom: 8px;
            display: inline-block;
            font-weight: 500;
        }

        /* Languages Section */
        .language-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .language-item:last-child {
            border-bottom: none;
        }

        .language-name {
            font-weight: 500;
            color: #2d3748;
            font-size: 11px;
        }

        .proficiency-level {
            background: #e2e8f0;
            color: #2d3748;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            text-transform: capitalize;
        }

        /* Achievements Section */
        .achievement-item {
            background: #f8f9fa;
            padding: 6px 8px;
            margin-bottom: 5px;
            border-left: 3px solid #4299e1;
            font-size: 10px;
            line-height: 1.4;
        }

        /* References Section */
        .reference-item {
            background: #f8f9fa;
            padding: 8px;
            margin-bottom: 6px;
            border-radius: 2px;
            font-size: 10px;
        }

        .reference-name {
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .reference-position {
            color: #4a5568;
            margin-bottom: 2px;
        }

        .reference-contact {
            color: #718096;
        }

        /* Freshie Notice */
        .freshie-notice {
            background: #f7fafc;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #e2e8f0;
            font-size: 11px;
        }

        .freshie-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .freshie-text {
            color: #4a5568;
            line-height: 1.4;
        }

        /* PDF download button styling */
        .pdf-download {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #4a6491;
            color: white;
            padding: 6px 10px;
            border-radius: 3px;
            text-decoration: none;
            z-index: 1000;
            font-size: 11px;
        }
        
        /* Hide download button in PDF */
        @media print {
            .pdf-download {
                display: none;
            }
            
            body {
                font-size: 10px;
            }
            
            .header {
                padding: 12px;
            }
            
            .name {
                font-size: 18px;
            }
            
            .main-content {
                padding: 0 8px;
            }
        }
        
        /* Utility classes */
        .compact {
            margin-bottom: 6px;
        }
        
        .small-text {
            font-size: 10px;
        }
        
        .no-border {
            border: none;
        }
    </style>
</head>
<body>

    <div class="cv-container">
        <!-- Header -->
        <div class="header">
            <h1 class="name"><?php echo htmlspecialchars($resume['full_name']); ?></h1>
            <div class="title"><?php echo getProfessionalFieldName($resume['professional_field']); ?></div>
            
            <div class="contact-info">
                <div class="contact-item">
                    <?php echo htmlspecialchars($resume['email']); ?>
                </div>
                <div class="contact-item">
                    <?php echo htmlspecialchars($resume['phone']); ?>
                </div>
                <?php if (!empty($resume['address'])): ?>
                <div class="contact-item">
                    <?php echo htmlspecialchars($resume['address']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Professional Summary -->
        <?php if (!empty($resume['professional_summary'])): ?>
        <div style="padding: 0 15px 8px;">
            <div class="professional-summary compact">
                <h3 style="margin-bottom: 6px; color: #2c3e50; font-size: 13px;">Professional Summary</h3>
                <p><?php echo nl2br(htmlspecialchars($resume['professional_summary'])); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Education Section -->
                <?php if (mysqli_num_rows($education_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Education</h2>
                    
                    <?php while ($education = mysqli_fetch_assoc($education_result)): ?>
                    <div class="education-item">
                        <div class="education-type"><?php echo ucfirst($education['education_type']); ?></div>
                        <div class="institution-name"><?php echo htmlspecialchars($education['institution_name']); ?></div>
                        <?php if (!empty($education['degree_program'])): ?>
                        <div class="degree-program"><?php echo htmlspecialchars($education['degree_program']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($education['duration'])): ?>
                        <div class="duration"><?php echo htmlspecialchars($education['duration']); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
                
                <!-- Experience Section -->
                <?php if (mysqli_num_rows($experience_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Experience</h2>
                    
                    <?php while ($experience = mysqli_fetch_assoc($experience_result)): ?>
                    <div class="experience-item">
                        <div class="job-title"><?php echo htmlspecialchars($experience['job_title']); ?></div>
                        <?php if (!empty($experience['company_name'])): ?>
                        <div class="company-name"><?php echo htmlspecialchars($experience['company_name']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($experience['duration'])): ?>
                        <div class="duration"><?php echo htmlspecialchars($experience['duration']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($experience['job_description'])): ?>
                        <div class="job-description"><?php echo nl2br(htmlspecialchars($experience['job_description'])); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php elseif ($resume['is_freshie']): ?>
                <div class="section compact">
                    <h2 class="section-title">Experience</h2>
                    <div class="freshie-notice">
                        <h3 class="freshie-title">Recent Graduate</h3>
                        <p class="freshie-text">
                            Eager to begin my professional journey and apply my academic knowledge in a real-world environment. 
                            Seeking opportunities to contribute to innovative teams and develop practical skills in <?php echo getProfessionalFieldName($resume['professional_field']); ?>.
                        </p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Projects Section -->
                <?php if (mysqli_num_rows($projects_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Projects</h2>
                    
                    <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                    <div class="project-item">
                        <div class="project-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                        <?php if (!empty($project['duration'])): ?>
                        <div class="duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($project['project_description'])): ?>
                        <div class="project-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Column -->
            <div class="right-column">
                <!-- Career Objective -->
                <?php if (!empty($resume['career_objective'])): ?>
                <div class="section compact">
                    <h2 class="section-title">Career Objective</h2>
                    <p style="line-height: 1.4; color: #4a5568; font-size: 11px;"><?php echo nl2br(htmlspecialchars($resume['career_objective'])); ?></p>
                </div>
                <?php endif; ?>

                <!-- Skills Section -->
                <?php if (mysqli_num_rows($skills_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Skills</h2>
                    
                    <div class="field-highlight"><?php echo getProfessionalFieldName($resume['professional_field']); ?></div>
                    
                    <div class="skills-container">
                        <?php while ($skill = mysqli_fetch_assoc($skills_result)): ?>
                        <div class="skill-tag"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Languages Section -->
                <?php if (mysqli_num_rows($languages_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Languages</h2>
                    
                    <?php while ($language = mysqli_fetch_assoc($languages_result)): ?>
                    <div class="language-item">
                        <span class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></span>
                        <span class="proficiency-level"><?php echo ucfirst($language['proficiency_level']); ?></span>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>

                <!-- Achievements Section -->
                <?php if (mysqli_num_rows($achievements_result) > 0): ?>
                <div class="section compact">
                    <h2 class="section-title">Achievements</h2>
                    
                    <?php while ($achievement = mysqli_fetch_assoc($achievements_result)): ?>
                    <div class="achievement-item">
                        <?php echo htmlspecialchars($achievement['achievement_description']); ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>

                <!-- References Section -->
                <?php if (mysqli_num_rows($references_result) > 0): ?>
                <div class="section compact no-border">
                    <h2 class="section-title">References</h2>
                    
                    <?php while ($reference = mysqli_fetch_assoc($references_result)): ?>
                    <div class="reference-item">
                        <div class="reference-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                        <?php if (!empty($reference['position']) || !empty($reference['company'])): ?>
                        <div class="reference-position">
                            <?php 
                            $position_info = [];
                            if (!empty($reference['position'])) $position_info[] = $reference['position'];
                            if (!empty($reference['company'])) $position_info[] = $reference['company'];
                            echo htmlspecialchars(implode(' at ', $position_info));
                            ?>
                        </div>
                        <?php endif; ?>
                        <div class="reference-contact">
                            <?php if (!empty($reference['email'])): ?>
                                <?php echo htmlspecialchars($reference['email']); ?>
                            <?php endif; ?>
                            <?php if (!empty($reference['phone'])): ?>
                                <?php if (!empty($reference['email'])) echo ' | '; ?>
                                <?php echo htmlspecialchars($reference['phone']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
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