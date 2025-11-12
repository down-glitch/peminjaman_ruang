@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="content-wrapper">
    <!-- Welcome Section -->
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1 class="welcome-title">Halo, {{ Auth::user()->username }}! 👋</h1>
                <p class="welcome-subtitle">Siap meminjam ruangan hari ini?</p>
            </div>
            <div class="current-date">
                <div class="date">{{ now()->format('d') }}</div>
                <div class="month-year">
                    <div class="month">{{ now()->locale('id')->monthName }}</div>
                    <div class="year">{{ now()->format('Y') }}</div>
                </div>
            </div>
        </div>
        <div class="welcome-decoration">
            <div class="decoration-circle decoration-1"></div>
            <div class="decoration-circle decoration-2"></div>
            <div class="decoration-circle decoration-3"></div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-message success fade-in">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                {{ session('success') }}
            </div>
            <button class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="actions-grid">
        <!-- Ajukan Peminjaman -->
        <a href="{{ route('peminjaman.create') }}" class="action-item primary">
            <div class="action-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="action-content">
                <h3>Ajukan Peminjaman</h3>
                <p>Buat pengajuan baru</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="action-shine"></div>
        </a>

        <!-- Jadwal Ruangan -->
        <a href="{{ route('peminjam.jadwal') }}" class="action-item secondary">
            <div class="action-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="action-content">
                <h3>Jadwal Ruangan</h3>
                <p>Cek ketersediaan ruangan</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="action-shine"></div>
        </a>

        <!-- Jadwal Booking -->
        <a href="{{ route('peminjaman.jadwalbooking') }}" class="action-item info">
            <div class="action-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="action-content">
                <h3>Jadwal Booking</h3>
                <p>Lihat semua jadwal booking aktif</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="action-shine"></div>
        </a>

        <!-- Riwayat Peminjaman -->
        <a href="{{ route('peminjaman.user') }}" class="action-item accent">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="action-content">
                <h3>Riwayat Saya</h3>
                <p>Lihat status peminjaman</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="action-shine"></div>
        </a>
    </div>

    <!-- Stats Section -->


    <!-- Recent Activity -->

</div>

<style>
    /* ==== CSS Variables ==== */
    :root {
        /* Premium Warm Base Palette */
        --warm-50: #FFFBF5;
        --warm-100: #FEF7ED;
        --warm-200: #FDF2E0;
        --warm-300: #FCE8C8;
        --warm-400: #F8D4A1;
        --warm-500: #E2B88A;
        --warm-600: #C19660;
        --warm-700: #A67C52;
        --warm-800: #7A5C3C;
        --warm-900: #4E3A28;
        
        /* Teal/Cyan Accent */
        --teal-50: #ECFDF5;
        --teal-100: #D1FAE5;
        --teal-200: #A7F3D0;
        --teal-300: #6EE7B7;
        --teal-400: #34D399;
        --teal-500: #10B981;
        --teal-600: #059669;
        --teal-700: #047857;
        --teal-800: #065F46;
        --teal-900: #064E3B;
        
        /* Purple/Violet Accent */
        --purple-50: #FAF5FF;
        --purple-100: #F3E8FF;
        --purple-200: #E9D5FF;
        --purple-300: #D8B4FE;
        --purple-400: #C084FC;
        --purple-500: #A855F7;
        --purple-600: #9333EA;
        --purple-700: #7C3AED;
        --purple-800: #6B21A8;
        --purple-900: #581C87;
        
        /* Coral/Salmon Accent */
        --coral-50: #FFF1F2;
        --coral-100: #FFE4E6;
        --coral-200: #FECDD3;
        --coral-300: #FDA4AF;
        --coral-400: #FB7185;
        --coral-500: #F43F5E;
        --coral-600: #E11D48;
        --coral-700: #BE123C;
        --coral-800: #9F1239;
        --coral-900: #881337;
        
        /* Amber/Gold Accent */
        --amber-50: #FFFBEB;
        --amber-100: #FEF3C7;
        --amber-200: #FDE68A;
        --amber-300: #FCD34D;
        --amber-400: #FBBF24;
        --amber-500: #F59E0B;
        --amber-600: #D97706;
        --amber-700: #B45309;
        --amber-800: #92400E;
        --amber-900: #78350F;
        
        /* Sky Blue Accent */
        --sky-50: #F0F9FF;
        --sky-100: #E0F2FE;
        --sky-200: #BAE6FD;
        --sky-300: #7DD3FC;
        --sky-400: #38BDF8;
        --sky-500: #0EA5E9;
        --sky-600: #0284C7;
        --sky-700: #0369A1;
        --sky-800: #075985;
        --sky-900: #0C4A6E;
        
        /* Theme Variables */
        --bg-primary: #FFFBF5;
        --bg-secondary: #FFFFFF;
        --bg-tertiary: #F8F5F0;
        --text-primary: #2D2416;
        --text-secondary: #5A4A36;
        --text-tertiary: #8B7A65;
        --text-quaternary: #BDB4A5;
        --border-primary: #E8E1D3;
        --border-secondary: #F2E9DD;
        
        /* Premium Gradients */
        --gradient-warm: linear-gradient(135deg, #F8D4A1 0%, #C19660 50%, #A67C52 100%);
        --gradient-teal: linear-gradient(135deg, #6EE7B7 0%, #34D399 50%, #10B981 100%);
        --gradient-purple: linear-gradient(135deg, #D8B4FE 0%, #A855F7 50%, #7C3AED 100%);
        --gradient-coral: linear-gradient(135deg, #FDA4AF 0%, #FB7185 50%, #F43F5E 100%);
        --gradient-amber: linear-gradient(135deg, #FCD34D 0%, #FBBF24 50%, #F59E0B 100%);
        --gradient-sky: linear-gradient(135deg, #7DD3FC 0%, #38BDF8 50%, #0EA5E9 100%);
        --gradient-sunset: linear-gradient(135deg, #F8D4A1 0%, #FDA4AF 50%, #D8B4FE 100%);
        --gradient-ocean: linear-gradient(135deg, #7DD3FC 0%, #6EE7B7 50%, #FCD34D 100%);
        --gradient-royal: linear-gradient(135deg, #D8B4FE 0%, #F8D4A1 50%, #FB7185 100%);
        --gradient-aurora: linear-gradient(135deg, #6EE7B7 0%, #7DD3FC 50%, #D8B4FE 100%);
        
        /* Shadow System */
        --shadow-xs: 0 1px 2px 0 rgba(45, 36, 22, 0.05);
        --shadow-sm: 0 1px 3px 0 rgba(45, 36, 22, 0.1), 0 1px 2px 0 rgba(45, 36, 22, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(45, 36, 22, 0.1), 0 2px 4px -1px rgba(45, 36, 22, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(45, 36, 22, 0.1), 0 4px 6px -2px rgba(45, 36, 22, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(45, 36, 22, 0.1), 0 10px 10px -5px rgba(45, 36, 22, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(45, 36, 22, 0.25);
        --shadow-glow: 0 0 20px rgba(248, 212, 161, 0.3);
        --shadow-glow-teal: 0 0 20px rgba(110, 231, 183, 0.3);
        --shadow-glow-purple: 0 0 20px rgba(216, 180, 254, 0.3);
        --shadow-glow-coral: 0 0 20px rgba(253, 164, 175, 0.3);
        
        /* Glassmorphism */
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.2);
        --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
    }
    
    :root[data-theme="dark"] {
        --bg-primary: #1A1814;
        --bg-secondary: #221F1A;
        --bg-tertiary: #2A2620;
        --text-primary: #F5E6D3;
        --text-secondary: #D4C4B0;
        --text-tertiary: #A89986;
        --text-quaternary: #7C6E5C;
        --border-primary: #3A342C;
        --border-secondary: #302A24;
        --glass-bg: rgba(34, 31, 26, 0.7);
        --glass-border: rgba(255, 255, 255, 0.1);
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.4), 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.4), 0 4px 6px -2px rgba(0, 0, 0, 0.3);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* ==== Global Styles ==== */
    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        position: relative;
        overflow-x: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(248, 212, 161, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(110, 231, 183, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(216, 180, 254, 0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: -1;
    }

    .content-wrapper {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ==== Typography ==== */
    .font-display {
        font-family: 'Playfair Display', serif;
    }

    .text-gradient {
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ==== Welcome Card ==== */
    .welcome-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        color: var(--text-primary);
        padding: 2.5rem;
        border-radius: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-sunset);
    }

    .welcome-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-2xl);
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .welcome-text {
        flex: 1;
    }

    .welcome-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        color: var(--text-primary);
    }

    .welcome-subtitle {
        opacity: 0.9;
        font-size: 1.2rem;
        font-weight: 400;
        color: var(--text-secondary);
    }

    .current-date {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--glass-bg);
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        flex-shrink: 0;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .current-date:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-xl);
    }

    .date { 
        font-size: 3rem; 
        font-weight: 700; 
        line-height: 1; 
        color: var(--text-primary);
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .month-year {
        display: flex;
        flex-direction: column;
    }
    
    .month { 
        font-weight: 600; 
        font-size: 1.2rem;
        color: var(--text-primary);
    }
    
    .year { 
        opacity: 0.8; 
        font-size: 1rem; 
        color: var(--text-secondary);
    }

    .welcome-decoration {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .decoration-circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
    }

    .decoration-1 {
        width: 200px;
        height: 200px;
        background: var(--gradient-warm);
        top: -100px;
        right: -50px;
        animation: float 20s ease-in-out infinite;
    }

    .decoration-2 {
        width: 150px;
        height: 150px;
        background: var(--gradient-teal);
        bottom: -50px;
        right: 100px;
        animation: float 15s ease-in-out infinite reverse;
    }

    .decoration-3 {
        width: 100px;
        height: 100px;
        background: var(--gradient-purple);
        top: 50%;
        right: -30px;
        animation: float 25s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    /* ==== Alert ==== */
    .alert-message {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        font-weight: 500;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-message.success {
        background: rgba(40, 167, 69, 0.1);
        border-color: rgba(40, 167, 69, 0.2);
        color: var(--teal-700);
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-teal);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-close {
        background: none;
        border: none;
        color: var(--text-tertiary);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .alert-close:hover {
        background: rgba(0, 0, 0, 0.1);
        color: var(--text-primary);
    }

    /* ==== Action Cards ==== */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 2rem 1.5rem;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .action-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .action-item.primary::before { background: var(--gradient-warm); }
    .action-item.secondary::before { background: var(--gradient-teal); }
    .action-item.info::before { background: var(--gradient-purple); }
    .action-item.accent::before { background: var(--gradient-coral); }

    .action-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-2xl);
        text-decoration: none;
    }

    .action-item:hover::before {
        opacity: 1;
    }

    .action-item:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .action-item:hover .action-arrow {
        transform: translateX(5px);
    }

    .action-icon {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .action-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: rotate(45deg);
        animation: shine 3s ease-in-out infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    }

    .action-item.primary .action-icon {
        background: var(--gradient-warm);
        box-shadow: var(--shadow-glow);
    }
    
    .action-item.secondary .action-icon {
        background: var(--gradient-teal);
        box-shadow: var(--shadow-glow-teal);
    }
    
    .action-item.info .action-icon {
        background: var(--gradient-purple);
        box-shadow: var(--shadow-glow-purple);
    }
    
    .action-item.accent .action-icon {
        background: var(--gradient-coral);
        box-shadow: var(--shadow-glow-coral);
    }

    .action-content {
        flex: 1;
    }

    .action-content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .action-item:hover .action-content h3 {
        color: var(--warm-600);
    }

    .action-content p {
        color: var(--text-secondary);
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.4;
    }

    .action-arrow {
        color: var(--text-tertiary);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .action-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .action-item:hover .action-shine {
        left: 100%;
    }

    /* ==== Stats Grid ==== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card.warm::before { background: var(--gradient-warm); }
    .stat-card.teal::before { background: var(--gradient-teal); }
    .stat-card.purple::before { background: var(--gradient-purple); }
    .stat-card.coral::before { background: var(--gradient-coral); }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-2xl);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: rotate(45deg);
        animation: shine 3s ease-in-out infinite;
    }

    .stat-icon.warm { background: var(--gradient-warm); box-shadow: var(--shadow-glow); }
    .stat-icon.teal { background: var(--gradient-teal); box-shadow: var(--shadow-glow-teal); }
    .stat-icon.purple { background: var(--gradient-purple); box-shadow: var(--shadow-glow-purple); }
    .stat-icon.coral { background: var(--gradient-coral); box-shadow: var(--shadow-glow-coral); }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .stat-change {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 2rem;
        position: relative;
        overflow: hidden;
    }

    .stat-change::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: slideShine 2s ease-in-out infinite;
    }

    @keyframes slideShine {
        0% { left: -100%; }
        50%, 100% { left: 100%; }
    }

    .stat-change.positive {
        color: var(--teal-700);
        background: var(--teal-50);
        border: 1px solid var(--teal-200);
    }

    .stat-change.negative {
        color: var(--coral-700);
        background: var(--coral-50);
        border: 1px solid var(--coral-200);
    }

    /* ==== Recent Activity ==== */
    .recent-activity {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .recent-activity:hover {
        box-shadow: var(--shadow-xl);
    }

    .activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-secondary);
    }

    .activity-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .activity-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--warm-600);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .activity-link:hover {
        color: var(--warm-700);
        transform: translateX(3px);
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: var(--bg-tertiary);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .activity-icon.approved {
        background: var(--gradient-teal);
    }

    .activity-icon.pending {
        background: var(--gradient-amber);
    }

    .activity-icon.completed {
        background: var(--gradient-purple);
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .activity-desc {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .activity-time {
        font-size: 0.8rem;
        color: var(--text-tertiary);
    }

    /* ==== Animations ==== */
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ==== Responsive ==== */
    @media (max-width: 968px) {
        .welcome-content { 
            flex-direction: column; 
            text-align: center; 
            gap: 1.5rem; 
        }
        
        .welcome-title {
            font-size: 2rem;
        }
        
        .date {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1.5rem;
        }
        
        .actions-grid { 
            grid-template-columns: 1fr; 
            gap: 1rem; 
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .welcome-card {
            padding: 1.5rem;
        }
        
        .current-date {
            padding: 1rem 1.5rem;
        }
        
        .date {
            font-size: 2rem;
        }
        
        .welcome-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .action-item {
            padding: 1.5rem;
        }
        
        .action-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        .action-content h3 {
            font-size: 1.2rem;
        }
        
        .recent-activity {
            padding: 1.5rem;
        }
        
        .activity-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<script>
    // Alert close functionality
    document.addEventListener('DOMContentLoaded', function() {
        const alertCloseButtons = document.querySelectorAll('.alert-close');
        
        alertCloseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alertMessage = this.closest('.alert-message');
                alertMessage.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    alertMessage.remove();
                }, 300);
            });
        });
        
        // Auto-hide success messages after 5 seconds
        const successAlerts = document.querySelectorAll('.alert-message.success');
        successAlerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    });
    
    // Add slide up animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection