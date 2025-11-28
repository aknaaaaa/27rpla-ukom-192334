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
            // Make kategori nullable since we want to drop it later
            $table->string('kategori')->nullable()->change();
            // Drop stok_kamar column if it exists (we're using stok instead)
            if (Schema::hasColumn('kamars', 'stok_kamar')) {
                $table->dropColumn('stok_kamar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            $table->string('kategori')->nullable(false)->change();
            $table->integer('stok_kamar')->default(0);
        });
    }
};
