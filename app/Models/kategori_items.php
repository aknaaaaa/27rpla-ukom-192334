<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $table = 'category_items'; // sesuaikan nama tabelnya
    protected $primaryKey = 'id_category_item'; // kalau pakai PK ini

    protected $fillable = [
        'category_id',
        'name'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
}
