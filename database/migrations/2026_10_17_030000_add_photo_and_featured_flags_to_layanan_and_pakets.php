<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('deskripsi');
            $table->boolean('unggulan')->default(false)->after('foto');
        });

        Schema::table('pakets', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('deskripsi');
            $table->boolean('unggulan')->default(false)->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn(['foto', 'unggulan']);
        });

        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn(['foto', 'unggulan']);
        });
    }
};
