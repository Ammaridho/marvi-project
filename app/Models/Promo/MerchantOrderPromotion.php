<?php

namespace App\Models\Promo;

use Illuminate\Database\Eloquent\Model;

class MerchantOrderPromotion extends Model
{

    protected $table = 'merchant_order_promotion';

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
    const UPDATED_AT = null;

    public function promotionCode()
    {
        return $this->hasMany(PromotionCode::class);
    }
}
