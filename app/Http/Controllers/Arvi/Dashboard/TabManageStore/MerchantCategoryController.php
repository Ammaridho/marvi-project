<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ProductCategory;
use App\Models\BrandCategory;
use App\Models\Merchant;

class MerchantCategoryController extends Controller
{
    protected $view = 'arvi.backend.manage-merchant.merchant-category.'; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $merchant_id = $request->id;
            $brand_id = Merchant::find($merchant_id)->brand_id;
            $merchantName = Merchant::find($merchant_id)->name;
            $merchantCategories = ProductCategory::where('merchant_id',$merchant_id)
            ->orderBy('id','DESC')->get();
            $brandCategories = BrandCategory::where('brand_id',$brand_id)
            ->where('active',1)
            ->orderBy('id','DESC')->get();
            return view( $this->view . 'page-manage-store-custom-category',
                compact('companyCode','merchantCategories','brandCategories','merchant_id','merchantName'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $merchant_id = $request->merchant_id;
            return view($this->view . 'page-form-insert-category',
                compact('companyCode','merchant_id'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $validatedData = $request->validate([
                'name' => 'required',
            ]);
            $productCategory = new ProductCategory;
            $productCategory->merchant_id     = $request->merchant_id;
            $productCategory->category_name   = $request->name;
            $productCategory->category_type   = 'normal';
            $productCategory->save();
        }
        return view('arvi.page-not-available');
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
    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $id = $request->id;
            $merchant_id = $request->merchant_id;
            $productCategory = ProductCategory::find($id);
            return view($this->view . 'page-form-edit-category',
                compact('companyCode','productCategory','merchant_id'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            if(isset($request->statusActive)){
                $merchantCategory           = ProductCategory::find($request->id);
                $merchantCategory->active   = $request->statusActive;
                $merchantCategory->save();
            }else{
                $validatedData = $request->validate([
                    'id'               => 'required',
                    'name'             => 'required',
                ]);
                $id = $request->id;
                $productCategory = ProductCategory::find($id);
                $productCategory->category_name = $request->name;
                $productCategory->save();
            }
        }
        return view('arvi.page-not-available');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            ProductCategory::find($request->id)->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        return view('arvi.page-not-available');
    }
}
