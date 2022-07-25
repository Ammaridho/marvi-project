<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantProduct extends Model
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * Get product image
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get product category list
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategoryList()
    {
        return $this->belongsTo(ProductCategoryList::class);
    }

    /**
     * Get by Id
     * @param $id
     * @return mixed
     */
    public static function getById($id) {
        return static::where('id', $id)->first();
    }

}
