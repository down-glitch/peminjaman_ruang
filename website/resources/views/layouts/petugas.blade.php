<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard Petugas')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
      --primary: #E2CEB1;
      --primary-dark: #d4b995;
      --accent: #9c7c5e;
      --background: #FDFBD4;
      --text: #4a3c29;
      --card-bg: rgba(255, 255, 255, 0.96);
      --sidebar-bg: #f8f0d7;
      --sidebar-hover: #e2d4b0;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    :root[data-theme="dark"] {
      --primary: #7D6B4F;
      --primary-dark: #6A5A41;
      --accent: #B8A58A;
      --background: #1A1A1A;
      --text: #E2D6C0;
      --card-bg: #2D2D2D;
      --sidebar-bg: #252525;
      --sidebar-hover: #3D3D3D;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    * {margin:0; padding:0; box-sizing:border-box;}
    body {
      font-family: 'Montserrat', sans-serif;
      color: var(--text);
      min-height: 100vh;
      display: flex;
      background: var(--background);
      transition: var(--transition);
      overflow-x: hidden;
    }

    /* Mobile Sidebar Toggle */
    .mobile-toggle {
      position: fixed;
      top: 20px;
      left: 20px;
      width: 50px;
      height: 50px;
      background: var(--primary);
      color: var(--text);
      display: none;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      cursor: pointer;
      z-index: 1001;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }
    
    .mobile-toggle:hover {
      transform: scale(1.05);
      background: var(--primary-dark);
    }
    
    .mobile-toggle i {
      font-size: 1.2rem;
      transition: var(--transition);
    }
    
    .mobile-toggle.active i {
      transform: rotate(90deg);
    }

    /* Sidebar Overlay */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 998;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
    }
    
    .sidebar-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* Sidebar */
    .sidebar {
      width: 280px;
      background: var(--sidebar-bg);
      color: var(--text);
      display: flex;
      flex-direction: column;
      padding: 30px 0;
      box-shadow: var(--shadow);
      border-radius: 0 24px 24px 0;
      transition: var(--transition);
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 999;
      overflow-y: auto;
      overflow-x: hidden;
    }
    
    .sidebar-header {
      padding: 0 25px 30px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    
    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .sidebar-logo i {
      font-size: 1.8rem;
      color: var(--accent);
    }
    
    .sidebar h4 {
      font-family: 'Poppins', sans-serif;   
      font-weight: 600;
      color: var(--accent);
      margin: 0;
      font-size: 1.3rem;
    }
    
    .sidebar-nav {
      flex: 1;
      padding: 0 15px;
    }
    
    .sidebar a {
      padding: 14px 20px;
      text-decoration: none;
      color: var(--text);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 15px;
      border-radius: 14px;
      margin-bottom: 8px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background: var(--accent);
      transform: scaleY(0);
      transition: var(--transition);
    }
    
    .sidebar a:hover, .sidebar a.active {
      background: var(--sidebar-hover);
      color: var(--accent);
      transform: translateX(5px);
    }
    
    .sidebar a:hover::before, .sidebar a.active::before {
      transform: scaleY(1);
    }
    
    .sidebar a i {
      width: 24px;
      text-align: center;
      font-size: 1.1rem;
    }
    
    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      margin-top: auto;
    }

    /* Content */
    .content {
      flex: 1;
      padding: 30px;
      background: var(--card-bg);
      margin: 20px 20px 20px 300px;
      border-radius: 24px;
      box-shadow: var(--shadow);
      overflow-y: auto;
      transition: var(--transition);
      min-height: calc(100vh - 40px);
    }
    
    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .content-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 600;
      color: var(--accent);
    }
    
    .content-subtitle {
      color: var(--text);
      opacity: 0.8;
      margin-top: 5px;
    }

    /* Theme Toggle */
    .theme-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--primary);
      color: var(--text);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow);
      z-index: 1000;
      transition: var(--transition);
    }
    
    .theme-toggle:hover {
      transform: scale(1.1) rotate(15deg);
      background: var(--primary-dark);
    }
    
    .theme-toggle i {
      font-size: 1.4rem;
      transition: var(--transition);
    }
    
    .theme-toggle:hover i {
      transform: rotate(180deg);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .sidebar {
        width: 260px;
      }
      
      .content {
        margin-left: 280px;
      }
    }
    
    @media (max-width: 768px) {
      .mobile-toggle {
        display: flex;
      }
      
      .sidebar {
        transform: translateX(-100%);
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .content {
        margin-left: 20px;
        padding: 20px;
      }
      
      .theme-toggle {
        width: 50px;
        height: 50px;
        bottom: 20px;
        right: 20px;
      }
    }
    
    @media (max-width: 480px) {
      .content {
        padding: 15px;
        margin: 10px;
      }
      
      .content-title {
        font-size: 1.5rem;
      }
    }
    
    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease forwards;
    }
</style>
</head>
<body>
    <!-- Mobile Sidebar Toggle -->
    <div class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-door-open"></i>
                <h4>Peminjaman Ruang</h4>
            </div>
        </div>
        
        <div class="sidebar-nav">
            @php
                $role = Auth::user()->role;

                $dashboardRoute = match($role) {
                    'admin' => route('admin.dashboard'),
                    'petugas' => route('petugas.dashboard'),
                    'peminjam' => route('user.dashboard'),
                    default => '#'
                };

                $peminjamanRoute = match($role) {
                    'admin' => route('peminjaman.index'),
                    'petugas' => route('peminjaman.petugas'),
                    'peminjam' => route('peminjaman.index'),
                    default => '#'
                };

                $laporanRoute = match($role) {
                    'admin' => route('laporan.index'),
                    'petugas' => route('laporan.index'),
                    'peminjam' => '#', // peminjam tidak punya laporan
                    default => '#'
                };
                
                // Determine active menu based on current route
                $currentRoute = request()->route()->getName();
            @endphp

            <a href="{{ $dashboardRoute }}" class="{{ $currentRoute == 'admin.dashboard' || $currentRoute == 'petugas.dashboard' || $currentRoute == 'user.dashboard' ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('jadwal.index') }}" class="{{ $currentRoute == 'jadwal.index' ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Ruang</span>
            </a>

            <a href="{{ $peminjamanRoute }}" class="{{ str_contains($currentRoute, 'peminjaman') ? 'active' : '' }}">
                <i class="fas fa-handshake"></i>
                <span>Peminjaman</span>
            </a>

            @if($laporanRoute !== '#')
            <a href="{{ $laporanRoute }}" class="{{ $currentRoute == 'laporan.index' ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>
            @endif
        </div>
        
        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Check for saved theme preference or respect OS preference
            const savedTheme = localStorage.getItem('theme') || 
                              (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            
            // Apply the saved theme
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
            
            // Toggle theme on button click
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                    localStorage.setItem('theme', 'dark');
                }
            });
            
            // Mobile sidebar toggle
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                mobileToggle.classList.toggle('active');
            });
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                mobileToggle.classList.remove('active');
            });
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    mobileToggle.classList.remove('active');
                }
            }
            
            window.addEventListener('resize', handleResize);
            
            // Add fade-in animation to content
            const contentElements = document.querySelectorAll('.content > *');
            contentElements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>