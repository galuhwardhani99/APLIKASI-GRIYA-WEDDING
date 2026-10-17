<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            if (! Schema::hasColumn('reservasi', 'jenis_pesanan')) {
                $table->string('jenis_pesanan', 20)->default('paket');
            }
            if (! Schema::hasColumn('reservasi', 'id_layanan')) {
                $table->foreignId('id_layanan')->nullable()->constrained('layanans', 'id_layanan')->nullOnDelete();
            }
            if (! Schema::hasColumn('reservasi', 'nama_layanan')) {
                $table->string('nama_layanan')->nullable();
            }
            if (! Schema::hasColumn('reservasi', 'harga_layanan')) {
                $table->unsignedBigInteger('harga_layanan')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('reservasi', 'id_layanan')) {
            Schema::table('reservasi', fn (Blueprint $table) => $table->dropConstrainedForeignId('id_layanan'));
        }

        $columns = array_filter(['jenis_pesanan', 'nama_layanan', 'harga_layanan'], fn ($column) => Schema::hasColumn('reservasi', $column));
        if ($columns) {
            Schema::table('reservasi', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
