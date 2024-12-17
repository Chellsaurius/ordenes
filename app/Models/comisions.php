<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class comisions extends Model
{
    use HasFactory;

    protected $primaryKey = 'comision_id';

    public function RCU() : BelongsToMany {
        return $this->belongsToMany(User::class, 'records', 'comision_id', 'user_id');
    }

    // public function RComRecords()
    // {
    //     return $this->hasMany(records::class, 'comision_id', 'comision_id');
    // }

    // public function RComParties()    ya no pertenece una comisión a un partido
    // {
    //     return $this->belongsTo(parties::class, 'party_id', 'party_id');
    // }

    public function RComOrders()
    {
        return $this->hasMany( orders::class, 'comision_id', 'comision_id');
    }

    public function RComRecords()
    {
        return $this->hasMany(records::class, 'comision_id', 'comision_id')->where('record_status', 1)->orderBy('position_id');
    }
}
