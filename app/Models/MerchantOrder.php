<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Table that holds data transaction
 */
class MerchantOrder extends Model
{
    //public $timestamps = false;

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

    /**
     * Get current order by arvi session id
     * @param $arviSessId string arvi session id
     * @return mixed
     */
    public static function getByArviSessionId($arviSessId) {
        return static::where('arvi_session_id', $arviSessId)->first();
    }
}
