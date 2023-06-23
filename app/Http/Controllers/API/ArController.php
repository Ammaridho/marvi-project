<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArviDelivery;
use App\Models\ArviDeliveryType;
use App\Models\MerchantDefinedDelivery;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\MerchantProduct;
use App\Models\ProductAttribute;
use App\Models\MerchantProductVariant;
use App\Models\BrandProduct;
use App\Models\BrandExtraAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\MerchantOrderProductExtraAttributeList;
use App\Models\MerchantOrderProductAttributeList;
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

use Illuminate\Support\Facades\Auth;

class ArController extends Controller
{
    public function store(Request $request)
    {
        $store = Merchant::join('brands','brands.id','=','merchants.brand_id')
        ->join('locations','locations.id','=','merchants.location_id')
        ->select(
            'brands.name as brandName',
            'brands.image_url as brandImage',
            'locations.name as locationName',
            'merchants.name as merchantName',
            'merchants.code',
            'merchants.description',
            'merchants.address',
            'merchants.city',
            'merchants.state',
            'merchants.country',
            'merchants.postal_code',
            'merchants.image_url as image',
            'merchants.phone_number',
            'merchants.currency',
        )
        ->where('merchants.code',$request->storeCode)
        ->get();

        if (count($store) < 1) {
            return response()->json(['message'=>'store not found','status'=>404]);
        }

        return response()->json(compact('store'));
    }

    public function product(Request $request)
    {
        $products = MerchantProduct::join('merchants','merchants.id','=','merchant_products.merchant_id')
        ->join('product_images','product_images.merchant_product_id','=','merchant_products.id')
        ->select(
            'merchant_products.id',
            'merchant_products.name',
            'merchant_products.sku',
            'product_images.url as image',
            'merchant_products.description',
            'merchant_products.retail_price',
            'merchant_products.currency',
            'merchant_products.uom',
            'merchant_products.weight',
            'merchant_products.uow',
            'merchant_products.preparation_time',
            'merchant_products.min_order',
            'merchant_products.max_order',
            'merchant_products.available_days',
        )
        ->with(['merchantProductVariants' => function($a){
            $a->select(
                'merchant_product_variants.id', 
                'merchant_product_variants.merchant_product_id',
                'merchant_product_variants.name',
                'merchant_product_variants.sku',
                'merchant_product_variants.retail_price',
                'merchant_product_variants.currency_price',
                'merchant_product_variants.weight',
                'merchant_product_variants.uow',
                'merchant_product_variants.uom',
            );
        }])
        ->with(['productAttributes' => function($a){
        $a->select(
            'product_attributes.id', 
            'product_attributes.merchant_product_id',
            'product_attributes.name',
            'product_attributes.sku',
            'product_attributes.retail_price',
            'product_attributes.currency',
            'product_attributes.weight',
            'product_attributes.uow',
            'product_attributes.uom',
        );
        }])
        ->with(['merchantExtraAttributes'=> function($a){
            $a->select(
                'merchant_extra_attributes.id', 
                'merchant_extra_attributes.name',
                'merchant_extra_attributes.sku',
                'merchant_extra_attributes.fee',
                'merchant_extra_attributes.currency',
                'merchant_extra_attributes.weight',
                'merchant_extra_attributes.uow',
                'merchant_extra_attributes.uom',
            );
        }])
        ->with(['brandExtraAttributes'=> function($a){
            $a->select(
                'brand_extra_attributes.id', 
                'brand_extra_attributes.name',
                'brand_extra_attributes.sku',
                'brand_extra_attributes.fee',
                'brand_extra_attributes.currency',
                'brand_extra_attributes.weight',
                'brand_extra_attributes.uow',
                'brand_extra_attributes.uom',
            );
        }])
        ->with('merchantProductExtra')
        ->where('merchants.code',$request->storeCode)
        ->get();

        if (count($products) < 1) {
            return response()->json(['message'=>'store not found','status'=>404]);
        }

        return response()->json(compact('products'));
    }

    function storeDataAndPaymentProviderUrl(Request $request) {

        $cart          = $request->cart;
        $email         = $request->email;
        if (!$merchant = Merchant::where('code',$request->storeCode)->first()) {
            return response()->json(['message'=>'store not found','status'=>404]);
        }
        // check name
        if (isset($request->name)) {
            $name      = $request->name;
        } else {
            $name      = $merchant->name;
        }
        $merchantId    = $merchant->id;

        // order_type
        switch ($request->order_type) {
            case 'take_away':
                $deliveryType  = 2; 
                break;
            
            default:
                $deliveryType  = 3;  //default dine in
                break;
        }
        
        // reform data form cart
        $shoppingCarts = [];
        $deliveryId    = 1;
        $totalDiscount = 0;
        $totalPrice    = 0;

        // get payment id
        $paymId = MerchantPayment::join('arvi_payment_providers',
        'arvi_payment_providers.id','=','merchant_payments.payment_provider_id')
        ->where('merchant_payments.merchant_id',$merchantId)
        ->where('arvi_payment_providers.name','Stripe')
        ->select('merchant_payments.merchant_id',
        'arvi_payment_providers.name','merchant_payments.id')
        ->first()->id;  
        
        if (!is_array($cart)) {
            return response()->json(['message'=>'cart data not valid','status' => 400]);
        }

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

                $totalPrice += $value['totalPriceAll'];

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
        $currency      = $brand->currency;

        // Store Processs merchant_orders
        $create_time    = Carbon::now();
        $source_ip      = \Request::ip();

        // hard code get id prvider set stripe
        $paymentProviderId = ArviPaymentProvider::where('name','Stripe')->first()->id;
        
        //Get info on Payment method
        $_mPayment = MerchantPayment::find($paymId);
        if (!$_mPayment) {
            $err = "CANT FIND PAYMENT METHOD! by id: " . $paymId;
            \Log::error($err);
            throw new \Exception("CANT FIND PAYMENT METHOD!");
        }

        \Log::info($shoppingCarts);

        //Save Order to database:
        //TX?
        DB::beginTransaction();

        // store data order
         $newOrder = new MerchantOrder;
         $newOrder->user_id             = isset(Auth::user()->id)?Auth::user()->id:null;
         $newOrder->merchant_id         = $merchantId;
         $newOrder->brand_id            = $brand->id;
         $newOrder->create_time         = $create_time;
         $newOrder->day_deliver         = $create_time;
         $newOrder->source_ip           = $source_ip;
         $newOrder->name                = $name;
         $newOrder->email               = $email;
         $newOrder->delivery_id         = 0; //no courier
         $newOrder->delivery_type       = $deliveryType;
         $newOrder->cost_delivery       = isset($courier['cost_delivery'])?
                                                $courier['cost_delivery']:0;
         $newOrder->currency            = $currency;
         $newOrder->total_gross_price   = $totalPrice;
         $newOrder->arvi_session_id     = StripeService::generateId();
         $newOrder->discount            = $totalDiscount;
         $newOrder->merchant_payment_id = $paymId;
        //  $newOrder->payment_type        = $_mPayment->category;
         $newOrder->payment_id          = RandomGenerator::generateSimpleCode(7);
         $newOrder->save();

        try {

            // relation to fee brand
            $feeId = Brand::
            join('merchants','brands.id','=','merchants.brand_id')
            ->join('brand_fee_list','brands.id','=','brand_fee_list.brand_id')
            ->where('merchants.id',$merchantId)
            ->pluck('fee_id');
    
            // // many to many relation fee brand
             $newOrder->fees()->attach($feeId,
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
                $order_detail->MerchantOrder()->associate($newOrder);
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

            if (ArviPaymentProvider::STRIPE == $paymentProviderId) {

                $ee = new StripeArviCheckout();
                $ee->arviSessionId = $newOrder->arvi_session_id;
                $ee->name = $name;
                $ee->email = $email;
                

                $stripeService = new StripeService();
                \Log::info("Going to call stripe for order session_id: " . $ee->arviSessionId);

                DB::commit();

                $entry = new StripeArviEntryCheckout();
                $entry->entries = $shoppingCarts;
                $ee->entries = $entry->entries;

                // redirect
                $ee->successUrl = $request->link_redirect_success;
                $ee->cancelUrl = $request->link_redirect_cancel;

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
