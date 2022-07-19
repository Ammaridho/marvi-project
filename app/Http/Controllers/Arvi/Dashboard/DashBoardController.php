<?php

namespace App\Http\Controllers\Arvi\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

class DashBoardController extends Controller
{

    public function indexBackup(Request $request)
    {
        $qrCode = $request->qrCode;
        
         //get data merchant
         $data = Merchant::getByCode($qrCode);

         // check if merchant exist
         if ($data) {
            // get id merchant
            $mId = $data->id;
            
            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                                ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                ->select('merchant_orders.create_time','merchant_orders.day_deliver','merchant_orders.id',
                                'merchant_orders.name','merchant_orders.email','merchant_orders.mobile_number',
                                'merchant_defined_deliveries.address','merchant_order_details.qty','merchant_order_details.product_id')
                                ->orderBy('day_deliver','asc')
                                ->get()->unique('id');
            // to get quantity all product on order 
            $dataOrderDetails = MerchantOrderDetail::where('merchant_id',$mId)->get();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order    
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] = $valueDod->qty;
            }
            //get count product
            $countProduct = MerchantProduct::count();
            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->get();
            

            // Production Plan
            $joinForProductPlans = MerchantOrder::join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                    ->select('merchant_orders.day_deliver','merchant_orders.id',
                                    'merchant_order_details.qty','merchant_order_details.product_id')
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
                }else{
                    $now->addDays(1);
                    $dateA[$i] = $now->format('Y-m-d');
                    $dateH[$i] = $now->format('d-M');
                }
            }

            
            // delivery drop point list
            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                                                        ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                                        ->select('merchant_orders.day_deliver','merchant_orders.id','merchant_defined_deliveries.address',
                                                        'merchant_order_details.qty','merchant_order_details.product_id')
                                                        ->orderBy('day_deliver','asc')
                                                        ->orderBy('address','asc')
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

            // ==============================================================================================================

            return view('arvi.backend.old.main',compact('joinForOrderDetails','joinForProductPlans',
                                            'joinForDeliveryDropPoints','productsOrder','products',
                                            'countProduct','qrCode','test','productPlan',
                                            'dateA','dateH','deliveryDropPoint','noww'));
            }
        return view('arvi.frontend.page-not-available');
    }

    public function index(Request $request)
    {
        $qrCode = $request->qrCode;
        
         //get data merchant
         $data = Merchant::getByCode($qrCode);

         // check if merchant exist
         if ($data) {
            // get id merchant
            $mId = $data->id;
            
            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                                ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                ->select('merchant_orders.create_time','merchant_orders.day_deliver','merchant_orders.id',
                                'merchant_orders.name','merchant_orders.email','merchant_orders.mobile_number',
                                'merchant_defined_deliveries.address','merchant_order_details.qty','merchant_order_details.product_id')
                                ->orderBy('day_deliver','asc')
                                ->get()->unique('id');
            // to get quantity all product on order 
            $dataOrderDetails = MerchantOrderDetail::where('merchant_id',$mId)->get();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order    
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] = $valueDod->qty;
            }
            //get count product
            $countProduct = MerchantProduct::count();
            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->get();
            

            // Production Plan
            $joinForProductPlans = MerchantOrder::join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                    ->select('merchant_orders.day_deliver','merchant_orders.id',
                                    'merchant_order_details.qty','merchant_order_details.product_id')
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
                }else{
                    $now->addDays(1);
                    $dateA[$i] = $now->format('Y-m-d');
                    $dateH[$i] = $now->format('d-M');
                }
            }

            
            // delivery drop point list
            $joinForDeliveryDropPoints = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                                                        ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                                        ->select('merchant_orders.day_deliver','merchant_orders.id','merchant_defined_deliveries.address',
                                                        'merchant_order_details.qty','merchant_order_details.product_id')
                                                        ->orderBy('day_deliver','asc')
                                                        ->orderBy('address','asc')
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

            // ==============================================================================================================

            return view('arvi.backend.page-dashboard',compact('joinForOrderDetails','joinForProductPlans',
                                            'joinForDeliveryDropPoints','productsOrder','products',
                                            'countProduct','qrCode','test','productPlan',
                                            'dateA','dateH','deliveryDropPoint','noww'));
            }
        return view('arvi.frontend.page-not-available');
    }

    public function home(Request $request)
    {
        $qrCode = $request->qrCode;
        
        //get data merchant
        $data = Merchant::getByCode($qrCode);

        // check if merchant exist
        if ($data) {

            // date now
            $now = Carbon::now();

            // get count all order today
            $countOrderToday = MerchantOrder::whereDate('create_time', '=', $now)->count();

            // set sales today
            $currency   = MerchantOrder::first()->currency;
            $orderToday = MerchantOrder::whereDate('create_time', '=', $now);
            $incomeToday = $orderToday->sum('total_gross_price');
            $salesToday = $orderToday->count();
            
            // sales yesterday
            $orderYesterday = MerchantOrder::whereDate('create_time', '=', $now->subDays(1));
            $incomeYesterday = $orderYesterday->sum('total_gross_price');
            $salesYesterday = $orderYesterday->count();

            if ($incomeYesterday == 0 && $incomeToday == 0) {
                $percentase = 0;
            }else if($incomeYesterday == 0){
                $percentase = +$incomeToday*100;
            }else if($incomeToday == 0){
                $percentase = -$incomeYesterday*100;
            }else{
                if ($incomeToday > $incomeYesterday) {
                    $percentase = (($incomeToday - $incomeYesterday) / $incomeYesterday) * 100;
                }else {
                    $percentase = -((($incomeYesterday - $incomeToday) / $incomeToday) * 100);
                }
            }
                    
            return view('arvi.backend.page-home',compact('qrCode','countOrderToday','incomeToday','currency','salesYesterday','percentase'));
        }
        return view('arvi.frontend.page-not-available');
    }

}
