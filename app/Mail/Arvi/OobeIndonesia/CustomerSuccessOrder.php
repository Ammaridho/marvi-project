<?php

namespace App\Mail\Arvi\OobeIndonesia;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSuccessOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        )
        ->view('arvi.email.oobe-indonesia.email-success')
        ->with([
            'orderNumber'       => $this->details->orderNumber,
            'merchant'          => $this->details->merchant,
            'name'              => $this->details->name,
            'order_date'        => $this->details->order_date,
            'products'          => $this->details->products,
            'paymentMethod'     => $this->details->paym,
            'email'             => $this->details->email,
            'mobile_number'     => $this->details->mobile_number,
            'fees'              => $this->details->fees,
            'currency'          => $this->details->currency,
            'deliveryName'      => $this->details->deliveryName,
            'subDeliveryName'   => $this->details->subDeliveryName,
            'cost_delivery'     => $this->details->cost_delivery,
            'recepient_address' => $this->details->recepient_address,
            'recepient_notes'   => $this->details->recepient_notes,
            'totalPrice'        => $this->details->totalPrice,
            'custAddress'       => $this->details->custAddress,
            'custSubdistrict'   => $this->details->custSubdistrict,
            'custDistrict'      => $this->details->custDistrict,
            'custCity'          => $this->details->custCity,
            'custProvince'      => $this->details->custProvince,
            'storeBuildingSuite'=> $this->details->storeBuildingSuite,
            'storeAddress'      => $this->details->storeAddress,
            'storeCity'         => $this->details->storeCity,
            'storeState'        => $this->details->storeState,
        ]);
    }
}
