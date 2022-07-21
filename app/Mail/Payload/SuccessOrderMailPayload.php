<?php

namespace App\Mail\Payload;

/**
 * Holds information on success Order
 */
class SuccessOrderMailPayload
{
    public $merchant;
    public $merchantCode;
    public $name;
    public $telephone;
    public $email;
    public $orderNumber;
    public $urlBuy;
    public $products;
    public $paymentMethod;
    public $paymentProvider;
}
