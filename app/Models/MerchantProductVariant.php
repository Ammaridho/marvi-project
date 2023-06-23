<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantProductVariant extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'delete_time';
    protected $dates = ['delete_time'];
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

    public function merchantProduct()
    {
        return $this->belongsTo(MerchantProduct::class);
    }
    
    public function merchantInventory()
    {
        return $this->hasOne(MerchantInventory::class);
    }
}
