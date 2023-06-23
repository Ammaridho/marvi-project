<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabFulfilment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\ArviDelivery;
use App\Models\ArviSubDelivery;

class DeliveryController extends Controller
{
    protected $view = 'arvi.backend.fulfilment.delivery.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = ArviDelivery::orderBy('id', 'desc')->get();
        return view($this->view.'page-delivery-parent',
        compact('deliveries'));
    }

    public function showData(Request $request)
    {
        $search = $request->search;
        $active = $request->active;
        if ($active == 'Filter') {
            $deliveries = ArviDelivery::where('name', 'like', "%{$search}%")
            ->orderBy('id', 'desc')->get();
        } else {
            $deliveries = ArviDelivery::where('name', 'like', "%{$search}%")
                ->where('active',$active)
                ->orderBy('id', 'desc')->get();
        }
        return view($this->view.'page-delivery-child',compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deliveries = ArviDelivery::all();
        return view($this->view.'page-insert-delivery',
        compact('deliveries'));
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
            'method_name'   => 'required',
            'image_url'     => 'image|mimes:jpeg,jpg,png,gif|max:200',
        ],[
            'image_url.max'         => 'image max',
        ]);

        // set code delivery
        $code = Str::Random(10);

        // store delivery
        $arviDelivery             = new ArviDelivery;
        $arviDelivery->name       = $request->method_name;
        $arviDelivery->code       = $code;
        // save image file to repo
        if (isset($request->image_url)) {
            $image = $request->file('image_url');
            $new_name_image = $request->method_name.'_'.$code.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('arvi/backend-assets/img/delivery', $image, $new_name_image);
            $arviDelivery->image_type = $image->getClientOriginalExtension();
            $arviDelivery->image_url  = $new_name_image;
        }
        $arviDelivery->save();

        // service
        $services = json_decode($request->services,true);
        if(isset($services)){
            foreach ($services as $item) { 
                $service = new ArviSubDelivery;
                $service->name           = $item['nameService'];
                $service->active         = count($item['activeService']) > 0 ? 1 : 0 ;
                $service->arviDelivery()->associate($arviDelivery);
                $service->save();
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
        $id     = $request->id;
        $delivery = ArviDelivery::find($id);

        $services = $delivery->arviSubDelivery;

        return view($this->view.'page-update-delivery',
            compact('delivery','services'));
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
            if (isset($request->subDelType)) {
                $arviDelivery = ArviSubDelivery::find($request->id);
                $arviDelivery->active = $request->active;
                $arviDelivery->save();
            } else {
                $arviDelivery = ArviDelivery::find($request->id);
                $arviDelivery->active = $request->active;
                $arviDelivery->save();
            }
            
        }else{
            $validation = $request->validate([
                'method_name'   => 'required',
                'image_url'     => 'mimes:jpeg,jpg,png,gif|max:200',
            ],[
                'image_url.max'         => 'image max',
            ]);

            // set code delivery
            $code = Str::Random(10);

            // store delivery
            $arviDelivery        = ArviDelivery::find($request->id);
            $arviDelivery->name  = $request->method_name;
            $arviDelivery->code  = $code;
            // save image file to repo
            if (isset($request->image_url)) {
                $image = $request->file('image_url');
                $new_name_image = $request->method_name.'_'.$code.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->delete('/arvi/backend-assets/img/delivery/'.$arviDelivery->image_url);
                Storage::disk('public')->putFileAs('/arvi/backend-assets/img/delivery', $image, $new_name_image);
                $arviDelivery->image_type = $image->getClientOriginalExtension();
                $arviDelivery->image_url  = $new_name_image;
            }
            $arviDelivery->save();

            ArviSubDelivery::where('arvi_delivery_id',$request->id)->delete();

            // service
            $services = json_decode($request->services,true);
            if(isset($services)){
                foreach ($services as $item) { 
                    $service = new ArviSubDelivery;
                    $service->name           = $item['name'];
                    $service->active         = count($item['active']) > 0 ? 1 : 0 ;
                    $service->arviDelivery()->associate($arviDelivery);
                    $service->save();
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
    public function destroy(Request $request)
    {
        $arviDelivery = ArviDelivery::find($request->id);
        ArviSubDelivery::where('arvi_delivery_id',$request->id)->delete();
        Storage::disk('public')->delete('/arvi/backend-assets/img/delivery/'.$arviDelivery->image_url);
        $arviDelivery->delete();
    }
}
