<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantExtraAttribute extends Model
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

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function merchantOrderProductExtraAttributeList()
    {
        return $this->hasMany(MerchantOrderProductExtraAttributeList::class);
    }

    public function merchantProduct()
    {
        return $this->belongsTo(MerchantProduct::class,'merchant_extra_attribute_list')
        ->withPivot('create_time');
    }
}
