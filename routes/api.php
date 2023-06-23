<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('API')->group(function ()
{
    // store
    Route::prefix('/store/{storeCode}')->group(function () {
        Route::get('/detail', 'ArController@store')->middleware('auth:api');
        Route::get('/products', 'ArController@product')->middleware('auth:api');
        // store ar with stripe payment
        Route::post('/create-payment/stripe','ArController@storeDataAndPaymentProviderUrl');
    });

    Route::prefix('/auth')->group(function () {
        // Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
    });
    // promo
    Route::prefix('/promo/{storeCode}')->group(function () {
        // check
        Route::post('/validate','PromoController@check');
    });    
});

