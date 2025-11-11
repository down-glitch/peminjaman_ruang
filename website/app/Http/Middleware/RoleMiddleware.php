<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika role user tidak ada dalam daftar roles yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized. Halaman ini hanya untuk: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
