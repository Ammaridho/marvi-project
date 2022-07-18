<?php

namespace App\Http\Controllers\Arvi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view(Request $request)
    {
        $dataCart = $request->dataCart;

        return view('arvi.frontend.cart',compact('dataCart'));
    }

}
