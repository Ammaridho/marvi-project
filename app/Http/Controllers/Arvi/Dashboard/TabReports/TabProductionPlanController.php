<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Library\Vendor\autoload;
use App\Exports\MerchantProductionPlanExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\MerchantOrder;
use App\Models\MerchantOrderDetail;
use App\Models\Company;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

class TabProductionPlanController extends Controller
{
    public function productionPlanList(Request $request)
    {
        // get code merchant
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {
            // get id merchant
            $mId = $data->id;

            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->get();

            $fromDate = "2016-10-01";
            $toDate   = "2016-10-31";

             // Production Plan
             $joinForProductPlans = MerchantOrder::
                join('merchant_order_details','merchant_orders.id','=',
                'merchant_order_details.merchant_order_id')
                ->select('merchant_orders.day_deliver','merchant_orders.id',
                'merchant_order_details.qty','merchant_order_details.product_id')
                ->whereBetween('merchant_orders.day_deliver', [Carbon::now(), Carbon::now()->addDays(6)])
                ->get();

            $productPlan = [];
            $qtyp = 0;
            foreach ($joinForProductPlans as $key => $value) { //product
                $productPlan[$value->product_id][$value->day_deliver][$value->id] 
                = $value->qty;   
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
            return view('arvi.backend.production-plan-report.page-report-production-plan',
                    compact('noww','dateA','dateH','productPlan','joinForProductPlans',
                    'products','companyCode'));
        }
        return view('arvi.page-not-available');
    }

    public function productionPlanExportExcel(Request $request)
    {
        return Excel::download(new MerchantProductionPlanExport, 
            'Production_Plan_'.Carbon::now()->format('d-m-y').'.xlsx');
    }
}
