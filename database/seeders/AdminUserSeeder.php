<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // kunci unik
            [
                'nama_user' => 'Admin',
                'phone_number' => '089529622167',
                'password' => Hash::make('password_admin'),
                'id_role' => 1, // kalau ada
            ]
        );
    }
}
