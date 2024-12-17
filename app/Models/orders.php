<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    public function RComOrders() {
        return $this->belongsTo( comisions::class, 'comision_id', 'comision_id' );
    }

    public function ROrdContent()
    {
        return $this->hasMany( contents::class, 'order_id', 'order_id' );
    }

    public function RUserOrders() //primero va la llave local y después la foranea
    {
        return $this->belongsTo( User::class, 'order_createdBy', 'id' );
    }

    public function RTypesOrders(){
        return $this->belongsTo(types::class, 'type_id', 'type_id' );
    }

    public function ROrdPendings() {
        return $this->hasMany(Pending::class, 'order_id', 'order_id' );
    }
}
