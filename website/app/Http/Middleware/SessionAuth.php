<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionAuth
{
    public function handle(Request $request, Closure $next)
    {
        // cek apakah session user ada
        if (!$request->session()->has('user')) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan login terlebih dahulu.'
            ]);
        }

        return $next($request);
    }
}
