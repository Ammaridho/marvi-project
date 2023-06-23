<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabMarketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\ArviBanner;

class BannerController extends Controller
{
    protected $view = 'arvi.backend.marketing.banner.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = ArviBanner::orderBy('create_time','desc')->get();
        return view($this->view.'page-banner-parent',compact('banners'));
    }

    public function showData(Request $request)
    {
        $search = $request->search;
        $active = $request->active;
        if ($active == 'Filter') {
            $banners = ArviBanner::where('name', 'like', "%{$search}%")
            ->orderBy('id', 'desc')->get();
        } else {
            $banners = ArviBanner::where('name', 'like', "%{$search}%")
                ->where('active',$active)
                ->orderBy('id', 'desc')->get();
        }
        return view($this->view.'page-banner-child',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view.'page-insert-banner');
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
            'image_url'     => 'required|image|mimes:jpeg,jpg,png,gif|
                                max:200|dimensions:width=900,height=400',
            'order'         => 'required|integer|min:1',
            'date_start'    => 'required',
            'date_end'      => 'required'
        ],[
            'image_url.required'    => 'image required',
            'image_url.dimensions'  => 'image dimension',
            'image_url.max'         => 'image max',
        ]);

        // set code brand product
        $code = Str::Random(10);
        
        // store brand product
        $arviBanner             = new ArviBanner;
        $arviBanner->name       = $request->name;
        $arviBanner->order      = $request->order;
        $arviBanner->url        = $request->url;
        $arviBanner->date_start = date('Y-m-d',strtotime(str_replace('/', '-', "$request->date_start")));
        $arviBanner->date_end   = date('Y-m-d',strtotime(str_replace('/', '-', "$request->date_end")));
        // save image file to repo
        if (isset($request->image_url)) {
            $image = $request->file('image_url');
            $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/arvi/backend-assets/img/banners', $image, $new_name_image);
            $arviBanner->image_type = $image->getClientOriginalExtension();
            $arviBanner->image_url  = $new_name_image;
        }
        $arviBanner->save();

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
        $banner = ArviBanner::find($request->id);
        return view($this->view.'page-update-banner',compact('banner'));
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
            $arviBanner = ArviBanner::find($request->id);
            $arviBanner->active = $request->active;
            $arviBanner->save();
        }else{
            $validation = $request->validate([
                'name'          => 'required',
                'image_url'     => 'mimes:jpeg,jpg,png,gif|max:200|
                                    dimensions:width=900,height=400',
                'order'         => 'required|integer|min:1',
                'date_start'    => 'required',
                'date_end'      => 'required'
            ],[
                'image_url.dimensions' => 'image dimension',
                'image_url.max'        => 'image max',
            ]);

            // set code brand product
            $code = Str::Random(10);

            $arviBanner             = ArviBanner::find($request->id);
            // save image file to repo
            if (isset($request->image_url)) {
                $image = $request->file('image_url');
                $new_name_image = $request->name.'_'.$code.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->delete('/arvi/backend-assets/img/banners/'.$arviBanner->image_url);
                Storage::disk('public')->putFileAs('/arvi/backend-assets/img/banners', $image, $new_name_image);
            }

            // store brand product
            $arviBanner->name       = $request->name;
            $arviBanner->order      = $request->order;
            $arviBanner->url        = $request->url;
            $arviBanner->date_start = date('Y-m-d',strtotime(str_replace('/', '-', "$request->date_start")));
            $arviBanner->date_end   = date('Y-m-d',strtotime(str_replace('/', '-', "$request->date_end")));
            if (isset($request->image_url)) {
            $arviBanner->image_type = $image->getClientOriginalExtension();
            $arviBanner->image_url  = $new_name_image;
            }
            $arviBanner->save();
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
        $arviBanner = ArviBanner::find($request->id);
        Storage::disk('public')->delete('/arvi/backend-assets/img/banners/'.$arviBanner->image_url);
        $arviBanner->delete();
    }
}
