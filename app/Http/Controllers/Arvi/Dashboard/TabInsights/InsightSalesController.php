<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabInsights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsightSalesController extends Controller
{
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        return view('arvi.backend.dashboard.insights.sales',compact('companyCode'));
    }
}
