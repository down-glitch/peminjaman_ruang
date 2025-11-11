<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;

class AuthController extends Controller
{
    // ==================== WEB LOGIN FORM ====================
    public function showLoginForm()
    {
        if (Auth::check()) {
            return match(Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.dashboard'),
                'peminjam' => redirect()->route('peminjam.dashboard'),
                default => redirect()->route('login'),
            };
        }

        return view('auth.login');
    }

    // ==================== WEB LOGIN ====================
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserLogin::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.dashboard'),
                'peminjam' => redirect()->route('peminjam.dashboard'),
                default => redirect()->route('login')->withErrors(['username' => 'Role tidak valid.']),
            };
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // ==================== WEB REGISTER FORM ====================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ==================== WEB REGISTER ====================
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user_logins',
            'email' => 'required|email|unique:user_logins',
            'password' => 'required|min:6|confirmed',
        ]);

        UserLogin::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'peminjam',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // ==================== WEB LOGOUT ====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

    // ========================================================================
    // ============================== API FLUTTER =============================
    // ========================================================================

    // ========== API LOGIN (return token Sanctum) ==========
    public function apiLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserLogin::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Username atau password salah'], 401);
        }

        if ($user->role !== 'peminjam') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak (hanya peminjam).'], 403);
        }

        $token = $user->createToken('flutter')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    // ========== API LOGOUT ==========
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    // ========== API REGISTER (Otomatis role peminjam) ==========
    public function apiRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user_logins',
            'email' => 'required|email|unique:user_logins',
            'password' => 'required|min:6',
        ]);

        $user = UserLogin::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'peminjam',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user
        ]);
    }
}
