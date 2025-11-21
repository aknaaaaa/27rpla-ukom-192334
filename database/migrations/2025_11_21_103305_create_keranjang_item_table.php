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
    Schema::create('cart_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cart_id')->constrained('cart')->cascadeOnDelete();
        $table->foreignId('kamar_id')->constrained('kamar')->cascadeOnDelete();
        $table->integer('jumlah_kamar')->default(1);
        $table->integer('harga_saat_ini'); // harga per malam saat dimasukkan
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_item');
    }
};
