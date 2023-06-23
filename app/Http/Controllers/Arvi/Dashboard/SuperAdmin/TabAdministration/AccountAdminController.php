<?php

namespace App\Http\Controllers\Arvi\Dashboard\SuperAdmin\TabAdministration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\User;

use Illuminate\Support\Str;

use Carbon\Carbon;

class AccountAdminController extends Controller
{
    protected $view = 'arvi.backend.administration.manage-account-admin.';

    protected $roles = ['superadmin','admin','viewer'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            $users = User::orderBy('id','desc')
            ->whereIn('role',$this->roles)->take(25)->get();
            $merchants = Merchant::pluck('name');
            $merchant = Merchant::pluck('name','id');
            return view($this->view . 'page-admin-user-management',
                    compact('users','merchants','merchant','companyCode'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function showData(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {

            $much = isset($request->much) ? $request->much : 25;

            if (isset($request->role)) {
                if ($request->role == 'superadmin' || 
                $request->role == 'admin' || $request->role == 'viewer') {
                    $users = User::where('role', $request->role)
                    ->orderBy('id', 'desc')->take($much)->get();
                }else if ($request->role == '0' || $request->role == '1') {
                    $users = User::where('active',$request->role)
                    ->orderBy('id','desc')->take($much)->get();
                }else{
                    $users = User::orderBy('id','desc')
                    ->whereIn('role',$this->roles)->take($much)->get();
                }
            }else {
                $users = User::orderBy('id','desc')
                ->whereIn('role',$this->roles)->take($much)->get();
            }
            
            $merchants = Merchant::pluck('name');
            $merchant = Merchant::pluck('name','id');
            return view($this->view . 'data-table-account',
                    compact('users','merchants','merchant','companyCode'));
        }
        return view('arvi.frontend.page-not-available');
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
            $companies = Company::all();

            return view($this->view . 'page-admin-user-management-new',
                    compact('companies','companyCode'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function brandAppear(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {
            
            $companyIds = $request->checkedCompanies;
            $companyAndBrands = Company::join('brands','companies.id','=','brands.company_id')
            ->select('brands.id as brand_id','companies.id as company_id',
            'brands.name as brand_name','companies.name as company_name')
            ->whereIn('company_id',$companyIds)
            ->get();

            if (isset($request->idUser)) {
                $idUser = $request->idUser;
                $dataRelationBrands = User::find($request->idUser)->brands->pluck('id');
                return view($this->view . 'side-brand-appear',
                    compact('companyAndBrands','companyCode','dataRelationBrands','idUser'));
            }
            
            return view($this->view . 'side-brand-appear',
                compact('companyAndBrands','companyCode'));
        } 
        return view('arvi.frontend.page-not-available');
    }

    public function merchantAppear(Request $request)
    {
        $companyCode = $request->companyCode;
        if ($companyCode == 'superAdmin') {

            $brandIds = $request->checkedBrands;
            $brandAndMerchants = Brand::join('merchants','brands.id','=','merchants.brand_id')
                                    ->select('merchants.id as merchant_id','brands.id as brand_id',
                                    'merchants.name as merchant_name','brands.name as brand_name')
                                    ->whereIn('brand_id',$brandIds)
                                    ->get();
            
            if (isset($request->idUser)) {
                $dataUserStore = User::find($request->idUser)->store_id;
                return view($this->view . 'side-merchant-appear',
                    compact('brandAndMerchants','companyCode','dataUserStore'));
            }

            return view($this->view . 'side-merchant-appear',
                compact('brandAndMerchants','companyCode'));
        } 
        return view('arvi.frontend.page-not-available');
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
                'name'      => 'required',
                'email'     => 'required|email',
                'password'  => 'required|confirmed',
                'role'      => 'required',
                'mobile'    => 'required'
            ]);

            // user and merchant
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone_number    = $request->mobile;
            $user->password = bcrypt($request->password);
            $user->role     = $request->role;
            $user->remember_token = Str::random(100);

            if ($request->role == 'superadmin') {

                $user->save();

            }else{

                // cek input store_id
                if (isset($request->store)) {
                    // store to users att store_id
                    $user->store_id = json_encode($request->store);

                    // set relation to brand
                    $brands = Merchant::findMany($request->store)
                    ->unique('brand_id')->pluck('brand_id');
                } else {
                    $user->store_id = null;
                }

                $user->save();

                // many to many relation
                $user->companies()->attach($request->companies, 
                ['create_time' => Carbon::now()]);
                
                // many to many relation
                $user->brands()->attach($request->brand, 
                ['create_time' => Carbon::now()]);            
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
        if ($companyCode == 'superAdmin') {
            $companies = Company::all();

            // join
            $companyAndBrands = Company::join('brands','companies.id','=','brands.company_id')
                                        ->select('brands.id as brand_id','companies.id as company_id',
                                        'brands.name as brand_name','companies.name as company_name')
                                        ->get();
            $brandAndMerchants = Brand::join('merchants','brands.id','=','merchants.brand_id')
                                        ->select('merchants.id as merchant_id','brands.id as brand_id',
                                        'merchants.name as merchant_name','brands.name as brand_name')
                                        ->get();

            // data user
            $userId = $request->userId;
            $dataUser = User::find($userId);
            
            // get data with relation many to many
            $dataRelationBrands = User::find($userId)->brands->pluck('id');
            $dataRelationCompanies = User::find($userId)->companies->pluck('id');

            return view($this->view . 'page-admin-user-management-update',
                    compact('dataUser','companyAndBrands','companyCode',
                        'brandAndMerchants','companies','dataRelationBrands',
                        'dataRelationCompanies'));
        }
        return view('arvi.frontend.page-not-available');
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
                $user               = User::find($request->id);
                $user->active       = $request->statusActive;
                $user->save();

            } else {

                if (isset($request->password)) {
                    $validatedData = $request->validate([
                        'name'      => 'required',
                        'email'     => 'required|string|email|max:255|unique:users,email,'.$request->idUser,
                        'role'      => 'required',
                        'mobile'    => 'required',
                        'password'  => 'required|confirmed'
                    ]);
                } else {
                    $validatedData = $request->validate([
                        'name'      => 'required',
                        'email'     => 'required|string|email|max:255|unique:users,email,'.$request->idUser,
                        'role'      => 'required',
                        'mobile'    => 'required'
                    ]);
                }

                // user and merchant
                $idUser = $request->idUser;

                $user               = User::find($idUser);
                $user->name         = $request->name;
                $user->email        = $request->email;
                $user->phone_number = $request->mobile;
                if (isset($request->password)) {
                    $user->password     = bcrypt($request->password);
                }
                $user->role         = $request->role;
                
                // cek input store_id
                if (isset($request->store)) {
                    // store to users att store_id
                    $user->store_id = json_encode($request->store);

                    // set relation to brand
                    $brands = Merchant::findMany($request->store)
                                        ->unique('brand_id')->pluck('brand_id');
                } else {
                    $user->store_id = null;
                }
                $user->save();

                // many to many relation
                    $user->companies()->detach();
                    $user->companies()->attach($request->companies,
                    ['create_time' => Carbon::now()]);

                    $user->brands()->detach();
                    $user->brands()->attach($request->brand, 
                    ['create_time' => Carbon::now()]);
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
        $user = User::find($request->id);
        $user->companies()->detach();
        $user->brands()->detach();
        $user->delete();
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
