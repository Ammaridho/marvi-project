<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageBrand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\BrandProduct;
use App\Models\BrandCategory;
use App\Models\BrandImage;
use App\Models\Brand;
use App\Models\BrandProductVariant;
use App\Models\BrandProductAttribute;
use App\Models\BrandExtraAttribute;
use App\Models\UomList;

use App\Models\MerchantProduct;
use App\Models\ProductImage;
use App\Models\MerchantProductVariant;
use App\Models\ProductAttribute;
use App\Models\MerchantInventory;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Validator;

use Carbon\Carbon;

class BrandProductController extends Controller
{
    protected $view = 'arvi.backend.manage-brand.brand-product.'; 

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
            $brand_id = $request->id;
            //for search
            if (isset($request->action)) {
                $brandCategories = BrandCategory::where('brand_id',$brand_id)->get();
                if($request->filter == 'all'){
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->orderBy('brand_products.id', 'ASC')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->get();
                }else if($request->filter == 1 || $request->filter == 0){
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->orderBy('brand_products.id', 'ASC')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->where('brand_products.active',$request->filter)
                    ->get();
                }else{
                    $filter = $request->filter;
                    $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                    '=','brand_images.brand_product_id')
                    ->orderBy('brand_products.id', 'ASC')
                    ->select('*','brand_products.active as active','brand_products.id as id')
                    ->where('brand_products.name', 'ILIKE', "%$request->keySearch%")
                    ->where('brand_products.brand_id',$brand_id)
                    ->whereHas('brand_categories', function($q) use($filter) {
                        $q->where('name', $filter);
                    })
                    ->get();
                }
                return view($this->view . 'page-product-list-child',
                    compact('companyCode','brandProducts','brandCategories','brand_id'));
            } 
            else {
                // index
                $brandName = Brand::find($brand_id)->name;
                $brandCategories = BrandCategory::where('brand_id',$brand_id)->get();
                $brandProducts = BrandProduct::leftJoin('brand_images','brand_products.id',
                '=','brand_images.brand_product_id')
                ->select('*','brand_products.active as active','brand_products.id as id')
                ->orderBy('brand_products.id', 'ASC')
                ->where('brand_products.brand_id',$brand_id)
                ->get();
                return view($this->view . 'page-product-list-parent',
                    compact('companyCode','brandProducts','brandCategories',
                        'brand_id','brandName'));
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
            if ($request->first_product) {
                $company_id = $data->id;
                $brand_id = Brand::where('company_id',$company_id)->first()->id;
            } else {
                $brand_id = $request->brand_id;
            }
            $brandCategories = BrandCategory::where('brand_id',$brand_id)->get();
            $extraAttributes = BrandExtraAttribute::where('brand_id',$brand_id)->get();
            $uomList = UomList::all();
            return view($this->view . 'page-product-insert',
                compact('companyCode','brandCategories','brand_id','extraAttributes','uomList'));
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
            
            // set code brand product
            $code = Str::Random(10);

            // save image file to repo
            if (isset($request->image_url)) {
                $image = $request->file('image_url');
                $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('arvi/backend-assets/img/products/brands', $image, $new_name_image);
            }

            // store brand product
            $brandProduct = new BrandProduct;
            $brandProduct->brand_id            = $request->brand_id;
            $brandProduct->currency            = Brand::find($request->brand_id)->currency;
            $brandProduct->product_id          = $code;
            $brandProduct->name                = $request->name;
            $brandProduct->description         = $request->description;
            $brandProduct->sku                 = strtoupper($request->sku);
            $brandProduct->preparation_time    = $request->preparation_time;
            $brandProduct->retail_price        = $request->retail_price;
            $brandProduct->min_order           = $request->min_order;
            $brandProduct->max_order           = $request->max_order;
            $brandProduct->discount_price      = $request->discount_price;
            $brandProduct->available_days      = $request->available_days;
            $brandProduct->uom                 = $request->uom;
            $brandProduct->weight              = $request->weight;
            $brandProduct->active              = isset($request->active) ? 1 : 0 ;
            $brandProduct->save();

            if (isset($request->image_url)) {
                // stor brand image
                $brandImage = new BrandImage;
                $brandImage->brand_id            = $request->brand_id;
                $brandImage->image_type          = $image->getClientOriginalExtension();
                $brandImage->url                 = $new_name_image;
                $brandImage->active              = isset($request->active) ? 1 : 0 ;
                $brandImage->BrandProduct()->associate($brandProduct);
                $brandImage->save();
            }

            // many to many category
            $productCategories = json_decode($request->productCategories);
            $brandProduct->brandCategories()->attach($productCategories,
            ['create_time' => Carbon::now()]);

            // variant
            $variants = json_decode($request->productVariants,true);
            foreach ($variants as $item) { 
                $variant = new BrandProductVariant;
                $variant->name              = $item['nameVariant'];
                $variant->sku               = strtoupper($item['skuVariant']);
                $variant->retail_price      = $item['priceVariant'];
                $variant->uom               = $item['uomVariant'];
                $variant->weight            = $item['weightVariant'];
                $variant->bundle_to_menu    = count($item['bundleVariant']) > 0 ? 1 : 0 ;
                $variant->active            = count($item['activeVariant']) > 0 ? 1 : 0 ;
                $variant->mandatory         = count($item['mandatoryVariant']) > 0 ? 1 : 0 ;
                $variant->BrandProduct()->associate($brandProduct);
                $variant->save();
            }

            // attribute
            $attributes = json_decode($request->productAttributes,true);
            foreach ($attributes as $item) { 
                $attribute = new BrandProductAttribute;
                $attribute->name              = $item['nameAttribute'];
                $attribute->sku               = strtoupper($item['skuAttribute']);
                $attribute->retail_price      = $item['priceAttribute'];
                $attribute->uom               = $item['uomAttribute'];
                $attribute->weight            = $item['weightAttribute'];
                $attribute->bundle_to_menu    = count($item['bundleAttribute']) > 0 ? 1 : 0 ;
                $attribute->active            = count($item['activeAttribute']) > 0 ? 1 : 0 ;
                $attribute->mandatory         = count($item['mandatoryAttribute']) > 0 ? 1 : 0 ;
                $attribute->BrandProduct()->associate($brandProduct);
                $attribute->save();
            }
            
            // many to many relation extra attribute
            $extra_attributes = json_decode($request->extra_attributes);
            $brandProduct->brandExtraAttributes()->attach($extra_attributes,
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
            $brand_id = $request->brand_id;
            $brandCategories = BrandCategory::where('brand_id',$brand_id)->get();
            $extraAttributes = BrandExtraAttribute::where('brand_id',$brand_id)->get();
            $brandProduct = BrandProduct::find($id);
            $brandImage = BrandProduct::find($id)->brandImage->pluck('url');

            // get data with relation many to many
            $dataRelationCategories      = BrandProduct::find($id)->brandCategories->pluck('id');
            $dataRelationVariants        = BrandProduct::find($id)->brandProductVariants;
            $dataRelationAttributes      = BrandProduct::find($id)->brandProductAttributes;
            $dataRelationExtraAttributes = BrandProduct::find($id)->brandExtraAttributes->pluck('id');

            $uomList = UomList::all();

            return view($this->view . 'page-product-edit',
                compact('companyCode','brandCategories','brand_id','extraAttributes',
                'brandProduct','id','dataRelationCategories',
                'dataRelationVariants','dataRelationAttributes',
                'dataRelationExtraAttributes','brandImage','uomList'
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
                $brandProduct = BrandProduct::find($request->id);
                $brandProduct->active = $request->statusActive;
                $brandProduct->save();
            } 
            else {
                $validation = Validator::make($request->all(), [
                    'name'              => 'required',
                    'sku'               => 'required',
                    'preparation_time'  => 'required',
                    'retail_price'      => 'required',
                    'min_order'         => 'required',
                ]);
                              
                // set code brand product
                $code = Str::Random(10);

                // store brand product
                $brandProduct = BrandProduct::find($request->id);
                $brandProduct->brand_id            = $request->brand_id;
                $brandProduct->product_id          = $code;
                $brandProduct->name                = $request->name;
                $brandProduct->description         = $request->description;
                $brandProduct->sku                 = strtoupper($request->sku);
                $brandProduct->preparation_time    = $request->preparation_time;
                $brandProduct->retail_price        = $request->retail_price;
                $brandProduct->min_order           = $request->min_order;
                $brandProduct->max_order           = $request->max_order;
                $brandProduct->discount_price      = $request->discount_price;
                $brandProduct->available_days      = $request->available_days;
                $brandProduct->uom                 = $request->uom;
                $brandProduct->weight              = $request->weight;
                $brandProduct->active              = isset($request->active) ? 1 : 0 ;

                // update data merchant product
                $merchantProduct = MerchantProduct::where('brand_product_id',$request->id)
                ->update([
                    'name' => $request->name,
                    'sku'  => strtoupper($request->sku),
                    'description' => $request->description
                ]);

                if (isset($request->image_url)) {
                    // delete foto
                    $gambar = public_path("arvi/backend-assets/img/products/brands/".$brandProduct->brandImage->pluck('url'));
                    \File::delete($gambar);
                    // upload foto
                    $image = $request->file('image_url');
                    $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();

                    if ($brandProduct->brandImage->first()) {
                        Storage::disk('public')->delete('arvi/backend-assets/img/products/brands/'.$brandProduct->brandImage->first()->url);
                    }
                    Storage::disk('public')->putFileAs('arvi/backend-assets/img/products/brands', $image, $new_name_image);
                    
                    // stor brand image
                    $cekBrandImage = BrandImage::where('brand_product_id',$request->id)->first();
                    if (isset($cekBrandImage)) {
                        $brandImage = $cekBrandImage;
                    } else{
                        $brandImage = new BrandImage;
                        $brandImage->brand_id = $request->brand_id;
                        $brandImage->BrandProduct()->associate($brandProduct);
                    }
                    $brandImage->image_type  = $image->getClientOriginalExtension();
                    $brandImage->url         = $new_name_image;
                    $brandImage->active      = isset($request->active) ? 1 : 0 ;
                    $brandImage->save();

                    // update merchant product image
                    $merchantImage = ProductImage::join('merchant_products','product_images.merchant_product_id','=','merchant_products.id')
                    ->where('merchant_products.brand_product_id',$request->id)
                    ->select(
                        'product_images.url',
                        'product_images.image_type',
                    )->update([
                        'url' => $new_name_image,
                        'image_type' => $image->getClientOriginalExtension()
                    ]);
                }
                $brandProduct->save();
         
                $brandProduct = BrandProduct::find($request->id);
                $brandProduct->brandCategories()->detach();
                $brandProduct->brandExtraAttributes()->detach();
                BrandProductVariant::where('brand_product_id',$request->id)->delete();
                BrandProductAttribute::where('brand_product_id',$request->id)->delete();

                // many to many category
                $productCategories = json_decode($request->productCategories);
                $brandProduct->brandCategories()->attach($productCategories,
                ['create_time' => Carbon::now()]);
                
                // set update brand category to all merchant products
                $products = MerchantProduct::where('brand_product_id',$request->id)->get();
                foreach ($products as $key => $product) {
                    $product->brandCategories()->detach();
                    $product->brandCategories()->attach($productCategories,
                    ['create_time' => Carbon::now()]);
                }

                // variant
                $variants = json_decode($request->productVariants,true);
                if(isset($variants)){
                    foreach ($variants as $item) { 
                        $variant = new BrandProductVariant;
                        $variant->name            = $item['name'];
                        $variant->sku             = strtoupper($item['sku']);
                        $variant->retail_price    = $item['retail_price'];
                        $variant->uom             = $item['uom'];
                        $variant->weight          = $item['weight'];
                        $variant->bundle_to_menu  = count($item['bundle_to_menu']) > 0 ? 1 : 0 ;
                        $variant->active          = count($item['active']) > 0 ? 1 : 0 ;
                        $variant->mandatory       = count($item['mandatory']) > 0 ? 1 : 0 ;
                        $variant->BrandProduct()->associate($brandProduct);
                        $variant->save();
                    }
                }
                    
                // attribute
                $attributes = json_decode($request->productAttributes,true);
                if(isset($attributes)){
                    foreach ($attributes as $item) { 
                        $attribute = new BrandProductAttribute;
                        $attribute->name           = $item['name'];
                        $attribute->sku            = strtoupper($item['sku']);
                        $attribute->retail_price   = $item['retail_price'];
                        $attribute->uom            = $item['uom'];
                        $attribute->weight         = $item['weight'];
                        $attribute->bundle_to_menu = count($item['bundle_to_menu']) > 0 ? 1 : 0 ;
                        $attribute->active         = count($item['active']) > 0 ? 1 : 0 ;
                        $attribute->mandatory      = count($item['mandatory']) > 0 ? 1 : 0 ;
                        $attribute->BrandProduct()->associate($brandProduct);
                        $attribute->save();
                    }
                }
                
                // many to many relation extra attribute
                $extra_attributes = json_decode($request->extra_attributes);
                $brandProduct->brandExtraAttributes()->attach($extra_attributes,
                ['create_time' => Carbon::now()]);
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
        $brandProduct = BrandProduct::find($request->id);
        $brandProduct->brandCategories()->detach();
        $brandProduct->brandExtraAttributes()->detach();        
        // delete foto
        if ($brandProduct->brandImage->first()) {
            $gambar = public_path("arvi/backend-assets/img/products/brands/".
            $brandProduct->brandImage->first()->url);
            \File::delete($gambar);
        }
        $brandProduct->delete();
        Storage::disk('public')->delete('arvi/backend-assets/img/products/brands/'.$brandProduct->brandImage->first()->url);

        BrandImage::where('brand_product_id',$request->id)->delete();
        BrandProductVariant::where('brand_product_id',$request->id)->delete();
        BrandProductAttribute::where('brand_product_id',$request->id)->delete();

        $merchantProductId = MerchantProduct::where('brand_product_id',$request->id)->pluck('id');

        foreach ($merchantProductId as $key => $value) {
            $mp = MerchantProduct::find($value);
            $mp->brandCategories()->detach();
            $mp->productCategories()->detach();
            $mp->brandExtraAttributes()->detach();
            $mp->merchantExtraAttributes()->detach();
            $mp->delete();
    
            ProductImage::where('merchant_product_id',$mp->id)->delete();
            MerchantProductVariant::where('merchant_product_id',$mp->id)->delete();
            ProductAttribute::where('merchant_product_id',$mp->id)->delete();
            MerchantInventory::where('merchant_product_id',$mp->id)->delete();
        }
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
