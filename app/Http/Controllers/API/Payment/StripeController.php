<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Mail\Arvi\OFTCustomerFailedOrder;
use App\Mail\Arvi\OFTCustomerSuccessOrder;
use App\Mail\Payload\FailedOrderMailPayload;
use App\Mail\Payload\SuccessOrderMailPayload;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantProduct;
use App\Models\Payments\ArviPaymentMethod;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\ArviPaymentStatus;
use App\Models\Payments\MerchantPayment;
use App\Models\Payments\StripeArviCheckout;
use App\Models\Payments\StripeArviEntryCheckout;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Stripe Payment controller, based on:
 * https://stripe.com/docs/checkout/quickstart
 *
 * See: sampleTakeMeToStripeVars for sample
 */
class StripeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Take me to stripe. This will initiate session to stripe
     * and redirect to them
     *
     * https://stripe.com/docs/api/checkout/sessions/object
     *
     */
    public function takeMeToStripe(StripeArviCheckout &$payload){
        $stripeService = new StripeService();
        return redirect( $stripeService->takeMeToStripe($payload) );
    }

    /**
     * Process on success call after stripe
     * @param $arviSessionId
     */
    public function onSuccess($arviSessionId) {
        $ord = MerchantOrder::where('arvi_session_id',$arviSessionId)->first();
        if (!$ord) {
            return redirect("/404?stripe-success");
        }
        $payment = '';
        $_e = MerchantPayment::find($ord->merchant_payment_id);
        if ($_e) {
            $payment = ArviPaymentMethod::resolveName($_e->payment_method_id);
        }

        //Update status, only if its NEW
        if ($ord->payment_status == ArviPaymentStatus::NEW) {
            $ord->payment_status = ArviPaymentStatus::PAID;
            $ord->save();

            //Only send if success and has email
            try {
                $merchant =  Merchant::find($ord->merchant_id);
                if (isset( $ord->email )) {
                    $entry = new SuccessOrderMailPayload();
                    $entry->name = $ord->name;
                    $entry->email = $ord->email;
                    $entry->telephone = $ord->mobile_number;
                    $entry->orderNumber = $ord->arvi_session_id;
                    $entry->merchantCode = '';
                    if ($merchant) {
                        $entry->merchant = $merchant->name;
                        $entry->merchantCode = $merchant->code;
                        $entry->urlBuy = url('/m/' . $merchant->code);
                    }
                    $entry->paymentMethod = $payment;
                    $entry->paymentProvider = ArviPaymentProvider::resolveName($ord->payment_provider_id);

                    //Get info on purchase details
                    $items = MerchantOrderDetail::where('merchant_id',$ord->merchant_id)
                                ->where('merchant_order_id',$ord->id)
                                ->get();
                    $products = array();
                    foreach ($items as $_i) {
                        $p = MerchantProduct::getById($_i->product_id);
                        $li = new \stdClass();
                        $li->qty = $_i->qty;
                        $li->currency = $_i->currency;
                        $li->productPrice = $_i->selling_price;
                        if ($p) {
                            $li->productName = $p->name;
                        }
                        $products[] = $li;
                    }
                    $entry->products = $products;

                    Mail::to($ord->email)
                        ->send(new OFTCustomerSuccessOrder($entry));

                    Log::info("Sent email to: {$ord->email}. Order#: {$entry->orderNumber}");

                }
            } catch (\Exception $exception) {
                Log::error("Error sending success email to: {$ord->email}. Message: {$exception->getMessage()}");
            }

        }
        return view('arvi.frontend.bootstrap.stripe.success', compact('ord','payment'));
    }

    /**
     * Process on failed call after stripe
     * @param $arviSessionId
     */
    public function onFailed($arviSessionId) {
        $ord = MerchantOrder::where('arvi_session_id',$arviSessionId)->first();
        if (!$ord) {
            return redirect("/404?stripe-failed");
        }
        $payment = '';
        $_e = MerchantPayment::find($ord->merchant_payment_id);
        if ($_e) {
            $payment = ArviPaymentMethod::resolveName($_e->payment_method_id);
        }

        //Update status, only if its NEW
        if ($ord->payment_status == ArviPaymentStatus::NEW) {
            $ord->payment_status = ArviPaymentStatus::FAILED;
            $ord->save();


            //Only send if just set to failed and has email
            try {
                $merchant =  Merchant::find($ord->merchant_id);
                if (isset( $ord->email )) {
                    $entry = new FailedOrderMailPayload();
                    $entry->name = $ord->name;
                    //$entry->email = $ord->email;
                    //$entry->telephone = $ord->mobile_number;
                    $entry->orderNumber = $ord->arvi_session_id;
                    $entry->merchantCode = '';
                    if ($merchant) {
                        $entry->merchant = $merchant->name;
                        $entry->merchantCode = $merchant->code;
                        $entry->urlBuy = url('/m/' . $merchant->code);
                    }

                    //Get info on purchase details
                    Mail::to($ord->email)
                        ->send(new OFTCustomerFailedOrder($entry));

                    Log::info("Sent failed purchase email to: {$ord->email}. Order#: {$entry->orderNumber}");

                }
            } catch (\Exception $exception) {
                Log::error("Error sending failed email to: {$ord->email}. Message: {$exception->getMessage()}");
            }

        }
        return view('arvi.frontend.bootstrap.stripe.failed', compact('ord','payment'));
    }


    /* ------------- TEST ------------ */

    /**
     * (sample) Take me to stripe
     * https://stripe.com/docs/api/checkout/sessions/object
     *
     */
    public function sampleTakeMeToStripeVars(Request $request){
        $ee = new StripeArviCheckout();
        $ee->arviSessionId = StripeService::generateId();
        $entry = new StripeArviEntryCheckout();
        //$entry->name = 'Oat Milk Coffee';
        $entry->name = 'Rooibos Orange Tea';
        $entry->description = "Creamy, naturally-sweet and refreshingly smooth. Our signature cold brew coffee infused with 100% dairy-free organic oat milk. Shake well for the best experience.";
        $entry->unitAmountDecimalInCents = 4.8*100;
        $entry->sku = 'CBO250';
        $entry->images = array(
            'https://storage.googleapis.com/berkah-bootstrap/media/cache/55/eb/55ebbd7b515db9c65fd6c0dd6fcfba8b.jpg'
        );
        $ee->entries[] = $entry;

        return $this->takeMeToStripe($ee);
    }

    /**
     * (sample) Take me to stripe
     * https://stripe.com/docs/api/checkout/sessions/object
     *
     */
    public function sampleTakeMeToStripeHarcode(Request $request){
        \Stripe\Stripe::setApiKey(config('services.stripe.key'));
        header('Content-Type: application/json');
        $YOUR_DOMAIN = env('APP_URL');

        //$PRICE_ID = "price_1LDADUKPQDLc7b1Pwfg5NT4e";

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'SGD',
                        'product_data' => [
                            'name'          => 'Hojicha Green Tea',
                            'description'   => "Premium roasted green tea with tasting notes of coffee, ".
                                    "roasted barley and caramel. Our cold brew's lower caffeine level makes " .
                                    "it the perfect refreshment for any time of the day.",
                            'images'        => [
                                0 => 'https://storage.googleapis.com/berkah-bootstrap/media/cache/55/eb/55ebbd7b515db9c65fd6c0dd6fcfba8b.jpg'
                            ],
                            'metadata'      => [
                                'test' => 'value-test',
                                'SKU'  => 'CBTH250',
                            ]
                        ],
                        'unit_amount_decimal' => (3.8*100)
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);
        return redirect($checkout_session->url);
    }

}

