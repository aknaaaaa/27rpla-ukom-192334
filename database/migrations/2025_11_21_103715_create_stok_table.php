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
Schema::create('kamar_ketersediaan', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('kamar_id');
    $table->foreign('kamar_id')
          ->references('id_kamar')
          ->on('kamars')
          ->cascadeOnDelete();

    $table->date('tanggal');
    $table->integer('jumlah_dipesan')->default(0);
    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
