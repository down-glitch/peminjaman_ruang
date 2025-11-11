@extends('layouts.app')

@section('title', 'Manajemen Ruang')

@section('content')
<div class="content-wrapper">
    <!-- Header Section -->
    <div class="page-header">
        <h1 class="page-title">Manajemen Ruang</h1>
        <p class="page-subtitle">Kelola semua ruangan yang tersedia</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="alert-content">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Action Bar -->
    <div class="action-bar">
        <div class="search-box">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari ruangan...">
            <div class="search-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </div>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Ruang Baru
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-filter="all"></button>
    </div>

    <!-- Rooms Grid -->
    <div class="rooms-grid" id="roomsGrid">
        @forelse($rooms as $room)
        <div class="room-card {{ $room->status == 'Tersedia' ? 'available' : 'unavailable' }}" data-name="{{ $room->nama_room }}" data-status="{{ $room->status }}">
            <div class="room-header">
                <div class="room-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <div class="room-status">
                    {{ $room->status }}
                </div>
            </div>
            
            <div class="room-content">
                <h3 class="room-name">{{ $room->nama_room }}</h3>
                <div class="room-location">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $room->lokasi }}
                </div>
                <p class="room-description">{{ $room->deskripsi }}</p>
                
                <div class="room-meta">
                    <div class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        <span>{{ $room->kapasitas }} orang</span>
                    </div>
                </div>
            </div>
            
            <div class="room-actions">
                <a href="{{ route('rooms.edit', $room->id_room) }}" class="btn btn-edit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('rooms.destroy', $room->id_room) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-delete" onclick="return confirm('Hapus ruangan ini?')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <h3>Belum ada ruangan</h3>
            <p>Mulai dengan menambahkan ruangan pertama Anda</p>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Ruangan
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Header Section */
    .page-header {
        margin-bottom: 2rem;
        position: relative;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-warm);
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        font-weight: 400;
    }

    /* Alert */
    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        border: none;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: var(--teal-50);
        color: var(--teal-700);
        border-left: 3px solid var(--teal-500);
    }

    .alert-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--teal-100);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teal-600);
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    /* Action Bar */
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-primary);
        padding-bottom: 0.5rem;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem 0.5rem 0 0;
        background: transparent;
        border: none;
        color: var(--text-secondary);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .filter-tab::after {
        content: '';
        position: absolute;
        bottom: -0.5rem;
        left: 0;
        right: 0;
        height: 2px;
        background: transparent;
        transition: all 0.2s ease;
    }

    .filter-tab.active {
        color: var(--text-primary);
    }

    .filter-tab.active::after {
        background: var(--gradient-warm);
    }

    .filter-tab:hover {
        color: var(--text-primary);
    }

    /* Rooms Grid */
    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Room Card */
    .room-card {
        background: var(--card-bg);
        border-radius: 0.75rem;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border-primary);
        position: relative;
    }

    .room-card::before {
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

    .room-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .room-card:hover::before {
        opacity: 1;
    }

    /* Room Card Variants */
    .room-card.available::before {
        background: var(--gradient-teal);
    }

    .room-card.unavailable::before {
        background: var(--gradient-coral);
    }

    .room-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.25rem 0.75rem;
    }

    .room-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        background: var(--gradient-warm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .room-card.available .room-icon {
        background: var(--gradient-teal);
    }

    .room-card.unavailable .room-icon {
        background: var(--gradient-coral);
    }

    .room-status {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .room-card.available .room-status {
        background: var(--teal-50);
        color: var(--teal-700);
    }

    .room-card.unavailable .room-status {
        background: var(--coral-50);
        color: var(--coral-700);
    }

    .room-content {
        padding: 0 1.25rem 0.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .room-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .room-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
    }

    .room-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .room-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .room-actions {
        display: flex;
        padding: 0.75rem 1.25rem 1.25rem;
        gap: 0.5rem;
        border-top: 1px solid var(--border-secondary);
    }

    .room-actions .btn {
        padding: 0.5rem;
        border-radius: 0.5rem;
        justify-content: center;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit {
        background: var(--gradient-amber);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-delete {
        background: var(--gradient-coral);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-primary);
        background: var(--card-bg);
        border-radius: 0.75rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-primary);
    }

    .empty-icon {
        margin: 0 auto 1.5rem;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--gradient-warm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    /* No Results Message */
    .no-results {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
        display: none;
        background: var(--card-bg);
        border-radius: 0.75rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-primary);
        margin-bottom: 1.5rem;
    }

    .no-results.show {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .rooms-grid {
            grid-template-columns: 1fr;
        }

        .room-actions {
            flex-direction: column;
        }

        .room-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const roomsGrid = document.getElementById('roomsGrid');
    const roomCards = document.querySelectorAll('.room-card');
    
    // Create no results element
    const noResults = document.createElement('div');
    noResults.className = 'no-results';
    noResults.innerHTML = `
        <div class="empty-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
        </div>
        <h3>Tidak ada hasil pencarian</h3>
        <p>Coba kata kunci lain atau periksa ejaan Anda</p>
    `;
    
    // Add no results element to the grid
    roomsGrid.appendChild(noResults);
    
    // Initially hide no results
    noResults.style.display = 'none';

    // Filter tabs functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            filterRooms(filter);
        });
    });

    // Search input event listener
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-tab.active').getAttribute('data-filter');
        
        filterRooms(activeFilter, searchTerm);
    });

    function filterRooms(filter, searchTerm = '') {
        let visibleCount = 0;
        
        roomCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const status = card.getAttribute('data-status');
            const matchesSearch = name.includes(searchTerm);
            const matchesFilter = filter === 'all' || 
                               (filter === 'available' && status === 'Tersedia') || 
                               (filter === 'unavailable' && status === 'Tidak Tersedia');
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }
    
    // Initialize with "all" filter
    filterRooms('all');
});
</script>
@endsection