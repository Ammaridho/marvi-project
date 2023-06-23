<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabMenu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\ProductCategory;
use App\Models\ProductCategoryList;
use App\Models\BrandProduct;
use App\Models\BrandImage;
use App\Models\Company;

use Illuminate\Support\Str;
use Validator;

class TabProductsController extends Controller
{
    protected $view  = 'arvi.backend.menu.products.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        //for search
        if (isset($request->action)) {
            $productCategories = ProductCategory::all();
            $products = BrandProduct::leftJoin('brand_images',
            'brand_products.id','=','brand_images.brand_product_id')
            ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
            ->orderBy('brand_products.id', 'ASC')
            ->get();
            return view($this->view . 'page-product-list-child',
                compact('companyCode','productCategories','products'));
        } else {
            // Like To Buy
            $productCategories = ProductCategory::all();
            $products = BrandProduct::leftJoin('brand_images',
            'brand_products.id','=','brand_images.brand_product_id')
            ->orderBy('brand_products.id', 'ASC')
            ->get();
            return view($this->view . 'page-product-list-parent',
                compact('companyCode','productCategories','products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $productCategories = ProductCategory::all();
        $merchants = Merchant::all();
        return view($this->view . 'page-product-detail',
            compact('companyCode','productCategories','merchants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'              => 'required',
            'description'       => 'required',
            'sku'               => 'required',
            'preparation_time'  => 'required',
            'retail_price'      => 'required',
            'min_order'         => 'required',
            'max_order'         => 'required',
            'image_url'         => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        

        if ($validation->passes()) {
            // set code brand product
            $code = Str::Random(10);

            // save image file to repo
            $image = $request->file('image_url');
            $new_name_image = $request->name . '_'. $code . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('brand_product_image'), $new_name_image);

            // store brand product
            $storeA = new BrandProduct;
            $storeA->brand_id            = 1;
            $storeA->product_id          = $code;
            $storeA->name                = $request->name;
            $storeA->description         = $request->description;
            $storeA->sku                 = $request->sku;
            $storeA->preparation_time    = $request->preparation_time;
            $storeA->retail_price        = $request->retail_price;
            $storeA->min_order           = $request->min_order;
            $storeA->max_order           = $request->max_order;
            $storeA->active              = isset($request->active) ? 1 : 0 ;
            $storeA->save();

            // stor brand image
            $storeB = new BrandImage;
            $storeB->brand_id            = 1;
            $storeB->image_type          = $image->getClientOriginalExtension();
            $storeB->url                 = $new_name_image;
            $storeB->active              = isset($request->active) ? 1 : 0 ;
            $storeB->BrandProduct()->associate($storeA);
            $storeB->save();

            
            if (isset($request->merchants)) {
                foreach ($request->merchants as $valueA) {
                    $storeC = new MerchantProduct;
                    $storeC->merchant_id         = $valueA;
                    $storeC->product_id          = $code;
                    $storeC->name                = $request->name;
                    $storeC->description         = $request->description;
                    $storeC->sku                 = $request->sku;
                    $storeC->preparation_time    = $request->preparation_time;
                    $storeC->retail_price        = $request->retail_price;
                    $storeC->min_order           = $request->min_order;
                    $storeC->max_order           = $request->max_order;
                    $storeC->active              = isset($request->active) ? 1 : 0 ;
                    $storeC->save();
                    // foreach ($request->productCategories as $valueB) { //ini belum benar
                    //     $storeD = new ProductCategoryList;
                    //     $storeD->merchant_id         = $valueA;
                    //     $storeD->product_category_id = $valueB;
                    //     $storeD->merchant_product__id = $valueB;
                    //     $storeC->active              = isset($request->active) ? 1 : 0 ;
                    //     // $storeD->MerchantProduct()->associate($storeC);
                    //     $storeD->save();
                    // }
                }
            }
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
