<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Merchant defined delivery
 */
class MerchantDefinedDelivery extends Model
{
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get defined delivery based on merchant_d
     * @param $merchantId
     * @return mixed
     */
    public static function getByMerchantId($merchantId) {
        return Cache::get('mdefd-'. $merchantId, function() use($merchantId) {
            return static::where('merchant_id',$merchantId)->get();
        });
    }
}
