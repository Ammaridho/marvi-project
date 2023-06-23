<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabMarketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\ArviAr;
use App\Models\Merchant;

class ArController extends Controller
{
    protected $view = 'arvi.backend.marketing.ar.';

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ars = ArviAr::orderBy('create_time','desc')->get();
        return view($this->view.'page-ar-parent',compact('ars'));
    }

    public function showData(Request $request)
    {
        $search = $request->search;
        $active = $request->active;
        if ($active == 'Filter') {
            $ars = ArviAr::where('name', 'like', "%{$search}%")
            ->orderBy('id', 'desc')->get();
        } else {
            $ars = ArviAr::where('name', 'like', "%{$search}%")
                ->where('active',$active)
                ->orderBy('id', 'desc')->get();
        }
        return view($this->view.'page-ar-child',compact('ars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchantIds = Merchant::select('id','name')->get();
        return view($this->view.'page-insert-ar',compact('merchantIds'));
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
            'image_url'     => 'required|image',
        ]);

        // set code
        $code = Str::Random(10);

        // store
        $arviAr        = new ArviAr;
        $arviAr->name  = $request->name;
        // save image file to repo
        if (isset($request->image_url)) {
            $image = $request->file('image_url');
            $new_name_image = 'ar_'.$code.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/arvi/backend-assets/img/ars/', $image, $new_name_image);
            $arviAr->image_type = $image->getClientOriginalExtension();
            $arviAr->file_name  = $new_name_image;
            $arviAr->ar_url = env('APP_URL').'/storage/arvi/backend-assets/img/ars/'.$new_name_image;
            $arviAr->code = 'ar_'.$code;
        }
        $arviAr->save();
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
        $ar = ArviAr::find($request->id);
        $merchantIds = Merchant::select('id','name')->get();
        return view($this->view.'page-update-ar',compact('ar','merchantIds'));
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
            $arviAr = ArviAr::find($request->id);
            $arviAr->active = $request->active;
            $arviAr->save();
        }else{
            $validation = $request->validate([
                'name'          => 'required',
                'image_url'     => 'image',
            ]);

            // set code
            $code = Str::Random(10);

            // store
            $arviAr  = ArviAr::find($request->id);
            $arviAr->name  = $request->name;
            // save image file to repo
            if (isset($request->image_url)) {                
                $image = $request->file('image_url');
                $new_name_image = 'ar_'.$code.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->delete('/arvi/backend-assets/img/ars/'.$arviAr->file_name);
                Storage::disk('public')->putFileAs('/arvi/backend-assets/img/ars/', $image, $new_name_image);

                $arviAr->image_type = $image->getClientOriginalExtension();
                $arviAr->file_name  = $new_name_image;
                $arviAr->ar_url = env('APP_URL').'/storage/arvi/backend-assets/img/ars/'.$new_name_image;
                $arviAr->code = 'ar_'.$code;
            }
            $arviAr->save();
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
        $arviAr = ArviAr::find($request->id);
        Storage::disk('public')->delete('/arvi/backend-assets/img/ars/'.$arviAr->file_name);
        $arviAr->delete();
    }
}

