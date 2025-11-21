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
    Schema::create('cart_item_fasilitas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cart_item_id')->constrained('cart_items')->cascadeOnDelete();
        $table->foreignId('fasilitas_id')->constrained('fasilitas')->cascadeOnDelete();
        $table->integer('jumlah')->default(1);
        $table->integer('harga_saat_ini');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_item_fasilitas');
    }
};
