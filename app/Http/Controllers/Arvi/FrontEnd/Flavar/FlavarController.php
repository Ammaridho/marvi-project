<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Flavar;

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
use App\Models\BrandExtraAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\MerchantOrderProductExtraAttributeList;
use App\Models\MerchantOrderProductAttributeList;
use App\Models\Payments\ArviPaymentProvider;
use App\Models\Payments\ArviPaymentMethod;
use App\Models\Payments\MerchantPayment;
use App\Models\Payments\StripeArviCheckout;
use App\Models\Payments\StripeArviEntryCheckout;
use App\Models\Payments\ArviPaymentStatus;
use App\Mail\Arvi\Flavar\CustomerCancelOrder;
use App\Mail\Arvi\Flavar\CustomerSuccessOrder;
use App\Services\RandomGenerator;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Payload\FailedOrderMailPayload;
use App\Mail\Payload\SuccessOrderMailPayload;

use Illuminate\Support\Facades\Auth;

class FlavarController extends Controller
{
    const DEFAULT_CURRENCY = "IDR";
    const DEFAULT_UOM = "PCS";
    const BOOK_SESSION_ID = "BOOK_SESS";

    function store(Request $request) {
        
         // reform data form cart
        $shoppingCarts = [];
        $deliveryId    = 1;
        $totalDiscount = 0;

        // HARD CODE
        $cart = '[{"idMerchant":"6","idProduct":"50","qty":2,"weight":0,"totalWeight":0,"variant":{"id":null,"price":null,"weight":0},"attribute":[],"extraAttribute":[],"note":"","totalPricePerProduct":12000,"totalPriceAll":24000},{"idMerchant":"6","idProduct":"55","qty":3,"weight":0,"totalWeight":0,"variant":{"id":null,"price":null,"weight":0},"attribute":[],"extraAttribute":[],"note":"","totalPricePerProduct":11000,"totalPriceAll":33000},{"idMerchant":"6","idProduct":"51","qty":2,"weight":22,"totalWeight":44,"variant":{"id":null,"price":null,"weight":0},"attribute":[],"extraAttribute":[],"note":"","totalPricePerProduct":1,"totalPriceAll":2},{"idMerchant":"6","idProduct":"49","qty":2,"weight":2,"totalWeight":4.6,"variant":{"id":null,"price":null,"weight":0},"attribute":[],"extraAttribute":[{"id":1,"price":5000,"qty":"1","type":"b","weight":0.3}],"note":"","totalPricePerProduct":5001,"totalPriceAll":10002},{"idMerchant":"6","idProduct":"56","qty":2,"weight":0.2,"totalWeight":0.4,"variant":{"id":44,"price":2000,"weight":0.2},"attribute":[{"id":75,"price":3000,"qty":1,"weight":0},{"id":76,"price":1000,"qty":1,"weight":0},{"id":77,"price":2000,"qty":1,"weight":0}],"extraAttribute":[],"note":"","totalPricePerProduct":12000,"totalPriceAll":24000}]';

        $data = new stdClass;
        $data->name  = 'ammaridhoteststripe';
        $data->email = 'ammaridho@gmail.com';

        $cart          = json_decode($cart, true);
        $merchantId    = 6;
        $deliveryType  = 1;       
        $totalPrice    = 10000;    
        $paymp         = 42;     

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
        $currency      = $brand->currency;

        // Store Processs merchant_orders
        $create_time    = Carbon::now();
        $source_ip      = \Request::ip();
        $paymId     = $paymp;

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
         $newOrder->name                = $data->name;
         $newOrder->email               = $data->email;
         $newOrder->delivery_id         = $deliveryType!=1?0:$deliveryId;
         $newOrder->delivery_type       = $deliveryType;
         $newOrder->cost_delivery       = isset($courier['cost_delivery'])?
                                                $courier['cost_delivery']:0;
         $newOrder->currency            = $currency;
         $newOrder->total_gross_price   = $totalPrice;
         $newOrder->arvi_session_id     = StripeService::generateId();
         $newOrder->discount            = $totalDiscount;
         $newOrder->merchant_payment_id = $paymp;
         $newOrder->payment_type        = $_mPayment->category;
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
                $ee->name = $data->name;
                $ee->email = $data->email;
                

                $stripeService = new StripeService();
                \Log::info("Going to call stripe for order session_id: " . $ee->arviSessionId);

                DB::commit();

                $entry = new StripeArviEntryCheckout();
                $entry->entries = $shoppingCarts;
                $ee->entries = $entry->entries;

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

     /**
     * Process on success call after stripe
     * @param $arviSessionId
     */
    public function onSuccess(Request $request,$arviSessionId) {

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
                    $entry->orderNumber = $ord->id;
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
                        ->send(new CustomerSuccessOrder($entry));

                    Log::info("Sent email to: {$ord->email}. Order#: {$entry->orderNumber}");

                }
            } catch (\Exception $exception) {
                Log::error("Error sending success email to: {$ord->email}. Message: {$exception->getMessage()}");
            }

        }
        // return view('arvi.frontend.bootstrap.stripe.success', compact('ord','payment'));
        return redirect($request->successUrl);
    }

    /**
     * Process on failed call after stripe
     * @param $arviSessionId
     */
    public function onFailed(Request $request,$arviSessionId) {
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
                    $entry->orderNumber = $ord->id;
                    $entry->merchantCode = '';
                    if ($merchant) {
                        $entry->merchant = $merchant->name;
                        $entry->merchantCode = $merchant->code;
                        $entry->urlBuy = url('/m/' . $merchant->code);
                    }

                    //Get info on purchase details
                    Mail::to($ord->email)
                        ->send(new CustomerCancelOrder($entry));

                    Log::info("Sent failed purchase email to: {$ord->email}. Order#: {$entry->orderNumber}");

                }
            } catch (\Exception $exception) {
                Log::error("Error sending failed email to: {$ord->email}. Message: {$exception->getMessage()}");
            }

        }
        // return view('arvi.frontend.bootstrap.stripe.failed', compact('ord','payment'));
        return redirect($request->cancelUrl);
    }
}
