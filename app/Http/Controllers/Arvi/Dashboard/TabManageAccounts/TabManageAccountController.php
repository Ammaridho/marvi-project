<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabManageAccounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\User;

use Illuminate\Support\Str;

use Carbon\Carbon;

class TabManageAccountController extends Controller
{
    protected $view = 'arvi.backend.manage-accounts.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {
            $company_id = $data->id;
            $merchant = Merchant::pluck('name','id');
            // user if not have companies like code
            $users = User::whereIn('role',['admin','viewer'])
                ->whereHas('companies', function($q) use($companyCode) {
                    $q->where('code', $companyCode);
                })->get();
            $merchants_id = Merchant::where('company_id',$data->id)->pluck('id')->toArray();
            return view($this->view . 'page-account',
                    compact('companyCode','users','merchant','merchants_id','company_id'));
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
        $data = Company::getByCode($companyCode);
        if ($data) {
            $companyId = $data->id;
            $brands = Brand::where('company_id', $companyId)->get();
            return view($this->view . 'page-account-new',
                    compact('companyId','companyCode','brands'));
        }
        return view('arvi.page-not-available');
    }

    public function merchantAppear(Request $request)
    {
        $companyCode = $request->companyCode;
        $data = Company::getByCode($companyCode);
        if ($data) {

            $brandIds = $request->checkedBrands;

            $brandAndMerchants = Brand::join('merchants','brands.id','=','merchants.brand_id')
                                        ->select('merchants.id as merchant_id','brands.id as brand_id',
                                        'merchants.name as merchant_name','brands.name as brand_name')
                                        ->whereIn('brand_id',$brandIds)
                                        ->get();

            if (isset($request->idUser)) {
                $idUser = $request->idUser;
                $dataUserStore = User::find($request->idUser)->store_id;
                return view($this->view . 'side-merchant-appear',compact('brandAndMerchants','companyCode','dataUserStore','idUser'));
            }
    
            return view($this->view . 'side-merchant-appear',compact('brandAndMerchants','companyCode'));
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
        $data = Company::getByCode($companyCode);
        if ($data) {
            
            $validatedData = $request->validate([
                'companyId' => 'required',
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|confirmed',
                'role'      => 'required',
                'mobile'    => 'required',
                'brand'     => 'required'
            ]);

            // user and merchant
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone_number    = $request->mobile;
            $user->password = bcrypt($request->password);
            $user->role     = $request->role;
            $user->remember_token = Str::random(100);
            // cek input store_id
            if (isset($request->store)) {

                // store to users att store_id
                $user->store_id = json_encode($request->store);

            } else {
                $user->store_id = null;
            }
            $user->save();
            
            // one to many (bcs admin only can manage account in his company)
            $user->companies()->attach($request->companyId,
                ['create_time' => Carbon::now()]);
            
            // many to many relation
            $user->brands()->attach($request->brand, 
                ['create_time' => Carbon::now()]);

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
        $data = Company::getByCode($companyCode);
        if ($data) {
            $brands = Brand::where('company_id', $data->id)->get();

            // join
            $brandAndMerchants = Brand::join('merchants','brands.id','=','merchants.brand_id')
                                        ->select('merchants.id as merchant_id','brands.id as brand_id',
                                        'merchants.name as merchant_name','brands.name as brand_name')
                                        ->where('brands.company_id', $data->id)
                                        ->get();

            // data user
            $dataUser = $request->dataUser;

            // get data with relation many to many
            $dataRelationBrands = User::find($dataUser['id'])->brands->pluck('id');

            
            return view($this->view . 'page-account-update',
                    compact('companyCode','dataUser',
                        'brandAndMerchants','brands','dataRelationBrands'));
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
        $data = Company::getByCode($companyCode);
        if ($data) {
            if (isset($request->password)) {
                $validatedData = $request->validate([
                    'name'      => 'required',
                    'email'     => 'required|email',
                    'role'      => 'required',
                    'mobile'    => 'required',
                    'brand'     => 'required',
                    'password'  => 'required|confirmed'
                ]);
            } else {
                $validatedData = $request->validate([
                    'name'      => 'required',
                    'email'     => 'required|email',
                    'role'      => 'required',
                    'brand'     => 'required',
                    'mobile'    => 'required'
                ]);
            }

            // user and merchant
            $idUser = $request->idUser;

            $user           = User::find($idUser);
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone_number  = $request->mobile;
            if (isset($request->password)) {
                $user->password     = bcrypt($request->password);
            }
            $user->role     = $request->role;

            foreach ($request->brand as $key => $brandId) {
                // check input store_id
                $merchant_id = Merchant::where('brand_id',$brandId)->pluck('id')->toArray(); //merchant in brand
                $users_store_id = $user->store_id;  //merchant in user
    
                if (isset($request->store)) {
                    $user->store_id = json_encode($request->store);
                }else{
                    $user->store_id = null;
                }
            }
            $user->save();

            $brand_id = Brand::where('company_id',$data->id)->pluck('id');
            $user->brands()->detach($brand_id);
            $user->brands()->attach($request->brand, 
                ['create_time' => Carbon::now()]);

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
