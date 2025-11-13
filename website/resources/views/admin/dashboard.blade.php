@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin
        </h3>
        <div class="badge-simple">
            <i class="fas fa-clock"></i>
            {{ \Carbon\Carbon::now()->locale('id')->format('d F Y, H:i') }}
        </div>
    </div>

    <!-- Notification for pending bookings -->
    @if($pendingBookingsCount > 0)
        <div class="alert-simple warning mb-4 pulse-animation">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Perhatian!</strong> Ada {{ $pendingBookingsCount }} pengajuan peminjaman yang belum diproses.
                <a href="{{ route('peminjaman.index') }}" class="alert-link">Lihat sekarang</a>
            </div>
        </div>
    @else
        <div class="alert-simple success mb-4">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Semua Beres!</strong> Tidak ada pengajuan peminjaman yang menunggu. Semua pengajuan telah diproses.
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $totalBookings }}</h4>
                    <p>Total Peminjaman</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon approved">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $approvedBookings }}</h4>
                    <p>Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $pendingBookingsCount }}</h4>
                    <p>Menunggu Persetujuan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $rejectedBookings }}</h4>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="card-simple">
        <div class="card-body-simple">
            <div class="welcome-section">
                <div class="welcome-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="welcome-content">
                    <h4>Selamat datang di halaman dashboard admin.</h4>
                    <p>Di sini Anda dapat memantau dan mengelola semua aktivitas peminjaman ruangan. Gunakan menu di atas untuk navigasi ke berbagai fitur yang tersedia.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        color: var(--accent);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.5rem;
    }

    .badge-simple {
        background: var(--primary);
        color: var(--text);
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }

    .alert-simple {
        padding: 16px 20px;
        border-radius: 8px;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1rem;
    }

    .alert-simple.success {
        background: rgba(40, 167, 69, 0.1);
        border-left-color: #28a745;
        color: var(--text);
    }

    .alert-simple.warning {
        background: rgba(255, 193, 7, 0.1);
        border-left-color: #ffc107;
        color: var(--text);
    }

    .alert-simple i {
        font-size: 1.2rem;
    }

    .alert-simple.warning i {
        color: #ffc107;
    }

    .alert-simple.success i {
        color: #28a745;
    }

    .alert-link {
        color: #ffc107;
        text-decoration: none;
        font-weight: 500;
        margin-left: 5px;
    }

    .alert-link:hover {
        text-decoration: underline;
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
        }
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.5rem;
    }

    .stat-icon.total {
        background: rgba(0, 123, 255, 0.15);
        color: #007bff;
    }

    .stat-icon.approved {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .stat-icon.pending {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .stat-icon.rejected {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .stat-content h4 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        color: var(--accent);
    }

    .stat-content p {
        margin: 5px 0 0;
        color: var(--text);
        font-size: 0.9rem;
    }

    .card-simple {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid rgba(156, 124, 94, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .card-body-simple {
        padding: 20px;
    }

    .welcome-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .welcome-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text);
        font-size: 1.5rem;
    }

    .welcome-content h4 {
        color: var(--accent);
        margin-bottom: 10px;
    }

    .welcome-content p {
        color: var(--text);
        margin: 0;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }

        .stat-icon {
            margin-right: 0;
            margin-bottom: 10px;
        }

        .welcome-section {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .badge-simple {
            align-self: flex-start;
        }
    }
</style>
@endsection