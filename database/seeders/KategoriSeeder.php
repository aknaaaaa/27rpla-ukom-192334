<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
public function run()
{
    $kategori = [
        ['name' => 'Tipe Kasur'],
        ['name' => 'Tipe Kapasitas'],
        ['name' => 'Tipe Kamar'],
    ];

    DB::table('categories')->insert($kategori);

    // Ambil ID setelah insert
    $kasurId     = DB::table('categories')->where('name', 'Tipe Kasur')->first()->id;
    $kapasitasId = DB::table('categories')->where('name', 'Tipe Kapasitas')->first()->id;
    $kamarId     = DB::table('categories')->where('name', 'Tipe Kamar')->first()->id;

    // Insert isi kategori
    DB::table('category_items')->insert([
        ['category_id' => $kasurId, 'name' => 'Single'],
        ['category_id' => $kasurId, 'name' => 'Double'],
        ['category_id' => $kasurId, 'name' => 'Twin'],
        ['category_id' => $kasurId, 'name' => 'King'],
        ['category_id' => $kasurId, 'name' => 'Suite'],
        ['category_id' => $kasurId, 'name' => 'Superior'],

        ['category_id' => $kapasitasId, 'name' => '1 Orang'],
        ['category_id' => $kapasitasId, 'name' => '2 Orang'],
        ['category_id' => $kapasitasId, 'name' => '4 Orang'],

        ['category_id' => $kamarId, 'name' => 'Family Room'],
        ['category_id' => $kamarId, 'name' => 'Ruang Terhubung'],
    ]);
}
}

