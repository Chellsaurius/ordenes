<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcontent extends Model
{
    use HasFactory;

    protected $primaryKey = 'subcontent_id';

    public function RConSubcontent()
    {
        return $this->belongsTo(contents::class, 'content_id', 'content_id');
    }
}
