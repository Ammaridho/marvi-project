<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabAdministration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Merchant;
use App\Models\Brand;
use App\Models\User;
use App\Models\BrandSocialReference;
use App\Models\MerchantProduct;
use Illuminate\Support\Facades\Storage;
use App\Models\MerchantDelivery;
use App\Models\MerchantSocialReference;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Monarobase\CountryList\CountryListFacade;

class CompanyController extends Controller
{

    protected $view = 'arvi.backend.administration.manage-company-admin.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $companies = Company::orderBy('id','desc')->get();
            return view($this->view . 'page-admin-company-management',
                    compact('companyCode','companies'));
        }
        return view('arvi.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {

            $much = isset($request->much) ? $request->much : 25;

            if ($request->status == 'approved' || $request->status == 'rejected') {
                $companies = Company::where('status', $request->status)
                                    ->orderBy('id', 'desc')->take($much)->get();
            } else if ($request->status == 'inreview') {
                $companies = Company::where('status', $request->status)
                                    ->orWhereNull('status')->orderBy('id', 'desc')
                                    ->take($much)->get();
            } else {
                $companies = Company::orderBy('id','desc')->take($much)->get();
            }
            
            return view($this->view . 'data-table-company',
                    compact('companyCode','companies'));
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
            $countries = CountryListFacade::getList('en');
            return view($this->view . 'page-admin-company-management-new',
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
                'name'          => 'required',
                'email'         => 'required|email',
                'phone_number'  => 'required',
                'country'       => 'required',
            ]);

            // user and merchant
            $company = new Company();
            $company->name             = $request->name;
            $company->email            = $request->email;
            $company->code             = Str::random(10);
            $company->phone_number     = $request->phone_number;
            $company->street_address   = $request->street_address;
            $company->building_suite   = $request->building_suite;
            $company->city             = $request->city;
            $company->state            = $request->state;
            $company->postal_code      = $request->postal_code;
            $company->country          = $request->country;
            $company->status           = $request->status;
            $company->save();

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
            // data user
            $dataUser = $request->dataUser;
            $countries = CountryListFacade::getList('en');
            return view($this->view . 'page-admin-company-management-update',
                    compact('dataUser','companyCode','countries'));
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
                $company               = Company::find($request->id);
                $company->active       = $request->statusActive;
                $company->save();

            } else {
                $validatedData = $request->validate([
                    'name'          => 'required',
                    'email'         => 'required|email',
                    'phone_number'  => 'required',
                    'country'       => 'required',
                ]);

                $company = Company::find($request->idCompany);
                $company->name             = $request->name;
                $company->email            = $request->email;
                $company->phone_number     = $request->phone_number;
                $company->street_address   = $request->street_address;
                $company->building_suite   = $request->building_suite;
                $company->city             = $request->city;
                $company->state            = $request->state;
                $company->postal_code      = $request->postal_code;
                $company->country          = $request->country;
                $company->status           = $request->status;
                $company->save();
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
        $company = Company::find($request->id);

        // Brand
        $brandIds = Brand::where('company_id',$request->id)->pluck('id');
        foreach ($brandIds as $key => $brandId) {
            // Delete Brand and Store include
            $merchant = app('App\Http\Controllers\Arvi\Dashboard\TabManageBrand\TabManageBrandController')
            ->destroy(new Request, $company->code,$brandId);
        }

        $company->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
