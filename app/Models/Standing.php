<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $primaryKey = 'standing_id';

    public function RStanPending()
    {
        return $this->hasMany(Pending::class, 'standing_id', 'standing_id');
    }
}
