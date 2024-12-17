<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contents extends Model
{
    use HasFactory;

    protected $primaryKey = 'content_id';

    public function ROrdContent()
    {
        return $this->belongsTo(orders::class, 'order_id', 'order_id');
    }

    public function RConSubcontent()
    {
        return $this->hasMany(subcontent::class, 'content_id', 'content_id')->where('subcontent_status', 1);
    }
}
