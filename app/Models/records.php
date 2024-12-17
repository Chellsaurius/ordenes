<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class records extends Model
{
    use HasFactory;

    protected $primaryKey = 'record_id';

    public function RUserRecords()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function RComRecords()
    {
        return $this->belongsTo(comisions::class, 'comision_id', 'comision_id');
    }

    public function RPosRecords()
    {
        return $this->belongsTo(positions::class, 'position_id', 'position_id');
    }

}
