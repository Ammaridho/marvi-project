<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// ARVI ========================================================================================
//index route tanpa qrCode
Route::namespace('Arvi')->group(function(){

    Route::get('/','OTFController@index')->name('basic');

    //OTF route
    Route::get('/m/{qrCode}','OTFController@otfHandler');

    //Add specific context for OTF
    Route::get('/otf/{qrCode}','OTFController@otfHandler');

    // cart view
    Route::post('/otf/cart','CartController@view')->name('view-cart');

    // review
    Route::post('/otf/reviewPost','OTFController@review')->name('review-otf');

    // Book for payment (generally to safe guard request)
    Route::post('/otf/paymentBook','PaymentController@book')->name('payment-book');


    // next step
    // storeArvi (database)
    Route::post('/','TransactionController@storeArvi')->name('storeArvi');

    //proceed
    Route::get('/proceedToPay','TransactionController@proceedToPay');

    // back pack main
    Route::get('/backToMain','TransactionController@backToMain');


    // Dashboard
    Route::prefix('/m/{qrCode}/')->namespace('Dashboard')->group(function(){
        
        //form login dashboard
        // Route::get('/login','AuthController@formLogin')->name('login-form')->middleware('guest');

        // //process login
        Route::post('/login','AuthController@login')->name('login');
        
        // dashboard session =============================================================
        Route::prefix('/dashboard')->group(function()
        {

            //dashboard
            Route::get('/','DashBoardController@index')->name('main-dashboard');

            // forget password
            Route::get('/forgetPassword','AuthController@forgetPassword')->name('forget-password');

            Route::middleware('auth')->group(function()
            {
                //home
                Route::get('/home','DashBoardController@home')->name('home-dashboard');
                
                //orderList
                Route::get('/order','DashBoardController@orderList')->name('order-dashboard');

                //production plan
                Route::get('/productionPlan','DashBoardController@productionPlanList')->name('production-plan-dashboard');
                
                //delivery order point
                Route::get('/deliveryOrderPoint','DashBoardController@deliveryDropPointList')->name('delivery-order-dashboard');
                
                //products
                Route::get('/product','DashBoardController@productList')->name('product-dashboard');

                //logout
                Route::post('/logout','AuthController@logout')->name('logout-dashboard');

            });
        });

    });

});

// Payment

Route::prefix('payment')->namespace('Payment')->group(function () {
    Route::get('/stripe','StripeCheckoutController@sampleTakeMeToStripe');
    Route::get('/stripeVarSample','StripeCheckoutController@sampleTakeMeToStripeVars');

    Route::get('/stripe/success/{arviSessionId}',
        'StripeCheckoutController@onSuccess')->name('stripe-success');
    Route::get('/stripe/failed/{arviSessionId}',
        'StripeCheckoutController@onFailed')->name('stripe-failed');

});



// SUHSHIMOO =================================================================================
Route::prefix('o')->namespace('Sushimoo')->group(function () {

    // index
    Route::get('/','HomeController@index')->name('homeSushimoo');

    // cart
    Route::prefix('cart')->namespace('Cart')->name('cart.')->group(function () {
        Route::get('/','CartController@index');
        Route::post('/{id}','CartController@store')->name('store');
        Route::put('/{id}','CartController@update')->name('edit');
        Route::delete('/{id}/delete','CartController@destroy')->name('delete');
    });

    // menu
    Route::prefix('master-menu')->namespace('MasterMenu')->name('Master-Menu.')->group(function () {

        // list category
        Route::get('/category','MenuController@listCategory')->name('listCategory');
        // choose category
        Route::get('/category/{id}','MenuController@listProduct')->name('listProduct');

        // if choose Product
        Route::get('/product/{id}','MenuController@displayProduct')->name('detailProduct');

    });

});
