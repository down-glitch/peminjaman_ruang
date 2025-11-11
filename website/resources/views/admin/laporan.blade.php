@extends('layouts.app')

@section('title', 'Laporan Peminjaman Ruangan')

@section('content')
<div class="container-fluid">
    <!-- Print Header (Hidden on screen, visible on print) -->
    <div class="print-header">
        <div class="print-logo">
            <i class="fas fa-door-open"></i>
        </div>
        <div class="print-title">
            <h1>Laporan Peminjaman Ruangan</h1>
            <p>Dicetak pada: <span id="printDate"></span></p>
        </div>
    </div>

    <div class="page-header d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h3 class="page-title"><i class="fas fa-file-alt me-2"></i> Laporan Peminjaman Ruangan</h3>
            <p class="page-subtitle">Filter dan cetak laporan peminjaman ruangan</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-sync me-2"></i> Refresh
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header no-print">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Data Laporan</h5>
                </div>
                <div class="header-actions">
                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                    <button class="btn btn-sm btn-primary" onclick="printTable()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filter Section (Hidden on print) -->
            <div class="filter-section no-print">
                <form action="{{ route('laporan.index') }}" method="GET" class="filter-form">
                    <div class="row g-3 mb-4">
                        <div class="col-lg-3 col-md-6">
                            <label for="tanggal" class="form-label">Filter Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </span>
                                <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" 
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label for="bulan" class="form-label">Filter Bulan</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="month" name="bulan" id="bulan" value="{{ request('bulan') }}" 
                                       class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i> Filter
                                </button>
                                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-undo me-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Stats -->
            @php
                // Initialize variables with default values to prevent errors
                $bookingsCollection = isset($bookings) ? $bookings : collect([]);
                $total = $bookingsCollection->count();
                $approvedCount = $bookingsCollection->where('status', 'approved')->count();
                $pendingCount = $bookingsCollection->where('status', 'pending')->count();
                $rejectedCount = $bookingsCollection->where('status', 'rejected')->count();
                
                // Calculate percentages safely
                $approvedPercent = $total > 0 ? ($approvedCount / $total) * 100 : 0;
                $pendingPercent = $total > 0 ? ($pendingCount / $total) * 100 : 0;
                $rejectedPercent = $total > 0 ? ($rejectedCount / $total) * 100 : 0;
            @endphp

            <div class="stats-section mb-4 print-stats">
                <div class="row">
                    <!-- Total -->  
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon total">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="stats-info">
                                <h4>{{ $total }}</h4>
                                <p>Total Data</p>
                            </div>
                        </div>
                    </div>

                    <!-- Disetujui -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon approved">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-info">
                                <h4>{{ $approvedCount }}</h4>
                                <p>Disetujui</p>

                            </div>
                        </div>
                    </div>

                    <!-- Menunggu -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stats-info">
                                <h4>{{ $pendingCount }}</h4>
                                <p>Menunggu</p>

                            </div>
                        </div>
                    </div>

                    <!-- Ditolak -->
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon rejected">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stats-info">
                                <h4>{{ $rejectedCount }}</h4>
                                <p>Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div id="printTableArea">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover print-table" id="bookingTable">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Keterangan</th>
                                    <th width="120">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookingsCollection as $index => $b)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        @if(isset($b->user) && $b->user)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    {{ strtoupper(substr($b->user->username ?? 'User', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $b->user->username ?? '-' }}</div>
                                                    <small class="text-muted">{{ $b->user->email ?? '-' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="fw-medium">-</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($b->room) && $b->room)
                                            <div class="d-flex align-items-center">
                                                <div class="room-icon me-2">
                                                    <i class="fas fa-door-open"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $b->room->nama_room ?? '-' }}</div>
                                                    <small class="text-muted">Kapasitas: {{ $b->room->kapasitas ?? '-' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="fw-medium">-</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ isset($b->tanggal) ? \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d F Y') : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="time-info">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ isset($b->jam_mulai) && isset($b->jam_selesai) ? $b->jam_mulai . ' - ' . $b->jam_selesai : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="description-text" title="{{ $b->keterangan ?? '-' }}">
                                            {{ $b->keterangan ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($b->status))
                                            @if($b->status === 'approved')
                                                <span class="status-badge approved">
                                                    <i class="fas fa-check me-1"></i> Disetujui
                                                </span>
                                            @elseif($b->status === 'pending')
                                                <span class="status-badge pending">
                                                    <i class="fas fa-clock me-1"></i> Menunggu
                                                </span>
                                            @elseif($b->status === 'rejected')
                                                <span class="status-badge rejected">
                                                    <i class="fas fa-times me-1"></i> Ditolak
                                                </span>
                                            @else
                                                <span class="status-badge unknown">
                                                    <i class="fas fa-question me-1"></i> Tidak Diketahui
                                                </span>
                                            @endif
                                        @else
                                            <span class="status-badge unknown">
                                                <i class="fas fa-question me-1"></i> Tidak Diketahui
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5>Tidak ada data peminjaman</h5>
                                            <p>Tidak ditemukan data peminjaman dengan filter yang dipilih</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Table Footer -->
            <div class="table-footer d-flex justify-content-between align-items-center mt-3 no-print">
                <div class="text-muted">
                    <small>Menampilkan {{ $total }} data peminjaman</small>
                </div>
                <div class="table-actions">
                    <button class="btn btn-sm btn-outline-secondary" onclick="previousPage()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="nextPage()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Footer (Hidden on screen, visible on print) -->
    <div class="print-footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Sistem Peminjaman Ruangan</p>
            <p>Halaman <span class="page-number"></span></p>
        </div>
    </div>
</div>

<style>
    /* CSS Variables */
    :root {
        --gradient-primary: linear-gradient(135deg, #E2CEB1, #d4b995);
        --gradient-sidebar: linear-gradient(135deg, #f8f0d7, #e9dfc7);
        --card-bg: #ffffff;
        --sidebar-bg: #f8f0d7;
        --sidebar-hover: #e9dfc7;
        --border-color: rgba(156, 124, 94, 0.2);
        --text: #4a3c29;
        --text-secondary: #7a6b56;
        --text-muted: #9c8e7a;
        --accent: #9c7c5e;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 15px;
        color: var(--text-secondary);
        margin: 0;
    }

    .page-actions .btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .page-actions .btn:hover {
        background: var(--sidebar-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .card {
        background: var(--card-bg);
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .card-header {
        background: var(--gradient-sidebar);
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
    }

    .card-header h5 {
        font-weight: 600;
        color: var(--text);
        margin: 0;
    }

    .header-actions .btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text);
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .header-actions .btn:hover {
        background: var(--sidebar-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .header-actions .btn-primary {
        background: var(--gradient-primary);
        border: none;
        color: var(--text);
    }

    .header-actions .btn-primary:hover {
        background: var(--gradient-primary);
        box-shadow: var(--shadow-md);
    }

    .filter-section {
        background: var(--sidebar-bg);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 8px;
    }

    .input-group {
        position: relative;
    }

    .input-group-text {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-right: none;
        color: var(--accent);
    }

    .form-control, .form-select {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text);
        border-radius: 0 8px 8px 0;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.25rem rgba(156, 124, 94, 0.25);
    }

    .btn-primary {
        background: var(--gradient-primary);
        border: none;
        color: var(--text);
        font-weight: 600;
        padding: 10px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: var(--gradient-primary);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline-secondary {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text);
        font-weight: 500;
        padding: 10px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary:hover {
        background: var(--sidebar-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .stats-section {
        margin-bottom: 24px;
    }

    .stats-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stats-card.total::before {
        background: var(--gradient-primary);
    }

    .stats-card.approved::before {
        background: linear-gradient(180deg, #28a745, #20c997);
    }

    .stats-card.pending::before {
        background: linear-gradient(180deg, #ffc107, #fd7e14);
    }

    .stats-card.rejected::before {
        background: linear-gradient(180deg, #dc3545, #e83e8c);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .stats-icon.total {
        background: var(--gradient-primary);
    }

    .stats-icon.approved {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .stats-icon.pending {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }

    .stats-icon.rejected {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
    }

    .stats-info {
        flex: 1;
    }

    .stats-info h4 {
        font-weight: 700;
        font-size: 24px;
        margin-bottom: 4px;
        color: var(--text);
    }

    .stats-info p {
        font-size: 14px;
        color: var(--text-secondary);
        margin-bottom: 12px;
    }

    .stats-progress {
        height: 4px;
    }

    .progress {
        height: 4px;
        background: var(--sidebar-hover);
        border-radius: 2px;
    }

    .progress-bar {
        border-radius: 2px;
    }

    .table-container {
        background: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: var(--sidebar-bg);
        color: var(--text);
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
        padding: 16px;
        font-size: 14px;
        cursor: pointer;
        position: relative;
    }

    .table thead th:hover {
        background: var(--sidebar-hover);
    }

    .table thead th.sortable::after {
        content: '\f0dc';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 8px;
        opacity: 0.5;
    }

    .table thead th.sorted-asc::after {
        content: '\f0de';
        opacity: 1;
    }

    .table thead th.sorted-desc::after {
        content: '\f0dd';
        opacity: 1;
    }

    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .table tbody tr:hover {
        background: var(--sidebar-hover);
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        flex-shrink: 0;
    }

    .room-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--sidebar-hover);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .date-info, .time-info {
        display: flex;
        align-items: center;
        color: var(--text);
    }

    .date-info i, .time-info i {
        color: var(--accent);
        margin-right: 6px;
    }

    .description-text {
        color: var(--text);
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .status-badge.unknown {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: var(--text-muted);
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text);
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    .table-footer {
        padding: 16px 0;
    }

    .table-actions .btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text);
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .table-actions .btn:hover {
        background: var(--sidebar-hover);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    /* Print Header and Footer */
    .print-header {
        display: none;
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #000;
    }

    .print-logo {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .print-title h1 {
        font-size: 20px;
        font-weight: bold;
        margin: 0;
    }

    .print-title p {
        font-size: 12px;
        margin: 5px 0 0;
    }

    .print-footer {
        display: none;
        text-align: center;
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #ccc;
        font-size: 10px;
        color: #666;
    }

    /* Print Styles */
    @media print {
        /* General Print Settings */
        body {
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff !important;
        }

        /* Hide screen elements */
        .no-print, .page-header, .card-header, .filter-section, .table-footer {
            display: none !important;
        }

        /* Show print elements */
        .print-header, .print-footer, .print-stats {
            display: block !important;
        }

        /* Print Container */
        #printTableArea {
            position: relative !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: white !important;
        }

        /* Print Table */
        .print-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 0 !important;
            font-size: 11px !important;
        }

        .print-table thead th {
            background: #f5f5f5 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
            padding: 8px !important;
            text-align: left !important;
            font-weight: bold !important;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .print-table tbody td {
            border: 1px solid #000 !important;
            padding: 6px !important;
            background: white !important;
            color: #000 !important;
            vertical-align: top !important;
        }

        .print-table tbody tr:nth-child(even) {
            background: #f9f9f9 !important;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        /* Print Stats */
        .print-stats {
            margin-bottom: 20px !important;
        }

        .stats-card {
            border: 1px solid #000 !important;
            page-break-inside: avoid;
            margin-bottom: 10px !important;
        }

        .stats-icon {
            background: #f5f5f5 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
        }

        .stats-info h4 {
            color: #000 !important;
        }

        .stats-info p {
            color: #000 !important;
        }

        /* Status Badges */
        .status-badge {
            border: 1px solid #000 !important;
            background: white !important;
            color: #000 !important;
            padding: 2px 6px !important;
            font-size: 10px !important;
        }

        /* Avatar and Room Icons */
        .avatar-circle, .room-icon {
            background: #f5f5f5 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
        }

        /* Page Settings */
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        /* Page Numbers */
        .page-number:before {
            content: counter(page);
        }

        body {
            counter-reset: page;
        }

        /* Prevent content from being cut off */
        tr, .stats-card {
            page-break-inside: avoid;
        }

        /* Ensure table fits on page */
        .table-responsive {
            overflow: visible !important;
        }

        /* Adjust table width for print */
        .print-table {
            table-layout: fixed;
        }

        .print-table th:nth-child(1),
        .print-table td:nth-child(1) {
            width: 5%;
        }

        .print-table th:nth-child(2),
        .print-table td:nth-child(2) {
            width: 20%;
        }

        .print-table th:nth-child(3),
        .print-table td:nth-child(3) {
            width: 15%;
        }

        .print-table th:nth-child(4),
        .print-table td:nth-child(4) {
            width: 15%;
        }

        .print-table th:nth-child(5),
        .print-table td:nth-child(5) {
            width: 15%;
        }

        .print-table th:nth-child(6),
        .print-table td:nth-child(6) {
            width: 20%;
        }

        .print-table th:nth-child(7),
        .print-table td:nth-child(7) {
            width: 10%;
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .page-actions {
            margin-top: 16px;
            width: 100%;
        }

        .page-actions .btn {
            width: 100%;
        }

        .card-header {
            padding: 16px;
        }

        .header-actions {
            margin-top: 12px;
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .filter-section {
            padding: 16px;
        }

        .stats-card {
            padding: 16px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .stats-info h4 {
            font-size: 20px;
        }

        .table thead th, .table tbody td {
            padding: 12px 8px;
            font-size: 12px;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .room-icon {
            width: 30px;
            height: 30px;
        }

        .description-text {
            max-width: 150px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 24px;
        }

        .filter-form .row {
            gap: 12px;
        }

        .filter-form .col-lg-3 {
            width: 100%;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }

        .table-footer {
            flex-direction: column;
            gap: 12px;
        }

        .table-footer .text-muted {
            order: 2;
        }

        .table-actions {
            order: 1;
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Sort table functionality
document.addEventListener('DOMContentLoaded', function() {
    // Make table headers sortable
    const tableHeaders = document.querySelectorAll('.table thead th');
    tableHeaders.forEach((header, index) => {
        if (index > 0) { // Skip first column (No.)
            header.classList.add('sortable');
            header.addEventListener('click', function() {
                sortTable(index);
            });
        }
    });

    // Add animation to stats cards
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
            }
        });
    });

    document.querySelectorAll('.stats-card').forEach(card => {
        observer.observe(card);
    });
});

function sortTable(columnIndex) {
    const table = document.getElementById('bookingTable');
    if (!table) return; // Safety check
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const header = table.querySelectorAll('thead th')[columnIndex];
    
    // Determine sort direction
    const isAscending = !header.classList.contains('sorted-asc');
    
    // Remove sorted classes from all headers
    table.querySelectorAll('thead th').forEach(th => {
        th.classList.remove('sorted-asc', 'sorted-desc');
    });
    
    // Add appropriate class to clicked header
    header.classList.add(isAscending ? 'sorted-asc' : 'sorted-desc');
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        if (isAscending) {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

function printTable() {
    // Set print date
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const printDateElement = document.getElementById('printDate');
    if (printDateElement) {
        printDateElement.textContent = now.toLocaleDateString('id-ID', options);
    }
    
    // Trigger print dialog
    window.print();
}

function exportToExcel() {
    const table = document.getElementById('bookingTable');
    if (!table) {
        showToast('Tabel tidak ditemukan');
        return;
    }
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    // Get headers
    const headers = [];
    table.querySelectorAll('thead th').forEach(th => {
        headers.push(th.textContent.trim());
    });
    csv.push(headers.join(','));
    
    // Get data rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = [];
        tr.querySelectorAll('td').forEach(td => {
            // Clean up text content for CSV
            let text = td.textContent.trim();
            // Replace commas with semicolons to avoid CSV issues
            text = text.replace(/,/g, ';');
            // If text contains quotes, escape them
            if (text.includes('"')) {
                text = text.replace(/"/g, '""');
            }
            // If text contains a newline or other special characters, wrap in quotes
            if (text.includes('\n') || text.includes('\r') || text.includes(',')) {
                text = `"${text}"`;
            }
            row.push(text);
        });
        csv.push(row.join(','));
    });
    
    // Create a downloadable CSV file
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    
    // Create a temporary link and trigger download
    const link = document.createElement('a');
    const date = new Date().toISOString().slice(0, 10);
    link.setAttribute('href', url);
    link.setAttribute('download', `laporan_peminjaman_${date}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Data berhasil diekspor');
}

function previousPage() {
    // This would typically involve server-side pagination
    showToast('Navigasi ke halaman sebelumnya');
}

function nextPage() {
    // This would typically involve server-side pagination
    showToast('Navigasi ke halaman berikutnya');
}

function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    
    // Style the toast
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.backgroundColor = 'var(--text)';
    toast.style.color = 'white';
    toast.style.padding = '12px 24px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = 'var(--shadow-lg)';
    toast.style.zIndex = '1000';
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s ease';
    
    // Add to DOM
    document.body.appendChild(toast);
    
    // Fade in
    setTimeout(() => {
        toast.style.opacity = '1';
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
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
</script>
@endsection