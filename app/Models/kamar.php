<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kamar extends Model
{
    protected $table = 'kamars';
    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'nama_kamar',
        'kategori',
        'id_kategori',
        'harga_permalam',
        'ukuran_kamar',
        'kapasitas',
        'deskripsi',
        'gambar',
        'status_kamar',
        'stok',
    ];

    protected $casts = [
        'harga_permalam' => 'float',
    ];

    /**
     * Relasi ke kategori
     */
    public function kategoriRelasi(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    /**
     * Relasi ke fasilitas
     */
    public function fasilitas(): HasMany
    {
        return $this->hasMany(Fasilitas::class, 'id_kamar', 'id_kamar');
    }
}
