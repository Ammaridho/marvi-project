<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArviDelivery extends Model
{
    const ARVI = 4;

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

    /**
     * Get all delivery method, cacheable
     * @return mixed
     */
    public static function getAll() {
        return Cache::get('allDelivery', function() {
            return static::all();
        });
    }

    public function arviSubDelivery()
    {
        return $this->hasMany(ArviSubDelivery::class);
    }
}
