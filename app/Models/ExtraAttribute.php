<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraAttribute extends Model
{
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
