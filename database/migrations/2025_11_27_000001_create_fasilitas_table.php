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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_kamar')->nullable();
            $table->string('nama_fasilitas', 100);
            $table->string('nilai_fasilitas', 100)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_kamar')->references('id_kamar')->on('kamars')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
