<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    use HasFactory;

    protected $primaryKey = 'pending_id';

    public function RStanPending(){
        return $this->belongsTo( Standing::class, 'standing_id', 'standing_id' );
    }

    public function ROrdPendings(){
        return $this->belongsTo( orders::class, 'order_id', 'order_id' );
    }
}
