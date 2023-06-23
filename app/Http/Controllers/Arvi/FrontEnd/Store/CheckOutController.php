<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Models\Brand;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantProductVariant;
use App\Models\ProductAttribute;
use App\Models\BrandExtraAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantOrderProductAttributeList;
use App\Models\MerchantOrderProductExtraAttributeList;
use App\Models\ArviDelivery;
use App\Models\ArviSubDelivery;
use App\Models\MerchantDelivery;
use App\Models\MerchantDeliveryMethod;
use Illuminate\Support\Facades\Auth;

use App\Models\UserAddress;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\MerchantPayment;
use Illuminate\Support\Facades\Validator;
use App\Models\Payments\ArviPaymentMethod;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Jenssegers\Agent\Agent as Agent;

use App\Mail\Arvi\OobeIndonesia\CustomerSuccessOrder;

class CheckOutController extends Controller
{
    protected $view = 'arvi.frontend.store.check-out.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shoppingCarts = [];
        $cart = json_decode($request->cart, true);

        if (isset($cart)) {

            foreach ($cart as $key => $value) {
                // product
                $product = MerchantProduct::
                leftJoin('product_images','merchant_products.id','=',
                    'product_images.merchant_product_id')
                ->join('merchants','merchant_products.merchant_id','=',
                    'merchants.id')
                ->where('merchant_products.id',$value['idProduct'])
                ->select(
                    'merchants.name as merchantName',
                    'merchants.id as merchantId',
                    'merchant_products.id',
                    'merchant_products.merchant_id',
                    'merchant_products.name',
                    'merchant_products.retail_price',
                    'merchant_products.currency',
                    'merchant_products.description',
                    'product_images.url',
                    'product_images.image_mime',
                    'product_images.image_type',
                    )
                ->first()->toArray();
                if (MerchantProductVariant::find($value['variant']['id'])) {
                    $variant['id']    = $value['variant']['id'];
                    $variant['name']  = MerchantProductVariant::
                    find($value['variant']['id'])->name;
                    $variant['price'] = $value['variant']['price'];
                }else{
                    $variant = null;
                }

                $qty = $value['qty'];

                if (isset($value['attribute'])) {
                    // attribute
                    foreach ($value['attribute'] as $key1 => $value1) {
                        $attribute[$key1]['id']    = $value1['id'];
                        $attribute[$key1]['name']  =
                        ProductAttribute::find($value1['id'])->name;
                        $attribute[$key1]['price'] = $value1['price'];
                        $attribute[$key1]['qty']   = $value1['qty'];
                    }
                }else{
                    $attribute = null;
                }

                // extra attribute
                if (isset($value['extraAttribute'])) {
                    foreach ($value['extraAttribute'] as $key2 => $value2) {
                        // check brand extra attribute have index 'type'
                        if (isset($value2['type'])) {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                            BrandExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'b';
                        } else {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                            MerchantExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'm';
                        }
                        $extraAttribute[$key2]['price']   = $value2['price'];
                        $extraAttribute[$key2]['qty']     = $value2['qty'];
                    }
                }else{
                    $extraAttribute = null;
                }

                // note
                $note = isset($value['note'])?$value['note']:'';

                $shoppingCarts[$key] = [
                    'product'               => $product,
                    'variant'               => isset($variant)?$variant:null,
                    'qty'                   => $qty,
                    'attribute'             => isset($attribute)?$attribute:null,
                    'extraAttribute'        => isset($extraAttribute)?$extraAttribute:null,
                    'note'                  => $note,
                    'totalPricePerProduct'  => $value['totalPricePerProduct'],
                    'totalPriceAll'         => $value['totalPriceAll'],

                ];

                $extraAttribute = null;
                $attribute = null;

            }
        }

        return view($this->view . 'index',
        compact('shoppingCarts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deliveryOrder(Request $request,$code)
    {
        $cart = json_decode($request->cart, true);
        
        $merchantIds = [];
        $totalWeight = 0;

        // items dan prices
        foreach ($cart as $key => $value) {

            // all id merchant
            if (!in_array($value['idMerchant'], $merchantIds)) {
                array_push($merchantIds,$value['idMerchant']);
            }

            if (isset($items[$value['idMerchant']])) {
                $items[$value['idMerchant']] += 1;
                $Prices[$value['idMerchant']] += $value['totalPriceAll'];
            }else{
                $items[$value['idMerchant']] = 1;
                $Prices[$value['idMerchant']] = $value['totalPriceAll'];
            }

            // merchant data
            $merchant = Merchant::find($value['idMerchant']);

            // total weight
            $totalWeight += $value['totalWeight'];
                
            // dif product base on merchant
            $orders[$value['idMerchant']] = [
                // merchant id
                    'merchantId'    => $merchant->id,
                // merchant name
                    'merchantName'  => $merchant->name,
                // total items
                    'totalItems'    => $items[$value['idMerchant']],  
                // total price product
                    'totalPrices'   => $Prices[$value['idMerchant']],
                // fee
                    'fees'          => Brand::find($merchant->brand_id)->fees,
            ];
        }
        
        // data merchant
        $merchant = Merchant::find($merchantIds[0]);
        // currency
        $currency = $merchant->currency;
        // location
        $location = $merchant->location->first();
        // client id
        $client_id = Brand::find($merchant->brand_id)->client_id;

        // delivery
        $deliveryMethod = array();
        if ($merchant->support_delivery == 1) {
            $merchantDelivery = MerchantDelivery::where('merchant_id',$merchant->id)
            ->first()->merchantDeliveryMethod->pluck('arvi_sub_delivery_id');
            
            foreach ($merchantDelivery as $key => $value) {
                $deliveryMethod[$key] = MerchantDelivery::
                join('merchant_delivery_methods','merchant_delivery_methods.merchant_delivery_id',
                '=','merchant_deliveries.id')
                ->join('arvi_deliveries','arvi_deliveries.id',
                '=','merchant_delivery_methods.arvi_delivery_id')
                ->join('arvi_sub_deliveries','arvi_sub_deliveries.id',
                '=','merchant_delivery_methods.arvi_sub_delivery_id')
                ->select(
                    'arvi_deliveries.name as deliveryName',
                    'arvi_sub_deliveries.name as subDeliveryName',
                    'arvi_sub_deliveries.id as subDeliveryId',
                    'arvi_sub_deliveries.image_url as subDeliveryImage',
                    'arvi_sub_deliveries.cost_delivery as cost_delivery',
                    'arvi_sub_deliveries.currency as currency',
                    'merchant_delivery_methods.transporter_id'
                )
                ->where('arvi_sub_deliveries.id',$value)
                ->first();
            }
        }
                
        // saved address
        if (Auth::check()){
            $saved_address = UserAddress::where('user_id',Auth::user()->id)->get();
        }else{
            $saved_address = [];
        }

        return view($this->view . 'page-orders',
        compact('orders','merchant','currency','location',
        'saved_address','deliveryMethod',
        'totalWeight','client_id','code'));        
    }

    public function searchDistrict(Request $request)
    {
        // list postal code
        $resultSearchDistrict = app('App\Http\Controllers\API\ApiController')
        ->searchDistrict($request->keySearch);
        return $resultSearchDistrict->result;
    }

    public function checkRates(Request $request)
    {
        $checkRates = app('App\Http\Controllers\API\ApiController')
        ->getCourierRates($request->client_id,$request->origin,
        $request->destination,$request->weight,$request->volume);
        $currency = $request->currency;

        // merchant delivery configuration
        $merchant_deliveries = MerchantDeliveryMethod::
        rightJoin('merchant_deliveries','merchant_delivery_methods.merchant_delivery_id',
        '=','merchant_deliveries.id')
        ->join('arvi_deliveries','arvi_deliveries.id',
        '=','merchant_delivery_methods.arvi_delivery_id')
        ->join('arvi_sub_deliveries','arvi_sub_deliveries.id',
        '=','merchant_delivery_methods.arvi_sub_delivery_id')
        ->select(
            'arvi_deliveries.name as courier',
            'arvi_sub_deliveries.name as service_type',
            'merchant_delivery_methods.id'
        )
        ->where('merchant_deliveries.merchant_id',$request->merchant_id)
        ->get();

        // compare store active with cek rates data
        //mdm_id = merchant delivery method id
        $deliveryMethod = [];
        foreach ($checkRates as $key => $dm) {
            // hide delivery lower weight than minimal
            if ($request->weight >= $dm['minimal_weight']) {
                foreach ($merchant_deliveries as $md) {
                    if ($dm['courier'] == $md['courier'] &&
                     $dm['service_type'] == $md['service_type']) {
                        array_push(
                            $deliveryMethod, 
                            array_merge($dm, ['mdm_id' => $md['id']])
                        ); 
                    }
                }
            }
        }
        
        return view($this->view . 'list-delivery',
            compact('currency','deliveryMethod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentOrder(Request $request,$code)
    {
        if (!isset($request->data)) {
            // data
            $totalShoppingPrice     = (float)$request->totalShoppingPrice;
            $bioCust                = $request->bioCust;
            $deliveryId             = $request->deliveryId;
            $courier                = $request->courier;
            $cost_delivery          = (float)$request->cost_delivery; 
            $cart                   = json_decode($request->cart, true);
            
        } else {
            $data = json_decode($request->data,true);
            
            // data
            $totalShoppingPrice     = (float)$data['totalShoppingPrice'];
            $bioCust                = $data['bioCust'];
            $deliveryId             = $data['deliveryId'];
            $courier                = $data['courier'];
            $cost_delivery          = json_decode($data['courier'])!=null ? 
                (float)json_decode($data['courier'],true)['cost_delivery'] : 0;
            $cart                   = json_decode($data['cart'], true);
        }
        
        $totalPrice  = $totalShoppingPrice + $cost_delivery;

        $xenditChannels = app('App\Http\Controllers\API\Payment\XenditController')
        ->getListChannel();
        
        
        // all merchant id
        $merchantIds = [];
        foreach ($cart as $key => $value) {
            // all id merchant
            if (!in_array($value['idMerchant'], $merchantIds)) {
                array_push($merchantIds,$value['idMerchant']);
            }
        }

        $merchant_id = $merchantIds[0];
        $merchant = Merchant::find($merchant_id);

        // payments
        $paymentMerchants = MerchantPayment::
        join('arvi_payment_methods','arvi_payment_methods.id',
        '=','merchant_payments.payment_method_id')
        ->select('*','merchant_payments.id as id')
        ->where('merchant_id',$merchant->id)->get();
        $payments = array();
        $Agent = new Agent();
        foreach ($paymentMerchants as $_paym) {

            // only display cash, ew and qr
            if (!(in_array($_paym->category,['QR_CODE','EWALLET','CASH']))) {
                continue;
            }

            // skip qr method if mobile
            if ($Agent->isMobile() && $_paym->category == 'QR_CODE') {
                continue;
            }

            // skip ew method if desktop
            if (!($Agent->isMobile()) && $_paym->category == 'EWALLET') {
                continue;
            }

            $a                        = array();
            $a['id']                  = $_paym->id;
            $a['category']            = $_paym->category;
            $a['payment_provider_id'] = $_paym->payment_provider_id;
            $a['provider']            = ArviPaymentProvider::resolveName($_paym->payment_provider_id);
            $a['method_id']           = $_paym->payment_method_id;
            $a['method']              = ArviPaymentMethod::find($_paym->payment_method_id)->name;
            $a['channel_code']        = ArviPaymentMethod::find($_paym->payment_method_id)->channel_code;
            $payments[]               = $a;
        }
        
        if ($deliveryId > 0) {
            $delivery = MerchantDeliveryMethod::find($deliveryId);
        } else {
            $delivery = ArviDelivery::where('name','Pick Up')->first();
        }

        // fee
        // relation to fee brand
        $fees = Brand::
        join('merchants','brands.id','=','merchants.brand_id')
        ->join('brand_fee_list','brands.id','=','brand_fee_list.brand_id')
        ->join('fees','brand_fee_list.fee_id','=','fees.id')
        ->where('merchants.id',$merchant_id)
        ->select('fees.name','fees.type_fee','fees.value_fee',
        'fees.type_value','fees.currency')
        ->get();

        // bundle based category
        $bundlePayments = array();
        foreach ($payments as $key => $value) {
            $bundlePayments[$value['category']][] = $value;
        }

        return view($this->view . 'page-payment',
            compact('merchant','deliveryId','bioCust',
            'totalPrice','cost_delivery','totalShoppingPrice',
            'courier','bundlePayments','code'));
    }

    public function paymentProcess(Request $request,$code)
    {
        // collect all data
        $data = new stdClass();
        $data->cart                 =  json_decode($request->cart);
        $data->paymp                =  json_decode($request->paymp);
        $data->merchantId           =  $request->merchantId;
        $data->deliveryId           =  $request->deliveryId;
        $data->totalPrice           =  json_decode($request->totalPrice);
        $data->totalShoppingPrice   =  json_decode($request->totalShoppingPrice);
        $data->bioCust              =  $request->bioCust;
        $data->courier              =  $request->courier;

        $payment = MerchantPayment::
        join('arvi_payment_methods','arvi_payment_methods.id','=',
        'merchant_payments.payment_method_id')
        ->select('arvi_payment_methods.name', 'arvi_payment_methods.channel_code',
        'arvi_payment_methods.category')
        ->where('merchant_payments.id',$data->paymp )->first()->toArray();

        $id         = Str::random(10);
        $name       = json_decode($request->bioCust, true)['nameCust'];
        $totalPrice = $data->totalPrice;
        $data->id   = $id;

        // currency
        $merchant      = Merchant::find($request->merchantId);
        $brand         = Brand::find($merchant->brand_id);
        $currency      = $merchant->currency;

        $payment = array_merge($payment,[
            'totalPrice' => $totalPrice,
            'currency'   => $currency,
            'id'         => $id,
            'name'       => $name
        ]);
        
        $data->payment = $payment;
        return redirect()->route('payment-store-detail-store',['code'=>$code,'data' => json_encode($data)]);
        
    }

    // supaya saat refresh stay
    function detail(Request $request,$code)
    {
        $data = json_decode($request->data,true);

        switch ($data['payment']['category']) {

            case 'CASH':
                return view('arvi.frontend.store.result-payment.cash.page-payment-cash',
                compact('data','code'));
                break;
            case 'VIRTUAL_ACCOUNT':
                return view('arvi.frontend.store.result-payment.va.page-payment-va',
                compact('data','code'));
                break;
            case 'EWALLET':
                return view('arvi.frontend.store.result-payment.ew.page-payment-ew',
                compact('data','code'));
                break;
            case 'QR_CODE':
                return view('arvi.frontend.store.result-payment.qr.page-payment-qr',
                compact('data','code'));
                break;
            case 'RETAIL_OUTLET':
                return view('arvi.frontend.store.result-payment.ro.page-payment-ro',
                compact('data','code'));
                break;
        }

    }

    public function generateCash(Request $request)
    {
        $data = json_decode($request->data);
        $code = $request->code;
        
        $paymentType  = 'cash'; //cash

        $data->merchant_order_id = $this->store($data,$paymentType); //Store to Database

        return redirect()->route(
            'payment-invoice-store',['data' => json_encode($data),'code'=>$code]
        );
    }

    public function generateQr(Request $request,$code)
    {
        $data = json_decode($request->data);

        $id           = $data->payment->id;
        $channel_code = $data->payment->channel_code;
        $name         = $data->payment->name;
        $totalPrice   = $data->payment->totalPrice;

        // create xendit qris
        $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
        ->createQr($id,$channel_code,$name,(float)$totalPrice);

        $paymentType  = 'qr'; //qris
        $data->payment->id = $createPayment['id'];
        $data->payment->reference_id = $createPayment['reference_id'];

        //Store to Database
        $data->merchant_order_id = $this->store($data,$paymentType); 

        $data->timer = Carbon::now()->addMinutes(2);
        
        $qr_string = $createPayment['qr_string'];

        return view('arvi.frontend.store.result-payment.qr.page-payment-generate-qr',
        compact('data','qr_string','code'));
    }

    public function generateEw(Request $request,$code)
    {
        $data         = json_decode($request->data);

        $id           = $data->payment->id;
        $channel_code = $data->payment->channel_code;
        $name         = $data->payment->name;
        $totalPrice   = $data->payment->totalPrice;
        $linkSuccess  = route('payment-store-success-store',['code'=>$code]);
        $linkFailed   = route('payment-store-failed-store',['code'=>$code]);

        // create xendit ew
        if ($data->payment->channel_code == 'OVO') {
            $noTelpOvo = '+'.preg_replace("/[^1-9]+/", "",$request->noTelpOvo); 
            $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
            ->createEwOvo($id,$channel_code,$name,(float)$totalPrice,$noTelpOvo);
            $paymentType  = 'ew'; //ewwalet
            $data->payment->id    = $createPayment['id'];
            $data->merchant_order_id = $this->store($data,$paymentType); //Store to Database
            $data->noTelpOvo = $noTelpOvo;
            return redirect()->route(
                'payment-invoice-store',['data' => json_encode($data),'code'=>$code]
            );
        } else {
            $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
            ->createEw($id,$channel_code,$name,(float)$totalPrice,$linkSuccess,$linkFailed);
            $paymentType  = 'ew'; //ewwalet
            $data->payment->id  = $createPayment['id'];   
            $this->store($data,$paymentType); //Store to Database

            // check desktop or mobile
            $Agent = new Agent();
            if ($Agent->isMobile()) {
                return redirect($createPayment['actions']['mobile_web_checkout_url']);
            } else {
                return redirect($createPayment['actions']['desktop_web_checkout_url']);
            }
        }
    }

    public function generateVa(Request $request,$code)
    {
        $data         = json_decode($request->data);
        
        $id           = $data->payment->id;
        $channel_code = $data->payment->channel_code;
        $name         = $data->payment->name;
        $totalPrice   = $data->payment->totalPrice;

        // create xendit va
        $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
        ->createVa($id,$channel_code,$name,(float)$totalPrice);

        $xenditPaymentType  = 'va'; //ewwalet
        $xenditPaymentId    = $createPayment['id'];
        $this->store($data,$xenditPaymentType,$xenditPaymentId); //Store to Database

        return view('arvi.frontend.store.result-payment.va.page-payment-generate-va',
        compact('data','createPayment','xenditPaymentId','code'));
    }

    public function generateRo(Request $request,$code)
    {
        
        $data         = json_decode($request->data);

        $id           = $data->payment->id;
        $channel_code = $data->payment->channel_code;
        $name         = $data->payment->name;
        $totalPrice   = $data->payment->totalPrice;
        
        // create xendit va
        $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
        ->createRo($id,$channel_code,$name,(float)$totalPrice);
        
        $xenditPaymentType  = 'ro'; //ewwalet
        $xenditPaymentId    = $createPayment['id'];

        $this->store($data,$xenditPaymentType,$xenditPaymentId); //Store to Database

        return view('arvi.frontend.store.result-payment.ro.page-payment-generate-ro',
        compact('data','createPayment','xenditPaymentId','code'));
    }

    public function invoice(Request $request,$code)
    {
        $data = json_decode($request->data);
        return view('arvi.frontend.store.result-payment.invoice',
        compact('data','code'));
    }

    public function checkPaymentCallback(Request $request)
    {
        $paymentId = $request->paymentId;
        
        $order = MerchantOrder::where('payment_id',$paymentId)
        ->select(
            'payment_status'
        )
        ->first();
            
        // cek payment is already payed
        if ($order->payment_status == 0) {
            return 'waiting for payment';
        }     

        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data,$paymentType)
    {
        // reform data form cart
        $shoppingCarts = [];
        $cart          = json_decode($data->cart, true);
        $totalDiscount = 0;

        if (isset($cart)) {
            foreach ($cart as $key => $value) {
                // product
                $product = MerchantProduct::
                leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.id',$value['idProduct'])
                ->select(
                    'merchant_products.id',
                    'merchant_products.merchant_id',
                    'merchant_products.name',
                    'merchant_products.retail_price',
                    'merchant_products.discount_price',
                    'merchant_products.currency',
                    'merchant_products.description',
                    'product_images.url',
                    'product_images.image_mime',
                    'product_images.image_type',
                    )
                ->first()->toArray();
                if (MerchantProductVariant::find($value['variant']['id'])) {
                    $variant['id']    = $value['variant']['id'];
                    $variant['name']  = MerchantProductVariant::
                    find($value['variant']['id'])->name;
                    $variant['price'] = $value['variant']['price'];
                }else{
                    $variant = null;
                }

                $qty = $value['qty'];

                if (isset($value['attribute'])) {
                    // attribute
                    foreach ($value['attribute'] as $key1 => $value1) {
                        $attribute[$key1]['id']    = $value1['id'];
                        $attribute[$key1]['name']  =
                        ProductAttribute::find($value1['id'])->name;
                        $attribute[$key1]['price'] = $value1['price'];
                        $attribute[$key1]['qty']   = $value1['qty'];
                    }
                }else{
                    $attribute = null;
                }

                // extra attribute
                if (isset($value['extraAttribute'])) {
                    foreach ($value['extraAttribute'] as $key2 => $value2) {
                        // check brand extra attribute have index 'type'
                        if (isset($value2['type'])) {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                            BrandExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'b';
                        } else {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                            MerchantExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'm';
                        }
                        $extraAttribute[$key2]['price']   = $value2['price'];
                        $extraAttribute[$key2]['qty']     = $value2['qty'];
                    }
                }else{
                    $extraAttribute = null;
                }

                // note
                $note = isset($value['note'])?$value['note']:'';

                $shoppingCarts[] = [
                    'product'               => $product,
                    'variant'               => isset($variant)?$variant:null,
                    'qty'                   => $qty,
                    'attribute'             => isset($attribute)?$attribute:null,
                    'extraAttribute'        => isset($extraAttribute)?$extraAttribute:null,
                    'note'                  => $note,
                    'totalPricePerProduct'  => $value['totalPricePerProduct'],
                    'totalPriceAll'         => $value['totalPriceAll'],
                ];

                $attribute = null;
                $extraAttribute = null;

                $totalDiscount += $qty *
                 (isset($product['discount_price'])?
                 $product['discount_price']:0);

            }
        }

        // collect all data and reform
        $merchantPaymentId     = $data->paymp;
        $merchantId    = $data->merchantId;
        $deliveryId    = $data->deliveryId;
        $totalPrice    = $data->totalPrice;
        $bioCust       = json_decode($data->bioCust, true);
        $courier       = json_decode($data->courier, true);
        $merchant      = Merchant::find($merchantId);
        $brand         = Brand::find($merchant->brand_id);
        $currency      = $merchant->currency;
        $locationId     = $bioCust['locationId'];
        $typeDel        = substr($deliveryId, 0, 1);
        $idDel          = trim($deliveryId, $typeDel.'-');

        // Store Processs merchant_orders
        $create_time    = Carbon::now();
        $source_ip      = \Request::ip();
        $savedAddress   = isset($bioCust['savedAddress'])?1:0;
        $name           = $bioCust['nameCust'];
        $mobile_number  = $bioCust['phoneCust'];
        $email          = $bioCust['emailCust'];

        if ($deliveryId>0) {
            $addressCust    = $bioCust['addressCust'];
            $notes          = $bioCust['notesCust'];
        }else{
            $addressCust    = null;
            $notes          = null;
        }

        // saved address
        if($savedAddress == 1){
            $address = new UserAddress;
            $address->user_id       = Auth::user()->id;
            $address->name          = $name;
            $address->email         = $email;
            $address->phone_number  = $mobile_number;
            $address->address       = $addressCust;
            $address->notes         = $notes;
            $address->location_id   = $locationId;
            $address->save();
        }

        // store data order
        $merchant_orders = new MerchantOrder;
        $merchant_orders->user_id             = isset(Auth::user()->id)?Auth::user()->id:null;
        $merchant_orders->merchant_id         = $merchantId;
        $merchant_orders->brand_id            = $brand->id;
        $merchant_orders->create_time         = $create_time;
        $merchant_orders->day_deliver         = $create_time;
        $merchant_orders->source_ip           = $source_ip;
        $merchant_orders->name                = $name;
        $merchant_orders->email               = $email;
        $merchant_orders->mobile_number       = '+'.preg_replace("/[^1-9]+/", "",$mobile_number);
        $merchant_orders->delivery_id         = $deliveryId;
        $merchant_orders->delivery_type       = $deliveryId>0?1:0;
        $merchant_orders->cost_delivery       = isset($courier['cost_delivery'])?$courier['cost_delivery']:0;
        $merchant_orders->currency            = $currency;
        $merchant_orders->loc_tz              = $merchant->loc_tz;
        if ($deliveryId > 0) {
            $merchant_orders->address             = $addressCust;
            $merchant_orders->postal_code         = $bioCust['district']['postcode'];
            $merchant_orders->subdistrict         = $bioCust['district']['subdistrict'];
            $merchant_orders->district            = $bioCust['district']['district'];
            $merchant_orders->city                = $bioCust['district']['city'];
            $merchant_orders->province            = $bioCust['district']['province'];
            $merchant_orders->remarks_deliver     = $notes;
        }
        $merchant_orders->total_gross_price   = $totalPrice;
        $merchant_orders->discount            = $totalDiscount;
        $merchant_orders->merchant_payment_id = $merchantPaymentId;
        $merchant_orders->payment_type = $paymentType;
        $merchant_orders->payment_id   = $data->payment->id;
        $merchant_orders->save();

        // relation to fee brand
        $feeId = Brand::
        join('merchants','brands.id','=','merchants.brand_id')
        ->join('brand_fee_list','brands.id','=','brand_fee_list.brand_id')
        ->where('merchants.id',$merchantId)
        ->pluck('fee_id');

        // // many to many relation fee brand
        $merchant_orders->fees()->attach($feeId,
        ['create_time' => Carbon::now()]);

        //Store data detail order product
        $allItem = array();
        $mp = '';
        $mv = '';
        $mpa = '';
        $mea = '';
        foreach ($shoppingCarts as $key => $value) {
            
            $order_detail = new MerchantOrderDetail;
            $order_detail->merchant_id      = $value['product']['merchant_id'];
            $order_detail->create_time      = Carbon::now();
            $order_detail->product_id       = $value['product']['id'];
            $order_detail->qty              = $value['qty'];
            $order_detail->selling_price    = $value['totalPriceAll'];
            if ($value['product']['discount_price']>0) {
                $order_detail->discount_price   = 
                $value['totalPriceAll']-($value['product']['discount_price']*$value['qty'])+
                ($value['product']['retail_price']*$value['qty'])-$value['totalPriceAll'];
            } else {
                $order_detail->discount_price = 0;
            }
            $order_detail->remarks_product  = $value['note'];
            $order_detail->currency         = $currency;
            $order_detail->variant_id       = isset($value['variant'])?$value['variant']['id']:null;
            $order_detail->MerchantOrder()->associate($merchant_orders);
            $order_detail->save();

            //Store data detail ProductAttribute
            if ($value['attribute']) {
                foreach ($value['attribute'] as $key => $attribute) {
                    $pa                       = new MerchantOrderProductAttributeList;
                    $pa->product_attribute_id = $attribute['id'];
                    $pa->create_time          = Carbon::now();
                    $pa->qty                  = $attribute['qty'];
                    $pa->selling_price        = $attribute['price'];
                    $pa->merchantOrderDetail()->associate($order_detail);
                    $pa->save();
                }
                $attribute = null;
            }

            //Store data detail ProductExtraAttribute
            if ($value['extraAttribute']) {
                foreach ($value['extraAttribute'] as $key => $extraAttribute) {
                    $pea  = new MerchantOrderProductExtraAttributeList;
                    if ($extraAttribute['brand/merchant'] == 'm') {
                        $pea->merchant_extra_attribute_id = $extraAttribute['id'];
                        $mea = MerchantExtraAttribute::find($extraAttribute['id']);
                    } else {
                        $pea->brand_extra_attribute_id    = $extraAttribute['id'];
                        $mea = BrandExtraAttribute::find($extraAttribute['id']);
                    }
                    $pea->create_time      = Carbon::now();
                    $pea->qty              = $extraAttribute['qty'];
                    $pea->selling_price    = $extraAttribute['price'];
                    $pea->merchantOrderDetail()->associate($order_detail);
                    $pea->save();
                }
                $extraAttribute = null;
            }

            unset ($value);

        }

        return $merchant_orders->id;
    }
    
    public function proceedToPay(Request $request)
    {
        //set hardcode payment status
        $status = 'waiting';

        if ($status == 'waiting') {
            return view('arvi.frontend.bootstrap.page-response-wait');
        }else if( $status == 'success'){
            return view('arvi.frontend.bootstrap.page-response-success');
        }else{
            return view('arvi.frontend.bootstrap.page-response-failed');
        }
    }

    function customerEmailFail($email,$name)
    {
        //send email
        $details = [
            'name' => $name
        ];
        Mail::to("$email")->send(new CustomerFailOrder($details));
    }

    function bootstrapEmail($address)
    {
        //send email
        $details = [
            'address' => $address,
        ];
        Mail::to("bootstrap@gmail.com")->send(new MerchantOrderEmail($details));
    }


    function failed(Request $request,$code)
    {
        $totalPrice      = $request->totalPrice;
        $currency        = $request->currency;
        $payment         = $request->payment;
        return view('arvi.frontend.store.result-payment.page-payment-failed',
            compact('totalPrice','currency','payment','code'));
    }

    function success(Request $request,$code)
    {
        $totalPrice = $request->totalPrice;
        $currency   = $request->currency;
        $payment    = $request->payment;
        $paymentId  = $request->paymentId;

        // sent email receipt
        $order = MerchantOrder::where('payment_id',$paymentId)
        ->select(
            'id',
            'email'
        )
        ->first();
        if ($order->email != '') {
            $this->sentEmailReciept($order->id);
        }
        return view('arvi.frontend.store.result-payment.page-payment-success',
            compact('totalPrice','currency','payment','code'));
    }

    public function sentEmailReciept($orderId)
    {
        $order = MerchantOrder::
        join('merchants','merchant_orders.merchant_id','=','merchants.id')
        ->join('merchant_payments','merchant_orders.merchant_payment_id','='
        ,'merchant_payments.id')
        ->join('arvi_payment_methods','merchant_payments.payment_method_id','='
            ,'arvi_payment_methods.id')
        ->leftJoin('merchant_delivery_methods','merchant_orders.delivery_id',
        '=','merchant_delivery_methods.id')
        ->leftJoin('arvi_sub_deliveries','merchant_delivery_methods.arvi_sub_delivery_id',
        '=','arvi_sub_deliveries.id')
        ->leftJoin('arvi_deliveries','merchant_delivery_methods.arvi_delivery_id',
        '=','arvi_deliveries.id')
        ->where('merchant_orders.id',$orderId)
        ->select(
            'merchant_orders.user_id',
            'merchant_orders.order_status',
            'merchant_orders.payment_status',
            'merchant_orders.create_time',
            'merchant_orders.id',
            'merchant_orders.merchant_payment_id',
            'merchant_orders.currency',
            'merchant_orders.cost_delivery',
            'merchant_orders.total_gross_price',
            'merchant_orders.name',
            'merchant_orders.email',
            'merchant_orders.mobile_number',
            'merchant_orders.address as custAddress',
            'merchant_orders.subdistrict as custSubdistrict',
            'merchant_orders.district as custDistrict',
            'merchant_orders.city as custCity',
            'merchant_orders.province as custProvince',
            'merchants.name as merchantName',
            'merchants.id as merchantId',
            'merchants.building_state as storeBuildingSuite',
            'merchants.address as storeAddress',
            'merchants.city as storeCity',
            'merchants.state as storeState',
            'arvi_payment_methods.name as paymentName',
            'arvi_deliveries.name as deliveryName',
            'arvi_sub_deliveries.name as subDeliveryName',
        )
        ->first();

        // fees
        $merchant = Merchant::find($order->merchantId);
        $fees = Brand::find($merchant->brand_id)->fees;

        $dataEmailSuccess = new stdClass();
        $dataEmailSuccess->orderNumber      = $order->id;
        $dataEmailSuccess->merchant         = $merchant;
        $dataEmailSuccess->name             = $order->name; 
        $dataEmailSuccess->order_date       = $order->create_time;
        $dataEmailSuccess->products         = $this->getProductOrder($orderId); 
        $dataEmailSuccess->paym             = $order->paymentName;
        $dataEmailSuccess->email            = $order->email;
        $dataEmailSuccess->mobile_number    = $order->mobile_number;
        $dataEmailSuccess->fees             = $fees;
        $dataEmailSuccess->currency         = $order->currency;
        $dataEmailSuccess->totalPrice       = $order->total_gross_price;
        $dataEmailSuccess->deliveryName      = $order->deliveryName;
        $dataEmailSuccess->subDeliveryName   = $order->subDeliveryName;
        $dataEmailSuccess->cost_delivery     = $order->cost_delivery;
        $dataEmailSuccess->recepient_address = $order->recepient_address;
        $dataEmailSuccess->recepient_notes   = $order->recepient_notes;
        $dataEmailSuccess->custAddress      = $order->custAddress;
        $dataEmailSuccess->custSubdistrict  = $order->custSubdistrict;
        $dataEmailSuccess->custDistrict     = $order->custDistrict;
        $dataEmailSuccess->custCity         = $order->custCity;
        $dataEmailSuccess->custProvince     = $order->custProvince;
        $dataEmailSuccess->storeBuildingSuite = $order->storeBuildingSuite;
        $dataEmailSuccess->storeAddress     = $order->storeAddress;
        $dataEmailSuccess->storeCity        = $order->storeCity;
        $dataEmailSuccess->storeState       = $order->storeState;

        \Mail::to("$dataEmailSuccess->email")->send(new CustomerSuccessOrder($dataEmailSuccess));
    }

    public function getProductOrder($id)
    {
        $joinForOrderDetails = MerchantOrder::
        join('merchant_order_details','merchant_orders.id','=',
            'merchant_order_details.merchant_order_id')
        ->leftJoin('merchant_payments','merchant_orders.merchant_payment_id','='
            ,'merchant_payments.id')
        ->leftJoin('arvi_payment_methods','merchant_payments.payment_method_id','='
            ,'arvi_payment_methods.id')
        ->leftJoin('merchant_delivery_methods','merchant_orders.delivery_id',
        '=','merchant_delivery_methods.id')
        ->leftJoin('arvi_sub_deliveries','merchant_delivery_methods.arvi_sub_delivery_id',
        '=','arvi_sub_deliveries.id')
        ->leftJoin('arvi_deliveries','merchant_delivery_methods.arvi_delivery_id',
        '=','arvi_deliveries.id')
        ->select(
            'merchant_orders.id',
            'merchant_orders.create_time as create_time',
            'merchant_orders.day_deliver as day_deliver',
            'merchant_orders.fulfilment_status',
            'merchant_orders.delivery_id',
            'merchant_orders.delivery_type',
            'merchant_orders.order_status',
            'merchant_orders.name',
            'merchant_orders.mobile_number',
            'merchant_orders.email',
            'merchant_orders.address',
            'merchant_orders.remarks_order',
            'merchant_orders.remarks_deliver',
            'merchant_order_details.qty',
            'merchant_orders.cost_delivery',
            'merchant_orders.total_gross_price',
            'merchant_orders.currency',
            'merchant_orders.payment_status',
            'arvi_payment_methods.name as payment_methods',
            'arvi_deliveries.name as delivery_name',
            'arvi_sub_deliveries.name as subDeliveryName',
        )
        // ->where('merchant_orders.payment_status',1)
        ->where('merchant_orders.id',$id)
        ->orderBy('merchant_orders.create_time', 'desc')
        ->limit(1000)
        ->first();

        $joinProductsOrder = MerchantOrderDetail::
        leftJoin('merchant_order_product_attribute_list',
        'merchant_order_product_attribute_list.merchant_order_detail_id',
        '=','merchant_order_details.id')
        ->join('merchant_products','merchant_order_details.product_id',
        '=','merchant_products.id')
        ->leftJoin('product_attributes','merchant_order_product_attribute_list.product_attribute_id',
        '=','product_attributes.id')
        ->leftJoin('merchant_product_variants','merchant_order_details.variant_id',
        '=','merchant_product_variants.id')
        ->leftJoin('merchant_order_product_extra_attribute_list',
        'merchant_order_details.id',
        '=','merchant_order_product_extra_attribute_list.merchant_order_detail_id')
        ->leftJoin('merchant_extra_attributes',
        'merchant_order_product_extra_attribute_list.merchant_extra_attribute_id',
        '=','merchant_extra_attributes.id')
        ->leftJoin('brand_extra_attributes',
        'merchant_order_product_extra_attribute_list.brand_extra_attribute_id',
        '=','brand_extra_attributes.id')
        ->select(
            'merchant_products.id as product_id',
            'merchant_products.name as product_name',
            'merchant_products.currency as product_currency',
            'merchant_order_details.id as merchant_order_detail_id',
            'merchant_order_details.merchant_order_id as merchant_order_id',
            'merchant_order_details.qty as productQty',
            'merchant_order_details.remarks_product as remarks_product',
            'merchant_order_details.selling_price',
            'merchant_order_details.discount_price',
            'merchant_order_product_attribute_list.qty as attribute_qty',
            'merchant_order_product_attribute_list.selling_price as attribute_price',
            'product_attributes.id as attribute_id',
            'product_attributes.name as attribute_name',
            'merchant_product_variants.name as variant_name',
            'merchant_product_variants.retail_price as variant_price',
            'merchant_extra_attributes.id as m_extra_attribute_id',
            'merchant_extra_attributes.name as m_extra_attribute_name',
            'merchant_extra_attributes.fee as m_extra_attribute_price',
            'brand_extra_attributes.id as b_extra_attribute_id',
            'brand_extra_attributes.name as b_extra_attribute_name',
            'brand_extra_attributes.fee as b_extra_attribute_price',
            'merchant_order_product_extra_attribute_list.qty as extra_attribute_qty',
        )
        ->where('merchant_order_details.merchant_order_id',$id)
        ->get();
        
        // reform data
        $reformJoinProductsOrder = [];
        $merchant_order_detail_id = '';
        $price = [];
        foreach ($joinProductsOrder as $key => $value) {

            $reformJoinProductsOrder[$value['merchant_order_detail_id']]
            ['merchant_order_detail_id'] = $value['merchant_order_detail_id'];
            $reformJoinProductsOrder[$value['merchant_order_detail_id']]
            ['qty'] = $value['productQty'];

            $reformJoinProductsOrder[$value['merchant_order_detail_id']]['product'] = [
                'product_id'        => $value['product_id'],
                'product_name'      => $value['product_name'],
                'product_currency'  => $value['product_currency'],
                'selling_price'     => $value['selling_price'],
                'discount_price'    => $value['discount_price'],
            ];

            if ($value['variant_name']) {
                $reformJoinProductsOrder[$value['merchant_order_detail_id']]['variant'] = [
                    'variant_name'  => $value['variant_name'],
                    'variant_price' => $value['variant_price'],
                ];
            }
            
            if ($value['attribute_id']) {
                $reformJoinProductsOrder[$value['merchant_order_detail_id']]
                ['attribute'][$value['attribute_id']] = [
                    'attribute_name'  => $value['attribute_name'],
                    'attribute_qty'   => $value['attribute_qty'],
                    'attribute_price' => $value['attribute_price'],
                ];
            }

            if ($value['m_extra_attribute_id']) {
                $reformJoinProductsOrder[$value['merchant_order_detail_id']]
                ['extra_attribute'][$value['m_extra_attribute_id']] = [
                    'extra_attribute_name'  => $value['m_extra_attribute_name'],
                    'extra_attribute_qty'   => $value['extra_attribute_qty'],
                    'extra_attribute_price' => $value['m_extra_attribute_price'],
                ];
            }

            if ($value['b_extra_attribute_id']) {
                $reformJoinProductsOrder[$value['merchant_order_detail_id']]
                ['extra_attribute'][$value['b_extra_attribute_id']] = [
                    'extra_attribute_name'  => $value['b_extra_attribute_name'],
                    'extra_attribute_qty'   => $value['extra_attribute_qty'],
                    'extra_attribute_price' => $value['b_extra_attribute_price'],
                ];
            }

            if ($value['remarks_product']) {
                $reformJoinProductsOrder[$value['merchant_order_detail_id']]
                ['remarks_product'] = $value['remarks_product'];
            }

            $value = null;

        }


        //sum all data base on product
        $price = [];
        foreach ($reformJoinProductsOrder as $key => $value) {

            // base price
            $selling_price = (float) $value['product']['selling_price'];

            // discount price
            $discount_price = (float) $value['product']['discount_price'];

            // variant
            $variant_price = 0;
            if (isset($value['variant'])) {
                $variant_price = (float) $value['variant']['variant_price'];
            }

            // attribute
            $attribute_price = 0;
            if (isset($value['attribute'])) {
                foreach ($value['attribute'] as $key => $value1) {
                    $attribute_price += 
                    (float) $value1['attribute_price']*(float) $value1['attribute_qty'];
                }
            }

            // extra attribute
            $extra_attribute_price = 0;
            if (isset($value['extra_attribute'])) {
                foreach ($value['extra_attribute'] as $key => $value2) {
                    $extra_attribute_price += 
                    (float) $value2['extra_attribute_price']*(float) $value2['extra_attribute_qty'];
                }
            }

            $priceAll[$value['merchant_order_detail_id']]['price'] = ($selling_price / $value['qty']);
            $priceAll[$value['merchant_order_detail_id']]['total_price'] = ($selling_price);
            $priceAll[$value['merchant_order_detail_id']]['discount_price'] = ($discount_price);

        }

        $data = new stdClass();
        $data->joinForOrderDetails      = $joinForOrderDetails;
        $data->joinProductsOrder        = $joinProductsOrder;
        $data->reformJoinProductsOrder  = $reformJoinProductsOrder; 
        $data->priceAll                 = $priceAll; 

        return $data;
    }
}
