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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->foreignId('id_kategori')                           // FK -> kategori.id_kategori
                  ->constrained('kategoris', 'id_kategori')
                  ->cascadeOnDelete();
            $table->string('nama_kamar', 100);
            $table->decimal('harga_permalam', 12, 2);
            $table->string('ukuran_kamar', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->enum('status_kamar', ['Tersedia', 'Telah di reservasi', 'Maintenance'])
                  ->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
