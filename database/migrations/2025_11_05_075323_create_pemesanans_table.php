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
    $table->id(); // PK = id

    $table->unsignedBigInteger('id_user');
    $table->foreign('id_user')
          ->references('id_user')
          ->on('user')
          ->cascadeOnDelete();

    $table->string('kode_pesanan')->unique();
    $table->date('tanggal_pemesanan');
    $table->date('tanggal_checkin');
    $table->date('tanggal_checkout');
    $table->string('status')->default('Menunggu');

    $table->string('nama_penginap')->nullable();
    $table->string('email_penginap')->nullable();
    $table->string('telepon_penginap')->nullable();

    $table->unsignedBigInteger('total_harga')->default(0);

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
