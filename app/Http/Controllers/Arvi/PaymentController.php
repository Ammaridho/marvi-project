<?php

namespace App\Http\Controllers\Arvi;

use App\Http\Controllers\Controller;
use App\Models\ArviDelivery;
use App\Models\MerchantDefinedDelivery;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantProduct;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\MerchantPayment;
use App\Models\Payments\StripeArviCheckout;
use App\Models\Payments\StripeArviEntryCheckout;
use App\Services\RandomGenerator;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

/**
 * General payment controller
 *
 */
class PaymentController extends Controller
{
    const DEFAULT_CURRENCY = "IDR";
    const DEFAULT_UOM = "PCS";
    const BOOK_SESSION_ID = "BOOK_SESS";

    /**
     * Book slot for payment and decide which payment provider will process
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function book(Request $request){

        //if ($request->session()->has(static::BOOK_SESSION_ID)) {
        //    //it's a double call we assume
        //    return response()->json(
        //        ['message'          => 'DOUBLE_CALL',
        //            'processingUrl' => ''
        //        ],
        //        400
        //    );
        //}

        $validator = Validator::make($request->all(), [
            'mid' => 'required',
            'name' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            //'revor' => 'required',
            'datej' => 'required',
            'paymp' => 'required',
        ]);
        if ($validator->fails()) {
            $err = new stdClass();
            $err->error = 400;
            $err->message = trans('otf.validation.missing_parameter');
            return response()->json($err,400);
        }

        $bookId = RandomGenerator::generateSimpleCode(5);
        $request->session()->put(static::BOOK_SESSION_ID, $bookId);

        //Now continue to get provider
        $paymentMechantsId = MerchantPayment::getById($request->get('paymp'));
        if (!$paymentMechantsId) {
            $err = new stdClass();
            $err->error = 400;
            $err->message = trans('otf.validation.invalid_parameter');
            return response()->json($err,400);
        }

        $url = $this->constructPaymentProviderUrl($paymentMechantsId->payment_provider_id, $request);

        $request->session()->remove(static::BOOK_SESSION_ID);

        return response()->json(
            ['message'          => 'OK',
                'slot'          => $bookId,
                'processingUrl' => $url
            ]
        );
    }

    /**
     * Contruct URL for payment provider.
     * This method WILL save order to database
     *
     * @param $paymentProviderId
     * @param Request $request
     * @return string|null
     * @throws \Exception
     */
    function constructPaymentProviderUrl($paymentProviderId, Request $request) {
        $mId        = $request->get('mid');
        $products   = $request->get('products');
        $name       = $request->get('name');
        $telephone  = $request->get('telephone');
        $email      = $request->get('email');
        $revor      = $request->get(OTFController::PARAM_DELIVERY_POINT);
        $paymId     = $request->get(OTFController::PARAM_MERCHANT_PAYMENT_METHOD);
        $date       = $request->get('datej');

        //Get info on Payment method
        $_mPayment = MerchantPayment::find($paymId);
        if (!$_mPayment) {
            $err = "CANT FIND PAYMENT METHOD! by id: " . $paymId;
            \Log::error($err);
            throw new \Exception("CANT FIND PAYMENT METHOD!");
        }

        \Log::info($products);
        $pobj = json_decode($products);

        //Save Order to database:
        //TX?
        DB::beginTransaction();

        $newOrder = new MerchantOrder();
        $newOrder->merchant_id = $mId;
        $newOrder->source_ip = $request->ip();
        $newOrder->name = $name;
        $newOrder->mobile_number = $telephone;
        $newOrder->email = $email;
        $newOrder->arvi_session_id = RandomGenerator::generateSimpleCode(7);
        $newOrder->merchant_payment_id = $paymId;
        $newOrder->payment_provider_id = $_mPayment->payment_provider_id;
        $newOrder->payment_provider_id = $_mPayment->payment_provider_id;
        //default
        $newOrder->delivery_id = ArviDelivery::ARVI;

        $d = Carbon::parse($date);
        $newOrder->day_deliver = $d->format('Y-m-d');

        $address = '';
        $loc_lan = 0.0;
        $loc_lat = 0.0;
        $postal = '';
        if (!empty($revor)) {
            $defineDelivery = MerchantDefinedDelivery::find($revor);
            if ($defineDelivery) {
                $address = $defineDelivery->address;
                $loc_lan = $defineDelivery->loc_lan;
                $loc_lat = $defineDelivery->loc_lat;
                $postal = $defineDelivery->postal_code;
            }
        } else {
            $revor = 0;
        }

        $newOrder->defined_delivery_id = $revor;
        $newOrder->loc_lan = $loc_lan;
        $newOrder->loc_lat = $loc_lat;
        $newOrder->postal_code = $postal;
        $newOrder->address = $address;

        try {
            $qtot = 0;
            $curr = static::DEFAULT_CURRENCY;
            foreach ($pobj as $key => $entry) {
                $_entry = $entry->{$entry->pid};
                $qtot += ($_entry->productQuan * $_entry->productPrice);
                //take sample of currency
                $curr = $_entry->productCurren;
            }
            $newOrder->currency = $curr;
            $newOrder->total_gross_price = $qtot;
            $newOrder->save();

            foreach ($pobj as $key => $entry) {
                $_entry = $entry->{$entry->pid};
                $moDet = new MerchantOrderDetail();
                $moDet->merchant_id = $mId;
                $moDet->merchant_order_id = $newOrder->id;
                $moDet->product_id = $entry->pid;
                $moDet->qty = $_entry->productQuan;
                $moDet->currency = $curr;
                $moDet->selling_price = $_entry->productPrice;
                $moDet->uom = static::DEFAULT_UOM;
                $moDet->save();
            }

            if (ArviPaymentProvider::STRIPE == $paymentProviderId) {

                $ee = new StripeArviCheckout();
                $ee->arviSessionId = $newOrder->arvi_session_id;
                $ee->email = $email;

                foreach ($pobj as $key => $entry) {
                    $lineEntry = $entry->{$entry->pid};
                    $pDB = MerchantProduct::getById($entry->pid);
                    $desc = '';
                    $sku = '';
                    if ($pDB) {
                        $desc = $pDB->description;
                        $sku = $pDB->product_id;
                    }

                    $entry = new StripeArviEntryCheckout();
                    $entry->name = $lineEntry->productName;
                    $entry->description = $desc;
                    $entry->quantity = $lineEntry->productQuan;
                    $entry->unitAmountDecimalInCents = floatval($lineEntry->productPrice) *100;
                    $entry->sku = $sku;
                    //$entry->images = array(
                    //    'https://storage.googleapis.com/berkah-bootstrap/media/cache/55/eb/55ebbd7b515db9c65fd6c0dd6fcfba8b.jpg'
                    //);

                    $ee->entries[] = $entry;
                }

                $stripeService = new StripeService();
                \Log::info("Going to call stripe for order session_id: " . $ee->arviSessionId);

                DB::commit();

                return $stripeService->takeMeToStripe($ee);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();
            $message = $exception->getMessage();
            \Log::error("Error while saving Order[consPaymentProviderUrl]: {$message}. Stacktrace: " .
                $exception->getTraceAsString());
        }
        return "";
    }

}
