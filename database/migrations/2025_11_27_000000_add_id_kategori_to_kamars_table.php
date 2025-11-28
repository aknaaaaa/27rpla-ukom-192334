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
        Schema::table('kamars', function (Blueprint $table) {
            // Tambah kolom id_kategori jika belum ada
            if (!Schema::hasColumn('kamars', 'id_kategori')) {
                $table->unsignedBigInteger('id_kategori')->nullable()->after('nama_kamar');
                $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            if (Schema::hasColumn('kamars', 'id_kategori')) {
                $table->dropForeign(['id_kategori']);
                $table->dropColumn('id_kategori');
            }
        });
    }
};
