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

        $cancelUrl = route('stripe-failed',['arviSessionId' => $payload->arviSessionId]);
        $successUrl = route('stripe-success',['arviSessionId' => $payload->arviSessionId]);

        if ( sizeof($payload->entries) < 1) {
            \Log::error("Can't process payment, payload data is empty. SessionId: " . $payload->arviSessionId);
            //return redirect($cancelUrl . '?err=missing-data');
            return $cancelUrl . '?err=missing-data';
        }

        \Log::info('>> Going to process: ' . json_encode($payload));

        $dataLines = array();
        foreach ($payload->entries as $entry) {
            $p = array(
                'name'          => $entry->name,
                'description'   => $entry->description,
            );
            if (is_array($entry->images) && sizeof($entry->images) > 0) {
                $imgs = array();
                for($i = 0; $i < sizeof($entry->images); $i++) {
                    $imgs[$i] = $entry->images[$i];
                }
                $p['images'] = $imgs;
            }
            $mm = array();
            if (!empty($entry->sku)) {
                $mm['sku'] = $entry->sku;
            }
            if (is_array($entry->metadata) && sizeof($entry->metadata) > 0) {
                $mm[] = $entry->metadata;
            }
            if (sizeof($mm) > 0) {
                $p['metadata'] = $mm;
            }

            $a = array(
                'currency'              => $payload->currency,
                'product_data'          => $p,
                'unit_amount_decimal'   => $entry->unitAmountDecimalInCents
            );
            $e = array(
                'price_data' => $a,
                'quantity'   => $entry->quantity,
            );
            $dataLines[] = $e;
        }

        //Initiate to Stripe
        $basicData = [
            'line_items' => $dataLines,
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

        //return redirect($checkout_session->url);
        return $checkout_session->url;
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
