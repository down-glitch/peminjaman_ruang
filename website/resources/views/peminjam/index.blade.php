@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-history"></i>
                    Riwayat Peminjaman
                </h1>
                <p class="page-subtitle">Lihat semua riwayat peminjaman ruangan Anda</p>
            </div>
            <div class="stats-section">
                <div class="stat-card total">
                    <div class="stat-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number">{{ count($bookings) }}</span>
                        <span class="stat-label">Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-message success fade-in">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <h6 class="alert-title">Berhasil!</h6>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="filter-item">
                <label>Status:</label>
                <select class="filter-select" onchange="filterTable()">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>
        <div class="filter-actions">
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Content -->
    @if($bookings->count() > 0)
        <div class="booking-cards">
            @foreach($bookings as $index => $b)
            <div class="booking-card" data-status="{{ $b->status }}">
                <div class="card-header">
                    <div class="room-info">
                        <div class="room-icon">
                            <i class="fas fa-door-closed"></i>
                        </div>
                        <div class="room-details">
                            <h3 class="room-name">{{ $b->room->nama_room ?? 'Ruangan' }}</h3>
                            <span class="booking-id">#{{ $index + 1 }}</span>
                        </div>
                    </div>
                    <div class="status-badge {{ $b->status }}">
                        @if($b->status == 'pending')
                            <i class="fas fa-clock"></i>
                            <span>Menunggu</span>
                        @elseif($b->status == 'approved')
                            <i class="fas fa-check"></i>
                            <span>Disetujui</span>
                        @else
                            <i class="fas fa-times"></i>
                            <span>Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <label>Tanggal</label>
                                <span>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <label>Waktu</label>
                                <span>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="info-content">
                                <label>Durasi</label>
                                <span>{{ \Carbon\Carbon::parse($b->jam_mulai)->diffInHours(\Carbon\Carbon::parse($b->jam_selesai)) }} jam</span>
                            </div>
                        </div>
                    </div>

                    @if($b->keterangan)
                    <div class="keterangan-section">
                        <label>Keterangan:</label>
                        <p class="keterangan-text">{{ $b->keterangan }}</p>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="booking-date">
                        Diajukan pada {{ $b->created_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="empty-content">
                <h3>Belum Ada Riwayat Peminjaman</h3>
                <p>Mulai dengan mengajukan peminjaman ruangan pertama Anda</p>
                <a href="{{ route('peminjaman.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Ajukan Peminjaman
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* CSS Variables dengan tema hangat yang diperbaiki */
    :root {
        /* Warm Color Palette - Dipertahankan */
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
        
        /* Complementary Colors */
        --teal-500: #10B981;
        --purple-500: #A855F7;
        --coral-500: #F43F5E;
        --amber-500: #F59E0B;
        --sky-500: #0EA5E9;
        
        /* Theme Variables - Dipertahankan */
        --bg-primary: #FFFBF5;
        --bg-secondary: #FFFFFF;
        --bg-tertiary: #F8F5F0;
        --text-primary: #2D2416;
        --text-secondary: #5A4A36;
        --text-tertiary: #8B7A65;
        --text-quaternary: #BDB4A5;
        --border-primary: #E8E1D3;
        --border-secondary: #F2E9DD;
        
        /* Enhanced Gradients */
        --gradient-warm: linear-gradient(135deg, #F8D4A1 0%, #C19660 50%, #A67C52 100%);
        --gradient-warm-light: linear-gradient(135deg, #FCE8C8 0%, #E2B88A 100%);
        --gradient-warm-subtle: linear-gradient(135deg, rgba(248, 212, 161, 0.1) 0%, rgba(193, 150, 96, 0.1) 100%);
        --gradient-teal: linear-gradient(135deg, #6EE7B7 0%, #34D399 50%, #10B981 100%);
        --gradient-coral: linear-gradient(135deg, #FDA4AF 0%, #FB7185 50%, #F43F5E 100%);
        --gradient-amber: linear-gradient(135deg, #FCD34D 0%, #FBBF24 50%, #F59E0B 100%);
        --gradient-sky: linear-gradient(135deg, #7DD3FC 0%, #38BDF8 50%, #0EA5E9 100%);
        --gradient-sunset: linear-gradient(135deg, #F8D4A1 0%, #FDA4AF 50%, #D8B4FE 100%);
        --gradient-ocean: linear-gradient(135deg, #7DD3FC 0%, #6EE7B7 50%, #FCD34D 100%);
        
        /* Enhanced Shadow System */
        --shadow-sm: 0 2px 4px rgba(45, 36, 22, 0.05);
        --shadow-md: 0 4px 8px rgba(45, 36, 22, 0.08);
        --shadow-lg: 0 8px 16px rgba(45, 36, 22, 0.12);
        --shadow-xl: 0 16px 32px rgba(45, 36, 22, 0.16);
        --shadow-2xl: 0 25px 50px rgba(45, 36, 22, 0.2);
        --shadow-glow: 0 0 20px rgba(248, 212, 161, 0.25);
        --shadow-glow-teal: 0 0 20px rgba(110, 231, 183, 0.25);
        --shadow-glow-coral: 0 0 20px rgba(253, 164, 175, 0.25);
        --shadow-glow-amber: 0 0 20px rgba(252, 211, 77, 0.25);
        --shadow-glow-sky: 0 0 20px rgba(125, 211, 252, 0.25);
        
        /* Glass Effect - Lebih Subtle */
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(232, 225, 211, 0.4);
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
        --glass-bg: rgba(34, 31, 26, 0.85);
        --glass-border: rgba(58, 52, 44, 0.4);
    }

    /* Global Styles */
    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Header Styles - Enhanced */
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .title-section {
        flex: 1;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.5rem;
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 0;
    }

    .stats-section {
        display: flex;
        gap: 1rem;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        background: var(--gradient-warm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        box-shadow: var(--shadow-md);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
        color: var(--text-secondary);
    }

    /* Alert Styles - Enhanced */
    .alert-message {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        position: relative;
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
        border: 1px solid rgba(40, 167, 69, 0.2);
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

    .alert-title {
        font-weight: 600;
        color: var(--teal-700);
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
    }

    .alert-content p {
        margin: 0;
        opacity: 0.9;
    }

    .alert-close {
        background: none;
        border: none;
        color: var(--teal-500);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .alert-close:hover {
        background: rgba(0, 0, 0, 0.1);
        color: var(--teal-700);
    }

    /* Filter Section - Enhanced */
    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.25rem 1.5rem;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
    }

    .filter-group {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-item label {
        font-weight: 500;
        color: var(--text-primary);
        white-space: nowrap;
    }

    .filter-select {
        padding: 0.625rem 1rem;
        border: 2px solid var(--border-primary);
        border-radius: 0.75rem;
        background: var(--glass-bg);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--warm-500);
        box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .btn-refresh {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        background: var(--gradient-warm);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-refresh:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Booking Cards - Enhanced with Color Play */
    .booking-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
    }

    .booking-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-warm);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .booking-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
    }

    .booking-card:hover::before {
        opacity: 1;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.5rem 1.5rem 1rem;
        border-bottom: 1px solid var(--border-primary);
    }

    .room-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .room-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        background: var(--gradient-warm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .booking-card:hover .room-icon {
        transform: scale(1.05) rotate(5deg);
    }

    .room-details {
        display: flex;
        flex-direction: column;
    }

    .room-name {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 0.25rem 0;
        font-size: 1.25rem;
    }

    .booking-id {
        font-size: 0.875rem;
        color: var(--warm-600);
        opacity: 0.8;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .status-badge.pending {
        background: var(--gradient-amber);
        color: white;
        box-shadow: var(--shadow-glow-amber);
    }

    .status-badge.approved {
        background: var(--gradient-teal);
        color: white;
        box-shadow: var(--shadow-glow-teal);
    }

    .status-badge.rejected {
        background: var(--gradient-coral);
        color: white;
        box-shadow: var(--shadow-glow-coral);
    }

    .card-body {
        padding: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        background: var(--gradient-warm-subtle);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--warm-600);
        font-size: 0.875rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .info-content {
        display: flex;
        flex-direction: column;
    }

    .info-content label {
        font-size: 0.75rem;
        color: var(--text-tertiary);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .info-content span {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .keterangan-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-primary);
    }

    .keterangan-section label {
        font-size: 0.875rem;
        color: var(--text-tertiary);
        margin-bottom: 0.5rem;
        display: block;
        font-weight: 500;
    }

    .keterangan-text {
        color: var(--text-secondary);
        opacity: 0.9;
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .card-footer {
        padding: 1rem 1.5rem;
        background: var(--gradient-warm-subtle);
        border-top: 1px solid var(--border-primary);
    }

    .booking-date {
        font-size: 0.875rem;
        color: var(--text-tertiary);
        text-align: center;
    }

    /* Empty State - Enhanced */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px dashed var(--border-primary);
        border-radius: 1.25rem;
        box-shadow: var(--shadow-lg);
    }

    .empty-icon {
        font-size: 4rem;
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
    }

    .empty-content h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-content p {
        opacity: 0.7;
        margin-bottom: 2rem;
        font-size: 1rem;
        color: var(--text-secondary);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 2rem;
        background: var(--gradient-warm);
        color: white;
        text-decoration: none;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
        color: white;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .booking-cards {
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .stats-section {
            justify-content: center;
        }

        .page-title {
            justify-content: center;
            font-size: 2rem;
        }

        .filter-section {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .filter-group {
            justify-content: center;
        }

        .booking-cards {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .room-info {
            justify-content: center;
            text-align: center;
        }

        .status-badge {
            align-self: center;
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            padding: 0 1rem;
        }

        .stat-card {
            padding: 0.75rem 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-icon {
            font-size: 3rem;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }

        .filter-group {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-item {
            justify-content: space-between;
        }
    }

    @media (max-width: 380px) {
        .room-info {
            flex-direction: column;
            text-align: center;
        }

        .info-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .info-icon {
            align-self: center;
        }
    }
</style>

<script>
    function filterTable() {
        const filter = document.querySelector('.filter-select').value;
        const cards = document.querySelectorAll('.booking-card');
        
        cards.forEach(card => {
            if (filter === 'all' || card.dataset.status === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Initialize filter on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterTable();
        
        // Alert close functionality
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