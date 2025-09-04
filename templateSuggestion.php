<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Gallery | Geeko CV Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Your existing CSS variables */
            --primary: #29353C;
            --primary-light: #44576D;
            --primary-dark: #1C252B;
            --secondary: #768A96;
            --secondary-light: #9AA9B3;
            --secondary-dark: #5E717D;
            --accent: #AAC7D8;
            --accent-light: #C4DAE8;
            --accent-dark: #8FB4CB;
            --background-light: #DFEBF6;
            --background-dark: #111827;
            --surface: #FFFFFF;
            --surface-dark: #1F2937;
            --text-primary: #1F2937;
            --text-secondary: #5E717D;
            --text-light: #FFFFFF;
            --text-on-primary: #FFFFFF;
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
            --info: #3B82F6;
            --frosted-bg: rgba(255, 255, 255, 0.85);
            --frosted-border: rgba(255, 255, 255, 0.25);
            --frosted-shadow: rgba(0, 0, 0, 0.1);
            --dark-frosted-bg: rgba(17, 24, 39, 0.85);
            --dark-frosted-border: rgba(255, 255, 255, 0.15);
            --dark-frosted-shadow: rgba(0, 0, 0, 0.25);
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-light) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            --gradient-hero: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            --gradient-subtle: linear-gradient(135deg, rgba(41, 53, 60, 0.1) 0%, rgba(118, 138, 150, 0.1) 100%);
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-mono: 'Fira Code', monospace;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.15);
            --shadow-primary: 0 4px 20px rgba(41, 53, 60, 0.2);
            --shadow-secondary: 0 4px 20px rgba(118, 138, 150, 0.2);
            --shadow-accent: 0 4px 20px rgba(170, 199, 216, 0.2);
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background-color: var(--background-light);
            color: var(--text-primary);
            overflow-x: hidden;
            padding-top: 90px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-primary);
        }

        .section {
            padding: 100px 0;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 3.2rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto;
            font-weight: 400;
            line-height: 1.6;
        }

        /* Enhanced Navbar */
        .navbar {
            background: rgba(41, 53, 60, 0.95);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            padding: 15px 0;
            box-shadow: var(--shadow-lg);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 90px;
            transition: var(--transition);
            border-bottom: 1px solid var(--frosted-border);
        }

        .navbar.scrolled {
            background: rgba(17, 24, 39, 0.98);
            height: 80px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 800;
            color: var(--text-light);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            color: var(--accent-light);
            margin-right: 10px;
            transition: var(--transition);
            font-size: 2rem;
        }

        .navbar-brand:hover i {
            transform: rotate(15deg) scale(1.1);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin: 0 15px;
            transition: var(--transition);
            position: relative;
            padding: 8px 0;
            letter-spacing: -0.2px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--text-light);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--accent-light);
            transition: var(--transition);
            border-radius: 2px;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .btn-nav {
            background: var(--accent);
            color: var(--primary-dark);
            border-radius: var(--radius-full);
            padding: 10px 24px;
            font-weight: 600;
            transition: var(--transition-bounce);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 2px solid var(--accent);
            box-shadow: var(--shadow-accent);
        }

        .btn-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--text-light);
            transition: var(--transition);
            z-index: -1;
        }

        .btn-nav:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(170, 199, 216, 0.4);
            color: var(--primary);
        }

        .btn-nav:hover::before {
            width: 100%;
        }

        /* Enhanced Gallery Section */
        .gallery-section {
            background-color: var(--background-light);
            position: relative;
            overflow: hidden;
        }

        .gallery-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(68, 87, 109, 0.05) 0%, transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(118, 138, 150, 0.05) 0%, transparent 30%);
            z-index: 0;
        }

        .template-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            margin-bottom: 4rem;
        }

        .filter-btn {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 0.8rem 1.8rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            transition: var(--transition-bounce);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--gradient-primary);
            transition: var(--transition);
            z-index: -1;
        }

        .filter-btn:hover, .filter-btn.active {
            color: var(--text-light);
            transform: translateY(-3px);
            border-color: transparent;
            box-shadow: var(--shadow-primary);
        }

        .filter-btn:hover::before, .filter-btn.active::before {
            width: 100%;
        }

        /* Enhanced Template Cards */
        .template-card {
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition-bounce);
            position: relative;
            height: 100%;
            margin-bottom: 30px;
            border: 1px solid var(--frosted-border);
            background: var(--frosted-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .template-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: var(--shadow-lg);
        }

        .template-image-container {
            position: relative;
            overflow: hidden;
            height: 280px;
        }

        .template-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .template-card:hover .template-image {
            transform: scale(1.08);
        }

        .template-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(41, 53, 60, 0.9) 0%, rgba(41, 53, 60, 0.4) 50%, transparent 100%);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
            padding: 2rem;
        }

        .template-card:hover .template-overlay {
            opacity: 1;
        }

        .use-template-btn {
            background: var(--accent);
            color: var(--primary-dark);
            border: none;
            padding: 14px 32px;
            border-radius: var(--radius-full);
            font-weight: 600;
            transition: var(--transition-bounce);
            transform: translateY(20px);
            box-shadow: var(--shadow-accent);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .template-card:hover .use-template-btn {
            transform: translateY(0);
        }

        .use-template-btn:hover {
            background: var(--accent-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(170, 199, 216, 0.5);
        }

        .template-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: var(--gradient-accent);
            color: var(--primary-dark);
            padding: 0.6rem 1.4rem;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: var(--shadow-sm);
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .template-card:hover .template-badge {
            transform: scale(1.1) rotate(5deg);
        }

        .template-content {
            padding: 2rem;
            background: transparent;
        }

        .template-title {
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
            color: var(--primary-dark);
            font-weight: 700;
            line-height: 1.3;
        }

        .template-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.6;
        }

        .template-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .template-category {
            background: rgba(118, 138, 150, 0.1);
            padding: 0.4rem 1rem;
            border-radius: var(--radius-full);
            font-weight: 500;
            transition: var(--transition);
        }

        .template-card:hover .template-category {
            background: rgba(118, 138, 150, 0.2);
            transform: translateX(5px);
        }

        .view-more-btn {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1.4rem 3rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            transition: var(--transition-bounce);
            box-shadow: var(--shadow-primary);
            margin-top: 3rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .view-more-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-dark);
            transition: var(--transition);
            z-index: -1;
        }

        .view-more-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(41, 53, 60, 0.4);
        }

        .view-more-btn:hover::before {
            width: 100%;
        }

        /* Enhanced Footer */
        .footer {
            background: var(--dark-frosted-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            color: var(--text-light);
            padding: 5rem 0 0;
            position: relative;
            overflow: hidden;
            border-top: 1px solid var(--dark-frosted-border);
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(41, 53, 60, 0.15) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(118, 138, 150, 0.15) 0%, transparent 25%);
            z-index: 0;
        }

        .footer h5 {
            color: var(--text-light);
            margin-bottom: 1.8rem;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 12px;
            font-weight: 700;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent);
            border-radius: 2px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            display: block;
            margin-bottom: 1rem;
            font-weight: 400;
            position: relative;
            width: fit-content;
        }

        .footer a:hover {
            color: var(--text-light);
            transform: translateX(8px);
        }

        .footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--accent);
            transition: var(--transition);
        }

        .footer a:hover::after {
            width: 100%;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-bounce);
            font-size: 1.3rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-icon:hover {
            background: var(--accent);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 5px 20px rgba(170, 199, 216, 0.4);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.4);
            padding: 25px 0;
            text-align: center;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .section-title {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 992px) {
            .section-title {
                font-size: 2.4rem;
            }
            
            .navbar {
                height: 80px;
            }
            
            .template-image-container {
                height: 240px;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2.2rem;
            }
            
            .section {
                padding: 80px 0;
            }
            
            .template-filter {
                flex-direction: column;
                align-items: center;
            }
            
            .filter-btn {
                width: 220px;
            }
            
            .template-content {
                padding: 1.5rem;
            }
            
            .footer {
                text-align: center;
            }
            
            .footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .footer a {
                margin: 0 auto 1rem;
            }
            
            .social-icons {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 2rem;
            }
            
            .section-subtitle {
                font-size: 1.1rem;
            }
            
            .template-image-container {
                height: 200px;
            }
            
            .use-template-btn {
                padding: 12px 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-file-alt"></i>Geeko CV
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="templateSuggestion.php">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn btn-nav me-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                    <a href="sign_up.php" class="btn btn-nav">
                        <i class="fas fa-user-plus me-2"></i>Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Template Gallery Section -->
    <section class="section gallery-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title animate__animated animate__fadeIn">Professional Templates</h2>
                <p class="section-subtitle animate__animated animate__fadeIn animate__delay-1s">Choose from our collection of professionally designed resume templates that help you stand out</p>
            </div>
            
            <!-- Template Category Filter -->
            <div class="template-filter">
                <button class="filter-btn active" data-filter="all">All Templates</button>
                <button class="filter-btn" data-filter="modern">Modern</button>
                <button class="filter-btn" data-filter="creative">Creative</button>
                <button class="filter-btn" data-filter="professional">Professional</button>
                <button class="filter-btn" data-filter="executive">Executive</button>
            </div>
            
            <div class="row template-container">
                <!-- Template 1 - Modern -->
                <div class="col-lg-4 col-md-6 template-item" data-category="modern">
                    <div class="template-card animate__animated animate__fadeInUp">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1542435503-956c469947f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Modern Minimalist Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">Popular</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Minimalist</h3>
                            <p class="template-description">Clean, modern design perfect for tech and creative roles with ample white space and elegant typography.</p>
                            <div class="template-meta">
                                <span class="template-category">Modern</span>
                                <span><i class="far fa-clock me-1"></i> 2 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 2 - Creative -->
                <div class="col-lg-4 col-md-6 template-item" data-category="creative">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1586281380117-5a60ae2050cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Creative Portfolio Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Portfolio</h3>
                            <p class="template-description">Showcase your work with this visually striking design that highlights your creative projects and achievements.</p>
                            <div class="template-meta">
                                <span class="template-category">Creative</span>
                                <span><i class="far fa-clock me-1"></i> 3 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 3 - Professional -->
                <div class="col-lg-4 col-md-6 template-item" data-category="professional">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1516339901601-2e1b62dc0c45?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Professional Executive Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">New</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Executive</h3>
                            <p class="template-description">Sophisticated layout for senior-level professionals with emphasis on leadership and strategic achievements.</p>
                            <div class="template-meta">
                                <span class="template-category">Professional</span>
                                <span><i class="far fa-clock me-1"></i> 4 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 4 - Modern -->
                <div class="col-lg-4 col-md-6 template-item" data-category="modern">
                    <div class="template-card animate__animated animate__fadeInUp">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Modern Clean Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Clean Lines</h3>
                            <p class="template-description">Modern design with clean typography and ample white space that creates a professional yet contemporary look.</p>
                            <div class="template-meta">
                                <span class="template-category">Modern</span>
                                <span><i class="far fa-clock me-1"></i> 2 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 5 - Creative -->
                <div class="col-lg-4 col-md-6 template-item" data-category="creative">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1545239351-ef35f43d514b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Creative Bold Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">Trending</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Bold Statement</h3>
                            <p class="template-description">Make an impact with this bold and creative design that showcases your personality and unique strengths.</p>
                            <div class="template-meta">
                                <span class="template-category">Creative</span>
                                <span><i class="far fa-clock me-1"></i> 3 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 6 - Executive -->
                <div class="col-lg-4 col-md-6 template-item" data-category="executive">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Executive Classic Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Classic Executive</h3>
                            <p class="template-description">Timeless design for C-level and executive professionals who value tradition and established professionalism.</p>
                            <div class="template-meta">
                                <span class="template-category">Executive</span>
                                <span><i class="far fa-clock me-1"></i> 5 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 7 - Professional -->
                <div class="col-lg-4 col-md-6 template-item" data-category="professional">
                    <div class="template-card animate__animated animate__fadeInUp">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1589652717521-10c0d092dea9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Professional Corporate Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Corporate</h3>
                            <p class="template-description">Professional design perfect for corporate environments with structured layout and formal presentation.</p>
                            <div class="template-meta">
                                <span class="template-category">Professional</span>
                                <span><i class="far fa-clock me-1"></i> 3 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 8 - Modern -->
                <div class="col-lg-4 col-md-6 template-item" data-category="modern">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1586074299757-dc655f18518c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Modern Tech Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">Popular</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Tech Pro</h3>
                            <p class="template-description">Designed specifically for technology professionals with sections for technical skills and project highlights.</p>
                            <div class="template-meta">
                                <span class="template-category">Modern</span>
                                <span><i class="far fa-clock me-1"></i> 2 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 9 - Creative -->
                <div class="col-lg-4 col-md-6 template-item" data-category="creative">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1516633630673-67bbad747022?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Creative Artistic Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Artistic</h3>
                            <p class="template-description">For creatives who want to showcase their unique style with visual elements that reflect artistic sensibility.</p>
                            <div class="template-meta">
                                <span class="template-category">Creative</span>
                                <span><i class="far fa-clock me-1"></i> 4 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 10 - Executive -->
                <div class="col-lg-4 col-md-6 template-item" data-category="executive">
                    <div class="template-card animate__animated animate__fadeInUp">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1593642532744-d377ab507dc8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Executive Modern Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Modern Executive</h3>
                            <p class="template-description">Contemporary design for today's business leaders who want to showcase innovation alongside experience.</p>
                            <div class="template-meta">
                                <span class="template-category">Executive</span>
                                <span><i class="far fa-clock me-1"></i> 4 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 11 - Professional -->
                <div class="col-lg-4 col-md-6 template-item" data-category="professional">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1589656966895-2f33e7653819?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Professional Business Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">New</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Business</h3>
                            <p class="template-description">Professional template for business and finance roles with emphasis on metrics and business impact.</p>
                            <div class="template-meta">
                                <span class="template-category">Professional</span>
                                <span><i class="far fa-clock me-1"></i> 3 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 12 - Modern -->
                <div class="col-lg-4 col-md-6 template-item" data-category="modern">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1585279834655-00e173f7246e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Modern Simple Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Simple Elegance</h3>
                            <p class="template-description">Minimalist design that focuses on your content with clean lines and sophisticated typography hierarchy.</p>
                            <div class="template-meta">
                                <span class="template-category">Modern</span>
                                <span><i class="far fa-clock me-1"></i> 2 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 13 - Creative -->
                <div class="col-lg-4 col-md-6 template-item" data-category="creative">
                    <div class="template-card animate__animated animate__fadeInUp">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1616007736933-54d2525a2c19?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Creative Colorful Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Colorful</h3>
                            <p class="template-description">Vibrant design that stands out from the crowd while maintaining professionalism and readability.</p>
                            <div class="template-meta">
                                <span class="template-category">Creative</span>
                                <span><i class="far fa-clock me-1"></i> 3 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 14 - Executive -->
                <div class="col-lg-4 col-md-6 template-item" data-category="executive">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Executive Leadership Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                            <div class="template-badge">Premium</div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Leadership</h3>
                            <p class="template-description">Designed for executives and senior managers with emphasis on strategic vision and leadership accomplishments.</p>
                            <div class="template-meta">
                                <span class="template-category">Executive</span>
                                <span><i class="far fa-clock me-1"></i> 5 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Template 15 - Professional -->
                <div class="col-lg-4 col-md-6 template-item" data-category="professional">
                    <div class="template-card animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="template-image-container">
                            <img src="https://images.unsplash.com/photo-1568992687947-868a62a9f521?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                 alt="Professional Academic Template" 
                                 class="template-image">
                            <div class="template-overlay">
                                <a href="form.php" class="use-template-btn">
                                    <i class="fas fa-magic me-2"></i>Use Template
                                </a>
                            </div>
                        </div>
                        <div class="template-content">
                            <h3 class="template-title">Academic</h3>
                            <p class="template-description">Perfect for educators, researchers, and academics with sections for publications, research, and teaching experience.</p>
                            <div class="template-meta">
                                <span class="template-category">Professional</span>
                                <span><i class="far fa-clock me-1"></i> 4 min setup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5 animate__animated animate__fadeIn animate__delay-3s">
                <a href="#" class="btn view-more-btn">
                    Load More Templates <i class="fas fa-arrow-down ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h5>About Geeko CV</h5>
                    <p>Creating professional resumes that help you land your dream job. Our AI-powered tools make resume building fast, easy, and effective.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Resume Templates</a></li>
                        <li><a href="#">Cover Letters</a></li>
                        <li><a href="#">Resume Tips</a></li>
                        <li><a href="#">Career Blog</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> support@geekocv.com</li>
                        <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> San Francisco, CA</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2023 Geeko CV Builder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Template Filtering
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const templateItems = document.querySelectorAll('.template-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Filter templates
                    templateItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            // Add animation
                            item.classList.add('animate__fadeIn');
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Animation on scroll
            const animatedElements = document.querySelectorAll('.animate__animated');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.getAttribute('data-animation');
                        entry.target.style.visibility = 'visible';
                        entry.target.classList.add('animate__animated', animation);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            animatedElements.forEach(element => {
                element.style.visibility = 'hidden';
                const animation = element.classList[1].replace('animate__', '');
                element.setAttribute('data-animation', animation);
                observer.observe(element);
            });
        });
    </script>
</body>
</html>