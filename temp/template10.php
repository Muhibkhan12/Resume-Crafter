<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 12mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333333;
            font-size: 11pt;
            background: #1a1a1a;
        }

        .cv-container {
            width: 100%;
            background: #ffffff;
            position: relative;
        }

        .sidebar {
            position: absolute;
            left: 0;
            top: 0;
            width: 35%;
            height: 100%;
            background: #2c3e50;
            color: #ffffff;
            padding: 25pt;
        }

        .main-content {
            margin-left: 35%;
            padding: 25pt;
            background: #ffffff;
            min-height: 100%;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 30pt;
            padding-bottom: 25pt;
            border-bottom: 2pt solid #34495e;
        }

        .profile-image {
            width: 80pt;
            height: 80pt;
            border-radius: 50%;
            background: #34495e;
            margin: 0 auto 15pt auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24pt;
            color: #ecf0f1;
        }

        .name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 8pt;
            color: #ecf0f1;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }

        .title {
            font-size: 12pt;
            color: #bdc3c7;
            margin-bottom: 15pt;
            font-weight: 300;
        }

        .contact-info {
            font-size: 10pt;
            line-height: 1.8;
        }

        .contact-item {
            margin-bottom: 8pt;
            display: block;
        }

        .contact-label {
            font-weight: bold;
            color: #3498db;
            display: inline-block;
            width: 60pt;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5pt;
        }

        .sidebar-section {
            margin-bottom: 25pt;
        }

        .sidebar-title {
            font-size: 12pt;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 15pt;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            position: relative;
            padding-bottom: 8pt;
        }

        .sidebar-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1pt;
            background: linear-gradient(90deg, #3498db 0%, transparent 100%);
        }

        .skills-list {
            list-style: none;
        }

        .skill-item {
            background: #34495e;
            padding: 8pt 12pt;
            margin-bottom: 6pt;
            border-radius: 4pt;
            font-size: 10pt;
            position: relative;
            border-left: 3pt solid #3498db;
        }

        .skill-level {
            position: absolute;
            right: 12pt;
            top: 50%;
            transform: translateY(-50%);
            font-size: 8pt;
            color: #bdc3c7;
        }

        .education-item {
            margin-bottom: 15pt;
            padding-bottom: 15pt;
            border-bottom: 1pt solid #34495e;
        }

        .education-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .education-degree {
            font-weight: bold;
            color: #ecf0f1;
            font-size: 11pt;
            margin-bottom: 3pt;
        }

        .education-institution {
            color: #3498db;
            font-size: 10pt;
            margin-bottom: 3pt;
        }

        .education-duration {
            color: #bdc3c7;
            font-size: 9pt;
            font-style: italic;
        }

        .language-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6pt 0;
            border-bottom: 1pt solid #34495e;
        }

        .language-name {
            color: #ecf0f1;
            font-size: 10pt;
        }

        .language-level {
            color: #3498db;
            font-size: 9pt;
            font-weight: 500;
        }

        .main-section {
            margin-bottom: 30pt;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20pt;
            text-transform: uppercase;
            letter-spacing: 1pt;
            position: relative;
            padding-bottom: 8pt;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50pt;
            height: 3pt;
            background: linear-gradient(90deg, #3498db 0%, #2c3e50 100%);
        }

        .profile-text {
            font-size: 11pt;
            line-height: 1.6;
            text-align: justify;
            color: #444444;
            padding: 15pt;
            background: #f8f9fa;
            border-left: 4pt solid #3498db;
            border-radius: 4pt;
        }

        .experience-item {
            margin-bottom: 25pt;
            position: relative;
            padding-left: 20pt;
            page-break-inside: avoid;
        }

        .experience-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 12pt;
            height: 12pt;
            background: #3498db;
            border-radius: 50%;
            border: 3pt solid #ffffff;
            box-shadow: 0 0 0 2pt #3498db;
        }

        .experience-title {
            font-size: 13pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3pt;
        }

        .experience-company {
            font-size: 12pt;
            color: #3498db;
            font-weight: 600;
            margin-bottom: 5pt;
        }

        .experience-duration {
            font-size: 10pt;
            color: #7f8c8d;
            margin-bottom: 10pt;
            font-style: italic;
            background: #ecf0f1;
            padding: 4pt 8pt;
            border-radius: 12pt;
            display: inline-block;
        }

        .experience-description {
            font-size: 11pt;
            line-height: 1.5;
            color: #555555;
            text-align: justify;
        }

        .project-item {
            background: #f8f9fa;
            border: 1pt solid #dee2e6;
            border-radius: 6pt;
            padding: 15pt;
            margin-bottom: 15pt;
            position: relative;
            page-break-inside: avoid;
        }

        .project-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5pt;
        }

        .project-duration {
            font-size: 9pt;
            color: #7f8c8d;
            margin-bottom: 10pt;
            font-style: italic;
        }

        .project-description {
            font-size: 10pt;
            line-height: 1.5;
            color: #555555;
            margin-bottom: 8pt;
        }

        .project-status {
            position: absolute;
            top: 15pt;
            right: 15pt;
            background: #27ae60;
            color: white;
            padding: 4pt 10pt;
            border-radius: 12pt;
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: 600;
        }

        .achievements-list {
            list-style: none;
        }

        .achievement-item {
            position: relative;
            padding-left: 20pt;
            margin-bottom: 12pt;
            font-size: 11pt;
            line-height: 1.5;
            color: #555555;
        }

        .achievement-item::before {
            content: '★';
            position: absolute;
            left: 0;
            color: #f39c12;
            font-size: 12pt;
            top: 2pt;
        }

        .reference-item {
            background: #2c3e50;
            color: #ffffff;
            padding: 12pt;
            border-radius: 6pt;
            margin-bottom: 12pt;
        }

        .reference-name {
            font-weight: bold;
            color: #3498db;
            font-size: 11pt;
            margin-bottom: 3pt;
        }

        .reference-position {
            color: #bdc3c7;
            font-size: 10pt;
            margin-bottom: 5pt;
        }

        .reference-contact {
            color: #ecf0f1;
            font-size: 9pt;
            line-height: 1.4;
        }

        .highlight-box {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 15pt;
            border-radius: 6pt;
            margin-bottom: 20pt;
        }

        .highlight-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }

        .highlight-content {
            font-size: 10pt;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <div class="sidebar">
            <div class="profile-section">
                <div class="profile-image">JS</div>
                <h1 class="name">John Smith</h1>
                <p class="title">Senior Software Developer</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-label">Email:</span>
                        john.smith@email.com
                    </div>
                    <div class="contact-item">
                        <span class="contact-label">Phone:</span>
                        +1 (555) 123-4567
                    </div>
                    <div class="contact-item">
                        <span class="contact-label">LinkedIn:</span>
                        linkedin.com/in/johnsmith
                    </div>
                    <div class="contact-item">
                        <span class="contact-label">Location:</span>
                        San Francisco, CA
                    </div>
                </div>
            </div>

            <section class="sidebar-section">
                <h3 class="sidebar-title">Core Skills</h3>
                <div class="skills-list">
                    <div class="skill-item">
                        JavaScript
                        <span class="skill-level">Expert</span>
                    </div>
                    <div class="skill-item">
                        React/Redux
                        <span class="skill-level">Expert</span>
                    </div>
                    <div class="skill-item">
                        Node.js
                        <span class="skill-level">Advanced</span>
                    </div>
                    <div class="skill-item">
                        Python
                        <span class="skill-level">Advanced</span>
                    </div>
                    <div class="skill-item">
                        PostgreSQL
                        <span class="skill-level">Advanced</span>
                    </div>
                    <div class="skill-item">
                        Docker
                        <span class="skill-level">Intermediate</span>
                    </div>
                    <div class="skill-item">
                        AWS
                        <span class="skill-level">Intermediate</span>
                    </div>
                </div>
            </section>

            <section class="sidebar-section">
                <h3 class="sidebar-title">Education</h3>
                <div class="education-item">
                    <div class="education-degree">Bachelor of Computer Science</div>
                    <div class="education-institution">Stanford University</div>
                    <div class="education-duration">2018 - 2022</div>
                </div>
                <div class="education-item">
                    <div class="education-degree">AWS Certified Solutions Architect</div>
                    <div class="education-institution">Amazon Web Services</div>
                    <div class="education-duration">2023</div>
                </div>
            </section>

            <section class="sidebar-section">
                <h3 class="sidebar-title">Languages</h3>
                <div class="language-item">
                    <span class="language-name">English</span>
                    <span class="language-level">Native</span>
                </div>
                <div class="language-item">
                    <span class="language-name">Spanish</span>
                    <span class="language-level">Advanced</span>
                </div>
                <div class="language-item">
                    <span class="language-name">French</span>
                    <span class="language-level">Intermediate</span>
                </div>
            </section>

            <section class="sidebar-section">
                <h3 class="sidebar-title">References</h3>
                <div class="reference-item">
                    <div class="reference-name">Sarah Johnson</div>
                    <div class="reference-position">Senior Tech Lead</div>
                    <div class="reference-contact">
                        sarah.j@techcorp.com<br>
                        +1 (555) 987-6543
                    </div>
                </div>
            </section>
        </div>

        <div class="main-content">
            <section class="main-section">
                <h2 class="section-title">Professional Summary</h2>
                <div class="highlight-box">
                    <div class="highlight-title">Executive Summary</div>
                    <div class="highlight-content">
                        Results-driven Senior Software Developer with 5+ years of experience architecting and developing enterprise-level applications. Proven expertise in leading cross-functional teams, implementing scalable solutions, and driving digital transformation initiatives. Strong background in full-stack development with focus on performance optimization and user experience.
                    </div>
                </div>
            </section>

            <section class="main-section">
                <h2 class="section-title">Professional Experience</h2>
                <div class="experience-item">
                    <h3 class="experience-title">Senior Software Developer</h3>
                    <div class="experience-company">TechCorp Solutions</div>
                    <div class="experience-duration">January 2022 - Present</div>
                    <p class="experience-description">
                        Lead development of enterprise-level web applications serving 100K+ users. Architected microservices infrastructure reducing system latency by 40%. Mentored junior developers and established coding standards that improved team productivity by 25%. Implemented DevOps practices resulting in 99.9% uptime.
                    </p>
                </div>

                <div class="experience-item">
                    <h3 class="experience-title">Full Stack Developer</h3>
                    <div class="experience-company">StartupXYZ</div>
                    <div class="experience-duration">June 2020 - December 2021</div>
                    <p class="experience-description">
                        Developed responsive web applications using React and Node.js. Implemented CI/CD pipelines reducing deployment time by 60%. Collaborated with product managers to define technical requirements for new features. Built RESTful APIs handling 50K+ daily requests.
                    </p>
                </div>

                <div class="experience-item">
                    <h3 class="experience-title">Junior Developer</h3>
                    <div class="experience-company">WebDev Inc.</div>
                    <div class="experience-duration">March 2019 - May 2020</div>
                    <p class="experience-description">
                        Contributed to front-end development using modern JavaScript frameworks. Participated in code reviews and maintained legacy systems. Assisted in database optimization projects that improved query performance by 30%.
                    </p>
                </div>
            </section>

            <section class="main-section">
                <h2 class="section-title">Key Projects</h2>
                <div class="project-item">
                    <div class="project-status">Completed</div>
                    <h3 class="project-title">E-Commerce Platform Redesign</h3>
                    <div class="project-duration">2023</div>
                    <p class="project-description">
                        Led complete redesign of e-commerce platform handling $2M+ monthly transactions. Implemented modern React architecture with server-side rendering, resulting in 45% improvement in page load times and 20% increase in conversion rates.
                    </p>
                </div>

                <div class="project-item">
                    <div class="project-status">Ongoing</div>
                    <h3 class="project-title">AI-Powered Analytics Dashboard</h3>
                    <div class="project-duration">2023 - Present</div>
                    <p class="project-description">
                        Developing machine learning-powered analytics dashboard for business intelligence. Utilizing Python, TensorFlow, and React to create predictive models and intuitive data visualizations for executive decision-making.
                    </p>
                </div>
            </section>

            <section class="main-section">
                <h2 class="section-title">Key Achievements</h2>
                <ul class="achievements-list">
                    <li class="achievement-item">Led team that won "Innovation Award" for developing ML-powered recommendation system that increased user engagement by 35%</li>
                    <li class="achievement-item">Reduced application load time by 50% through performance optimization and code refactoring initiatives</li>
                    <li class="achievement-item">Mentored 5 junior developers, with 3 receiving promotions within 12 months of guidance</li>
                    <li class="achievement-item">Implemented security protocols that achieved SOC 2 Type II compliance for enterprise clients</li>
                    <li class="achievement-item">Published 2 technical articles on modern web development practices, reaching 10K+ developers</li>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>