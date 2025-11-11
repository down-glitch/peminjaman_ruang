<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Professional Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
   
   
   <style>
        :root {
            --primary: #5D4E37;
            --primary-dark: #3E3326;
            --primary-light: #8B7355;
            --accent: #D4AF37;
            --accent-light: #F4E4C1;
            --bg-primary: #FAFAFA;
            --bg-secondary: #FFFFFF;
            --bg-input: #F8F8F8;
            --text-primary: #1A1A1A;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --border: #E5E7EB;
            --border-focus: #D4AF37;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --error: #DC2626;
            --error-bg: #FEF2F2;
            --success: #059669;
            --success-bg: #ECFDF5;
        }

        body {
            background: var(--bg-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            padding: 24px;
            position: relative;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 1px 1px, var(--border) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.3;
            pointer-events: none;
        }

        /* Main container */
        .register-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Card with professional styling */
        .register-card {
            background: var(--bg-secondary);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .register-card:hover {
            box-shadow: 0 25px 30px -10px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        /* Professional header */
        .register-header {
            padding: 32px 32px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            text-align: center;
            position: relative;
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, var(--accent-light) 100%);
        }

        .register-header h2 {
            font-family: 'Merriweather', serif;
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            font-weight: 400;
            margin: 0;
        }

        /* Form section */
        .register-body {
            padding: 32px;
        }

        /* Professional form groups */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
            transition: color 0.2s ease;
        }

        .form-label i {
            margin-right: 6px;
            color: var(--primary);
            font-size: 13px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            padding-left: 42px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            background: var(--bg-input);
            color: var(--text-primary);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--border-focus);
            background: white;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* Input icons */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 38px;
            color: var(--text-muted);
            font-size: 15px;
            transition: color 0.2s ease;
            pointer-events: none;
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        /* Password strength indicator */
        .password-strength {
            height: 5px;
            margin-top: 8px;
            border-radius: 5px;
            background: var(--border);
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
            border-radius: 5px;
        }

        .password-requirements {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 8px;
        }

        .password-requirements div {
            margin-bottom: 4px;
            display: flex;
            align-items: center;
        }

        .password-requirements i {
            margin-right: 6px;
        }

        /* Professional button */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 8px;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px -4px rgba(93, 78, 55, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Loading state */
        .btn-register.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-register.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Professional alerts */
        .alert {
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 24px;
            border: 1px solid;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .alert-danger {
            background: var(--error-bg);
            border-color: var(--error);
            color: var(--error);
        }

        .alert-danger i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* Footer link */
        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .login-link p {
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }

        .login-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Form validation states */
        .form-control.is-invalid {
            border-color: var(--error);
            background-image: none;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 6px;
            font-size: 13px;
            color: var(--error);
        }

        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .register-header {
                padding: 24px 20px;
            }

            .register-body {
                padding: 24px 20px;
            }

            .register-header h2 {
                font-size: 28px;
            }
        }

        /* Subtle animations */
        .form-group {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.4s;
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

        /* Focus ripple effect */
        .form-control:focus {
            position: relative;
        }

        .form-control:focus::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            border-radius: 8px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            transform: translate(-50%, -50%) scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: translate(-50%, -50%) scale(2);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h2>Peminjaman Ruang</h2>
                <p>Silahkan buat akun</p>
            </div>

            <div class="register-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="/register" id="registerForm" novalidate>
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Masukan username" 
                               required>
                        <i class="fas fa-user input-icon"></i>
                        <div class="invalid-feedback">Please enter a valid username</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               placeholder="Masukan email" 
                               required>
                        <i class="fas fa-envelope input-icon"></i>
                        <div class="invalid-feedback">Please enter a valid email address</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Masukan password" 
                               required 
                               onkeyup="checkPasswordStrength()">
                        <i class="fas fa-lock input-icon"></i>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="password-requirements">
                            <div id="lengthReq">
                                <i class="fas fa-times-circle text-danger" id="lengthIcon"></i> 
                                Minimal 8 karakter
                            </div>
                            <div id="numberReq">
                                <i class="fas fa-times-circle text-danger" id="numberIcon"></i> 
                                Sertakan nomor
                            </div>
                            <div id="upperReq">
                                <i class="fas fa-times-circle text-danger" id="upperIcon"></i> 
                                Sertakan Huruf besar
                            </div>
                        </div>
                        <div class="invalid-feedback">Password must meet all requirements</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">
                            <i class="fas fa-lock"></i> Confirm Password
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi password" 
                               required 
                               onkeyup="checkPasswordMatch()">
                        <i class="fas fa-lock input-icon"></i>
                        <div class="password-requirements">
                            <div id="matchReq">
                                <i class="fas fa-times-circle text-danger" id="matchIcon"></i> 
                                Passwords match
                            </div>
                        </div>
                        <div class="invalid-feedback">Passwords tidak sama</div>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i> Buat akun
                    </button>
                </form>

                <div class="login-link">
                    <p>Sudah punya akun? <a href="/login">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const lengthIcon = document.getElementById('lengthIcon');
            const numberIcon = document.getElementById('numberIcon');
            const upperIcon = document.getElementById('upperIcon');
            
            let strength = 0;
            
            // Check length
            if (password.length >= 8) {
                strength += 33;
                lengthIcon.className = 'fas fa-check-circle text-success';
            } else {
                lengthIcon.className = 'fas fa-times-circle text-danger';
            }
            
            // Check for numbers
            if (/\d/.test(password)) {
                strength += 33;
                numberIcon.className = 'fas fa-check-circle text-success';
            } else {
                numberIcon.className = 'fas fa-times-circle text-danger';
            }
            
            // Check for uppercase letters
            if (/[A-Z]/.test(password)) {
                strength += 34;
                upperIcon.className = 'fas fa-check-circle text-success';
            } else {
                upperIcon.className = 'fas fa-times-circle text-danger';
            }
            
            // Update strength bar
            strengthBar.style.width = strength + '%';
            
            // Update color based on strength
            if (strength < 40) {
                strengthBar.style.background = 'var(--error)';
            } else if (strength < 80) {
                strengthBar.style.background = 'var(--accent)';
            } else {
                strengthBar.style.background = 'var(--success)';
            }
            
            // Also check password match as user types
            checkPasswordMatch();
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchIcon = document.getElementById('matchIcon');
            
            if (confirmPassword.length === 0) {
                matchIcon.className = 'fas fa-times-circle text-danger';
                return;
            }
            
            if (password === confirmPassword) {
                matchIcon.className = 'fas fa-check-circle text-success';
            } else {
                matchIcon.className = 'fas fa-times-circle text-danger';
            }
        }
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const form = this;
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            let isValid = true;

            // Reset validation states
            form.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });

            // Validate username
            if (!username.value.trim()) {
                username.classList.add('is-invalid');
                isValid = false;
            }

            // Validate email
            if (!email.value.trim() || !email.value.includes('@')) {
                email.classList.add('is-invalid');
                isValid = false;
            }

            // Validate password
            if (password.value.length < 8 || !/\d/.test(password.value) || !/[A-Z]/.test(password.value)) {
                password.classList.add('is-invalid');
                isValid = false;
            }

            // Validate password confirmation
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return;
            }

            // Show loading state
            const submitBtn = form.querySelector('.btn-register');
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Creating Account...';
            
            // Reset button after 3 seconds (for demo purposes)
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Create Account';
            }, 3000);
        });

        // Clear validation on input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });

        // Add subtle hover effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>