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
Schema::create('cart', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')
          ->references('id_user')
          ->on('user')
          ->cascadeOnDelete();

    $table->date('tanggal_checkin');
    $table->date('tanggal_checkout');
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
