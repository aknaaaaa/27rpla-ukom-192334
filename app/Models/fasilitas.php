<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'id_kategori',
        'id_kamar',
        'nama_fasilitas',
        'nilai_fasilitas',
        'deskripsi',
    ];

    /**
     * Relasi ke kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    /**
     * Relasi ke kamar
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }
}
