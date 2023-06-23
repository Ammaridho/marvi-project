<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Table that holds data transaction
 */
class MerchantOrder extends Model
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

    public function merchantOrderDetail()
    {
        return $this->hasMany(MerchantOrderDetail::class);
    }

    public function arviPaymentMethod()
    {
        return $this->belongsTo(ArviPaymentMethod::class);
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class,'order_fee_list')
        ->withPivot('create_time');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get current order by arvi session id
     * @param $arviSessId string arvi session id
     * @return mixed
     */
    public static function getByArviSessionId($arviSessId) {
        return static::where('arvi_session_id', $arviSessId)->first();
    }
}
