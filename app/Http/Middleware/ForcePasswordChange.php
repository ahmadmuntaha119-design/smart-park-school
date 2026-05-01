<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pengecualian agar tidak memutar-mutar terus, polisi ini izinkan lewat khusus untuk Lorong "Ganti Password" atau "Logout".
        if ($request->routeIs('password.change.show') || $request->routeIs('password.change.process') || $request->routeIs('logout')) {
            return $next($request);
        }

        // 2. Cegat orangnya kalau di data tertulis "Is First Login = TRUE" (khusus siswa baru daftar)
        if (Auth::check() && Auth::user()->is_first_login) {
            return redirect()->route('password.change.show')->with('warning', 'Anda wajib mengganti password default sebelum masuk ke sistem PKS.');
        }

        // 3. Kalau bukan first login macam Admin PKS? Silakan lewat!
        return $next($request);
    }
}
