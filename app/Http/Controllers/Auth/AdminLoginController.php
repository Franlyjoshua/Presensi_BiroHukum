<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User di-import

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // HAPUS ATAU BERI KOMENTAR BARIS INI:
        // $this->middleware('guest')->except('logout');
        // Middleware 'guest' akan kita tangani melalui logika di showLoginForm
        // dan proteksi rute admin akan menggunakan middleware 'auth' dan 'admin'.
    }

    public function showLoginForm()
    {
        // Jika sudah ada user login dan dia adalah admin, redirect ke dashboard admin
        // Ini secara efektif berfungsi seperti middleware 'guest' untuk admin yang sudah login
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // Jika belum login atau bukan admin, tampilkan form login admin
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            if ($user->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki hak akses admin.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
