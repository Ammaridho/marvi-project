<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantImage extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The name of the "deleted at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';
}
