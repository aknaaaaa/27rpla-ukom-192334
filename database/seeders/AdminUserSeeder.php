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
            ],
            ['email' => 'admin2@gmail.com'], // kunci unik
            [
                'nama_user' => 'Admin2',
                'phone_number' => '082113750847',
                'password' => Hash::make('password_admin2'),
                'id_role' => 1, // kalau ada
            ]
        );
    }
}
