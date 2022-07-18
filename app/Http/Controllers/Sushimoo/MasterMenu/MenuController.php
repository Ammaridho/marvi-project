<?php

namespace App\Http\Controllers\Sushimoo\MasterMenu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// database
use App\Models\ProductCategory;
use App\Models\MerchantProduct;
use App\Models\ExtraAttribute;

class MenuController extends Controller
{
    protected $route = 'Master-Menu.';
    protected $view = 'sushimoo.frontend.';
    protected $merchantId = 4;

    public function listCategory(Request $request)
    {
        $route = $this->route;

        $categories = ProductCategory::all();

        return view($this->view.'index',compact(
            'route',
            'categories'
        ));
    }
    
    
    public function listProduct(Request $request)
    {
        $route = $this->route;

        $idCategory = $request->id;

        $products = ProductCategory::join('product_category_list','product_categories.id','=','product_category_list.product_category_id')
                                    ->join('merchant_products','product_category_list.merchant_product_id','=','merchant_products.id')
                                    ->where('merchant_products.merchant_id',$this->merchantId)
                                    ->where('product_categories.id',$idCategory)
                                    ->get();

        return view($this->view.'page-menu',compact(
            'route',
            'products',
            'idCategory'
        ));
    }
    
    public function displayProduct(Request $request)
    {
        $route = $this->route;

        $idProduct = $request->id;

        $product = MerchantProduct::find($idProduct);

        $extraAtributesCondiments = ExtraAttribute::where('merchant_id',4)->where('type','Condiments')->get();
        $extraAtributesCutlery = ExtraAttribute::where('merchant_id',4)->where('type','Cutlery')->get();
                                        
        return view($this->view.'page-item',compact(
            'route',
            'product',
            'extraAtributesCondiments',
            'extraAtributesCutlery',
        ));
    }
}
