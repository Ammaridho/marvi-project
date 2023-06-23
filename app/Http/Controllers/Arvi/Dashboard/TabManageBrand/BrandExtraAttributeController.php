<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageBrand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\BrandExtraAttribute;
use App\Models\UomList;

class BrandExtraAttributeController extends Controller
{
    protected $view = 'arvi.backend.manage-brand.brand-extra-attribute.';

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
            $brandExtraAttributes = BrandExtraAttribute::where('brand_id',$brand_id)
            ->orderBy('id','DESC')->get();
            $brandName = Brand::find($brand_id)->name;
            return view( $this->view . 'page-brand-product-extra-attributes-list',
                compact('brand_id','companyCode','brandExtraAttributes','brandName'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $brand_id = $request->brand_id;
            $much = isset($request->much) ? $request->much : 25;
            if ($much != 'all') {
                $brandExtraAttributes = BrandExtraAttribute::where('brand_id',$brand_id)
                ->orderBy('id','DESC')->take($much)->get();
            } else {
                $brandExtraAttributes = BrandExtraAttribute::where('brand_id',$brand_id)
                ->orderBy('id','DESC')->get();
            }
            return view( $this->view . 'data-table-extra-attribute',
                compact('brand_id','companyCode','brandExtraAttributes'));
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

            $uomList = UomList::all();

            return view( $this->view . 'page-brand-product-extra-attributes-new',
                compact('brand_id','companyCode','uomList'));
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
                'name'   => 'required',
                'fee'    => 'required',
                'sku'    => 'required',
                'uom'    => 'required',
                'weight' => 'required',
            ]);
            $brandExtraAttribute = new BrandExtraAttribute;
            $brandExtraAttribute->brand_id  = $request->brand_id;
            $brandExtraAttribute->currency  = Brand::find($request->brand_id)->currency;
            $brandExtraAttribute->name      = $request->name;
            $brandExtraAttribute->type      = 'normal';
            $brandExtraAttribute->fee       = $request->fee;
            $brandExtraAttribute->sku       = strtoupper($request->sku);
            $brandExtraAttribute->uom       = $request->uom;
            $brandExtraAttribute->weight    = $request->weight;
            $brandExtraAttribute->save();
        }
        return view('arvi.page-not-available');
    }

    /**
     * Display the specified resource.
/     *
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
            $brand_id = $request->brand_id;
            $id = $request->id;
            $brandExtraAttribute = BrandExtraAttribute::find($id);
            $uomList = UomList::all();
            return view( $this->view . 'page-brand-product-extra-attributes-edit',
                compact('brand_id','companyCode','brandExtraAttribute','uomList'));
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
                    $brandExtraAttribute          = BrandExtraAttribute::find($request->id);
                    $brandExtraAttribute->active  = $request->statusActive;
                    $brandExtraAttribute->save();
            }else{
                $companyCode = $request->companyCode;
                $data = Company::getByCode($companyCode);
                if ($data) {
                    $validatedData = $request->validate([
                        'brand_id'     => 'required',
                        'name'         => 'required',
                        'fee'          => 'required',
                        'sku'          => 'required',
                        'uom'          => 'required',
                        'weight'       => 'required',
                    ]);
                    $id = $request->id;
                    $brandExtraAttribute = BrandExtraAttribute::find($id);
                    $brandExtraAttribute->name      = $request->name;
                    $brandExtraAttribute->fee       = $request->fee;
                    $brandExtraAttribute->sku       = strtoupper($request->sku);
                    $brandExtraAttribute->uom       = $request->uom;
                    $brandExtraAttribute->weight    = $request->weight;
                    $brandExtraAttribute->save();
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
            $id = $request->id;
            $brandExtraAttribute = BrandExtraAttribute::find($id)->delete();
        }
        return view('arvi.page-not-available');
    }
}
