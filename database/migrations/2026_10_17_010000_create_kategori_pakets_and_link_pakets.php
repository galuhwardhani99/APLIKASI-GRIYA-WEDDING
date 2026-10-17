<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori')->unique();
            $table->timestamps();
        });

        DB::table('pakets')->select('kategori')->distinct()->orderBy('kategori')->get()->each(function ($row) {
            DB::table('kategori_pakets')->insert([
                'nama_kategori' => $row->kategori,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        Schema::table('pakets', function (Blueprint $table) {
            $table->foreignId('kategori_paket_id')->nullable()->after('kategori')->constrained('kategori_pakets')->restrictOnDelete();
        });

        DB::table('pakets')->select('kategori')->distinct()->orderBy('kategori')->get()->each(function ($row) {
            $kategoriId = DB::table('kategori_pakets')->where('nama_kategori', $row->kategori)->value('id');
            DB::table('pakets')->where('kategori', $row->kategori)->update(['kategori_paket_id' => $kategoriId]);
        });

        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->string('kategori')->nullable();
        });

        DB::table('pakets')->select('id', 'kategori_paket_id')->get()->each(function ($paket) {
            $namaKategori = DB::table('kategori_pakets')->where('id', $paket->kategori_paket_id)->value('nama_kategori');
            DB::table('pakets')->where('id', $paket->id)->update(['kategori' => $namaKategori]);
        });

        Schema::table('pakets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_paket_id');
        });

        Schema::dropIfExists('kategori_pakets');
    }
};
