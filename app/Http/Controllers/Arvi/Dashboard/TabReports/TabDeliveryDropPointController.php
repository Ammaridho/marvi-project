<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Library\Vendor\autoload;
use App\Exports\MerchantDeliveryDropPointExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
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

            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->orderBy('merchant_orders.day_deliver','desc')
                ->orderBy('merchant_orders.address','asc')
                ->select('merchant_orders.day_deliver','merchant_orders.id', 'merchant_defined_deliveries.address',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->limit(1000)
                ->get();

            // mapping product to quantity
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();
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

            $deliveryDropPointNew = [];

            //itterasi day and address
            foreach ($joinForDeliveryDropPoints as $key => $item){ 

                //check day_deliver && address && product
                if (isset($deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id])) { //if same
                    $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] += $aa;
                }else{ //if different
                    $new_qty = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] = $new_qty;
                    $temp_qty = $new_qty;
                }

                $temp_day_deliver = $item->day_deliver;
                $temp_address   = $item->address;
                $temp_product_id = $item->product_id;
            }   
            

            //reformat data to display
            $i = 0;
            $temp_day_deliver = '';
            $temp_address = '';
            $idExist = [];
            $data = [];
            

            foreach ($joinForDeliveryDropPoints as $key => $item){

                if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address)){
                    $dataProduct = [];
                    foreach ($products as $itemP){
                        $dataProduct[$itemP->id] = isset( $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id]) ? 
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] : 0;
                    }
                    $data[$i] = [
                        'day_deliver'   => $item->day_deliver,
                        'address'       => $item->address,
                        'totalItem'     => array_sum($dataProduct),
                        'dataProduct'   => $dataProduct,
                    ];
                    $i++;
                    $temp_day_deliver = $item->day_deliver;
                    $temp_address = $item->address;
                }

            }

            $countDeliveryDropPoint = count($data);

            $dataPaginate = $this->paginate($data);
            $test = $dataPaginate;

            return view('arvi.backend.delivery-drop-point-report.page-report-delivery-drop-point-parent',
                    compact('joinForDeliveryDropPoints','deliveryDropPointNew',
                    'products','qrCode','dataPaginate','test','data','countDeliveryDropPoint'));
        }
        return view('arvi.frontend.page-not-available');
    }

    // diplay data on tab delivery drop option
    public function deliveryDropPointListFetch(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $mId = $data->id;

            // to get data order, bio customer and pickup address
            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->orderBy('merchant_orders.day_deliver','desc')
                ->orderBy('merchant_orders.address','asc')
                ->select('merchant_orders.day_deliver','merchant_orders.id', 'merchant_defined_deliveries.address',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->limit(1000)
                ->get();

            // mapping product to quantity
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();
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

            $deliveryDropPointNew = [];

            //itterasi day and address
            foreach ($joinForDeliveryDropPoints as $key => $item){

                //check day_deliver && address && product
                if (isset($deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id])) { //if same
                    $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] += $aa;
                }else{ //if different
                    $new_qty = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] = $new_qty;
                    $temp_qty = $new_qty;
                }

                $temp_day_deliver = $item->day_deliver;
                $temp_address   = $item->address;
                $temp_product_id = $item->product_id;
            }   

            //reformat data to display
            $i = 0;
            $temp_day_deliver = '';
            $temp_address = '';
            $idExist = [];
            $data = [];

            foreach ($joinForDeliveryDropPoints as $key => $item){
                
                if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address)){
                    $dataProduct = [];
                    foreach ($products as $itemP){
                        $dataProduct[$itemP->id] = isset( $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id]) ? 
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] : 0;
                    }
                    $data[$i] = [
                        'day_deliver'   => $item->day_deliver,
                        'address'       => $item->address,
                        'totalItem'     => array_sum($dataProduct),
                        'dataProduct'   => $dataProduct,
                    ];
                    $i++;
                    $temp_day_deliver = $item->day_deliver;
                    $temp_address = $item->address;
                }
            }

            $countDeliveryDropPoint = count($data);

            $test = $request;
            if ($request->action == 1) { //pagination
                $dataPaginate = $this->paginate($data,5,$request->page);
                return view('arvi.backend.delivery-drop-point-report.page-report-delivery-drop-point-child',
                        compact('products','qrCode','test','dataPaginate','data','countDeliveryDropPoint'));
            }else{
                $dataPaginate = $data; //searching or sorting
                return view('arvi.backend.delivery-drop-point-report.page-report-delivery-drop-point-child',
                        compact('products','qrCode','test','dataPaginate','countDeliveryDropPoint'));
            }
            
        }
        return view('arvi.frontend.page-not-available');
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // // Export to excel
    public function deliveryDropPointListExportExcel(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $mId = $data->id;
            $noww = Carbon::now();

            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->orderBy('merchant_orders.day_deliver','desc')
                ->orderBy('merchant_orders.address','asc')
                ->select('merchant_orders.day_deliver','merchant_orders.id', 'merchant_defined_deliveries.address',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->limit(1000)
                ->get();

            // mapping product to quantity
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();
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

            $deliveryDropPointNew = [];

            //itterasi day and address
            foreach ($joinForDeliveryDropPoints as $key => $item){ 

                //check day_deliver && address && product
                if (isset($deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id])) { //if same
                    $aa = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] += $aa;
                }else{ //if different
                    $new_qty = isset( $deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id]) ? 
                    (int)$deliveryDropPoint[$item->day_deliver][$item->address][$item->id][$item->product_id] : 0 ;
                    $deliveryDropPointNew[$item->day_deliver][$item->address][$item->product_id] = $new_qty;
                    $temp_qty = $new_qty;
                }

                $temp_day_deliver = $item->day_deliver;
                $temp_address   = $item->address;
                $temp_product_id = $item->product_id;
            }   
            

            //reformat data to display
            $i = 0;
            $temp_day_deliver = '';
            $temp_address = '';
            $idExist = [];
            $data = [];
            

            foreach ($joinForDeliveryDropPoints as $key => $item){

                if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address)){

                    $dataProduct = [];

                    foreach ($products as $itemP){
                        $dataProduct[$itemP->id] = isset( $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id]) ? 
                        $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] : 0;
                    }

                    $data[$i] = [
                        'day_deliver'   => $item->day_deliver,
                        'address'       => $item->address,
                        'totalItem'     => array_sum($dataProduct),
                        'dataProduct'   => $dataProduct,
                    ];

                    $i++;
                    $temp_day_deliver = $item->day_deliver;
                    $temp_address = $item->address;
                }

            }

            $displayData = [];
            $dataIndex = json_decode($request->dataIndex,true);

            foreach ($dataIndex as $value) {
                array_push($displayData,$data[$value]);
            }
            
            return Excel::download(new MerchantDeliveryDropPointExport($noww,$displayData,$products), 
                'Delivery_Drop_Point_'.Carbon::now()->format('d-m-y').'.xlsx');
        }
        return view('arvi.frontend.page-not-available');
    }
}
