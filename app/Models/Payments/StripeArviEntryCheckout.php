<?php

namespace App\Models\Payments;

/**
 * Stripe Arivi Checkout payload
 */
class StripeArviEntryCheckout
{
    public $name;
    public $description;
    public $images = NULL;
    public $sku = NULL;
    public $metadata = array();
    public $unitAmountDecimalInCents = 100; //default: means 1 dollar
    public $quantity = 1;

}
