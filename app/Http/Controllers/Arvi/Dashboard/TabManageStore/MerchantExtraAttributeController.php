<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\MerchantExtraAttribute;
use App\Models\BrandExtraAttribute;
use App\Models\UomList;


class MerchantExtraAttributeController extends Controller
{
    protected $view = 'arvi.backend.manage-merchant.merchant-extra-attribute.';

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
            $merchant = Merchant::find($merchant_id);
            $brand_id = $merchant->brand_id;
            $merchantName = $merchant->name;
            $merchantExtraAttributes = MerchantExtraAttribute::where('merchant_id',$merchant_id)
            ->orderBy('id','DESC')->get();
            $brandExtraAttribute = BrandExtraAttribute::where('brand_id',$brand_id)
            ->where('active',1)
            ->orderBy('id','DESC')->get();
            return view( $this->view . 'page-merchant-product-extra-attributes-list',
                compact('merchant_id','companyCode',
                'merchantName','merchantExtraAttributes','brandExtraAttribute'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $merchant_id = $request->merchant_id;
            $brand_id = Merchant::find($merchant_id)->brand_id;
            $much = isset($request->much) ? $request->much : 25;
            if ($much != 'all') {
                $merchantExtraAttributes = MerchantExtraAttribute::where('merchant_id',$merchant_id)
                ->orderBy('id','DESC')->take($much)->get();
            } else {
                $merchantExtraAttributes = MerchantExtraAttribute::where('merchant_id',$merchant_id)
                ->orderBy('id','DESC')->get();
            }
            $merchantExtraAttribute = BrandExtraAttribute::where('brand_id',$brand_id)
            ->where('active',1)
            ->orderBy('id','DESC')->get();
            return view( $this->view . 'data-table-extra-attribute',
                compact('merchant_id','companyCode','merchantExtraAttributes','merchantExtraAttribute'));
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
            $uomList = UomList::all();
            return view( $this->view . 'page-merchant-product-extra-attributes-new',
                compact('merchant_id','companyCode','uomList'));
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
            $merchantExtraAttribute = new MerchantExtraAttribute;
            $merchantExtraAttribute->merchant_id  = $request->merchant_id;
            $merchantExtraAttribute->brand_id  = Merchant::find($request->merchant_id)->brand_id;
            $merchantExtraAttribute->name      = $request->name;
            $merchantExtraAttribute->currency  = Brand::find($merchantExtraAttribute->brand_id)->currency;
            $merchantExtraAttribute->type      = 'normal';
            $merchantExtraAttribute->fee       = $request->fee;
            $merchantExtraAttribute->sku       = strtoupper($request->sku);
            $merchantExtraAttribute->uom       = $request->uom;
            $merchantExtraAttribute->weight    = $request->weight;
            $merchantExtraAttribute->save();
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
            $merchant_id = $request->merchant_id;
            $id = $request->id;
            $merchantExtraAttribute = MerchantExtraAttribute::find($id);
            $uomList = UomList::all();
            return view( $this->view . 'page-merchant-product-extra-attributes-edit',
                compact('merchant_id','companyCode','merchantExtraAttribute',
                'uomList'));
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
                    $merchantExtraAttribute          = MerchantExtraAttribute::find($request->id);
                    $merchantExtraAttribute->active  = $request->statusActive;
                    $merchantExtraAttribute->save();
            }else{
                $companyCode = $request->companyCode;
                $data = Company::getByCode($companyCode);
                if ($data) {
                    $validatedData = $request->validate([
                        'merchant_id'     => 'required',
                        'name'         => 'required',
                        'fee'          => 'required',
                        'sku'    => 'required',
                        'uom'    => 'required',
                        'weight' => 'required',
                    ]);
                    $id = $request->id;
                    $merchantExtraAttribute = MerchantExtraAttribute::find($id);
                    $merchantExtraAttribute->name    = $request->name;
                    $merchantExtraAttribute->fee     = $request->fee;
                    $merchantExtraAttribute->sku     = strtoupper($request->sku);
                    $merchantExtraAttribute->uom     = $request->uom;
                    $merchantExtraAttribute->weight  = $request->weight;
                    $merchantExtraAttribute->save();
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
        MerchantExtraAttribute::find($request->id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
