<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // ambil user dari auth

        // hanya admin yang boleh masuk
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $users = UserLogin::all();
        return view('manajemen-user.index', compact('users'));
    }

    public function updateRole(Request $request, UserLogin $user)
    {
        $currentUser = Auth::user(); // ambil user dari auth

        if (!$currentUser || $currentUser->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('manajemen.user')->with('success', 'Role berhasil diperbarui');
    }
}
