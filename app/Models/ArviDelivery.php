<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ArviDelivery extends Model
{
    const ARVI = 4;

    /**
     * Get all delivery method, cacheable
     * @return mixed
     */
    public static function getAll() {
        return Cache::get('allDelivery', function() {
            return static::all();
        });
    }
}
