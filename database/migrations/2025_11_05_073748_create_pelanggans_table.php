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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan');                           // PK: id_pelanggan
            $table->foreignId('id_role')                           // FK -> roles.id_role
                  ->constrained('roles', 'id_role')
                  ->cascadeOnDelete();
            $table->string('nama_pelanggan', 100);
            $table->string('email', 191)->unique();               // 191 aman utk index utf8mb4
            $table->string('phone_number', 20);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
