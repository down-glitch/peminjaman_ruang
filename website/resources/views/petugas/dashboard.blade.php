@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 class="welcome-title">
            Selamat Datang, <span>{{ Auth::user()->name }}</span> 👋
        </h1>
        <p class="welcome-subtitle">Berikut ringkasan aktivitas terbaru dalam sistem peminjaman ruang:</p>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Aksi Cepat</h2>
        <div class="actions-grid">
            <a href="{{ route('jadwal.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4>Lihat Jadwal</h4>
            </a>
            
            <a href="{{ route('peminjaman.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h4>Daftar Peminjaman</h4>
            </a>
            
            <a href="{{ route('laporan.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h4>Lihat Laporan</h4>
            </a>
        </div>
    </div>
</div>

<style>
    /* Dashboard Container */
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Welcome Section */
    .welcome-section {
        margin-bottom: 3rem;
        text-align: center;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 1rem;
    }

    .welcome-title span {
        color: var(--accent);
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: var(--text);
        opacity: 0.8;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Quick Actions */
    .quick-actions {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 2rem;
        position: relative;
        padding-left: 0.75rem;
        text-align: center;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: -10px;
        width: 60px;
        height: 4px;
        background: var(--accent);
        border-radius: 2px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .action-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 2.5rem 1.5rem;
        text-decoration: none;
        color: var(--text);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary);
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .action-icon {
        width: 80px;
        height: 80px;
        background: var(--primary);
        color: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1);
        background: var(--accent);
    }

    .action-card h4 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1.5rem;
        }

        .welcome-title {
            font-size: 2rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .actions-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .action-card {
            padding: 2rem 1.5rem;
        }

        .action-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
        }
    }
</style>
@endsection