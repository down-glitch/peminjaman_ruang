@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container py-4">
    <!-- Header dengan gradien subtle -->
    <div class="header-section mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h1 class="h3 mb-1 fw-bold">Riwayat Peminjaman</h1>
                        <p class="text-muted mb-0">Kelola dan pantau semua peminjaman ruangan Anda</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="stats-badge">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-list-check me-2"></i>
                        <div>
                            <div class="stats-number">{{ count($bookings) }}</div>
                            <div class="stats-label">Total</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Filter Section dengan design lebih baik -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label class="me-3 fw-semibold">Filter:</label>
                        <div class="filter-pills">
                            <button class="filter-btn active" onclick="filterTable('all')">
                                <i class="fas fa-border-all me-1"></i>Semua
                            </button>
                            <button class="filter-btn" onclick="filterTable('pending')">
                                <i class="fas fa-clock me-1"></i>Menunggu
                            </button>
                            <button class="filter-btn" onclick="filterTable('approved')">
                                <i class="fas fa-check me-1"></i>Disetujui
                            </button>
                            <button class="filter-btn" onclick="filterTable('rejected')">
                                <i class="fas fa-times me-1"></i>Ditolak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    @if($bookings->count() > 0)
        <div class="row g-4">
            @foreach($bookings as $index => $b)
            <div class="col-lg-6 col-xl-4 booking-item" data-status="{{ $b->status }}">
                <div class="card booking-card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="room-icon me-3">
                                    <i class="fas fa-door-open"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1 fw-bold">{{ $b->room->nama_room ?? 'Ruangan' }}</h5>
                                    <span class="booking-id">ID: #{{ str_pad($index + 1, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                            <div class="status-indicator">
                                @if($b->status == 'pending')
                                    <span class="status-badge pending">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($b->status == 'approved')
                                    <span class="status-badge approved">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @else
                                    <span class="status-badge rejected">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body pb-4">
                        <div class="booking-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="detail-content">
                                    <label>Tanggal Pinjam</label>
                                    <span>{{ \Carbon\Carbon::parse($b->tanggal)->format('l, d F Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-business-time"></i>
                                </div>
                                <div class="detail-content">
                                    <label>Waktu</label>
                                    <span>{{ \Carbon\Carbon::parse($b->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->jam_selesai)->format('H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <div class="detail-content">
                                    <label>Durasi</label>
                                    <span>
                                        @php
                                            $start = \Carbon\Carbon::parse($b->jam_mulai);
                                            $end = \Carbon\Carbon::parse($b->jam_selesai);
                                            $duration = $end->diff($start);
                                            $hours = $duration->h;
                                            $minutes = $duration->i;
                                            $totalMinutes = ($hours * 60) + $minutes;
                                            $formattedDuration = '';
                                            if ($hours > 0) {
                                                $formattedDuration .= $hours . ' jam';
                                            }
                                            if ($minutes > 0) {
                                                $formattedDuration .= ($formattedDuration ? ' ' : '') . $minutes . ' menit';
                                            }
                                            if ($totalMinutes == 0) {
                                                $formattedDuration = '0 menit';
                                            }
                                        @endphp
                                        {{ $formattedDuration }}
                                    </span>
                                </div>
                            </div>

                            @if($b->keterangan)
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-sticky-note"></i>
                                </div>
                                <div class="detail-content">
                                    <label>Keterangan</label>
                                    <span class="keterangan-text">{{ $b->keterangan }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus me-1"></i>
                                {{ $b->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="empty-state">
            <div class="empty-illustration">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
            <div class="empty-content">
                <h3 class="mb-3">Belum Ada Riwayat Peminjaman</h3>
                <p class="text-muted mb-4">Anda belum pernah melakukan peminjaman ruangan. Mulai sekarang untuk memesan ruangan yang Anda butuhkan!</p>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman Pertama
                </a>
            </div>
        </div>
    @endif
</div>

<style>
/* Header dengan gradien subtle */
.header-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 1rem;
    padding: 2rem;
    border-left: 4px solid #6A5A41;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(106, 90, 65, 0.2);
}

.stats-badge {
    background: white;
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(106, 90, 65, 0.1);
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #6A5A41;
    line-height: 1;
}

.stats-label {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Filter Pills */
.filter-pills {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #dee2e6;
    background: white;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    border-color: #6A5A41;
    color: #6A5A41;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    border-color: #6A5A41;
    color: white;
    box-shadow: 0 4px 12px rgba(106, 90, 65, 0.2);
}

/* Booking Cards */
.booking-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.booking-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
}

.room-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(106, 90, 65, 0.2);
    transition: all 0.3s ease;
}

.booking-card:hover .room-icon {
    transform: scale(1.05) rotate(5deg);
}

.booking-id {
    font-size: 0.75rem;
    color: #6c757d;
    font-family: 'Courier New', monospace;
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.status-badge.pending {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: white;
}

.status-badge.approved {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.status-badge.rejected {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    color: white;
}

/* Booking Details */
.booking-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.detail-icon {
    width: 32px;
    height: 32px;
    background: #f8f9fa;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6A5A41;
    font-size: 0.875rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.booking-card:hover .detail-icon {
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    color: white;
    transform: scale(1.05);
}

.detail-content {
    flex: 1;
}

.detail-content label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    display: block;
    margin-bottom: 0.25rem;
}

.detail-content span {
    font-size: 0.875rem;
    color: #212529;
    font-weight: 500;
}

.keterangan-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 1rem;
    border: 2px dashed #dee2e6;
}

.empty-illustration {
    margin-bottom: 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 10px 25px rgba(106, 90, 65, 0.2);
    animation: pulse 2s ease-in-out infinite;
}

.empty-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Primary Button */
.btn-primary {
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #6A5A41 0%, #8B7355 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(106, 90, 65, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .header-section {
        padding: 1.5rem;
    }
    
    .header-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .stats-number {
        font-size: 1.25rem;
    }
    
    .filter-pills {
        flex-direction: column;
        width: 100%;
    }
    
    .filter-btn {
        text-align: center;
        border-radius: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    window.filterTable = function(status) {
        const bookingItems = document.querySelectorAll('.booking-item');
        const filterBtns = document.querySelectorAll('.filter-btn');
        
        // Update active button
        filterBtns.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filter items
        bookingItems.forEach(item => {
            if (status === 'all' || item.dataset.status === status) {
                item.style.display = 'block';
                // Add fade in animation
                item.style.animation = 'fadeIn 0.5s ease';
            } else {
                item.style.display = 'none';
            }
        });
    };
    
    // Auto-hide success messages
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Add fade in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection