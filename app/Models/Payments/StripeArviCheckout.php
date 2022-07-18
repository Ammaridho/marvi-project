<?php

namespace App\Models\Payments;

/**
 * Stripe Arivi Checkout payload
 */
class StripeArviCheckout
{
    public $merchantId = 0;
    //default based on the area we operate
    public $currency = "SGD";
    public $arviSessionId;
    //Stripe session id
    public $sessionId;
    public $email = NULL;
    public $entries = array();
}
