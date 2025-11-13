<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:user_logins',
            'email'    => 'required|string|email|unique:user_logins',
            'password' => 'required|string|min:8',
            'role'     => 'in:admin,petugas,peminjam',
        ]);

        $user = UserLogin::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'peminjam',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Register berhasil',
            'user'    => $user,
            'token'   => $token,
        ], 201); // ✅ 201 Created
    }

    // LOGIN
    public function login(Request $request)
    {

dd($request->all());

        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserLogin::where('email', $request->login)
                         ->orWhere('username', $request->login)
                         ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email/Username atau Password salah'
            ], 401); // ✅ 401 Unauthorized
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
        ], 200); // ✅ 200 OK
    }
}
