<?php

namespace App\Http\Controllers\Arvi\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Company;
use App\Models\Merchant;
use App\Models\Brand;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\ArviPaymentMethod;
use App\Models\Payments\MerchantPayment;
use App\Models\MerchantOrderProductAttributeList;
use Illuminate\Support\Facades\Hash;

use stdClass;

use Carbon\Carbon;

use App\Mail\Arvi\OobeIndonesia\CustomerSuccessOrder;

class OrderListController extends Controller
{
    protected $view = 'arvi.backend.dashboard.orderList.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $companyCode = $request->companyCode;
            $brandIds = Brand::where('company_id',$data->id)->pluck('id');
            $merchants = Merchant::whereIn('brand_id',$brandIds)->get();
            $merchantOrders = MerchantOrder::whereIn('brand_id',$brandIds)->get();
            $merchantIds = Merchant::where('company_id',$data->id)->pluck('id');

            if (isset($request->startDate)) {

                if (count(json_decode($request->merchantIds)) > 0) {
                    $merchantIds = Merchant::whereIn('id',json_decode($request->merchantIds))
                    ->pluck('id');
                }

                $startDate = date('Y-m-d',strtotime(json_decode($request->startDate,true)));
                $endDate = date('Y-m-d',strtotime(json_decode($request->endDate,true)));

                $joinMerchantOrder = MerchantOrder::
                    join('merchant_order_details','merchant_orders.id','=',
                        'merchant_order_details.merchant_order_id')
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
                    ->select(
                        'merchant_orders.id',
                        'merchant_orders.loc_tz',
                        'merchant_orders.create_time as create_time',
                        'merchant_orders.day_deliver as day_deliver',
                        'merchant_orders.fulfilment_status',
                        'merchant_orders.order_status',
                        'merchant_orders.delivery_id',
                        'merchant_orders.delivery_type',
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
                    ->whereIn('merchant_orders.merchant_id',$merchantIds)
                    ->whereDate('merchant_orders.create_time', '>=', $startDate)
                    ->whereDate('merchant_orders.create_time', '<=', $endDate);

                    if (substr($request->fulfilmentOrStatus,1,1) == "s") {
                        $filter =  $joinMerchantOrder->where('merchant_orders.order_status',
                            substr($request->fulfilmentOrStatus,2,1));
                    }else if(substr($request->fulfilmentOrStatus,1,1) == "f"){
                        $filter =  $joinMerchantOrder->where('merchant_orders.fulfilment_status',
                            substr($request->fulfilmentOrStatus,2,1));
                    }else{
                        $filter =  $joinMerchantOrder;
                    }
                    $joinForOrderDetails = $filter->orderBy('merchant_orders.id', 'desc')
                        ->limit(50)
                        ->get()->unique('id');

                return view($this->view . 'orderListChild',
                        compact('companyCode','joinForOrderDetails'));

            } else {
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
                        'merchant_orders.loc_tz',
                        'merchant_orders.create_time as create_time',
                        'merchant_orders.day_deliver as day_deliver',
                        'merchant_orders.fulfilment_status',
                        'merchant_orders.order_status',
                        'merchant_orders.delivery_id',
                        'merchant_orders.delivery_type',
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
                    ->whereIn('merchant_orders.merchant_id',$merchantIds)
                    ->orderBy('merchant_orders.id', 'desc')
                    ->limit(50)
                    ->get()->unique('id');

                // data for pick filter brand merchant ====================================
                $joinBrandMerchant = Brand::
                    join('merchants','brands.id','=','merchants.brand_id')
                    ->where('brands.company_id',$data->id)
                    ->select('brands.name as brand_name','merchants.id as merchant_id')
                    ->get()->toArray();

                // Reform data for radio button filter order list (brand => merchant)
                $filterBrandMerchant = [];
                $angkerBrand = 0;
                $angkerMerchant = 0;

                // set all data check
                $filterBrandMerchant[$angkerBrand]['name'] = 'Show all';
                foreach ($joinBrandMerchant as $key => $value) {
                    $filterBrandMerchant[$angkerBrand]['options'][$angkerMerchant++] =
                        $value['merchant_id'];
                }

                // set check data base on brand
                foreach ($joinBrandMerchant as $key => $value) {
                    if ($filterBrandMerchant[$angkerBrand]['name'] != $value['brand_name'] ) {
                        $filterBrandMerchant[++$angkerBrand]['name'] = $value['brand_name'];
                        $angkerMerchant = 0;
                        $filterBrandMerchant[$angkerBrand]['options'][$angkerMerchant++] =
                            $value['merchant_id'];
                    }else{
                        $filterBrandMerchant[$angkerBrand]['options'][$angkerMerchant++] =
                            $value['merchant_id'];
                    }
                }

                $joinProductsOrders = MerchantOrderDetail::
                    join('merchant_products','merchant_order_details.product_id',
                    '=','merchant_products.id')
                    ->select(
                        'merchant_products.retail_price',
                        'merchant_order_details.qty',
                    );

                return view( $this->view . 'orderListParent',
                    compact('companyCode','merchantOrders','merchants',
                        'joinForOrderDetails','joinProductsOrders','filterBrandMerchant'));
            }

        }
        return view('arvi.page-not-available');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
        $id = $request->id;

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
            'merchant_orders.loc_tz',
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
        
        return view( $this->view . 'orderDetail',
            compact('companyCode','id','joinForOrderDetails',
                'joinProductsOrder','reformJoinProductsOrder','priceAll'));
        }
        return view('arvi.page-not-available');
    }

    public function updateStatusOrder(Request $request)
    {
        // validation
        if ($request->status == 'Cancel') {
            $credentials = $request->validate([
                'id'        => 'required',
                'password'  => 'required'
            ]);
            $user = User::where('email',$request->session()->get('email'))->first();
            if (Hash::check($request->password, $user->password)) {
                $order = MerchantOrder::find($request->id);
                $order->order_status = 0;
                $order->save();
            }else{
                return false;
            }
        } else {
            if ($request->status == 'Confirm Payment') {
                // confirm status payment
                $order = MerchantOrder::find($request->id);
                $order->payment_status = 1;
                $order->save();
                
            }else{
                // update order status
                $order = MerchantOrder::find($request->id);
                $order->order_status = $order->order_status+1;
                $order->save();

                if ($order->order_status == 2) {
                    // run sent to lodi
                    $sentOrderToLodi = app('App\Http\Controllers\API\ApiController')
                    ->sentOrderToLodi($order->payment_id);
                }

            }
        }

    }

    public function sentEmailReciept($orderId)
    {

        $order = MerchantOrder::find($orderId);

        // sent email if user input email
        if (isset($order->email)) {
            //payment name
            $paym = MerchantPayment::
            join('arvi_payment_methods','arvi_payment_methods.id','=','merchant_payments.payment_method_id')
            ->where('merchant_payments.id',$order->merchant_payment_id)->first()->name;

            // fees
            $merchant = Merchant::find($order->merchant_id);
            $fees = Brand::find($merchant->brand_id)->fees;
    
            $dataEmailSuccess = new stdClass();
            $dataEmailSuccess->orderNumber      = $order->id;
            $dataEmailSuccess->merchant         = $merchant;
            $dataEmailSuccess->name             = $order->name; 
            $dataEmailSuccess->order_date       = $order->create_time;
            $dataEmailSuccess->products         = $this->getProductOrder($orderId); 
            $dataEmailSuccess->paym             = $paym;
            $dataEmailSuccess->email            = $order->email;
            $dataEmailSuccess->mobile_number    = $order->mobile_number;
            $dataEmailSuccess->fees             = $fees;
            $dataEmailSuccess->currency         = $merchant->currency;
    
            \Mail::to("$dataEmailSuccess->email")->send(new CustomerSuccessOrder($dataEmailSuccess));
        }
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
            'merchant_orders.loc_tz',
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
