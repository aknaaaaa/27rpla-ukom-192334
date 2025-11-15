<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kamar';
    protected $fillable = [
        'nama_kamar',
        'harga_permalam',
        'ukuran_kamar',
        'deskripsi',
        'gambar',
        'status_kamar',
    ];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_kamar', 'id_kamar');
    }
}

