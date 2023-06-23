<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabMarketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use App\Models\ArviQr;
use App\Models\Merchant;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Response;

class QrController extends Controller
{
    protected $view = 'arvi.backend.marketing.qr.';

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qrs = ArviQr::orderBy('create_time','desc')->get();
        return view($this->view.'page-qr-parent',compact('qrs'));
    }

    public function showData(Request $request)
    {
        $search = $request->search;
        $active = $request->active;
        if ($active == 'Filter') {
            $qrs = ArviQr::where('name', 'like', "%{$search}%")
            ->orderBy('id', 'desc')->get();
        } else {
            $qrs = ArviQr::where('name', 'like', "%{$search}%")
                ->where('active',$active)
                ->orderBy('id', 'desc')->get();
        }
        return view($this->view.'page-qr-child',compact('qrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchantIds = Merchant::
        join('brands','brands.id','=','merchants.brand_id')
        ->join('companies','companies.id','=','merchants.company_id')
        ->select('merchants.id','merchants.name')->get();
        return view($this->view.'page-insert-qr',compact('merchantIds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = $request->validate([
            'name'          => 'required',
            'store'         => 'required|numeric',
            'type'          => 'required|numeric',
        ]);

        // store
        $arviQr              = new ArviQr;
        $arviQr->name        = $request->name;
        $arviQr->merchant_id = $request->store;
        $arviQr->qr_type     = $request->type;
        if ($request->type == 0) {
            $storeCode = Merchant::find($arviQr->merchant_id)->code;
            $arviQr->qr_url      = env('APP_URL').'/store/'.$storeCode;
        } else {
            $arviQr->qr_url      = $request->url;
        }

        $arviQr->save();
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
        $qr = ArviQr::find($request->id);
        $merchantIds = Merchant::select('id','name')->get();
        return view($this->view.'page-update-qr',
            compact('qr','merchantIds'));
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
        if (isset($request->active)) {
            $arviQr = ArviQr::find($request->id);
            $arviQr->active = $request->active;
            $arviQr->save();
        }else{
            $validation = $request->validate([
                'name'          => 'required',
                'store'         => 'required|numeric',
                'type'          => 'required|numeric',
            ]);
            // store
            $arviQr  = ArviQr::find($request->id);
            $arviQr->name        = $request->name;
            $arviQr->merchant_id = $request->store;
            $arviQr->qr_type     = $request->type;
            if ($request->type == 0) {
                $storeCode = Merchant::find($arviQr->merchant_id)->code;
                $arviQr->qr_url      = env('APP_URL').'/store/'.$storeCode;
            } else {
                $arviQr->qr_url      = $request->url;
            }
            $arviQr->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $arviQr = ArviQr::find($request->id);
        Storage::disk('public')
        ->delete('/arvi/backend-assets/img/qr-posters/logos/'.
        $arviQr->image_logo_poster);
        Storage::disk('public')
        ->delete('/arvi/backend-assets/img/qr-posters/backgrounds/'.
        $arviQr->image_background_poster);
        Storage::disk('public')
        ->delete('/arvi/backend-assets/img/qr-posters/posters/'.
        $arviQr->image_poster);
        $arviQr->delete();
    }

    public function formCustomQr(Request $request)
    {
        $qr = ArviQR::find($request->id);
        return view($this->view.'page-admin-qr-layout',
            compact('qr'));
    }

    public function updateLayoutQr(Request $request)
    {
        $qr = ArviQR::find($request->id);

        // set code brand product
        $code = Str::Random(10);

        // save image file to repo
        if (isset($request->image_logo_poster)) {
            Storage::disk('public')
            ->delete('/arvi/backend-assets/img/qr-posters/logos/'.
                $qr->image_logo_poster);
            $image = $request
            ->file('image_logo_poster');
            $new_name_image = $request->title_poster.'_'.$code.'.'.
                $image->getClientOriginalExtension();
            Storage::disk('public')
            ->putFileAs('/arvi/backend-assets/img/qr-posters/logos',
                 $image, $new_name_image);
            $qr->image_logo_poster = $new_name_image;
        }

        // save image file to repo
        if (isset($request->image_background_poster)) {
            Storage::disk('public')
            ->delete('/arvi/backend-assets/img/qr-posters/backgrounds/'.
                $qr->image_background_poster);
            $image = $request->file('image_background_poster');
            $new_name_image = $request->title_poster.'_'.$code.'.'.
                $image->getClientOriginalExtension();
            Storage::disk('public')
            ->putFileAs('/arvi/backend-assets/img/qr-posters/backgrounds',
                 $image, $new_name_image);
            $qr->image_background_poster = $new_name_image;
        }

        // create import poster to storage
        Storage::disk('public')
        ->delete('/arvi/backend-assets/img/qr-posters/posters/'.
            $qr->image_poster);
        $image = $request->file('image_poster');
        $new_name_image = $request->title_poster.'_'.$code.'.png';
        Storage::disk('public')
        ->putFileAs('/arvi/backend-assets/img/qr-posters/posters',
             $image, $new_name_image);
        $qr->image_poster = $new_name_image;

        $qr->title_poster               = $request->title_poster;
        $qr->title_color_poster         = $request->title_color_poster;
        $qr->sub_title_poster           = $request->sub_title_poster;
        $qr->sub_title_color_poster     = $request->sub_title_color_poster;
        $qr->description_poster         = $request->description_poster;
        $qr->description_color_poster   = $request->description_color_poster;
        $qr->helper_poster              = $request->helper_poster;
        $qr->helper_color_poster        = $request->helper_color_poster;
        $qr->show_store_loc_poster      = isset($request->show_store_loc_poster)?1:0;
        $qr->show_social_icons_poster   = isset($request->show_social_icons_poster)?1:0;
        $qr->global_text_color_poster   = $request->global_text_color_poster;
        $qr->backgrount_color_poster    = $request->backgrount_color_poster;
        $qr->save(); 
    }

    public function download(Request $request)
    {
        $id = $request->id;
        $qr = ArviQr::find($id);
        return Storage::disk('public')
        ->download('/arvi/backend-assets/img/qr-posters/posters/'.$qr->image_poster, 'poster-qr-'.$qr->name.'.png');
    }
}
