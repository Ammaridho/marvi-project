<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabMenu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\BrandCategory;
use App\Models\ArviDelivery;
use App\Models\Company;

use Carbon\Carbon;

class TabCategoriesController extends Controller
{
    protected $view  = 'arvi.backend.menu.categories.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $productCategoriesNormal = BrandCategory::where('category_type','normal')->orderBy('id','DESC')->get();
        $productCategoriesFixed = BrandCategory::where('category_type','fixed')->orderBy('id','DESC')->get();
        $merchants = Merchant::all();
        return view($this->view . 'page-manage-store-custom-category',
            compact('companyCode','productCategoriesNormal','productCategoriesFixed','merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $merchants = Merchant::all();
        $arviDeliveries = ArviDelivery::all();
        return view($this->view . 'page-form-insert-category',
            compact('merchants','arviDeliveries','companyCode'));
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
                'name'             => 'required',
            ]);

            $productCategory = new BrandCategory;
            $productCategory->brand_id        = 1;
            $productCategory->category_name   = $request->name;
            $productCategory->category_type   = 'normal';
            // cek input arviDeliveries
            if (isset($request->arviDeliveries)) {
                $productCategory->deliver_method = json_encode($request->arviDeliveries);
            } else {
                $productCategory->deliver_method = null;
            }
            // cek input store
            if (isset($request->merchants)) {
                $productCategory->availability_store = json_encode($request->merchants);
            } else {
                $productCategory->availability_store = null;
            }
            $productCategory->save();
        }
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
        $id = $request->id;
        $productCategory = BrandCategory::find($id);
        $merchants = Merchant::all();
        $arviDeliveries = ArviDelivery::all();
        return view($this->view . 'page-form-edit-category',
            compact('companyCode','productCategory','merchants','arviDeliveries'));
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
                    $productCategory->availability_store = json_encode($request->merchants);
                } else {
                    $productCategory->availability_store = null;
                }
                $productCategory->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        BrandCategory::find($request->id)->delete();
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
