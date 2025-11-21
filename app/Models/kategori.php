<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // jika tabelnya categories


    public function items()
    {
        return $this->hasMany(CategoryItem::class);
    }
}

