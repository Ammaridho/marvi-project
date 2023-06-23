<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\ProductCategory;
use App\Models\BrandCategory;
use App\Models\MerchantProduct;
use App\Models\ProductAttribute;
use App\Models\MerchantProductVariant;

class SearchController extends Controller
{
    protected $view = 'arvi.frontend.area.search.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$code)
    {

        $dataProducts = '';
        $a = '';

        // all product data
        $a = MerchantProduct::
        leftJoin('product_category_list','merchant_products.id','=',
        'product_category_list.merchant_product_id')
        ->leftJoin('brand_categories','product_category_list.brand_category_id',
        '=','brand_categories.id')
        ->leftJoin('merchants','merchant_products.merchant_id',
        '=','merchants.id')
        ->join('locations','locations.id','=','merchants.location_id')
        ->leftJoin('product_categories','product_category_list.product_category_id',
        '=','product_categories.id')
        ->join('product_images','merchant_products.id','=',
        'product_images.merchant_product_id')
        ->select(
            'merchants.name as merchant_name',
            'merchant_products.id as merchant_products_id',
            'merchant_products.name',
            'merchant_products.currency',
            'merchant_products.retail_price',
            'merchant_products.description',
            'brand_categories.category_name as brand_categories',
            'product_categories.category_name as product_categories',
            'product_images.url',
            'product_images.image_mime',
            'product_images.image_type',
            'locations.code'
        )->where('locations.code',$code);

        if ($request->search) {
        $dataProducts = $a->where('merchant_products.name', 'ILIKE', "%$request->search%")
        ->orWhere('merchants.name', 'ILIKE', "%$request->search%")->limit(10)->get();
        }else{
        $dataProducts = $a->limit(10)->get();
        }

        return view($this->view . 'list-store',compact('dataProducts','code'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
