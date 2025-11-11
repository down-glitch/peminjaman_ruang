<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // ===================== PEMINJAM (USER) =====================
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('peminjam.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('peminjam.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'peminjam') {
            abort(403, 'Unauthorized. Hanya peminjam yang dapat mengajukan.');
        }

        $request->validate([
            'id_room' => 'required|exists:rooms,id_room',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jam_mulai.required' => 'Jam mulai harus diisi.',
            'jam_selesai.required' => 'Jam selesai harus diisi.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        // 🔍 Cek bentrok
        $bentrok = Booking::where('id_room', $request->id_room)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrok) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal untuk ruangan ini bentrok dengan peminjaman lain.'])
                ->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'id_room' => $request->id_room,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjaman.user')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim dan menunggu persetujuan.');
    }

    // ===================== PETUGAS =====================
    public function indexPetugas()
    {
        $bookings = Booking::with(['user', 'room'])->latest()->get();
        return view('petugas.peminjaman.index', compact('bookings'));
    }

    // ===================== ADMIN =====================
    public function indexAdmin()
    {
        $bookings = Booking::with(['user', 'room'])->latest()->get();
        return view('admin.peminjaman.index', compact('bookings'));
    }

    // ===================== APPROVE & REJECT =====================
    public function approve($id_booking)
    {
        $booking = Booking::findOrFail($id_booking);
        $booking->update(['status' => 'approved']);

        // otomatis tolak booking lain yang bentrok
        Booking::where('id_room', $booking->id_room)
            ->where('tanggal', $booking->tanggal)
            ->where('id_booking', '!=', $booking->id_booking)
            ->where('status', 'pending')
            ->where(function ($query) use ($booking) {
                $query->whereBetween('jam_mulai', [$booking->jam_mulai, $booking->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$booking->jam_mulai, $booking->jam_selesai])
                      ->orWhere(function ($q) use ($booking) {
                          $q->where('jam_mulai', '<=', $booking->jam_mulai)
                            ->where('jam_selesai', '>=', $booking->jam_selesai);
                      });
            })
            ->update(['status' => 'rejected']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman disetujui. Jadwal lain yang bentrok otomatis ditolak.');
    }

    public function reject($id_booking)
    {
        $booking = Booking::findOrFail($id_booking);
        $booking->update(['status' => 'rejected']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman telah ditolak.');
    }

    // ===================== CEK JADWAL (AJAX) =====================
    public function cekJadwal(Request $request)
    {
        $request->validate([
            'id_room' => 'required|exists:rooms,id_room',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $bentrok = Booking::where('id_room', $request->id_room)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->get(['jam_mulai', 'jam_selesai']);

        if ($bentrok->count() > 0) {
            return response()->json([
                'status' => 'bentrok',
                'message' => 'Jadwal untuk ruangan ini bentrok dengan peminjaman lain.',
                'data' => $bentrok
            ]);
        }

        return response()->json([
            'status' => 'aman',
            'message' => 'Jadwal tersedia, tidak ada bentrok.'
        ]);
    }

    // ===================== JADWAL BOOKING (UNTUK SEMUA PEMINJAM) =====================
    public function jadwalBooking()
    {
        $bookings = Booking::with(['user', 'room'])
            ->whereIn('status', ['approved', 'pending'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('peminjam.jadwal-booking', compact('bookings'));
    }
}
