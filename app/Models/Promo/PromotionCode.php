<?php

namespace App\Models\Promo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionCode extends Model
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

    public function promotion()
    {
        return $this->hasMany(Promotion::class);
    }

    public function merchantOrderPromotion()
    {
        return $this->belongsTo(MerchantOrderPromotion::class);
    }
}
