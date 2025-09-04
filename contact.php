<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Geeko CV Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- <style>
        :root {
            --primary: #008080;
            --primary-light: #4da6a6;
            --primary-dark: #006666;
            --secondary: #f8f9fa;
            --text: #333;
            --text-light: #fff;
            --accent: #00b3b3;
            --highlight: #00cccc;
            --light: #f5f6fa;
            --dark: #2d3436;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --border-radius: 8px;
            --transition: all 0.3s ease;
            --shadow-sm: 0 2px 6px rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.15);
            /* Fonts */
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--text);
            line-height: 1.8;
            overflow-x: hidden;
            font-weight: 400;
            padding-top: 90px; /* Account for fixed navbar */
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn,
        .form-label,
        .step {
            font-family: 'Inter', sans-serif;
        }

        /* Enhanced Navbar from index.php */
        .navbar {
            background: var(--primary-dark);
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
            background: var(--dark);
            height: 80px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--text-light);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .navbar-brand i {
            color: var(--highlight);
            margin-right: 10px;
            transition: var(--transition);
        }
        
        .navbar-brand:hover i {
            transform: rotate(15deg);
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            margin: 0 15px;
            transition: var(--transition);
            position: relative;
            padding: 8px 0;
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
            background: var(--highlight);
            transition: var(--transition);
            border-radius: 2px;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        .navbar-toggler {
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
        }
        
        .btn-nav {
            background: var(--accent);
            color: var(--text-light);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 2px solid var(--accent);
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
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.3);
            color: var(--primary);
        }
        
        .btn-nav:hover::before {
            width: 100%;
        }

        /* Split-screen layout */
        .split-container {
            display: flex;
            min-height: 100vh;
            margin-top: -90px; /* Offset navbar height */
            padding-top: 90px; /* Add padding for content */
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            color: var(--text-light);
        }

        .right-panel {
            flex: 1;
            background-color: var(--secondary);
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Left panel styling */
        .contact-intro {
            max-width: 600px;
            position: relative;
            z-index: 2;
        }

        .contact-intro h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-light);
            animation: textReveal 1.5s ease;
            font-weight: 700;
            line-height: 1.2;
        }

        .contact-intro p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
            animation: fadeInUp 1s ease 0.3s both;
            font-style: italic;
            font-weight: 300;
        }

        .contact-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .method-card {
            background: rgba(67, 97, 238, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: var(--transition);
            backdrop-filter: blur(5px);
            box-shadow: var(--shadow);
        }

        .method-card:hover {
            transform: translateY(-5px);
            background: rgba(67, 97, 238, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow-hover);
        }

        .method-card i {
            font-size: 1.8rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .method-card:hover i {
            transform: scale(1.2);
        }

        .method-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--text-light);
            font-weight: 600;
        }

        .method-card p,
        .method-card a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            transition: color 0.3s ease;
            font-weight: 300;
        }

        .method-card a {
            display: inline-block;
            margin-top: 0.5rem;
            text-decoration: none;
            color: var(--text-light);
            font-style: italic;
            position: relative;
            font-weight: 400;
        }

        .method-card a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--text-light);
            transition: width 0.3s ease;
        }

        .method-card a:hover {
            color: var(--text-light);
        }

        .method-card a:hover::after {
            width: 100%;
        }

        /* Decorative elements */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(72, 149, 239, 0.1) 0%, transparent 70%);
            animation: pulse 12s infinite linear;
            z-index: 1;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(247, 37, 133, 0.05);
            filter: blur(30px);
            animation: float 15s infinite linear;
        }

        /* Resume-themed decorative elements */
        .resume-decoration {
            position: absolute;
            top: 20%;
            right: 10%;
            width: 100px;
            height: 140px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: rotate(5deg);
            z-index: 1;
            animation: floatResume 20s infinite linear;
            border-radius: 4px;
        }

        .resume-decoration::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .resume-decoration::after {
            content: '';
            position: absolute;
            top: 30px;
            left: 10px;
            width: 60px;
            height: 5px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Right panel styling */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            width: 100%;
        }

        .form-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .form-header h2 {
            font-size: 2.4rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
            font-weight: 600;
        }

        .form-header h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform-origin: left;
            animation: lineGrow 1s ease-out;
        }

        .form-header p {
            color: var(--text);
            font-size: 1.1rem;
            font-style: italic;
            font-weight: 300;
        }

        /* Interactive form styles */
        .form-stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary);
            border: 2px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
            position: relative;
            z-index: 2;
            transition: var(--transition);
        }

        .step.active {
            background: var(--primary);
            color: var(--text-light);
            border-color: var(--primary);
        }

        .step.completed {
            background: var(--accent);
            border-color: var(--accent);
            color: var(--text-light);
        }

        .step-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(67, 97, 238, 0.2);
            transform: translateY(-50%);
            z-index: 1;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            height: 1px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: translateY(-50%);
            z-index: 1;
            transition: width 0.5s ease;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.8rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text);
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--gray-light);
            border-radius: var(--border-radius);
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            transition: var(--transition);
            background: var(--light);
            color: var(--text);
            font-weight: 400;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .radio-option {
            flex: 1;
        }

        .radio-input {
            display: none;
        }

        .radio-label {
            display: block;
            padding: 1rem;
            border: 1px solid var(--gray-light);
            border-radius: var(--border-radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--text);
            font-weight: 400;
        }

        .radio-input:checked+.radio-label {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
            color: var(--primary);
            font-weight: 500;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .checkbox-input {
            margin-right: 0.5rem;
            accent-color: var(--primary);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2.5rem;
        }

        .form-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            letter-spacing: 0.5px;
            box-shadow: var(--shadow);
        }

        .btn-next {
            background: linear-gradient(45deg, var(--primary), var(--primary-light));
            color: var(--text-light);
        }

        .btn-prev {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--gray-light);
        }

        .btn-submit {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            color: var(--text-light);
            width: 100%;
        }

        .form-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Success message */
        .success-message {
            text-align: center;
            display: none;
            animation: fadeIn 0.5s ease;
            padding: 2rem;
            background: var(--light);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .success-message i {
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
            animation: bounceIn 0.8s ease;
        }

        .success-message h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
            font-weight: 700;
        }

        .success-message p {
            color: var(--text);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Creative Enhanced Footer */
        .footer {
            background: var(--dark);
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
            background: var(--highlight);
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
            background: var(--highlight);
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
            color: var(--highlight);
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
        }

        .social-icon:hover {
            background: var(--accent);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 5px 15px rgba(247, 37, 133, 0.3);
        }

        .newsletter-form {
            display: flex;
            margin-top: 1.5rem;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
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
            color: white;
            border: none;
            padding: 0 25px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .newsletter-form button:hover {
            background: var(--primary-light);
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
            color: var(--highlight);
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
            background: rgba(76, 201, 240, 0.2);
            color: var(--highlight);
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        /* Animations */
        @keyframes textReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.4;
            }

            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(20px, 20px) rotate(180deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        @keyframes floatResume {
            0% {
                transform: translateY(0) rotate(5deg);
            }

            50% {
                transform: translateY(-20px) rotate(8deg);
            }

            100% {
                transform: translateY(0) rotate(5deg);
            }
        }

        @keyframes lineGrow {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Responsive styles */
        @media (max-width: 1024px) {
            .split-container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                padding: 3rem 2rem;
            }

            .contact-intro {
                max-width: 100%;
            }

            .form-container {
                max-width: 100%;
            }

            .contact-intro h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .contact-methods {
                grid-template-columns: 1fr;
            }

            .contact-intro h1 {
                font-size: 2.5rem;
            }

            .form-header h2 {
                font-size: 2rem;
            }
            
            .navbar-nav {
                background: rgba(29, 30, 44, 0.95);
                padding: 15px;
                border-radius: 10px;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .left-panel,
            .right-panel {
                padding: 2rem 1.5rem;
            }

            .contact-intro h1 {
                font-size: 2.2rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .form-btn {
                width: 100%;
            }

            .navbar {
                height: auto;
                padding: 10px 0;
            }
        }
    </style> -->
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

body {
    font-family: var(--font-primary);
    background-color: var(--background-light);
    color: var(--text-primary);
    line-height: 1.8;
    overflow-x: hidden;
    font-weight: 400;
    padding-top: 90px; /* Account for fixed navbar */
}

h1,
h2,
h3,
h4 {
    font-family: var(--font-heading);
    font-weight: 600;
    letter-spacing: 0.5px;
}

.btn,
.form-label,
.step {
    font-family: var(--font-primary);
}

/* Enhanced Navbar */
.navbar {
    background: var(--primary-dark);
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
    background: var(--primary);
    height: 80px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.navbar-brand {
    font-family: var(--font-heading);
    font-weight: 700;
    color: var(--text-light);
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    transition: var(--transition);
}

.navbar-brand i {
    color: var(--accent);
    margin-right: 10px;
    transition: var(--transition);
}

.navbar-brand:hover i {
    transform: rotate(15deg);
}

.navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.85);
    font-weight: 500;
    margin: 0 15px;
    transition: var(--transition);
    position: relative;
    padding: 8px 0;
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

.navbar-toggler {
    border: none;
    color: var(--text-light);
    font-size: 1.5rem;
}

.btn-nav {
    background: var(--accent);
    color: var(--primary);
    border-radius: var(--radius-full);
    padding: 8px 20px;
    font-weight: 600;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    z-index: 1;
    border: 2px solid var(--accent);
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
    box-shadow: var(--shadow-accent);
    color: var(--primary);
}

.btn-nav:hover::before {
    width: 100%;
}

/* Split-screen layout */
.split-container {
    display: flex;
    min-height: 100vh;
    margin-top: -90px; /* Offset navbar height */
    padding-top: 90px; /* Add padding for content */
}

.left-panel {
    flex: 1;
    background: var(--gradient-hero);
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
    color: var(--text-light);
}

.right-panel {
    flex: 1;
    background-color: var(--surface);
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Left panel styling */
.contact-intro {
    max-width: 600px;
    position: relative;
    z-index: 2;
}

.contact-intro h1 {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    color: var(--text-light);
    animation: textReveal 1.5s ease;
    font-weight: 700;
    line-height: 1.2;
}

.contact-intro p {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    color: rgba(255, 255, 255, 0.9);
    animation: fadeInUp 1s ease 0.3s both;
    font-style: italic;
    font-weight: 300;
}

.contact-methods {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-top: 3rem;
}

.method-card {
    background: rgba(68, 87, 109, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius);
    padding: 1.5rem;
    transition: var(--transition);
    backdrop-filter: blur(5px);
    box-shadow: var(--shadow);
}

.method-card:hover {
    transform: translateY(-5px);
    background: rgba(68, 87, 109, 0.4);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: var(--shadow-md);
}

.method-card i {
    font-size: 1.8rem;
    color: var(--accent);
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
}

.method-card:hover i {
    transform: scale(1.2);
}

.method-card h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: var(--text-light);
    font-weight: 600;
}

.method-card p,
.method-card a {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    transition: color 0.3s ease;
    font-weight: 300;
}

.method-card a {
    display: inline-block;
    margin-top: 0.5rem;
    text-decoration: none;
    color: var(--accent-light);
    font-style: italic;
    position: relative;
    font-weight: 400;
}

.method-card a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: var(--accent-light);
    transition: width 0.3s ease;
}

.method-card a:hover {
    color: var(--text-light);
}

.method-card a:hover::after {
    width: 100%;
}

/* Decorative elements */
.left-panel::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(170, 199, 216, 0.1) 0%, transparent 70%);
    animation: pulse 12s infinite linear;
    z-index: 1;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    z-index: 0;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(170, 199, 216, 0.1);
    filter: blur(30px);
    animation: float 15s infinite linear;
}

/* Resume-themed decorative elements */
.resume-decoration {
    position: absolute;
    top: 20%;
    right: 10%;
    width: 100px;
    height: 140px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transform: rotate(5deg);
    z-index: 1;
    animation: floatResume 20s infinite linear;
    border-radius: 4px;
}

.resume-decoration::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    width: 80px;
    height: 10px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

.resume-decoration::after {
    content: '';
    position: absolute;
    top: 30px;
    left: 10px;
    width: 60px;
    height: 5px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

/* Right panel styling */
.form-container {
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
}

.form-header {
    margin-bottom: 2.5rem;
    text-align: center;
}

.form-header h2 {
    font-size: 2.4rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
    font-weight: 600;
}

.form-header h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gradient-primary);
    transform-origin: left;
    animation: lineGrow 1s ease-out;
}

.form-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
    font-style: italic;
    font-weight: 300;
}

/* Interactive form styles */
.form-stepper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    position: relative;
}

.step {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--surface);
    border: 2px solid var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: var(--primary);
    position: relative;
    z-index: 2;
    transition: var(--transition);
}

.step.active {
    background: var(--primary);
    color: var(--text-light);
    border-color: var(--primary);
}

.step.completed {
    background: var(--accent);
    border-color: var(--accent);
    color: var(--primary);
}

.step-line {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(41, 53, 60, 0.2);
    transform: translateY(-50%);
    z-index: 1;
}

.progress-line {
    position: absolute;
    top: 50%;
    left: 0;
    height: 1px;
    background: var(--gradient-primary);
    transform: translateY(-50%);
    z-index: 1;
    transition: width 0.5s ease;
}

.form-step {
    display: none;
    animation: fadeIn 0.5s ease;
}

.form-step.active {
    display: block;
}

.form-group {
    margin-bottom: 1.8rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 1px solid var(--secondary-light);
    border-radius: var(--radius);
    font-family: var(--font-primary);
    font-size: 1.1rem;
    transition: var(--transition);
    background: var(--surface);
    color: var(--text-primary);
    font-weight: 400;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(41, 53, 60, 0.1);
}

.radio-group {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.radio-option {
    flex: 1;
}

.radio-input {
    display: none;
}

.radio-label {
    display: block;
    padding: 1rem;
    border: 1px solid var(--secondary-light);
    border-radius: var(--radius);
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    font-family: var(--font-primary);
    font-size: 1rem;
    color: var(--text-primary);
    font-weight: 400;
}

.radio-input:checked+.radio-label {
    border-color: var(--primary);
    background: rgba(41, 53, 60, 0.05);
    color: var(--primary);
    font-weight: 500;
}

.checkbox-group {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.checkbox-input {
    margin-right: 0.5rem;
    accent-color: var(--primary);
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2.5rem;
}

.form-btn {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--radius);
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    letter-spacing: 0.5px;
    box-shadow: var(--shadow);
}

.btn-next {
    background: var(--gradient-primary);
    color: var(--text-light);
}

.btn-prev {
    background: transparent;
    color: var(--primary);
    border: 1px solid var(--secondary-light);
}

.btn-submit {
    background: var(--gradient-primary);
    color: var(--text-light);
    width: 100%;
}

.form-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Success message */
.success-message {
    text-align: center;
    display: none;
    animation: fadeIn 0.5s ease;
    padding: 2rem;
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.success-message i {
    font-size: 4rem;
    color: var(--accent);
    margin-bottom: 1.5rem;
    animation: bounceIn 0.8s ease;
}

.success-message h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--primary);
    font-weight: 700;
}

.success-message p {
    color: var(--text-primary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
    font-weight: 400;
}

/* Creative Enhanced Footer */
.footer {
    background: var(--primary-dark);
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
        radial-gradient(circle at 10% 20%, rgba(170, 199, 216, 0.1) 0%, transparent 15%),
        radial-gradient(circle at 90% 80%, rgba(118, 138, 150, 0.1) 0%, transparent 15%),
        radial-gradient(circle at 30% 60%, rgba(68, 87, 109, 0.1) 0%, transparent 15%);
    z-index: 0;
}

.footer-main {
    padding-bottom: 3rem;
    position: relative;
    z-index: 1;
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
}

.social-icon:hover {
    background: var(--accent);
    transform: translateY(-5px) scale(1.1);
    box-shadow: var(--shadow-accent);
}

.newsletter-form {
    display: flex;
    margin-top: 1.5rem;
    border-radius: var(--radius-full);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
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

/* Animations */
@keyframes textReveal {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0.8;
    }

    50% {
        transform: scale(1.1);
        opacity: 0.4;
    }

    100% {
        transform: scale(1);
        opacity: 0.8;
    }
}

@keyframes float {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }

    50% {
        transform: translate(20px, 20px) rotate(180deg);
    }

    100% {
        transform: translate(0, 0) rotate(360deg);
    }
}

@keyframes floatResume {
    0% {
        transform: translateY(0) rotate(5deg);
    }

    50% {
        transform: translateY(-20px) rotate(8deg);
    }

    100% {
        transform: translateY(0) rotate(5deg);
    }
}

@keyframes lineGrow {
    from {
        transform: scaleX(0);
    }

    to {
        transform: scaleX(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes bounceIn {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.2);
    }

    100% {
        transform: scale(1);
    }
}

/* Responsive styles */
@media (max-width: 1024px) {
    .split-container {
        flex-direction: column;
    }

    .left-panel,
    .right-panel {
        padding: 3rem 2rem;
    }

    .contact-intro {
        max-width: 100%;
    }

    .form-container {
        max-width: 100%;
    }

    .contact-intro h1 {
        font-size: 3rem;
    }
}

@media (max-width: 768px) {
    .contact-methods {
        grid-template-columns: 1fr;
    }

    .contact-intro h1 {
        font-size: 2.5rem;
    }

    .form-header h2 {
        font-size: 2rem;
    }
    
    .navbar-nav {
        background: rgba(29, 30, 44, 0.95);
        padding: 15px;
        border-radius: 10px;
        margin-top: 10px;
    }
}

@media (max-width: 576px) {
    .left-panel,
    .right-panel {
        padding: 2rem 1.5rem;
    }

    .contact-intro h1 {
        font-size: 2.2rem;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .form-btn {
        width: 100%;
    }

    .navbar {
        height: auto;
        padding: 10px 0;
    }
}
    </style>
</head>

<body>
    <!-- Enhanced Navbar -->
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
                        <a class="nav-link" href="#templates">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" href="history.php">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">Contact Us</a>
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

    <div class="split-container">
        <!-- Left Panel - Contact Information -->
        <div class="left-panel">
            <div class="floating-shapes">
                <div class="shape shape-1" style="width: 200px; height: 200px; top: 20%; left: 10%; animation-delay: 0s; background: rgba(72, 149, 239, 0.1);"></div>
                <div class="shape shape-2" style="width: 300px; height: 300px; bottom: 10%; right: 10%; animation-delay: 3s; background: rgba(247, 37, 133, 0.1);"></div>
                <div class="shape shape-3" style="width: 150px; height: 150px; top: 60%; left: 30%; animation-delay: 6s; background: rgba(76, 201, 240, 0.1);"></div>
            </div>

            <!-- Resume-themed decoration -->
            <div class="resume-decoration"></div>

            <div class="contact-intro">
                <h1>Craft Your Career Success</h1>
                <p>Professional resume services to help you land your dream job</p>

                <div class="contact-methods">
                    <div class="method-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Our Headquarters</h3>
                        <p>Career Development Center</p>
                        <p>San Francisco, CA 94105</p>
                        <a href="#" target="_blank">Get Directions</a>
                    </div>

                    <div class="method-card">
                        <i class="fas fa-phone-alt"></i>
                        <h3>Career Support</h3>
                        <p>+1 (415) 555-0199</p>
                        <p>Mon-Fri: 9AM-6PM PST</p>
                        <a href="tel:+14155550199">Call Now</a>
                    </div>

                    <div class="method-card">
                        <i class="fas fa-envelope"></i>
                        <h3>Email Support</h3>
                        <p>support@geekocv.com</p>
                        <p>careers@geekocv.com</p>
                        <a href="mailto:support@geekocv.com">Email Us</a>
                    </div>

                    <div class="method-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Consultation</h3>
                        <p>Schedule a free resume review</p>
                        <p>With our career experts</p>
                        <a href="#" id="scheduleBtn">Book Session</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Interactive Form -->
        <div class="right-panel">
            <div class="form-container">
                <!-- Form Stepper -->
                <div class="form-stepper">
                    <div class="step active" id="step1">I</div>
                    <div class="step" id="step2">II</div>
                    <div class="step" id="step3">III</div>
                    <div class="step-line"></div>
                    <div class="progress-line" id="progressLine"></div>
                </div>

                <!-- Step 1: Personal Information -->
                <div class="form-step active" id="formStep1">
                    <div class="form-header">
                        <h2>Your Career Profile</h2>
                        <p>Tell us about your professional background</p>
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" class="form-input" placeholder="Johnathan Smith" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" class="form-input" placeholder="johnathan@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Contact Number</label>
                        <input type="tel" id="phone" class="form-input" placeholder="+1 (415) 555-0199">
                    </div>

                    <div class="form-group">
                        <label for="industry" class="form-label">Industry/Profession</label>
                        <input type="text" id="industry" class="form-input" placeholder="e.g. Software Engineering, Marketing, Healthcare">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-btn btn-next" onclick="nextStep(1)">Continue</button>
                    </div>
                </div>

                <!-- Step 2: Resume Service Details -->
                <div class="form-step" id="formStep2">
                    <div class="form-header">
                        <h2>Resume Services</h2>
                        <p>Select the services you need</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Service Type</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="service-resume" name="service" value="resume" class="radio-input" checked>
                                <label for="service-resume" class="radio-label">Resume Writing</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="service-cover" name="service" value="cover" class="radio-input">
                                <label for="service-cover" class="radio-label">Cover Letter</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="service-both" name="service" value="both" class="radio-input">
                                <label for="service-both" class="radio-label">Both</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="urgency" class="form-label">Urgency</label>
                        <select id="urgency" class="form-input" required>
                            <option value="" disabled selected>Select timeline</option>
                            <option value="rush">Rush (24-48 hours)</option>
                            <option value="standard">Standard (3-5 days)</option>
                            <option value="flexible">Flexible (1-2 weeks)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience" class="form-label">Years of Experience</label>
                        <input type="text" id="experience" class="form-input" placeholder="e.g. 5 years in marketing">
                    </div>

                    <div class="form-group">
                        <label for="goals" class="form-label">Career Goals</label>
                        <textarea id="goals" class="form-input" rows="3" placeholder="What positions are you targeting? What are your career objectives?"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-btn btn-prev" onclick="prevStep(2)">Previous</button>
                        <button type="button" class="form-btn btn-next" onclick="nextStep(2)">Continue</button>
                    </div>
                </div>

                <!-- Step 3: Preferences -->
                <div class="form-step" id="formStep3">
                    <div class="form-header">
                        <h2>Final Details</h2>
                        <p>How we can best serve you</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preferred Contact Method</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="contact-email" name="contact-method" value="email" class="radio-input" checked>
                                <label for="contact-email" class="radio-label">Email</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="contact-phone" name="contact-method" value="phone" class="radio-input">
                                <label for="contact-phone" class="radio-label">Phone</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="contact-video" name="contact-method" value="video" class="radio-input">
                                <label for="contact-video" class="radio-label">Video Call</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preferred Contact Time</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="time-morning" name="contact-time" value="morning" class="radio-input">
                                <label for="time-morning" class="radio-label">Morning</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="time-afternoon" name="contact-time" value="afternoon" class="radio-input" checked>
                                <label for="time-afternoon" class="radio-label">Afternoon</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="time-evening" name="contact-time" value="evening" class="radio-input">
                                <label for="time-evening" class="radio-label">Evening</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="resume-review" class="checkbox-input" checked>
                            <label for="resume-review" class="form-label">I'd like a free resume review before proceeding</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="career-tips" class="checkbox-input" checked>
                            <label for="career-tips" class="form-label">Send me career tips and job market insights</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-btn btn-prev" onclick="prevStep(3)">Previous</button>
                        <button type="button" class="form-btn btn-submit" onclick="submitForm()">Submit Request</button>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="success-message" id="successMessage">
                    <i class="fas fa-file-contract"></i>
                    <h3>Request Received!</h3>
                    <p>Your resume service request has been submitted. A career specialist will contact you within 24 hours.</p>
                    <button type="button" class="form-btn btn-submit" onclick="resetForm()">New Request</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row footer-main">
                <div class="col-lg-4 mb-5 mb-lg-0 footer-column animated">
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

                <div class="col-lg-2 col-md-4 mb-4 mb-md-0 footer-column animated delay-1">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Resume Templates</a></li>
                        <li><a href="#">Cover Letters</a></li>
                        <li><a href="#">Resume Tips</a></li>
                        <li><a href="#">Career Blog</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4 mb-4 mb-md-0 footer-column animated delay-2">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4 footer-column animated delay-3">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        // Form navigation
        let currentStep = 1;
        const totalSteps = 3;

        function updateProgress() {
            // Update step indicators
            for (let i = 1; i <= totalSteps; i++) {
                const step = document.getElementById(`step${i}`);
                if (i < currentStep) {
                    step.classList.remove('active');
                    step.classList.add('completed');
                } else if (i === currentStep) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            }

            // Update progress line
            const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            document.getElementById('progressLine').style.width = `${progressPercentage}%`;
        }

        function nextStep(step) {
            if (step === currentStep && validateStep(step)) {
                document.getElementById(`formStep${step}`).classList.remove('active');
                currentStep++;
                document.getElementById(`formStep${currentStep}`).classList.add('active');
                updateProgress();
            }
        }

        function prevStep(step) {
            document.getElementById(`formStep${step}`).classList.remove('active');
            currentStep--;
            document.getElementById(`formStep${currentStep}`).classList.add('active');
            updateProgress();
        }

        function validateStep(step) {
            // Simple validation for demo purposes
            if (step === 1) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                if (!name || !email) {
                    alert('Please complete all required fields');
                    return false;
                }
            } else if (step === 2) {
                const goals = document.getElementById('goals').value;
                if (!goals) {
                    alert('Please provide your career goals');
                    return false;
                }
            }
            return true;
        }

        function submitForm() {
            // Simulate form submission
            document.getElementById(`formStep${currentStep}`).classList.remove('active');
            document.getElementById('successMessage').style.display = 'block';

            // In a real application, you would send the form data to a server here
            console.log('Resume service request submitted:', {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                industry: document.getElementById('industry').value,
                service: document.querySelector('input[name="service"]:checked').value,
                urgency: document.getElementById('urgency').value,
                experience: document.getElementById('experience').value,
                goals: document.getElementById('goals').value,
                contactMethod: document.querySelector('input[name="contact-method"]:checked').value,
                contactTime: document.querySelector('input[name="contact-time"]:checked').value,
                resumeReview: document.getElementById('resume-review').checked,
                careerTips: document.getElementById('career-tips').checked
            });
        }

        function resetForm() {
            // Reset form and show first step
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById(`formStep${currentStep}`).classList.remove('active');
            currentStep = 1;
            document.getElementById(`formStep${currentStep}`).classList.add('active');
            updateProgress();

            // Reset form fields
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('industry').value = '';
            document.getElementById('urgency').value = '';
            document.getElementById('experience').value = '';
            document.getElementById('goals').value = '';
            document.getElementById('resume-review').checked = true;
            document.getElementById('career-tips').checked = true;
        }

        // Schedule button interaction
        document.getElementById('scheduleBtn').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Our career specialists will contact you to schedule your free resume review session.');
        });

        // Initialize progress
        updateProgress();

        // Animate footer elements on scroll
        const footerElements = document.querySelectorAll('.footer .animated');
        const footerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                }
            });
        }, {
            threshold: 0.1
        });
        
        footerElements.forEach(element => {
            footerObserver.observe(element);
        });
    </script>
</body>

</html>