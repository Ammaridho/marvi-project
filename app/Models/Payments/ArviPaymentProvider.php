<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ArviPaymentProvider extends Model
{
    /* -- Preset Payment Provider -- */

    const UNKNOWN = 0;
    const STRIPE = 1;
    const DOKU = 2;
    const MIDTRANS = 3;
    const XENDIT = 4;

    /* -- End of preset Payment Provider -- */

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
     * Get all payment provider
     * @return mixed
     */
    public static function getAll() {
        return Cache::get('allPaymentProv', function() {
            return static::all();
        });
    }

    /**
     * Resolve name of
     * @param $id
     */
    public static function resolveName($id) {
        $name = "UNKNOWN";
        switch ($id) {
            case 1:
                $name = "Stripe";
                break;
            case 2:
                $name = "Doku";
                break;
            case 3:
                $name = "Midtrans";
                break;
            case 4:
                $name = "Xendit";
                break;

        }
        return $name;
    }
}
