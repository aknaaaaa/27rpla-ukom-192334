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
    Schema::create('pemesanan_fasilitas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pemesanan_kamar_id')->constrained('pemesanan_kamar')->cascadeOnDelete();
        $table->foreignId('fasilitas_id')->constrained('fasilitas')->cascadeOnDelete();
        $table->integer('jumlah');
        $table->integer('total_harga');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemsanan_fasilitas');
    }
};
