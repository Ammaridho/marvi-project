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

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

class TabOrderController extends Controller
{
    public function OrderList(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        //get data merchant
        $data = Merchant::getByCode($qrCode);
        // check if merchant exist
        if ($data) {
            // get id merchant
            $mId = $data->id;
            // date
            $noww = Carbon::now();
            // to get data order, bio customer and pickup address
            $joinForOrderDetails = MerchantOrder::join('merchant_defined_deliveries','merchant_orders.defined_delivery_id','=','merchant_defined_deliveries.id')
                                ->join('merchant_order_details','merchant_orders.id','=','merchant_order_details.merchant_order_id')
                                ->select('merchant_orders.create_time','merchant_orders.day_deliver','merchant_orders.id',
                                'merchant_orders.name','merchant_orders.email','merchant_orders.mobile_number',
                                'merchant_defined_deliveries.address','merchant_order_details.qty','merchant_order_details.product_id')
                                ->orderBy('day_deliver','asc')->get()->unique('id');
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
            // $products = MerchantProduct::where('merchant_id',$mId)->get();
            return view('arvi.backend.page-report-orders',compact('noww','joinForOrderDetails','productsOrder','countProduct','qrCode'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function OrderListExportExcel(Request $request)
    {
        return Excel::download(new MerchantorderExport, 'Order_'.Carbon::now()->format('d-m-y').'.xlsx');
    }
}
