<?php

namespace App\Http\Controllers\Arvi\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Company;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

use stdClass;

use Carbon\Carbon;

class AuthController extends Controller
{
    protected $view = 'arvi.backend.auth.';
    
    public function index(Request $request)
    {
        return view('arvi.backend.index');
    }

    public function formLogin(Request $request)
    {
        return view($this->view.'page-login');
    }

    public function login(Request $request)
    {
        // validation
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        // check account and 
        if (User::where('email',$request->email)->first()) {
            // remember_me
            $remember_me = $request->has('remember')?true:false;
            if (Auth::attempt($credentials,$remember_me)) {
                $user = auth()->user();
                if (User::where('email',$request->email)->first()->role == 'superadmin') {
                    $request->session()->regenerate();
                    $request->session()->put('access', 'superadmin');
                    $request->session()->put('email', $request->email);
                    $user = User::where('email',$request->email)->first();
                    if ($user->active == 0) {
                        return redirect()->route('index')
                        ->with(['notActive' => ""]);
                    }
                    $user->last_login = Carbon::now();
                    $user->save();
                    return redirect()
                    ->route('choose-company',['idCompanies' =>  'superAdmin'])
                    ->with(['success' => 'Login Success!']);
                } else {                
                    $userCompanies = User::where('email',$request->email)->first()
                    ->companies->pluck('id')->toArray();
                    if (count($userCompanies) > 0) {
                        $request->session()->regenerate();
                        $request->session()->put('email', $request->email);
                        $user = User::where('email',$request->email)->first();
                        $request->session()->put('access', $user->role);
                        if ($user->active == 0) {
                            return redirect()->route('index')
                            ->with(['notActive' => ""]);
                        }
                        $user->last_login = Carbon::now();
                        $user->save();
                        return redirect()
                        ->route('choose-company',['idCompanies' =>  $userCompanies])
                        ->with(['success' => 'Login Success!']);
                    }
                    return redirect()->route('index')
                    ->with(['error' => 'You dont have company, please contact admin!']);
                }
            }
            return redirect()->route('index')
                ->with(['errorPassword' => 'Wrong Password!']);
        }
        return redirect()->route('index')
                ->with(['errorEmail' => 'Wrong Password!']);
    }
    
    public function formSignUp(Request $request)
    {
        return view($this->view.'page-registration');
    }

    public function formSignUpCheckData(Request $request)
    {
        // validation
        $validator = $request->validate([
            'uname'             => 'required',
            'bname'             => 'required',
            'name'              => 'required|unique:App\Models\Company,name',
            'company_address'   => 'required',
            'phone_number'      => 'required|unique:App\Models\User,phone_number',
            'email'             => 'required|unique:App\Models\User,email|email:dns',
            'password'          => 'required|confirmed',
            'accept'            => 'accepted'
        ],
        [
            'name.required'           => 'name required!',
            'name.unique'             => 'name unique!',
            'phone_number.required'   => 'phone_number required!',
            'phone_number.unique'     => 'phone_number unique!',
            'email.required'          => 'email required!',
            'email.unique'            => 'email unique!'
        ]);
    }

    public function otpRegister(Request $request)
    {
        $data = $request->data;
        return view($this->view.'page-otp',compact('data'));
    }
    
    public function storeSignUp(Request $request)
    {
        $data = json_decode($request->data,true);

        $dataArray = [];
        foreach ($data as $key => $value) {
            $dataArray[$value['name']] =  $value['value'];
        }

        $user = new User;
        $user->name             = $dataArray['uname'];
        $user->email            = $dataArray['email'];
        $user->phone_number     = str_replace("( ","(+",$dataArray['phone_number']);
        $user->password         = bcrypt($dataArray['password']);
        $user->remember_token   = Str::random(50);
        $user->role             = 'admin';
        $user->active           = 0;
        $user->save();
        
        $company = new Company;
        $company->name           = $dataArray['name']; 
        $company->code           = 'cmp'.Str::random(10);
        $company->email          = $dataArray['email'];
        $company->phone_number   = str_replace("( ","(+",$dataArray['phone_number']);
        $company->street_address = $dataArray['company_address'];
        $company->save();
        
        $idCompany = Company::where('email',$dataArray['email'])->first()->id;
        
        // many to many relation
        $user->companies()->attach([$idCompany],['create_time' => Carbon::now()]);

        return redirect()->route('thankyou-page');
    }

    public function thankyouPage(Request $request)
    {
        return view($this->view.'page-thank-you');
    }
    
    public function settings(Request $request)
    {
        $companyCode = $request->companyCode;
        $dataCompany = Company::getByCode($companyCode);
        if ($dataCompany) {
            $loginData = User::where('email',$request->session()->get('email'))->first();
            return view('arvi.backend.dashboard.page-settings',
            compact('companyCode','loginData','dataCompany'));
        } else if($companyCode == 'superAdmin'){
            $loginData = User::where('email',$request->session()->get('email'))->first();
            return view('arvi.backend.dashboard.page-settings',
            compact('companyCode','loginData'));
        }
        return view('arvi.page-not-available');
    }
    
    public function storeSettings(Request $request)
    {
        $companyCode = $request->companyCode;
        $dataCompany = Company::getByCode($companyCode);
        if ($dataCompany) {
            // validation
            if (isset($request->password)) {
                $validator = $request->validate([
                    'nameUser'        => 'required',
                    'nameCompany'     => 'required|unique:App\Models\Company,name,'.$dataCompany->id,
                    'company_address' => 'required',
                    'phone_number'    => 'required',
                    'email'           => 'required|email:dns',
                    'password'        => 'confirmed',
                ]);
                $user = User::where('email',$request->session()->get('email'))->first();
                if (Hash::check($request->passwordOld, $user->password)) {
                    $user = User::where('email',$request->session()->get('email'))->first();
                    $user->password = bcrypt($request->password);
                    $user->save();
                } 
                else {
                    $err = new stdClass();
                    $err->error = 400;
                    $err->message = trans('otf.validation.missing_parameter');
                    return response()->json($err,400);
                }
            }else{
                $validator = $request->validate([
                    'nameUser'        => 'required',
                    'nameCompany'     => 'required|unique:App\Models\Company,name,'.$dataCompany->id,
                    'company_address' => 'required',
                    'phone_number'    => 'required',
                    'email'           => 'required|email:dns'
                ]);
            }
            
            // company
            $dataCompany->name = $request->nameCompany;
            $dataCompany->email = $request->email;
            $dataCompany->phone_number = $request->phone_number;
            $dataCompany->street_address = $request->company_address;
            $dataCompany->save();
            
            // user 
            $user = User::where('email',$request->session()->get('email'))->first();
            $user->name = $request->nameUser;
            $user->save();
            
        } else if($companyCode == 'superAdmin'){
            if (isset($request->password)) {
                $validator = $request->validate([
                    'nameUser'        => 'required',
                    'password'        => 'confirmed',
                ]);
                $user = User::where('email',$request->session()->get('email'))->first();
                if (Hash::check($request->passwordOld, $user->password)) {
                    $user = User::where('email',$request->session()->get('email'))->first();
                    $user->password = bcrypt($request->password);
                    $user->save();
                } 
                else {
                    $err = new stdClass();
                    $err->error = 400;
                    $err->message = trans('otf.validation.missing_parameter');
                    return response()->json($err,400);
                }
            }else{
                $validator = $request->validate([
                    'nameUser'        => 'required',
                ]);
            }
            $user = User::where('email',$request->session()->get('email'))->first();
            $user->name = $request->nameUser;
            $user->save();
        }
        return view('arvi.page-not-available');
    }
    
    public function logout(Request $request)
    {
        // logout Auth
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // get code merchant
        return redirect('/dashboard');
    }
    
    public function forgetPassword(Request $request)
    {
        return view($this->view.'page-forget');
    }

    public function checkPhoneNumber(Request $request)
    {
        // validation
        $validator = $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);

        $data = $request->phone_number;
        
        return view($this->view.'page-otp',compact('data'));
    }

    public function inputNewPassword(Request $request)
    {
        $phone_number = $request->data;
        return view($this->view . 'page-changed-password',compact('phone_number'));
    }

    public function storeNewPassword(Request $request)
    {
        // validation
        $validator = $request->validate([
            'password'  => 'required|confirmed',
        ]);

        $account = User::where('phone_number',$request->phone_number)->first();
        $account->password = bcrypt($request->password);
        $account->save();

        return redirect()->route('store-new-password-dashboard-success');

    }

    public function storeNewPasswordSuccess()
    {
        return view($this->view . 'page-changed-password-done');
    }

}
