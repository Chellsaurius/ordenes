<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parties extends Model
{
    use HasFactory;

    protected $primaryKey = 'party_id';

    protected $fillable = [
        'party_icon',
        'party_iconPath'
    ];

    public function RPartyUsers()
    {
        return $this->hasMany(parties::class, 'party_id', 'party_id');
    }
}
