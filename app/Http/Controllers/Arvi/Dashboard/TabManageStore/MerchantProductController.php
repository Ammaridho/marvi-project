<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;

use App\Models\Brand;
use App\Models\BrandProduct;
use App\Models\BrandImage;
use App\Models\BrandProductAttribute;
use App\Models\BrandProductVariant;
use App\Models\BrandCategoryList;
use App\Models\BrandCategory;
use App\Models\BrandExtraAttributeList;
use App\Models\BrandExtraAttribute;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\MerchantProductVariant;
use App\Models\ProductAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\MerchantInventory;

use App\Models\UomList;

use Validator;

use Carbon\Carbon;

class MerchantProductController extends Controller
{
    protected $view = 'arvi.backend.manage-merchant.merchant-product.'; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $merchant_id = $request->id;
            $brand_id = $request->brand_id;
            //for search
            if (isset($request->action)) {
                $productCategories = ProductCategory::where('merchant_id',$merchant_id)->get();
                if($request->filter == 'all'){
                    $merchantProducts = MerchantProduct::leftJoin('product_images','merchant_products.id',
                    '=','product_images.merchant_product_id')
                    ->select('*','merchant_products.active as active','merchant_products.id as id')
                    ->orderBy('merchant_products.id', 'DESC')
                    ->where('merchant_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('merchant_products.merchant_id',$merchant_id)
                    ->get();
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->orderBy('brand_products.id', 'DESC')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->get();
                }else if($request->filter == 1 || $request->filter == 0){
                    $merchantProducts = MerchantProduct::leftJoin('product_images','merchant_products.id',
                    '=','product_images.merchant_product_id')
                    ->select('*','merchant_products.active as active','merchant_products.id as id')
                    ->orderBy('merchant_products.id', 'DESC')
                    ->where('merchant_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('merchant_products.merchant_id',$merchant_id)
                    ->where('merchant_products.active',$request->filter)
                    ->get();
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->orderBy('brand_products.id', 'DESC')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->where('brand_products.active',$request->filter)
                    ->get();
                }else{
                    $filter = $request->filter;
                    $merchantProducts = MerchantProduct::leftJoin('product_images','merchant_products.id',
                    '=','product_images.merchant_product_id')
                    ->orderBy('merchant_products.id', 'DESC')
                    ->select('*','merchant_products.active as active','merchant_products.id as id')
                    ->where('merchant_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('merchant_products.merchant_id',$merchant_id)
                    ->whereHas('brand_categories', function($q) use($filter) {
                        $q->where('name', $filter);
                    })
                    ->get();
                    $filter = $request->filter;
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->orderBy('brand_products.id', 'DESC')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->whereHas('brand_categories', function($q) use($filter) {
                        $q->where('name', $filter);
                    })
                    ->get();
                }
                return view($this->view . 'page-product-list-child',
                    compact('companyCode','merchantProducts','brandProducts',
                    'productCategories','merchant_id','brand_id'));
            } 
            else {
                // index
                $merchant = merchant::find($merchant_id);
                $productCategories = ProductCategory::where('merchant_id',$merchant_id)->get();
                $merchantProductTemp = MerchantProduct::leftJoin('product_images','merchant_products.id',
                '=','product_images.merchant_product_id')
                ->select('*','merchant_products.active as active','merchant_products.id as id')
                ->orderBy('merchant_products.id', 'DESC')
                ->where('merchant_products.merchant_id',$merchant_id);                
                // sku for checking if product brand already exist in merchant product
                $alreadyProduct = $merchantProductTemp->pluck('sku')->toArray();
                $merchantProducts = $merchantProductTemp->get();
                $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                '=','brand_images.brand_product_id')
                ->select('*','brand_products.active as active','brand_products.id as id')
                ->orderBy('brand_products.id', 'DESC')
                ->where('brand_products.brand_id',$brand_id)
                ->whereNotIn('brand_products.sku',$alreadyProduct)
                ->get();

                return view($this->view . 'page-product-list-parent',
                    compact('companyCode','merchantProducts','brandProducts','productCategories',
                        'merchant_id','merchant','brand_id'));
            }
        }
        return view('arvi.page-not-available');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $merchant_id = $request->merchant_id;
            $merchantCategories = ProductCategory::where('merchant_id',$merchant_id)->get();
            return view($this->view . 'page-product-insert',
                compact('companyCode','merchantCategories','merchant_id','extraAttributes'));
        }
        return view('arvi.page-not-available');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {

            $validation = Validator::make($request->all(), [
                'name'              => 'required',
                'sku'               => 'required',
                'preparation_time'  => 'required',
                'retail_price'      => 'required',
                'min_order'         => 'required',
            ]);

            // get data brand product with id
            $brandProduct = BrandProduct::find($request->id);
            $brandImage = BrandImage::where('brand_product_id',$request->id)->first();
            $brandProductVariant = BrandProductVariant::where('brand_product_id',$request->id)->get();
            $brandProductAttribute = BrandProductAttribute::where('brand_product_id',$request->id)->get();

            // merchant
            $merchant = Merchant::find($request->merchant_id);

            // store merchant product
            $merchantProduct = new MerchantProduct;
            $merchantProduct->merchant_id         = $request->merchant_id;
            $merchantProduct->brand_id            = $merchant->brand_id;
            $merchantProduct->currency            = $merchant->currency;
            $merchantProduct->product_id          = $brandProduct['product_id'];
            $merchantProduct->brand_product_id    = $request->id;
            $merchantProduct->name                = $brandProduct['name'];
            $merchantProduct->description         = $brandProduct['description'];
            $merchantProduct->sku                 = strtoupper($brandProduct['sku']);
            $merchantProduct->preparation_time    = $brandProduct['preparation_time'];
            $merchantProduct->retail_price        = $brandProduct['retail_price'];
            $merchantProduct->min_order           = $brandProduct['min_order'];
            $merchantProduct->max_order           = $brandProduct['max_order'];
            $merchantProduct->discount_price      = $brandProduct['discount_price'];
            $merchantProduct->available_days      = $brandProduct['available_days'];
            $merchantProduct->uom                 = $brandProduct['uom'];
            $merchantProduct->weight              = $brandProduct['weight'];
            $merchantProduct->active              = $brandProduct->active;
            $merchantProduct->save();

            if (isset($brandImage['url'])) {
                // stor merchant image
                $merchantImage = new ProductImage;
                $merchantImage->merchant_id         = $request->merchant_id;
                $merchantImage->image_type          = $brandImage['image_type'];
                $merchantImage->url                 = $brandImage['url'];
                $merchantImage->image_mime          = $brandImage['image_mime'];
                $merchantImage->image_type          = $brandImage['image_type'];
                $merchantImage->active              = $brandImage['active'];
                $merchantImage->merchantProduct()->associate($merchantProduct);
                $merchantImage->save();
            }

            // get data from brand_category_list with where brand_product_id
            $dataBrandCategories = BrandCategoryList::where('brand_product_id',$request->id)
                ->pluck('brand_category_id')->toArray();
            $merchantProduct->brandCategories()->attach($dataBrandCategories,
                ['create_time' => Carbon::now()]);

            // variant
            // get data variant from brand product
            $brandVariants = BrandProductVariant::where('brand_product_id',$request->id)->get();
            foreach ($brandVariants as $item) { 
                $variant = new MerchantProductVariant;
                $variant->name              = $item['name'];
                $variant->sku               = strtoupper($item['sku']);
                $variant->retail_price      = $item['retail_price'];
                $variant->bundle_to_menu    = $item['bundle_to_menu'];
                $variant->active            = $item['active'];
                $variant->mandatory         = $item['mandatory'];
                $variant->uom               = $item['uom'];
                $variant->weight            = $item['weight'];
                $variant->currency_price    = $merchant->currency;
                $variant->merchantProduct()->associate($merchantProduct);
                $variant->save();
            }

            // inventories product
            $merchantInventory = new MerchantInventory;
            $merchantInventory->merchant_id = $request->merchant_id;
            $merchantInventory->merchantProduct()->associate($merchantProduct);
            $merchantInventory->save();

            // attribute
            $brandAttributes = BrandProductAttribute::where('brand_product_id',$request->id)->get();
            foreach ($brandAttributes as $item) { 
                $attribute = new ProductAttribute;
                $attribute->name            = $item['name'];
                $attribute->sku             = strtoupper($item['sku']);
                $attribute->retail_price    = $item['retail_price'];
                $attribute->bundle_to_menu  = $item['bundle_to_menu'];
                $attribute->active          = $item['active'];
                $attribute->mandatory       = $item['mandatory'];
                $attribute->uom             = $item['uom'];
                $attribute->weight          = $item['weight'];
                $attribute->currency        = $merchant->currency;
                $attribute->merchantProduct()->associate($merchantProduct);
                $attribute->save();
            }
            
            // many to many relation extra attribute
            // get data from brand_extra_attribute_list with where brand_product_id
            $dataBrandExtraAttribut = BrandExtraAttributeList::where('brand_product_id',$request->id)
                ->pluck('brand_extra_attribute_id')->toArray();
            $merchantProduct->brandExtraAttributes()->attach($dataBrandExtraAttribut,
            ['create_time' => Carbon::now()]);
                
        }
        return view('arvi.page-not-available');
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
    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $id = $request->id;
            $merchant_id = $request->merchant_id;
            $brand_id                = Merchant::find($merchant_id)->brand_id;
            $merchantCategories      = ProductCategory::where('merchant_id',$merchant_id)->get();
            $brandCategories         = BrandCategory::where('brand_id',$brand_id)->get();
            $merchantExtraAttributes = MerchantExtraAttribute::where('merchant_id',$merchant_id)->get();
            $brandExtraAttributes    = BrandExtraAttribute::where('brand_id',$brand_id)->get();
            $merchantProduct         = MerchantProduct::find($id);
            $merchantImage           = MerchantProduct::find($id)->productImage->pluck('url');
            $merchantInventory       = MerchantInventory::where('merchant_product_id',$id)->first();
            
            // get data with relation many to many
            $dataRelationMECategories     = MerchantProduct::find($id)->productCategories->pluck('id');
            $dataRelationBECategories     = MerchantProduct::find($id)->brandCategories->pluck('id');
            $dataRelationVariants         = MerchantProduct::find($id)->merchantProductVariants;
            $dataRelationAttributes       = MerchantProduct::find($id)->productAttributes;
            $dataRelationMExtraAttributes = MerchantProduct::find($id)->merchantExtraAttributes->pluck('id');
            $dataRelationBExtraAttributes = MerchantProduct::find($id)->brandExtraAttributes->pluck('id');
            
            $uomList = UomList::all();

            return view($this->view . 'page-product-edit',
                compact('companyCode','merchantCategories','brandCategories',
                'merchant_id','brand_id','merchantInventory',
                'merchantExtraAttributes','brandExtraAttributes',
                'merchantProduct','id','dataRelationMECategories',
                'dataRelationBECategories',
                'dataRelationVariants','dataRelationAttributes',
                'dataRelationMExtraAttributes','dataRelationBExtraAttributes',
                'merchantImage','uomList'
            ));
        }
        return view('arvi.page-not-available');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            if (isset($request->statusActive)) {
                $merchantProduct = MerchantProduct::find($request->id);
                $merchantProduct->active = $request->statusActive;
                $merchantProduct->save();
            } 
            else {
                $validation = Validator::make($request->all(), [
                    'preparation_time'  => 'required',
                    'retail_price'      => 'required',
                    'min_order'         => 'required',
                ]);

                // store brand product
                $merchantProduct = MerchantProduct::find($request->id);
                $merchantProduct->retail_price        = $request->retail_price;
                $merchantProduct->discount_price      = $request->discount_price;
                $merchantProduct->preparation_time    = $request->preparation_time;
                $merchantProduct->min_order           = $request->min_order;
                $merchantProduct->max_order           = $request->max_order;
                $merchantProduct->active              = isset($request->active) ? 1 : 0 ;
                $merchantProduct->available_days      = $request->available_days;

                if (MerchantInventory::where('merchant_product_id',$request->id)->exists()) {
                    // inventories product
                    $merchantInventory = MerchantInventory::where('merchant_product_id',$request->id)->first();
                    $merchantInventory->total_available = isset($request->stock)?$request->stock:0;
                    $merchantInventory->total_allocate  = isset($request->stock)?$request->stock:0;
                    $merchantInventory->low_stock       = isset($request->lowStock)?$request->lowStock:0;
                    $merchantInventory->active          = isset($request->inventoryActive)?1:0;
                    $merchantInventory->save();
                } else {
                    // inventories product
                    $merchantInventory = new MerchantInventory;
                    $merchantInventory->merchant_id = $request->merchant_id;
                    $merchantInventory->total_available = isset($request->stock)?$request->stock:0;
                    $merchantInventory->total_allocate  = isset($request->stock)?$request->stock:0;
                    $merchantInventory->low_stock       = isset($request->lowStock)?$request->lowStock:0;
                    $merchantInventory->active          = isset($request->inventoryActive)?1:0;
                    $merchantInventory->merchantProduct()->associate($merchantProduct);
                    $merchantInventory->save();
                }

                // delete all old data
                $merchantProduct->productCategories()->detach();
                $merchantProduct->brandExtraAttributes()->detach();
                $merchantProduct->merchantExtraAttributes()->detach();
                MerchantProductVariant::where('merchant_product_id',$request->id)->delete();
                ProductAttribute::where('merchant_product_id',$request->id)->delete();
                
                // many to many category
                $brandCategories = json_decode($request->brandCategories);
                $merchantProduct->brandCategories()->attach($brandCategories,
                ['create_time' => Carbon::now()]);
                
                // many to many category
                $productCategories = json_decode($request->productCategories);
                $merchantProduct->productCategories()->attach($productCategories,
                ['create_time' => Carbon::now()]);
                
                // merchant
                $merchant = Merchant::find($merchantProduct->merchant_id);

                // variant
                $variants = json_decode($request->productVariants,true);
                if(isset($variants)){
                    foreach ($variants as $item) { 
                        $variant = new MerchantProductVariant;
                        $variant->name            = $item['name'];
                        $variant->retail_price    = $item['retail_price'];
                        $variant->currency_price  = $merchant->currency;
                        $variant->sku             = strtoupper($item['sku']);
                        $variant->uom             = $item['uom'];
                        $variant->weight          = $item['weight'];
                        $variant->bundle_to_menu  = count($item['bundle_to_menu']) > 0 ? 1 : 0 ;
                        $variant->active          = count($item['active']) > 0 ? 1 : 0 ;
                        $variant->merchantProduct()->associate($merchantProduct);
                        $variant->save();
                    }
                }
                
                // attribute
                $attributes = json_decode($request->productAttributes,true);
                if(isset($attributes)){
                    foreach ($attributes as $item) { 
                        $attribute = new ProductAttribute;
                        $attribute->name           = $item['name'];
                        $attribute->retail_price   = $item['retail_price'];
                        $attribute->currency  = $merchant->currency;
                        $attribute->sku            = strtoupper($item['sku']);
                        $attribute->uom            = $item['uom'];
                        $attribute->weight         = $item['weight'];
                        $attribute->bundle_to_menu = count($item['bundle_to_menu']) > 0 ? 1 : 0 ;
                        $attribute->active         = count($item['active']) > 0 ? 1 : 0 ;
                        $attribute->merchantProduct()->associate($merchantProduct);
                        $attribute->save();
                    }
                }
                
                // many to many relation extra attribute
                $brand_extra_attributes = json_decode($request->brand_extra_attributes);
                $merchantProduct->brandExtraAttributes()->attach($brand_extra_attributes,
                ['create_time' => Carbon::now()]);
                
                // many to many relation extra attribute
                $merchant_extra_attributes = json_decode($request->merchant_extra_attributes);
                $merchantProduct->merchantExtraAttributes()->attach($merchant_extra_attributes,
                ['create_time' => Carbon::now()]);

                $merchantProduct->save();
            }    
        }
        return view('arvi.page-not-available');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $merchantProduct = MerchantProduct::find($request->id);
        $merchantProduct->brandCategories()->detach();
        $merchantProduct->productCategories()->detach();
        $merchantProduct->brandExtraAttributes()->detach();
        $merchantProduct->merchantExtraAttributes()->detach();
        $merchantProduct->delete();

        ProductImage::where('merchant_product_id',$request->id)->delete();
        MerchantProductVariant::where('merchant_product_id',$request->id)->delete();
        ProductAttribute::where('merchant_product_id',$request->id)->delete();
        MerchantInventory::where('merchant_product_id',$request->id)->delete();
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
