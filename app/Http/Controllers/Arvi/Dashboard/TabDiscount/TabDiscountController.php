<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabDiscount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\Company;

class TabDiscountController extends Controller
{
    protected $view = 'arvi.backend.discounts.';

    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        return view($this->view . 'index',compact('companyCode'));
    }

    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $merchants = Merchant::all();
        return view($this->view . 'page-discount-add',compact('companyCode','merchants'));
    }
}
