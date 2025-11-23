<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';      // atau nama tabel kamu
    protected $primaryKey = 'id_role';

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
