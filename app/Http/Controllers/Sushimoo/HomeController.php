<?php

namespace App\Http\Controllers\Sushimoo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $reqeust)
    {
        return redirect()->route('Master-Menu.listCategory');
    }   
}