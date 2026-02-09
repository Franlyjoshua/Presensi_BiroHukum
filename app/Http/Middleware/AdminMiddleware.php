<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login DAN apakah dia adalah admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Lanjutkan jika admin
        }

        // Jika bukan admin atau belum login, redirect ke halaman login admin
        // dengan pesan error.
        return redirect()->route('admin.login.form')->withErrors(['email' => 'Anda harus login sebagai admin untuk mengakses halaman ini.']);
    }
}