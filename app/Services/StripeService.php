<?php namespace App\Services;

use App\Models\MerchantOrder;
use App\Models\Payments\MerchantStripeSession;
use App\Models\Payments\StripeArviCheckout;
use Carbon\Carbon;

/**
 * Stripe Service, based on:
 * https://stripe.com/docs/checkout/quickstart
 *
 * @package App\Utils
 */
class StripeService
{
    /**
     * Take me to stripe. This will initiate session to stripe
     * and redirect to them
     *
     * https://stripe.com/docs/api/checkout/sessions/object
     *
     */
    public function takeMeToStripe(StripeArviCheckout &$payload){
        \Stripe\Stripe::setApiKey(config('services.stripe.key'));
        header('Content-Type: application/json');

        
        $cancelUrl = route('stripe-failed-flavar',['arviSessionId' => $payload->arviSessionId,'cancelUrl' => $payload->cancelUrl]);
        $successUrl = route('stripe-success-flavar',['arviSessionId' => $payload->arviSessionId,'successUrl' => $payload->successUrl]);

        if ( sizeof($payload->entries) < 1) {
            \Log::error("Can't process payment, payload data is empty. SessionId: " . $payload->arviSessionId);
            //return redirect($cancelUrl . '?err=missing-data');
            return $cancelUrl . '?err=missing-data';
        }

        \Log::info('>> Going to process: ' . json_encode($payload));

        $dataLines = array();
        // products cart
        foreach ($payload->entries as $entry) {

            $product_data = array(
                'name'          => $entry['product']['name'],
                'description'   => $entry['product']['description'],
            );
            $price_data = array(
                'currency'              => $payload->currency,
                'product_data'          => $product_data,
                'unit_amount_decimal'   => $entry['totalPricePerProduct']*100
            );
            $line_item = array(
                'price_data' => $price_data,
                'quantity'   => $entry['qty'],
            );
            $line_items[] = $line_item;
        }

        //Initiate to Stripe
        $basicData = [
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];
        if (isset($payload->email) && !empty($payload->email)) {
            $basicData['customer_email'] = $payload->email;
        }
        $checkout_session = \Stripe\Checkout\Session::create($basicData);

        $this->logEntryToDatabase($payload,$checkout_session->id,
            $checkout_session->mode, $checkout_session->customer_email,
            $checkout_session->amount_subtotal, $checkout_session->amount_total,
            $checkout_session->payment_link, $cancelUrl, $successUrl
        );

        $payload->sessionId = $checkout_session->id;
        $this->updateMerchantOrderSessionId($payload->arviSessionId, $payload->sessionId);

        // return redirect($checkout_session->url);
        return response()->json(['stripe_url'=>$checkout_session->url]);

        // SUDAH BISA MEMUNCULKAN LINK PEMBAYARAN
    }


    /**
     * Log entry to database
     * @param StripeArviCheckout $payload
     * @param $session_id
     * @param $mode
     * @param $customerEmail
     * @param $amountSubtotal
     * @param $amountTotal
     * @param $paymentLink
     * @param $cancelUrl string cancel url
     * @param $successUrl string  success url
     */
    function logEntryToDatabase(StripeArviCheckout $payload,
                                                   $session_id, $mode,$customerEmail,
                                                   $amountSubtotal, $amountTotal, $paymentLink,
                                                   $cancelUrl, $successUrl) {
        $sessDb = new MerchantStripeSession();
        $sessDb->merchant_id = $payload->merchantId;
        $sessDb->session_id = $session_id;
        $sessDb->update_time = Carbon::now();
        $sessDb->cancel_url = $cancelUrl;
        $sessDb->success_url = $successUrl;
        $sessDb->mode = $mode;
        $sessDb->customer_email = $customerEmail;
        $sessDb->amount_subtotal = $amountSubtotal;
        $sessDb->amount_total = $amountTotal;
        $sessDb->payment_link = $paymentLink;
        $sessDb->currency = $payload->currency;
        $sessDb->save();
    }


    /**
     * Update merchant order session id
     * @param $arviSessionId string arvi session id
     * @param $stripeSessionId string stripe session id
     */
    function updateMerchantOrderSessionId(string $arviSessionId, string $stripeSessionId) {
        $ex = MerchantOrder::getByArviSessionId($arviSessionId);
        if ($ex) {
            $ex->payment_session_id = $stripeSessionId;
            $ex->save();
        }
    }

    /**
     * Simple tool to generate Client Id
     */
    static function generateId() {
        return md5(rand(0,1000) . now());
    }

}
