<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Merchant extends Model
{
    public function extraAttribute()
    {
        return $this->belongsTo(ExtraAttribute::class);
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
}
