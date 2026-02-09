<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ================================================================= //
        // --- PERUBAHAN 1: Ganti email dengan email Anda ---
        $adminEmail = 'franlyng1@gmail.com';
        // ================================================================= //

        User::updateOrCreate(
            [
                'email' => $adminEmail // Cari user berdasarkan email ini
            ],
            [
                // ================================================================= //
                // --- PERUBAHAN 2: Ganti nama & password dengan data Anda ---
                'name' => 'Franly Joshua', // Anda bisa sesuaikan nama ini
                'password' => Hash::make('Joshuang1'),
                // ================================================================= //

                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        // Memberikan pesan konfirmasi di terminal
        $this->command->info('Seeder admin berhasil dijalankan. Data untuk email: ' . $adminEmail . ' telah diatur.');
    }
}