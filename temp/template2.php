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

// Get data and store in arrays
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
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
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #2c3e50;
            font-size: 11pt;
        }

        .cv-container {
            width: 100%;
        }

        .header {
            background: #008080;
            padding: 20pt;
            text-align: center;
            color: white;
            margin-bottom: 15pt;
            page-break-inside: avoid;
        }

        .profile-image {
            width: 60pt;
            height: 60pt;
            border-radius: 50%;
            border: 2pt solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 10pt;
            background: #e0f2f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20pt;
            color: #008080;
        }

        .name {
            font-size: 22pt;
            font-weight: bold;
            margin-bottom: 5pt;
        }

        .title {
            font-size: 12pt;
            margin-bottom: 15pt;
            opacity: 0.9;
        }

        .contact-info {
            font-size: 9pt;
        }

        .contact-item {
            display: inline-block;
            margin: 0 8pt;
        }

        .content {
            padding: 15pt;
        }

        .main-columns {
            width: 100%;
            display: table;
        }

        .left-column {
            display: table-cell;
            width: 65%;
            vertical-align: top;
            padding-right: 15pt;
        }

        .right-column {
            display: table-cell;
            width: 35%;
            vertical-align: top;
        }

        .section {
            margin-bottom: 20pt;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #008080;
            margin-bottom: 10pt;
            padding-bottom: 3pt;
            border-bottom: 1pt solid #e0e0e0;
            text-transform: uppercase;
        }

        .profile-text {
            font-size: 10pt;
            line-height: 1.5;
            color: #444;
        }

        .item {
            margin-bottom: 15pt;
            padding: 10pt;
            border-radius: 3pt;
            background: white;
            border-left: 3pt solid #4db6ac;
            page-break-inside: avoid;
        }

        .item-title {
            font-size: 11pt;
            font-weight: bold;
            color: #008080;
            margin-bottom: 3pt;
        }

        .item-subtitle {
            font-size: 10pt;
            color: #00695c;
            font-weight: bold;
            margin-bottom: 3pt;
        }

        .item-duration {
            font-size: 9pt;
            color: #777;
            font-style: italic;
            margin-bottom: 5pt;
        }

        .item-description {
            font-size: 10pt;
            line-height: 1.4;
            color: #555;
        }

        .sidebar-section {
            margin-bottom: 15pt;
        }

        .sidebar-title {
            font-size: 11pt;
            font-weight: bold;
            color: #008080;
            margin-bottom: 8pt;
            padding-bottom: 3pt;
            border-bottom: 1pt solid #e0e0e0;
        }

        .skill-tag {
            background: #4db6ac;
            padding: 3pt 8pt;
            font-size: 9pt;
            color: white;
            border-radius: 3pt;
            margin-bottom: 3pt;
            margin-right: 3pt;
            display: inline-block;
        }

        .education-item {
            background: #f8f9fa;
            padding: 8pt;
            border-radius: 3pt;
            margin-bottom: 8pt;
            border-left: 2pt solid #ff6b6b;
        }

        .achievements li {
            position: relative;
            padding-left: 12pt;
            margin-bottom: 5pt;
            font-size: 9pt;
            line-height: 1.4;
            color: #555;
            list-style: none;
        }

        .achievements li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-weight: bold;
        }

        .project-status {
            display: inline-block;
            background: #e8f5e8;
            color: #2e7d32;
            padding: 2pt 5pt;
            border-radius: 3pt;
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: 500;
            margin-top: 5pt;
        }

        .project-status.ongoing {
            background: #fff3e0;
            color: #f57c00;
        }

        .project-status.planned {
            background: #e3f2fd;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <header class="header">
            <div class="profile-image">
                <?php if (!empty($row['profile_image']) && file_exists($row['profile_image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                <?php else: ?>
                    👤
                <?php endif; ?>
            </div>
            <h1 class="name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
            <p class="title"><?php echo formatProfessionalField($row['professional_field']); ?></p>
            <div class="contact-info">
                <?php if (!empty($row['email'])): ?>
                    <span class="contact-item">📧 <?php echo htmlspecialchars($row['email']); ?></span>
                <?php endif; ?>
                <?php if (!empty($row['phone'])): ?>
                    <span class="contact-item">📱 <?php echo htmlspecialchars($row['phone']); ?></span>
                <?php endif; ?>
                <?php if (!empty($row['address'])): ?>
                    <span class="contact-item">📍 <?php echo htmlspecialchars($row['address']); ?></span>
                <?php endif; ?>
                <?php if (!empty($row['linkedin'])): ?>
                    <span class="contact-item">🔗 <?php echo htmlspecialchars($row['linkedin']); ?></span>
                <?php endif; ?>
            </div>
        </header>
        
        <div class="content">
            <?php if (!empty($row['professional_summary'])): ?>
            <section class="section">
                <h2 class="section-title">Professional Profile</h2>
                <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?></p>
            </section>
            <?php endif; ?>

            <?php if (!empty($row['career_objective'])): ?>
            <section class="section">
                <h2 class="section-title">Career Objective</h2>
                <p class="profile-text"><?php echo nl2br(htmlspecialchars($row['career_objective'])); ?></p>
            </section>
            <?php endif; ?>
            
            <div class="main-columns">
                <div class="left-column">
                    <?php if (!empty($experience)): ?>
                    <section class="section">
                        <h2 class="section-title">Professional Experience</h2>
                        <?php foreach ($experience as $exp): ?>
                        <div class="item">
                            <h3 class="item-title"><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                            <div class="item-subtitle"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                            <?php if (!empty($exp['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($exp['duration']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($exp['job_description'])): ?>
                            <p class="item-description"><?php echo nl2br(htmlspecialchars($exp['job_description'])); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($projects)): ?>
                    <section class="section">
                        <h2 class="section-title">Key Projects</h2>
                        <?php foreach ($projects as $project): ?>
                        <div class="item">
                            <h3 class="item-title"><?php echo htmlspecialchars($project['project_title']); ?></h3>
                            <?php if (!empty($project['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($project['duration']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($project['project_description'])): ?>
                            <p class="item-description"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></p>
                            <?php endif; ?>
                            <div class="project-status <?php echo $project['project_status']; ?>">
                                <?php echo ucfirst($project['project_status']); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>

                    <?php if (!empty($achievements)): ?>
                    <section class="section">
                        <h2 class="section-title">Key Achievements</h2>
                        <ul class="achievements">
                            <?php foreach ($achievements as $achievement): ?>
                            <li><?php echo htmlspecialchars($achievement['achievement_description']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                </div>
                
                <div class="right-column">
                    <?php if (!empty($skills)): ?>
                    <section class="sidebar-section">
                        <h3 class="sidebar-title">Core Competencies</h3>
                        <?php foreach ($skills as $skill): ?>
                            <span class="skill-tag"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($education)): ?>
                    <section class="sidebar-section">
                        <h3 class="sidebar-title">Education</h3>
                        <?php foreach ($education as $edu): ?>
                        <div class="education-item">
                            <?php if (!empty($edu['degree_program'])): ?>
                            <div class="item-title" style="font-size: 10pt;"><?php echo htmlspecialchars($edu['degree_program']); ?></div>
                            <?php endif; ?>
                            <div class="item-subtitle" style="font-size: 9pt;"><?php echo htmlspecialchars($edu['institution_name']); ?></div>
                            <?php if (!empty($edu['duration'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($edu['duration']); ?></div>
                            <?php endif; ?>
                            <div style="font-size: 8pt; color: #666;"><?php echo ucfirst(str_replace('_', ' ', $edu['education_type'])); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>
                    
                    <?php if (!empty($languages)): ?>
                    <section class="sidebar-section">
                        <h3 class="sidebar-title">Languages</h3>
                        <?php foreach ($languages as $language): ?>
                        <div style="margin-bottom: 5pt;">
                            <span class="skill-tag"><?php echo htmlspecialchars($language['language_name']) . ' (' . ucfirst($language['proficiency_level']) . ')'; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>

                    <?php if (!empty($references)): ?>
                    <section class="sidebar-section">
                        <h3 class="sidebar-title">References</h3>
                        <?php foreach ($references as $reference): ?>
                        <div class="education-item">
                            <div class="item-title" style="font-size: 10pt;"><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                            <?php if (!empty($reference['position'])): ?>
                            <div class="item-subtitle" style="font-size: 9pt;"><?php echo htmlspecialchars($reference['position']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($reference['company'])): ?>
                            <div class="item-duration"><?php echo htmlspecialchars($reference['company']); ?></div>
                            <?php endif; ?>
                            <div style="font-size: 8pt; color: #666;">
                                <?php if (!empty($reference['email'])): ?>
                                    <?php echo htmlspecialchars($reference['email']); ?>
                                <?php endif; ?>
                                <?php if (!empty($reference['phone'])): ?>
                                    <?php if (!empty($reference['email'])) echo ' | '; ?>
                                    <?php echo htmlspecialchars($reference['phone']); ?>
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
<?php mysqli_close($conn); ?>