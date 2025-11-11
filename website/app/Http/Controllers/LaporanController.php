<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan hanya admin dan petugas
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $query = Booking::with(['user', 'room']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $bulan = date('m', strtotime($request->bulan));
            $tahun = date('Y', strtotime($request->bulan));
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }

        $bookings = $query->latest()->get();

        if (Auth::user()->role === 'petugas') {
            return view('petugas.laporan', compact('bookings'));
        } else {
            return view('admin.laporan', compact('bookings'));
        }
    }
}
