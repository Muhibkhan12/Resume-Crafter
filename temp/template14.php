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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Professional CV</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2563eb;
            --primary-light: #dbeafe;
            --primary-dark: #1d4ed8;
            --secondary: #4b5563;
            --accent: #60a5fa;
            --success: #10b981;
            --light: #f9fafb;
            --dark: #1f2937;
            --text: #374151;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --section-gap: 30px;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: var(--light);
            padding: 40px 20px;
            min-height: 100vh;
        }

        .cv-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: var(--card-shadow);
            border-radius: 12px;
            overflow: hidden;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 50px 50px 40px;
            color: white;
            position: relative;
            text-align: center;
        }

        .name {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .title {
            font-size: 22px;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 30px;
            max-width: 700px;
            margin: 0 auto 30px;
            color: rgba(255, 255, 255, 0.9);
        }

        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            max-width: 800px;
            margin: 20px auto 0;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 400;
        }

        .contact-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--section-gap);
            padding: 50px;
        }

        /* Columns */
        .left-column, .right-column {
            display: flex;
            flex-direction: column;
            gap: var(--section-gap);
        }

        /* Section Styling */
        .section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border);
        }

        .section-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: var(--primary);
            font-size: 20px;
        }

        /* Profile Section */
        .summary {
            font-size: 16px;
            line-height: 1.8;
            color: var(--text);
            padding: 10px 0;
        }

        /* Experience Section */
        .experience-item {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .experience-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .job-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .job-title i {
            color: var(--accent);
        }

        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .company-name {
            font-size: 16px;
            color: var(--primary);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-location {
            font-size: 14px;
            color: var(--text-light);
            background: var(--light);
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 500;
        }

        .job-summary {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text);
            margin-bottom: 15px;
        }

        /* Skills Section */
        .skills-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }

        .skill-item {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
            font-size: 15px;
            border: 1px solid rgba(66, 153, 225, 0.1);
        }

        /* Education Section */
        .education-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .education-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .degree {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .university {
            font-size: 16px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .edu-date {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 12px;
        }

        /* Projects Section */
        .project-item {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .project-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .project-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .project-duration {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .project-description {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text);
            margin-bottom: 15px;
        }

        .project-link {
            font-size: 15px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            color: var(--accent);
        }

        .project-status {
            display: inline-block;
            background: #dcfce7;
            color: #047857;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            margin-top: 12px;
        }

        /* Achievements Section */
        .achievements-list {
            list-style: none;
            padding-left: 0;
        }

        .achievements-list li {
            position: relative;
            padding-left: 28px;
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.7;
            color: var(--text);
        }

        .achievements-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
            color: var(--primary);
            font-size: 24px;
            line-height: 1;
        }

        /* References Section */
        .reference-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .reference-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .reference-name {
            font-size: 17px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .reference-position {
            font-size: 15px;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .reference-contact {
            font-size: 14px;
            color: var(--text-light);
            margin-top: 10px;
        }

        .reference-contact div {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }

        .no-data {
            color: #94a3b8;
            font-style: italic;
            padding: 20px 0;
            text-align: center;
            font-size: 16px;
        }

        /* Languages Section */
        .languages-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .language-item {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 15px;
            border: 1px solid rgba(66, 153, 225, 0.1);
        }

        /* Professional Badge */
        .professional-badge {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .main-content {
                grid-template-columns: 1fr;
                padding: 30px;
                gap: 25px;
            }
            
            .header {
                padding: 40px 30px;
            }
            
            .name {
                font-size: 36px;
            }
            
            .title {
                font-size: 20px;
            }
            
            .contact-info {
                gap: 15px;
            }
            
            .professional-badge {
                position: relative;
                top: 0;
                right: 0;
                margin: 15px auto;
                width: fit-content;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .name {
                font-size: 32px;
            }
            
            .title {
                font-size: 18px;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 12px;
                align-items: center;
            }
            
            .contact-item {
                justify-content: center;
            }
            
            .company-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .section {
                padding: 25px 20px;
            }
            
            .section-title {
                font-size: 20px;
            }
            
            .skills-container {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .cv-container {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <!-- Header Section -->
        <header class="header">
            <div class="professional-badge">Professional CV</div>
            <h1 class="name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
            <div class="title"><?php echo formatProfessionalField($row['professional_field']); ?></div>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <?php echo htmlspecialchars($row['phone']); ?>
                </div>
                <?php if (!empty($row['address'])): ?>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo htmlspecialchars($row['address']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($row['linkedin'])): ?>
                <div class="contact-item">
                    <i class="fab fa-linkedin"></i>
                    <?php echo htmlspecialchars($row['linkedin']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($row['website'])): ?>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <?php echo htmlspecialchars($row['website']); ?>
                </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Professional Summary -->
                <?php if (!empty($row['professional_summary'])): ?>
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-user"></i>Professional Summary</h2>
                    <div class="summary">
                        <?php echo nl2br(htmlspecialchars($row['professional_summary'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Work Experience -->
                <?php if (mysqli_num_rows($experience_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-briefcase"></i>Work Experience</h2>
                    <?php while ($experience = mysqli_fetch_assoc($experience_result)): ?>
                    <div class="experience-item">
                        <h3 class="job-title"><i class="fas fa-briefcase"></i><?php echo htmlspecialchars($experience['job_title']); ?></h3>
                        <div class="company-info">
                            <div class="company-name">
                                <i class="fas fa-building"></i>
                                <?php echo htmlspecialchars($experience['company_name']); ?>
                            </div>
                            <?php if (!empty($experience['duration'])): ?>
                            <div class="date-location">
                                <i class="fas fa-calendar"></i>
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
                    <h2 class="section-title"><i class="fas fa-project-diagram"></i>Projects</h2>
                    <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
                    <div class="project-item">
                        <h3 class="project-title">
                            <i class="fas fa-folder-open"></i>
                            <?php echo htmlspecialchars($project['project_title']); ?>
                        </h3>
                        <?php if (!empty($project['duration'])): ?>
                        <div class="project-duration">
                            <i class="fas fa-calendar"></i>
                            <?php echo htmlspecialchars($project['duration']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($project['project_description'])): ?>
                        <div class="project-description">
                            <?php echo nl2br(htmlspecialchars($project['project_description'])); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($project['project_link'])): ?>
                        <a href="<?php echo htmlspecialchars($project['project_link']); ?>" class="project-link" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View Project
                        </a>
                        <?php endif; ?>
                        <div class="project-status"><?php echo ucfirst($project['project_status']); ?></div>
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
                    <h2 class="section-title"><i class="fas fa-star"></i>Skills</h2>
                    <div class="skills-container">
                        <?php while ($skill = mysqli_fetch_assoc($skills_result)): ?>
                        <div class="skill-item"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Education -->
                <?php if (mysqli_num_rows($education_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-graduation-cap"></i>Education</h2>
                    <?php while ($education = mysqli_fetch_assoc($education_result)): ?>
                    <div class="education-item">
                        <div class="degree"><i class="fas fa-graduation-cap"></i><?php echo htmlspecialchars($education['degree_program']); ?></div>
                        <div class="university">
                            <i class="fas fa-university"></i>
                            <?php echo htmlspecialchars($education['institution_name']); ?>
                        </div>
                        <?php if (!empty($education['duration'])): ?>
                        <div class="edu-date">
                            <i class="fas fa-calendar"></i>
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
                    <h2 class="section-title"><i class="fas fa-language"></i>Languages</h2>
                    <div class="languages-list">
                        <?php while ($language = mysqli_fetch_assoc($languages_result)): ?>
                        <div class="language-item">
                            <?php echo htmlspecialchars($language['language_name']); ?> 
                            (<?php echo formatProficiencyLevel($language['proficiency_level']); ?>)
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Achievements -->
                <?php if (mysqli_num_rows($achievements_result) > 0): ?>
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-trophy"></i>Achievements</h2>
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
                    <h2 class="section-title"><i class="fas fa-user-friends"></i>References</h2>
                    <?php while ($reference = mysqli_fetch_assoc($references_result)): ?>
                    <div class="reference-item">
                        <div class="reference-name"><i class="fas fa-user"></i><?php echo htmlspecialchars($reference['reference_name']); ?></div>
                        <?php if (!empty($reference['position'])): ?>
                        <div class="reference-position"><?php echo htmlspecialchars($reference['position']); ?></div>
                        <?php endif; ?>
                        <div class="reference-contact">
                            <?php if (!empty($reference['email'])): ?>
                            <div>
                                <i class="fas fa-envelope"></i>
                                <?php echo htmlspecialchars($reference['email']); ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($reference['phone'])): ?>
                            <div>
                                <i class="fas fa-phone"></i>
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
// Close the database connection
mysqli_close($conn);
?>