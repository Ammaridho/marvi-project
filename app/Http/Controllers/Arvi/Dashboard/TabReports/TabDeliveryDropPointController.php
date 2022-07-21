<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\MerchantDeliveryDropPointExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

class TabDeliveryDropPointController extends Controller
{
    // diplay data on tab delivery drop option
    public function deliveryDropPointList(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $mId = $data->id;
            $joinForDeliveryDropPoints = MerchantOrder::
                join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->select('merchant_orders.day_deliver','merchant_orders.id',
                'merchant_defined_deliveries.address',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->orderBy('day_deliver','asc')
                ->orderBy('address','asc')
                ->get();

            // mapping product to quantity
            $products = MerchantProduct::where('merchant_id',$mId)->get();
            $deliveryDropPoint = [];
            foreach ($joinForDeliveryDropPoints as $keyJ => $value) { //product
                $deliveryDropPoint[$value->day_deliver][$value->address]
                [$value->id][$value->product_id] 
                = $value->qty;
            }

            // remapping data base on date and address
            $aa = [];
            $temp_day_deliver = '';
            $temp_address = '';
            $temp_product_id = '';
            $temp_qty = 0;
            //itterasi day and address
            foreach ($joinForDeliveryDropPoints as $key => $item){ 
                //check day_deliver && address && product
                if ($temp_day_deliver == $item->day_deliver && $temp_address == $item->address &&
                    $temp_product_id == $item->product_id) { //if same
                    $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address]
                    [$item->id][$item->product_id]) ? $deliveryDropPoint[$item->day_deliver]
                    [$item->address][$item->id][$item->product_id] : 0 ;
                    $temp_qty += $aa;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] 
                    = $temp_qty;
                }else{ //if different
                    $new_qty = isset( $deliveryDropPoint[$item->day_deliver]
                    [$item->address][$item->id][$item->product_id]) ?  
                    $deliveryDropPoint[$item->day_deliver][$item->address]
                    [$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id]
                    = $new_qty;
                    $temp_qty = $new_qty;
                }
                $temp_day_deliver = $item->day_deliver;
                $temp_address   = $item->address;
                $temp_product_id = $item->product_id;
            }
            $test = $deliveryDropPointNew;
            return view('arvi.backend.page-report-delivery-drop-point',
                    compact('joinForDeliveryDropPoints','deliveryDropPointNew',
                            'products','qrCode','test'));
        }
        return view('arvi.frontend.page-not-available');
    }

    // Export to excel
    public function deliveryDropPointListExportExcel(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $mId = $data->id;
            $noww = Carbon::now();
            $idData = json_decode($request->idData,true);

            // get data from db
            $joinForDeliveryDropPoints = MerchantOrder::
                join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->select('merchant_orders.day_deliver','merchant_orders.id',
                'merchant_defined_deliveries.address',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->orderBy('day_deliver','asc')
                ->orderBy('address','asc')
                ->get();

            // mapping product to quantity
            $products = MerchantProduct::where('merchant_id',$mId)->get();
            $deliveryDropPoint = [];
            foreach ($joinForDeliveryDropPoints as $keyJ => $value) { //product
                $deliveryDropPoint[$value->day_deliver][$value->address]
                [$value->id][$value->product_id] 
                = $value->qty;
            }

            // remapping data base on date and address
            $aa = [];
            $temp_day_deliver = '';
            $temp_address = '';
            $temp_product_id = '';
            $temp_qty = 0;
            //itterasi day and address
            foreach ($joinForDeliveryDropPoints as $key => $item){ 
                //check day_deliver && address && product
                if ($temp_day_deliver == $item->day_deliver && $temp_address == $item->address &&
                    $temp_product_id == $item->product_id) { //if same
                    $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address]
                    [$item->id][$item->product_id]) ? $deliveryDropPoint[$item->day_deliver]
                    [$item->address][$item->id][$item->product_id] : 0 ;
                    $temp_qty += $aa;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] 
                    = $temp_qty;
                }else{ //if different
                    $new_qty = isset( $deliveryDropPoint[$item->day_deliver]
                    [$item->address][$item->id][$item->product_id]) ?  
                    $deliveryDropPoint[$item->day_deliver][$item->address]
                    [$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id]
                    = $new_qty;
                    $temp_qty = $new_qty;
                }
                $temp_day_deliver = $item->day_deliver;
                $temp_address   = $item->address;
                $temp_product_id = $item->product_id;
            }
            return Excel::download(new MerchantDeliveryDropPointExport($noww,$joinForDeliveryDropPoints,$deliveryDropPointNew,$products), 
                'Delivery_Drop_Point_'.Carbon::now()->format('d-m-y').'.xlsx');
        }
        return view('arvi.frontend.page-not-available');
    }
}
