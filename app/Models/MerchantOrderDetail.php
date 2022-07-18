<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantOrderDetail extends Model
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

    public function merchantOrder()
    {
        return $this->belongsTo(MerchantOrder::class);
    }
}
