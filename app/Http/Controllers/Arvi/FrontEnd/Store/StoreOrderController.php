<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\ProductCategory;
use App\Models\BrandCategory;
use App\Models\MerchantProduct;
use App\Models\ProductAttribute;
use App\Models\MerchantProductVariant;

class StoreOrderController extends Controller
{
    protected $view = 'arvi.frontend.store.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$code)
    {
        $merchant = Merchant::join('brands','brands.id','=','merchants.brand_id')
        ->select('brands.image_url as logo','merchants.*')
        ->where('merchants.code',$code)->first();
        $merchantId = $merchant->id;

        // ga_code
        $request->session()->put('ga_code', $merchant->ga_code);

        $categoriesM = [];
        $categoriesB = [];
        $categoriesM = MerchantProduct::
            join('product_category_list','merchant_products.id','=',
            'product_category_list.merchant_product_id')
            ->join('product_categories','product_category_list.product_category_id',
            '=','product_categories.id')
            ->leftJoin('product_images','merchant_products.id','=',
            'product_images.merchant_product_id')
            ->where('merchant_products.merchant_id',$merchantId)
            ->select('product_categories.category_name')
            ->distinct('product_categories.category_name')
            ->pluck('product_categories.category_name')
            ->toArray();

        $categoriesB = MerchantProduct::
            join('product_category_list','merchant_products.id','=',
            'product_category_list.merchant_product_id')
            ->join('brand_categories','product_category_list.brand_category_id',
            '=','brand_categories.id')
            ->leftJoin('product_images','merchant_products.id','=',
            'product_images.merchant_product_id')
            ->where('merchant_products.merchant_id',$merchantId)
            ->select('brand_categories.category_name')
            ->distinct('brand_categories.category_name')
            ->pluck('brand_categories.category_name')
            ->toArray();

        $categories = array_merge($categoriesM,$categoriesB);

        // all product data
        $dataProducts = MerchantProduct::
            leftJoin('product_category_list','merchant_products.id','=',
            'product_category_list.merchant_product_id')
            ->leftJoin('brand_categories','product_category_list.brand_category_id',
            '=','brand_categories.id')
            ->leftJoin('product_categories','product_category_list.product_category_id',
            '=','product_categories.id')
            ->leftJoin('product_images','merchant_products.id','=',
            'product_images.merchant_product_id')
            ->where('merchant_products.merchant_id',$merchantId)
            ->select(
                'merchant_products.id as merchant_products_id',
                'merchant_products.name',
                'merchant_products.currency',
                'merchant_products.retail_price',
                'merchant_products.discount_price',
                'merchant_products.description',
                'brand_categories.category_name as brand_categories',
                'product_categories.category_name as product_categories',
                'product_images.url',
                'product_images.image_mime',
                'product_images.image_type'
            )
            ->where('merchant_products.active',1)
            ->get();


        // combine data base on category
        $listProduct = [];
        foreach ($dataProducts as $key => $value) {
            if (!($value['brand_categories']||$value['product_categories'])) {
                $listProduct['noCategory'][] = $value;
            }
            if ($value['brand_categories']) {
                $listProduct[$value['brand_categories']][] = $value;
            }
            if ($value['product_categories']) {
                $listProduct[$value['product_categories']][] = $value;
            }
        }

        return view($this->view . 'page-merchant',
            compact('merchant','categories',
            'listProduct','code'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$code)
    {
        $product = MerchantProduct::
        leftJoin('product_images','merchant_products.id','=',
        'product_images.merchant_product_id')
        ->where('merchant_products.id',$request->productId)
        ->select(
            'merchant_products.id',
            'merchant_products.merchant_id',
            'merchant_products.name',
            'merchant_products.weight',
            'merchant_products.retail_price',
            'merchant_products.discount_price',
            'merchant_products.currency',
            'merchant_products.description',
            'product_images.url',
            )
        ->first();
        $merchantId = $product->merchant_id;
        $productAttributes = ProductAttribute::
            where('merchant_product_id',$request->productId)
            ->get();
        $productVariants = MerchantProductVariant::
            where('merchant_product_id',$request->productId)
            ->get();

        // brand extra attribute
        $brand_extra_attributes = MerchantProduct::
            join('merchant_extra_attribute_list','merchant_products.id','=',
            'merchant_extra_attribute_list.merchant_product_id')
            ->join('brand_extra_attributes','merchant_extra_attribute_list.brand_extra_attribute_id',
            '=','brand_extra_attributes.id')
            ->select(
                'brand_extra_attributes.name',
                'brand_extra_attributes.id',
                'brand_extra_attributes.fee',
                'brand_extra_attributes.currency',
                'brand_extra_attributes.brand_id',
                'brand_extra_attributes.weight',
                )
            ->where('merchant_products.id',$request->productId)
            ->get()->toArray();

        // merchant extra attribute
        $merchant_extra_attributes = MerchantProduct::
            join('merchant_extra_attribute_list','merchant_products.id','=',
            'merchant_extra_attribute_list.merchant_product_id')
            ->join('merchant_extra_attributes',
            'merchant_extra_attribute_list.merchant_extra_attribute_id',
            '=','merchant_extra_attributes.id')
            ->select(
                'merchant_extra_attributes.name',
                'merchant_extra_attributes.id',
                'merchant_extra_attributes.fee',
                'merchant_extra_attributes.currency',
                'merchant_extra_attributes.weight',
                )
            ->where('merchant_products.id',$request->productId)
            ->get()->toArray();

        $extraAttributes = array_merge($brand_extra_attributes,$merchant_extra_attributes);

        $cartId = $request->cartId;

        return view($this->view . 'page-product',
            compact('product','merchantId','productAttributes','productVariants',
                'extraAttributes','cartId','code'));
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
