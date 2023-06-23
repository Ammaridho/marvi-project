<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Merchant defined delivery
 */
class MerchantDefinedDelivery extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The name of the "deleted at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';
    
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
