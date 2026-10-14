<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('jadwal_acaras', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_reservasi')->constrained('reservasi', 'id_reservasi')->onDelete('cascade');
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('status_validasi', 50)->default('Menunggu Validasi');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('jadwal_acaras');
        Schema::enableForeignKeyConstraints();
    }
};