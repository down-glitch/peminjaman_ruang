@extends('layouts.app')

@section('title', 'Laporan Peminjaman Ruangan')

@section('content')
<!-- Wrapper unik untuk mengisolasi CSS -->
<div id="laporan-wrapper">
    <!-- Header untuk Cetak -->
    <div class="cetak-header">
        <h1>Laporan Peminjaman Ruangan</h1>
        <p>Dicetak pada: <span id="tanggal-cetak"></span></p>
    </div>

    <!-- Header Halaman (Tidak tercetak) -->
    <div class="halaman-header">
        <div>
            <h2>Laporan Peminjaman Ruangan</h2>
            <p>Filter dan cetak laporan peminjaman ruangan</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn-tombol btn-sekunder">
            <i class="fas fa-sync"></i> Refresh
        </a>
    </div>

    <!-- Kartu Utama -->
    <div class="kartu-utama">
        <!-- Header Kartu (Tidak tercetak) -->
        <div class="kartu-header tidak-cetak">
            <h5>Data Laporan</h5>
            <div>
                <button class="btn-tombol btn-sekunder" onclick="eksporExcel()">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
                <button class="btn-tombol btn-utama" onclick="cetakTabel()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>

        <div class="kartu-body">
            <!-- Filter (Tidak tercetak) -->
            <div class="filter-area tidak-cetak">
                <form action="{{ route('laporan.index') }}" method="GET">
                    <div class="filter-baris">
                        <div class="filter-kolom">
                            <label>Filter Tanggal</label>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="filter-kolom">
                            <label>Filter Bulan</label>
                            <input type="month" name="bulan" value="{{ request('bulan') }}">
                        </div>
                        <div class="filter-kolom">
                            <label>&nbsp;</label>
                            <div class="filter-aksi">
                                <button type="submit" class="btn-tombol btn-utama">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('laporan.index') }}" class="btn-tombol btn-sekunder">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistik -->
            @php
                $bookingsCollection = isset($bookings) ? $bookings : collect([]);
                $total = $bookingsCollection->count();
                $approvedCount = $bookingsCollection->where('status', 'approved')->count();
                $pendingCount = $bookingsCollection->where('status', 'pending')->count();
                $rejectedCount = $bookingsCollection->where('status', 'rejected')->count();
            @endphp

            <div class="stat-grid">
                <div class="stat-card total">
                    <div class="stat-angka">{{ $total }}</div>
                    <div class="stat-label">Total Data</div>
                </div>
                <div class="stat-card disetujui">
                    <div class="stat-angka">{{ $approvedCount }}</div>
                    <div class="stat-label">Disetujui</div>
                </div>
                <div class="stat-card menunggu">
                    <div class="stat-angka">{{ $pendingCount }}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
                <div class="stat-card ditolak">
                    <div class="stat-angka">{{ $rejectedCount }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="tabel-area">
                <table class="tabel-data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookingsCollection as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $b->user->username ?? 'Tidak diketahui' }}</td>
                            <td>{{ $b->room->nama_room ?? 'Tidak diketahui' }}</td>
                            <td>{{ isset($b->tanggal) ? \Carbon\Carbon::parse($b->tanggal)->format('d-m-Y') : '-' }}</td>
                            <td>{{ ($b->jam_mulai ?? '-') . ' - ' . ($b->jam_selesai ?? '-') }}</td>
                            <td>{{ $b->keterangan ?? '-' }}</td>
                            <td>
                                @if($b->status === 'approved')
                                    <span class="badge-status sukses">Disetujui</span>
                                @elseif($b->status === 'pending')
                                    <span class="badge-status peringatan">Menunggu</span>
                                @elseif($b->status === 'rejected')
                                    <span class="badge-status gagal">Ditolak</span>
                                @else
                                    <span class="badge-status netral">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="tidak-ada-data">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* --- AWAL CSS YANG TERISOLASI --- */
/* Semua style di dalam ini hanya berlaku untuk elemen di dalam #laporan-wrapper */

#laporan-wrapper {
    font-family: 'Inter', sans-serif;
    color: #333;
    padding: 20px;
    background-color: #f9f9f9;
}

/* Header untuk cetak - disembunyikan di layar */
.cetak-header {
    display: none;
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #000;
}
.cetak-header h1 { font-size: 18px; font-weight: bold; margin: 0; }
.cetak-header p { font-size: 12px; margin: 5px 0 0; }

/* Footer untuk cetak - disembunyikan di layar */
.cetak-footer {
    display: none;
    text-align: center;
    margin-top: 20px;
    padding-top: 10px;
    border-top: 1px solid #ccc;
    font-size: 10px;
    color: #666;
}

/* Header Halaman (tidak tercetak) */
.halaman-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e0e0e0;
}
.halaman-header h2 {
    font-size: 24px;
    font-weight: 700;
    color: #2D2416;
    margin: 0;
}
.halaman-header p {
    font-size: 14px;
    color: #777;
    margin: 5px 0 0;
}

/* Kartu Utama */
.kartu-utama {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}
.kartu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    background: #f8f5f0;
    border-bottom: 1px solid #e0e0e0;
}
.kartu-header h5 { font-size: 16px; font-weight: 600; margin: 0; color: #2D2416; }
.kartu-body { padding: 25px; }

/* Tombol */
.btn-tombol {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-utama {
    background: #E2B88A;
    color: #fff;
    border-color: #C19660;
}
.btn-utama:hover { background: #C19660; transform: translateY(-1px); }
.btn-sekunder {
    background: #fff;
    color: #5A4A36;
    border-color: #e0e0e0;
}
.btn-sekunder:hover { background: #f2f2f2; }

/* Filter */
.filter-area {
    background: #f8f5f0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
}
.filter-baris {
    display: grid;
    grid-template-columns: 1fr 1fr 1.5fr;
    gap: 20px;
    align-items: end;
}
.filter-kolom label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #2D2416;
    margin-bottom: 8px;
}
.filter-kolom input {
    width: 100%;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 14px;
}
.filter-aksi { display: flex; gap: 10px; }

/* Statistik */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}
.stat-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}
.stat-card.total { border-left: 4px solid #E2B88A; }
.stat-card.disetujui { border-left: 4px solid #10B981; }
.stat-card.menunggu { border-left: 4px solid #F59E0B; }
.stat-card.ditolak { border-left: 4px solid #EF4444; }
.stat-angka {
    font-size: 28px;
    font-weight: 700;
    color: #2D2416;
    margin-bottom: 5px;
}
.stat-label {
    font-size: 13px;
    color: #777;
    font-weight: 500;
}

/* Tabel */
.tabel-area {
    overflow-x: auto;
}
.tabel-data {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.tabel-data th {
    background: #f8f5f0;
    color: #2D2416;
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 2px solid #e0e0e0;
}
.tabel-data td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}
.tabel-data tr:hover { background: #fafafa; }
.tidak-ada-data {
    text-align: center !important;
    padding: 40px 20px !important;
    color: #999 !important;
    font-size: 16px !important;
}

/* Badge Status */
.badge-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}
.badge-status.sukses {
    background: #d1fae5;
    color: #065f46;
}
.badge-status.peringatan {
    background: #fed7aa;
    color: #92400e;
}
.badge-status.gagal {
    background: #fecaca;
    color: #991b1b;
}
.badge-status.netral {
    background: #e5e7eb;
    color: #374151;
}

/* Responsif */
@media (max-width: 768px) {
    .halaman-header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .filter-baris { grid-template-columns: 1fr; }
    .stat-grid { grid-template-columns: 1fr; }
}


/* ========================================================= */
/* =================== FORMAT CETAK (PRINT) ================== */
/* ========================================================= */

@media print {
    /* 1. Pengaturan Halaman & Kertas */
    @page {
        size: A4 landscape; /* Membuat orientasi landscape untuk tabel lebar */
        margin: 15mm; /* Margin di setiap sisi */
    }

    /* 2. Sembunyikan Semua Elemen di Luar Wrapper */
    body * {
        visibility: hidden;
    }

    /* 3. Tampilkan Hanya Konten di Dalam Wrapper */
    #laporan-wrapper, #laporan-wrapper * {
        visibility: visible;
    }

    /* 4. Posisikan Wrapper dari Awal Halaman */
    #laporan-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 10mm; /* Padding di dalam margin kertas */
    }

    /* 5. Tampilkan Header & Footer Khusus Cetak */
    .cetak-header, .cetak-footer, .stat-grid, .tabel-area {
        display: block !important;
    }
    
    /* 6. Sembunyikan Elemen Interaktif */
    .tidak-cetak, .filter-area, .kartu-header, .halaman-header {
        display: none !important;
    }

    /* 7. Reset Font dan Warna Dasar */
    #laporan-wrapper {
        font-size: 11pt;
        line-height: 1.3;
        color: #000 !important;
        background: #fff !important;
    }
    
    /* 8. Gaya Header Cetak */
    .cetak-header h1 {
        font-size: 16pt !important;
        font-weight: bold !important;
        margin-bottom: 5pt !important;
    }
    .cetak-header p {
        font-size: 10pt !important;
        margin: 0 !important;
    }

    /* 9. Gaya Kartu Statistik Cetak */
    .stat-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 10mm !important;
        margin-bottom: 10mm !important;
        page-break-inside: avoid; /* Cegah kartu terpotong */
    }
    .stat-card {
        border: 1pt solid #000 !important;
        padding: 8pt !important;
        text-align: center !important;
        background: #fff !important;
    }
    .stat-angka, .stat-label {
        color: #000 !important;
        font-weight: bold !important;
    }
    .stat-angka { font-size: 14pt !important; }
    .stat-label { font-size: 10pt !important; font-weight: normal !important; }

    /* 10. Gaya Tabel Cetak - PALING PENTING */
    .tabel-data {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
        font-size: 10pt !important;
    }
    .tabel-data th {
        background: #f0f0f0 !important; /* Warna abu-abu terang untuk header */
        color: #000 !important;
        border: 1pt solid #000 !important;
        padding: 6pt 8pt !important;
        font-weight: bold !important;
        text-align: left !important;
    }
    .tabel-data td {
        border: 1pt solid #000 !important;
        padding: 5pt 8pt !important;
        background: #fff !important;
        color: #000 !important;
        vertical-align: top !important;
    }
    .tabel-data tr {
        page-break-inside: avoid; /* Cegah baris terpotong */
    }

    /* 11. Gaya Badge Cetak (gunakan border, bukan background) */
    .badge-status {
        border: 1pt solid #000 !important;
        background: #fff !important;
        color: #000 !important;
        padding: 2pt 6pt !important;
        font-size: 9pt !important;
        font-weight: bold !important;
        border-radius: 0 !important; /* Buat kotak sederhana */
    }

    /* 12. Gaya Footer Cetak */
    .cetak-footer {
        display: block !important;
        margin-top: 10mm !important;
        padding-top: 5mm !important;
        border-top: 1pt solid #ccc !important;
        font-size: 9pt !important;
        color: #666 !important;
    }
    .cetak-footer .page-number::before {
        content: "Halaman " counter(page);
    }
    body {
        counter-reset: page;
    }
}
/* --- AKHIR CSS YANG TERISOLASI --- */
</style>
<script>
function cetakTabel() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('tanggal-cetak').textContent = now.toLocaleDateString('id-ID', options);
    window.print();
}

function eksporExcel() {
    // Fungsi ekspor tetap sama
    const table = document.querySelector('.tabel-data');
    if (!table) { alert('Tabel tidak ditemukan'); return; }
    
    let csv = [];
    table.querySelectorAll('tr').forEach(tr => {
        const row = [];
        tr.querySelectorAll('th, td').forEach(td => {
            let text = td.textContent.trim().replace(/,/g, ';');
            if (text.includes('"')) text = text.replace(/"/g, '""');
            if (text.includes('\n') || text.includes(',')) text = `"${text}"`;
            row.push(text);
        });
        csv.push(row.join(','));
    });
    
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `laporan_peminjaman_${new Date().toISOString().slice(0, 10)}.csv`;
    link.click();
    URL.revokeObjectURL(url);
    alert('Data berhasil diekspor');
}
</script>
@endsection