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
        'school' => 'School',
        'college' => 'College',
        'university' => 'University',
        'diploma' => 'Diploma'
    ];
    return isset($types[$type]) ? $types[$type] : ucfirst($type);
}

// Function to group skills by category (based on professional field)
function groupSkillsByCategory($skills, $professional_field) {
    $categories = [
        'software_developer' => [
            'Programming Languages' => ['javascript', 'python', 'java', 'c++', 'php', 'html/css'],
            'Frameworks & Tools' => ['react', 'node.js', 'angular', 'vue.js', 'git', 'docker'],
            'Databases' => ['sql', 'mysql', 'mongodb', 'postgresql']
        ],
        'graphic_designer' => [
            'Design Software' => ['photoshop', 'illustrator', 'indesign', 'coreldraw', 'figma'],
            'Design Skills' => ['branding', 'ui/ux', 'typography', 'color theory'],
            'Other Tools' => ['canva', 'sketch', 'adobe xd']
        ],
        'sales_executive' => [
            'Sales Skills' => ['lead generation', 'negotiation', 'client relationship', 'sales strategy'],
            'Tools & Systems' => ['crm', 'salesforce', 'hubspot'],
            'Business Skills' => ['market analysis', 'presentation', 'communication']
        ],
        'teacher' => [
            'Teaching Skills' => ['curriculum development', 'classroom management', 'lesson planning'],
            'Subject Expertise' => ['mathematics', 'english', 'science', 'history'],
            'Educational Tools' => ['blackboard', 'moodle', 'google classroom']
        ],
        'customer_support' => [
            'Support Tools' => ['zendesk', 'freshdesk', 'live chat', 'helpdesk'],
            'Communication Skills' => ['customer service', 'problem solving', 'technical support'],
            'Technical Skills' => ['crm tools', 'ticketing systems']
        ]
    ];
    
    $grouped = [];
    $default_category = 'General Skills';
    
    foreach ($skills as $skill) {
        $skill_name = strtolower($skill['skill_name']);
        $categorized = false;
        
        if (isset($categories[$professional_field])) {
            foreach ($categories[$professional_field] as $category => $category_skills) {
                foreach ($category_skills as $cat_skill) {
                    if (strpos($skill_name, $cat_skill) !== false || strpos($cat_skill, $skill_name) !== false) {
                        $grouped[$category][] = $skill;
                        $categorized = true;
                        break 2;
                    }
                }
            }
        }
        
        if (!$categorized) {
            $grouped[$default_category][] = $skill;
        }
    }
    
    return $grouped;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional CV | <?php echo htmlspecialchars($row['full_name']); ?></title>
    <style>
        @page {
            margin: 0.75in;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            background: #ffffff;
            color: #2d3748;
            line-height: 1.6;
            font-size: 11pt;
        }

        .cv-container {
            width: 100%;
            background: #ffffff;
        }

        /* Header */
        .header {
            background: #1a365d;
            color: white;
            padding: 30pt;
            text-align: center;
            margin-bottom: 20pt;
        }

        .name {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 8pt;
            letter-spacing: 0.5pt;
        }

        .title {
            font-size: 14pt;
            color: #cbd5e0;
            margin-bottom: 15pt;
        }

        .contact-info {
            text-align: center;
        }

        .contact-item {
            display: inline-block;
            margin: 0 10pt 5pt 0;
            font-size: 10pt;
            color: #e2e8f0;
        }

        .contact-item a {
            color: #e2e8f0;
            text-decoration: none;
        }

        /* Main Content */
        .main-content {
            padding: 0 15pt;
        }

        /* Section Styling */
        .section {
            margin-bottom: 25pt;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16pt;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 15pt;
            padding-bottom: 5pt;
            border-bottom: 2pt solid #4c51bf;
        }

        /* Profile Section */
        .profile-section {
            background: #f8fafc;
            padding: 15pt;
            margin-bottom: 20pt;
            border-left: 3pt solid #4c51bf;
        }

        .profile-text {
            font-size: 11pt;
            color: #4a5568;
            line-height: 1.7;
            margin-bottom: 10pt;
        }

        .profile-objective {
            font-size: 10pt;
            color: #4a5568;
            line-height: 1.7;
            font-style: italic;
            border-top: 1pt solid #e2e8f0;
            padding-top: 10pt;
        }

        /* Education & Experience Items */
        .item {
            margin-bottom: 20pt;
            padding: 12pt;
            background: #f8fafc;
            border-left: 3pt solid #4c51bf;
            page-break-inside: avoid;
        }

        .item-header {
            width: 100%;
            margin-bottom: 8pt;
        }

        .item-type {
            font-size: 8pt;
            color: #4c51bf;
            text-transform: uppercase;
            letter-spacing: 1pt;
            margin-bottom: 5pt;
            font-weight: bold;
        }

        .item-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 3pt;
        }

        .item-subtitle {
            font-size: 10pt;
            color: #4a5568;
            font-style: italic;
            margin-bottom: 5pt;
        }

        .item-duration {
            font-size: 9pt;
            color: #4c51bf;
            font-weight: bold;
            background: #ebf4ff;
            padding: 3pt 8pt;
            float: right;
            margin-top: -20pt;
        }

        .item-description {
            font-size: 10pt;
            color: #4a5568;
            line-height: 1.6;
            margin-top: 8pt;
        }

        /* Skills Section */
        .field-name {
            font-size: 12pt;
            color: #4c51bf;
            margin-bottom: 15pt;
            font-weight: bold;
        }

        .skills-container {
            width: 100%;
        }

        .skill-group {
            background: #f8fafc;
            padding: 12pt;
            margin-bottom: 10pt;
            border-top: 2pt solid #4c51bf;
            page-break-inside: avoid;
        }

        .skill-category {
            font-size: 11pt;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10pt;
            padding-bottom: 5pt;
            border-bottom: 1pt solid #e2e8f0;
        }

        .skill-item {
            font-size: 10pt;
            color: #4a5568;
            margin-bottom: 5pt;
            padding-left: 10pt;
        }

        .skill-item:before {
            content: "• ";
            color: #4c51bf;
            margin-left: -10pt;
        }

        /* Projects Section */
        .project-item {
            margin-bottom: 20pt;
            padding: 12pt;
            background: #f8fafc;
            border-left: 3pt solid #4c51bf;
            page-break-inside: avoid;
        }

        .project-header {
            width: 100%;
            margin-bottom: 8pt;
        }

        .project-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2d3748;
        }

        .project-duration {
            font-size: 9pt;
            color: #4c51bf;
            font-weight: bold;
            background: #ebf4ff;
            padding: 2pt 6pt;
            float: right;
            margin-top: -15pt;
        }

        .project-status {
            font-size: 8pt;
            color: #2d3748;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1pt;
            margin-bottom: 8pt;
        }

        /* Languages Section */
        .language-item {
            padding: 8pt 0;
            border-bottom: 1pt solid #e2e8f0;
            page-break-inside: avoid;
        }

        .language-name {
            font-weight: bold;
            color: #2d3748;
            font-size: 10pt;
            display: inline-block;
            width: 60%;
        }

        .language-level {
            background: #ebf4ff;
            color: #4c51bf;
            padding: 3pt 8pt;
            font-size: 9pt;
            font-weight: bold;
            float: right;
        }

        /* Achievements Section */
        .achievement-item {
            background: #f8fafc;
            padding: 10pt;
            margin-bottom: 10pt;
            border-left: 2pt solid #4c51bf;
            page-break-inside: avoid;
        }

        .achievement-text {
            color: #4a5568;
            font-size: 10pt;
            line-height: 1.6;
        }

        /* References Section */
        .reference-item {
            background: #f8fafc;
            padding: 12pt;
            margin-bottom: 15pt;
            border-top: 2pt solid #4c51bf;
            page-break-inside: avoid;
        }

        .reference-name {
            font-size: 11pt;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5pt;
        }

        .reference-position {
            color: #4a5568;
            font-weight: bold;
            margin-bottom: 3pt;
            font-size: 10pt;
        }

        .reference-company {
            color: #4c51bf;
            font-weight: bold;
            margin-bottom: 8pt;
            font-size: 10pt;
        }

        .reference-contact {
            font-size: 9pt;
            color: #4a5568;
        }

        .reference-contact div {
            margin-bottom: 3pt;
        }

        /* Freshie Notice */
        .freshie-notice {
            text-align: center;
            padding: 15pt;
            background: #ebf4ff;
            border: 1pt solid #c3dafe;
            font-size: 10pt;
            color: #2d3748;
            margin-top: 15pt;
            page-break-inside: avoid;
        }

        .freshie-title {
            font-size: 12pt;
            font-weight: bold;
            color: #4c51bf;
            margin-bottom: 8pt;
        }

        /* Utility classes for layout */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .mb-10 {
            margin-bottom: 10pt;
        }

        .mb-15 {
            margin-bottom: 15pt;
        }

        .mb-20 {
            margin-bottom: 20pt;
        }

        .p-10 {
            padding: 10pt;
        }

        .p-15 {
            padding: 15pt;
        }

        /* Print specific styles */
        @media print {
            body {
                font-size: 10pt;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            .item, .project-item, .reference-item, .skill-group {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <!-- Header -->
        <div class="header">
            <div class="name"><?php echo htmlspecialchars($row['full_name']); ?></div>
            <div class="title"><?php echo formatProfessionalField($row['professional_field']); ?></div>
            
            <div class="contact-info">
                <div class="contact-item">
                    Email: <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <div class="contact-item">
                    Phone: <?php echo htmlspecialchars($row['phone']); ?>
                </div>
                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    Address: <?php echo htmlspecialchars($row['address']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($row['linkedin'])): ?>
                <div class="contact-item">
                    <a href="<?php echo htmlspecialchars($row['linkedin']); ?>">LinkedIn</a>
                </div>
                <?php endif; ?>
                <?php if (!empty($row['website'])): ?>
                <div class="contact-item">
                    <a href="<?php echo htmlspecialchars($row['website']); ?>">Website</a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <?php if (!empty($row['professional_summary']) || !empty($row['career_objective'])): ?>
            <div class="profile-section">
                <?php if (!empty($row['professional_summary'])): ?>
                    <div class="profile-text"><?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($row['career_objective'])): ?>
                    <div class="profile-objective">
                        <strong>Career Objective:</strong> <?php echo nl2br(htmlspecialchars($row['career_objective'])); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Education -->
            <?php if (!empty($education)): ?>
            <div class="section">
                <div class="section-title">Education</div>
                
                <?php foreach ($education as $edu): ?>
                <div class="item clearfix">
                    <div class="item-type"><?php echo formatEducationType($edu['education_type']); ?></div>
                    <?php if (!empty($edu['duration'])): ?>
                        <div class="item-duration"><?php echo htmlspecialchars($edu['duration']); ?></div>
                    <?php endif; ?>
                    <div class="item-header">
                        <div class="item-title"><?php echo htmlspecialchars($edu['institution_name']); ?></div>
                        <?php if (!empty($edu['degree_program'])): ?>
                            <div class="item-subtitle"><?php echo htmlspecialchars($edu['degree_program']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Experience -->
            <?php if (!empty($experience)): ?>
            <div class="section">
                <div class="section-title">Experience</div>
                
                <?php foreach ($experience as $exp): ?>
                <div class="item clearfix">
                    <?php if (!empty($exp['duration'])): ?>
                        <div class="item-duration"><?php echo htmlspecialchars($exp['duration']); ?></div>
                    <?php endif; ?>
                    <div class="item-header">
                        <div class="item-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                        <?php if (!empty($exp['company_name'])): ?>
                            <div class="item-subtitle"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($exp['job_description'])): ?>
                        <div class="item-description"><?php echo nl2br(htmlspecialchars($exp['job_description'])); ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
                <?php if ($row['is_freshie'] == 1): ?>
                <div class="freshie-notice">
                    <div class="freshie-title">Recent Graduate</div>
                    <div>Eager to apply strong academic foundation and fresh perspective to contribute meaningfully in a professional environment.</div>
                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
                <?php if ($row['is_freshie'] == 1): ?>
                <div class="section">
                    <div class="section-title">Experience</div>
                    <div class="freshie-notice">
                        <div class="freshie-title">Recent Graduate</div>
                        <div>Eager to apply strong academic foundation and fresh perspective to contribute meaningfully in a professional environment.</div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Skills -->
            <?php if (!empty($skills)): ?>
            <div class="section">
                <div class="section-title">Skills</div>
                
                <div class="field-name"><?php echo formatProfessionalField($row['professional_field']); ?></div>
                
                <div class="skills-container">
                    <?php 
                    $grouped_skills = groupSkillsByCategory($skills, $row['professional_field']);
                    foreach ($grouped_skills as $category => $category_skills): 
                    ?>
                    <div class="skill-group">
                        <div class="skill-category"><?php echo htmlspecialchars($category); ?></div>
                        <?php foreach ($category_skills as $skill): ?>
                        <div class="skill-item">
                            <?php echo htmlspecialchars($skill['skill_name']); ?> (<?php echo formatProficiencyLevel($skill['skill_level']); ?>)
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Projects -->
            <?php if (!empty($projects)): ?>
            <div class="section">
                <div class="section-title">Projects</div>
                
                <?php foreach ($projects as $project): ?>
                <div class="project-item clearfix">
                    <?php if (!empty($project['duration'])): ?>
                        <div class="project-duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                    <?php endif; ?>
                    <div class="project-header">
                        <div class="project-title"><?php echo htmlspecialchars($project['project_title']); ?></div>
                    </div>
                    
                    <div class="project-status">Status: <?php echo ucfirst($project['project_status']); ?></div>
                    
                    <?php if (!empty($project['project_description'])): ?>
                        <div class="item-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($project['project_link'])): ?>
                        <div style="margin-top: 8pt;">
                            <a href="<?php echo htmlspecialchars($project['project_link']); ?>" style="color: #4c51bf; text-decoration: none; font-weight: bold;">
                                View Project: <?php echo htmlspecialchars($project['project_link']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Languages -->
            <?php if (!empty($languages)): ?>
            <div class="section">
                <div class="section-title">Languages</div>
                
                <?php foreach ($languages as $language): ?>
                <div class="language-item clearfix">
                    <div class="language-name"><?php echo htmlspecialchars($language['language_name']); ?></div>
                    <div class="language-level"><?php echo formatProficiencyLevel($language['proficiency_level']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Achievements -->
            <?php if (!empty($achievements)): ?>
            <div class="section">
                <div class="section-title">Achievements</div>
                
                <?php foreach ($achievements as $achievement): ?>
                <div class="achievement-item">
                    <div class="achievement-text"><?php echo nl2br(htmlspecialchars($achievement['achievement_description'])); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- References -->
            <?php if (!empty($resume_references)): ?>
            <div class="section">
                <div class="section-title">References</div>
                
                <?php foreach ($resume_references as $reference): ?>
                <div class="reference-item">
                    <div class="reference-name"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                    <?php if (!empty($reference['position'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['position']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($reference['company'])): ?>
                        <div class="reference-company"><?php echo htmlspecialchars($reference['company']); ?></div>
                    <?php endif; ?>
                    
                    <div class="reference-contact">
                        <?php if (!empty($reference['email'])): ?>
                            <div>Email: <?php echo htmlspecialchars($reference['email']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['phone'])): ?>
                            <div>Phone: <?php echo htmlspecialchars($reference['phone']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reference['relationship'])): ?>
                            <div>Relationship: <?php echo htmlspecialchars($reference['relationship']); ?></div>
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