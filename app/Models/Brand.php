<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
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

    

    public function users()
    {
        return $this->belongsToMany(User::class,'user_brands');
    }

    public function brandSocialReference()
    {
        return $this->hasMany(BrandSocialReference::class);
    }

    public function brandExtraAttribute()
    {
        return $this->hasMany(BrandExtraAttribute::class);
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class,'brand_fee_list')
        ->withPivot('create_time');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function merchant()
    {
        return $this->hasMany(Merchant::class);
    }
}
