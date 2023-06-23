<?php

namespace App\Http\Controllers\Arvi\FrontEnd\OobeIndonesia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\MerchantOrder;
use App\Models\OrderFeeList;

class MyOrderController extends Controller
{
    protected $view = 'arvi.frontend.oobe-indonesia.my-order.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('merchant_orders')
            ->join('merchants','merchant_orders.merchant_id','=','merchants.id')
            ->join('merchant_order_details','merchant_orders.id','=',
            'merchant_order_details.merchant_order_id')
            ->select(
                'merchant_orders.id',
                'merchant_orders.user_id',
                'merchant_orders.create_time',
                'merchant_orders.currency',
                'merchant_orders.loc_tz',
                'merchant_orders.total_gross_price',
                'merchant_orders.order_status',
                'merchant_orders.payment_status',
                'merchants.image_url as image_url',
                'merchants.name as merchantName',
                DB::raw('count(merchant_order_details.id) as items'),
                )
            ->where('user_id',Auth::user()->id)
            ->groupBy(
                'merchant_orders.id',
                'merchant_orders.user_id',
                'merchant_orders.create_time',
                'merchant_orders.currency',
                'merchant_orders.loc_tz',
                'merchant_orders.total_gross_price',
                'merchant_orders.order_status',
                'merchant_orders.payment_status',
                'merchants.name','merchants.image_url'
            )
            ->orderBy('merchant_orders.id','DESC')    
            ->get();
        return view($this->view.'page-my-order',compact('orders'));
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
            ->where('merchant_orders.id',$request->id)
            ->select(
                'merchant_orders.user_id',
                'merchant_orders.order_status',
                'merchant_orders.payment_status',
                'merchant_orders.create_time',
                'merchant_orders.id',
                'merchant_orders.merchant_payment_id',
                'merchant_orders.currency',
                'merchant_orders.loc_tz',
                'merchant_orders.cost_delivery',
                'merchant_orders.total_gross_price',
                'merchant_orders.name',
                'merchant_orders.mobile_number',
                'merchants.name as merchantName',
                'merchants.id as merchantId',
                'arvi_payment_methods.name as paymentName',
                'arvi_deliveries.name as deliveryName',
                'arvi_sub_deliveries.name as subDeliveryName',
            )
            ->first();

            // fee
            // relation to fee brand
            $fees = OrderFeeList::
            join('merchant_orders','order_fee_list.merchant_order_id',
            '=','merchant_orders.id')
            ->join('fees','order_fee_list.fee_id','=','fees.id')
            ->where('merchant_orders.id',$request->id)
            ->select('fees.name','fees.type_fee','fees.value_fee',
            'fees.type_value','fees.currency')
            ->get();

        return view($this->view.'page-my-order-detail',compact('order','fees'));
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
