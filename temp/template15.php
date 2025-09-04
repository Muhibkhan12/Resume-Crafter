<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 20mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.5;
            color: #1a1a1a;
            font-size: 11pt;
            background: #ffffff;
        }

        .cv-container {
            width: 100%;
            max-width: 100%;
            background: white;
        }

        .header {
            text-align: center;
            padding-bottom: 20pt;
            border-bottom: 3pt solid #2c3e50;
            margin-bottom: 25pt;
        }

        .name {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 5pt;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 2pt;
            font-family: 'Arial', sans-serif;
        }

        .title {
            font-size: 14pt;
            margin-bottom: 15pt;
            color: #34495e;
            font-style: italic;
            font-weight: 300;
        }

        .contact-info {
            font-size: 11pt;
            line-height: 1.6;
            color: #2c3e50;
        }

        .contact-line {
            margin-bottom: 3pt;
        }

        .divider {
            text-align: center;
            margin: 20pt 0;
            color: #34495e;
            font-size: 14pt;
        }

        .section {
            margin-bottom: 25pt;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1pt;
            margin-bottom: 12pt;
            padding-bottom: 5pt;
            border-bottom: 1pt solid #bdc3c7;
            font-family: 'Arial', sans-serif;
        }

        .subsection-title {
            font-size: 12pt;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 8pt;
            margin-top: 15pt;
        }

        .two-column {
            display: table;
            width: 100%;
        }

        .column-left {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding-right: 15pt;
        }

        .column-right {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding-left: 15pt;
        }

        .profile-text {
            font-size: 11pt;
            line-height: 1.6;
            text-align: justify;
            color: #2c3e50;
            text-indent: 20pt;
        }

        .experience-entry {
            margin-bottom: 20pt;
            page-break-inside: avoid;
        }

        .job-header {
            margin-bottom: 8pt;
        }

        .job-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
            display: inline;
        }

        .job-separator {
            font-weight: bold;
            margin: 0 8pt;
            color: #7f8c8d;
        }

        .company-name {
            font-size: 12pt;
            color: #34495e;
            font-weight: 600;
            display: inline;
        }

        .job-duration {
            font-size: 10pt;
            color: #7f8c8d;
            font-style: italic;
            margin-bottom: 8pt;
            display: block;
        }

        .job-description {
            font-size: 11pt;
            line-height: 1.5;
            color: #2c3e50;
            text-align: justify;
        }

        .education-entry {
            margin-bottom: 15pt;
            padding-bottom: 12pt;
            border-bottom: 1pt dotted #bdc3c7;
        }

        .education-entry:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .degree-info {
            display: table;
            width: 100%;
            margin-bottom: 5pt;
        }

        .degree-left {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }

        .degree-right {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: right;
        }

        .degree-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 11pt;
        }

        .institution-name {
            color: #34495e;
            font-size: 10pt;
            font-style: italic;
        }

        .degree-year {
            color: #7f8c8d;
            font-size: 10pt;
            font-style: italic;
        }

        .skills-section {
            margin-bottom: 20pt;
        }

        .skills-category {
            margin-bottom: 15pt;
        }

        .skills-category-title {
            font-size: 11pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8pt;
            text-decoration: underline;
        }

        .skills-list {
            font-size: 10pt;
            color: #34495e;
            line-height: 1.6;
        }

        .language-table {
            width: 100%;
            border-collapse: collapse;
        }

        .language-row {
            border-bottom: 1pt solid #ecf0f1;
        }

        .language-cell {
            padding: 8pt 0;
            vertical-align: top;
        }

        .language-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 10pt;
            width: 60%;
        }

        .language-level {
            color: #34495e;
            font-size: 10pt;
            text-align: right;
        }

        .project-entry {
            margin-bottom: 18pt;
            page-break-inside: avoid;
        }

        .project-header {
            display: table;
            width: 100%;
            margin-bottom: 8pt;
        }

        .project-title-cell {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }

        .project-date-cell {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: right;
        }

        .project-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
        }

        .project-date {
            font-size: 10pt;
            color: #7f8c8d;
            font-style: italic;
        }

        .project-description {
            font-size: 11pt;
            line-height: 1.5;
            color: #2c3e50;
            text-align: justify;
            margin-bottom: 5pt;
        }

        .project-status {
            font-size: 9pt;
            color: #27ae60;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }

        .achievements-list {
            list-style: none;
        }

        .achievement-item {
            position: relative;
            padding-left: 15pt;
            margin-bottom: 10pt;
            font-size: 11pt;
            line-height: 1.5;
            color: #2c3e50;
            text-align: justify;
        }

        .achievement-item::before {
            content: '▶';
            position: absolute;
            left: 0;
            color: #34495e;
            font-size: 8pt;
            top: 3pt;
        }

        .reference-table {
            width: 100%;
            border-collapse: collapse;
        }

        .reference-row {
            border-bottom: 2pt solid #ecf0f1;
            margin-bottom: 15pt;
        }

        .reference-cell {
            padding: 12pt 0;
            vertical-align: top;
        }

        .reference-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 12pt;
            margin-bottom: 3pt;
        }

        .reference-title {
            color: #34495e;
            font-size: 11pt;
            margin-bottom: 3pt;
            font-style: italic;
        }

        .reference-company {
            color: #34495e;
            font-size: 10pt;
            margin-bottom: 5pt;
        }

        .reference-contact {
            color: #7f8c8d;
            font-size: 10pt;
            line-height: 1.4;
        }

        .certification-entry {
            margin-bottom: 12pt;
            padding: 12pt;
            background: #f8f9fa;
            border: 1pt solid #dee2e6;
            border-left: 4pt solid #2c3e50;
        }

        .cert-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 11pt;
            margin-bottom: 3pt;
        }

        .cert-issuer {
            color: #34495e;
            font-size: 10pt;
            margin-bottom: 3pt;
        }

        .cert-date {
            color: #7f8c8d;
            font-size: 9pt;
            font-style: italic;
        }

        .footer {
            text-align: center;
            margin-top: 30pt;
            padding-top: 15pt;
            border-top: 1pt solid #bdc3c7;
            color: #7f8c8d;
            font-size: 10pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <header class="header">
            <h1 class="name">John Alexander Smith</h1>
            <p class="title">Senior Software Developer & Technology Leader</p>
            <div class="contact-info">
                <div class="contact-line">john.smith@email.com | +1 (555) 123-4567</div>
                <div class="contact-line">LinkedIn: linkedin.com/in/johnsmith | Portfolio: www.johnsmith.dev</div>
                <div class="contact-line">San Francisco, California, United States</div>
            </div>
        </header>

        <section class="section">
            <h2 class="section-title">Professional Summary</h2>
            <p class="profile-text">
                Accomplished Senior Software Developer with over five years of experience in designing, developing, and implementing enterprise-level software solutions. Proven expertise in full-stack development, team leadership, and project management. Demonstrated ability to translate complex business requirements into scalable technical solutions while maintaining high standards of code quality and performance. Committed to continuous learning and innovation in rapidly evolving technology landscapes.
            </p>
        </section>

        <div class="two-column">
            <div class="column-left">
                <section class="section">
                    <h2 class="section-title">Professional Experience</h2>
                    
                    <div class="experience-entry">
                        <div class="job-header">
                            <span class="job-title">Senior Software Developer</span>
                            <span class="job-separator">|</span>
                            <span class="company-name">TechCorp Solutions</span>
                        </div>
                        <div class="job-duration">January 2022 - Present</div>
                        <div class="job-description">
                            Lead development of enterprise-level web applications serving over 100,000 active users. Architect and implement microservices infrastructure that reduced system latency by 40% and improved scalability. Mentor junior developers and establish coding standards that enhanced team productivity by 25%. Collaborate with cross-functional teams to deliver high-quality software solutions on schedule and within budget.
                        </div>
                    </div>

                    <div class="experience-entry">
                        <div class="job-header">
                            <span class="job-title">Full Stack Developer</span>
                            <span class="job-separator">|</span>
                            <span class="company-name">StartupXYZ</span>
                        </div>
                        <div class="job-duration">June 2020 - December 2021</div>
                        <div class="job-description">
                            Developed responsive web applications using modern JavaScript frameworks including React and Node.js. Implemented comprehensive CI/CD pipelines that reduced deployment time by 60% and minimized production errors. Collaborated closely with product managers and designers to define technical requirements and deliver feature-rich applications that exceeded user expectations.
                        </div>
                    </div>

                    <div class="experience-entry">
                        <div class="job-header">
                            <span class="job-title">Software Developer</span>
                            <span class="job-separator">|</span>
                            <span class="company-name">WebDev Solutions Inc.</span>
                        </div>
                        <div class="job-duration">March 2019 - May 2020</div>
                        <div class="job-description">
                            Contributed to front-end and back-end development of client-facing web applications. Participated in code reviews, maintained legacy systems, and assisted in database optimization projects that improved query performance by 30%. Gained valuable experience in agile development methodologies and version control systems.
                        </div>
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Key Projects</h2>
                    
                    <div class="project-entry">
                        <div class="project-header">
                            <div class="project-title-cell">
                                <h4 class="project-title">Enterprise E-Commerce Platform</h4>
                            </div>
                            <div class="project-date-cell">
                                <div class="project-date">2023</div>
                            </div>
                        </div>
                        <div class="project-description">
                            Architected and developed comprehensive e-commerce solution with real-time inventory management, integrated payment processing, and advanced analytics dashboard. Implemented using React, Node.js, PostgreSQL, and AWS services.
                        </div>
                        <div class="project-status">Status: Successfully Deployed</div>
                    </div>

                    <div class="project-entry">
                        <div class="project-header">
                            <div class="project-title-cell">
                                <h4 class="project-title">Machine Learning Analytics Dashboard</h4>
                            </div>
                            <div class="project-date-cell">
                                <div class="project-date">2023 - Ongoing</div>
                            </div>
                        </div>
                        <div class="project-description">
                            Leading development of AI-powered analytics platform that provides predictive insights for business decision-making. Utilizing Python, TensorFlow, and React to create intuitive data visualizations and automated reporting systems.
                        </div>
                        <div class="project-status">Status: In Development</div>
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Notable Achievements</h2>
                    <ul class="achievements-list">
                        <li class="achievement-item">Led development team that received "Innovation Excellence Award" for creating machine learning-powered recommendation system that increased user engagement by 35% and revenue by 18%</li>
                        <li class="achievement-item">Successfully reduced application load time by 50% through comprehensive performance optimization and code refactoring initiatives</li>
                        <li class="achievement-item">Mentored and guided five junior developers, resulting in three promotions and significant skill advancement within 12-month period</li>
                        <li class="achievement-item">Implemented robust security protocols and best practices that achieved SOC 2 Type II compliance for enterprise client requirements</li>
                        <li class="achievement-item">Published two technical articles on modern web development practices that reached over 10,000 developers in the community</li>
                    </ul>
                </section>
            </div>

            <div class="column-right">
                <section class="section">
                    <h2 class="section-title">Technical Expertise</h2>
                    
                    <div class="skills-section">
                        <div class="skills-category">
                            <h4 class="skills-category-title">Programming Languages</h4>
                            <div class="skills-list">JavaScript (ES6+), Python, TypeScript, Java, C++, SQL</div>
                        </div>
                        
                        <div class="skills-category">
                            <h4 class="skills-category-title">Frontend Technologies</h4>
                            <div class="skills-list">React, Vue.js, Angular, HTML5, CSS3, SASS, Bootstrap, Tailwind CSS</div>
                        </div>
                        
                        <div class="skills-category">
                            <h4 class="skills-category-title">Backend & Database</h4>
                            <div class="skills-list">Node.js, Express.js, Django, PostgreSQL, MongoDB, Redis, MySQL</div>
                        </div>
                        
                        <div class="skills-category">
                            <h4 class="skills-category-title">DevOps & Tools</h4>
                            <div class="skills-list">Docker, Kubernetes, AWS, Git, Jenkins, CI/CD, Linux, Nginx</div>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Education & Certifications</h2>
                    
                    <div class="education-entry">
                        <div class="degree-info">
                            <div class="degree-left">
                                <div class="degree-name">Bachelor of Science in Computer Science</div>
                                <div class="institution-name">Stanford University</div>
                            </div>
                            <div class="degree-right">
                                <div class="degree-year">2018 - 2022</div>
                            </div>
                        </div>
                    </div>

                    <h3 class="subsection-title">Professional Certifications</h3>
                    
                    <div class="certification-entry">
                        <div class="cert-name">AWS Certified Solutions Architect</div>
                        <div class="cert-issuer">Amazon Web Services</div>
                        <div class="cert-date">Issued: March 2023</div>
                    </div>

                    <div class="certification-entry">
                        <div class="cert-name">Google Cloud Professional Developer</div>
                        <div class="cert-issuer">Google Cloud Platform</div>
                        <div class="cert-date">Issued: August 2022</div>
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Languages</h2>
                    <table class="language-table">
                        <tr class="language-row">
                            <td class="language-cell language-name">English</td>
                            <td class="language-cell language-level">Native Speaker</td>
                        </tr>
                        <tr class="language-row">
                            <td class="language-cell language-name">Spanish</td>
                            <td class="language-cell language-level">Advanced (C1)</td>
                        </tr>
                        <tr class="language-row">
                            <td class="language-cell language-name">French</td>
                            <td class="language-cell language-level">Intermediate (B2)</td>
                        </tr>
                        <tr class="language-row">
                            <td class="language-cell language-name">Mandarin</td>
                            <td class="language-cell language-level">Beginner (A2)</td>
                        </tr>
                    </table>
                </section>

                <section class="section">
                    <h2 class="section-title">Professional References</h2>
                    
                    <div class="reference-table">
                        <div class="reference-row">
                            <div class="reference-cell">
                                <div class="reference-name">Sarah Johnson</div>
                                <div class="reference-title">Senior Technology Lead</div>
                                <div class="reference-company">TechCorp Solutions</div>
                                <div class="reference-contact">
                                    Email: sarah.j@techcorp.com<br>
                                    Phone: +1 (555) 987-6543
                                </div>
                            </div>
                        </div>
                        
                        <div class="reference-row">
                            <div class="reference-cell">
                                <div class="reference-name">Michael Rodriguez</div>
                                <div class="reference-title">Product Manager</div>
                                <div class="reference-company">StartupXYZ</div>
                                <div class="reference-contact">
                                    Email: m.rodriguez@startupxyz.com<br>
                                    Phone: +1 (555) 654-3210
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="divider">◆ ◆ ◆</div>

        <footer class="footer">
            <p>This resume represents a comprehensive overview of professional qualifications and experience.<br>
            Additional portfolio materials and code samples available upon request.</p>
        </footer>
    </div>
</body>
</html>