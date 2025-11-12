@extends('layouts.app')

@section('title', 'Manajemen Ruang')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Manajemen Ruang</h1>
            <p class="text-muted mb-0">Kelola semua ruangan yang tersedia</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Ruang
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari ruangan...">
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="row" id="roomsGrid">
        @forelse($rooms as $room)
        <div class="col-lg-4 col-md-6 mb-4 room-item" data-name="{{ $room->nama_room }}" data-status="{{ $room->status }}">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-2 {{ $room->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                            <i class="fas fa-door-open text-white"></i>
                        </div>
                        <h5 class="mb-0">{{ $room->nama_room }}</h5>
                    </div>
                    <span class="badge {{ $room->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $room->status }}
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        <span>{{ $room->lokasi }}</span>
                    </div>
                    
                    <p class="text-muted mb-3">{{ Str::limit($room->deskripsi, 100) }}</p>
                    
                    <div class="mb-3">
                        <i class="fas fa-users text-muted me-2"></i>
                        <span>Kapasitas: {{ $room->kapasitas }} orang</span>
                    </div>
                </div>
                
                <div class="card-footer bg-white">
                    <div class="d-flex gap-2">
                        <a href="{{ route('rooms.edit', $room->id_room) }}" class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('rooms.destroy', $room->id_room) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus ruangan ini?')">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-door-closed fa-4x text-muted"></i>
                </div>
                <h3>Belum ada ruangan</h3>
                <p class="text-muted mb-4">Mulai dengan menambahkan ruangan pertama Anda</p>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Ruangan
                </a>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- No Results Message -->
    <div id="noResults" class="text-center py-5 d-none">
        <div class="mb-4">
            <i class="fas fa-search fa-4x text-muted"></i>
        </div>
        <h3>Tidak ada hasil pencarian</h3>
        <p class="text-muted">Coba kata kunci lain atau periksa ejaan Anda</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const roomsGrid = document.getElementById('roomsGrid');
    const roomItems = document.querySelectorAll('.room-item');
    const noResults = document.getElementById('noResults');
    
    // Search input event listener
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        roomItems.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            
            if (name.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
            roomsGrid.classList.add('d-none');
        } else {
            noResults.classList.add('d-none');
            roomsGrid.classList.remove('d-none');
        }
    });
});
</script>
@endsection