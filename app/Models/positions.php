<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class positions extends Model
{
    use HasFactory;

    protected $primaryKey = 'position_id';

    public function RPU() : BelongsToMany{
        return $this->belongsToMany( User::class, 'records', 'user_id', 'position_id' );
    }

    // public function RPosUsers()
    // {
    //     return $this->hasMany(comisions::class, 'position_id', 'position_id');
    // }

    public function RPosRecords()
    {
        return $this->hasMany(records::class, 'position_id', 'position_id');
    }
}
