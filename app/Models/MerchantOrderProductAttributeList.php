<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantOrderProductAttributeList extends Model
{
    protected $table = 'merchant_order_product_attribute_list';

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
    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
