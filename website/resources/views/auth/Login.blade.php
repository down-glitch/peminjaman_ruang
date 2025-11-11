<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Professional Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
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
    .auth-container {
      width: 100%;
      max-width: 420px;
      position: relative;
      z-index: 1;
    }

    /* Card with professional styling */
    .auth-card {
      background: var(--bg-secondary);
      border-radius: 16px;
      box-shadow: var(--shadow-xl);
      border: 1px solid var(--border);
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .auth-card:hover {
      box-shadow: 0 25px 30px -10px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }

    /* Professional header */
    .auth-header {
      padding: 32px 32px 24px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      text-align: center;
      position: relative;
    }

    .auth-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent) 0%, var(--accent-light) 100%);
    }

    .auth-header h2 {
      font-family: 'Merriweather', serif;
      font-size: 32px;
      font-weight: 700;
      color: white;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .auth-header p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 15px;
      font-weight: 400;
      margin: 0;
    }

    /* Form section */
    .auth-body {
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

    /* Password toggle */
    .password-toggle {
      position: absolute;
      right: 14px;
      top: 38px;
      color: var(--text-muted);
      cursor: pointer;
      padding: 4px;
      transition: color 0.2s ease;
    }

    .password-toggle:hover {
      color: var(--primary);
    }

    /* Professional button */
    .btn-login {
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

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s ease;
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 16px -4px rgba(93, 78, 55, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    /* Loading state */
    .btn-login.loading {
      pointer-events: none;
      opacity: 0.8;
    }

    .btn-login.loading i {
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

    .alert-danger ul {
      margin: 0;
      padding-left: 20px;
    }

    /* Footer link */
    .auth-footer {
      text-align: center;
      margin-top: 24px;
      padding-top: 24px;
      border-top: 1px solid var(--border);
    }

    .auth-footer p {
      color: var(--text-secondary);
      font-size: 14px;
      margin: 0;
    }

    .auth-footer a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .auth-footer a:hover {
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
      .auth-header {
        padding: 24px 20px;
      }

      .auth-body {
        padding: 24px 20px;
      }

      .auth-header h2 {
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
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2>Peminjaman Ruang</h2>
        <p>Silahkan Login Terlebih Dahulu</p>
      </div>

      <div class="auth-body">
        <!-- Display errors -->
        @if ($errors->any())
          <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div>
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" id="loginForm" novalidate>
          @csrf
          
          <div class="form-group">
            <label class="form-label" for="username">
              <i class="fas fa-user"></i> Username
            </label>
            <input type="text" 
                   class="form-control" 
                   id="username" 
                   name="username" 
                   placeholder="Masukan username anda" 
                   required>
            <i class="fas fa-user input-icon"></i>
            <div class="invalid-feedback">Please enter your username</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="password">
              <i class="fas fa-lock"></i> Password
            </label>
            <input type="password" 
                   class="form-control" 
                   id="password" 
                   name="password" 
                   placeholder="Masukan password anda" 
                   required>
            <i class="fas fa-lock input-icon"></i>
            <span class="password-toggle" onclick="togglePassword()">
              <i class="fas fa-eye" id="toggleIcon"></i>
            </span>
            <div class="invalid-feedback">Please enter your password</div>
          </div>

          <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Masuk
          </button>
        </form>

        <div class="auth-footer">
          <p>Tidak punya akun? <a href="/register">Buat akun</a></p>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");
      
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        passwordField.type = "password";
        toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }

    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const form = this;
      const username = document.getElementById('username');
      const password = document.getElementById('password');
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

      // Validate password
      if (!password.value.trim()) {
        password.classList.add('is-invalid');
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
        return;
      }

      // Show loading state
      const submitBtn = form.querySelector('.btn-login');
      submitBtn.classList.add('loading');
      submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Authenticating...';
      
      // Reset button after 3 seconds (for demo purposes)
      setTimeout(() => {
        submitBtn.classList.remove('loading');
        submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Sign In';
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