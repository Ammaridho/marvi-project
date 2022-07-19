<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;

class TabProductListController extends Controller
{
    public function productList(Request $request)
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
            $products = MerchantProduct::where('merchant_id',$mId)->get();
            return view('arvi.backend.page-product-list',compact('products','qrCode'));
        }
        return view('arvi.frontend.page-not-available');
    }
}
