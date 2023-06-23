<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\MerchantHour;
use App\Models\MerchantProduct;
use App\Models\BrandProduct;

use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        //get data merchant
        $data = Company::getByCode($companyCode);
        // check if merchant exist
        if ($data) {
            // date now
            $now = Carbon::now();

            $company_id = $data->id;
            $first_brand_exist       = Brand::where('company_id',$company_id)->exists();
            $first_merchant_exist    = Merchant::where('company_id',$company_id)->exists();
            if ($first_merchant_exist ) {
                $first_merchant       = Merchant::where('company_id',$company_id)->first()
                                        ->id;
                $first_hours_exist   = MerchantHour::where('merchant_id',$first_merchant)
                                        ->exists();
                $first_brand         = Brand::where('company_id',$company_id)->first()
                                        ->id;
                $first_brand_product_exist = BrandProduct::where('brand_id',$first_brand)
                                              ->exists();
            }else{
                $first_hours_exist = false;
                $first_brand_product_exist = false;
            }

            //set new preview home or not (just set command)
            return view('arvi.backend.dashboard.index',
                compact('companyCode','company_id','first_brand_exist','first_merchant_exist',
                    'first_hours_exist','first_brand_product_exist'));
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
