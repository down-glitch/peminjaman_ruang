@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Header Section -->
    <div class="page-header">
        <h1 class="page-title">Tambah Ruang Baru</h1>
        <p class="page-subtitle">Isi form berikut untuk menambahkan ruangan baru</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="alert-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="alert-content">
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err) 
                        <li>{{ $err }}</li> 
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Nama Ruang
                    </label>
                    <input type="text" name="nama_room" class="form-control" 
                           value="{{ old('nama_room') }}" required 
                           placeholder="Contoh: Ruang Rapat A, Laboratorium Komputer">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Lokasi
                    </label>
                    <input type="text" name="lokasi" class="form-control" 
                           value="{{ old('lokasi') }}" required 
                           placeholder="Contoh: Lantai 1, Gedung Utama">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        Kapasitas
                    </label>
                    <input type="number" name="kapasitas" class="form-control" 
                           value="{{ old('kapasitas') }}" required 
                           placeholder="Jumlah orang" min="1">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Status
                    </label>
                    <select name="status" class="form-control">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" class="form-control" rows="4"
                              placeholder="Deskripsi fasilitas dan spesifikasi ruangan (opsional)">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    </svg>
                    Simpan Ruangan
                </button>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali
                </a>
            </div>
        </form>
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
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: var(--coral-50);
        color: var(--coral-700);
        border-left: 3px solid var(--coral-500);
    }

    .alert-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--coral-100);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--coral-600);
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content strong {
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Card */
    .card {
        background: var(--card-bg);
        border-radius: 0.75rem;
        box-shadow: var(--shadow-md);
        padding: 2rem;
        border: 1px solid var(--border-primary);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-primary);
        border-radius: 0.5rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--warm-500);
        box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .form-control::placeholder {
        color: var(--text-quaternary);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-secondary);
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--gradient-warm);
        color: white;
        border-color: var(--warm-600);
        box-shadow: var(--shadow-glow);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl), var(--shadow-glow);
    }

    .btn-secondary {
        background: var(--glass-bg);
        color: var(--text-primary);
        border-color: var(--border-primary);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    /* Color Variants for Form Elements */
    .form-group:nth-child(1) .form-control:focus {
        border-color: var(--warm-500);
        box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .form-group:nth-child(2) .form-control:focus {
        border-color: var(--teal-500);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    .form-group:nth-child(3) .form-control:focus {
        border-color: var(--purple-500);
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
    }

    .form-group:nth-child(4) .form-control:focus {
        border-color: var(--amber-500);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }

    .form-group:nth-child(5) .form-control:focus {
        border-color: var(--sky-500);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection