<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rols extends Model
{
    use HasFactory;

    protected $primaryKey = 'rol_id';

    public function RRolUsers()
    {
        return $this->hasMany(comisions::class, 'rol_id', 'rol_id');
    }
}
