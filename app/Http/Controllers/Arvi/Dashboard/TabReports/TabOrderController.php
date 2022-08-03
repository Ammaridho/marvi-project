<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\MerchantOrderExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\AbstractPaginator;

use Carbon\Carbon;

class TabOrderController extends Controller
{
    // to display data on table order
    public function orderList(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        
        // check if merchant exist
        if ($data) {
            $mId = $data->id;
            $noww = Carbon::now();

            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::orderBy('create_time', 'desc')->paginate(10);

            // to get quantity all product on order 
            $dataOrderDetails = MerchantOrderDetail::where('merchant_id',$mId)->orderBy('create_time', 'desc')->limit(1000)->get();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order    
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] 
                = $valueDod->qty;
            }

            //get count product
            $countProduct = MerchantProduct::count();
            $countOrder = MerchantOrder::count();
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();

            return view('arvi.backend.order-report.page-report-order-parent',
                compact('noww','joinForOrderDetails','productsOrder',
                'countProduct','products','qrCode','countOrder'));
        }
        return view('arvi.frontend.page-not-available');
    }

    // to display data on table order
    public function orderListFetch(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        
        // check if merchant exist
        if ($data) {
            $mId = $data->id;
            $noww = Carbon::now();

            if ($request->action == 1) {
                // to get data order, bio customer and pickup address
                $joinForOrderDetails = MerchantOrder::orderBy('create_time', 'desc')->paginate(10);
            }else {
                // to get data order, bio customer and pickup address
                $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries',
                    'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                    ->join('merchant_order_details','merchant_orders.id','=',
                    'merchant_order_details.merchant_order_id')
                    ->select('merchant_orders.create_time','merchant_orders.day_deliver','merchant_orders.id',
                    'merchant_orders.name','merchant_orders.email','merchant_orders.mobile_number',
                    'merchant_defined_deliveries.address','merchant_order_details.qty',
                    'merchant_order_details.product_id')->orderBy('merchant_orders.create_time', 'desc')->limit(1000)->get()->unique('id');
            }

            // to get quantity all product on order 
            $dataOrderDetails = MerchantOrderDetail::where('merchant_id',$mId)->limit(1000)->get();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order    
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] 
                = $valueDod->qty;
            }

            //get count product
            $countProduct = MerchantProduct::count();
            $countOrder = MerchantOrder::count();
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();

            return view('arvi.backend.order-report.page-report-order-child',
                    compact('noww','joinForOrderDetails','productsOrder',
                    'countProduct','products','qrCode','countOrder'))->render();
        }
        // return view('arvi.frontend.page-not-available');
    }

    // export order to excel
    public function orderListExportExcel(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $mId = $data->id;
            $noww = Carbon::now();
            $idData = json_decode($request->idData,true);

            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries',
                'merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                ->join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->select('merchant_orders.create_time','merchant_orders.day_deliver','merchant_orders.id',
                'merchant_orders.name','merchant_orders.email','merchant_orders.mobile_number',
                'merchant_defined_deliveries.address','merchant_order_details.qty',
                'merchant_order_details.product_id')
                ->whereIn('merchant_orders.id',$idData)
                ->orderBy('merchant_orders.create_time','desc')
                ->limit(1000)->get()->unique('id');
            
            // to get quantity all product on order 
            $dataOrderDetails = MerchantOrderDetail::where('merchant_id',$mId)->limit(1000)->get();
            $productsOrder = [];
            foreach ($dataOrderDetails as $valueDod) {
                //quantity per order    
                $productsOrder[$valueDod->merchant_order_id][$valueDod->product_id] = $valueDod->qty;
            }

            //get count product
            $countProduct = MerchantProduct::count();
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();

            return Excel::download(new MerchantorderExport($noww,$joinForOrderDetails,
                $countProduct,$productsOrder,$products), 'Order_'.Carbon::now()->format('d-m-y').'.xlsx');
        }
        
    }
}
