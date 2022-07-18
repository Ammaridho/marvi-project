<?php

namespace App\Models\Payments;

/**
 * Payment method resides here
 */
class ArviPaymentStatus
{
    const NEW = 0;
    const PAID = 1;
    const EXPIRED = 2;
    const FAILED = 4;


    /**
     * Resolve name of id
     * @param $id
     */
    public static function resolveName($id) {
        $name = "UNKNOWN";
        switch ($id) {
            case 1:
                $name = "Paid";
                break;
            case 2:
                $name = "Expired";
                break;
            case 4:
                $name = "Failed";
                break;
            default:
                $name = "New";
                break;

        }
        return $name;
    }
}
