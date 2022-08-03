<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabStoreSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Merchant;
use App\Models\User;

use Illuminate\Support\Str;

class TabAccountController extends Controller
{
    // protected $route = 'master-pedagang.pedagangAlamat.';
    protected $view  = 'arvi.backend.store-settings.account.';

    public function index(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $user = User::orderBy('id','desc')->get();
            return view($this->view . 'page-account',
                    compact('qrCode','user'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function form(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $merchants = Merchant::all();
            return view($this->view . 'page-account-add',
                    compact('qrCode','merchants'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function store(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            
            $validatedData = $request->validate([
                'name'      => 'required',
                'email'     => 'required|email',
                'password'  => 'required|confirmed|min:6',
                'role'      => 'required',
                'store'     => 'required',
            ]);

            $user = new User;
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = bcrypt($request->password);
            $user->role     = $request->role;
            $user->remember_token = Str::random(100);
            $user->store_id = json_encode($request->store);
            $user->save();
        }
    }

    public function formUpdate(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            $dataUser = $request->dataUser;
            $merchants = Merchant::all();
            return view($this->view . 'page-account-update',
                    compact('qrCode','merchants','dataUser'));
        }
        return view('arvi.frontend.page-not-available');
    }

    public function update(Request $request)
    {
        $qrCode = $request->qrCode;
        $data = Merchant::getByCode($qrCode);
        if ($data) {
            
            $validatedData = $request->validate([
                'name'      => 'required',
                'email'     => 'required|email',
                'password'  => 'required|confirmed|min:6',
                'role'      => 'required',
                'store'     => 'required',
            ]);

            $idUser = $request->idUser;

            $user = User::find($idUser);
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = bcrypt($request->password);
            $user->role     = $request->role;
            $user->remember_token = Str::random(100);
            $user->store_id = json_encode($request->store);
            $user->save();
        }
    }

    public function delete(Request $request)
    {
        User::find($request->id)->delete();
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
