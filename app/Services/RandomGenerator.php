<?php namespace App\Services;

/**
 * Generator uttility
 *
 * @package App\Utils
 */
class RandomGenerator
{

    /**
     * Generate Simple Random Code
     * @param int $length
     * @return string
     */
    public static function generateSimpleCode($length = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $_sequence = '';
        for ($i=1; $i<=5; $i++) {
            $char = '';
            for ($z=0; $z<1200; $z++) {
                //Not supported in PHP dev / prod :p
                $char = $chars[mt_rand(0, 61)];
            }
            $_sequence .= $char;
        }
        return substr(strtoupper($_sequence.rand()), 0, ($length < 4 ? 10 : $length));
    }
}
