<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificates extends Model
{
    use HasFactory;

    protected $primaryKey = 'certificate_id';

    public function RCerOrder(): HasOne {
        return $this->hasOne(orders::class, 'order_id', 'order_id');
    }
}
