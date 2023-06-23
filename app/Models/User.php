<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $dates = ['deleted_at'];

    /**
     * The name of the "deleted at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';
    
    public function companies()
    {
        return $this->belongsToMany(Company::class,'user_companies')->withPivot('create_time');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class,'user_brands')->withPivot('create_time');
    }

    public function merchantOrder()
    {
        return $this->hasMany(MerchantOrder::class);
    }

}
