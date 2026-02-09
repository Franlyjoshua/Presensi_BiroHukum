<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use App\Models\User;

class ChangePasswordController extends Controller
{
    // 1. Tampilkan Form Ganti Password
    public function index()
    {
        return view('admin.change-password');
    }

    // 2. Proses Ganti Password
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // 'confirmed' artinya harus cocok dengan field new_password_confirmation
        ]);

        // Cek apakah password lama (current_password) cocok dengan database
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah!']);
        }

        // Jika cocok, update password baru
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', 'Password berhasil diubah!');
    }
}