<?php

namespace App\Mail\Payload;

/**
 * Holds information on failed Order
 */
class FailedOrderMailPayload
{
    public $merchant;
    public $merchantCode;
    public $name;
    public $orderNumber;
    public $urlBuy;
}
