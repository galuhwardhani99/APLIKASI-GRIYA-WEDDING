<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi_layanans', function (Blueprint $table) {
            $table->foreignId('id_reservasi')->constrained('reservasi', 'id_reservasi')->cascadeOnDelete();
            $table->foreignId('id_layanan')->constrained('layanans', 'id_layanan')->cascadeOnDelete();
            $table->string('nama_layanan');
            $table->unsignedBigInteger('harga_layanan');
            $table->timestamps();
            $table->primary(['id_reservasi', 'id_layanan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_layanans');
    }
};
