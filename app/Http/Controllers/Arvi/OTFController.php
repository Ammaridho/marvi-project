<?php

namespace App\Http\Controllers\Arvi;

use App\Http\Controllers\Controller;
use App\Models\MerchantDefinedDelivery;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\MerchantPayment;
use App\Services\OrderDateExclusionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\Payments\ArviPaymentMethod;
use Illuminate\Support\Facades\Validator;
use stdClass;

/**
 * OTF controller manage logic that is specific to Order-For-Tommorow case
 */
class OTFController extends Controller
{
    const MAX_DISPLAY = 4;

    /* ---- to undertand the parameter ---- */

    const PARAM_MERCHANT_PAYMENT_METHOD = "paymp";
    //This represent "merchant defined delivery" (id)
    const PARAM_DELIVERY_POINT = "revor";


    //Locao
    protected $orderDateExclusionService;

    /**
     * Default constructor
     */
    public function __construct(){
        $this->orderDateExclusionService = new OrderDateExclusionService();
    }

    /**
     * We're not accepting 'default'
     */
    public function index()
    {
        return view('arvi.frontend.page-not-available');
    }

    /**
     * OTF handler, otf means order-for-tommorrow, cases where we display page
     * as is, simply user to choose a product, pick a date, pay and deliver
     *
     * @param $qrCode
     * @return \Illuminate\Contracts\Foundation\Application
     *          |\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function otfHandler($qrCode)
    {
        // Merchant
        $merchant =  Merchant::getByCode($qrCode);

        // merchant Active
        if(isset($merchant) && $merchant->active == 1){

            //Merchant id
            $mId = $merchant->id;

            // location allow
            $allowLocation = $merchant->loc_aware;

            //now
            $now = Carbon::now();

            // order_days_ahead merchant
            $oda = $merchant->order_days_ahead;

            // set cut time if > 20.00 UTC
            if($oda == 1 && $now->format('H:i:s') > "12:00:00"){
                $oda += 1;
            }

            // Dates order set, start date
            $nowd = $now->addDays($oda);

            $dates = array();
            $d = $nowd->clone();
            for($i = 0; $i < static::MAX_DISPLAY; $i++){
                $dates['dmY'][$i] = $d->format('D, M d, Y');
                $dates['d'][$i] = $d->format('d');
                $dates['D'][$i] = $d->format('D');
                $dates['M'][$i] = $d->format('M');
                $isAbsent = $this->orderDateExclusionService->isDeliverDay($d);
                $d->addDay();
                while($isAbsent) {
                    $d->addDay();
                    $isAbsent = $this->orderDateExclusionService->isDeliverDay($d);
                }
            }

            // Like To Buy
            $pjis = MerchantProduct::join(
                        'product_images','merchant_products.id','=','product_images.merchant_product_id')
                    ->where('merchant_products.merchant_id',$mId)
                    ->orderBy('merchant_products.id', 'ASC')
                    ->get()->unique('merchant_product_id');

            // payments
            $paymentMechants = MerchantPayment::getByMerchant($mId);
            $payments = array();
            foreach ($paymentMechants as $_paym) {
                $a = new \stdClass();
                $a->payment_provider_id = $_paym->payment_provider_id;
                $a->provider = ArviPaymentProvider::resolveName($_paym->payment_provider_id);
                $a->id = $_paym->id;
                $a->method = ArviPaymentMethod::resolveName($_paym->payment_method_id);
                $a->method_id = $_paym->id;
                $payments[] = $a;
            }

            // predefined target delivery
            $revor = MerchantDefinedDelivery::getByMerchantId($mId);

            $f = strtotime("+8 days");
            $futureDate = date('Y-m-d', $f);
            $d = new \DateTime('+1day');
            $tomorrowDate = $d->format('m/d/Y');

            return view('arvi.frontend.index',
                compact('qrCode','merchant',
                    'allowLocation', 'dates','revor','payments','pjis',
                    'futureDate','tomorrowDate'
                ));
        }

        //we're unable to find code
        return view('arvi.frontend.page-not-available');
    }

    /**
     * Review order
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mid' => 'required',
            'name' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'revor' => 'required',
            'datej' => 'required',
        ]);
        if ($validator->fails()) {
            $err = new stdClass();
            $err->message = trans('otf.validation.missing_parameter');
            return response()->json($err,400);
        }

        $mId        = $request->get('mid');
        $products   = $request->get('products');
        $name       = $request->get('name');
        $telephone  = $request->get('telephone');
        $email      = $request->get('email');
        $revor      = $request->get(static::PARAM_DELIVERY_POINT);
        $paymId     = $request->get(static::PARAM_MERCHANT_PAYMENT_METHOD);
        $date       = $request->get('datej');

        // merchant
        $merchant = merchant::find($mId);

        // product
        $qtot = 0;
        $pobj = json_decode($products);
        //\Log::info($pobj);
        $productss = array();
        foreach ($pobj as $key => $entry) {
            $productss[] = $entry->{$entry->pid};
            $qtot += ($entry->{$entry->pid}->productQuan * $entry->{$entry->pid}->productPrice);
        }
        //$qtot *= $value->productPrice;

        //Get detail data of predefined delivery
        $defineDelivery = MerchantDefinedDelivery::find($revor);

        $_e = MerchantPayment::find($paymId);
        $payment = NULL;
        if ($_e) {
            $payment = ArviPaymentMethod::resolveName($_e->payment_method_id);
        }

        return view('arvi.frontend.review',
            compact('merchant','productss','payment',
                'defineDelivery','date','qtot'));
    }
}
