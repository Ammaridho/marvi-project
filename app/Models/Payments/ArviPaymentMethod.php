<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Payment method resides here
 */
class ArviPaymentMethod extends Model
{
    const CC = 13;
    const DEBIT = 14;
    const TRANSFER = 15;
    const GOPAY = 21;
    const OVO = 22;

    /**
     * Get all payment method, cacheable
     * @return mixed
     */
    public static function getAll() {
        return Cache::get('allPaymentM', function() {
            return static::all();
        });
    }

    /**
     * Resolve name of id
     * @param $id
     */
    public static function resolveName($id) {
        $name = "UNKNOWN";
        switch ($id) {
            case 13:
                $name = "Credit Card";
                break;
            case 14:
                $name = "Debit Card";
                break;
            case 15:
                $name = "Transfer";
                break;
            case 21:
                $name = "GoPay";
                break;
            case 22:
                $name = "OVO";
                break;

        }
        return $name;
    }
}
