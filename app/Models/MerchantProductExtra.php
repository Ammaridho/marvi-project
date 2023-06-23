<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantProductExtra extends Model
{
    public $timestamps = false;

    public function merchantProduct()
    {
        return $this->belongsTo(MerchantProduct::class);
    }
}
