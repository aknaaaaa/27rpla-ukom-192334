<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayarans', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('id_pemesanan');
            }
            if (!Schema::hasColumn('pembayarans', 'payment_date')) {
                $table->date('payment_date')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('pembayarans', 'amount_paid')) {
                $table->decimal('amount_paid', 15, 2)->default(0)->after('payment_date');
            }
            if (!Schema::hasColumn('pembayarans', 'status_pembayaran')) {
                $table->string('status_pembayaran')->default('Belum dibayar')->after('amount_paid');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_date', 'amount_paid', 'status_pembayaran']);
        });
    }
};
