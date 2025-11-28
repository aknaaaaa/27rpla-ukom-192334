<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;

    /**
     * Relasi ke fasilitas
     */
    public function fasilitas(): HasMany
    {
        return $this->hasMany(Fasilitas::class, 'id_kategori', 'id');
    }
}
