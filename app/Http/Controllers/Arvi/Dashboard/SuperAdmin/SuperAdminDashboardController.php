<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\Company;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;


class SuperAdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries', 'merchant_orders.defined_delivery_id', '=', 'merchant_defined_deliveries.id')
                ->join('merchant_order_details', 'merchant_orders.id', '=', 'merchant_order_details.merchant_order_id')
                ->select(
                    'merchant_orders.create_time',
                    'merchant_orders.day_deliver',
                    'merchant_orders.id',
                    'merchant_orders.name',
                    'merchant_orders.email',
                    'merchant_orders.mobile_number',
                    'merchant_defined_deliveries.address',
                    'merchant_order_details.qty',
                    'merchant_order_details.product_id'
                )
                ->orderBy('day_deliver', 'asc')
                ->get()->unique('id');

            // to get quantity all product on order
            $dataOrderDetails = MerchantOrderDetail::all();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] = $valueDod->qty;
            }
            //get count product
            $countProduct = MerchantProduct::count();
            // to get data product
            $products = MerchantProduct::all();

            // user login
            $email = $request->session()->get('email');
            $access = $request->session()->get('access');

            // Production Plan
            $joinForProductPlans = MerchantOrder::join('merchant_order_details', 'merchant_orders.id', '=', 'merchant_order_details.merchant_order_id')
                ->select(
                    'merchant_orders.day_deliver',
                    'merchant_orders.id',
                    'merchant_order_details.qty',
                    'merchant_order_details.product_id'
                )
                ->get();
            $productPlan = [];
            $qtyp = 0;
            foreach ($joinForProductPlans as $key => $value) { //product
                $productPlan[$value->product_id][$value->day_deliver][$value->id] = $value->qty;
            }

            //date production plan
            $now = Carbon::now();
            $noww = Carbon::now();
            $da =  7;

            $dateA = [];
            for ($i=0; $i < $da; $i++) {
                if ($i==0) {
                    $dateA[$i] = $now->format('Y-m-d');
                    $dateH[$i] = $now->format('d-M');
                } else {
                    $now->addDays(1);
                    $dateA[$i] = $now->format('Y-m-d');
                    $dateH[$i] = $now->format('d-M');
                }
            }


            // delivery drop point list
            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries', 'merchant_orders.defined_delivery_id', '=', 'merchant_defined_deliveries.id')
                ->join('merchant_order_details', 'merchant_orders.id', '=', 'merchant_order_details.merchant_order_id')
                ->select(
                    'merchant_orders.day_deliver',
                    'merchant_orders.id',
                    'merchant_defined_deliveries.address',
                    'merchant_order_details.qty',
                    'merchant_order_details.product_id'
                )
                ->orderBy('day_deliver', 'asc')
                ->orderBy('address', 'asc')
                ->get();

            $deliveryDropPoint = [];
            $tess = [];
            $qtyp = 0;
            foreach ($joinForDeliveryDropPoints as $keyJ => $value) { //product
                $deliveryDropPoint[$value->day_deliver][$value->address][$value->id][$value->product_id] = $value->qty;
            }

            $aa = [];
            $temp_day_deliver = '';
            $temp_address = '';
            $temp_product_id = '';

            // On Develop ===================================================================================================

            foreach ($joinForDeliveryDropPoints as $key => $item) { //itterasi day and address
                $temp_qty = 0;

                foreach ($products as $keyP => $itemP) { //itterasi product
                    if (!($temp_day_deliver == $item->day_deliver && $temp_address ==
                        $item->address && $temp_product_id == $itemP->id)) { //if same
                        $aa = isset($deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) ?
                        $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id] : 0 ;
                        $temp_qty += $aa;
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] = $temp_qty;
                    } else { //if different
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] =
                        isset($deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) ?
                        $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id] : 0 ;
                    }

                    $temp_day_deliver = $item->day_deliver;
                    $temp_address   = $item->address;
                    $temp_product_id = $itemP->id;
                }
            }

            // ==============================================================================================================

            return view(
                'arvi.backend.layouts.index',
                compact(
                    'joinForOrderDetails', 'joinForProductPlans',
                    'joinForDeliveryDropPoints', 'productsOrder',
                    'products', 'countProduct',
                    'productPlan', 'dateA',
                    'dateH', 'deliveryDropPoint',
                    'noww', 'companyCode',
                    'email','access'
                )
            );
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
