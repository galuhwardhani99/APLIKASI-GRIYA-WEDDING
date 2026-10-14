<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ganti 'reservasis' menjadi 'reservasi'
        Schema::table('reservasi', function (Blueprint $table) {
            $table->text('bukti_transfer')->nullable()->after('status_reservasi');
        });
    }

    public function down(): void
    {
        // Ganti 'reservasis' menjadi 'reservasi'
        Schema::table('reservasi', function (Blueprint $table) {
            $table->dropColumn('bukti_transfer');
        });
    }
};