<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->string('kode_reservasi')->unique();
            $table->string('jenis_acara')->nullable();
            $table->string('detail_acara')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_acara');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->string('status_reservasi')->default('Pending');
            $table->foreignId('id_akun')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};