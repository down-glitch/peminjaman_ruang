<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\JadwalRegulerController;



// Login (return token)
Route::post('/login', [AuthController::class, 'apiLogin']);
// Register
Route::post('/register', [AuthController::class, 'apiRegister']);


Route::middleware(['auth:sanctum'])->group(function () {

    // Logout Token
    Route::post('/logout', [AuthController::class, 'apiLogout']);


    Route::get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });


    Route::get('/rooms', [RoomController::class, 'index']); 

    // ==================== JADWAL RUANG ====================
    Route::get('/jadwal', [JadwalRegulerController::class, 'index']);

    // ==================== PEMINJAMAN OLEH PEMINJAM ====================
    // List Peminjaman user
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);

    // Create peminjaman baru
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);

    // Jadwal booking peminjam
    Route::get('/peminjaman/jadwal-booking', [PeminjamanController::class, 'jadwalBooking']);

    // Cek bentrokan jadwal
    Route::get('/cek-jadwal', [PeminjamanController::class, 'cekJadwal']);
});
