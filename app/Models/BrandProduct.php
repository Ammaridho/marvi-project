<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandProduct extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The name of the "deleted at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';
    
    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'create_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = 'update_time';

    public function brandImage()
    {
        return $this->hasMany(BrandImage::class);  //one to many
    }

    public function brandProductExtra()
    {
        return $this->hasMany(BrandProductExtra::class);
    }

    public function brandCategories()
    {
        return $this->belongsToMany(BrandCategory::class,'brand_category_list')->withPivot('create_time');
    }

    public function brandExtraAttributes()
    {
        return $this->belongsToMany(BrandExtraAttribute::class,'brand_extra_attribute_list')->withPivot('create_time');
    }

    public function brandProductAttributes()
    {
        return $this->hasMany(BrandProductAttribute::class);
    }

    public function brandProductVariants()
    {
        return $this->hasMany(BrandProductVariant::class);
    }
}
