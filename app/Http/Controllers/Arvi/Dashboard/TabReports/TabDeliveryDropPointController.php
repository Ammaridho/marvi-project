<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

class TabDeliveryDropPointController extends Controller
{
    public function deliveryDropPointList(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        //get data merchant
        $data = Merchant::getByCode($qrCode);
        // check if merchant exist
        if ($data) {
            // get id merchant
            $mId = $data->id;
            // delivery drop point list
            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
            ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
            ->select('merchant_orders.day_deliver','merchant_orders.id','merchant_defined_deliveries.address',
            'merchant_order_details.qty','merchant_order_details.product_id')
            ->orderBy('day_deliver','asc')
            ->orderBy('address','asc')
            ->get()->unique('id');

            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->get();

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

            foreach ($joinForDeliveryDropPoints as $key => $item){ //itterasi day and address

                $temp_qty = 0;

                foreach ($products as $keyP => $itemP){ //itterasi product

                    if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address && $temp_product_id == $itemP->id)) { //if same

                        $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) ?  $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id] : 0 ;
                        $temp_qty += $aa;
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] = $temp_qty;

                    }else{ //if different
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id]) ?  $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$itemP->id] : 0 ;
                    }

                    $temp_day_deliver = $item->day_deliver;
                    $temp_address   = $item->address;
                    $temp_product_id = $itemP->id;

                }

            }

            $test = $deliveryDropPoint;
            return view('arvi.backend.page-report-delivery-drop-point',compact('joinForDeliveryDropPoints','products','qrCode','test'));
        }
        return view('arvi.frontend.page-not-available');
    }
}
