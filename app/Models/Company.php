<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
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

    public function users()
    {
        return $this->belongsToMany(User::class,'user_companies');
    }

    /**
     * Get merchant info by code, cache enabled
     * @param $code
     * @return mixed
     */
    public static function getByCode($code) {
        return Cache::get('mcode-'. $code, function() use($code) {
            return static::where('code',$code)->first();
        });
    }

    public function brand()
    {
        return $this->hasMany(Brand::class);
    }
}
