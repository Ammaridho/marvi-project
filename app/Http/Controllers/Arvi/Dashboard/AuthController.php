<?php

namespace App\Http\Controllers\Arvi\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\user;
use App\Models\Merchant;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    
    public function formLogin(Request $request)
    {
        $qrCode = $request->qrCode;
        session(['qrCode' => $qrCode]);
        return view('arvi.backend.index',compact('qrCode'));
    }

    public function login(Request $request)
    {
        // validation
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        // get code merchant
        $qrCode = $request->qrCode;
        // check
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->flash('success','success login');
            return redirect()->intended("/m/"."$qrCode"."/dashboard")->with(['success' => 'Login Success!']);
        }
        return redirect()->route('main-dashboard',['qrCode' => $qrCode])->with(['error' => 'Login Failed!']);
    }

    public function forgetPassword(Request $request)
    {
        $qrCode = $request->qrCode;
        return view('arvi.backend.page-forget',compact('qrCode'));
    }

    public function logout(Request $request)
    {
        // logout Auth
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // get code merchant
        $qrCode = $request->qrCode;
        return redirect()->route('main-dashboard',['qrCode' => $qrCode])->with(['success' => 'Berhasil Logout!']);
    }

}
