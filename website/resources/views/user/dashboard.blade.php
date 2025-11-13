@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Halo, {{ Auth::user()->username }}! 👋</h1>
                    <p class="text-muted">Siap meminjam ruangan hari ini?</p>
                </div>
                <div class="text-center">
                    <div class="h2 mb-0">{{ now()->format('d') }}</div>
                    <div class="small">{{ now()->locale('id')->monthName }} {{ now()->format('Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-lg-6 col-md-12 mb-3">
            <a href="{{ route('peminjaman.create') }}" class="card text-decoration-none h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="fas fa-plus-circle text-primary fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Ajukan Peminjaman</h5>
                        <p class="text-muted mb-0">Buat pengajuan baru</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
        
        <div class="col-lg-6 col-md-12 mb-3">
            <a href="{{ route('peminjam.jadwal') }}" class="card text-decoration-none h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="fas fa-calendar-check text-success fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Jadwal Ruangan</h5>
                        <p class="text-muted mb-0">Cek ketersediaan ruangan</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
        
        <div class="col-lg-6 col-md-12 mb-3">
            <a href="{{ route('peminjaman.jadwalbooking') }}" class="card text-decoration-none h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                        <i class="fas fa-clock text-info fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Jadwal Booking</h5>
                        <p class="text-muted mb-0">Lihat semua jadwal booking aktif</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
        
        <div class="col-lg-6 col-md-12 mb-3">
            <a href="{{ route('peminjaman.user') }}" class="card text-decoration-none h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="fas fa-history text-warning fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Riwayat Saya</h5>
                        <p class="text-muted mb-0">Lihat status peminjaman</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    /* Basic Styling */
    .card {
        border-radius: 0.75rem;
        border: 1px solid rgba(0, 0, 0, 0.125);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .rounded-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-opacity-10 {
        opacity: 0.1;
    }
    
    /* Alert Styling */
    .alert {
        border-radius: 0.75rem;
        border: none;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .rounded-circle {
            width: 50px;
            height: 50px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success messages after 5 seconds
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});
</script>
@endsection