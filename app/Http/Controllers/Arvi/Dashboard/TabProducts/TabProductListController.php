<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;

class TabProductListController extends Controller
{
    public function index(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        //get data merchant
        $data = Merchant::getByCode($qrCode);
        // check if merchant exist
        if ($data) {
            // get id merchant
            $mId = $data->id;
            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->paginate(5);
            $countProduct = MerchantProduct::count();
            return view('arvi.backend.product-list.page-product-list-parent',
            compact('products','qrCode','countProduct'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function indexFetch(Request $request)
    {
        // get code merchant
        $qrCode = $request->qrCode;
        //get data merchant
        $data = Merchant::getByCode($qrCode);
        // check if merchant exist
        if ($data) {
            // get id merchant
            $mId = $data->id;
            // to get data product
            $products = MerchantProduct::where('merchant_id',$mId)->orderBy('id','ASC')->paginate(5);
            $countProduct = MerchantProduct::count();
            return view('arvi.backend.product-list.page-product-list-child',
            compact('products','qrCode','countProduct'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $editProduct = MerchantProduct::find($id);
        $editProduct->sku = $request->sku;
        $editProduct->name = $request->name;
        $editProduct->description = $request->description;
        $editProduct->retail_price = $request->price;
        if ($request->status == 'active') {
            $editProduct->active = 1;
        }else{
            $editProduct->active = 0;
        }
        $editProduct->save();
    }
}
