<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            // Mengubah kolom 'tanda_tangan' menjadi VARCHAR dengan panjang 500 karakter.
            // Anda bisa menyesuaikan angka 500 jika perlu (misalnya 1000 atau lebih).
            // Jika nama file bisa SANGAT panjang, Anda bisa mempertimbangkan $table->text('tanda_tangan')->nullable()->change();
            // tapi untuk path file, VARCHAR yang lebih panjang biasanya lebih baik.
            // Menambahkan nullable() untuk keamanan, meskipun validasi Anda mengharuskannya.
            // Jika Anda yakin tidak akan pernah null, Anda bisa menghapus ->nullable().
            $table->string('tanda_tangan', 500)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            // Mengembalikan ke definisi sebelumnya (VARCHAR 255 default) jika migrasi di-rollback.
            // Pastikan ini sesuai dengan bagaimana kolom didefinisikan sebelum perubahan ini.
            $table->string('tanda_tangan')->nullable()->change(); // Laravel akan default ke 255
        });
    }
};
