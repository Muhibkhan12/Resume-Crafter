<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Modern Design</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #29353C;        /* Deep Navy - sophisticated and trustworthy */
            --primary-light: #44576D;  /* Slate Blue - for highlights */
            --primary-dark: #1C252B;   /* Darker Navy - for depth */
            --secondary: #768A96;      /* Muted Steel - fresh and energetic */
            --secondary-light: #9AA9B3;/* Lighter Steel */
            --secondary-dark: #5E717D; /* Darker Steel */
            --accent: #AAC7D8;         /* Soft Sky Blue - for attention and warmth */
            --accent-light: #C4DAE8;   /* Light Sky Blue */
            --accent-dark: #8FB4CB;    /* Darker Sky Blue */
            
            /* Neutrals */
            --background-light: #DFEBF6;  /* Light Ice Blue */
            --background-dark: #111827;   /* Deep charcoal */
            --surface: #FFFFFF;           /* Pure white for cards */
            --surface-dark: #1F2937;      /* Dark surface */
            
            /* Text Colors */
            --text-primary: #1F2937;      /* Almost black */
            --text-secondary: #5E717D;    /* Muted gray-blue */
            --text-light: #FFFFFF;        /* Pure white */
            --text-on-primary: #FFFFFF;   /* White on colored backgrounds */
            
            /* Status Colors */
            --success: #10B981;          /* Emerald green */
            --warning: #F59E0B;          /* Amber */
            --error: #EF4444;            /* Coral red */
            --info: #3B82F6;             /* Sky blue */
            
            /* Frosted Glass Effects */
            --frosted-bg: rgba(255, 255, 255, 0.85);
            --frosted-border: rgba(255, 255, 255, 0.25);
            --frosted-shadow: rgba(0, 0, 0, 0.1);
            --dark-frosted-bg: rgba(17, 24, 39, 0.85);
            --dark-frosted-border: rgba(255, 255, 255, 0.15);
            --dark-frosted-shadow: rgba(0, 0, 0, 0.25);
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-light) 100%);
            --gradient-accent: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            --gradient-hero: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            --gradient-subtle: linear-gradient(135deg, rgba(41, 53, 60, 0.1) 0%, rgba(118, 138, 150, 0.1) 100%);
            
            /* Fonts */
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-mono: 'Fira Code', monospace;
            
            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.15);
            --shadow-primary: 0 4px 20px rgba(41, 53, 60, 0.2);
            --shadow-secondary: 0 4px 20px rgba(118, 138, 150, 0.2);
            --shadow-accent: 0 4px 20px rgba(170, 199, 216, 0.2);
            
            /* Transitions */
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            
            /* Border Radius */
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

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-primary);
            background: var(--background-light);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* === SUBTLE BACKGROUND PATTERN === */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 25% 25%, rgba(67, 97, 238, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(247, 37, 133, 0.02) 0%, transparent 50%);
            z-index: -1;
        }

        /* Enhanced Navbar */
        .navbar {
            background: var(--primary);
            padding: 15px 0;
            box-shadow: var(--shadow-lg);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 90px;
            transition: var(--transition);
        }
        
        .navbar.scrolled {
            background: var(--primary-dark);
            height: 80px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }
        
        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--text-light);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .navbar-brand i {
            color: var(--accent);
            margin-right: 10px;
            transition: var(--transition);
        }
        
        .navbar-brand:hover {
            color: var(--text-light);
        }
        
        .navbar-brand:hover i {
            transform: rotate(15deg);
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 2rem;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            padding: 8px 0;
            text-decoration: none;
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
            background: var(--accent);
            transition: var(--transition);
            border-radius: 2px;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .navbar-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn-nav {
            background: var(--accent);
            color: var(--primary);
            border-radius: var(--radius-full);
            padding: 10px 20px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 2px solid var(--accent);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
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
            transform: translateY(-2px);
            box-shadow: var(--shadow-accent);
            color: var(--primary);
        }
        
        .btn-nav:hover::before {
            width: 100%;
        }

        /* Mobile Menu Toggle */
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* === HERO SECTION === */
        .hero {
            background: var(--gradient-hero);
            color: var(--text-light);
            padding: 8rem 0 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='9' cy='9' r='1'/%3E%3Ccircle cx='49' cy='49' r='1'/%3E%3Ccircle cx='29' cy='29' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease 0.2s forwards;
        }

        .hero h1 {
            font-family: var(--font-heading);
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease 0.4s forwards;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.3rem);
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease 0.6s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === MAIN CONTENT === */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        section {
            padding: 6rem 0;
        }

        /* === STORY SECTION === */
        .story-section {
            background: var(--background-light);
        }

        .story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
        }

        .story-content {
            opacity: 0;
            transform: translateX(-30px);
            transition: var(--transition);
        }

        .story-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .section-badge {
            display: inline-block;
            background: var(--primary);
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .story-text {
            font-size: 1.1rem;
            color: var(--text-primary);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .story-visual {
            position: relative;
            opacity: 0;
            transform: translateX(30px);
            transition: var(--transition);
        }

        .story-visual.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .story-image {
            width: 100%;
            height: 400px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .story-image:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .story-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .story-image:hover img {
            transform: scale(1.05);
        }

        /* === VALUES SECTION === */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .value-card {
            background: var(--surface);
            border: 1px solid var(--secondary-light);
            border-radius: var(--radius-lg);
            padding: 3rem 2rem;
            text-align: center;
            transition: var(--transition);
            opacity: 0;
            transform: translateY(30px);
            box-shadow: var(--shadow-sm);
        }

        .value-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .value-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .value-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: var(--text-light);
            transition: var(--transition);
        }

        .value-card:hover .value-icon {
            transform: scale(1.1);
            background: var(--accent);
        }

        .value-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .value-desc {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* === TEAM SECTION === */
        .team-section {
            background: var(--background-light);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .team-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            opacity: 0;
            transform: translateY(30px);
        }

        .team-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .team-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-10px);
        }

        .team-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .team-card:hover .team-image img {
            transform: scale(1.1);
        }

        .team-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(41, 53, 60, 0.8), rgba(118, 138, 150, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .team-card:hover .team-overlay {
            opacity: 1;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--text-light);
            color: var(--primary);
            transform: scale(1.1);
        }

        .team-info {
            padding: 1.5rem;
            text-align: center;
        }

        .team-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .team-role {
            color: var(--accent-dark);
            font-weight: 500;
        }

        /* === STATS SECTION === */
        .stats-section {
            background: var(--gradient-hero);
            color: var(--text-light);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            text-align: center;
        }

        .stat-item {
            opacity: 0;
            transform: translateY(30px);
            transition: var(--transition);
        }

        .stat-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-light);
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* === CTA SECTION === */
        .cta-section {
            text-align: center;
            background: var(--background-light);
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(30px);
            transition: var(--transition);
        }

        .cta-content.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cta-title {
            font-family: var(--font-heading);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .cta-text {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--text-light);
            border: 2px solid var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--text-light);
            transform: translateY(-2px);
        }
        #ourImpact {
            color: white;
        }

        /* Creative Enhanced Footer */
        .footer {
            background: var(--background-dark);
            color: var(--text-light);
            padding: 5rem 0 0;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 10% 20%, rgba(76, 201, 240, 0.1) 0%, transparent 15%),
                radial-gradient(circle at 90% 80%, rgba(247, 37, 133, 0.1) 0%, transparent 15%),
                radial-gradient(circle at 30% 60%, rgba(67, 97, 238, 0.1) 0%, transparent 15%);
            z-index: 0;
        }

        .footer-main {
            padding-bottom: 3rem;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 3rem;
        }

        .footer h5 {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 10px;
            font-weight: 600;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent);
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            display: block;
            margin-bottom: 0.8rem;
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

        .footer-contact li {
            display: flex;
            margin-bottom: 1rem;
            font-weight: 400;
            align-items: flex-start;
        }

        .footer-contact i {
            color: var(--accent);
            margin-right: 10px;
            min-width: 20px;
            font-size: 1.2rem;
            margin-top: 4px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 1.5rem;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
            color: var(--text-light);
        }

        .social-icon:hover {
            background: var(--accent);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 5px 15px rgba(170, 199, 216, 0.3);
            color: var(--primary);
        }

        .newsletter-form {
            display: flex;
            margin-top: 1.5rem;
            border-radius: var(--radius-full);
            overflow: hidden;
            box-shadow: var(--shadow);
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .newsletter-form input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            font-size: 1rem;
            outline: none;
            font-weight: 400;
            background: transparent;
            color: var(--text-light);
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .newsletter-form button {
            background: var(--accent);
            color: var(--primary);
            border: none;
            padding: 0 25px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .newsletter-form button:hover {
            background: var(--accent-light);
            transform: scale(1.05);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            padding: 25px 0;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 400;
            position: relative;
            z-index: 1;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .footer-logo i {
            color: var(--accent);
            margin-right: 10px;
            font-size: 2rem;
        }

        .footer-slogan {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.5rem;
            font-size: 1rem;
            font-weight: 300;
            max-width: 400px;
        }

        .footer-column {
            margin-bottom: 2rem;
        }

        .footer-badge {
            background: rgba(170, 199, 216, 0.2);
            color: var(--accent);
            padding: 8px 15px;
            border-radius: var(--radius-full);
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border: 1px solid rgba(170, 199, 216, 0.3);
        }

        /* === RESPONSIVE === */
        @media (max-width: 1024px) {
            .story-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }
            
            .story-visual {
                order: -1;
            }

            .footer-main {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }

            .navbar-toggler {
                display: block;
            }

            .hero {
                padding: 6rem 0 4rem;
            }
            
            section {
                padding: 4rem 0;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .footer-main {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        /* === SCROLL ANIMATIONS === */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: var(--transition);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Enhanced Navbar - Updated to match index.php -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-file-alt"></i>Geeko CV
            </a>
            
            <button class="navbar-toggler" type="button">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-nav">
                <li><a class="nav-link" href="index.php">Home</a></li>
                <li><a class="nav-link" href="#templates">Templates</a></li>
                <li class="nav-item">
                        <a  class="nav-link" href="history.php">History</a>
                    </li>
                <li><a class="nav-link active" href="about.php">About Us</a></li>
                <li><a class="nav-link" href="contact.php">Contact Us</a></li>
            </ul>
            
            <div class="navbar-buttons">
                <a href="login.php" class="btn-nav">
                    <i class="fas fa-sign-in-alt"></i>Login
                </a>
                <a href="sign_up.php" class="btn-nav">
                    <i class="fas fa-user-plus"></i>Sign Up
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-award"></i>
                <span>Professional Resume Building</span>
            </div>
            <h1>About Geeko CV</h1>
            <p class="hero-subtitle">Empowering professionals worldwide with beautifully crafted resumes that open doors to new opportunities</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="story-section">
        <div class="container">
            <div class="story-grid">
                <div class="story-content">
                    <div class="section-badge">Our Story</div>
                    <h2 class="section-title">Crafting Success Stories Since 2020</h2>
                    <p class="story-text">Geeko CV was founded with a simple yet powerful vision: to help talented professionals showcase their potential through expertly designed resumes. What began as a small project has grown into a trusted platform serving over 250,000 users worldwide.</p>
                    <p class="story-text">Our journey started when our founders recognized the gap between talent and opportunity. Too many qualified candidates were being overlooked due to poorly formatted resumes that failed to highlight their achievements.</p>
                    <p class="story-text">Today, we combine innovative design with proven hiring insights to create resumes that not only look professional but also perform exceptionally well with both applicant tracking systems and human recruiters.</p>
                </div>
                <div class="story-visual">
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Geeko CV Team">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="reveal">
                <div class="section-badge">Our Values</div>
                <h2 class="section-title">What Drives Us Forward</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="value-title">Innovation</h3>
                        <p class="value-desc">We continuously evolve our platform with the latest design trends and recruitment insights to keep your resume ahead of the competition.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="value-title">User-Centric</h3>
                        <p class="value-desc">Every feature is designed with our users in mind, making the resume creation process intuitive, efficient, and stress-free.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="value-title">Excellence</h3>
                        <p class="value-desc">We maintain the highest standards in design quality and functionality, ensuring every resume meets professional expectations.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="value-title">Trust</h3>
                        <p class="value-desc">Your privacy and data security are our top priorities. We handle your information with the utmost care and confidentiality.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="value-title">Support</h3>
                        <p class="value-desc">Our dedicated support team is always ready to help you succeed, providing guidance throughout your resume creation journey.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="value-title">Accessibility</h3>
                        <p class="value-desc">We believe everyone deserves access to professional resume tools, regardless of their background or experience level.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="reveal">
                <div class="section-badge">Our Team</div>
                <h2 class="section-title">Meet the People Behind Geeko CV</h2>
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ghulam Mustafa">
                            <div class="team-overlay">
                                <div class="social-links">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <div class="team-name">Ghulam Mustafa</div>
                            <div class="team-role">Web Developer</div>
                        </div>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Muhib Khan">
                            <div class="team-overlay">
                                <div class="social-links">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-dribbble"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <div class="team-name">Muhib Khan</div>
                            <div class="team-role">Web Developer</div>
                        </div>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ayesha Abideen">
                            <div class="team-overlay">
                                <div class="social-links">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-medium"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <div class="team-name">Ayesha Abideen</div>
                            <div class="team-role">Web Developer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="reveal">
                <div class="section-badge">Our Impact</div>
                <h2 id="ourImpact" class="section-title text-light">Numbers That Tell Our Story</h2>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number" data-target="250">0</span>
                        <div class="stat-label">K+ Resumes Created</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="97">0</span>
                        <div class="stat-label">% Success Rate</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="50">0</span>
                        <div class="stat-label">+ Professional Templates</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="24">0</span>
                        <div class="stat-label">24/7 Customer Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Build Your Professional Resume?</h2>
                <p class="cta-text">Join thousands of professionals who have successfully landed their dream jobs with Geeko CV. Create your standout resume today.</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Create Resume</span>
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <i class="fas fa-eye"></i>
                        <span>View Templates</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-main">
                <div class="footer-column">
                    <div class="footer-logo">
                        <i class="fas fa-file-alt"></i>Geeko CV
                    </div>
                    <p class="footer-slogan">Creating professional resumes that help you land your dream job.</p>
                    <p class="mb-4">Our AI-powered tools make resume building fast, easy, and effective.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Resume Templates</a></li>
                        <li><a href="#">Cover Letters</a></li>
                        <li><a href="#">Resume Tips</a></li>
                        <li><a href="#">Career Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <div class="footer-badge">
                        <i class="fas fa-envelope me-2"></i> Subscribe to our newsletter
                    </div>
                    <p>Get resume tips and career advice directly to your inbox</p>
                    <div class="newsletter-form">
                        <input type="email" class="form-control" placeholder="Your email address">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                    
                    <h5 class="mt-4">Contact Us</h5>
                    <ul class="list-unstyled footer-contact">
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>support@geekocv.com</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>San Francisco, CA</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="container">
                    <p class="mb-0">&copy; 2023 Geeko CV Builder. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> for job seekers</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all elements with animation classes
        document.querySelectorAll('.reveal, .story-content, .story-visual, .value-card, .team-card, .stat-item, .cta-content').forEach(el => {
            observer.observe(el);
        });

        // Animated counter for stats
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            };
            
            updateCounter();
        }

        // Observer for stats animation
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target.querySelector('.stat-number');
                    if (counter && !counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        animateCounter(counter);
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-item').forEach(item => {
            statsObserver.observe(item);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced button interactions
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Mobile menu toggle (basic functionality)
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            const nav = document.querySelector('.navbar-nav');
            nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
        });

        // Animate footer elements on scroll
        const footerElements = document.querySelectorAll('.footer .footer-column');
        const footerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });
        
        footerElements.forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.6s ease';
            footerObserver.observe(element);
        });
    </script>
</body>
</html>