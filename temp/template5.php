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

// Function to get user initials for avatar
function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper($word[0]);
        }
    }
    return substr($initials, 0, 2);
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
        /* DomPDF compatible CSS - Using only basic, well-supported properties */
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
            line-height: 1.35;
            padding: 0;
            background: #ffffff;
            font-size: 10px;
        }

        .cv-container {
            width: 100%;
            background: #ffffff;
            height: 100%;
            display: block;
        }

        /* Two-column layout */
        .sidebar {
            width: 30%;
            float: left;
            background: #2c3e50;
            color: #f8f9fa;
            padding: 12px;
            min-height: 10.6in;
        }

        .main-content {
            width: 70%;
            float: right;
            padding: 12px 15px;
            background: #ffffff;
        }

        /* Profile Section */
        .profile {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #3498db;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .title {
            font-size: 11px;
            color: #bdc3c7;
            margin-bottom: 8px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #ecf0f1;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
        }

        .main-section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 2px solid #3498db;
            text-transform: uppercase;
        }

        /* Contact Section */
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 9px;
            color: #e2e8f0;
        }

        .contact-icon {
            width: 12px;
            margin-right: 6px;
            color: #3498db;
            font-weight: bold;
            text-align: center;
        }

        /* Skills Section */
        .skill {
            margin-bottom: 8px;
        }

        .skill-name {
            display: block;
            margin-bottom: 3px;
            font-size: 9px;
        }

        .skill-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 2px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: #3498db;
            border-radius: 2px;
        }

        /* Languages Section */
        .language {
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
        }

        .language-name {
            font-size: 9px;
        }

        .language-level {
            color: #bdc3c7;
            font-size: 8px;
            text-transform: capitalize;
        }

        /* Achievements Section */
        .achievement-tag {
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            padding: 4px 6px;
            border-radius: 2px;
            font-size: 8px;
            margin-bottom: 5px;
            display: inline-block;
            border-left: 2px solid #3498db;
        }

        /* Experience Section */
        .experience-item {
            margin-bottom: 10px;
            padding-left: 10px;
            border-left: 1px solid #e2e8f0;
        }

        .job-title {
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .company-name {
            color: #3498db;
            margin-bottom: 3px;
            font-weight: bold;
            font-size: 10px;
        }

        .duration {
            color: #718096;
            font-size: 8px;
            margin-bottom: 5px;
        }

        .job-description {
            color: #4a5568;
            font-size: 9px;
            line-height: 1.3;
        }

        /* Education Section */
        .education-item {
            margin-bottom: 10px;
            padding: 8px;
            background: #f9fbfd;
            border-radius: 3px;
            border-left: 2px solid #3498db;
        }

        .institution-name {
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .education-type {
            font-size: 9px;
            color: #9b59b6;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: capitalize;
        }

        .degree-program {
            color: #4a5568;
            margin-bottom: 3px;
            font-size: 9px;
        }

        /* Projects Section */
        .project-item {
            margin-bottom: 10px;
            padding: 8px;
            background: #f9fbfd;
            border-radius: 3px;
            border-top: 2px solid #9b59b6;
        }

        .project-title {
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .project-description {
            color: #4a5568;
            line-height: 1.3;
            margin-bottom: 5px;
            font-size: 9px;
        }

        /* References Section */
        .reference-item {
            margin-bottom: 8px;
            padding: 8px;
            background: #f9fbfd;
            border-radius: 3px;
            border-left: 2px solid #e67e22;
        }

        .reference-name {
            font-size: 10px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .reference-position {
            color: #9b59b6;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 9px;
        }

        .reference-contact {
            color: #4a5568;
            font-size: 8px;
            line-height: 1.3;
        }

        /* Freshie Notice */
        .freshie-notice {
            background: #f0f7ff;
            padding: 10px;
            border-radius: 3px;
            text-align: center;
            margin: 10px 0;
            border: 1px solid #bee3f8;
        }

        .freshie-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .freshie-text {
            font-size: 9px;
            line-height: 1.3;
            color: #4a5568;
        }

        /* Utility classes */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .icon {
            margin-right: 3px;
            width: 9px;
        }

        .compact-text {
            font-size: 9px;
            line-height: 1.3;
        }

        .no-margin {
            margin-bottom: 5px;
        }

        /* PDF download button styling */
        .pdf-download {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #4a6491;
            color: white;
            padding: 5px 8px;
            border-radius: 3px;
            text-decoration: none;
            z-index: 1000;
            font-size: 10px;
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
                    <?php echo getInitials($resume['full_name']); ?>
                </div>
                <h1 class="name"><?php echo htmlspecialchars($resume['full_name']); ?></h1>
                <div class="title"><?php echo getProfessionalFieldName($resume['professional_field']); ?></div>
            </div>
            
            <!-- Contact Section -->
            <div class="section">
                <h3 class="section-title">Contact Info</h3>
                <div class="contact-item">
                    <span class="contact-icon">✉</span>
                    <span><?php echo htmlspecialchars($resume['email']); ?></span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <span><?php echo htmlspecialchars($resume['phone']); ?></span>
                </div>
                <?php if (!empty($resume['address'])): ?>
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <span><?php echo htmlspecialchars($resume['address']); ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Skills Section -->
            <?php if (mysqli_num_rows($skills_result) > 0): ?>
            <div class="section">
                <h3 class="section-title">Professional Skills</h3>
                <?php while ($skill = mysqli_fetch_assoc($skills_result)): ?>
                <div class="skill">
                    <div class="skill-name"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 
                            <?php 
                            $levels = ['beginner' => '30%', 'intermediate' => '60%', 'advanced' => '80%', 'expert' => '95%'];
                            echo isset($levels[$skill['skill_level']]) ? $levels[$skill['skill_level']] : '60%'; 
                            ?>">
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            
            <!-- Languages Section -->
            <?php if (mysqli_num_rows($languages_result) > 0): ?>
            <div class="section">
                <h3 class="section-title">Languages</h3>
                <?php while ($language = mysqli_fetch_assoc($languages_result)): ?>
                <div class="language">
                    <span class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></span>
                    <span class="language-level"><?php echo ucfirst($language['proficiency_level']); ?></span>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            
            <!-- Achievements Section -->
            <?php if (mysqli_num_rows($achievements_result) > 0): ?>
            <div class="section">
                <h3 class="section-title">Key Achievements</h3>
                <?php while ($achievement = mysqli_fetch_assoc($achievements_result)): ?>
                <div class="achievement-tag"><?php echo htmlspecialchars($achievement['achievement_description']); ?></div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Professional Summary -->
            <?php if (!empty($resume['professional_summary'])): ?>
            <section class="section no-margin">
                <h2 class="main-section-title">Professional Profile</h2>
                <p class="compact-text">
                    <?php echo nl2br(htmlspecialchars($resume['professional_summary'])); ?>
                </p>
            </section>
            <?php endif; ?>

            <!-- Career Objective -->
            <?php if (!empty($resume['career_objective'])): ?>
            <section class="section no-margin">
                <h2 class="main-section-title">Career Objective</h2>
                <p class="compact-text">
                    <?php echo nl2br(htmlspecialchars($resume['career_objective'])); ?>
                </p>
            </section>
            <?php endif; ?>
            
            <!-- Experience Section -->
            <section class="section no-margin">
                <h2 class="main-section-title">Work Experience</h2>
                
                <?php if (mysqli_num_rows($experience_result) > 0): ?>
                    <?php while ($experience = mysqli_fetch_assoc($experience_result)): ?>
                    <div class="experience-item">
                        <div class="job-title"><?php echo htmlspecialchars($experience['job_title']); ?></div>
                        <?php if (!empty($experience['company_name'])): ?>
                        <div class="company-name"><?php echo htmlspecialchars($experience['company_name']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($experience['duration'])): ?>
                        <div class="duration">
                            <span class="icon">📅</span>
                            <?php echo htmlspecialchars($experience['duration']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($experience['job_description'])): ?>
                        <p class="compact-text">
                            <?php echo nl2br(htmlspecialchars($experience['job_description'])); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                <?php elseif ($resume['is_freshie']): ?>
                    <div class="freshie-notice">
                        <h3 class="freshie-title">Recent Graduate</h3>
                        <p class="freshie-text">
                            Eager to begin my professional journey and apply my academic knowledge in a real-world environment. 
                            Seeking opportunities to contribute to innovative teams and develop practical skills in 
                            <?php echo getProfessionalFieldName($resume['professional_field']); ?>.
                        </p>
                    </div>
                <?php else: ?>
                    <p class="compact-text">Experience information will be updated soon.</p>
                <?php endif; ?>
            </section>
            
            <!-- Education Section -->
            <?php if (mysqli_num_rows($education_result) > 0): ?>
            <section class="section no-margin">
                <h2 class="main-section-title">Education</h2>
                
                <?php while ($education = mysqli_fetch_assoc($education_result)): ?>
                <div class="education-item">
                    <div class="institution-name"><?php echo htmlspecialchars($education['institution_name']); ?></div>
                    <div class="education-type"><?php echo ucfirst($education['education_type']); ?></div>
                    <?php if (!empty($education['degree_program'])): ?>
                    <div class="degree-program"><?php echo htmlspecialchars($education['degree_program']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($education['duration'])): ?>
                    <div class="duration">
                        <span class="icon">📅</span>
                        <?php echo htmlspecialchars($education['duration']); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </section>
            <?php endif; ?>
            
            <!-- Projects Section -->
            <?php if (mysqli_num_rows($projects_result) > 0): ?>
            <section class="section no-margin">
                <h2 class="main-section-title">Projects</h2>
                
                <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                <div class="project-item">
                    <div class="project-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                    <?php if (!empty($project['duration'])): ?>
                    <div class="duration">
                        <span class="icon">📅</span>
                        <?php echo htmlspecialchars($project['duration']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($project['project_description'])): ?>
                    <p class="compact-text">
                        <?php echo nl2br(htmlspecialchars($project['project_description'])); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </section>
            <?php endif; ?>

            <!-- References Section -->
            <?php if (mysqli_num_rows($references_result) > 0): ?>
            <section class="section no-margin">
                <h2 class="main-section-title">References</h2>
                
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
                            <div><span class="icon">✉</span> <?php echo htmlspecialchars($reference['email']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['phone'])): ?>
                            <div><span class="icon">📞</span> <?php echo htmlspecialchars($reference['phone']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </section>
            <?php endif; ?>
        </main>
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