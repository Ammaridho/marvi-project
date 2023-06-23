<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Merchant extends Model
{

    use SoftDeletes, HasApiTokens;

    protected $dates = ['deleted_at'];

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

    /**
     * The name of the "deleted at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';

    public function arviQrs()
    {
        return $this->hasMany(ArviQr::class);
    }

    public function merchantSocialReference()
    {
        return $this->hasMany(MerchantSocialReference::class);
    }

    public function merchantExtraAttribute()
    {
        return $this->belongsTo(MerchantExtraAttribute::class);
    }

    public function merchantDelivery()
    {
        return $this->hasMany(MerchantDelivery::class);
    }

    public function location()
    {
        return $this->belongsToMany(Location::class,'location_merchants')
        ->withPivot('create_time');
    }

    public function payment()
    {
        return $this->belongsToMany(ArviPaymentMethod::class,'merchant_payments')
        ->withPivot('create_time');
    }

    /**
     * Get defined delivery location
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function definedDeliveryLocation()
    {
        return $this->belongsTo(MerchantDefinedDelivery::class);
    }

    /**
     * Get merchant info by code, cache enabled
     * @param $code
     * @return mixed
     */
    public static function getByCode($code) {
        return Cache::get('mcode-'. $code, function() use($code) {
            return static::where('code',$code)->first();
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function merchantOrder()
    {
        return $this->hasMany(MerchantOrder::class);
    }
}
