<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        // validation admin
        $loginData = $request->validate([
            'email_admin' => 'email|required',
            'password_admin' => 'required'
        ]);
        
        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials','status'=>401]);
        }
        
        // for store new account
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials','status'=>401]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json(['name' => auth()->user()->name, 'access_token' => $accessToken]);

    }
}
