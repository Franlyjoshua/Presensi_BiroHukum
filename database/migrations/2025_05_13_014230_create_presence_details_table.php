<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('presence_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presence_id')->constrained('presences')->onDelete('cascade');
            $table->string('nama');
            $table->string('email'); // Diubah
            $table->string('no_hp'); // Diubah
            $table->string('instansi'); // Diubah
            $table->string('nama_bank'); // Diubah (menghilangkan spasi, lowercase)
            $table->string('no_rekening'); // Diubah
            $table->string('atas_nama'); // Diubah (menghilangkan spasi, lowercase)
            $table->string('npwp'); // Diubah
            $table->string('golongan')->nullable(); // Pastikan nullable jika memang opsional, dan diubah ke lowercase
            $table->string('tanda_tangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('presence_details');
    }
};
