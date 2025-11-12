<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Peminjam')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    .brand {
      display: flex;
      align-items: center;
      gap: 1rem;
      text-decoration: none;
      color: var(--text-primary);
      position: relative;
      z-index: 1;
    }

    .brand-icon {
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

    .brand-icon::before {
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

    .brand-text {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: -0.025em;
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

    .nav-item {
      margin: 0.25rem 0;
      position: relative;
    }

    .nav-link {
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
    }

    .nav-link::before {
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

    .nav-link::after {
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

    .nav-link:hover {
      background: var(--glass-bg);
      color: var(--text-primary);
      transform: translateX(4px);
      box-shadow: var(--shadow-md);
    }

    .nav-link:hover::before {
      height: 70%;
    }

    .nav-link:hover::after {
      left: 0;
    }

    .nav-link.active {
      background: var(--gradient-warm);
      color: white;
      font-weight: 600;
      box-shadow: var(--shadow-glow);
      transform: translateX(4px);
    }

    .nav-link.active::before {
      height: 70%;
      background: white;
    }

    .nav-icon {
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.125rem;
      transition: transform 0.3s ease;
    }

    .nav-link:hover .nav-icon {
      transform: scale(1.1);
    }

    .nav-link.active .nav-icon {
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
    .main-content {
      flex: 1;
      margin-left: 280px;
      background: var(--bg-primary);
      min-height: 100vh;
      position: relative;
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

    .page-title {
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

    .stat-card {
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
    .stat-card.amber::before { background: var(--gradient-amber); }
    .stat-card.sky::before { background: var(--gradient-sky); }

    .stat-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-2xl);
    }

    .stat-card:hover::before {
      opacity: 1;
    }

    .stat-card:hover .stat-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .stat-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .stat-icon {
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
    .stat-icon.amber { background: var(--gradient-amber); }
    .stat-icon.sky { background: var(--gradient-sky); }

    .stat-value {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--text-primary);
      line-height: 1;
      margin-bottom: 0.5rem;
      position: relative;
    }

    .stat-label {
      font-size: 0.875rem;
      color: var(--text-secondary);
      margin-bottom: 1rem;
      font-weight: 500;
    }

    .stat-change {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.75rem;
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
    .status-badge {
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

    .status-badge::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      animation: slideShine 3s ease-in-out infinite;
    }

    .status-badge::after {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(1.2); }
    }

    .status-badge.approved {
      background: var(--teal-50);
      color: var(--teal-700);
      border: 1px solid var(--teal-200);
    }

    .status-badge.approved::after {
      background: var(--teal-500);
    }

    .status-badge.pending {
      background: var(--amber-50);
      color: var(--amber-700);
      border: 1px solid var(--amber-200);
    }

    .status-badge.pending::after {
      background: var(--amber-500);
    }

    .status-badge.rejected {
      background: var(--coral-50);
      color: var(--coral-700);
      border: 1px solid var(--coral-200);
    }

    .status-badge.rejected::after {
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

    .form-control {
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

    .form-control:focus {
      outline: none;
      border-color: var(--warm-500);
      box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
      background: var(--bg-secondary);
    }

    .form-control::placeholder {
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

    /* Toggle Switch */
    .toggle-switch {
      position: relative;
      width: 48px;
      height: 24px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: var(--border-primary);
      border-radius: 24px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background: white;
      border-radius: 50%;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: var(--shadow-sm);
    }

    .toggle-switch input:checked + .toggle-slider {
      background: var(--gradient-warm);
    }

    .toggle-switch input:checked + .toggle-slider:before {
      transform: translateX(24px);
    }

    /* Theme Toggle */
    .theme-toggle {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      color: var(--text-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow-xl);
      z-index: 999;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    .theme-toggle::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: var(--gradient-sunset);
      opacity: 0.1;
      animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .theme-toggle:hover {
      transform: scale(1.1) rotate(10deg);
      box-shadow: var(--shadow-2xl);
    }

    .theme-toggle i {
      font-size: 1.25rem;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
    }

    .theme-toggle:hover i {
      transform: rotate(-10deg);
    }

    /* Mobile Toggle */
    .mobile-toggle {
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

    .mobile-toggle:hover {
      transform: scale(1.05);
      box-shadow: var(--shadow-xl);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .mobile-toggle {
        display: flex;
      }

      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .content-wrapper {
        padding: 1.5rem;
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
</head>
<body>
  <div class="app-container">
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" id="mobileToggle">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Premium Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="{{ route('peminjam.dashboard') }}" class="brand">
          <div class="brand-icon floating">
            <i class="fas fa-tachometer-alt"></i>
          </div>
          <span class="brand-text">Dashboard</span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-section">
          <div class="nav-section-title">Menu Utama</div>
          <div class="nav-item">
            <a href="{{ route('peminjam.dashboard') }}" class="nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
              <span class="nav-icon"><i class="fas fa-home"></i></span>
              <span>Dashboard</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="{{ route('peminjaman.create') }}" class="nav-link {{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">
              <span class="nav-icon"><i class="fas fa-handshake"></i></span>
              <span>Pengajuan Pinjam</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="{{ route('peminjaman.user') }}" class="nav-link {{ request()->routeIs('peminjaman.user') ? 'active' : '' }}">
              <span class="nav-icon"><i class="fas fa-book"></i></span>
              <span>Riwayat Peminjaman</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="{{ route('peminjam.jadwal') }}" class="nav-link {{ request()->routeIs('peminjam.jadwal') ? 'active' : '' }}">
              <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
              <span>Jadwal Reguler</span>
            </a>
          </div>
          <div class="nav-item">
            <a href="{{ route('peminjaman.jadwalbooking') }}" class="nav-link {{ request()->routeIs('peminjaman.jadwalbooking') ? 'active' : '' }}">
              <span class="nav-icon"><i class="fas fa-calendar-check"></i></span>
              <span>Jadwal Booking</span>
            </a>
          </div>
        </div>
      </nav>

      <div class="sidebar-footer">
        <div class="user-profile">
          <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
          </div>
          <div class="user-info">
            <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
            <div class="user-role">{{ Auth::user()->role ?? 'Peminjam' }}</div>
          </div>
        </div>
        
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link logout-link">
          <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
          <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="content-wrapper">
        @yield('content')
      </div>
    </main>

    <!-- Premium Theme Toggle -->
    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i>
    </button>
  </div>

  <script>
    // Mobile Sidebar Toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');
    
    mobileToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 768 && 
          !sidebar.contains(e.target) && 
          !mobileToggle.contains(e.target) && 
          sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
      }
    });

    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const icon = themeToggle.querySelector('i');
    const savedTheme = localStorage.getItem('theme') || 'light';

    if (savedTheme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      icon.classList.replace('fa-moon', 'fa-sun');
    }

    themeToggle.addEventListener('click', () => {
      const isDark = document.documentElement.hasAttribute('data-theme');
      if (isDark) {
        document.documentElement.removeAttribute('data-theme');
        icon.classList.replace('fa-sun', 'fa-moon');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        icon.classList.replace('fa-moon', 'fa-sun');
        localStorage.setItem('theme', 'dark');
      }
    });

    // Close sidebar on mobile when navigating
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          sidebar.classList.remove('show');
        }
      });
    });

    // Add smooth scroll behavior
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

    // Add parallax effect to background
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallax = document.querySelector('body::before');
      if (parallax) {
        const speed = 0.5;
        parallax.style.transform = `translateY(${scrolled * speed}px)`;
      }
    });
  </script>
</body>
</html>