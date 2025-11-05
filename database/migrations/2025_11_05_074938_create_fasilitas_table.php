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
            $table->foreignId('id_kategori')
                  ->constrained('kategoris', 'id_kategori')
                  ->cascadeOnDelete();
            $table->foreignId('id_kamar')
                  ->nullable()
                  ->constrained('kamars', 'id_kamar')
                  ->cascadeOnDelete();
            $table->string('nama_fasilitas', 100);
            $table->decimal('nilai_fasilitas', 12, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
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
