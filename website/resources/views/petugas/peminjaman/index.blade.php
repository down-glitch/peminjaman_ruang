@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">
            <i class="fas fa-calendar-alt"></i>
            Daftar Peminjaman Ruangan
        </h3>
        <div class="badge-simple">
            <i class="fas fa-list"></i>
            {{ count($bookings) }} Peminjaman
        </div>
    </div>

    @if(session('success'))
        <div class="alert-simple success mb-4">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card-simple">
        <div class="table-container">
            <table class="table-simple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span>{{ $booking->user->username ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ $booking->room->nama_room ?? '-' }}</td>
                        <td>
                            <div class="date-info">
                                <div>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</div>
                                <small>{{ \Carbon\Carbon::parse($booking->tanggal)->locale('id')->dayName }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="time-info">
                                <div>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</div>
                                <small>{{ \Carbon\Carbon::parse($booking->jam_mulai)->diffInHours(\Carbon\Carbon::parse($booking->jam_selesai)) }} jam</small>
                            </div>
                        </td>
                        <td>
                            @if($booking->status === 'pending')
                                <span class="status-badge pending">
                                    <i class="fas fa-clock"></i>
                                    Menunggu
                                </span>
                            @elseif($booking->status === 'approved')
                                <span class="status-badge approved">
                                    <i class="fas fa-check"></i>
                                    Disetujui
                                </span>
                            @else
                                <span class="status-badge rejected">
                                    <i class="fas fa-times"></i>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($booking->status === 'pending')
                                <div class="action-buttons">
                                    <form action="{{ route('peminjaman.approve', $booking->id ?? $booking->id_booking) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action approve">
                                            <i class="fas fa-check"></i>
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('peminjaman.reject', $booking->id ?? $booking->id_booking) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-action reject">
                                            <i class="fas fa-times"></i>
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="no-action">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <h5>Belum ada data peminjaman</h5>
                                <p>Semua permintaan peminjaman akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
        background: rgba(40, 167, 69, 0.1);
        color: var(--text);
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 4px solid #28a745;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .alert-simple.success {
        background: rgba(40, 167, 69, 0.1);
        border-left-color: #28a745;
    }

    .card-simple {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid rgba(156, 124, 94, 0.1);
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
    }

    .table-simple {
        width: 100%;
        background: var(--card-bg);
        border-collapse: collapse;
    }

    .table-simple thead {
        background: var(--sidebar-bg);
    }

    .table-simple th {
        padding: 16px 12px;
        text-align: left;
        font-weight: 600;
        color: var(--accent);
        border-bottom: 2px solid rgba(156, 124, 94, 0.1);
        font-family: 'Montserrat', sans-serif;
    }

    .table-simple td {
        padding: 16px 12px;
        border-bottom: 1px solid rgba(156, 124, 94, 0.1);
        vertical-align: middle;
    }

    .table-simple tbody tr:last-child td {
        border-bottom: none;
    }

    .table-simple tbody tr:hover {
        background: rgba(156, 124, 94, 0.05);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text);
        font-size: 0.8rem;
    }

    .date-info,
    .time-info {
        line-height: 1.4;
    }

    .date-info small,
    .time-info small {
        color: var(--accent);
        opacity: 0.7;
        font-size: 0.8rem;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-action.approve {
        background: #28a745;
        color: white;
    }

    .btn-action.reject {
        background: #dc3545;
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    .no-action {
        color: var(--accent);
        opacity: 0.6;
        font-style: italic;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--primary);
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--accent);
    }

    .empty-state p {
        opacity: 0.7;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .table-simple {
            font-size: 0.9rem;
        }

        .table-simple th,
        .table-simple td {
            padding: 12px 8px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
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

        .table-container {
            border-radius: 0;
            margin: 0 -1rem;
        }
    }
</style>
@endsection