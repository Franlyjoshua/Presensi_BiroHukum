<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            // Tambahkan nullable() agar bisa diisi NULL untuk data yang sudah ada
            $table->date('tanggal_absensi')->nullable()->after('presence_id');
        });
    }

    public function down(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            $table->dropColumn('tanggal_absensi');
        });
    }
};