<?php
session_start(); // start session
include('db.php');

if (isset($_POST['submitBtn'])) {

    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Insert user data into database
    $sql_insert = "INSERT INTO login (name, email, password) VALUES ('$name', '$email', '$password')";

    if (mysqli_query($con, $sql_insert)) {
        // Save user session
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;

        // Redirect on successful signup
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NeoLogin | Modern Authentication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Elegant Color Palette - Updated */
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
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-primary);
            background: var(--background-light);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: var(--surface);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            position: relative;
        }

        .graphic-side {
            flex: 1;
            background: var(--gradient-hero);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: var(--text-light);
            position: relative;
            overflow: hidden;
        }

        .graphic-side::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            left: -100px;
        }

        .graphic-side::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            bottom: -50px;
            right: -50px;
        }

        .graphic-content {
            text-align: center;
            z-index: 2;
            max-width: 400px;
        }

        .graphic-content h2 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .graphic-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .floating-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 50px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            position: relative;
            background: var(--surface);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-header h1 {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid var(--accent-light);
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--background-light);
            color: var(--text-primary);
            font-weight: 500;
            font-family: var(--font-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: var(--surface);
            box-shadow: 0 0 0 4px rgba(41, 53, 60, 0.1);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            background: var(--background-light);
            border: 2px solid var(--accent-light);
            border-radius: 5px;
            margin-right: 10px;
            position: relative;
            transition: var(--transition);
        }

        .checkbox-container input:checked ~ .checkmark {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-login {
            background: var(--primary);
            color: var(--text-light);
            border: none;
            padding: 18px 30px;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-primary);
            width: 100%;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            font-family: var(--font-primary);
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--accent-light);
        }

        .separator::before {
            margin-right: .5em;
        }

        .separator::after {
            margin-left: .5em;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 2rem;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--background-light);
            border: 1px solid var(--accent-light);
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .social-btn.google {
            color: #DB4437;
        }

        .social-btn.facebook {
            color: #4267B2;
        }

        .social-btn.twitter {
            color: #1DA1F2;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
        }

        .form-footer {
            text-align: center;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .form-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Animation for form elements */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group, .form-options, .btn-login, .form-footer {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .form-group { animation-delay: 0.1s; }
        .form-options { animation-delay: 0.2s; }
        .btn-login { animation-delay: 0.3s; }
        .form-footer { animation-delay: 0.4s; }

        /* Responsive styles */
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }
            
            .graphic-side {
                padding: 30px;
                display: none;
            }
            
            .form-side {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                box-shadow: none;
            }
            
            .form-side {
                padding: 25px 20px;
            }
            
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .forgot-password {
                margin-left: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="graphic-side">
            <div class="floating-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="graphic-content">
                <h2>Join Us!</h2>
                <p>Create an account to access your personalized dashboard and start your journey with us.</p>
            </div>
        </div>
        
        <div class="form-side">
            <div class="form-header">
                <h1>Create Account</h1>
                <p>Fill in your details to get started</p>
            </div>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="inputName">Full Name</label>
                    <div class="input-container">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" name="name" id="inputName" placeholder="Enter your full name" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email Address</label>
                    <div class="input-container">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Enter your email" aria-describedby="emailHelp" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Create a strong password" required />
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="termsAgree" required />
                        <span class="checkmark"></span>
                        I agree to the Terms & Conditions
                    </label>
                </div>

                <button type="submit" name="submitBtn" class="btn-login">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Create Account
                </button>
            </form>

            <div class="separator">Or sign up with</div>

            <div class="social-login">
                <div class="social-btn google">
                    <i class="fab fa-google"></i>
                </div>
                <div class="social-btn facebook">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <div class="social-btn twitter">
                    <i class="fab fa-twitter"></i>
                </div>
            </div>

            <div class="form-footer">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('inputPassword');
        
        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const eyeIcon = this.querySelector('i');
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>