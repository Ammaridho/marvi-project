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
use App\Models\Company;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


use Carbon\Carbon;

class TabDeliveryDropPointController extends Controller
{

    protected $view  = 'arvi.backend.delivery-drop-point-report.';

    // diplay data on tab delivery drop option
    public function deliveryDropPointList(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $mId = $data->id;

            if (!isset($request->page)) {
                $page = 1;
            }else{
                $page = $request->page;
            }

            $limit  = 10;
            $offset = ($page * $limit) - $limit;

            $sql = "
                SELECT 
                merchant_orders.day_deliver,
                merchant_defined_deliveries.address,
                SUM(merchant_order_details.qty::integer) as total
                
                FROM merchant_orders 
                JOIN merchant_defined_deliveries ON merchant_orders.defined_delivery_id = 
                merchant_defined_deliveries.id
                JOIN merchant_order_details ON merchant_orders.id = merchant_order_details.merchant_order_id
                GROUP BY merchant_orders.day_deliver,merchant_defined_deliveries.address
                ORDER BY merchant_orders.day_deliver DESC
                limit $limit
                offset $offset
            ";

            $countSql = "
                SELECT COUNT (*)
                FROM ( 
                    SELECT 
                    merchant_orders.day_deliver,
                    merchant_defined_deliveries.address
                
                    FROM merchant_orders 
                    JOIN merchant_defined_deliveries ON merchant_orders.defined_delivery_id = 
                    merchant_defined_deliveries.id
                    GROUP BY merchant_orders.day_deliver,merchant_defined_deliveries.address
                ) AS tblOrdersPerTrackingNum
            ";
            
            $rows = DB::select($sql);
            $countData = count($rows);

            $cs = DB::select($countSql);
            $countAll = $cs[0]->count;

            if (!isset($request->page)) {
                return view($this->view . 'page-report-delivery-drop-point-parent',
                    compact('rows','companyCode','countData','countAll','page','limit'));
            }else{
                return view($this->view . '.page-report-delivery-drop-point-child',
                    compact('rows','companyCode','countData','countAll','page','limit'));
            }
        }
        return view('arvi.page-not-available');
    }

    // dropdown detail quantity product
    public function detailProduct(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $mId = $data->id;
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();
            $day_deliver = json_decode($request->day_deliver,true);
            $address = json_decode($request->address,true);

            $sql = "
                SELECT 
                merchant_products.name,
                SUM(merchant_order_details.qty::integer) as total
                
                FROM merchant_orders 
                JOIN merchant_defined_deliveries ON merchant_orders.defined_delivery_id = merchant_defined_deliveries.id
                JOIN merchant_order_details ON merchant_orders.id = merchant_order_details.merchant_order_id
                JOIN merchant_products ON merchant_order_details.product_id = merchant_products.id
                WHERE (merchant_orders.day_deliver = '$day_deliver' AND merchant_orders.address = '$address')
                GROUP BY merchant_products.name
            ";
            
            $rows = DB::select($sql);
 
            return view($this->view . 'detail-quantity-product',
                    compact('companyCode','products','rows'));
        }
    }

    public function sortDate(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $mId = $data->id;
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();
            $startDate = json_decode($request->startDate,true);
            $endDate = json_decode($request->endDate,true);

            $sql = "
                SELECT 
                merchant_orders.day_deliver,
                merchant_defined_deliveries.address,
                SUM(merchant_order_details.qty::integer) as total
                
                FROM merchant_orders 
                JOIN merchant_defined_deliveries ON merchant_orders.defined_delivery_id = 
                merchant_defined_deliveries.id
                JOIN merchant_order_details ON merchant_orders.id = merchant_order_details.merchant_order_id
                WHERE (merchant_orders.day_deliver >= '$startDate' AND merchant_orders.day_deliver <= '$endDate')
                GROUP BY merchant_orders.day_deliver,merchant_defined_deliveries.address
                ORDER BY merchant_orders.day_deliver DESC
            ";
            
            $rows = DB::select($sql);

            return view($this->view . 'page-report-delivery-drop-point-child',
                    compact('companyCode','products','rows'));
        }
    }

    // // Export to excel
    public function deliveryDropPointListExportExcel(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
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
                ->where('merchant_orders.day_deliver','>=',$request->startDate)
                ->where('merchant_orders.day_deliver','<=',$request->endDate)
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
        
            return Excel::download(new MerchantDeliveryDropPointExport($noww,$data,$products), 
                'Delivery_Drop_Point_'.Carbon::now()->format('d-m-y').'.xlsx');
        }
        return view('arvi.page-not-available');
    }
}
