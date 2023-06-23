<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\ArviBanner;

use DB;
use carbon\Carbon;

class HomeController extends Controller
{
    protected $view = 'arvi.frontend.store.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {

        // banner
        $banners = [];
        for ($i=1; $i <= 6; $i++) {
            $banners[$i] = ArviBanner::where('order',$i)
            ->where('date_start','<=',Carbon::now())
            ->where('date_end','>',Carbon::yesterday())
            ->where('active',1)
            ->latest()->first();
        }

        // merchants
        $merchants = Merchant::
        join('locations','locations.id','=','merchants.location_id')
        ->select(
            'merchants.id as id',
            'merchants.name as name',
            'merchants.code'
        )
        ->where('merchants.code',$code)->orderBy('merchants.id','ASC')->get();

        $join = MerchantProduct::
        join('merchants','merchants.id','=','merchant_products.merchant_id')
        ->join('locations','locations.id','=','merchants.location_id')
        ->leftJoin('product_images','merchant_products.id','=',
        'product_images.merchant_product_id')
        ->select(
            'merchant_products.id',
            'merchant_products.merchant_id',
            'merchant_products.name',
            'merchant_products.retail_price',
            'merchant_products.currency',
            'merchant_products.description',
            'product_images.url',
            'product_images.image_mime',
            'product_images.image_type',
            'merchants.code'
        )
        ->where('merchants.code',$code);

        // get popular product (based on ordering)
        $rankPopular = MerchantProduct::
        join('merchants','merchants.id','=','merchant_products.merchant_id')
        ->join('locations','locations.id','=','merchants.location_id')
        ->leftJoin('merchant_order_details','merchant_order_details.product_id','=',
        'merchant_products.id')
        ->where('merchants.code',$code)
        ->groupBy('merchant_products.id')
        ->select(
            'merchant_products.id',
        )
        ->addSelect(DB::raw('count(merchant_products) as total'))
        ->orderBy('total','DESC')
        ->limit(10)->pluck('id')->toArray();

        $productTabPopular = array();
        foreach ($rankPopular as $key => $value) {
            $product = MerchantProduct::leftJoin('product_images','merchant_products.id','=',
            'product_images.merchant_product_id')
            ->select(
                'merchant_products.id as id',
                'merchant_products.merchant_id',
                'merchant_products.name',
                'merchant_products.retail_price',
                'merchant_products.currency',
                'merchant_products.description',
                'product_images.url',
                'product_images.image_mime',
                'product_images.image_type'
            )->find($value);

            array_push($productTabPopular,$product);
        }

        // newer product
        $productTabNew      = $join->orderBy('merchant_products.create_time','DESC')->limit(10)->get();

        // best rating product
        $productTabRating   = $join->limit(10)->get(); //feature rating not ready

        return view($this->view . 'index',
            compact('banners','merchants','productTabPopular','productTabNew','productTabRating','code'));
    }

    public function tnc($code)
    {
        return view($this->view . 'tnc-and-pp.page-tc',compact('code'));
    }

    public function pp($code)
    {
        return view($this->view . 'tnc-and-pp.page-pp',compact('code'));
    }

    public function about($code)
    {
        return view($this->view . 'about-us.about',compact('code'));
    }

}
