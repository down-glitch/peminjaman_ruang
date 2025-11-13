@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 class="welcome-title">
            Selamat Datang, <span>{{ Auth::user()->name }}</span> 👋
        </h1>
        <p class="welcome-subtitle">Kelola peminjaman ruang dengan mudah dan efisien</p>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Menu Utama</h2>
        <div class="actions-grid">
            <a href="{{ route('jadwal.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4>Jadwal</h4>
            </a>
            
            <a href="{{ route('peminjaman.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h4>Peminjaman</h4>
            </a>
            
            <a href="{{ route('laporan.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h4>Laporan</h4>
            </a>
        </div>
    </div>
</div>

<style>
    /* Dashboard Container */
    .dashboard-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Welcome Section */
    .welcome-section {
        text-align: center;
        margin-bottom: 3rem;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1F2937; /* --text */
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .welcome-title span {
        color: #3B82F6; /* --primary */
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: #6B7280; /* Warna abu-abu untuk subtitle */
        max-width: 500px;
        margin: 0 auto;
    }

    /* Quick Actions */
    .quick-actions {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1F2937; /* --text */
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #3B82F6; /* --primary */
        border-radius: 2px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .action-card {
        background: #FFFFFF; /* --card-bg */
        border-radius: 12px;
        padding: 2.5rem 1.5rem;
        text-decoration: none;
        color: #1F2937; /* --text */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #3B82F6; /* --primary */
    }

    .action-icon {
        width: 70px;
        height: 70px;
        background: #3B82F6; /* --primary */
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        background: #2563EB; /* Warna aksen yang sedikit lebih gelap */
        transform: scale(1.05);
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
            font-size: 1.3rem;
        }

        .actions-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .action-card {
            padding: 2rem 1.5rem;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .welcome-title {
            font-size: 1.8rem;
        }

        .actions-grid {
            gap: 1rem;
        }
    }
</style>
@endsection