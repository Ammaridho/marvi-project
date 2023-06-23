<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageBrand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Merchant;
use App\Models\User;
use App\Models\Brand;
use App\Models\BrandExtraAttribute;
use App\Models\BrandCategory;
use App\Models\Fee;
use App\Models\BrandSocialReference;
use App\Models\BrandProduct;
use App\Models\BrandProductVariant;
use App\Models\BrandProductAttribute;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Monarobase\CountryList\CountryListFacade;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\Auth;
use Session;
use DateTimeZone;
use Carbon\Carbon;

class TabManageBrandController extends Controller
{

    protected $view = 'arvi.backend.manage-brand.';  

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

            $user = User::where('email',$request->session()->get('email'))
                    ->first();

            if ( $user->role == 'superadmin') {

                $brands = Brand::where('company_id',$data->id)
                ->orderBy('id','DESC')->get();

            } else {

                // get store id
                $idBrands = User::where('email',$request->session()->get('email'))
                ->first()->brands->pluck('id')->toArray();

                $brands = Brand::where('company_id',$data->id)->whereIn('id',$idBrands)->get();

            }
            
            return view( $this->view . 'index',
                compact('companyCode','brands'));
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
            $countries = CountryListFacade::getList('en');
            $fees = Fee::where('company_id',$data->id)->get();
            $aa = new Countries();
            $currencies = $aa->currencies();
            $timezonelist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            return view($this->view . 'page-manage-brand-new',
                compact('companyCode','countries','currencies','fees',
                    'timezonelist'));
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
            $validator = $request->validate([
                'name'         => 'required|unique:App\Models\Brand,name',
                'country'      => 'required',
                'description'  => 'required',
                'currency'     => 'required',
                'image_url'    => 'image|mimes:jpeg,png,jpg,gif',
                'client_id'    => 'unique:App\Models\Brand,client_id',
            ]);

            // set code brand
            $code = Str::Random(10);
            
            // store brand
            $brand = new Brand;
            if ($request->file('image_url')) {
            // save image file to repo
            $image = $request->file('image_url');
            $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('arvi/backend-assets/img/logo/brands', $image, $new_name_image);
            $brand->image_url       = $new_name_image;
            }
            $brand->name            = $request->name;
            $brand->client_id       = strtoupper($request->client_id);
            $brand->description     = $request->description;
            $brand->code            = 'br'.$code;
            $brand->country         = $request->country;
            $brand->company_id      = $data->id;
            if ($request->currency != 'Select') {
                $brand->currency        = $request->currency;
            }
            $brand->save();

            // many to many relation fee
            $brandFeeIds = json_decode($request->brandFeeIds);
            $brand->fees()->attach($brandFeeIds,
            ['create_time' => Carbon::now()]);

            // store social media
            $socialMedia = json_decode($request->socialMedia);
            if (is_array($socialMedia) || is_object($socialMedia)){
                foreach ($socialMedia as $key => $value) {
                    $brandsocialreference       = new BrandSocialReference;
                    $brandsocialreference->name = $value[1];
                    $brandsocialreference->type = $value[0];
                    $brandsocialreference->url  = $value[0].'.com/'.$value[1];
                    $brandsocialreference->Brand()->associate($brand);
                    $brandsocialreference->save(); 
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
    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $dataBrand = Brand::find($request->id);
            $countries = CountryListFacade::getList('en');
            $dataSocialMedia = BrandSocialReference::where('brand_id',$request->id)->get()
            ->map->only(['type','name']);
            $fees = Fee::where('company_id',$data->id)->get();
            // data old fees
            $dataRelationFees = $dataBrand->fees->pluck('id');
            $aa = new Countries();
            $currencies = $aa->currencies();
            $timezonelist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

            return view($this->view . 'page-manage-brand-update',
                compact('companyCode','countries','dataBrand','currencies',
                    'dataSocialMedia','fees','dataRelationFees',
                        'timezonelist'));
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
            if (isset($request->active)) {
                $brand = Brand::find($request->id);
                $brand->active = $request->active;
                $brand->save();
                $merchants = Merchant::where('brand_id',$request->id)
                    ->where('active',1)->update(array('active' => 0));

            } else {
                $validator = $request->validate([
                    'name'         => 'required|unique:brands,name,'.$request->id,
                    'country'      => 'required',
                    'description'  => 'required',
                    'currency'     => 'required',
                    'image_url'    => 'image|mimes:jpeg,png,jpg,gif',
                    'client_id'    => 'unique:brands,client_id,'.$request->id,
                ]);

                // set code brand
                $code = Str::Random(10);

                // store brand
                $brand = Brand::find($request->id);
                $brand->name            = $request->name;
                $brand->client_id       = strtoupper($request->client_id);
                $brand->description     = $request->description;
                $brand->country         = $request->country;
                if ($request->file('image_url')) {
                    // delete foto
                    $gambar = public_path("arvi/backend-assets/img/logo/brands/".$brand->image_url);
                    \File::delete($gambar);
                    // upload foto
                    $image = $request->file('image_url');
                    $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
                    Storage::disk('public')->delete('arvi/backend-assets/img/logo/brands/'.$brand->image_url);
                    Storage::disk('public')->putFileAs('arvi/backend-assets/img/logo/brands', $image, $new_name_image);
                    $brand->image_url  = $new_name_image;
                }
                if ($request->currency != 'Select') {
                    $brand->currency        = $request->currency;

                    // update currency at all data
                    // brand product
                    BrandProduct::where('brand_id',$request->id)
                        ->update(['currency' => $request->currency]);

                    // brand product variant
                    BrandProductVariant::join('brand_products',
                    'brand_product_variants.brand_product_id','=',
                    'brand_products.id')
                    ->where('brand_products.brand_id',$request->id)
                        ->update(['brand_product_variants.currency' => $request->currency]);

                    // brand product attribute
                    BrandProductAttribute::join('brand_products',
                    'brand_product_attributes.brand_product_id','=',
                    'brand_products.id')
                    ->where('brand_products.brand_id',$request->id)
                        ->update(['brand_product_attributes.currency' => $request->currency]);

                    // brand extra attribute
                    BrandExtraAttribute::where('brand_id',$request->id)
                        ->update(['currency' => $request->currency]);

                }
                if ($request->timezone != 'Select') {
                $brand->loc_tz          = $request->timezone;
                }
                $brand->save();

                $brand = Brand::find($request->id);
                $brand->fees()->detach();

                // many to many relation fee
                $brandFeeIds = json_decode($request->brandFeeIds);
                $brand->fees()->attach($brandFeeIds,
                ['create_time' => Carbon::now()]);
                
                // edit social media
                BrandSocialReference::where('brand_id',$request->id)->delete();
                $socialMedia = json_decode($request->socialMedia);
                if (is_array($socialMedia) || is_object($socialMedia)){
                    foreach ($socialMedia as $key => $value) {
                        $brandsocialreference       = new BrandSocialReference;
                        $brandsocialreference->name = $value[1];
                        $brandsocialreference->type = $value[0];
                        $brandsocialreference->url  = $value[0].'.com/'.$value[1];
                        $brandsocialreference->Brand()->associate($brand);
                        $brandsocialreference->save(); 
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $companyCode, $brandId)
    {
        // check parameter data, if 0, use $request (ajax data)
        if ($brandId == 0) {
            $brandId = $request->brandId;
        }

        // brand categories
        $brandCategories = BrandCategory::where('brand_id',$brandId)->delete();

        // brand products
        $brandProductIds = BrandProduct::where('brand_id',$brandId)->pluck('id');
        foreach ($brandProductIds as $key => $brandProductId) {
            $brandProduct = BrandProduct::find($brandProductId);
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

            BrandImage::where('brand_product_id',$brandProductId)->delete();
            BrandProductVariant::where('brand_product_id',$brandProductId)->delete();
            BrandProductAttribute::where('brand_product_id',$brandProductId)->delete();
        }

        // brand extra attributes
        $brandExtraAttributes = BrandExtraAttribute::where('brand_id',$brandId)->delete();

        // brand 
        $brand = Brand::find($brandId);
        $brand->fees()->detach();
        // delete foto
        Storage::disk('public')->delete('arvi/backend-assets/img/logo/brands/'.$brand->image_url);
        $gambar = public_path("arvi/backend-assets/img/logo/brands/".$brand->image_url);
        \File::delete($gambar);
        // delete social media
        BrandSocialReference::where('brand_id',$brandId)->delete();
        // Stores
        $merchantIds = Merchant::where('brand_id',$brandId)->pluck('id');
        foreach ($merchantIds as $key => $merchantId) {
            // Delete Store
            $merchant = app('App\Http\Controllers\Arvi\Dashboard\TabManageStore\TabManageStoreController')
            ->destroy($companyCode,$merchantId);
        }
        $brand->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
