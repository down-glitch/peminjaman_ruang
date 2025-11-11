<?php

namespace App\Http\Controllers;

use App\Models\JadwalReguler;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalRegulerController extends Controller
{
    public function index()
    {
        $jadwal = JadwalReguler::with('room')->orderBy('hari')->get();

        if (in_array(Auth::user()->role, ['admin', 'petugas'])) {
            return view('admin.jadwal.index_admin', compact('jadwal'));
        } else {
            return view('peminjam.jadwal.index_user', compact('jadwal'));
        }
    }

    public function create()
    {
        $this->authorizeAdminOrPetugas();
        $rooms = Room::all();
        return view('admin.jadwal.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdminOrPetugas();

        $request->validate([
            'id_room' => 'required|exists:rooms,id_room',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        JadwalReguler::create([
            'id_room' => $request->id_room,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id_reguler)
    {
        $this->authorizeAdminOrPetugas();
        $jadwal = JadwalReguler::findOrFail($id_reguler);
        $rooms = Room::all();
        return view('admin.jadwal.edit', compact('jadwal', 'rooms'));
    }

    public function update(Request $request, $id_reguler)
    {
        $this->authorizeAdminOrPetugas();

        $request->validate([
            'id_room' => 'required|exists:rooms,id_room',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $jadwal = JadwalReguler::findOrFail($id_reguler);
        $jadwal->update([
            'id_room' => $request->id_room,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id_reguler)
    {
        $this->authorizeAdminOrPetugas();
        $jadwal = JadwalReguler::findOrFail($id_reguler);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    private function authorizeAdminOrPetugas()
    {
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Unauthorized. Hanya admin atau petugas yang dapat mengakses halaman ini.');
        }
    }
}
