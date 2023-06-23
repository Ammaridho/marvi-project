<?php

namespace App\Http\Controllers\Arvi\FrontEnd\OobeIndonesia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAddress;

use stdClass;

class ProfileController extends Controller
{
    protected $view = 'arvi.frontend.oobe-indonesia.account.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $saved_address = UserAddress::where('user_id',Auth::user()->id)->get();
        return view($this->view.'page-profile',compact('user','saved_address'));
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
    public function update(Request $request)
    {
        // validation
        if ($request->password) {
            $account = User::find(Auth::user()->id);
            if (Hash::check($request->password_old, $account->password)) {
                $validator = $request->validate([
                    'fname'         => 'required',
                    'phone_number'  => 'required|unique:App\Models\User,phone_number,'.Auth::user()->id,
                    'password_old'  => 'required',
                    'password'      => 'required|confirmed',
                ]);
                $account->name          = $request->fname;
                $account->phone_number  = $request->phone_number;
                $account->address       = $request->address;
                $account->password      = bcrypt($request->password);
                $account->save();
                return redirect()->route('index-oobe');
            }
            else {
                return redirect()->back()->with('error', 'Old Password not match!');
            }

        } else {
            $validator = $request->validate([
                'fname'         => 'required',
                'phone_number'  => 'required|unique:App\Models\User,phone_number,'.Auth::user()->id,
            ]);
            $account = User::find(Auth::user()->id);
            $account->name          = $request->fname;
            $account->phone_number  = $request->phone_number;
            $account->address       = $request->address;
            $account->save();
            return redirect()->route('index-oobe');
        }

    }

    public function savedAddressUpdate(Request $request)
    {
        $saved_address = UserAddress::find($request->id);
        $saved_address->name         = $request->name;
        $saved_address->phone_number = $request->phone_number;
        $saved_address->address      = $request->address;
        $saved_address->notes        = $request->notes;
        $saved_address->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        UserAddress::find($request->id)->delete();
    }
}
