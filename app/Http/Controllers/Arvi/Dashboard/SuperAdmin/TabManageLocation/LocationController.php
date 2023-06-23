<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabManageLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    protected $view = 'arvi.backend.administration.manage-location-admin.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $locations = Location::orderBy('id','desc')->get();
            return view($this->view . 'page-admin-location-management',
                compact('companyCode','locations'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $much = isset($request->much) ? $request->much : 25;
            if (isset($request->filter)) {
                if (in_array($request->filter, 
                ['Office Building','Hospital','Mall','Restaurant',
                'Cloud Kitchen','Pop-ups','Food Truck','Cafe',
                'Fast Food','Food Court','School/College','Public Area'])) {
                    $locations = Location::where('location_type', 'like', "%{$request->filter}%")
                    ->orderBy('id', 'desc')->take($much)->get();
                }else if ($request->filter == '0' || $request->filter == '1') {
                    $locations = Location::where('active',$request->filter)
                        ->orderBy('id','desc')->take($much)->get();
                }else{
                    $locations = Location::orderBy('id','desc')->take($much)->get();
                }
            }else {
                $locations = Location::orderBy('id','desc')->take($much)->get();
            }
            return view($this->view . 'data-table-location',
                    compact('locations','companyCode'));
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
        if ($companyCode == 'superAdmin') {
            $countries = Countries::all()->pluck('name.common');
            return view($this->view . 'page-admin-location-management-new',
                compact('companyCode','countries'));
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
        if ($companyCode == 'superAdmin') {
            $validatedData = $request->validate([
                'name'                  => 'required',
                'street_address'        => 'required',
                'building_suite'        => 'required',
                'city'                  => 'required',
                'postal_code'           => 'required',
                'lat'                   => 'required',
                'lon'                   => 'required',
                'storeCategoriesData'   => 'required',
                'loc_aware_tolerance'   => 'required',
            ]);
            // Store Location
            $location = new Location();
            $location->name                 = $request->name;
            $location->code                 = 'loc'.Str::random(10);
            $location->address              = $request->street_address;
            $location->building_suite       = $request->building_suite;
            $location->city                 = $request->city;
            $location->state                = $request->state;
            $location->postal_code          = $request->postal_code;
            $location->country              = $request->country;
            $location->loc_lat              = $request->lat;
            $location->loc_lon              = $request->lon;
            $location->description          = $request->description;
            $location->location_type        = $request->storeCategoriesData;
            $location->loc_aware_tolerance  = $request->loc_aware_tolerance;
            $location->loc_aware_uom        = 'M';
            $location->save();
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
        if ($companyCode == 'superAdmin') {
            $location = $request->dataLocation;
            $countries = Countries::all()->pluck('name.common');
            return view($this->view . 'page-admin-location-management-update',
                    compact('companyCode','location','countries'));
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
        if ($companyCode == 'superAdmin') {
            if (isset($request->statusActive)) {
                $location               = Location::find($request->id);
                $location->active       = $request->statusActive;
                $location->save();
            } else {
                $validatedData = $request->validate([
                    'idLocation'            => 'required',
                    'name'                  => 'required',
                    'street_address'        => 'required',
                    'building_suite'        => 'required',
                    'city'                  => 'required',
                    'postal_code'           => 'required',
                    'lat'                   => 'required',
                    'lon'                   => 'required',
                    'storeCategoriesData'   => 'required',
                    'loc_aware_tolerance'   => 'required',
                ]);
                // Store Location
                $location = Location::find($request->idLocation);
                $location->name                 = $request->name;
                $location->address              = $request->street_address;
                $location->building_suite       = $request->building_suite;
                $location->city                 = $request->city;
                $location->state                = $request->state;
                $location->postal_code          = $request->postal_code;
                $location->country              = $request->country;
                $location->loc_lat              = $request->lat;
                $location->loc_lon              = $request->lon;
                $location->description          = $request->description;
                $location->location_type        = $request->storeCategoriesData;
                $location->loc_aware_tolerance  = $request->loc_aware_tolerance;
                $location->loc_aware_uom        = 'M';
                $location->save();
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
        $location = Location::find($request->id)->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
