<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabPOS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\ProductCategory;
use App\Models\BrandCategory;
use App\Models\MerchantProduct;
use App\Models\ProductAttribute;
use App\Models\MerchantProductVariant;
use App\Models\BrandExtraAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantOrderProductAttributeList;
use App\Models\MerchantOrderProductExtraAttributeList;
use Illuminate\Support\Facades\Auth;


use App\Models\Payments\MerchantPayment;
use App\Models\User;
use Jenssegers\Agent\Agent as Agent;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\ArviPaymentMethod;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Mail\Arvi\OobeIndonesia\CustomerSuccessOrder;

class TabPOSController extends Controller
{

    protected $view = 'arvi.backend.POS.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {

            $idMerchants = json_decode(User::where('email',$request->session()->get('email'))
                ->first()->store_id);
            
            if ($idMerchants == null) {
                return view($this->view.'alert-access');
            } 
            
            if (count($idMerchants)>1) {
                return view($this->view.'alert-access');
            }

            $idMerchant = $idMerchants[0];
            $merchantId = $idMerchant;
            $merchant = Merchant::find($merchantId);

            $categoriesM = [];
            $categoriesB = [];
            $categoriesM = MerchantProduct::
                join('product_category_list','merchant_products.id','=',
                'product_category_list.merchant_product_id')
                ->join('product_categories','product_category_list.product_category_id',
                '=','product_categories.id')
                ->leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.merchant_id',$merchantId)
                ->where('product_categories.active',1)
                ->select('product_categories.category_name')
                ->orderBy('product_categories.category_name','asc')
                ->distinct('product_categories.category_name')
                ->pluck('product_categories.category_name')
                ->toArray();

            $categoriesB = MerchantProduct::
                join('product_category_list','merchant_products.id','=',
                'product_category_list.merchant_product_id')
                ->join('brand_categories','product_category_list.brand_category_id',
                '=','brand_categories.id')
                ->leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.merchant_id',$merchantId)
                ->where('brand_categories.active',1)
                ->select('brand_categories.category_name')
                ->orderBy('brand_categories.category_name','asc')
                ->distinct('brand_categories.category_name')
                ->pluck('brand_categories.category_name')
                ->toArray();

            $categories = array_merge($categoriesM,$categoriesB);

            // all product data
            $dataProducts = MerchantProduct::
                leftJoin('product_category_list','merchant_products.id','=',
                'product_category_list.merchant_product_id')
                ->leftJoin('brand_categories','product_category_list.brand_category_id',
                '=','brand_categories.id')
                ->leftJoin('product_categories','product_category_list.product_category_id',
                '=','product_categories.id')
                ->leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.merchant_id',$merchantId)
                ->select(
                    'merchant_products.id as merchant_product_id',
                    'merchant_products.name as name',
                    'merchant_products.currency',
                    'merchant_products.retail_price',
                    'merchant_products.description',
                    'merchant_products.active',
                    'brand_categories.category_name as brand_categories',
                    'product_categories.category_name as product_categories',
                    'product_images.url',
                    'product_images.image_mime',
                    'product_images.image_type'
                )
                ->orderBy('name','asc')
                ->where('merchant_products.active',1)
                ->get()
                ->unique('merchant_product_id');

            // combine data base on category
            $listProduct = [];
            foreach ($dataProducts as $key => $value) {
                if (!($value['brand_categories']||$value['product_categories'])) {
                    $listProduct['noCategory'][] = $value;
                }
                if ($value['brand_categories']) {
                    $listProduct[$value['brand_categories']][] = $value;
                }
                if ($value['product_categories']) {
                    $listProduct[$value['product_categories']][] = $value;
                }
            }
            
            return view($this->view.'index',
                compact('companyCode','merchantId','categories','listProduct'));
        }
        return view('arvi.page-not-available');
    }

    public function category(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {

            $idMerchants = json_decode(User::where('email',$request->session()->get('email'))
                ->first()->store_id)[0];
            
            $merchantId = $idMerchants;

            $category = $request->cat;

            // all product data
            $dataProducts = MerchantProduct::
                leftJoin('product_category_list','merchant_products.id','=',
                'product_category_list.merchant_product_id')
                ->leftJoin('brand_categories','product_category_list.brand_category_id',
                '=','brand_categories.id')
                ->leftJoin('product_categories','product_category_list.product_category_id',
                '=','product_categories.id')
                ->leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.merchant_id',$merchantId)
                ->select(
                    'merchant_products.id as merchant_product_id',
                    'merchant_products.name as name',
                    'merchant_products.currency',
                    'merchant_products.retail_price',
                    'merchant_products.description',
                    'merchant_products.active',
                    'brand_categories.category_name as brand_categories',
                    'brand_categories.active',
                    'product_categories.category_name as product_categories',
                    'product_categories.active',
                    'product_images.url',
                    'product_images.image_mime',
                    'product_images.image_type'
                )
                ->orderBy('name','asc')
                ->where('merchant_products.active',1);
                if ($category == 'All Items') {
                    $dataProducts = $dataProducts->get()->unique('merchant_product_id');
                }else{
                    $dataProducts = $dataProducts->where('product_categories.category_name',$category)
                    ->orWhere('brand_categories.category_name',$category)->get()->unique('merchant_product_id');
                }
                
            
            return view($this->view.'list-product',
            compact('companyCode','dataProducts'));        
        }
        return view('arvi.page-not-available');
    }

    public function addProduct(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {

            $product = MerchantProduct::
                leftJoin('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.id',$request->productId)
                ->select(
                    'merchant_products.id',
                    'merchant_products.merchant_id',
                    'merchant_products.name',
                    'merchant_products.weight',
                    'merchant_products.retail_price', 
                    'merchant_products.discount_price', 
                    'merchant_products.currency',
                    'merchant_products.description',
                    'product_images.url',
                )
                ->first();

            $merchantId = $product->merchant_id;
            $productAttributes = ProductAttribute::
                where('merchant_product_id',$request->productId)
                ->get();
            $productVariants = MerchantProductVariant::
                where('merchant_product_id',$request->productId)
                ->get();

            // brand extra attribute
            $brand_extra_attributes = MerchantProduct::
                join('merchant_extra_attribute_list','merchant_products.id','=',
                'merchant_extra_attribute_list.merchant_product_id')
                ->join('brand_extra_attributes','merchant_extra_attribute_list.brand_extra_attribute_id',
                '=','brand_extra_attributes.id')
                ->select(
                    'brand_extra_attributes.name',
                    'brand_extra_attributes.id',
                    'brand_extra_attributes.fee',
                    'brand_extra_attributes.currency',
                    'brand_extra_attributes.brand_id',
                    'brand_extra_attributes.weight',
                    'brand_extra_attributes.sku',
                    )
                ->where('merchant_products.id',$request->productId)
                ->get()->toArray();

            // merchant extra attribute
            $merchant_extra_attributes = MerchantProduct::
                join('merchant_extra_attribute_list','merchant_products.id','=',
                'merchant_extra_attribute_list.merchant_product_id')
                ->join('merchant_extra_attributes',
                'merchant_extra_attribute_list.merchant_extra_attribute_id',
                '=','merchant_extra_attributes.id')
                ->select(
                    'merchant_extra_attributes.name',
                    'merchant_extra_attributes.id',
                    'merchant_extra_attributes.fee',
                    'merchant_extra_attributes.currency',
                    'merchant_extra_attributes.weight',
                    'merchant_extra_attributes.sku',
                    )
                ->where('merchant_products.id',$request->productId)
                ->get()->toArray();

            $extraAttributes = array_merge($brand_extra_attributes,$merchant_extra_attributes);

            $cartId = $request->cartId;

            return view($this->view . 'add-product',
            compact('companyCode','product','merchantId',
            'productAttributes','productVariants',
                'extraAttributes','cartId'));   
        }
        return view('arvi.page-not-available');
    }

    public function detailOrder(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {
            $shoppingCarts = [];
            $cart = $request->cart;
            $merchantId = $request->merchantId;
            
            // total price
            $totalPrice = 0;

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
                        'merchants.brand_id as brandId',
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
                        $variant['name']  = 
                            MerchantProductVariant::find($value['variant']['id'])->name;
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
                            // check brand extra attribute have index 3
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
                        'product'                => $product,
                        'variant'                => isset($variant)?$variant:null,
                        'qty'                    => $qty,
                        'attribute'              => isset($attribute)?$attribute:null,
                        'extraAttribute'         => isset($extraAttribute)?$extraAttribute:null,
                        'note'                   => $note,
                        'totalPricePerProduct'   => $value['totalPricePerProduct'],
                        'totalPriceAll'          => $value['totalPriceAll'],
                        'weight'                 => $value['weight'],
                        'totalWeight'            => $value['totalWeight'],
                        'discount'               => $qty * (isset($product['discount_price'])?$product['discount_price']:0),
                        'price'                  => $qty * $product['retail_price']
                    ];
                    // reset data
                    $attribute = null;
                    $extraAttribute = null;

                    $totalPrice += $qty * $value['totalPricePerProduct'];
                }
            }
            
            // merchants
            $merchant = Merchant::find($merchantId);
            // fees
            $fees = Brand::find($merchant->brand_id)->fees;
            // currency
            $currency = $merchant->currency;
                    
            return view($this->view . 'detail-order',
            compact('shoppingCarts','companyCode','totalPrice','currency','fees'));
        }
        return view('arvi.page-not-available');
    }

    public function choosePayment(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {
            // collect data
            $cart = $request->cart;
            $merchantId = $request->merchantId;
            $selesType  = $request->selesType;
            $totalPrice = $request->totalPrice;

            // currency
            $currency = Merchant::find($merchantId)->currency;
            $merchantName = Merchant::find($merchantId)->name;

            // payments
            $paymentMerchants = MerchantPayment::
            join('arvi_payment_methods','arvi_payment_methods.id',
            '=','merchant_payments.payment_method_id')
            ->select('*','merchant_payments.id as id')
            ->where('merchant_id',$merchantId)->get();
            $payments = array();
            $Agent = new Agent();
            foreach ($paymentMerchants as $_paym) {

                // only display cash, ew and qr
                if (!(in_array($_paym->category,['QR_CODE','EWALLET','CASH']))) {
                    continue;
                }

                // link aja not active
                if (ArviPaymentMethod::find($_paym->payment_method_id)->name == 'LinkAja') {
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

            // fee
            // relation to fee brand
            $fees = Brand::
            join('merchants','brands.id','=','merchants.brand_id')
            ->join('brand_fee_list','brands.id','=','brand_fee_list.brand_id')
            ->join('fees','brand_fee_list.fee_id','=','fees.id')
            ->where('merchants.id',$merchantId)
            ->select('fees.name','fees.type_fee','fees.value_fee',
            'fees.type_value','fees.currency')
            ->get();

            // bundle based category
            $bundlePayments = array();
            foreach ($payments as $key => $value) {
                $bundlePayments[$value['category']][] = $value;
            }

            $custCash = [
                50000,
                100000,
                150000,
                200000
            ];

            return view($this->view . 'payment-method',
                compact('companyCode','merchantId','currency',
                'totalPrice','bundlePayments','custCash',
                'selesType','merchantName'));
        }
        return view('arvi.page-not-available');
    }

    public function storePOS(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {   
            $totalPrice    = $request->totalPrice;       
            $custCash      = $request->custCash;  
            $channel_code  = $request->channel_code;   
            $name          = $request->name;   

            $id         = Str::random(10);

            $data = new stdClass();
            $data->cart                 =  $request->cart;
            $data->paymp                =  $request->paymp;
            $data->channel_code         =  $request->channel_code;
            $data->merchantId           =  $request->merchantId;
            $data->deliveryId           =  $request->deliveryId;
            $data->totalPrice           =  $request->totalPrice;
            $data->name                 =  $request->name;
            $data->email                =  $request->email;
            $data->selesType            =  $request->selesType;
            $data->custCash             =  $request->custCash;
            $data->id                   =  $id;

            // currency
            $merchant      = Merchant::find($request->merchantId);
            $brand         = Brand::find($merchant->brand_id);
            $currency      = $merchant->currency;

            $payment = new stdClass();
            $payment->totalPrice    = $totalPrice;
            $payment->currency      = $currency;
            $payment->id            = $id;
            $payment->name          = $name;
            $payment->channel_code  = $channel_code;

            $data->payment = $payment;

            switch ($channel_code) {
                case 'OVO' :
                    $noTelpOvo = '+'.preg_replace("/[^1-9]+/", "",$request->noTelpOvo); 

                    $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
                    ->createEwOvo($id,$channel_code,$name,(float)$totalPrice,$noTelpOvo);

                    $paymentType  = 'ew'; //ewwalet
                    $data->payment->id    = $createPayment['id'];

                    $data->merchant_order_id = $this->store($data,$paymentType); //Store to Database
                    $data->noTelpOvo = $noTelpOvo;  

                    return view($this->view . 'process-payment',
                    compact('companyCode','data'));
                    break;

                case 'DANA':

                    // create order
                    $paymentType  = 'ew'; //ewwalet
                    $data->payment->id = null;
                    $data->merchant_order_id = $this->store($data,$paymentType); //Store to Database

                    $linkSuccess  = route('pos-payment-success',
                    [
                        'companyCode' => $companyCode,
                        'channel_code'=>$channel_code,
                        'orderId'=>$data->merchant_order_id
                    ]);
                    
                    $linkFailed   = route('pos-payment-failed',
                    [
                        'companyCode' => $companyCode,
                        'channel_code'=>$channel_code,
                        'orderId'=>$data->merchant_order_id
                    ]);
                    
                    $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
                    ->createEw($id,$channel_code,$name,(float)$totalPrice,$linkSuccess,$linkFailed);

                    $data->payment->id    = $createPayment['id'];    

                    // update paymentId
                    $mo = MerchantOrder::find($data->merchant_order_id);
                    $mo->payment_id = $data->payment->id;
                    $mo->save();

                    // check desktop or mobile
                    $Agent = new Agent();
                    if ($Agent->isMobile()) {
                        return $createPayment['actions']['mobile_web_checkout_url'];
                    } else {
                        return $createPayment['actions']['desktop_web_checkout_url'];
                    }
                    break;

                case 'LinkAja':
                    $linkSuccess  = route('pos-payment-success',
                    ['companyCode' => $companyCode,'typePayment'=>1]);
                    $linkFailed   = route('pos-payment-failed',
                    ['companyCode' => $companyCode,'typePayment'=>1]);

                    $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
                    ->createEw($id,$channel_code,$name,(float)$totalPrice,$linkSuccess,$linkFailed);
                    $paymentType  = 'ew'; //ewwalet
                    $data->payment->id    = $createPayment['id'];    
                    $data->merchant_order_id = $this->store($data,$paymentType); //Store to Database

                    // check desktop or mobile
                    $Agent = new Agent();
                    if ($Agent->isMobile()) {
                        return $createPayment['actions']['mobile_web_checkout_url'];
                    } else {
                        return $createPayment['actions']['desktop_web_checkout_url'];
                    }
                    break;
                
                case 'QRIS' :
                    // create xendit qris
                    $createPayment = app('App\Http\Controllers\API\Payment\XenditController')
                    ->createQr($id,$channel_code,$name,(float)$totalPrice);

                    $paymentType  = 'qr'; //qris
                    $data->payment->id = $createPayment['id'];
                    $data->payment->reference_id = $createPayment['reference_id'];

                    //Store to Database
                    $data->merchant_order_id = $this->store($data,$paymentType); 

                    $data->timer = Carbon::now()->addMinutes(2);
                    
                    $data->qr_string = $createPayment['qr_string'];

                    return view($this->view . 'process-payment',
                    compact('companyCode','data'));
                    break;
                default:
                    $paymentType = 'cash';
                    $orderId =  $this->store($data,$paymentType); //Store to Database
                    $change = $custCash - $totalPrice;
                    $channel_code = 'CASH';
                    return view($this->view . 'complete-payment',
                    compact('companyCode','orderId','totalPrice',
                    'change','custCash','channel_code','data'));
                    break;
            }
        }
        return view('arvi.page-not-available');
    }

    public function setEmail(Request $request)
    {
        // update order status
        $order = MerchantOrder::find($request->id);
        $order->email = $request->email;
        $order->save();

        // sent email
        if (isset($order->email)) {
            $this->sentEmailReciept($order->id);
        }
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

    public function store($data,$paymentType)
    {
        // reform data form cart
        $shoppingCarts = [];
        $cart          = json_decode($data->cart, true);
        $merchantId    = $data->merchantId;
        $deliveryType  = $data->selesType;       
        $totalPrice    = $data->totalPrice;       
        $custCash      = $data->custCash;       
        $paymp         = $data->paymp;     
        $deliveryId    = 1;
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
                if ($tempVar = MerchantProductVariant::find($value['variant']['id'])) {
                    $variant['id']    = $value['variant']['id'];
                    $variant['name']  = $tempVar->name;
                    $variant['price'] = $tempVar->retail_price;
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
                        $attribute[$key1]['price'] = 
                        ProductAttribute::find($value1['id'])->retail_price;
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
                            $extraAttribute[$key2]['price'] = 
                            BrandExtraAttribute::find($value2['id'])->fee;
                        } else {
                            $extraAttribute[$key2]['id']   = $value2['id'];
                            $extraAttribute[$key2]['name'] =
                            MerchantExtraAttribute::find($value2['id'])->name;
                            $extraAttribute[$key2]['brand/merchant'] = 'm';
                            $extraAttribute[$key2]['price'] = 
                            MerchantExtraAttribute::find($value2['id'])->fee;
                        }
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
                    'totalPriceAll'         => $value['totalPriceAll']
                ];

                $attribute = null;
                $extraAttribute = null;

                $totalDiscount += $qty * 
                (isset($product['discount_price'])?
                $product['discount_price']:0);
            }
        }

        // collect all data and reform
        $merchant      = Merchant::find($merchantId);
        $brand         = Brand::find($merchant->brand_id);
        $currency      = $merchant->currency;

        // Store Processs merchant_orders
        $create_time    = Carbon::now();
        $source_ip      = \Request::ip();

        // get payment cash this merchant

        // store data order
        $merchant_orders = new MerchantOrder;
        $merchant_orders->user_id             = isset(Auth::user()->id)?Auth::user()->id:null;
        $merchant_orders->merchant_id         = $merchantId;
        $merchant_orders->brand_id            = $brand->id;
        $merchant_orders->create_time         = $create_time;
        $merchant_orders->day_deliver         = $create_time;
        $merchant_orders->source_ip           = $source_ip;
        $merchant_orders->name                = $data->name;
        $merchant_orders->email               = $data->email;
        $merchant_orders->delivery_id         = $deliveryType!=1?0:$deliveryId;
        $merchant_orders->delivery_type       = $deliveryType;
        $merchant_orders->cost_delivery       = isset($courier['cost_delivery'])?
                                                $courier['cost_delivery']:0;
        $merchant_orders->currency            = $currency;
        $merchant_orders->loc_tz              = $merchant->loc_tz;
        $merchant_orders->total_gross_price   = $totalPrice;
        $merchant_orders->discount            = $totalDiscount;
        $merchant_orders->merchant_payment_id = $paymp;
        $merchant_orders->payment_type        = $paymentType;
        $merchant_orders->payment_id          = $data->payment->id;
        // check provider-payment or cash
        if ((float) $custCash > 0) {
            $merchant_orders->payment_status      = 1;  //set already payed
        }            
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
            $order_detail->variant_id       = isset($value['variant'])?
                                              $value['variant']['id']:null;
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

    public function checkPaymentCallback(Request $request)
    {
        $paymentId = $request->paymentId;
        
        if (MerchantOrder::where('payment_id',$paymentId)->first()) {
            $order = MerchantOrder::where('payment_id',$paymentId)
            ->select(
                'payment_status',
            )
            ->first();
            // cek payment is already payed
            if ($order->payment_status == 1) {
                return 1;
            }
            return 0;
        }

        return 'not exist';
    }

    public function cancelPayment(Request $request)
    {
        $paymentId = $request->paymentId;
        $order = MerchantOrder::where('payment_id',$paymentId)->first();
        $order->order_status = 0;
        $order->save();
    }

    public function success(Request $request)
    {
        $channel_code = $request->channel_code;
        $companyCode = $request->companyCode;
        $orderId = $request->orderId;
        $order = MerchantOrder::join('merchant_payments',
        'merchant_orders.merchant_payment_id','=','merchant_payments.id')
        ->leftJoin('arvi_payment_methods','merchant_payments.payment_method_id',
        '=','arvi_payment_methods.id')
        ->select(
            'merchant_orders.total_gross_price',
            'merchant_orders.currency',
            'arvi_payment_methods.name as payment_methods',
        )
        ->where('merchant_orders.id',$orderId)
        ->first();
        return view($this->view . 'complete-payment',
        compact('channel_code','companyCode','orderId','order'));
    }
    
    public function failed(Request $request)
    {
        $channel_code = $request->channel_code;
        $companyCode = $request->companyCode;
        $orderId = $request->orderId;
        return view($this->view .
        'payment-status.failed-payment',
        compact('channel_code','companyCode','orderId'));
    }
}
