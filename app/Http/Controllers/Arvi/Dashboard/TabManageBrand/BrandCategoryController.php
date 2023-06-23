<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageBrand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\BrandCategory;
use App\Models\Merchant;
use App\Models\Brand;

class BrandCategoryController extends Controller
{
    protected $view = 'arvi.backend.manage-brand.brand-category.'; 

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
            $brand_id = $request->id;
            $brandName = Brand::find($brand_id)->name;
            $brandCategories = BrandCategory::where('brand_id',$brand_id)
            ->orderBy('id','DESC')->get();
            $merchants = Merchant::where('brand_id',$brand_id)
            ->orderBy('id','DESC')->get();
            return view( $this->view . 'page-manage-store-custom-category',
                compact('companyCode','brandCategories','merchants','brand_id','brandName'));
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
            $brand_id = $request->brand_id;
            $merchants = Merchant::where('brand_id',$brand_id)
            ->orderBy('id','DESC')->get();
            return view($this->view . 'page-form-insert-category',
                compact('merchants','companyCode','brand_id'));
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

            $productCategory = new BrandCategory;
            $productCategory->brand_id        = $request->brand_id;
            $productCategory->category_name   = $request->name;
            $productCategory->category_type   = 'normal';
            // cek input store
            if (isset($request->storeAvaibility)) {
                $productCategory->availability_store = $request->storeAvaibilityData;
            } else {
                $productCategory->availability_store = null;
            }
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
            $companyCode = $request->companyCode;
            $id = $request->id;
            $brand_id = $request->brand_id;
            $productCategory = BrandCategory::find($id);
            $merchants = Merchant::where('brand_id',$brand_id)->get();
            return view($this->view . 'page-form-edit-category',
                compact('companyCode','productCategory','merchants','brand_id'));
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
            if (isset($request->modalEditStore)) {
                $companyCode = $request->companyCode;
                $data = Company::getByCode($companyCode);
                if ($data) {
                    $validatedData = $request->validate([
                        'id'               => 'required',
                    ]);
                    $id = $request->id;
                    $productCategory = BrandCategory::find($id);
                    if (isset($request->selectStore)) {
                        $productCategory->availability_store = json_encode($request->selectStore);
                    } else {
                        $productCategory->availability_store = null;
                    }
                    $productCategory->save();
                }
            }elseif(isset($request->statusActive)){
                    $brandCategory               = BrandCategory::find($request->id);
                    $brandCategory->active       = $request->statusActive;
                    $brandCategory->save();
            }else{
                $companyCode = $request->companyCode;
                $data = Company::getByCode($companyCode);
                if ($data) {
                    $validatedData = $request->validate([
                        'id'               => 'required',
                        'name'             => 'required',
                    ]);
                    $id = $request->id;
                    $productCategory = BrandCategory::find($id);
                    $productCategory->category_name        = $request->name;
                    // cek input arviDeliveries
                    if (isset($request->arviDeliveries)) {
                        $productCategory->deliver_method = json_encode($request->arviDeliveries);
                    } else {
                        $productCategory->deliver_method = null;
                    }
                    // cek input store
                    if (isset($request->merchants)) {
                        $productCategory->availability_store = $request->storeAvaibilityData;
                    } else {
                        $productCategory->availability_store = null;
                    }
                    $productCategory->save();
                }
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
            BrandCategory::find($request->id)->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        return view('arvi.page-not-available');
    }
}
