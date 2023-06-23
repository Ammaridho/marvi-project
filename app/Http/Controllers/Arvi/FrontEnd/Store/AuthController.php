<?php

namespace App\Http\Controllers\Arvi\FrontEnd\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;

class AuthController extends Controller
{

    protected $view = 'arvi.frontend.store.account.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        return view($this->view.'page-login',compact('code'));
    }


    public function login(Request $request,$code)
    {
        // validation
        $validator = $request->validate([
            'phone_number' => 'required',
            'password'     => 'required',
        ]);

        // remember_me
        $remember_me = $request->has('remember')?true:false;
        if (Auth::attempt($validator,$remember_me)) {
            $user = auth()->user();
            $request->session()->regenerate();
            return redirect()->route('index-store',['code'=>$code]);
        }
        return redirect()->route('login-store',['code'=>$code])
            ->with('error','Invalid Number or Password');
    }


    public function otp(Request $request,$code)
    {
        // validation
        $validator = $request->validate([
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'phone'     => 'required|unique:users,phone_number',
            'password'  => 'required|confirmed',
        ]);

        // data register
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,
        ];

        return view($this->view.'page-otp',compact('data','code'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$code)
    {
        return view($this->view.'page-register',compact('code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$code)
    {
        // validation
        $validator = $request->validate([
            'digit-1'      => 'required',
            'digit-2'      => 'required',
            'digit-3'      => 'required',
            'digit-4'      => 'required',
            'digit-5'      => 'required',
        ]);

        if (isset($request->data['name'])) {
            // create account
            $account = new User;
            $account->name          = $request->data['name'];
            $account->phone_number  = $request->data['phone'];
            $account->email         = $request->data['email'];
            $account->address       = $request->data['address'];
            $account->password      = bcrypt($request->data['password']);
            $account->role          = 'customer';
            $account->save();

            // auto login
            if (Auth::attempt(['phone_number' => $request->data['phone'],
                'password' => $request->data['password']])) {
                $user = auth()->user();
                $request->session()->regenerate();
                return redirect()->route('thankyou-store',['code'=>$code]);
            }
            return redirect()->route('login-store',['code'=>$code])
                ->with('error','error store data');
        }else {
            $phone_number = $request->data;
            return redirect()
                ->route('store-new-password-store',
                ['code'=>$code,'phone_number' => $phone_number]);
        }

    }

    public function thankyou($code)
    {
        return view($this->view.'page-thank-you',compact('code'));
    }

    public function logout(Request $request,$code)
    {
        // logout Auth
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // get code merchant
        return redirect()->route('index-store',['code'=>$code]);
    }

    public function forgetPassword($code)
    {
        return view($this->view.'page-forget-password',compact('code'));
    }

    public function checkPhoneNumber(Request $request,$code)
    {
        // validation
        $validator = $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);

        $data = $request->phone_number;
        return view($this->view.'page-otp',compact('data','code'));
    }

    public function inputNewPassword(Request $request,$code)
    {
        $phone_number = $request->phone_number;
        return view($this->view . 'page-new-password',compact('phone_number','code'));
    }

    public function storeNewPassword(Request $request,$code)
    {
        // validation
        $validator = $request->validate([
            'password'  => 'required|confirmed',
        ]);

        $account = User::where('phone_number',$request->phone_number)->first();
        $account->password = bcrypt($request->password);
        $account->save();

        return redirect()->route('login-store',['code'=>$code]);

    }

}
