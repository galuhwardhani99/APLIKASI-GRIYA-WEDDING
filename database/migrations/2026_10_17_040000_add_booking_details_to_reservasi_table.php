<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('reservasi', 'id_paket')) {
            Schema::table('reservasi', fn (Blueprint $table) => $table->foreignId('id_paket')->nullable()->constrained('pakets')->nullOnDelete());
        }

        Schema::table('reservasi', function (Blueprint $table) {
            if (! Schema::hasColumn('reservasi', 'nama_paket')) $table->string('nama_paket')->nullable();
            if (! Schema::hasColumn('reservasi', 'harga_paket')) $table->unsignedBigInteger('harga_paket')->nullable();
            if (! Schema::hasColumn('reservasi', 'jumlah_pesanan')) $table->unsignedInteger('jumlah_pesanan')->default(1);
            if (! Schema::hasColumn('reservasi', 'waktu_mulai')) $table->time('waktu_mulai')->nullable();
            if (! Schema::hasColumn('reservasi', 'waktu_selesai')) $table->time('waktu_selesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            if (Schema::hasColumn('reservasi', 'id_paket')) $table->dropConstrainedForeignId('id_paket');
            $columns = array_filter(['nama_paket', 'harga_paket', 'jumlah_pesanan', 'waktu_mulai', 'waktu_selesai'], fn ($column) => Schema::hasColumn('reservasi', $column));
            if ($columns) $table->dropColumn($columns);
        });
    }
};
