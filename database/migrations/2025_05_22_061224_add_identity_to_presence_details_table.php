<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            $table->string('identity_number')->nullable()->after('instansi'); // Untuk NIK atau Paspor
            $table->string('identity_type')->nullable()->after('identity_number'); // Jenis: NIK/Paspor
        });
    }

    public function down(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            $table->dropColumn(['identity_number', 'identity_type']);
        });
    }
};