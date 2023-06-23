<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandProductExtra extends Model
{
    public $timestamps = false;

    public function brandProduct()
    {
        return $this->belongsTo(BrandProduct::class);
    }
}
