<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryItem;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    public function items()
    {
        return $this->hasMany(CategoryItem::class, 'category_id');
    }
}
