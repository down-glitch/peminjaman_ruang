<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
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
      
      /* Rich Brown Spectrum */
      --brown-50: #FAF8F6;
      --brown-100: #F3F0EC;
      --brown-200: #E8E2DB;
      --brown-300: #D8CFC4;
      --brown-400: #C4B5A0;
      --brown-500: #A68B6F;
      --brown-600: #8B7355;
      --brown-700: #6F5C47;
      --brown-800: #5A4A36;
      --brown-900: #453828;
      
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
      --gradient-surface: linear-gradient(180deg, var(--glass-bg) 0%, rgba(255, 255, 255, 0.8) 100%);
      
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      color: var(--text-primary);
      background: var(--bg-primary);
      font-size: 14px;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated Background */
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

    /* Typography */
    .font-display {
      font-family: 'Playfair Display', serif;
    }

    .text-gradient {
      background: var(--gradient-warm);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .text-gradient-teal {
      background: var(--gradient-teal);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .text-gradient-purple {
      background: var(--gradient-purple);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Layout */
    .app-container {
      display: flex;
      min-height: 100vh;
    }

    /* Premium Sidebar */
    .sidebar {
      width: 280px;
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-right: 1px solid var(--glass-border);
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      box-shadow: var(--shadow-xl);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-sunset);
    }

    .sidebar-header {
      padding: 2rem 1.5rem;
      border-bottom: 1px solid var(--border-secondary);
      background: var(--gradient-surface);
      position: relative;
      overflow: hidden;
    }

    .sidebar-header::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(248, 212, 161, 0.1) 0%, transparent 70%);
      animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      33% { transform: translate(30px, -30px) rotate(120deg); }
      66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 1rem;
      text-decoration: none;
      color: var(--text-primary);
      position: relative;
      z-index: 1;
    }

    .logo-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: var(--gradient-warm);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
    }

    .logo-icon::before {
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

    .sidebar h4 {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--text-primary);
      margin: 0;
      letter-spacing: -0.025em;
    }

    .sidebar-subtitle {
      font-size: 0.75rem;
      color: var(--text-tertiary);
      margin-top: 0.25rem;
      font-weight: 500;
    }

    .sidebar-nav {
      flex: 1;
      padding: 1.5rem 1rem;
      overflow-y: auto;
      position: relative;
      z-index: 1;
    }

    .nav-section {
      margin-bottom: 2rem;
    }

    .nav-section-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem 0.75rem;
      font-size: 0.625rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-tertiary);
      position: relative;
    }

    .nav-section-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gradient-warm);
      margin-left: 0.75rem;
      opacity: 0.3;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 0.875rem;
      padding: 0.875rem 1rem;
      border-radius: 0.75rem;
      color: var(--text-secondary);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      margin: 0.25rem 0;
    }

    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 0;
      background: var(--gradient-warm);
      border-radius: 0 4px 4px 0;
      transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar a::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: var(--gradient-warm);
      opacity: 0.05;
      transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar a:hover {
      background: var(--glass-bg);
      color: var(--text-primary);
      transform: translateX(4px);
      box-shadow: var(--shadow-md);
    }

    .sidebar a:hover::before {
      height: 70%;
    }

    .sidebar a:hover::after {
      left: 0;
    }

    .sidebar a.active {
      background: var(--gradient-warm);
      color: white;
      font-weight: 600;
      box-shadow: var(--shadow-glow);
      transform: translateX(4px);
    }

    .sidebar a.active::before {
      height: 70%;
      background: white;
    }

    .nav-icon {
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
    }

    .sidebar a:hover .nav-icon {
      transform: scale(1.1);
    }

    .sidebar a.active .nav-icon {
      transform: scale(1.1);
    }

    .sidebar-footer {
      padding: 1.5rem 1rem;
      border-top: 1px solid var(--border-secondary);
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      position: relative;
      z-index: 1;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 0.875rem;
      padding: 1rem;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      margin-bottom: 1rem;
      position: relative;
      overflow: hidden;
    }

    .user-profile::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: var(--gradient-aurora);
    }

    .user-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--gradient-royal);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 1.125rem;
      box-shadow: var(--shadow-md);
      position: relative;
      z-index: 1;
    }

    .user-info {
      flex: 1;
      min-width: 0;
    }

    .user-name {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .user-role {
      font-size: 0.75rem;
      color: var(--text-tertiary);
      font-weight: 500;
    }

    /* Main Content */
    .content {
      flex: 1;
      margin-left: 280px;
      background: var(--bg-primary);
      min-height: 100vh;
      position: relative;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .content-wrapper {
      padding: 2rem;
      max-width: 1400px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    /* Header */
    .page-header {
      margin-bottom: 2.5rem;
      position: relative;
    }

    .page-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: var(--gradient-warm);
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 800;
      background: var(--gradient-warm);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
      letter-spacing: -0.025em;
      position: relative;
    }

    .page-subtitle {
      color: var(--text-secondary);
      font-size: 1rem;
      font-weight: 400;
    }

    /* Premium Cards */
    .card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: var(--gradient-warm);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-2xl);
    }

    .card:hover::before {
      opacity: 1;
    }

    .card-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--border-secondary);
      background: var(--glass-bg);
      position: relative;
    }

    .card-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 3px;
      background: var(--gradient-warm);
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    .card-body {
      padding: 1.5rem;
    }

    /* Stat Cards Grid */
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stats-card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      padding: 1.75rem;
      box-shadow: var(--shadow-lg);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .stats-card.warm::before { background: var(--gradient-warm); }
    .stats-card.teal::before { background: var(--gradient-teal); }
    .stats-card.purple::before { background: var(--gradient-purple); }
    .stats-card.coral::before { background: var(--gradient-coral); }
    .stats-card.amber::before { background: var(--gradient-amber); }
    .stats-card.sky::before { background: var(--gradient-sky); }

    .stats-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-2xl);
    }

    .stats-card:hover::before {
      opacity: 1;
    }

    .stats-card:hover .stats-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .stats-icon {
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
      margin-bottom: 1.5rem;
    }

    .stats-icon::before {
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

    .stats-icon.warm { background: var(--gradient-warm); box-shadow: var(--shadow-glow); }
    .stats-icon.teal { background: var(--gradient-teal); box-shadow: var(--shadow-glow-teal); }
    .stats-icon.purple { background: var(--gradient-purple); box-shadow: var(--shadow-glow-purple); }
    .stats-icon.coral { background: var(--gradient-coral); box-shadow: var(--shadow-glow-coral); }
    .stats-icon.amber { background: var(--gradient-amber); }
    .stats-icon.sky { background: var(--gradient-sky); }

    .stats-value {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--text-primary);
      line-height: 1;
      margin-bottom: 0.5rem;
      position: relative;
    }

    .stats-label {
      font-size: 0.875rem;
      color: var(--text-secondary);
      margin-bottom: 1rem;
      font-weight: 500;
    }

    /* Data Table */
    .data-table-container {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .data-table-container:hover {
      box-shadow: var(--shadow-xl);
    }

    .data-table-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--border-secondary);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: var(--glass-bg);
    }

    .data-table-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-primary);
    }

    .data-table-actions {
      display: flex;
      gap: 0.75rem;
    }

    .table {
      margin: 0;
      background: var(--glass-bg);
    }

    .table thead th {
      background: var(--glass-bg);
      border-bottom: 2px solid var(--border-primary);
      font-weight: 700;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-secondary);
      padding: 1rem 1.5rem;
      position: relative;
    }

    .table thead th::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 1.5rem;
      right: 1.5rem;
      height: 2px;
      background: var(--gradient-warm);
      opacity: 0.3;
    }

    .table tbody td {
      padding: 1.25rem 1.5rem;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-secondary);
      font-size: 0.875rem;
      transition: all 0.2s ease;
    }

    .table tbody tr {
      transition: all 0.2s ease;
      position: relative;
    }

    .table tbody tr::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: var(--gradient-warm);
      transform: scaleY(0);
      transition: transform 0.2s ease;
    }

    .table tbody tr:hover {
      background: var(--glass-bg);
      transform: translateX(4px);
    }

    .table tbody tr:hover::before {
      transform: scaleY(1);
    }

    /* Premium Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      border-radius: 0.75rem;
      font-size: 0.875rem;
      font-weight: 600;
      text-decoration: none;
      border: 1px solid transparent;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s ease;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .btn-primary {
      background: var(--gradient-warm);
      color: white;
      border-color: var(--warm-600);
      box-shadow: var(--shadow-glow);
    }

    .btn-primary:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: var(--shadow-xl), var(--shadow-glow);
    }

    .btn-teal {
      background: var(--gradient-teal);
      color: white;
      border-color: var(--teal-600);
      box-shadow: var(--shadow-glow-teal);
    }

    .btn-purple {
      background: var(--gradient-purple);
      color: white;
      border-color: var(--purple-600);
      box-shadow: var(--shadow-glow-purple);
    }

    .btn-coral {
      background: var(--gradient-coral);
      color: white;
      border-color: var(--coral-600);
      box-shadow: var(--shadow-glow-coral);
    }

    .btn-secondary {
      background: var(--glass-bg);
      color: var(--text-primary);
      border-color: var(--border-primary);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .btn-secondary:hover:not(:disabled) {
      background: var(--bg-tertiary);
      transform: translateY(-1px);
    }

    .btn-ghost {
      background: transparent;
      color: var(--text-secondary);
      border-color: transparent;
    }

    .btn-ghost:hover:not(:disabled) {
      background: var(--glass-bg);
      color: var(--text-primary);
    }

    .btn-icon {
      width: 40px;
      height: 40px;
      padding: 0;
      border-radius: 0.5rem;
    }

    /* Status Badges */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 2rem;
      font-size: 0.75rem;
      font-weight: 600;
      position: relative;
      overflow: hidden;
    }

    .badge::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      animation: slideShine 3s ease-in-out infinite;
    }

    .badge::after {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes slideShine {
      0% { left: -100%; }
      50%, 100% { left: 100%; }
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(1.2); }
    }

    .badge-success {
      background: var(--teal-50);
      color: var(--teal-700);
      border: 1px solid var(--teal-200);
    }

    .badge-success::after {
      background: var(--teal-500);
    }

    .badge-warning {
      background: var(--amber-50);
      color: var(--amber-700);
      border: 1px solid var(--amber-200);
    }

    .badge-warning::after {
      background: var(--amber-500);
    }

    .badge-danger {
      background: var(--coral-50);
      color: var(--coral-700);
      border: 1px solid var(--coral-200);
    }

    .badge-danger::after {
      background: var(--coral-500);
    }

    /* Forms */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--border-primary);
      border-radius: 0.75rem;
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: var(--text-primary);
      font-size: 0.875rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control:focus, .form-select:focus {
      outline: none;
      border-color: var(--warm-500);
      box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
      background: var(--bg-secondary);
    }

    .form-control::placeholder, .form-select::placeholder {
      color: var(--text-quaternary);
    }

    /* Search Box */
    .search-box {
      position: relative;
      width: 320px;
    }

    .search-input {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 3rem;
      border: 1px solid var(--border-primary);
      border-radius: 0.75rem;
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: var(--text-primary);
      font-size: 0.875rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .search-input:focus {
      outline: none;
      border-color: var(--warm-500);
      box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-tertiary);
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    .search-input:focus + .search-icon {
      color: var(--warm-500);
    }

    /* Alert */
    .alert {
      border-radius: 1rem;
      padding: 1rem 1.5rem;
      border: none;
      box-shadow: var(--shadow-md);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .alert-success {
      background: var(--teal-50);
      color: var(--teal-700);
      border: 1px solid var(--teal-200);
    }

    .alert-warning {
      background: var(--amber-50);
      color: var(--amber-700);
      border: 1px solid var(--amber-200);
    }

    .alert-danger {
      background: var(--coral-50);
      color: var(--coral-700);
      border: 1px solid var(--coral-200);
    }

    /* Modal */
    .modal-content {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      box-shadow: var(--shadow-2xl);
    }

    .modal-header {
      background: var(--glass-bg);
      border-bottom: 1px solid var(--border-secondary);
      border-radius: 1rem 1rem 0 0;
      padding: 1.5rem;
    }

    .modal-footer {
      border-top: 1px solid var(--border-secondary);
      padding: 1.5rem;
    }

    /* Dropdown */
    .dropdown-menu {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 1rem;
      box-shadow: var(--shadow-xl);
      padding: 0.5rem;
    }

    .dropdown-item {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      transition: all 0.2s ease;
    }

    .dropdown-item:hover {
      background: var(--glass-bg);
      color: var(--text-primary);
    }

    /* Pagination */
    .pagination {
      margin-top: 1.5rem;
    }

    .page-link {
      background: var(--glass-bg);
      border: 1px solid var(--border-primary);
      color: var(--text-primary);
      padding: 0.5rem 1rem;
      margin: 0 0.25rem;
      border-radius: 0.5rem;
      transition: all 0.2s ease;
    }

    .page-link:hover {
      background: var(--bg-tertiary);
      color: var(--text-primary);
      transform: translateY(-2px);
    }

    .page-item.active .page-link {
      background: var(--gradient-warm);
      border-color: var(--warm-600);
    }

    /* Progress */
    .progress {
      height: 8px;
      border-radius: 4px;
      background: var(--bg-tertiary);
      margin-top: 0.75rem;
    }

    .progress-bar {
      background: var(--gradient-warm);
      border-radius: 4px;
    }

    /* Breadcrumb */
    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 1rem;
    }

    .breadcrumb-item {
      color: var(--text-tertiary);
    }

    .breadcrumb-item.active {
      color: var(--text-primary);
    }

    .breadcrumb-item + .breadcrumb-item::before {
      content: "›";
      color: var(--text-tertiary);
    }

    /* Mobile Toggle */
    .mobile-menu-toggle {
      display: none;
      position: fixed;
      top: 1.5rem;
      left: 1.5rem;
      width: 56px;
      height: 56px;
      border-radius: 0.75rem;
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      color: var(--text-primary);
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow-lg);
      z-index: 1001;
      transition: all 0.3s ease;
    }

    .mobile-menu-toggle:hover {
      transform: scale(1.05);
      box-shadow: var(--shadow-xl);
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
      }

      .content-wrapper {
        padding: 1.5rem;
      }

      .mobile-menu-toggle {
        display: flex;
      }

      .stat-grid {
        grid-template-columns: 1fr;
      }

      .search-box {
        width: 100%;
      }

      .data-table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }

      .page-title {
        font-size: 2rem;
      }
    }

    /* Utility Classes */
    .text-muted {
      color: var(--text-tertiary) !important;
    }

    .bg-glass {
      background: var(--glass-bg) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .shadow-glow {
      box-shadow: var(--shadow-glow) !important;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: var(--bg-tertiary);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--gradient-warm);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--warm-600);
    }

    /* Loading Animation */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid var(--border-primary);
      border-radius: 50%;
      border-top-color: var(--warm-500);
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Floating Elements */
    .floating {
      animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    /* Glow Effects */
    .glow-warm {
      box-shadow: 0 0 30px rgba(248, 212, 161, 0.4) !important;
    }

    .glow-teal {
      box-shadow: 0 0 30px rgba(110, 231, 183, 0.4) !important;
    }

    .glow-purple {
      box-shadow: 0 0 30px rgba(216, 180, 254, 0.4) !important;
    }

    .glow-coral {
      box-shadow: 0 0 30px rgba(253, 164, 175, 0.4) !important;
    }
  </style>

  @stack('styles')
</head>
<body>
  @php
      $role = Auth::user()->role;

      $dashboardRoute = match($role) {
          'admin' => route('admin.dashboard'),
          'petugas' => route('petugas.dashboard'),
          default => route('user.dashboard')
      };

      $peminjamanRoute = match($role) {
          'admin' => route('peminjaman.index'),
          'petugas' => route('peminjaman.petugas'),
          'peminjam' => route('peminjaman.index'),
          default => '#'
      };

      $laporanRoute = in_array($role, ['admin', 'petugas']) ? route('laporan.index') : '#';

      $currentRoute = Request::route()->getName();
      $user = Auth::user();
  @endphp

  <div class="mobile-menu-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
    <i class="fas fa-bars"></i>
  </div>

  <div class="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        <div class="logo-icon">
          <i class="fas fa-door-open"></i>
        </div>
        <div>
          <h4>Peminjaman Ruang</h4>
          <div class="sidebar-subtitle">Sistem Manajemen</div>
        </div>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section">
        <div class="nav-section-title">Menu Utama</div>
        <a href="{{ $dashboardRoute }}" class="{{ str_contains($currentRoute, 'dashboard') ? 'active' : '' }}">
          <div class="nav-icon">
            <i class="fas fa-home"></i>
          </div>
          Dashboard
        </a>

        @if($role === 'admin')
          <a href="{{ route('manajemen.user') }}" class="{{ str_contains($currentRoute, 'manajemen.user') ? 'active' : '' }}">
            <div class="nav-icon">
              <i class="fas fa-users-cog"></i>
            </div>
            Manajemen User
          </a>
          <a href="{{ route('rooms.index') }}" class="{{ str_contains($currentRoute, 'rooms') ? 'active' : '' }}">
            <div class="nav-icon">
              <i class="fas fa-door-closed"></i>
            </div>
            Manajemen Ruang
          </a>
        @endif

        @if(in_array($role, ['admin', 'petugas']))
          <a href="{{ route('jadwal.index') }}" class="{{ str_contains($currentRoute, 'jadwal') ? 'active' : '' }}">
            <div class="nav-icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            Jadwal Ruang
          </a>
        @endif

        <a href="{{ $peminjamanRoute }}" class="{{ str_contains($currentRoute, 'peminjaman') ? 'active' : '' }}">
          <div class="nav-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          Peminjaman
        </a>

        @if($laporanRoute !== '#')
          <a href="{{ $laporanRoute }}" class="{{ str_contains($currentRoute, 'laporan') ? 'active' : '' }}">
            <div class="nav-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            Laporan
          </a>
        @endif
      </div>
    </div>

    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="user-avatar">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="user-info">
          <div class="user-name">{{ $user->name }}</div>
          <div class="user-role">{{ $user->role }}</div>
        </div>
      </div>
      
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <div class="nav-icon">
          <i class="fas fa-sign-out-alt"></i>
        </div>
        Logout
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
      </form>
    </div>
  </div>

  <div class="content">
    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.addEventListener('click', (e) => {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.mobile-menu-toggle');
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
          sidebar.classList.remove('active');
        }
      });
    });
  </script>

  @stack('scripts')
</body>
</html>