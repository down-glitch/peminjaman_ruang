<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_room' => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Ruang berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'nama_room' => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Ruang berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Ruang berhasil dihapus.');
    }
}
