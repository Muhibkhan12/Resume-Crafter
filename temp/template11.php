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
    die("No resume found in the database.");
}

$resume_id = $row['id'];

// Get all achievements for this resume
$sql_achievements = "SELECT * FROM achievements WHERE resume_id = $resume_id";
$achievements_result = mysqli_query($conn, $sql_achievements);

// Get all education for this resume
$sql_education = "SELECT * FROM education WHERE resume_id = $resume_id";
$education_result = mysqli_query($conn, $sql_education);

// Get all experience for this resume
$sql_experience = "SELECT * FROM experience WHERE resume_id = $resume_id";
$experience_result = mysqli_query($conn, $sql_experience);

// Get all languages for this resume
$sql_languages = "SELECT * FROM languages WHERE resume_id = $resume_id";
$languages_result = mysqli_query($conn, $sql_languages);

// Get all projects for this resume
$sql_projects = "SELECT * FROM projects WHERE resume_id = $resume_id";
$projects_result = mysqli_query($conn, $sql_projects);

// Get all references for this resume
$sql_references = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
$references_result = mysqli_query($conn, $sql_references);

// Get all skills for this resume
$sql_skills = "SELECT * FROM skills WHERE resume_id = $resume_id";
$skills_result = mysqli_query($conn, $sql_skills);

// Function to format professional field
function formatProfessionalField($field) {
    $formatted = str_replace('_', ' ', $field);
    return ucwords($formatted);
}

// Function to format proficiency level
function formatProficiencyLevel($level) {
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
    <title>Professional CV - <?php echo htmlspecialchars($row['full_name']); ?></title>
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
            color: #9fbd8dff;
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

        /* Header - Simple solid color */
        .header {
            background: #79548fff;
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
            color: #ECF0F1;
            margin-bottom: 20px;
        }

        .contact-wrapper {
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
            color: #ECF0F1;
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
            background: #F8F9F9;
        }

        .right-column {
            width: 60%;
            float: right;
            padding: 20px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 25px;
            background: #ffffff;
            padding: 20px;
            border-left: 4px solid #3498DB;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ECF0F1;
        }

        /* Experience Items */
        .experience-item {
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 2px solid #BDC3C7;
        }

        .job-title {
            font-size: 14px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
        }

        .company-info {
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 12px;
            color: #2980B9;
            margin-bottom: 3px;
            font-weight: 600;
        }

        .date-location {
            font-size: 11px;
            color: #7F8C8D;
        }

        .job-summary {
            font-size: 11px;
            color: #34495E;
            line-height: 1.4;
        }

        /* Project Items */
        .project-item {
            margin-bottom: 20px;
            padding: 15px;
            background: #F8F9F9;
        }

        .project-title {
            font-size: 13px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 8px;
        }

        .project-duration {
            font-size: 11px;
            color: #7F8C8D;
            margin-bottom: 8px;
        }

        .project-description {
            font-size: 11px;
            color: #34495E;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .project-link {
            color: #3498DB;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
        }

        .project-status {
            font-size: 10px;
            color: #ffffff;
            background: #27AE60;
            padding: 3px 8px;
            display: inline-block;
            font-weight: 600;
        }

        /* Skills */
        .skills-container {
            display: block;
        }

        .skill-item {
            font-size: 11px;
            color: #34495E;
            padding: 6px 0;
            border-bottom: 1px solid #ECF0F1;
            display: flex;
            justify-content: space-between;
        }

        .skill-item:last-child {
            border-bottom: none;
        }

        .skill-name {
            font-weight: 600;
            color: #2C3E50;
        }

        .skill-level {
            color: #3498DB;
            font-weight: 600;
        }

        /* Education */
        .education-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ECF0F1;
        }

        .education-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .degree {
            font-size: 13px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
        }

        .university {
            font-size: 12px;
            color: #2980B9;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .edu-date {
            font-size: 11px;
            color: #7F8C8D;
        }

        /* Languages */
        .languages-list {
            list-style: none;
        }

        .language-item {
            font-size: 11px;
            color: #34495E;
            padding: 6px 0;
            border-bottom: 1px solid #ECF0F1;
            display: flex;
            justify-content: space-between;
        }

        .language-item:last-child {
            border-bottom: none;
        }

        .language-name {
            font-weight: 600;
            color: #2C3E50;
        }

        .language-level {
            color: #3498DB;
            font-weight: 600;
        }

        /* Achievements */
        .achievements-list {
            list-style: none;
        }

        .achievements-list li {
            font-size: 11px;
            color: #34495E;
            padding: 6px 0;
            padding-left: 15px;
            position: relative;
            line-height: 1.4;
        }

        .achievements-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #3498DB;
            font-weight: bold;
        }

        /* References */
        .reference-item {
            margin-bottom: 15px;
            padding: 15px;
            background: #F8F9F9;
        }

        .reference-name {
            font-size: 12px;
            font-weight: bold;
            color: #2C3E50;
            margin-bottom: 5px;
        }

        .reference-position {
            font-size: 11px;
            color: #2980B9;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .reference-contact {
            font-size: 11px;
            color: #7F8C8D;
        }

        /* Summary */
        .summary {
            font-size: 11px;
            color: #34495E;
            line-height: 1.4;
        }

        /* Utility classes */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Icons using Unicode */
        .icon {
            margin-right: 5px;
            width: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="cv-container clearfix">
        <!-- Header -->
        <div class="header">
            <h1 class="name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
            <div class="title"><?php echo formatProfessionalField($row['professional_field']); ?></div>
            <div class="contact-wrapper">
                <div class="contact-item">
                    <span class="icon">✉</span>
                    <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <div class="contact-item">
                    <span class="icon">📞</span>
                    <?php echo htmlspecialchars($row['phone']); ?>
                </div>
                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    <span class="icon">📍</span>
                    <?php echo htmlspecialchars($row['address']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content clearfix">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Professional Summary -->
                <?php if (!empty($row['professional_summary'])): ?>
                <div class="section">
                    <h2 class="section-title">Professional Summary</h2>
                    <div class="summary">
                        <?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Work Experience -->
                <?php if (mysqli_num_rows($experience_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Work Experience</h2>
                    <?php while ($experience = mysqli_fetch_assoc($experience_result)): ?>
                    <div class="experience-item">
                        <h3 class="job-title"><?php echo htmlspecialchars($experience['job_title']); ?></h3>
                        <div class="company-info">
                            <?php if (!empty($experience['company_name'])): ?>
                            <div class="company-name">
                                <span class="icon">🏢</span>
                                <?php echo htmlspecialchars($experience['company_name']); ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($experience['duration'])): ?>
                            <div class="date-location">
                                <span class="icon">📅</span>
                                <?php echo htmlspecialchars($experience['duration']); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($experience['job_description'])): ?>
                        <p class="job-summary">
                            <?php echo nl2br(htmlspecialchars($experience['job_description'])); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>

                <!-- Projects -->
                <?php if (mysqli_num_rows($projects_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Projects</h2>
                    <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                    <div class="project-item">
                        <h3 class="project-title">
                            <span class="icon">📁</span>
                            <?php echo htmlspecialchars($project['project_title']); ?>
                        </h3>
                        <?php if (!empty($project['duration'])): ?>
                        <div class="project-duration">
                            <span class="icon">📅</span>
                            <?php echo htmlspecialchars($project['duration']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($project['project_description'])): ?>
                        <div class="project-description">
                            <?php echo nl2br(htmlspecialchars($project['project_description'])); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($project['project_link'])): ?>
                        <a href="<?php echo htmlspecialchars($project['project_link']); ?>" class="project-link">
                            <span class="icon">🔗</span> View Project
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($project['project_status'])): ?>
                        <div class="project-status"><?php echo ucfirst($project['project_status']); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Column -->
            <div class="right-column">
                <!-- Skills -->
                <?php if (mysqli_num_rows($skills_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Skills</h2>
                    <div class="skills-container">
                        <?php while ($skill = mysqli_fetch_assoc($skills_result)): ?>
                        <div class="skill-item">
                            <span class="skill-name"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                            <span class="skill-level"><?php echo formatProficiencyLevel($skill['skill_level']); ?></span>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Education -->
                <?php if (mysqli_num_rows($education_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Education</h2>
                    <?php while ($education = mysqli_fetch_assoc($education_result)): ?>
                    <div class="education-item">
                        <div class="degree"><?php echo htmlspecialchars($education['degree_program']); ?></div>
                        <div class="university">
                            <span class="icon">🎓</span>
                            <?php echo htmlspecialchars($education['institution_name']); ?>
                        </div>
                        <?php if (!empty($education['duration'])): ?>
                        <div class="edu-date">
                            <span class="icon">📅</span>
                            <?php echo htmlspecialchars($education['duration']); ?>
                        </div>
                        <?php endif; ?>
                        <div>
                            <?php echo ucfirst(str_replace('_', ' ', $education['education_type'])); ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>

                <!-- Languages -->
                <?php if (mysqli_num_rows($languages_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Languages</h2>
                    <div class="languages-list">
                        <?php while ($language = mysqli_fetch_assoc($languages_result)): ?>
                        <div class="language-item">
                            <span class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></span>
                            <span class="language-level"><?php echo formatProficiencyLevel($language['proficiency_level']); ?></span>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Achievements -->
                <?php if (mysqli_num_rows($achievements_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">Achievements</h2>
                    <ul class="achievements-list">
                        <?php while ($achievement = mysqli_fetch_assoc($achievements_result)): ?>
                        <li><?php echo htmlspecialchars($achievement['achievement_description']); ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- References -->
                <?php if (mysqli_num_rows($references_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title">References</h2>
                    <?php while ($reference = mysqli_fetch_assoc($references_result)): ?>
                    <div class="reference-item">
                        <div class="reference-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                        <?php if (!empty($reference['position'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['position']); ?></div>
                        <?php endif; ?>
                        <div class="reference-contact">
                            <?php if (!empty($reference['email'])): ?>
                            <div>
                                <span class="icon">✉</span>
                                <?php echo htmlspecialchars($reference['email']); ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($reference['phone'])): ?>
                            <div>
                                <span class="icon">📞</span>
                                <?php echo htmlspecialchars($reference['phone']); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
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