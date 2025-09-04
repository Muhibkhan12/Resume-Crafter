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
    die("No resume found in database");
}

$resume_id = $row['id'];

// Get all achievements for this resume
$sql1 = "SELECT * FROM achievements WHERE resume_id = $resume_id";
$run1 = mysqli_query($conn, $sql1);
$achievements = [];
while ($achievement = mysqli_fetch_assoc($run1)) {
    $achievements[] = $achievement;
}

// Get all education for this resume
$sql2 = "SELECT * FROM education WHERE resume_id = $resume_id ORDER BY created_at DESC";
$run2 = mysqli_query($conn, $sql2);
$education = [];
while ($edu = mysqli_fetch_assoc($run2)) {
    $education[] = $edu;
}

// Get all experience for this resume
$sql3 = "SELECT * FROM experience WHERE resume_id = $resume_id ORDER BY created_at DESC";
$run3 = mysqli_query($conn, $sql3);
$experience = [];
while ($exp = mysqli_fetch_assoc($run3)) {
    $experience[] = $exp;
}

// Get all languages for this resume
$sql4 = "SELECT * FROM languages WHERE resume_id = $resume_id";
$run4 = mysqli_query($conn, $sql4);
$languages = [];
while ($lang = mysqli_fetch_assoc($run4)) {
    $languages[] = $lang;
}

// Get all projects for this resume
$sql5 = "SELECT * FROM projects WHERE resume_id = $resume_id ORDER BY created_at DESC";
$run5 = mysqli_query($conn, $sql5);
$projects = [];
while ($proj = mysqli_fetch_assoc($run5)) {
    $projects[] = $proj;
}

// Get all references for this resume
$sql6 = "SELECT * FROM resume_references WHERE resume_id = $resume_id";
$run6 = mysqli_query($conn, $sql6);
$resume_references = [];
while ($ref = mysqli_fetch_assoc($run6)) {
    $resume_references[] = $ref;
}

// Get all skills for this resume
$sql7 = "SELECT * FROM skills WHERE resume_id = $resume_id";
$run7 = mysqli_query($conn, $sql7);
$skills = [];
while ($skill = mysqli_fetch_assoc($run7)) {
    $skills[] = $skill;
}

// Function to format professional field
function formatProfessionalField($field) {
    $fields = [
        'software_developer' => 'Software Developer',
        'graphic_designer' => 'Graphic Designer',
        'sales_executive' => 'Sales Executive',
        'teacher' => 'Teacher',
        'customer_support' => 'Customer Support Specialist'
    ];
    return isset($fields[$field]) ? $fields[$field] : ucwords(str_replace('_', ' ', $field));
}

// Function to format proficiency level
function formatProficiencyLevel($level) {
    return ucfirst($level);
}

// Function to format education type
function formatEducationType($type) {
    $types = [
        'school' => 'High School',
        'college' => 'College',
        'university' => 'University',
        'diploma' => 'Diploma'
    ];
    return isset($types[$type]) ? $types[$type] : ucfirst($type);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional CV | <?php echo htmlspecialchars($row['full_name']); ?></title>
    <style>
        /* DomPDF Compatible CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.5;
            font-size: 12px;
        }

        .cv-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
        }

        /* Header Section */
        .header {
            background-color: #2a9d8f;
            color: white;
            padding: 30px 20px;
            text-align: center;
            page-break-inside: avoid;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e9c46a;
            display: inline-block;
            text-align: center;
            line-height: 80px;
            font-size: 30px;
            color: white;
            margin-bottom: 15px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: white;
        }

        .title {
            font-size: 16px;
            color: #e0f2f1;
            margin-bottom: 20px;
        }

        .contact-info {
            font-size: 11px;
            color: #e0f2f1;
        }

        .contact-item {
            display: inline-block;
            margin: 0 10px 5px 0;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
        }

        .two-column {
            width: 100%;
        }

        .left-column {
            width: 48%;
            float: left;
        }

        .right-column {
            width: 48%;
            float: right;
        }

        .full-width {
            width: 100%;
            clear: both;
            margin-bottom: 20px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2a9d8f;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #2a9d8f;
        }

        /* Profile Section */
        .profile-section {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #2a9d8f;
        }

        .profile-text {
            font-size: 12px;
            color: #495057;
            line-height: 1.6;
        }

        /* Experience Section */
        .experience-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .experience-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .experience-date {
            font-weight: bold;
            color: #2a9d8f;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .job-title {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 3px;
        }

        .company-name {
            color: #6c757d;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 12px;
        }

        .job-description {
            color: #495057;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Education Section */
        .education-item {
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #2a9d8f;
        }

        .institution-name {
            font-size: 13px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 5px;
        }

        .education-type {
            font-size: 11px;
            color: #e76f51;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .education-program {
            font-size: 11px;
            color: #495057;
            margin-bottom: 5px;
        }

        .education-duration {
            font-size: 10px;
            color: #6c757d;
        }

        /* Skills Section */
        .skills-container {
            margin-top: 10px;
        }

        .skill-tag {
            background-color: #e9f5f4;
            color: #1d7874;
            padding: 5px 10px;
            margin: 3px 5px 3px 0;
            font-size: 10px;
            font-weight: bold;
            border-radius: 15px;
            display: inline-block;
        }

        /* Projects Section */
        .project-item {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-top: 4px solid #e76f51;
        }

        .project-title {
            font-size: 13px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 5px;
        }

        .project-duration {
            color: #2a9d8f;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .project-description {
            color: #495057;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Languages Section */
        .language-item {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .language-item:last-child {
            border-bottom: none;
        }

        .language-name {
            font-weight: bold;
            color: #212529;
            font-size: 12px;
            display: inline-block;
            width: 60%;
        }

        .language-level {
            background-color: #e9f5f4;
            color: #1d7874;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            float: right;
        }

        /* References Section */
        .reference-item {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #2a9d8f;
        }

        .reference-name {
            font-size: 12px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 3px;
        }

        .reference-position {
            color: #6c757d;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .reference-company {
            color: #2a9d8f;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .reference-contact {
            font-size: 10px;
            color: #495057;
        }

        /* Achievements Section */
        .achievement-item {
            background-color: #f8f9fa;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 3px solid #e76f51;
        }

        .achievement-text {
            color: #495057;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Clear floats */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Page break helpers */
        .page-break {
            page-break-before: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        /* Link styling */
        a {
            color: #2a9d8f;
            text-decoration: none;
        }

        /* Table for better layout control in DomPDF */
        .contact-table {
            width: 100%;
            border-collapse: collapse;
        }

        .contact-table td {
            padding: 2px 10px;
            font-size: 11px;
            color: #e0f2f1;
        }

        /* Font Awesome fallback - using text symbols */
        .icon-email:before { content: "✉ "; }
        .icon-phone:before { content: "☎ "; }
        .icon-location:before { content: "📍 "; }
        .icon-linkedin:before { content: "💼 "; }
        .icon-website:before { content: "🌐 "; }
    </style>
</head>
<body>
    <div class="cv-container">
        <!-- Header -->
        <div class="header">
            <div class="avatar">
                <?php if (!empty($row['profile_image']) && file_exists($row['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile" style="width:80px;height:80px;border-radius:50%;">
                <?php else: ?>
                    👤
                <?php endif; ?>
            </div>
            
            <div class="name"><?php echo htmlspecialchars($row['full_name']); ?></div>
            <div class="title"><?php echo formatProfessionalField($row['professional_field']); ?></div>
            
            <table class="contact-table">
                <tr>
                    <td class="icon-email"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="icon-phone"><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
                <?php if (!empty($row['address']) || !empty($row['linkedin'])): ?>
                <tr>
                    <?php if (!empty($row['address'])): ?>
                        <td class="icon-location"><?php echo htmlspecialchars($row['address']); ?></td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <?php if (!empty($row['linkedin'])): ?>
                        <td class="icon-linkedin">LinkedIn Profile</td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
                <?php endif; ?>
                <?php if (!empty($row['website'])): ?>
                <tr>
                    <td class="icon-website" colspan="2"><?php echo htmlspecialchars($row['website']); ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Summary -->
            <?php if (!empty($row['professional_summary']) || !empty($row['career_objective'])): ?>
            <div class="section full-width profile-section avoid-break">
                <h2 class="section-title">Professional Profile</h2>
                <?php if (!empty($row['professional_summary'])): ?>
                    <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($row['career_objective'])): ?>
                    <h3 style="margin-top: 15px; margin-bottom: 8px; color: #2a9d8f; font-size: 13px;">Career Objective</h3>
                    <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['career_objective'])); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <div class="two-column clearfix">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Experience Section -->
                    <?php if (!empty($experience)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Work Experience</h2>
                        
                        <?php foreach ($experience as $exp): ?>
                        <div class="experience-item avoid-break">
                            <div class="experience-date"><?php echo htmlspecialchars($exp['duration']); ?></div>
                            <div class="job-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                            <?php if (!empty($exp['company_name'])): ?>
                                <div class="company-name"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($exp['job_description'])): ?>
                                <div class="job-description"><?php echo nl2br(htmlspecialchars($exp['job_description'])); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Skills Section -->
                    <?php if (!empty($skills)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Skills</h2>
                        
                        <div class="skills-container">
                            <?php foreach ($skills as $skill): ?>
                                <div class="skill-tag"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Languages Section -->
                    <?php if (!empty($languages)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Languages</h2>
                        
                        <?php foreach ($languages as $language): ?>
                        <div class="language-item clearfix">
                            <div class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></div>
                            <div class="language-level"><?php echo formatProficiencyLevel($language['proficiency_level']); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Education Section -->
                    <?php if (!empty($education)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Education</h2>
                        
                        <?php foreach ($education as $edu): ?>
                        <div class="education-item avoid-break">
                            <div class="institution-name"><?php echo htmlspecialchars($edu['institution_name']); ?></div>
                            <div class="education-type"><?php echo formatEducationType($edu['education_type']); ?></div>
                            <?php if (!empty($edu['degree_program'])): ?>
                                <div class="education-program"><?php echo htmlspecialchars($edu['degree_program']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($edu['duration'])): ?>
                                <div class="education-duration"><?php echo htmlspecialchars($edu['duration']); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Projects Section -->
                    <?php if (!empty($projects)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Projects</h2>
                        
                        <?php foreach ($projects as $project): ?>
                        <div class="project-item avoid-break">
                            <div class="project-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                            <?php if (!empty($project['duration'])): ?>
                                <div class="project-duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($project['project_description'])): ?>
                                <div class="project-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($project['project_link'])): ?>
                                <div style="margin-top: 8px; font-size: 10px;">
                                    <a href="<?php echo htmlspecialchars($project['project_link']); ?>">View Project</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Achievements Section -->
                    <?php if (!empty($achievements)): ?>
                    <div class="section avoid-break">
                        <h2 class="section-title">Achievements</h2>
                        
                        <?php foreach ($achievements as $achievement): ?>
                        <div class="achievement-item avoid-break">
                            <div class="achievement-text"><?php echo nl2br(htmlspecialchars($achievement['achievement_description'])); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- References Section (Full Width) -->
            <?php if (!empty($resume_references)): ?>
            <div class="section full-width avoid-break" style="clear: both;">
                <h2 class="section-title">References</h2>
                
                <?php foreach ($resume_references as $reference): ?>
                <div class="reference-item avoid-break">
                    <div class="reference-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                    <?php if (!empty($reference['position'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['position']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($reference['company'])): ?>
                        <div class="reference-company"><?php echo htmlspecialchars($reference['company']); ?></div>
                    <?php endif; ?>
                    <div class="reference-contact">
                        <?php if (!empty($reference['email'])): ?>
                            <span class="icon-email"><?php echo htmlspecialchars($reference['email']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($reference['phone'])): ?>
                            <span class="icon-phone"><?php echo htmlspecialchars($reference['phone']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php mysqli_close($conn); ?>
</body>
</html>