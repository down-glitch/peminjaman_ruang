@extends('layouts.peminjam')

@section('title', 'Form Pengajuan | Dashboard Peminjam')

@section('content')
<div class="content-wrapper">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-handshake"></i>
                Ajukan Peminjaman Ruangan
            </h1>
            <p class="page-subtitle">Isi formulir berikut untuk mengajukan peminjaman ruangan</p>
        </div>
    </div>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert-message error fade-in">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <h6 class="alert-title">Perhatian</h6>
                <div class="alert-message-list">
                    @foreach ($errors->all() as $error)
                        <div class="error-item">
                            @if (str_contains($error, 'Jam selesai'))
                                <i class="fas fa-clock"></i>
                                <span>Jadwal bentrok dengan peminjaman lain</span>
                            @else
                                <i class="fas fa-info-circle"></i>
                                <span>{{ $error }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- Main Form --}}
    <div class="form-container">
        <div class="form-progress">
            <div class="progress-step active" data-step="1">
                <div class="step-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="step-title">Pilih Ruangan</div>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="2">
                <div class="step-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="step-title">Tanggal & Waktu</div>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="3">
                <div class="step-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="step-title">Keterangan</div>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step" data-step="4">
                <div class="step-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="step-title">Selesai</div>
            </div>
        </div>

        <div class="form-card">
            <form action="{{ route('peminjaman.store') }}" method="POST" class="form-enhanced" id="bookingForm">
                @csrf
                
                <!-- Step 1: Ruangan -->
                <div class="form-step active" data-step="1">
                    <div class="step-header">
                        <h3><i class="fas fa-door-open"></i> Pilih Ruangan</h3>
                        <p>Pilih ruangan yang ingin Anda pinjam</p>
                    </div>
                    
                    <div class="room-selection">
                        @foreach($rooms as $room)
                            <div class="room-card {{ old('id_room') == $room->id_room ? 'selected' : '' }}" data-room-id="{{ $room->id_room }}">
                                <div class="room-image">
                                    <i class="fas fa-door-closed"></i>
                                </div>
                                <div class="room-info">
                                    <h4>{{ $room->nama_room }}</h4>
                                    <p><i class="fas fa-map-marker-alt"></i> {{ $room->lokasi }}</p>
                                    <div class="room-details">
                                        <span class="capacity"><i class="fas fa-users"></i> Kapasitas: {{ $room->kapasitas ?? '-' }} orang</span>
                                    </div>
                                </div>
                                <div class="room-select">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <input type="hidden" name="id_room" id="selectedRoom" value="{{ old('id_room') }}">
                </div>

                <!-- Step 2: Tanggal & Waktu -->
                <div class="form-step" data-step="2">
                    <div class="step-header">
                        <h3><i class="fas fa-calendar"></i> Tanggal & Waktu</h3>
                        <p>Pilih tanggal dan waktu peminjaman</p>
                    </div>
                    
                    <div class="datetime-container">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-day"></i>
                                Tanggal Peminjaman
                            </label>
                            <div class="input-with-icon">
                                <input type="date" name="tanggal" class="form-input" value="{{ old('tanggal') }}" required id="bookingDate">
                                <i class="input-icon fas fa-calendar"></i>
                            </div>
                            <div class="form-hint">Pilih tanggal ketika Anda akan menggunakan ruangan</div>
                        </div>

                        <div class="time-slots">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock"></i>
                                    Jam Mulai
                                </label>
                                <div class="input-with-icon">
                                    <input type="time" name="jam_mulai" class="form-input" value="{{ old('jam_mulai') }}" required id="startTime">
                                    <i class="input-icon fas fa-clock"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock"></i>
                                    Jam Selesai
                                </label>
                                <div class="input-with-icon">
                                    <input type="time" name="jam_selesai" class="form-input" value="{{ old('jam_selesai') }}" required id="endTime">
                                    <i class="input-icon fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="duration-display" id="durationDisplay" style="display: none;">
                            <div class="duration-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="duration-content">
                                <div class="duration-label">Durasi Peminjaman</div>
                                <div class="duration-value" id="durationText">0 jam 0 menit</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Keterangan -->
                <div class="form-step" data-step="3">
                    <div class="step-header">
                        <h3><i class="fas fa-edit"></i> Keterangan Kegiatan</h3>
                        <p>Jelaskan tujuan peminjaman ruangan</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Keterangan
                        </label>
                        <div class="textarea-container">
                            <textarea name="keterangan" class="form-input textarea" rows="4" placeholder="Jelaskan tujuan peminjaman ruangan..." id="keterangan">{{ old('keterangan') }}</textarea>
                            <div class="char-counter">
                                <span id="charCount">0</span>/500 karakter
                            </div>
                        </div>
                        <div class="form-hint">
                            <i class="fas fa-lightbulb"></i>
                            Contoh: Meeting tim, Presentasi, Workshop, dll.
                        </div>
                    </div>
                    
                    <div class="activity-type">
                        <label class="form-label">
                            <i class="fas fa-tags"></i>
                            Jenis Kegiatan (Opsional)
                        </label>
                        <div class="activity-options">
                            <div class="activity-option">
                                <input type="radio" name="jenis_kegiatan" id="meeting" value="meeting">
                                <label for="meeting" class="option-label">
                                    <i class="fas fa-users"></i>
                                    Meeting
                                </label>
                            </div>
                            <div class="activity-option">
                                <input type="radio" name="jenis_kegiatan" id="presentasi" value="presentasi">
                                <label for="presentasi" class="option-label">
                                    <i class="fas fa-presentation"></i>
                                    Presentasi
                                </label>
                            </div>
                            <div class="activity-option">
                                <input type="radio" name="jenis_kegiatan" id="workshop" value="workshop">
                                <label for="workshop" class="option-label">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    Workshop
                                </label>
                            </div>
                            <div class="activity-option">
                                <input type="radio" name="jenis_kegiatan" id="lainnya" value="lainnya">
                                <label for="lainnya" class="option-label">
                                    <i class="fas fa-ellipsis-h"></i>
                                    Lainnya
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Konfirmasi -->
                <div class="form-step" data-step="4">
                    <div class="step-header">
                        <h3><i class="fas fa-check-circle"></i> Konfirmasi Pengajuan</h3>
                        <p>Periksa kembali detail peminjaman Anda</p>
                    </div>
                    
                    <div class="confirmation-summary">
                        <div class="summary-header">
                            <div class="summary-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h4>Ringkasan Peminjaman</h4>
                        </div>
                        <div class="summary-content">
                            <div class="summary-item">
                                <div class="summary-label">
                                    <i class="fas fa-door-open"></i>
                                    Ruangan
                                </div>
                                <div class="summary-value" id="summaryRoom">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">
                                    <i class="fas fa-calendar"></i>
                                    Tanggal
                                </div>
                                <div class="summary-value" id="summaryDate">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">
                                    <i class="fas fa-clock"></i>
                                    Waktu
                                </div>
                                <div class="summary-value" id="summaryTime">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">
                                    <i class="fas fa-hourglass-half"></i>
                                    Durasi
                                </div>
                                <div class="summary-value" id="summaryDuration">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">
                                    <i class="fas fa-file-alt"></i>
                                    Keterangan
                                </div>
                                <div class="summary-value" id="summaryKeterangan">-</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="confirmation-note">
                        <i class="fas fa-info-circle"></i>
                        <p>Dengan mengajukan peminjaman, Anda setuju dengan peraturan dan ketentuan yang berlaku. Pengajuan Anda akan diproses oleh admin dalam waktu 1x24 jam.</p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="form-navigation">
                    <button type="button" class="btn btn-outline" id="prevBtn" style="display: none;">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn">
                        Lanjutkan
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                        <i class="fas fa-paper-plane"></i>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* CSS Variables dengan tema hangat yang diperbaiki */
    :root {
        /* Warm Color Palette - Dipertahankan */
        --warm-50: #FFFBF5;
        --warm-100: #FEF7ED;
        --warm-200: #FDF2E0;
        --warm-300: #FCE8C8;
        --warm-400: #F8D4A1;
        --warm-500: #E2B88A;
        --warm-600: #C19660;
        --warm-700: #A67C52;
        --warm-800: #7A5C3C;
        --warm-900: #4E3A28;
        
        /* Complementary Colors */
        --teal-500: #10B981;
        --purple-500: #A855F7;
        --coral-500: #F43F5E;
        --amber-500: #F59E0B;
        
        /* Theme Variables - Dipertahankan */
        --bg-primary: #FFFBF5;
        --bg-secondary: #FFFFFF;
        --bg-tertiary: #F8F5F0;
        --text-primary: #2D2416;
        --text-secondary: #5A4A36;
        --text-tertiary: #8B7A65;
        --text-quaternary: #BDB4A5;
        --border-primary: #E8E1D3;
        --border-secondary: #F2E9DD;
        
        /* Enhanced Gradients */
        --gradient-warm: linear-gradient(135deg, #F8D4A1 0%, #C19660 50%, #A67C52 100%);
        --gradient-warm-light: linear-gradient(135deg, #FCE8C8 0%, #E2B88A 100%);
        --gradient-warm-subtle: linear-gradient(135deg, rgba(248, 212, 161, 0.1) 0%, rgba(193, 150, 96, 0.1) 100%);
        
        /* Enhanced Shadow System */
        --shadow-sm: 0 2px 4px rgba(45, 36, 22, 0.05);
        --shadow-md: 0 4px 8px rgba(45, 36, 22, 0.08);
        --shadow-lg: 0 8px 16px rgba(45, 36, 22, 0.12);
        --shadow-xl: 0 16px 32px rgba(45, 36, 22, 0.16);
        --shadow-glow: 0 0 20px rgba(248, 212, 161, 0.25);
        
        /* Glass Effect - Lebih Subtle */
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(232, 225, 211, 0.4);
    }
    
    :root[data-theme="dark"] {
        --bg-primary: #1A1814;
        --bg-secondary: #221F1A;
        --bg-tertiary: #2A2620;
        --text-primary: #F5E6D3;
        --text-secondary: #D4C4B0;
        --text-tertiary: #A89986;
        --text-quaternary: #7C6E5C;
        --border-primary: #3A342C;
        --border-secondary: #302A24;
        --glass-bg: rgba(34, 31, 26, 0.85);
        --glass-border: rgba(58, 52, 44, 0.4);
    }

    /* Global Styles */
    body {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 0;
    }

    /* Form Container */
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Progress Steps - Enhanced */
    .form-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        position: relative;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        width: 80px;
        transition: all 0.3s ease;
    }

    .step-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--glass-bg);
        border: 2px solid var(--glass-border);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        color: var(--text-tertiary);
        font-size: 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .progress-step.active .step-icon {
        background: var(--gradient-warm);
        border-color: var(--warm-500);
        color: white;
        box-shadow: var(--shadow-glow);
        transform: scale(1.05);
    }

    .progress-step.completed .step-icon {
        background: var(--gradient-warm);
        border-color: var(--warm-500);
        color: white;
    }

    .step-title {
        font-size: 0.75rem;
        color: var(--text-tertiary);
        text-align: center;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .progress-step.active .step-title {
        color: var(--text-primary);
        font-weight: 600;
    }

    .progress-step.completed .step-title {
        color: var(--text-primary);
    }

    .progress-line {
        flex: 1;
        height: 3px;
        background: var(--border-primary);
        margin-top: 30px;
        position: relative;
        z-index: 1;
    }

    .progress-step.completed ~ .progress-line {
        background: var(--gradient-warm);
    }

    /* Form Card - Simplified but Professional */
    .form-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Form Steps */
    .form-step {
        display: none;
        padding: 2.5rem;
        animation: fadeIn 0.5s ease;
    }

    .form-step.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .step-header h3 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .step-header p {
        color: var(--text-secondary);
        margin: 0;
        font-size: 1rem;
    }

    /* Room Selection - Enhanced */
    .room-selection {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .room-card {
        background: var(--glass-bg);
        border: 2px solid var(--glass-border);
        border-radius: 1.25rem;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
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
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: var(--warm-300);
    }

    .room-card:hover::before {
        opacity: 0.7;
    }

    .room-card.selected {
        border-color: var(--warm-500);
        background: var(--gradient-warm-subtle);
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }

    .room-card.selected::before {
        opacity: 1;
    }

    .room-card.selected .room-select {
        opacity: 1;
    }

    .room-image {
        width: 70px;
        height: 70px;
        background: var(--gradient-warm);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        color: white;
        font-size: 1.75rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .room-card:hover .room-image {
        transform: scale(1.05);
    }

    .room-info h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .room-info p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .room-details {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-tertiary);
    }

    .room-select {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 36px;
        height: 36px;
        background: var(--gradient-warm);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    /* Date & Time */
    .datetime-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .time-slots {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .duration-display {
        background: var(--gradient-warm-subtle);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid var(--border-primary);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .duration-display:hover {
        box-shadow: var(--shadow-md);
    }

    .duration-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-warm);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        box-shadow: var(--shadow-md);
    }

    .duration-label {
        font-size: 0.85rem;
        color: var(--text-tertiary);
        margin-bottom: 0.25rem;
    }

    .duration-value {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Form Elements - Simplified */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-primary);
        border-radius: 0.75rem;
        background: var(--glass-bg);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--warm-500);
        box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .textarea {
        resize: vertical;
        min-height: 120px;
        padding-right: 80px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-tertiary);
        pointer-events: none;
    }

    .char-counter {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        font-size: 0.8rem;
        color: var(--text-tertiary);
        background: var(--glass-bg);
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
    }

    .form-hint {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        font-size: 0.85rem;
        color: var(--text-tertiary);
    }

    /* Activity Type */
    .activity-type {
        margin-top: 2rem;
    }

    .activity-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .activity-option {
        position: relative;
    }

    .activity-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .option-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.25rem 0.75rem;
        background: var(--glass-bg);
        border: 2px solid var(--border-primary);
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .option-label i {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .activity-option input[type="radio"]:checked + .option-label {
        background: var(--gradient-warm-subtle);
        border-color: var(--warm-500);
        color: var(--warm-700);
        box-shadow: var(--shadow-md);
    }

    .option-label:hover {
        border-color: var(--warm-300);
        transform: translateY(-3px);
    }

    /* Confirmation */
    .confirmation-summary {
        background: var(--gradient-warm-subtle);
        border-radius: 1.25rem;
        padding: 0;
        margin-bottom: 2rem;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-primary);
    }

    .summary-header {
        background: var(--gradient-warm);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .summary-header h4 {
        color: white;
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .summary-content {
        padding: 1.5rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-primary);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .summary-value {
        color: var(--text-secondary);
        font-weight: 500;
        text-align: right;
        max-width: 60%;
    }

    .confirmation-note {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1.5rem;
        background: var(--gradient-warm-subtle);
        border-radius: 1rem;
        border-left: 4px solid var(--warm-500);
    }

    .confirmation-note i {
        color: var(--warm-600);
        margin-top: 0.2rem;
        font-size: 1.25rem;
    }

    .confirmation-note p {
        margin: 0;
        color: var(--text-primary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Alert */
    .alert-message {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        position: relative;
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-message.error {
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.2);
        color: var(--coral-700);
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-warm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        color: var(--coral-700);
        margin: 0 0 0.75rem 0;
        font-size: 1.1rem;
    }

    .error-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        color: var(--coral-700);
    }

    .alert-close {
        background: none;
        border: none;
        color: var(--coral-500);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .alert-close:hover {
        background: rgba(0, 0, 0, 0.1);
        color: var(--coral-700);
    }

    /* Navigation Buttons */
    .form-navigation {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem 2.5rem;
        background: var(--gradient-warm-subtle);
        border-top: 1px solid var(--border-primary);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        font-size: 0.95rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border-color: var(--border-primary);
    }

    .btn-outline:hover {
        background: var(--glass-bg);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary {
        background: var(--gradient-warm);
        color: white;
        border: none;
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-progress {
            margin-bottom: 1.5rem;
        }
        
        .progress-step {
            width: 60px;
        }
        
        .step-icon {
            width: 50px;
            height: 50px;
            font-size: 1rem;
        }
        
        .step-title {
            font-size: 0.65rem;
        }
        
        .form-step {
            padding: 1.5rem 1rem;
        }
        
        .room-selection {
            grid-template-columns: 1fr;
        }
        
        .time-slots {
            grid-template-columns: 1fr;
        }
        
        .activity-options {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .form-navigation {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.75rem;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .step-header h3 {
            font-size: 1.25rem;
        }
        
        .activity-options {
            grid-template-columns: 1fr;
        }
        
        .summary-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .summary-value {
            text-align: left;
            max-width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form Step Navigation
        const formSteps = document.querySelectorAll('.form-step');
        const progressSteps = document.querySelectorAll('.progress-step');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 1;
        
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.querySelector('input[type="date"]');
        if (dateInput) {
            dateInput.min = today;
        }
        
        // Room Selection
        const roomCards = document.querySelectorAll('.room-card');
        const selectedRoomInput = document.getElementById('selectedRoom');
        
        roomCards.forEach(card => {
            card.addEventListener('click', function() {
                roomCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedRoomInput.value = this.dataset.roomId;
            });
        });
        
        // Time Duration Calculation
        const startTimeInput = document.getElementById('startTime');
        const endTimeInput = document.getElementById('endTime');
        const durationDisplay = document.getElementById('durationDisplay');
        const durationText = document.getElementById('durationText');
        
        function calculateDuration() {
            if (startTimeInput.value && endTimeInput.value) {
                const start = new Date(`2000-01-01T${startTimeInput.value}`);
                const end = new Date(`2000-01-01T${endTimeInput.value}`);
                
                if (end > start) {
                    const diff = end - start;
                    const hours = Math.floor(diff / 3600000);
                    const minutes = Math.floor((diff % 3600000) / 60000);
                    
                    durationText.textContent = `${hours} jam ${minutes > 0 ? minutes + ' menit' : ''}`;
                    durationDisplay.style.display = 'flex';
                } else {
                    durationDisplay.style.display = 'none';
                }
            } else {
                durationDisplay.style.display = 'none';
            }
        }
        
        // Add event listeners for date and time inputs
        dateInput.addEventListener('change', function() {
            calculateDuration();
        });
        
        startTimeInput.addEventListener('change', calculateDuration);
        endTimeInput.addEventListener('change', calculateDuration);
        
        // Character Counter
        const keteranganTextarea = document.getElementById('keterangan');
        const charCount = document.getElementById('charCount');
        
        keteranganTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                this.value = this.value.substring(0, 500);
                charCount.textContent = 500;
            }
        });
        
        // Update Summary
        function updateSummary() {
            const selectedRoom = document.querySelector('.room-card.selected');
            const summaryRoom = document.getElementById('summaryRoom');
            const summaryDate = document.getElementById('summaryDate');
            const summaryTime = document.getElementById('summaryTime');
            const summaryDuration = document.getElementById('summaryDuration');
            const summaryKeterangan = document.getElementById('summaryKeterangan');
            
            if (selectedRoom) {
                summaryRoom.textContent = selectedRoom.querySelector('h4').textContent;
            }
            
            if (dateInput.value) {
                const date = new Date(dateInput.value);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                summaryDate.textContent = date.toLocaleDateString('id-ID', options);
            }
            
            if (startTimeInput.value && endTimeInput.value) {
                summaryTime.textContent = `${startTimeInput.value} - ${endTimeInput.value}`;
                
                // Calculate duration for summary
                const start = new Date(`2000-01-01T${startTimeInput.value}`);
                const end = new Date(`2000-01-01T${endTimeInput.value}`);
                
                if (end > start) {
                    const diff = end - start;
                    const hours = Math.floor(diff / 3600000);
                    const minutes = Math.floor((diff % 3600000) / 60000);
                    
                    summaryDuration.textContent = `${hours} jam ${minutes > 0 ? minutes + ' menit' : ''}`;
                }
            }
            
            if (keteranganTextarea.value) {
                summaryKeterangan.textContent = keteranganTextarea.value;
            }
        }
        
        // Step Navigation
        function showStep(step) {
            formSteps.forEach(formStep => {
                formStep.classList.remove('active');
                if (parseInt(formStep.dataset.step) === step) {
                    formStep.classList.add('active');
                }
            });
            
            progressSteps.forEach(progressStep => {
                progressStep.classList.remove('active', 'completed');
                const stepNum = parseInt(progressStep.dataset.step);
                
                if (stepNum === step) {
                    progressStep.classList.add('active');
                } else if (stepNum < step) {
                    progressStep.classList.add('completed');
                }
            });
            
            // Update navigation buttons
            prevBtn.style.display = step === 1 ? 'none' : 'flex';
            nextBtn.style.display = step === 4 ? 'none' : 'flex';
            submitBtn.style.display = step === 4 ? 'flex' : 'none';
            
            // Update summary when reaching confirmation step
            if (step === 4) {
                updateSummary();
            }
        }
        
        nextBtn.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });
        
        prevBtn.addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });
        
        function validateStep(step) {
            let isValid = true;
            
            if (step === 1) {
                if (!selectedRoomInput.value) {
                    isValid = false;
                    showNotification('Silakan pilih ruangan terlebih dahulu', 'error');
                }
            } else if (step === 2) {
                if (!dateInput.value || !startTimeInput.value || !endTimeInput.value) {
                    isValid = false;
                    showNotification('Silakan lengkapi tanggal dan waktu peminjaman', 'error');
                } else if (startTimeInput.value >= endTimeInput.value) {
                    isValid = false;
                    showNotification('Jam selesai harus lebih besar dari jam mulai', 'error');
                }
            }
            
            return isValid;
        }
        
        // Form submission
        const form = document.getElementById('bookingForm');
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengajukan...';
        });
        
        // Alert close functionality
        const alertCloseButtons = document.querySelectorAll('.alert-close');
        
        alertCloseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alertMessage = this.closest('.alert-message');
                alertMessage.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    alertMessage.remove();
                }, 300);
            });
        });
        
        // Auto-hide error messages after 10 seconds
        const errorAlerts = document.querySelectorAll('.alert-message.error');
        errorAlerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 10000);
        });
        
        // Show notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert-message ${type} fade-in`;
            notification.innerHTML = `
                <div class="alert-icon">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}"></i>
                </div>
                <div class="alert-content">
                    <div class="error-item">
                        <i class="fas fa-${type === 'error' ? 'times-circle' : 'check-circle'}"></i>
                        <span>${message}</span>
                    </div>
                </div>
                <button type="button" class="alert-close">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.querySelector('.form-container').prepend(notification);
            
            // Add close functionality
            const closeBtn = notification.querySelector('.alert-close');
            closeBtn.addEventListener('click', function() {
                notification.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    notification.remove();
                }, 300);
            });
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease-out forwards';
                
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }
        
        // Add slide up animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection