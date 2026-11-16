<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasi_layanans', function (Blueprint $table) {
            $table->text('catatan_layanan')->nullable()->after('harga_layanan');
        });
    }

    public function down(): void
    {
        Schema::table('reservasi_layanans', function (Blueprint $table) {
            $table->dropColumn('catatan_layanan');
        });
    }
};
