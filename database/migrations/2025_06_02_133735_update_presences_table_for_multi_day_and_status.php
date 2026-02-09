<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            // Asumsi 'tgl_kegiatan' sebelumnya adalah DATETIME untuk mulai
            $table->renameColumn('tgl_kegiatan', 'datetime_mulai');

            // Tambahkan kolom tanggal selesai kegiatan
            $table->dateTime('datetime_selesai')->nullable()->after('datetime_mulai');

            // Tambahkan kolom status link
            $table->boolean('is_link_active')->default(true)->after('slug'); // 'slug' adalah contoh, sesuaikan posisi
        });
    }

    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->renameColumn('datetime_mulai', 'tgl_kegiatan');
            $table->dropColumn('datetime_selesai');
            $table->dropColumn('is_link_active');
        });
    }
};