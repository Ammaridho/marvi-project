<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\MerchantDelivery;
use App\Models\MerchantDeliveryMethod;
use App\Models\Company;
use App\Models\Location;
use App\Models\MerchantSocialReference;
use App\Models\ArviDelivery;
use App\Models\ArviSubDelivery;
use App\Models\MerchantProduct;
use App\Models\MerchantProductVariant;
use App\Models\MerchantInventory;
use App\Models\ProductAttribute;
use App\Models\MerchantExtraAttribute;
use App\Models\User;
use App\Models\MerchantHour;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Monarobase\CountryList\CountryListFacade;
use PragmaRX\Countries\Package\Countries;

use DateTimeZone;
use Carbon\Carbon;

class TabManageStoreController extends Controller
{

    protected $view = 'arvi.backend.manage-merchant.';  

    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {

            $user = User::where('email',$request->session()->get('email'))
                    ->first();

            if ( $user->role == 'superadmin') {
                $merchants = Merchant::join('brands','brands.id','=','merchants.brand_id')
                ->select('brands.image_url as logo','merchants.*')
                ->where('merchants.company_id',$data->id)
                ->orderBy('id','DESC')->get();
            } else {
                // get store id
                $idMerchants = json_decode(User::where('email',$request->session()->get('email'))
                    ->first()->store_id);
                if (isset($idMerchants)) {
                    $merchants = Merchant::join('brands','brands.id','=','merchants.brand_id')
                    ->select('brands.image_url as logo','merchants.*')
                    ->where('merchants.company_id',$data->id)
                    ->whereIn('merchants.id',$idMerchants)
                    ->orderBy('merchants.id','DESC')->get();
                }else{
                    $merchants = [];
                }
            }
                
            $brands = Brand::where('company_id',$data->id)
                ->orderBy('id','DESC')->get();
            return view( $this->view . 'index',
                compact('companyCode','merchants','brands'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            if ($request->brand != 'all'){
                $merchants = Merchant::where('brand_id', $request->brand)
                ->orderBy('id', 'desc')->get();
            }else{
                $merchants = Merchant::where('company_id', $data->id)
                ->orderBy('id','desc')->get();
            }
            return view($this->view . 'data-merchant-list',
                    compact('companyCode','merchants'));
        }
        return view('arvi.page-not-available');
    }

    public function create(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $companyCode = $request->companyCode;
            $brands = Brand::where('company_id',$data->id)->get();
            $locations = Location::all();
            // all countries
            $countries = Countries::all()->pluck('name.common');
            //arvi_deliveries
            $arvi_deliveries = ArviDelivery::all(); 
            // time_zone
            $timezonelist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            // currencies
            $aa = new Countries();
            $currencies = $aa->currencies();
            return view($this->view . 'page-manage-store-add',
                compact('companyCode','brands','countries','currencies',
                    'locations','arvi_deliveries','timezonelist'));
        }
        return view('arvi.page-not-available');
    }

    public function store(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $validation = Validator::make($request->all(), [
                'brand_id'      => 'required',
                'name'          => 'required',
                'phone_number'  => 'required',
                'description'   => 'required',
                'image_url'     => 'image|mimes:jpeg,png,jpg,gif',
                'address'       => 'required',
                'building_suite'=> 'required',
                'city'          => 'required',
                'state'         => 'required',
                'postal_code'   => 'required',
                'country'       => 'required',
                'currency'      => 'required',
                'storeLocation' => 'required',
                'timezone'      => 'required',
                'ga_app_credential_json' => 'mimes:json',
            ]);

            // set code brand
            $code = Str::Random(10);
            
            // store merchant
            $merchant = new Merchant;
            if ($request->file('image_url')) {
                // save image file to repo
                $image = $request->file('image_url');
                $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')
                ->putFileAs('arvi/backend-assets/img/logo/merchants', $image, $new_name_image);
                $merchant->image_url = $new_name_image;
            }

            // save credential json
            if ($request->file('ga_app_credential_json')) {
                $json = $request->file('ga_app_credential_json');
                $new_name_json = $request->name.'_'.$code.'.'.$json->getClientOriginalExtension();
                Storage::putFileAs('analytics', $json, $new_name_json);
                $merchant->ga_app_credential_json = $new_name_json;
            }
            
            if ($request->timezone != 'Select') {
                $merchant->loc_tz          = $request->timezone;
            }
            $merchant->company_id           = $data->id;
            $merchant->brand_id             = $request->brand_id;
            $merchant->name                 = $request->name;
            $merchant->phone_number         = $request->phone_number;
            $merchant->building_state       = $request->building_suite;
            $merchant->description          = $request->description;
            $merchant->code                 = 'mrc'.$code;
            $merchant->location_id          = $request->locationId;
            $merchant->address              = $request->address;
            $merchant->city                 = $request->city;
            $merchant->state                = $request->state;
            $merchant->country              = $request->country;
            $merchant->postal_code          = $request->postal_code;
            $merchant->currency             = $request->currency;
            $merchant->sent_order_to_lodi   = isset($request->sent_order_to_lodi)?1:0;
            $merchant->warehouse_id         = strtoupper($request->warehouse_id);
            $merchant->support_delivery     = isset($request->support_delivery)?1:0;
            $merchant->support_pickup       = isset($request->support_pickup)?1:0;
            $merchant->support_pickup_min_order_amount = 
                isset($request->support_pickup_min_order_amount)?1:0;
            $merchant->pickup_min_order_amount = 
                isset($request->pickup_min_order_amount)?$request->pickup_min_order_amount:0;
            // ga code
            if (isset($request->ga_code)) {
                $merchant->ga_code = strtoupper($request->ga_code);
            }
            $merchant->ga_property_id = $request->ga_property_id;
            $merchant->save();

            // many to many relation location
            $locationId = $request->locationId;
            $merchant->location()->attach($locationId,
            ['create_time' => Carbon::now()]);

            // merchant delivery
            $md = new MerchantDelivery;
            $md->range_area = $request->range_area;
            $md->support_delivery_min_order_amount = 
                isset($request->support_delivery_min_order_amount)?1:0;
            $md->delivery_min_order_amount = $request->min_order_amount;
            $md->merchant()->associate($merchant); 
            $md->save(); 

            // merchant delivery method
            if (isset($request->sub_deliveries)) {
                foreach (json_decode($request->sub_deliveries) as $sdo) {
                    $msdm = new MerchantDeliveryMethod;
                    $msdm->arvi_delivery_id = $sdo->delivery_id;
                    $msdm->arvi_sub_delivery_id = $sdo->sub_delivery_id;
                    $msdm->transporter_id = $sdo->transporter_id;
                    $msdm->merchantDelivery()->associate($md);
                    $msdm->save();
                }
            }

            // store social media
            $socialMedia = json_decode($request->socialMedia);
            if (is_array($socialMedia) || is_object($socialMedia)){
                foreach ($socialMedia as $key => $value) {
                    $merchantsocialreference       = new MerchantSocialReference;
                    $merchantsocialreference->name = $value[1];
                    $merchantsocialreference->type = $value[0];
                    $merchantsocialreference->url  = $value[0].'.com/'.$value[1];
                    $merchantsocialreference->Merchant()->associate($merchant);
                    $merchantsocialreference->save(); 
                }
            }

        }
    }

    public function edit(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $brands = Brand::where('company_id',$data->id)->get();
            $dataMerchant = Merchant::find($request->merchant_id);
            $locations = Location::all();
            $countries = Countries::all()->pluck('name.common');
            $aa = new Countries();
            $currencies = $aa->currencies();
            $dataSocialMedia = MerchantSocialReference::where('merchant_id',$request->merchant_id)
            ->get()->map->only(['type','name']);

            //arvi_deliveries
            $arvi_deliveries = ArviDelivery::all(); 
            $merchantDeliveryExist = MerchantDelivery::where('merchant_id',$request->merchant_id)
            ->first();
            // check if merchant have relation data with merchant_deliveries
            if ($merchantDeliveryExist) {
                $deliveryMethods = $merchantDeliveryExist->merchantDeliveryMethod;
                $merchantDelivery = $merchantDeliveryExist;
            }else{
                $deliveryMethods = null;
                $merchantDelivery['delivery_method'] = null;
                $merchantDelivery['support_delivery_min_order_amount'] = null;
            }
            // time_zone
            $timezonelist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            return view($this->view . 'page-manage-store-update',
                compact('companyCode','countries','dataMerchant','dataSocialMedia',
                'brands','currencies','locations','arvi_deliveries','timezonelist',
                'merchantDelivery','deliveryMethods'));
        }
        return view('arvi.page-not-available');
    }

    public function update(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            if (isset($request->active)) {
                $merchant = Merchant::find($request->id);
                $merchant->active = $request->active;
                $merchant->save();
            } else {
                $validation = Validator::make($request->all(), [
                    'merchant_id'   => 'required',
                    'brand_id'      => 'required',
                    'name'          => 'required',
                    'phone_number'  => 'required',
                    'description'   => 'required',
                    'image_url'     => 'image|mimes:jpeg,png,jpg,gif',
                    'address'       => 'required',
                    'building_suite'=> 'required',
                    'city'          => 'required',
                    'state'         => 'required',
                    'postal_code'   => 'required',
                    'country'       => 'required',
                    'currency'      => 'required',
                    'storeLocation' => 'required',
                    'timezone'      => 'required',
                    'ga_app_credential_json' => 'mimes:json',
                ]);
                
                $merchant_id = $request->merchant_id;
                // update merchant
                $merchant = Merchant::find($merchant_id);

                if ($request->file('image_url')) {
                    // delete foto
                    $image = public_path("arvi/backend-assets/img/logo/merchants".
                    $merchant->image_url);
                    \File::delete($image);
                    // save image file to repo
                    $image = $request->file('image_url');
                    $new_name_image = $request->name.'_'.$merchant->code.'.'.
                    $image->getClientOriginalExtension();
                    Storage::disk('public')->delete('arvi/backend-assets/img/logo/merchants/'.$merchant->image_url);
                    Storage::disk('public')->putFileAs('arvi/backend-assets/img/logo/merchants', $image, $new_name_image);
                    $merchant->image_url = $new_name_image;
                }

                if ($request->file('ga_app_credential_json')) {
                    // delete foto
                    $json = public_path("arvi/backend-assets/img/logo/merchants". $merchant->ga_app_credential_json);
                    \File::delete($json);
                    // save json file to repo
                    $json = $request->file('ga_app_credential_json');
                    $new_name_json = $request->name.'_'.$merchant->code.'.'.$json->getClientOriginalExtension();
                    Storage::delete('analytics/'.$merchant->ga_app_credential_json);
                    Storage::putFileAs('analytics', $json, $new_name_json);
                    $merchant->ga_app_credential_json = $new_name_json;
                }

                if (isset($request->timezone)) {
                    $merchant->loc_tz          = $request->timezone;
                }
                $merchant->brand_id        = $request->brand_id;
                $merchant->name            = $request->name;
                $merchant->phone_number    = $request->phone_number;
                $merchant->building_state  = $request->building_suite;
                $merchant->description     = $request->description;
                $merchant->address         = $request->address;
                $merchant->city            = $request->city;
                $merchant->state           = $request->state;
                $merchant->country         = $request->country;
                $merchant->location_id     = $request->locationId;
                $merchant->postal_code     = $request->postal_code;
                if (isset($request->currency)) {
                    $merchant->currency    = $request->currency;
                }

                // merchant product
                MerchantProduct::where('merchant_id',$merchant_id)
                ->update(['currency' => $merchant->currency]);

                // merchant product variant
                MerchantProductVariant::join('merchant_products',
                'merchant_product_variants.merchant_product_id','=',
                'merchant_products.id')
                ->where('merchant_products.merchant_id',$merchant_id)
                ->update(['merchant_product_variants.currency_price' => $merchant->currency]);

                // merchant product attribute
                ProductAttribute::join('merchant_products',
                'product_attributes.merchant_product_id','=',
                'merchant_products.id')
                ->where('merchant_products.merchant_id',$merchant_id)
                ->update(['product_attributes.currency' => $merchant->currency]);

                // merchant extra attribute
                MerchantExtraAttribute::where('merchant_id',$merchant_id)
                ->update(['currency' => $merchant->currency]);

                $merchant->sent_order_to_lodi   = isset($request->sent_order_to_lodi)?1:0;
                $merchant->warehouse_id         = strtoupper($request->warehouse_id);
                $merchant->support_delivery = isset($request->support_delivery)?1:0;
                $merchant->support_pickup   = isset($request->support_pickup)?1:0;
                $merchant->support_pickup_min_order_amount = 
                    isset($request->support_pickup_min_order_amount)?1:0;
                $merchant->pickup_min_order_amount     = 
                    isset($request->pickup_min_order_amount)?
                    $request->pickup_min_order_amount:0;
                // ga code
                if (isset($request->ga_code)) {
                    $merchant->ga_code = strtoupper($request->ga_code);
                }
                $merchant->ga_property_id = $request->ga_property_id;
                $merchant->save();

                // many to many relation location update
                $merchant->location()->detach(); 
                $merchant->location()->attach($request->locationId,
                ['create_time' => Carbon::now()]);

                // merchant delivery
                if (MerchantDelivery::where('merchant_id',$merchant_id)->first() != null) {
                    $md = MerchantDelivery::where('merchant_id',$merchant_id)->first();
                }else{
                    $md = new MerchantDelivery;
                }
                $md->range_area = $request->range_area;
                $md->support_delivery_min_order_amount = 
                    isset($request->support_delivery_min_order_amount)?1:0;
                $md->delivery_min_order_amount = $request->min_order_amount;
                $md->merchant()->associate($merchant); 
                $md->save(); 

                if (MerchantDeliveryMethod::where('merchant_delivery_id',$md->id)->first() != null) {
                    MerchantDeliveryMethod::where('merchant_delivery_id',$md->id)->delete();
                }

                // merchant delivery method
                if (isset($request->sub_deliveries)) {
                    foreach (json_decode($request->sub_deliveries) as $sdo) {
                        $msdm = new MerchantDeliveryMethod;
                        $msdm->arvi_delivery_id = $sdo->delivery_id;
                        $msdm->arvi_sub_delivery_id = $sdo->sub_delivery_id;
                        $msdm->transporter_id = $sdo->transporter_id;
                        $msdm->merchantDelivery()->associate($md);
                        $msdm->save();
                    }
                }
                
                // edit social media
                MerchantSocialReference::where('merchant_id',$request->merchant_id)->delete();
                $socialMedia = json_decode($request->socialMedia);
                if (is_array($socialMedia) || is_object($socialMedia)){
                    foreach ($socialMedia as $key => $value) {
                        $merchantsocialreference       = new MerchantSocialReference;
                        $merchantsocialreference->name = $value[1];
                        $merchantsocialreference->type = $value[0];
                        $merchantsocialreference->url  = $value[0].'.com/'.$value[1];
                        $merchantsocialreference->Merchant()->associate($merchant);
                        $merchantsocialreference->save(); 
                    }
                }
            }
        }
    }

    public function destroy($companyCode,$merchantId)
    {
        // delete hour
        MerchantHour::where('merchant_id',$merchantId)->delete();
        // delete store categories
        ProductCategory::where('merchant_id',$merchantId)->delete();
        // delete store products
        $productIds = MerchantProduct::where('merchant_id',$merchantId)->pluck('id');
        foreach ($productIds as $key => $productId) {
            $merchantProduct = MerchantProduct::find($productId);
            $merchantProduct->brandCategories()->detach();
            $merchantProduct->productCategories()->detach();
            $merchantProduct->brandExtraAttributes()->detach();
            $merchantProduct->merchantExtraAttributes()->detach();
            $merchantProduct->delete();
            ProductImage::where('merchant_product_id',$productId)->delete();
            MerchantProductVariant::where('merchant_product_id',$productId)->delete();
            ProductAttribute::where('merchant_product_id',$productId)->delete();
            MerchantInventory::where('merchant_product_id',$productId)->delete();
        }
        // delete extra attribute
        MerchantExtraAttribute::where('merchant_id',$merchantId)->delete();
        // store
        $merchant = Merchant::find($merchantId);
        // delete foto
        if (isset($merchant->image_url)) {
            Storage::disk('public')->delete('arvi/backend-assets/img/logo/merchants/'.$merchant->image_url);
            $gambar = public_path("arvi/backend-assets/img/logo/merchants/".$merchant->image_url);
            \File::delete($gambar);
        }
        // delete social media
        MerchantDelivery::where('merchant_id',$merchantId)->delete();
        MerchantSocialReference::where('merchant_id',$merchantId)->delete();
        $merchant->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
