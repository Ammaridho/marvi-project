<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

use App\Models\UserAddress;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\MerchantPayment;
use Illuminate\Support\Facades\Validator;
use App\Models\Payments\ArviPaymentMethod;
use stdClass;
use Carbon\Carbon;

class CheckOutController extends Controller
{
    protected $view = 'arvi.frontend.area.check-out.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$code)
    {
        $shoppingCarts = [];
        $cart = json_decode($request->cart, true);

        if (isset($cart)) {

            foreach ($cart as $key => $value) {
                // product
                $product = MerchantProduct::
                join('product_images','merchant_products.id','=',
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
        compact('shoppingCarts','code'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deliveryOrder(Request $request,$code)
    {
        // location
        $location = Location::where('code',$code)->first();
        $cart = json_decode($request->cart, true);
        $merchant_id = MerchantProduct::find($cart[0]['idProduct'])->merchant_id;
        $merchant = Merchant::find($merchant_id);
        $deliveryMethod = ArviDelivery::all();
        if (Auth::check()){
            $saved_address = UserAddress::where('user_id',Auth::user()->id)->get();
        }else{
            $saved_address = [];
        }
        return view($this->view . 'page-orders',
            compact('merchant','deliveryMethod',
                'saved_address','code','location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentOrder(Request $request,$code)
    {
        $cart = json_decode($request->cart, true);
        $bioCust = $request->bioCust;

        // location
        $location = Location::where('code',$code)->first();
        $deliveryId = $request->deliveryId;
        $merchant_id = MerchantProduct::find($cart[0]['idProduct'])->merchant_id;
        $merchant = Merchant::find($merchant_id);
        // payments
        $paymentMechants = MerchantPayment::getByMerchant($merchant->id);
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
        $delivery = ArviDelivery::find($deliveryId);

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

        return view($this->view . 'page-payment',
            compact('merchant','delivery','payments',
                'bioCust','fees','code','location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$code)
    {

        // reform data form cart
        $shoppingCarts = [];
        $cart          = json_decode($request->cart, true);

        if (isset($cart)) {
            foreach ($cart as $key => $value) {
                // product
                $product = MerchantProduct::
                join('product_images','merchant_products.id','=',
                'product_images.merchant_product_id')
                ->where('merchant_products.id',$value['idProduct'])
                ->select(
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

                $attribute = null;
                $extraAttribute = null;

            }
        }

        // Process payment and store data to order here.. ===========================

        // collect all data and reform
        $paymentId  = $request->paymp;
        $merchantId = $request->merchantId;
        $deliveryId = $request->deliveryId;
        $totalPrice = $request->totalPrice;
        $bioCust    = json_decode($request->bioCust, true);
        $brand_id   = Merchant::find($merchantId)->brand_id;
        $currency   = Brand::find($brand_id)->currency;

        // Store Processs merchant_orders
        $create_time    = Carbon::now();
        $source_ip      = $request->ip();
        $savedAddress   = isset($bioCust['savedAddress'])?1:0;
        $name           = $bioCust['nameCust'];
        $email          = $bioCust['emailCust'];
        $mobile_number  = $bioCust['phoneCust'];
        $addressCust    = $bioCust['addressCust'];
        $notes          = $bioCust['notesCust'];
        $locationId     = $bioCust['locationId'];
        $deliveryId     = $bioCust['deliveryId'];

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
        $merchant_orders->create_time         = $create_time;
        $merchant_orders->day_deliver         = $create_time;
        $merchant_orders->source_ip           = $source_ip;
        $merchant_orders->name                = $name;
        $merchant_orders->email               = $email;
        $merchant_orders->mobile_number       = $mobile_number;
        $merchant_orders->delivery_id         = $deliveryId;
        $merchant_orders->currency            = $currency;
        $merchant_orders->address             = $addressCust;
        $merchant_orders->remarks_order       = $notes;
        $merchant_orders->total_gross_price   = $totalPrice;
        $merchant_orders->merchant_payment_id = $paymentId;
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
        foreach ($shoppingCarts as $key => $value) {
            $order_detail = new MerchantOrderDetail;
            $order_detail->merchant_id      = $value['product']['merchant_id'];
            $order_detail->create_time      = Carbon::now();
            $order_detail->product_id       = $value['product']['id'];
            $order_detail->qty              = $value['qty'];
            $order_detail->selling_price    = $value['totalPriceAll'];
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
                    $pea                   = new MerchantOrderProductExtraAttributeList;
                    if ($extraAttribute['brand/merchant'] == 'm') {
                        $pea->merchant_extra_attribute_id = $extraAttribute['id'];
                    } else {
                        $pea->brand_extra_attribute_id    = $extraAttribute['id'];
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

        return redirect()->route('payment-store-pending-area',
            ['code'=>$code,'totalPrice' => $totalPrice, 'currency' => $currency]);

        //payment name
        // $paym = ArviPaymentMethod::find($merchant_payment_id)->name;

        //send email success to customer
        // $this->customerEmailSuccess($name,$pobj,$paym,$email,$mobile_number);

        //send email to bootstrap
        // $this->bootstrapEmail($address);

    }

    public function proceedToPay(Request $request,$code)
    {

        //set hardcode payment status
        $status = 'waiting';

        // location
        $location = Location::where('code',$code)->first();

        if ($status == 'waiting') {
            return view('arvi.frontend.bootstrap.page-response-wait',
                compact('code','location'));
        }else if( $status == 'success'){
            return view('arvi.frontend.bootstrap.page-response-success',
                compact('code','location'));
        }else{
            return view('arvi.frontend.bootstrap.page-response-failed',
                compact('code','location'));
        }
    }

    function customerEmailSuccess($name,$pobj,$paym,$email,$mobile_number)
    {
        //send email
        $details = [
            'name'                  => $name,
            'products'              => $pobj,
            'paym'                  => $paym,
            'email'                 => $email,
            'telephone'             => $mobile_number,
        ];
        Mail::to("$email")->send(new OFTCustomerSuccessOrder($details));
    }

    function customerEmailFail($email,$name)
    {
        //send email
        $details = [
            'name'                  => $name
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

    function pending(Request $request,$code)
    {
        // location
        $location = Location::where('code',$code)->first();
        $totalPrice = $request->totalPrice;
        $currency = $request->currency;
        return view('arvi.frontend.area.result-payment.page-payment-pending',
            compact('totalPrice','currency','code','location'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
