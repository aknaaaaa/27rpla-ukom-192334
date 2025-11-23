<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamars';
    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'nama_kamar',
        'kategori',
        'harga_permalam',
        'ukuran_kamar',
        'deskripsi',
        'gambar',
        'status_kamar',
    ];

    protected $casts = [
        'harga_permalam' => 'float',
    ];
}
