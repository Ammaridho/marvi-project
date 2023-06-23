<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

use App\Models\MerchantOrder;
use App\Models\MerchantProductVariant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrderProductAttributeList;
use App\Models\ProductAttribute;
use App\Models\MerchantOrderProductExtraAttributeList;
use App\Models\MerchantExtraAttribute;
use App\Models\BrandExtraAttribute;

use Carbon\Carbon;

use stdClass;

class ApiController extends Controller
{

    protected $userkey, $barierToken;

    public function __construct()
    {
        $this->userkey = config('services.lodi.key');
        $this->barierToken = config('services.lodi.ars_bearer_token');
    }

    public function requestToken()
    {
        $client = new Client();
        $body = new stdClass();
        $body->userkey = $this->userkey;

        $request = new Request('POST', 'https://dev-api-v1.lodi.id/v3/users/authorize', 
        [], json_encode($body));
        $res = $client->sendAsync($request)->wait();
        $body = $res->getBody();
        $obj = json_decode($body,true);
        
        return $obj;
    }

    public function getCourierRates($client_id,$origin,$destination,$weight,$volume)
    {
        $requestToken = $this->requestToken();

        $client = new Client();
        $headers = [
            "Authorization" => $requestToken['id_token']
        ];

        $body = new stdClass();
        $body->origin = $origin;
        $body->destination = $destination;
        $body->client_id = $client_id;
        $body->weight = $weight;

        $request = new Request('POST', 'https://dev-api-v1.lodi.id/v3/courier/rates',
        $headers, json_encode($body));
        $res     = $client->sendAsync($request)->wait();
        $body    = $res->getBody();
        $obj     = json_decode($body,true);
        
        return $obj;
    }

    public function listOfSubDistricts()
    {
        $requestToken = $this->requestToken();

        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            "Authorization" => $requestToken['id_token']
        ];

        $request = new Request('GET', 'https://dev-api-v1.lodi.id/v2/districts/19.05.02/subs',
        $headers);
        $res     = $client->sendAsync($request)->wait();
        $body    = $res->getBody();
        $obj     = json_decode($body,true);
        
        return $obj;
    }

    public function searchDistrict($keySearch)
    {
        $requestToken = $this->requestToken();

        $barierToken = config('services.lodi.ars_bearer_token');

        $client = new Client();
        $headers = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer '.$this->barierToken,
        ];

        $request = new Request('GET', 'https://ars.lodi.id/suggest/sub-district?text='.
        $keySearch,$headers);
        $res     = $client->sendAsync($request)->wait();
        $body    = $res->getBody();
        $obj     = json_decode($body);
        
        return $obj;
    }

    public function sentOrderToLodi($paymentId)
    {
        $order = MerchantOrder::join('merchants','merchants.id','=','merchant_orders.merchant_id')
        ->where('payment_id',$paymentId)
        ->select(
            'merchant_orders.payment_status',
            'merchant_orders.delivery_id',
            'merchants.sent_order_to_lodi'
        )
        ->first();
            
        // cek payment is already payed
        if ($order->payment_status == 0) {
            return 'waiting for payment';
        }

        if ($order->sent_order_to_lodi == 1 && $order->delivery_id > 0) {
            // Sent order to Lodi ===========================
            $data = MerchantOrder::join('merchants','merchants.id','=','merchant_orders.merchant_id')
            ->join('brands','brands.id','=','merchants.brand_id')
            ->join('merchant_delivery_methods','merchant_delivery_methods.id','=','merchant_orders.delivery_id')
            ->join('arvi_deliveries','arvi_deliveries.id','=','merchant_delivery_methods.arvi_delivery_id')
            ->join('arvi_sub_deliveries','arvi_sub_deliveries.id','=','merchant_delivery_methods.arvi_sub_delivery_id')
            ->select(
                'merchant_orders.id',
                'merchant_orders.name',
                'merchant_orders.address',
                'merchant_orders.subdistrict',
                'merchant_orders.district',
                'merchant_orders.city',
                'merchant_orders.province',
                'merchant_orders.postal_code',
                'merchant_orders.mobile_number',
                'merchant_orders.total_gross_price',
                'merchant_orders.delivery_id',
                'merchant_orders.payment_status',
                'merchant_orders.payment_id',
                'arvi_deliveries.name as deliveryName',
                'arvi_sub_deliveries.name as subDeliveryName',
                'merchants.warehouse_id',
                'merchant_orders.remarks_deliver',
                'brands.client_id',
                'merchants.sent_order_to_lodi',
            )
            ->where('payment_id',$paymentId)
            ->first();

            // mapping product to sent to lodi      
            $allItem = array();   
            $mp = '';
            $mv = '';
            $mpa = '';
            $mea = '';   
            foreach ($data->merchantOrderDetail as $key => $value) {
                // mapping product/variant
                if (isset($value->variant_id)) {
                    $mv = MerchantProductVariant::find($value->variant_id);
                    $item = new stdClass();
                    $item->uom        = $mv->uom;
                    $item->product_id = $mv->sku;
                    $item->unit_price = $mv->retail_price;
                    $item->qty        = $value['qty'];
                    array_push($allItem,$item);
                }else{
                    // mapping product
                    $mp = MerchantProduct::find($value->product_id);
                    $item = new stdClass();
                    $item->uom        = $mp->uom;
                    $item->product_id = $mp->sku;
                    $item->unit_price = $mp->retail_price;
                    $item->qty        = $value['qty'];
                    array_push($allItem,$item);
                }

                // mapping product attribute
                $pa = MerchantOrderProductAttributeList::where('merchant_order_detail_id',$value->id)->get();
                foreach ($pa as $key => $attribute) {
                    $mpa = ProductAttribute::find($attribute->product_attribute_id);
                    $item = new stdClass();
                    $item->uom        = $mpa->uom;
                    $item->product_id = $mpa->sku;
                    $item->unit_price = $mpa->retail_price;
                    $item->qty        = $attribute['qty']*$value['qty'];
                    array_push($allItem,$item);
                }

                // mapping product extra attribute
                $pea = MerchantOrderProductExtraAttributeList::where('merchant_order_detail_id',$value->id)->get();

                foreach ($pea as $key => $extraAttribute) {
                    if (isset($extraAttribute->merchant_extra_attribute_id)) {
                        $mea = MerchantExtraAttribute::find($extraAttribute->merchant_extra_attribute_id);
                    }else{
                        $mea = BrandExtraAttribute::find($extraAttribute->brand_extra_attribute_id);
                    }
                    $item = new stdClass();
                    $item->uom        = $mea->uom;
                    $item->product_id = $mea->sku;
                    $item->unit_price = $mea->retail_price;
                    $item->qty        = $extraAttribute['qty']*$value['qty'];
                    array_push($allItem,$item);
                }
            }

            $body                         = new stdClass();
            $body->buyer_name             = $data->name;
            $body->buyer_street_address_1 = $data->address;
            $body->buyer_street_address_2 = $data->subdistrict;
            $body->district               = $data->district;
            $body->city                   = $data->city;
            $body->province               = $data->province;
            $body->postal_code            = $data->postal_code;
            $body->phone                  = $data->mobile_number;
            $body->order_amount           = $data->total_gross_price;
            $body->order_date             = Carbon::now();
            $body->shipping_channel       = $data->deliveryName;
            $body->shipping_service       = $data->subDeliveryName;
            $body->order_id               = 'OOBE-'.$data->id;
            $body->items                  = $allItem;
            $body->warehouse_id           = $data->warehouse_id;
            $body->so_remark              = $data->remarks_deliver;
            $body->marketplace_name       = 'OOBE';
            $body->client_id              = $data->client_id;

            // run sent to lodi
            $requestToken = $this->requestToken();
    
            $client = new Client();
            $headers = [
                'Accept' => 'application/json',
                "Authorization" => $requestToken['id_token']
            ];
    
            $request = new Request('POST', 'https://dev-api-v1.lodi.id/v2/orders/create',
            $headers, json_encode($body));
            // $headers, $body);
            $res     = $client->sendAsync($request)->wait();
            $body    = $res->getBody();
            $obj     = json_decode($body);
            
            return $obj;
        }

    }
}
