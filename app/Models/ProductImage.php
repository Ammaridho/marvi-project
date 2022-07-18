<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public function merchantProduct()
    {
        return $this->belongsTo(MerchantProduct::class);
    }
}
