@extends('layouts.peminjam')

@section('title', 'Jadwal Booking Ruangan')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-calendar-check"></i>
                Jadwal Booking Disetujui
            </h1>
            <p class="page-subtitle">Lihat semua jadwal peminjaman ruangan yang telah disetujui</p>
        </div>
        <div class="header-actions">
            <div class="current-date-card">
                <div class="date-day">{{ now()->format('d') }}</div>
                <div class="date-details">
                    <div class="date-month">{{ now()->locale('id')->monthName }}</div>
                    <div class="date-year">{{ now()->format('Y') }}</div>
                </div>
            </div>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Ajukan Peminjaman</span>
            </a>
        </div>
    </div>

    @php
        $approvedBookings = $bookings->where('status', 'approved');
    @endphp

    @if($approvedBookings->isEmpty())
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-illustration">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3 class="empty-title">Belum Ada Jadwal Disetujui</h3>
        <p class="empty-description">Belum ada jadwal peminjaman ruangan yang disetujui</p>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Ajukan Peminjaman
        </a>
    </div>
    @else
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $approvedBookings->count() }}</div>
                <div class="stat-label">Total Disetujui</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="stat-card today">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $approvedBookings->where('tanggal', today()->format('Y-m-d'))->count() }}</div>
                <div class="stat-label">Hari Ini</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="stat-card this-week">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $approvedBookings->whereBetween('tanggal', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])->count() }}</div>
                <div class="stat-label">Minggu Ini</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="stat-card this-month">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $approvedBookings->whereBetween('tanggal', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])->count() }}</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>

    <!-- Booking List -->
    <div class="booking-container">
        <div class="booking-header">
            <h2 class="booking-title">
                <i class="fas fa-list"></i>
                Jadwal booking
            </h2>
            <div class="booking-filters">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari ruangan atau peminjam..." id="searchInput">
                </div>
                <div class="filter-dropdown">
                    <button class="filter-btn" id="filterBtn">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <div class="filter-menu" id="filterMenu">
                        <a href="#" class="filter-item active" data-filter="all">Semua</a>
                        <a href="#" class="filter-item" data-filter="today">Hari Ini</a>
                        <a href="#" class="filter-item" data-filter="week">Minggu Ini</a>
                        <a href="#" class="filter-item" data-filter="month">Bulan Ini</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="booking-list">
            @foreach($approvedBookings as $booking)
            <div class="booking-item" data-date="{{ $booking->tanggal }}">
                <div class="booking-room">
                    <div class="room-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="room-details">
                        <h4>{{ $booking->room->nama_room ?? 'Ruangan' }}</h4>
                        <p>{{ $booking->room->lokasi ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="booking-datetime">
                    <div class="datetime-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="datetime-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</span>
                    </div>
                </div>
                
                <div class="booking-status">
                    <span class="status-badge approved">
                        <i class="fas fa-check-circle"></i>
                        Disetujui
                    </span>
                </div>
                
                <div class="booking-user">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h5>{{ $booking->user->name ?? '-' }}</h5>
                        <p>{{ $booking->user->email ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    /* CSS Variables */
    :root {
        --primary-color: #6a5a41;
        --secondary-color: #e2ceb1;
        --accent-color: #8d7b68;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --card-bg: #ffffff;
        --text-color: #333333;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        --transition: all 0.3s ease;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 16px;
        color: white;
        box-shadow: var(--shadow);
    }

    .header-content {
        flex: 1;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .current-date-card {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .date-day {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-right: 1rem;
    }

    .date-month {
        font-weight: 600;
        font-size: 1rem;
    }

    .date-year {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1rem;
    }

    .btn-primary {
        background: white;
        color: var(--primary-color);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 5rem 2rem;
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .empty-illustration {
        font-size: 5rem;
        color: var(--secondary-color);
        margin-bottom: 2rem;
        opacity: 0.7;
    }

    .empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .empty-description {
        font-size: 1.1rem;
        color: var(--text-muted);
        margin-bottom: 2rem;
        max-width: 500px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
    }

    .stat-card.total::before { background: linear-gradient(to bottom, #667eea, #764ba2); }
    .stat-card.today::before { background: linear-gradient(to bottom, #4facfe, #00f2fe); }
    .stat-card.this-week::before { background: linear-gradient(to bottom, #ff9a9e, #fecfef); }
    .stat-card.this-month::before { background: linear-gradient(to bottom, #a8edea, #fed6e3); }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1.5rem;
    }

    .stat-card.total .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-card.today .stat-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .stat-card.this-week .stat-icon { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
    .stat-card.this-month .stat-icon { background: linear-gradient(135deg, #a8edea, #fed6e3); }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .stat-trend {
        font-size: 1.2rem;
        color: var(--success-color);
    }

    /* Booking Container */
    .booking-container {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        border-bottom: 1px solid var(--border-color);
    }

    .booking-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .booking-filters {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
    }

    .search-box input {
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.9rem;
        width: 250px;
        transition: var(--transition);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(226, 206, 177, 0.2);
    }

    .filter-dropdown {
        position: relative;
    }

    .filter-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-btn:hover {
        background: var(--light-color);
    }

    .filter-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: var(--shadow);
        min-width: 150px;
        z-index: 10;
        display: none;
        margin-top: 0.5rem;
    }

    .filter-menu.show {
        display: block;
    }

    .filter-item {
        display: block;
        padding: 0.75rem 1rem;
        color: var(--text-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .filter-item:hover, .filter-item.active {
        background: var(--light-color);
    }

    .filter-item.active {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Booking List */
    .booking-list {
        padding: 1.5rem;
    }

    .booking-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: var(--light-color);
        border-radius: 12px;
        transition: var(--transition);
    }

    .booking-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .booking-item:last-child {
        margin-bottom: 0;
    }

    .booking-room {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .room-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 1rem;
    }

    .room-details h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0 0 0.25rem 0;
    }

    .room-details p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .booking-datetime {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .datetime-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-color);
    }

    .datetime-item i {
        color: var(--secondary-color);
    }

    .booking-status {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }

    .booking-user {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--secondary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
    }

    .user-details h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0 0 0.25rem 0;
    }

    .user-details p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .booking-item {
            flex-wrap: wrap;
        }
        
        .booking-room, .booking-datetime, .booking-status, .booking-user {
            flex: 1 1 50%;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .header-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .search-box input {
            width: 200px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .booking-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .booking-room, .booking-datetime, .booking-status, .booking-user {
            flex: 1 1 100%;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .booking-filters {
            flex-direction: column;
            width: 100%;
        }
        
        .search-box {
            width: 100%;
        }
        
        .search-box input {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterBtn = document.getElementById('filterBtn');
        const filterMenu = document.getElementById('filterMenu');
        const filterItems = document.querySelectorAll('.filter-item');
        const bookingItems = document.querySelectorAll('.booking-item');
        
        // Toggle filter menu
        filterBtn.addEventListener('click', function() {
            filterMenu.classList.toggle('show');
        });
        
        // Close filter menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.remove('show');
            }
        });
        
        // Filter bookings
        filterItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.getAttribute('data-filter');
                
                filterItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                const today = new Date().toISOString().split('T')[0];
                const weekStart = new Date();
                weekStart.setDate(weekStart.getDate() - weekStart.getDay());
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekEnd.getDate() + 6);
                const monthStart = new Date();
                monthStart.setDate(1);
                const monthEnd = new Date(monthStart.getFullYear(), monthStart.getMonth() + 1, 0);
                
                bookingItems.forEach(booking => {
                    const bookingDate = booking.getAttribute('data-date');
                    let showItem = false;
                    
                    if (filter === 'all') {
                        showItem = true;
                    } else if (filter === 'today') {
                        showItem = bookingDate === today;
                    } else if (filter === 'week') {
                        const date = new Date(bookingDate);
                        showItem = date >= weekStart && date <= weekEnd;
                    } else if (filter === 'month') {
                        const date = new Date(bookingDate);
                        showItem = date >= monthStart && date <= monthEnd;
                    }
                    
                    booking.style.display = showItem ? 'flex' : 'none';
                });
                
                filterMenu.classList.remove('show');
            });
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            bookingItems.forEach(booking => {
                const roomName = booking.querySelector('.room-details h4').textContent.toLowerCase();
                const userName = booking.querySelector('.user-details h5').textContent.toLowerCase();
                
                if (roomName.includes(searchTerm) || userName.includes(searchTerm)) {
                    booking.style.display = 'flex';  
                } else {
                    booking.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection