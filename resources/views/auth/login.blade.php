
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 60px;
            height: 60px;
            top: 30%;
            left: 70%;
            animation-delay: 1s;
        }

        .shape:nth-child(5) {
            width: 140px;
            height: 140px;
            top: 10%;
            left: 60%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.6;
            }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.8s ease-out forwards;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            animation: fadeInDown 1s ease-out 0.3s both;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
            animation: fadeInDown 1s ease-out 0.5s both;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            animation: fadeInLeft 0.8s ease-out forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.8s;
        }

        @keyframes fadeInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
        }

        .form-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .form-input:focus + .input-icon {
            color: #667eea;
            transform: translateY(-50%) scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
            transform: translateY(-50%) scale(1.1);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
            animation: fadeInRight 0.8s ease-out 1s both;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out 1.2s both;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
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

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            animation: fadeIn 0.8s ease-out 1.4s both;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 15px;
            color: #999;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .social-login {
            display: flex;
            gap: 15px;
            animation: fadeInUp 0.8s ease-out 1.6s both;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .social-btn.google {
            color: #db4437;
        }

        .social-btn.facebook {
            color: #4267B2;
        }

        .social-btn.twitter {
            color: #1DA1F2;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn.google:hover {
            background: #db4437;
            color: white;
            border-color: #db4437;
        }

        .social-btn.facebook:hover {
            background: #4267B2;
            color: white;
            border-color: #4267B2;
        }

        .social-btn.twitter:hover {
            background: #1DA1F2;
            color: white;
            border-color: #1DA1F2;
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            animation: fadeIn 0.8s ease-out 1.8s both;
        }

        .signup-link p {
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Success Animation */
        .success-check {
            display: none;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .success-check::after {
            content: '✓';
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        /* Error Shake Animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .form-input {
                padding: 12px 15px 12px 45px;
                font-size: 14px;
            }

            .input-icon {
                left: 15px;
                font-size: 16px;
            }

            .password-toggle {
                right: 15px;
                font-size: 16px;
            }
        }

        /* Pulse effect for form validation */
        .form-input.error {
            border-color: #e74c3c;
            animation: pulse-error 0.5s ease-in-out;
        }

        @keyframes pulse-error {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }

        .form-input.success {
            border-color: #27ae60;
            animation: pulse-success 0.5s ease-in-out;
        }

        @keyframes pulse-success {
            0% { box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(39, 174, 96, 0); }
            100% { box-shadow: 0 0 0 0 rgba(39, 174, 96, 0); }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>UPA TIK UNIPA</h1>
                <p>Peminjaman barang UPA TIK UNIPA</p>
            </div>

            <form id="loginForm" method="post" >
                <div class="form-group">
                    <input type="text" id="email" class="form-input" placeholder="Enter your username" required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="form-group">
                    <input type="password" id="password" class="form-input" placeholder="Enter your password" required>
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>

               

                <button type="submit" class="login-btn mt-5" id="loginBtn">
                    <div class="loading" id="loading"></div>
                    <div class="success-check" id="successCheck"></div>
                    <span id="btnText">Login</span>
                </button>
            </form>

            

            <div class="signup-link">
                <p>UPA TIK UNIPA</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const loginBtn = document.getElementById('loginBtn');
            const loading = document.getElementById('loading');
            const successCheck = document.getElementById('successCheck');
            const btnText = document.getElementById('btnText');
            const forgotPassword = document.getElementById('forgotPassword');
            const signupLink = document.getElementById('signupLink');
            const googleLogin = document.getElementById('googleLogin');
            const facebookLogin = document.getElementById('facebookLogin');
            const twitterLogin = document.getElementById('twitterLogin');

            // Password Toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    togglePassword.classList.remove('fa-eye-slash');
                    togglePassword.classList.add('fa-eye');
                } else {
                    togglePassword.classList.remove('fa-eye');
                    togglePassword.classList.add('fa-eye-slash');
                }
            });

            // Input Focus Effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                    validateInput(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('error')) {
                        this.classList.remove('error');
                    }
                });
            });

            // Input Validation
            function validateInput(input) {
                const value = input.value.trim();
                
                if (input.type === 'text') {
                    
                    if (value) {
                        input.classList.add('success');
                        input.classList.remove('error');
                    } 
                } else if (input.type === 'password' || input.type === 'text') {
                    if (value.length >= 2) {
                        input.classList.add('success');
                        input.classList.remove('error');
                    } else if (value) {
                        input.classList.add('error');
                        input.classList.remove('success');
                    }
                }
            }

            // Form Submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                
                // Validation
                let isValid = true;
                
                if (!email) {
                    emailInput.classList.add('error');
                    emailInput.parentElement.classList.add('shake');
                    setTimeout(() => emailInput.parentElement.classList.remove('shake'), 500);
                    isValid = false;
                }
                
                if (!password) {
                    passwordInput.classList.add('error');
                    passwordInput.parentElement.classList.add('shake');
                    setTimeout(() => passwordInput.parentElement.classList.remove('shake'), 500);
                    isValid = false;
                }
                
                if (!isValid) {
                    return;
                }
                
                // Simulate login process
                loginBtn.disabled = true;
                loading.style.display = 'inline-block';
                btnText.textContent = 'Signing In...';
                
                setTimeout(() => {
                    loading.style.display = 'none';
                    successCheck.style.display = 'inline-block';
                    btnText.textContent = 'Success!';
                    
                    // Simulate redirect after success
                    setTimeout(() => {
                        alert('Login successful! Welcome back!');
                        // Reset form
                        loginForm.reset();
                        loginBtn.disabled = false;
                        successCheck.style.display = 'none';
                        btnText.textContent = 'Sign In';
                        inputs.forEach(input => {
                            input.classList.remove('success', 'error');
                        });
                    }, 1500);
                }, 2000);
            });

            // Social Login Handlers
            googleLogin.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                    alert('Google login clicked! Integration would be implemented here.');
                }, 150);
            });

            facebookLogin.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                    alert('Facebook login clicked! Integration would be implemented here.');
                }, 150);
            });

            twitterLogin.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                    alert('Twitter login clicked! Integration would be implemented here.');
                }, 150);
            });

            // Forgot Password
            forgotPassword.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Password reset functionality would be implemented here.');
            });

            // Sign Up Link
            signupLink.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Sign up page would be loaded here.');
            });

            // Add floating animation to login card on mouse move
            document.addEventListener('mousemove', function(e) {
                const loginCard = document.querySelector('.login-card');
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;
                
                const xPos = (clientX / innerWidth - 0.5) * 10;
                const yPos = (clientY / innerHeight - 0.5) * 10;
                
                loginCard.style.transform = `translateX(${xPos}px) translateY(${yPos}px)`;
            });

            // Add typing effect for placeholder
            function addTypingEffect() {
                const texts = [
                    'Enter your username',
                    'your username',
                    'Username'
                ];
                let currentText = 0;
                let currentChar = 0;
                let isDeleting = false;

                function type() {
                    const current = texts[currentText];
                    
                    if (isDeleting) {
                        emailInput.placeholder = current.substring(0, currentChar - 1);
                        currentChar--;
                    } else {
                        emailInput.placeholder = current.substring(0, currentChar + 1);
                        currentChar++;
                    }

                    if (!isDeleting && currentChar === current.length) {
                        setTimeout(() => isDeleting = true, 2000);
                    } else if (isDeleting && currentChar === 0) {
                        isDeleting = false;
                        currentText = (currentText + 1) % texts.length;
                    }

                    setTimeout(type, isDeleting ? 50 : 100);
                }

                // Start typing effect after initial animation
                setTimeout(type, 3000);
            }

            addTypingEffect();

            // Add particle effect on button hover
            loginBtn.addEventListener('mouseenter', function() {
                for (let i = 0; i < 6; i++) {
                    setTimeout(() => {
                        createParticle(this);
                    }, i * 100);
                }
            });

            function createParticle(element) {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.width = '4px';
                particle.style.height = '4px';
                particle.style.background = 'rgba(255, 255, 255, 0.8)';
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '1000';
                
                const rect = element.getBoundingClientRect();
                particle.style.left = (rect.left + Math.random() * rect.width) + 'px';
                particle.style.top = rect.top + 'px';
                
                document.body.appendChild(particle);
                
                const animation = particle.animate([
                    { transform: 'translateY(0px)', opacity: 1 },
                    { transform: 'translateY(-50px)', opacity: 0 }
                ], {
                    duration: 1000,
                    easing: 'ease-out'
                });
                
                animation.onfinish = () => {
                    particle.remove();
                };
            }

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'Enter') {
                    loginForm.dispatchEvent(new Event('submit'));
                }
            });

            // Add focus management
            emailInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    passwordInput.focus();
                }
            });

            passwordInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    loginForm.dispatchEvent(new Event('submit'));
                }
            });
        });
    </script>
</body>
</html>

