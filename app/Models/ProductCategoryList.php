<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryList extends Model
{
    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class);
    }
    public function merchantProduct()
    {
        return $this->hasMany(MerchantProduct::class);
    }
}
