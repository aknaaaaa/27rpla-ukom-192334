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

    // Kolom FK harus dibuat terlebih dahulu
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('kamar_id');

    // FK user → user.id_user
    $table->foreign('user_id')
          ->references('id_user')
          ->on('user')
          ->cascadeOnDelete();

    // FK kamar → kamars.id_kamar
    $table->foreign('kamar_id')
          ->references('id_kamar')
          ->on('kamars')
          ->cascadeOnDelete();

    $table->integer('jumlah_kamar')->default(1);
    $table->integer('harga_saat_ini'); 
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
