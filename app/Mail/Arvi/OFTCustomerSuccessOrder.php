<?php

namespace App\Mail\Arvi;

use App\Mail\Payload\SuccessOrderMailPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OFTCustomerSuccessOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SuccessOrderMailPayload $details)
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
        )->subject(
            trans('otf.email.success.subject',
                ['merchant' => $this->details->merchant,
                    'order' => $this->details->orderNumber])
        )->view('arvi.email.mail-success')
            ->with([
                'merchant'          => $this->details->merchant,
                'name'              => $this->details->name,
                'email'             => $this->details->email,
                'telephone'         => $this->details->telephone,
                'orderNumber'       => $this->details->orderNumber,
                'urlBuy'            => url('/m/' . $this->details->merchantCode),
                'paymentMethod'     => $this->details->paymentMethod,
                'paymentProvider'   => $this->details->paymentProvider,
                'products'          => $this->details->products,
            ])
            ;

    }
}
