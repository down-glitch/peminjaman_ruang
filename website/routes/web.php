<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\JadwalRegulerController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LaporanController;

// ==================== ROOT ====================
Route::get('/', function () {
    if (Auth::check()) {
        return match(Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'peminjam' => redirect()->route('peminjam.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// ==================== AUTH (Hanya untuk yang belum login) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// ==================== LOGOUT (Hanya jika sudah login) ====================
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ==================== SETELAH LOGIN ====================
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/petugas/dashboard', fn() => view('petugas.dashboard'))
        ->middleware('role:petugas')
        ->name('petugas.dashboard');

    Route::get('/peminjam/dashboard', [UserDashboardController::class, 'index'])
        ->middleware('role:peminjam')
        ->name('peminjam.dashboard');

    // ADMIN & PETUGAS
    Route::middleware(['role:admin,petugas'])->group(function () {

        Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])->name('peminjaman.index');
        Route::put('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::put('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

        Route::prefix('manajemen-user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('manajemen.user');
            Route::get('/create', [UserController::class, 'create'])->name('manajemen.user.create');
            Route::post('/', [UserController::class, 'store'])->name('manajemen.user.store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('manajemen.user.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('manajemen.user.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('manajemen.user.destroy');
            Route::put('/{user}/update-role', [UserController::class, 'updateRole'])->name('manajemen.user.updateRole');
        });

        Route::resource('rooms', RoomController::class);

        Route::prefix('jadwal')->group(function () {
            Route::get('/', [JadwalRegulerController::class, 'index'])->name('jadwal.index');
            Route::get('/create', [JadwalRegulerController::class, 'create'])->name('jadwal.create');
            Route::post('/', [JadwalRegulerController::class, 'store'])->name('jadwal.store');
            Route::get('/{id_reguler}/edit', [JadwalRegulerController::class, 'edit'])->name('jadwal.edit');
            Route::put('/{id_reguler}', [JadwalRegulerController::class, 'update'])->name('jadwal.update');
            Route::delete('/{id_reguler}', [JadwalRegulerController::class, 'destroy'])->name('jadwal.destroy');
        });

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // PETUGAS
    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/peminjaman', [PeminjamanController::class, 'indexPetugas'])->name('peminjaman.petugas');
    });

    // PEMINJAM
    Route::middleware('role:peminjam')->prefix('peminjam')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.user');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/jadwal', [JadwalRegulerController::class, 'index'])->name('peminjam.jadwal');
        Route::get('/peminjaman/jadwal-booking', [PeminjamanController::class, 'jadwalBooking'])->name('peminjaman.jadwalbooking');
    });

    Route::get('/cek-jadwal', [PeminjamanController::class, 'cekJadwal'])->name('peminjaman.cekJadwal');
    Route::get('/cek-jadwal-reguler', [PeminjamanController::class, 'cekJadwalReguler'])->name('peminjaman.cekJadwal.reguler');

    Route::get('/api/jadwal-reguler/{roomId}/{day}', function($roomId, $day) {
    $schedules = \App\Models\JadwalReguler::where('id_room', $roomId)
        ->where('hari', $day)
        ->get(['jam_mulai', 'jam_selesai', 'deskripsi']);
    
    return response()->json($schedules);
});
});
