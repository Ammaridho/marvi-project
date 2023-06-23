<?php
namespace App\Http\Controllers\Arvi\Dashboard\TabStoreSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\ProductCategory;
use App\Models\Company;

use Illuminate\Support\Str;
use Validator;

class TabStoreFrontController extends Controller
{
    protected $view  = 'arvi.backend.store-settings.store-front.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $categories = ProductCategory::all();
        return view($this->view . 'page-store-front' ,compact('companyCode','categories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'         => 'required',
            'description'  => 'required',
            // 'country'      => 'required',
            // 'company_id'   => 'required',
            // 'postal_code'  => 'required',
            // 'loc_tz'       => 'required',
            'image_url'    => 'required|image|mimes:jpeg,png,jpg,gif',
            // 'phone_number' => 'required',
            // 'cover_img'    => 'required',
            // 'banner_img'   => 'required',
            // 'active'       => 'required',
        ]);

        if ($validation->passes()) {

            // set code brand
            $code = Str::Random(10);

            // save image file to repo
            $image = $request->file('image_url');
            $new_name_image = $request->name . '_'. $code . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('brand_logo'), $new_name_image);

            // store brand
            $store = new Brand;
            $store->name            = $request->name;
            $store->description     = $request->description;
            $store->code            = $code;
            $store->country         = 'indonesia';
            // $store->postal_code     = $request->postal_code;
            $store->company_id      = 1;
            // $store->loc_tz          = $request->loc_tz;
            $store->image_url       = $new_name_image;
            // $store->phone_number    = $request->phone_number;
            // $store->cover_img       = $request->cover_img;
            // $store->banner_img      = $request->banner_img;
            $store->active          = 1;
            $store->save();

            // store social media
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
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}