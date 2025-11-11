<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Menampilkan semua booking
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])->get();
        return response()->json($bookings);
    }

    // Menyimpan booking baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'id_room'     => 'required|exists:rooms,id_room',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'status'      => 'in:pending,approved,rejected',
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }

    // Menampilkan detail booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return response()->json($booking);
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'user_id'     => 'exists:users,id',
            'id_room'     => 'exists:rooms,id_room',
            'tanggal'     => 'date',
            'status'      => 'in:pending,approved,rejected',
        ]);

        $booking->update($request->all());

        return response()->json([
            'message' => 'Booking berhasil diupdate',
            'data' => $booking
        ]);
    }

    // Hapus booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}
