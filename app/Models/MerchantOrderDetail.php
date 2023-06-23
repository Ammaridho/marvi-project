<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantOrderDetail extends Model
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

    public function merchantOrder()
    {
        return $this->belongsTo(MerchantOrder::class);
    }

    public function merchantProduct()
    {
        return $this->hasOne(MerchantProduct::class);
    }

    public function merchantOrderProductAttributeList()
    {
        return $this->hasMany(MerchantOrderProductAttributeList::class);
    }

    public function merchantOrderProductExtraAttributeList()
    {
        return $this->hasMany(MerchantOrderProductExtraAttributeList::class);
    }

}
