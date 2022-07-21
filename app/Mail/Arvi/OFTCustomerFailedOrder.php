<?php

namespace App\Mail\Arvi;

use App\Mail\Payload\FailedOrderMailPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Email that will be sent out when fail purchase happened
 *
 */
class OFTCustomerFailedOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FailedOrderMailPayload $details)
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
            //config('mail.from.name') . ' ' . trans('otf.email.sender')
            config('mail.from.name')
        )->subject(
            trans('otf.email.failed.subject',
                ['merchant' => $this->details->merchant,
                    'order' => $this->details->orderNumber]
            )
        )->view('arvi.email.mail-fail')
        ->with([
            'merchant'      => $this->details->merchant,
            'name'          => $this->details->name,
            'orderNumber'   => $this->details->orderNumber,
            'urlBuy'        => url('/m/' . $this->details->merchantCode),
        ])
        ;
    }
}
