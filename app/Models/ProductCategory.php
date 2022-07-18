<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function productCategoryList()
    {
        return $this->belongsTo(ProductCategoryList::class);
    }

}
