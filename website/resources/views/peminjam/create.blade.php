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
        <div class="form-card">
            <!-- Remove type="submit" to prevent automatic submission -->
            <form action="{{ route('peminjaman.store') }}" method="POST" class="form-enhanced" id="bookingForm">
                @csrf
                
                <!-- Form Content -->
                <div class="form-content">
                    <div class="form-header">
                        <h2>Formulir Peminjaman Ruangan</h2>
                        <p>Lengkapi data berikut untuk mengajukan peminjaman ruangan</p>
                    </div>
                    
                    <!-- Room Selection -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-door-closed"></i>
                            Ruangan
                        </label>
                        <div class="select-wrapper">
                            <select name="id_room" class="form-select" id="selectedRoom" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id_room }}" {{ old('id_room') == $room->id_room ? 'selected' : '' }}>
                                        {{ $room->nama_room }} - {{ $room->lokasi }} (Kapasitas: {{ $room->kapasitas ?? '-' }} orang)
                                    </option>
                                @endforeach
                            </select>
                            <i class="select-icon fas fa-chevron-down"></i>
                        </div>
                    </div>

                    <!-- Date Selection -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-day"></i>
                            Tanggal Peminjaman
                        </label>
                        <div class="input-with-icon">
                            <input type="date" name="tanggal" class="form-input" value="{{ old('tanggal') }}" required id="bookingDate">
                            <i class="input-icon fas fa-calendar"></i>
                        </div>
                    </div>

                    <!-- Session Selection -->
                    <div class="session-selection">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-clock"></i>
                                Pilih Sesi
                            </label>
                            <div class="form-hint">Setiap sesi berdurasi 45 menit. Pilih sesi secara berurutan dari jam 07:00 hingga 15:15.</div>
                            <div class="session-grid" id="sessionGrid">
                                <!-- Sesi akan di-generate dengan JavaScript -->
                            </div>
                        </div>
                        
                        <div class="duration-display" id="durationDisplay" style="display: none;">
                            <div class="duration-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="duration-content">
                                <div class="duration-label">Durasi Total Peminjaman</div>
                                <div class="duration-value" id="durationText">0 sesi (0 jam 0 menit)</div>
                                <div class="session-times" id="sessionTimes">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Keterangan Kegiatan
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
                    

                    <!-- Summary Section -->
                    <div class="summary-section">
                        <h3>Ringkasan Peminjaman</h3>
                        <div class="summary-content">
                            <div class="summary-item">
                                <div class="summary-label">Ruangan:</div>
                                <div class="summary-value" id="summaryRoom">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Tanggal:</div>
                                <div class="summary-value" id="summaryDate">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Sesi:</div>
                                <div class="summary-value" id="summarySession">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Durasi:</div>
                                <div class="summary-value" id="summaryDuration">-</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="confirmation-note">
                        <i class="fas fa-info-circle"></i>
                        <p>Dengan mengajukan peminjaman, Anda setuju dengan peraturan dan ketentuan yang berlaku. Pengajuan Anda akan diproses oleh admin dalam waktu 1x24 jam.</p>
                    </div>
                </div>

                <!-- Hidden fields for session data -->
                <input type="hidden" name="sesi_data" id="sesiData" value="">
                <input type="hidden" name="jam_mulai" id="startTimeHidden" value="">
                <input type="hidden" name="jam_selesai" id="endTimeHidden" value="">

                <!-- Submit Button - Change to button type="button" -->
                <div class="form-footer">
                    <button type="button" class="btn btn-primary" id="submitBtn">
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
        --blue-500: #3B82F6;
        --blue-700: #1D4ED8;
        --teal-700: #0F766E;
        
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
        max-width: 700px;
        margin: 0 auto;
    }

    /* Form Card - Simplified */
    .form-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .form-content {
        padding: 2rem;
    }

    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-header h2 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: var(--text-secondary);
        margin: 0;
    }

    /* Form Elements - Simplified */
    .form-group {
        margin-bottom: 1.5rem;
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
        padding: 0.875rem 1rem;
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

    /* Form Select - Enhanced */
    .select-wrapper {
        position: relative;
    }

    .form-select {
        width: 100%;
        padding: 0.875rem 3rem 0.875rem 1rem;
        border: 2px solid var(--border-primary);
        border-radius: 0.75rem;
        background: var(--glass-bg);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
        appearance: none;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--warm-500);
        box-shadow: 0 0 0 3px rgba(248, 212, 161, 0.2);
    }

    .select-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-tertiary);
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .form-select:focus + .select-icon {
        color: var(--warm-500);
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
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-tertiary);
    }

    /* Session Selection - New */
    .session-selection {
        margin-bottom: 1.5rem;
    }

    .session-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .session-item {
        background: var(--glass-bg);
        border: 2px solid var(--border-primary);
        border-radius: 1rem;
        padding: 1rem 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .session-item:hover {
        border-color: var(--warm-300);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .session-item.selected {
        background: var(--gradient-warm-subtle);
        border-color: var(--warm-500);
        color: var(--warm-700);
        box-shadow: var(--shadow-md);
    }

    .session-item.selected::after {
        content: '\f058';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: var(--gradient-warm);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
    }

    .session-item.disabled {
        background: rgba(189, 180, 165, 0.2);
        border-color: var(--text-quaternary);
        color: var(--text-quaternary);
        cursor: not-allowed;
        opacity: 0.6;
    }

    .session-item.disabled:hover {
        transform: none;
        box-shadow: none;
        border-color: var(--text-quaternary);
    }

    .session-item.disabled::before {
        content: '\f0c1';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: var(--coral-500);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
    }

    /* Conflict Alert Styling */
    .alert-message.conflict-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        animation: fadeIn 0.3s ease;
    }

    .alert-message.conflict-error .alert-icon {
        color: #ef4444;
        font-size: 1.25rem;
    }

    .alert-message.conflict-error .alert-content {
        flex: 1;
    }

    .alert-message.conflict-error .alert-title {
        color: #ef4444;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .alert-message.conflict-error .error-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .alert-message.conflict-error .alert-close {
        background: none;
        border: none;
        color: var(--text-tertiary);
        cursor: pointer;
        padding: 0.25rem;
        margin: -0.25rem -0.25rem -0.25rem 0;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
    }

    .alert-message.conflict-error .alert-close:hover {
        background: rgba(189, 180, 165, 0.1);
        color: var(--text-primary);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .session-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .session-time {
        font-size: 0.85rem;
        color: var(--text-secondary);
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

    .session-times {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    /* Summary Section */
    .summary-section {
        background: var(--gradient-warm-subtle);
        border-radius: 1rem;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid var(--border-primary);
    }

    .summary-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .summary-section h3::before {
        content: '\f075';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: var(--warm-600);
    }

    .summary-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .summary-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .summary-value {
        color: var(--text-primary);
        font-weight: 500;
    }

    .confirmation-note {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--gradient-warm-subtle);
        border-radius: 0.75rem;
        border-left: 4px solid var(--warm-500);
        margin-top: 1.5rem;
    }

    .confirmation-note i {
        color: var(--warm-600);
        margin-top: 0.2rem;
        font-size: 1.1rem;
    }

    .confirmation-note p {
        margin: 0;
        color: var(--text-primary);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Form Footer */
    .form-footer {
        padding: 1.5rem 2rem;
        background: var(--gradient-warm-subtle);
        border-top: 1px solid var(--border-primary);
        text-align: center;
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

    .alert-message.info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: var(--blue-700);
    }
    
    .alert-message.success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: var(--teal-700);
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
    
    /* Ikon khusus untuk setiap tipe alert */
    .alert-message.error .alert-icon { background: var(--coral-500); }
    .alert-message.info .alert-icon { background: var(--blue-500); }
    .alert-message.success .alert-icon { background: var(--teal-500); }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin: 0 0 0.75rem 0;
        font-size: 1.1rem;
    }
    
    .alert-message.error .alert-title { color: var(--coral-700); }
    .alert-message.info .alert-title { color: var(--blue-700); }
    .alert-message.success .alert-title { color: var(--teal-700); }

    .error-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .alert-message.error .error-item { color: var(--coral-700); }
    .alert-message.info .error-item { color: var(--blue-700); }
    .alert-message.success .error-item { color: var(--teal-700); }

    .alert-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .alert-message.error .alert-close { color: var(--coral-500); }
    .alert-message.info .alert-close { color: var(--blue-500); }
    .alert-message.success .alert-close { color: var(--teal-500); }

    .alert-close:hover {
        background: rgba(0, 0, 0, 0.1);
    }
    
    .alert-message.error .alert-close:hover { color: var(--coral-700); }
    .alert-message.info .alert-close:hover { color: var(--blue-700); }
    .alert-message.success .alert-close:hover { color: var(--teal-700); }


    /* Button */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        font-size: 1rem;
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
        .form-container {
            max-width: 100%;
        }
        
        .form-content {
            padding: 1.5rem;
        }
        
        .session-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
        
        .summary-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.75rem;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .session-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.querySelector('input[type="date"]');
    if (dateInput) {
        dateInput.min = today;
    }
    
    // Room Selection (Dropdown)
    const roomSelect = document.getElementById('selectedRoom');
    
    // Session Generation and Selection
    const sessionGrid = document.getElementById('sessionGrid');
    const durationDisplay = document.getElementById('durationDisplay');
    const durationText = document.getElementById('durationText');
    const sessionTimes = document.getElementById('sessionTimes');
    const sesiDataInput = document.getElementById('sesiData');
    const startTimeHidden = document.getElementById('startTimeHidden');
    const endTimeHidden = document.getElementById('endTimeHidden');
    
    // Store existing schedules for conflict checking
    let existingSchedules = [];
    let regularSchedules = [];
    let isSubmitting = false;
    
    /**
     * Get day name from date
     */
    function getDayName(dateStr) {
        const date = new Date(dateStr);
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return days[date.getDay()];
    }
    
    /**
     * Convert time string to minutes since midnight
     */
    function timeToMinutes(timeStr) {
        const [hours, minutes] = timeStr.split(':').map(Number);
        return hours * 60 + minutes;
    }
    
    /**
     * Check if two time ranges overlap
     */
    function timeRangesOverlap(start1, end1, start2, end2) {
        const s1 = timeToMinutes(start1);
        const e1 = timeToMinutes(end1);
        const s2 = timeToMinutes(start2);
        const e2 = timeToMinutes(end2);
        
        return (s1 < e2 && s2 < e1);
    }
    
    /**
     * Generate session options (7:00 to 15:15, 45 minutes each)
     * Ensuring each session is exactly 45 minutes
     */
    function generateSessions() {
        const sessions = [];
        let startHour = 7;
        let startMinute = 0;
        
        // Generate sessions from 7:00 to 15:15, each exactly 45 minutes
        while (startHour < 15 || (startHour === 15 && startMinute === 0)) {
            // Calculate end time (exactly 45 minutes after start time)
            let endHour = startHour;
            let endMinute = startMinute + 45;
            
            if (endMinute >= 60) {
                endHour += Math.floor(endMinute / 60);
                endMinute = endMinute % 60;
            }
            
            const startTime = `${startHour.toString().padStart(2, '0')}:${startMinute.toString().padStart(2, '0')}`;
            const endTime = `${endHour.toString().padStart(2, '0')}:${endMinute.toString().padStart(2, '0')}`;
            
            sessions.push({
                id: sessions.length + 1,
                startTime: startTime,
                endTime: endTime
            });
            
            // Move to next session
            startHour = endHour;
            startMinute = endMinute;
        }
        
        return sessions;
    }
    
    const sessions = generateSessions();
    
    /**
     * Fetch existing schedules for selected date and room
     * This function generates mock data for demonstration
     * In a real application, this would be an API call to the server
     */
    function fetchExistingSchedules(date, roomId) {
        return new Promise((resolve) => {
            // First, fetch regular schedules based on day of the week
            const dayName = getDayName(date);
            
            // Fetch regular schedules via API
            fetch(`/api/jadwal-reguler/${roomId}/${dayName}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    regularSchedules = data;
                    
                    // Generate some mock schedules for demonstration
                    // This creates conflicts for today's date in room 1 and 2
                    const mockSchedules = [];
                    
                    if (date === today) {
                        if (roomId === "1") {
                            // Add conflicts for room 1 today
                            mockSchedules.push(
                                { date: date, roomId: roomId, startTime: "09:00", endTime: "09:45" },
                                { date: date, roomId: roomId, startTime: "11:00", endTime: "11:45" },
                                { date: date, roomId: roomId, startTime: "13:00", endTime: "13:45" }
                            );
                        } else if (roomId === "2") {
                            // Add conflicts for room 2 today
                            mockSchedules.push(
                                { date: date, roomId: roomId, startTime: "08:00", endTime: "08:45" },
                                { date: date, roomId: roomId, startTime: "10:30", endTime: "11:15" },
                                { date: date, roomId: roomId, startTime: "14:00", endTime: "14:45" }
                            );
                        }
                    }
                    
                    existingSchedules = [...mockSchedules];
                    resolve({ existingSchedules, regularSchedules });
                })
                .catch(error => {
                    console.error('Error fetching regular schedules:', error);
                    
                    // Fallback to mock data if API call fails
                    const mockSchedules = [];
                    
                    if (date === today) {
                        if (roomId === "1") {
                            mockSchedules.push(
                                { date: date, roomId: roomId, startTime: "09:00", endTime: "09:45" },
                                { date: date, roomId: roomId, startTime: "11:00", endTime: "11:45" },
                                { date: date, roomId: roomId, startTime: "13:00", endTime: "13:45" }
                            );
                        } else if (roomId === "2") {
                            mockSchedules.push(
                                { date: date, roomId: roomId, startTime: "08:00", endTime: "08:45" },
                                { date: date, roomId: roomId, startTime: "10:30", endTime: "11:15" },
                                { date: date, roomId: roomId, startTime: "14:00", endTime: "14:45" }
                            );
                        }
                    }
                    
                    existingSchedules = mockSchedules;
                    regularSchedules = [];
                    resolve({ existingSchedules, regularSchedules });
                });
        });
    }
    
    /**
     * Check if a session conflicts with existing schedules
     */
    function hasSessionConflict(session, schedules) {
        return schedules.some(schedule => {
            // Check if session time overlaps with any existing schedule
            return timeRangesOverlap(
                session.startTime, 
                session.endTime, 
                schedule.startTime || schedule.jam_mulai, 
                schedule.endTime || schedule.jam_selesai
            );
        });
    }
    
    /**
     * Update session availability based on existing schedules
     */
    function updateSessionAvailability() {
        const sessionItems = document.querySelectorAll('.session-item');
        
        sessionItems.forEach(item => {
            const session = {
                startTime: item.dataset.startTime,
                endTime: item.dataset.endTime
            };
            
            // Check if this session conflicts with any existing schedule
            const hasConflict = hasSessionConflict(session, existingSchedules) || 
                               hasSessionConflict(session, regularSchedules);
            
            if (hasConflict) {
                item.classList.add('disabled');
                item.classList.remove('selected');
                item.title = 'Sesi ini tidak tersedia (sudah dipesan)';
            } else {
                item.classList.remove('disabled');
                item.title = '';
            }
        });
        
        // Update duration display if needed
        updateDuration();
    }
    
    // Render session options
    function renderSessions() {
        sessionGrid.innerHTML = '';
        
        sessions.forEach(session => {
            const sessionItem = document.createElement('div');
            sessionItem.className = 'session-item';
            sessionItem.dataset.sessionId = session.id;
            sessionItem.dataset.startTime = session.startTime;
            sessionItem.dataset.endTime = session.endTime;
            
            sessionItem.innerHTML = `
                <div class="session-number">Sesi ${session.id}</div>
                <div class="session-time">${session.startTime} - ${session.endTime}</div>
            `;
            
            sessionItem.addEventListener('click', function() {
                // Don't allow selection of disabled sessions
                if (this.classList.contains('disabled')) {
                    showNotification('Sesi ini sudah dipesan. Silakan pilih sesi lain.', 'error');
                    return;
                }
                
                toggleSessionSelection(this);
            });
            
            sessionGrid.appendChild(sessionItem);
        });
    }
    
    // Initialize sessions
    renderSessions();
    
    /**
     * Toggle session selection with consecutive logic (without notification)
     */
    function toggleSessionSelection(sessionElement) {
        const allSessions = document.querySelectorAll('.session-item');
        const selectedSessions = document.querySelectorAll('.session-item.selected');
        const clickedId = parseInt(sessionElement.dataset.sessionId);

        // If clicking an already selected session, deselect all.
        if (sessionElement.classList.contains('selected')) {
            allSessions.forEach(s => s.classList.remove('selected'));
            updateDuration();
            return;
        }

        // If no session is selected, select the clicked one.
        if (selectedSessions.length === 0) {
            sessionElement.classList.add('selected');
            updateDuration();
            return;
        }
        
        // If sessions are already selected, check if the new one is consecutive.
        const selectedIds = Array.from(selectedSessions).map(s => parseInt(s.dataset.sessionId));
        const minId = Math.min(...selectedIds);
        const maxId = Math.max(...selectedIds);

        if (clickedId === minId - 1 || clickedId === maxId + 1) {
            // If consecutive, add it to the selection.
            sessionElement.classList.add('selected');
        } else {
            // If not consecutive, reset and start a new selection.
            allSessions.forEach(s => s.classList.remove('selected'));
            sessionElement.classList.add('selected');
        }
        
        updateDuration();
    }
    
    // Update duration display
    function updateDuration() {
        const selectedSessions = document.querySelectorAll('.session-item.selected');
        
        if (selectedSessions.length > 0) {
            // Calculate total duration (each session is exactly 45 minutes)
            const totalMinutes = selectedSessions.length * 45;
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            
            durationText.textContent = `${selectedSessions.length} sesi (${hours} jam ${minutes > 0 ? minutes + ' menit' : ''})`;
            
            // Get first and last session times
            const firstSession = selectedSessions[0];
            const lastSession = selectedSessions[selectedSessions.length - 1];
            
            sessionTimes.textContent = `${firstSession.dataset.startTime} - ${lastSession.dataset.endTime}`;
            
            // Update hidden fields
            startTimeHidden.value = firstSession.dataset.startTime;
            endTimeHidden.value = lastSession.dataset.endTime;
            
            // Create array of session data
            const sessionDataArray = Array.from(selectedSessions).map(session => ({
                id: session.dataset.sessionId,
                startTime: session.dataset.startTime,
                endTime: session.dataset.endTime
            }));
            
            sesiDataInput.value = JSON.stringify(sessionDataArray);
            
            durationDisplay.style.display = 'flex';
        } else {
            durationDisplay.style.display = 'none';
            startTimeHidden.value = '';
            endTimeHidden.value = '';
            sesiDataInput.value = '';
        }
    }
    
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
        const summaryRoom = document.getElementById('summaryRoom');
        const summaryDate = document.getElementById('summaryDate');
        const summarySession = document.getElementById('summarySession');
        const summaryDuration = document.getElementById('summaryDuration');
        
        if (roomSelect.value) {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            summaryRoom.textContent = selectedOption.text;
        }
        
        if (dateInput.value) {
            const date = new Date(dateInput.value);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            summaryDate.textContent = date.toLocaleDateString('id-ID', options);
        }
        
        const selectedSessions = document.querySelectorAll('.session-item.selected');
        if (selectedSessions.length > 0) {
            const sessionIds = Array.from(selectedSessions).map(s => `Sesi ${s.dataset.sessionId}`);
            summarySession.textContent = sessionIds.join(', ');
            
            // Calculate duration for summary (each session is exactly 45 minutes)
            const totalMinutes = selectedSessions.length * 45;
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            
            summaryDuration.textContent = `${hours} jam ${minutes > 0 ? minutes + ' menit' : ''}`;
        } else {
             summarySession.textContent = '-';
             summaryDuration.textContent = '-';
        }
    }
    
    // Update summary when form values change
    roomSelect.addEventListener('change', updateSummary);
    dateInput.addEventListener('change', updateSummary);
    keteranganTextarea.addEventListener('input', updateSummary);
    
    // Add event listener to update summary when session selection changes
    document.addEventListener('click', function(e) {
        if (e.target.closest('.session-item')) {
            setTimeout(updateSummary, 100); // Small delay to ensure class is updated
        }
    });
    
    // Event listener for date and room selection changes
    dateInput.addEventListener('change', function() {
        if (this.value && roomSelect.value) {
            fetchExistingSchedules(this.value, roomSelect.value)
                .then(() => updateSessionAvailability());
        }
    });
    
    roomSelect.addEventListener('change', function() {
        if (this.value && dateInput.value) {
            fetchExistingSchedules(dateInput.value, this.value)
                .then(() => updateSessionAvailability());
        }
    });
    
    // Form submission - COMPLETELY REWRITTEN
    const form = document.getElementById('bookingForm');
    const submitBtn = document.getElementById('submitBtn');
    
    submitBtn.addEventListener('click', async function(e) {
        e.preventDefault(); // ALWAYS prevent default first
        e.stopPropagation();
        
        // Prevent multiple submissions
        if (isSubmitting) {
            return;
        }
        
        isSubmitting = true;
        
        // Basic validation
        if (!roomSelect.value) {
            isSubmitting = false;
            showNotification('Silakan pilih ruangan terlebih dahulu', 'error');
            return;
        }
        
        if (!dateInput.value) {
            isSubmitting = false;
            showNotification('Silakan pilih tanggal peminjaman', 'error');
            return;
        }
        
        if (document.querySelectorAll('.session-item.selected').length === 0) {
            isSubmitting = false;
            showNotification('Silakan pilih minimal satu sesi', 'error');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memeriksa jadwal...';
        
        try {
            // Fetch the latest schedules before validation
            const { existingSchedules: latestExisting, regularSchedules: latestRegular } = 
                await fetchExistingSchedules(dateInput.value, roomSelect.value);
            
            // Check for conflicts with existing schedules
            const selectedSessions = document.querySelectorAll('.session-item.selected');
            let hasConflict = false;
            let conflictType = '';
            let conflictingSchedule = null;
            
            for (const sessionItem of selectedSessions) {
                const session = {
                    startTime: sessionItem.dataset.startTime,
                    endTime: sessionItem.dataset.endTime
                };
                
                // Check conflict with regular schedules first
                for (const schedule of latestRegular) {
                    if (timeRangesOverlap(
                        session.startTime, 
                        session.endTime, 
                        schedule.jam_mulai, 
                        schedule.jam_selesai
                    )) {
                        hasConflict = true;
                        conflictType = 'reguler';
                        conflictingSchedule = schedule;
                        break;
                    }
                }
                
                if (!hasConflict) {
                    // Check conflict with other schedules
                    for (const schedule of latestExisting) {
                        if (timeRangesOverlap(
                            session.startTime, 
                            session.endTime, 
                            schedule.startTime, 
                            schedule.endTime
                        )) {
                            hasConflict = true;
                            conflictType = 'other';
                            conflictingSchedule = schedule;
                            break;
                        }
                    }
                }
                
                if (hasConflict) break;
            }
            
            if (hasConflict) {
                isSubmitting = false;
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Ajukan Peminjaman';
                
                if (conflictType === 'reguler') {
                    const dayName = getDayName(dateInput.value);
                    showNotification(
                        `Jadwal yang dipilih bentrok dengan jadwal reguler pada hari ${dayName} (${conflictingSchedule.jam_mulai} - ${conflictingSchedule.jam_selesai}). Silakan pilih sesi lain.`, 
                        'error'
                    );
                } else {
                    showNotification(
                        `Jadwal yang dipilih bentrok dengan jadwal yang sudah ada (${conflictingSchedule.startTime} - ${conflictingSchedule.endTime}). Silakan pilih sesi lain.`, 
                        'error'
                    );
                }
                return;
            }
            
            // If no conflicts, update button and submit form
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengajukan...';
            
            // Use setTimeout to ensure UI updates before submission
            setTimeout(() => {
                form.submit();
            }, 500);
            
        } catch (error) {
            console.error('Error checking conflicts:', error);
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Ajukan Peminjaman';
            showNotification('Terjadi kesalahan saat memvalidasi jadwal. Silakan coba lagi.', 'error');
        }
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
            if(alert.parentNode) { // Check if element still exists
                alert.style.animation = 'slideUp 0.3s ease-out forwards';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }, 10000);
    });
    
    /**
     * Show notification function with support for 'info' type
     */
    function showNotification(message, type = 'info') {
        // Remove existing temporary notifications to avoid stacking
        document.querySelectorAll('.alert-message.info, .alert-message.success').forEach(n => n.remove());

        const notification = document.createElement('div');
        notification.className = `alert-message ${type} fade-in`;
        
        const iconMap = {
            'error': 'exclamation-triangle',
            'info': 'info-circle',
            'success': 'check-circle'
        };

        notification.innerHTML = `
            <div class="alert-icon">
                <i class="fas fa-${iconMap[type]}"></i>
            </div>
            <div class="alert-content">
                <div class="error-item">
                    <i class="fas fa-${iconMap[type]}"></i>
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
            if(notification.parentNode) {
                notification.style.animation = 'slideUp 0.3s ease-out forwards';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
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