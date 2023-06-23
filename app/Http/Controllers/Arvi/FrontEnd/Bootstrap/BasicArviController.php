<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Bootstrap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\ArviDelivery;
use App\Models\PredefinedDeliveryLocation;
use App\Models\ArviPaymentMethod;

class BasicArviController extends Controller
{
    public function index()
    {
        return view('arvi.frontend.bootstrap.page-not-available');
    }

    /**
     * OTF handler, otf means order-for-tommorrow, cases where we display page
     * as is, simply user to choose a product, pick a date, pay and deliver
     *
     * @deprecated see OTFController
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

            // Dates order set
            $now = Carbon::now()->addDays($merchant->order_days_ahead);

            $dates = array();
            for($i = 0; $i < 4; $i++){
                $d = $now;
                $dates['dmY'][$i] = $d->format('D, M d, Y');
                $dates['d'][$i] = $d->format('d');
                $dates['D'][$i] = $d->format('D');
                $dates['M'][$i] = $d->format('M');
                $d->addDay(1);
            }

            // Like To Buy
            $pjis = MerchantProduct::leftJoin(
                                'product_images','merchant_products.id','=','product_images.merchant_product_id')
                    ->where('merchant_products.merchant_id',$mId)
                    ->orderBy('merchant_products.id', 'ASC')
                    ->get()->unique('merchant_product_id');

            // receive order (pickup)
            $revor = PredefinedDeliveryLocation::where('merchant_id',$mId)->get();

            // payments
            $payments = ArviPaymentMethod::getAll();

            return view('arvi.frontend.bootstrap.index',
                compact('qrCode','merchant',
                        'allowLocation','dates','payments','pjis','revor'));
        }

        //we're unable to find code
        return view('frontend.bootstrap.page-not-available');
    }

    // public function chooseAttribute(Request $request)
    // {
    //     // id product
    //     $mId = $request->id;

    //     // attribute
    //     $Attributes = ProductAttribute::where('merchant_product_id',$mId)->orderBy('id', 'ASC')->get();

    //     return view('arvi.frontend.bootstrap.choose-attribute',compact('Attributes'));
    // }

    public function review(Request $request)
    {
        $mId        = $request->mid;
        $products   = $request->products;
        $name       = $request->name;
        $telephone  = $request->telephone;
        $email      = $request->email;
        $revor      = $request->revor;
        $date       = $request->datej;

        // // merchant
            $merchant = merchant::find($mId);

        // // recieve Order
        //     $revor = ArviDelivery::find($revor);

        // product
        // multi product
            // $productReview = MerchantProduct::join('product_images','merchant_products.id','=','product_images.merchant_product_id')->find($product);

        // Payment
            // $paym = ArviPaymentMethod::find($payId);

        // Total Payment
            // $p = $productReview->retail_price;                                                          //p = product + attribute
            // $tp = (($productReview->retail_price) * $quantity);                                         //tp = p * quantity
            // $ttp = (($productReview->retail_price) * $quantity) + $revor->cost_delivery + $paym->fee;   //ttp = tp + delivery + paymentCost

        return view('arvi.frontend.bootstrap.review',compact('merchant'));
    }

    public function storeArvi(Request $request)
    {
        // Store Processs merchant_orders:
        $merchant_id        = 1;
        $create_time        = Carbon::now();
        $day_deliver        = $request->date;
        $source_ip          = $request->ip();
        $name               = $request->name;
        $email              = $request->email;
        $mobile_number      = '+65'.$request->telephone;
        $delivery_id        = 1; //ini masi belum jelas
        // $delivery_fee       = 3; //ini masi belum jelas
        $currency           = '$';
        $total_gross_price  = $request->total_price;
        // $discount           =
        // $discount_type      =
        $merchan_payment_id = $request->pay;
        // $remarks_order      =
        // $remarks_deliver    =

        $merchant_orders = new MerchantOrder;
        $merchant_orders->merchant_id = $merchant_id;
        $merchant_orders->create_time = $create_time;
        $merchant_orders->day_deliver = $day_deliver;
        $merchant_orders->source_ip = $source_ip;
        $merchant_orders->name = $name;
        $merchant_orders->email = $email;
        $merchant_orders->mobile_number = $mobile_number;
        $merchant_orders->delivery_id = $delivery_id;
        $merchant_orders->currency = $currency;
        $merchant_orders->total_gross_price = $total_gross_price;
        $merchant_orders->merchan_payment_id = $merchan_payment_id;
        $merchant_orders->save();


        $order_detail = new MerchantOrderDetail;
        $order_detail->merchant_id      = $merchant_id;
        $order_detail->create_time      = Carbon::now();
        $order_detail->product_id       = $request->product;
        $order_detail->qty              = $request->quantity;
        $order_detail->selling_price    = $request->total_price_product;
        $order_detail->currency         = '$';
        $order_detail->MerchantOrder()->associate($merchant_orders);  //relation associate not plural an then col name 'merchant_order' not with s
        $order_detail->save();

        // Store Processs order_detail_attributes:

        // order_id
        // order_detail_id
        // product_attribute_id
        // create_time
        // qty
        // fee
        // currency

    }

    public function proceedToPay(Request $request)
    {
        return view('arvi.frontend.bootstrap.page-response-wait');
    }
}
