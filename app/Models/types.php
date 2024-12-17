<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class types extends Model
{
    use HasFactory;

    protected $primaryKey = 'type_id';

    public function RTypesOrders()
    {
        return $this->hasMany(orders::class, 'type_id', 'type_id');
    }
}
