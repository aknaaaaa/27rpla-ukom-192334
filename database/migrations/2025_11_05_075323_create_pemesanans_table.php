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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->foreignId('id_user')
                  ->constrained('user', 'id_user')
                  ->cascadeOnDelete();
            $table->foreignId('id_kamar')
                  ->constrained('kamars', 'id_kamar')
                  ->cascadeOnDelete();
            $table->string('booking_code', 20)->unique();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_hari');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
