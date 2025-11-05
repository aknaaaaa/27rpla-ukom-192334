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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_pemesanan')
                  ->constrained('pemesanans', 'id_pemesanan')
                  ->cascadeOnDelete();
            $table->string('payment_method', 50);
            $table->date('payment_date');
            $table->decimal('amount_paid', 12, 2);
            $table->enum('status_pembayaran', ['Belum dibayar', 'Telah dibayar', 'Dibatalkan'])
                  ->default('Belum dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
