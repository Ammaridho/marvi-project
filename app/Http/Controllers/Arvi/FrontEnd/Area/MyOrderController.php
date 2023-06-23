<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\MerchantOrder;
use App\Models\OrderFeeList;
use App\Models\Location;

class MyOrderController extends Controller
{
    protected $view = 'arvi.frontend.area.my-order.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        // location
        $location = Location::where('code',$code)->first();
        $orders = DB::table('merchant_orders')
            ->join('merchants','merchant_orders.merchant_id','=','merchants.id')
            ->join('merchant_order_details','merchant_orders.id','=',
            'merchant_order_details.merchant_order_id')
            ->select(
                'merchant_orders.id',
                'merchant_orders.user_id',
                'merchant_orders.create_time',
                'merchant_orders.currency',
                'merchant_orders.total_gross_price',
                'merchant_orders.order_status',
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
                'merchant_orders.total_gross_price',
                'merchant_orders.order_status',
                'merchants.name','merchants.image_url'
                )
            ->get();
        return view($this->view.'page-my-order',
            compact('orders','code','location'));
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
    public function show(Request $request,$code)
    {
        // location
        $location = Location::where('code',$code)->first();
        $order = MerchantOrder::
            join('merchants','merchant_orders.merchant_id','=','merchants.id')
            ->join('arvi_payment_methods','merchant_orders.merchant_payment_id',
            '=','arvi_payment_methods.id')
            ->join('arvi_deliveries','merchant_orders.delivery_id','=','arvi_deliveries.id')
            ->where('merchant_orders.id',$request->id)
            ->select(
                'merchant_orders.user_id',
                'merchant_orders.order_status',
                'merchant_orders.create_time',
                'merchant_orders.id',
                'merchant_orders.merchant_payment_id',
                'merchant_orders.currency',
                'merchant_orders.total_gross_price',
                'merchant_orders.name',
                'merchant_orders.mobile_number',
                'merchants.name as merchantName',
                'merchants.id as merchantId',
                'arvi_payment_methods.name as paymentName',
                'arvi_deliveries.cost_delivery',
                'arvi_deliveries.name as deliveryName',
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

        return view($this->view.'page-my-order-detail',
            compact('order','fees','code','location'));
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
