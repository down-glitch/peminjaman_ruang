<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // Tampilkan semua data petugas
    public function index()
    {
        $petugas = Petugas::with('userLogin')->get();
        return response()->json($petugas);
    }

    // Tambah petugas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_petugas'  => 'required|string|max:50',
            'telepon'       => 'nullable|numeric',
            'tanggal_lahir' => 'nullable|date',
            'user_login_id' => 'required|exists:user_logins,id',
        ]);

        $petugas = Petugas::create($request->all());

        return response()->json([
            'message' => 'Petugas berhasil ditambahkan',
            'data'    => $petugas
        ], 201);
    }

    // Detail petugas
    public function show($id)
    {
        $petugas = Petugas::with('userLogin')->findOrFail($id);
        return response()->json($petugas);
    }

    // Update data petugas
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama_petugas'  => 'sometimes|required|string|max:50',
            'telepon'       => 'nullable|numeric',
            'tanggal_lahir' => 'nullable|date',
            'user_login_id' => 'sometimes|required|exists:user_logins,id',
        ]);

        $petugas->update($request->all());

        return response()->json([
            'message' => 'Petugas berhasil diperbarui',
            'data'    => $petugas
        ]);
    }

    // Hapus petugas
    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return response()->json([
            'message' => 'Petugas berhasil dihapus'
        ]);
    }
}
