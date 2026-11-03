<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            if (! Schema::hasColumn('reservasi', 'payment_order_id')) {
                $table->string('payment_order_id')->nullable()->unique()->after('bukti_transfer');
            }
            if (! Schema::hasColumn('reservasi', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('payment_order_id');
            }
            if (! Schema::hasColumn('reservasi', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        $columns = array_filter(['payment_order_id', 'payment_status', 'paid_at'], fn ($column) => Schema::hasColumn('reservasi', $column));
        if ($columns) {
            Schema::table('reservasi', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
