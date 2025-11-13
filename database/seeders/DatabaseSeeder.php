<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan data role terlebih dahulu
        DB::table('roles')->insert([
            'id_role' => 1,
            'nama_role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Setelah itu, tambahkan user
        DB::table('user')->insert([
            'id_role' => 1, // FK ke tabel roles
            'nama_user' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '08123456789',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
