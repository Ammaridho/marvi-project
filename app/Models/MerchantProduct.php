<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantProduct extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'delete_time';
    protected $dates = ['delete_time'];

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
     * Get by Id
     * @param $id
     * @return mixed
     */
    public static function getById($id) {
        return static::where('id', $id)->first();
    }

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class,'product_category_list')
        ->withPivot('create_time');
    }
    
    public function brandCategories()
    {
        return $this->belongsToMany(BrandCategory::class,'product_category_list')
        ->withPivot('create_time');
    }

    public function merchantExtraAttributes()
    {
        return $this->belongsToMany(MerchantExtraAttribute::class,'merchant_extra_attribute_list')
        ->withPivot('create_time');
    }
    
    public function brandExtraAttributes()
    {
        return $this->belongsToMany(BrandExtraAttribute::class,'merchant_extra_attribute_list')
        ->withPivot('create_time');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function merchantProductVariants()
    {
        return $this->hasMany(MerchantProductVariant::class);
    }

    public function merchantInventory(Type $var = null)
    {
        return $this->hasOne(MerchantInventory::class);
    }

    public function merchantOrderDetail()
    {
        return $this->belongsTo(MerchantOrderDetail::class);
    }

    public function merchantProductExtra()
    {
        return $this->hasMany(MerchantProductExtra::class);
    }

}
