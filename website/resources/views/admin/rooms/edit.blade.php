@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="form-header mb-4">
        <h3 class="page-title"><i class="fas fa-edit"></i> Edit Ruang</h3>
        <p class="page-subtitle">Perbarui informasi ruang {{ $room->nama_room }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-custom">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('rooms.update', $room->id_room) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-simple">
                            <label class="form-label">Nama Ruang</label>
                            <input type="text" name="nama_room" class="form-control-simple" 
                                   value="{{ old('nama_room', $room->nama_room) }}" 
                                   placeholder="Masukkan nama ruang" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-simple">
                            <label class="form-label">Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control-simple" 
                                   value="{{ old('kapasitas', $room->kapasitas) }}" 
                                   placeholder="Jumlah orang" required min="1">
                        </div>
                    </div>
                </div>

                <div class="form-group-simple">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control-simple" 
                           value="{{ old('lokasi', $room->lokasi) }}" 
                           placeholder="Lokasi ruang" required>
                </div>

                <div class="form-group-simple">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control-simple" rows="3"
                              placeholder="Deskripsi ruang (opsional)">{{ old('deskripsi', $room->deskripsi) }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary-simple">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary-simple">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text);
        opacity: 0.7;
        margin-bottom: 0;
    }

    .card-custom {
        background-color: var(--card-bg);
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        border: 1px solid rgba(156, 124, 94, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .card-body {
        padding: 2rem;
    }

    .form-group-simple {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 0.5rem;
        font-family: 'Montserrat', sans-serif;
    }

    .form-control-simple {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid rgba(156, 124, 94, 0.2);
        border-radius: 10px;
        background: var(--card-bg);
        color: var(--text);
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }

    .form-control-simple:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(156, 124, 94, 0.1);
    }

    .form-control-simple::placeholder {
        color: var(--text);
        opacity: 0.5;
    }

    textarea.form-control-simple {
        resize: vertical;
        min-height: 80px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(156, 124, 94, 0.1);
    }

    .btn-primary-simple {
        background: linear-gradient(135deg, var(--accent), var(--primary-dark));
        color: var(--text);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary-simple:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(156, 124, 94, 0.3);
        color: var(--text);
    }

    .btn-secondary-simple {
        background: transparent;
        color: var(--text);
        border: 2px solid rgba(156, 124, 94, 0.3);
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-secondary-simple:hover {
        background: rgba(156, 124, 94, 0.1);
        color: var(--text);
        transform: translateY(-2px);
    }

    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: rgba(220, 53, 69, 0.1);
        color: var(--text);
        border-left: 4px solid #dc3545;
        font-family: 'Montserrat', sans-serif;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-custom {
            margin: 0 1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-primary-simple,
        .btn-secondary-simple {
            width: 100%;
            justify-content: center;
        }
        
        .row {
            flex-direction: column;
        }
        
        .col-md-6 {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .form-header {
            text-align: left;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection