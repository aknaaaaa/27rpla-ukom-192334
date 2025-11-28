<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class KategoriDanFasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Kategori
        $standar = Kategori::create(['name' => 'Standar']);
        $superior = Kategori::create(['name' => 'Superior']);
        $deluxe = Kategori::create(['name' => 'Deluxe']);
        $suite = Kategori::create(['name' => 'Suite']);

        // Fasilitas untuk Standar
        $fasilitasStandar = [
            ['nama_fasilitas' => 'Sarapan', 'deskripsi' => 'Sarapan pagi gratis'],
            ['nama_fasilitas' => 'Tanpa Sarapan', 'deskripsi' => 'Kamar tanpa fasilitas sarapan'],
            ['nama_fasilitas' => 'WiFi Gratis', 'deskripsi' => 'Internet berkecepatan tinggi'],
            ['nama_fasilitas' => 'AC', 'deskripsi' => 'Pendingin ruangan'],
            ['nama_fasilitas' => 'TV LED', 'deskripsi' => 'Televisi LED 32 inch'],
        ];

        foreach ($fasilitasStandar as $fasilitas) {
            Fasilitas::create([
                'id_kategori' => $standar->id,
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'deskripsi' => $fasilitas['deskripsi'],
            ]);
        }

        // Fasilitas untuk Superior
        $fasilitasSuperior = [
            ['nama_fasilitas' => 'Sarapan', 'deskripsi' => 'Sarapan pagi gratis'],
            ['nama_fasilitas' => 'Tanpa Sarapan', 'deskripsi' => 'Kamar tanpa fasilitas sarapan'],
            ['nama_fasilitas' => 'WiFi Gratis', 'deskripsi' => 'Internet berkecepatan tinggi'],
            ['nama_fasilitas' => 'AC', 'deskripsi' => 'Pendingin ruangan'],
            ['nama_fasilitas' => 'TV LED', 'deskripsi' => 'Televisi LED 42 inch'],
            ['nama_fasilitas' => 'Kamar Mandi Besar', 'deskripsi' => 'Bathroom dengan bathtub'],
        ];

        foreach ($fasilitasSuperior as $fasilitas) {
            Fasilitas::create([
                'id_kategori' => $superior->id,
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'deskripsi' => $fasilitas['deskripsi'],
            ]);
        }

        // Fasilitas untuk Deluxe
        $fasilitasDeluxe = [
            ['nama_fasilitas' => 'Sarapan', 'deskripsi' => 'Sarapan pagi gratis'],
            ['nama_fasilitas' => 'Tanpa Sarapan', 'deskripsi' => 'Kamar tanpa fasilitas sarapan'],
            ['nama_fasilitas' => 'WiFi Gratis', 'deskripsi' => 'Internet berkecepatan tinggi'],
            ['nama_fasilitas' => 'AC Premium', 'deskripsi' => 'Pendingin ruangan premium'],
            ['nama_fasilitas' => 'TV Plasma', 'deskripsi' => 'Televisi Plasma 50 inch'],
            ['nama_fasilitas' => 'Mini Bar', 'deskripsi' => 'Minuman dan snack premium'],
            ['nama_fasilitas' => 'Kamar Mandi Besar', 'deskripsi' => 'Bathroom dengan bathtub mewah'],
            ['nama_fasilitas' => 'Balkon Pribadi', 'deskripsi' => 'Balkon dengan pemandangan kota'],
        ];

        foreach ($fasilitasDeluxe as $fasilitas) {
            Fasilitas::create([
                'id_kategori' => $deluxe->id,
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'deskripsi' => $fasilitas['deskripsi'],
            ]);
        }

        // Fasilitas untuk Suite
        $fasilitasSuite = [
            ['nama_fasilitas' => 'Sarapan', 'deskripsi' => 'Sarapan pagi gratis premium'],
            ['nama_fasilitas' => 'Tanpa Sarapan', 'deskripsi' => 'Kamar tanpa fasilitas sarapan'],
            ['nama_fasilitas' => 'WiFi Gratis', 'deskripsi' => 'Internet berkecepatan tinggi'],
            ['nama_fasilitas' => 'AC Premium', 'deskripsi' => 'Pendingin ruangan kontrol suhu'],
            ['nama_fasilitas' => 'TV Plasma', 'deskripsi' => 'Televisi Plasma 60 inch'],
            ['nama_fasilitas' => 'Mini Bar Lengkap', 'deskripsi' => 'Bar lengkap dengan wine dan spirits'],
            ['nama_fasilitas' => 'Jacuzzi', 'deskripsi' => 'Bathtub dengan jet air panas'],
            ['nama_fasilitas' => 'Balkon Pribadi', 'deskripsi' => 'Balkon luas dengan pemandangan terbaik'],
            ['nama_fasilitas' => 'Living Room', 'deskripsi' => 'Ruang tamu terpisah yang nyaman'],
            ['nama_fasilitas' => 'Concierge Service', 'deskripsi' => 'Layanan personal asisten 24 jam'],
        ];

        foreach ($fasilitasSuite as $fasilitas) {
            Fasilitas::create([
                'id_kategori' => $suite->id,
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'deskripsi' => $fasilitas['deskripsi'],
            ]);
        }
    }
}
