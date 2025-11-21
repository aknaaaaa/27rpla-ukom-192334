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
    Schema::create('pemesanan_kamar', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pemesanan_id')->constrained('pemesanan')->cascadeOnDelete();
        $table->foreignId('kamar_id')->constrained('kamar')->cascadeOnDelete();
        $table->integer('jumlah_kamar');
        $table->integer('harga_per_malam');
        $table->integer('total_harga');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemsanan_kamar');
    }
};
