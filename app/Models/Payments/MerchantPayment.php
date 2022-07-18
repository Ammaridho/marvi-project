<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Assigned merchant method resides here
 */
class MerchantPayment extends Model
{
    protected $table = 'merchant_payments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
     * Get all payment method, cacheable
     * @return mixed
     */
    public static function getByMerchant($merchantId) {
        return Cache::get('allMPaymentM-' . $merchantId, function() use($merchantId) {
            return static::where('merchant_id',$merchantId)->get();
        });
    }

    /**
     * Get by id
     * @return mixed
     */
    public static function getById($id) {
        return static::where('id',$id)->first();
    }
}
