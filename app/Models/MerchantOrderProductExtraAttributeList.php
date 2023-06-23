<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantOrderProductExtraAttributeList extends Model
{
    protected $table = 'merchant_order_product_extra_attribute_list';

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

    public function merchantOrderDetail()
    {
        return $this->belongsTo(MerchantOrderDetail::class);
    }

    public function merchantExtraAttribute()
    {
        return $this->belongsTo(MerchantExtraAttribute::class);
    }

    public function BrandExtraAttribute()
    {
        return $this->belongsTo(brandExtraAttribute::class);
    }
    
}
