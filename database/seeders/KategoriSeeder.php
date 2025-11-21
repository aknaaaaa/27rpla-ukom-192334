<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
public function run()
{
$kategori = [
    ['nama_kategori' => 'Tipe Kasur'],
    ['nama_kategori' => 'Tipe Kapasitas'],
    ['nama_kategori' => 'Tipe Kamar'],
];

DB::table('kategori')->insert($kategori);

// Ambil ID kategori
$kasurId     = DB::table('kategori')->where('nama_kategori', 'Tipe Kasur')->first()->id_kategori;
$kapasitasId = DB::table('kategori')->where('nama_kategori', 'Tipe Kapasitas')->first()->id_kategori;
$kamarId     = DB::table('kategori')->where('nama_kategori', 'Tipe Kamar')->first()->id_kategori;

// Insert item
DB::table('kategori_items')->insert([
    ['id_kategori' => $kasurId, 'name' => 'Single'],
    ['id_kategori' => $kasurId, 'name' => 'Double'],
    ['id_kategori' => $kasurId, 'name' => 'Twin'],
    ['id_kategori' => $kasurId, 'name' => 'King'],
    ['id_kategori' => $kasurId, 'name' => 'Suite'],
    ['id_kategori' => $kasurId, 'name' => 'Superior'],

    ['id_kategori' => $kapasitasId, 'name' => '1 Orang'],
    ['id_kategori' => $kapasitasId, 'name' => '2 Orang'],
    ['id_kategori' => $kapasitasId, 'name' => '4 Orang'],

    ['id_kategori' => $kamarId, 'name' => 'Family Room'],
    ['id_kategori' => $kamarId, 'name' => 'Ruang Terhubung'],
]);
}}

