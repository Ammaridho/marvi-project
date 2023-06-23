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

// ARVI ========================================================================================
//index route tanpa qrCode
Route::namespace('Arvi')->group(function(){

    // dashboard session =============================================================
    Route::prefix('/dashboard')->namespace('Dashboard')->group(function()
    {

        Route::middleware('checkAlreadyLogin')->group(function()
        {
            // index
            Route::get('/','AuthController@index')->name('index');

            // login form
            Route::get('/login','AuthController@formLogin')->name('login');
            Route::post('/','AuthController@login')->name('login');

            // forget password
            Route::prefix('/forget-password')->group(function()
            {
                Route::get('/','AuthController@forgetPassword')->name('forget-password-dashboard');
                Route::post('/','AuthController@checkPhoneNumber')->name('check-number-dashboard');
                Route::get('/store-new-password','AuthController@inputNewPassword')
                ->name('store-new-password-dashboard');
                Route::post('/store-new-password','AuthController@storeNewPassword')
                ->name('store-new-password-dashboard');
                Route::get('/store-new-password-success','AuthController@storeNewPasswordSuccess')
                ->name('store-new-password-dashboard-success');
            });

            // sign up
            Route::prefix('/sign-up')->group(function()
            {
                // buka form
                Route::get('/','AuthController@formSignUp')->name('sign-up');
                Route::post('/sign-up-check-data','AuthController@formSignUpCheckData')
                ->name('sign-up-check-data');
                // otp
                Route::get('/otp-register','AuthController@otpRegister')->name('otp-register');
                // store and thankyoupage
                Route::post('/','AuthController@storeSignUp')->name('sign-up-store');
                // thankyou page
                Route::get('/thankyou-page','AuthController@thankyouPage')->name('thankyou-page');
            });
        });

        Route::middleware('auth','checkAccountAndRole:admin,viewer,superadmin')->group(function()
        {
            // //process choose company
            Route::get('/choose-company','DashBoardController@chooseCompany')->name('choose-company');

            Route::prefix('/c/{companyCode}/')->group(function(){

                //dashboard
                Route::get('/','DashBoardController@index')->name('main-dashboard');
                
                // update last display time
                Route::get('/update-time','DashBoardController@updateTime')->name('update-time');

                //home
                // manage brand
                Route::namespace('TabDashboard')->group(function (){
                    Route::get('/home','DashboardController@index')->name('home-dashboard');
                });

                Route::namespace('TabInsights')->group(function (){
                Route::get('/insight/sales','InsightSalesController@index')->name('insight-sales-dashboard');
                Route::get('/insight/qr','InsightQrController@index')->name('insight-qr-dashboard');
                Route::get('/insight/qr/detail','InsightQrController@show')->name('insight-qr-dashboard-show');
                });

                // orderList
                Route::get('/order-list','OrderListController@index')->name('orderList-dashboard');
                // detailOrderList
                Route::get('/order-detail','OrderListController@show')->name('order-detail-dashboard');
                // update status order
                Route::put('/order-list/update','OrderListController@updateStatusOrder')->name('update-status-order');
                
                // pos
                Route::namespace('TabPOS')->group(function(){
                    Route::get('/pos','TabPOSController@index')->name('pos-dashboard');
                    // select category product
                    Route::get('/pos/category','TabPOSController@category')->name('pos-dashboard-category');
                    // add product
                    Route::get('/pos/add-product','TabPOSController@addProduct')->name('pos-dashboard-add-product');
                    // detail order
                    Route::get('/pos/detail-order','TabPOSController@detailOrder')->name('pos-dashboard-detail-order');
                    // choose payment
                    Route::get('/pos/payment','TabPOSController@choosePayment')->name('pos-choose-payment');
                    // store order
                    Route::post('/pos/payment','TabPOSController@storePOS')->name('pos-store-order');
                    // sent email
                    Route::post('/pos/sent-email','TabPOSController@setEmail')->name('pos-set-email');
                    // sent callback
                    Route::post('/pos/check-callback','TabPOSController@checkPaymentCallback')->name('pos-check-payment-callback');
                    // page success
                    Route::get('/pos/success','TabPOSController@success')->name('pos-payment-success');
                    // page cancel payment
                    Route::post('/pos/cancel-payment','TabPOSController@cancelPayment')->name('pos-cancel-payment');
                    // page failed
                    Route::get('/pos/failed','TabPOSController@failed')->name('pos-payment-failed');
                });

                // reports
                Route::namespace('TabReports')->group(function(){

                    //orderList
                    Route::get('/order','TabOrderController@orderList')->name('order-dashboard');
                    //pagination
                    Route::post('/order/paginationFetch','TabOrderController@orderListFetch')
                    ->name('order-paginationfetch');
                    //export orderlist to excel
                    Route::get('/order/export','TabOrderController@OrderListExportExcel')
                    ->name('order-list-export-excel');

                    //production plan
                    Route::get('/productionPlan','TabProductionPlanController@productionPlanList')
                    ->name('production-plan-dashboard');
                    //export orderlist to excel
                    Route::get('/productionPlan/export','TabProductionPlanController@ProductionPlanExportExcel')
                    ->name('production-plan-export-excel');

                    //delivery drop point
                    Route::get('/deliveryOrderPoint','TabDeliveryDropPointController@deliveryDropPointList')
                    ->name('delivery-order-dashboard');
                    //Sort Date
                    Route::get('/deliveryOrderPoint/sorting','TabDeliveryDropPointController@sortDate')
                    ->name('sortDate-delivery-order-dashboard');
                    //detail product
                    Route::get('/deliveryOrderPoint/detailProduct','TabDeliveryDropPointController@detailProduct')
                    ->name('detail-quantity-delivery-order-dashboard');
                    //export deliverydroppoint to excel
                    Route::get('/deliveryOrderPoint/export', 'TabDeliveryDropPointController@deliveryDropPointListExportExcel')
                    ->name('delivery-drop-point-export-excel');

                });

                Route::middleware('checkAccountAndRole:admin,superadmin')->group(function()
                {
                    // manage brand
                    Route::namespace('TabManageBrand')->group(function (){

                        Route::prefix('/manage-brand')->group(function (){
                            // display
                            Route::get('/','TabManageBrandController@index')->name('manage-brand-list');
                            // form insert
                            Route::get('/create','TabManageBrandController@create')->name('manage-brand-create');
                            // brand
                            Route::post('/store','TabManageBrandController@store')->name('manage-brand-store');
                            // form edit
                            Route::get('/edit','TabManageBrandController@edit')->name('manage-brand-edit');
                            // update
                            Route::put('/update','TabManageBrandController@update')->name('manage-brand-update');
                            // destroy
                            Route::delete('/{brandId?}/destroy-brand','TabManageBrandController@destroy')->name('manage-brand-destroy');

                            Route::prefix('/brand-category')->group(function(){

                                // display
                                Route::get('/','BrandCategoryController@index')->name('brand-category-list');
                                // form insert
                                Route::get('/create','BrandCategoryController@create')->name('brand-category-create');
                                // store
                                Route::post('/store','BrandCategoryController@store')->name('brand-category-store');
                                // form edit
                                Route::get('/edit','BrandCategoryController@edit')->name('brand-category-edit');
                                // update
                                Route::put('/update','BrandCategoryController@update')->name('brand-category-update');
                                // destroy
                                Route::delete('/destroy','BrandCategoryController@destroy')->name('brand-category-destroy');

                            });
                            Route::prefix('/brand-product')->group(function(){

                                // display
                                Route::get('/','BrandProductController@index')->name('brand-product-list');
                                // form insert
                                Route::get('/create','BrandProductController@create')->name('brand-product-create');
                                // store
                                Route::post('/store','BrandProductController@store')->name('brand-product-store');
                                // form edit
                                Route::get('/edit','BrandProductController@edit')->name('brand-product-edit');
                                // update
                                Route::put('/update','BrandProductController@update')->name('brand-product-update');
                                // destroy
                                Route::delete('/destroy','BrandProductController@destroy')->name('brand-product-destroy');

                            });
                            Route::prefix('/brand-extra-attribute')->group(function(){

                                // display
                                Route::get('/','BrandExtraAttributeController@index')->name('brand-extra-attribute-list');
                                // show data table
                                Route::get('/show-data','BrandExtraAttributeController@showData')->name('brand-extra-attribute-list-table');
                                // form insert
                                Route::get('/create','BrandExtraAttributeController@create')->name('brand-extra-attribute-create');
                                // store
                                Route::post('/store','BrandExtraAttributeController@store')->name('brand-extra-attribute-store');
                                // form edit
                                Route::get('/edit','BrandExtraAttributeController@edit')->name('brand-extra-attribute-edit');
                                // update
                                Route::put('/update','BrandExtraAttributeController@update')->name('brand-extra-attribute-update');
                                // destroy
                                Route::delete('/destroy','BrandExtraAttributeController@destroy')->name('brand-extra-attribute-destroy');

                            });

                        });
                    });

                    // manage store
                    Route::namespace('TabManageStore')->group(function(){

                        Route::prefix('/manage-store')->group(function(){
                            // display
                            Route::get('/','TabManageStoreController@index')->name('manage-store-list');
                            // show data table
                            Route::get('/show-data','TabManageStoreController@showData')->name('store-list-table');
                            // form insert
                            Route::get('/create','TabManageStoreController@create')->name('manage-store-create');
                            // store
                            Route::post('/store','TabManageStoreController@store')->name('manage-store-store');
                            // form edit
                            Route::get('/edit','TabManageStoreController@edit')->name('manage-store-edit');
                            // update
                            Route::put('/update','TabManageStoreController@update')->name('manage-store-update');
                            // destroy
                            Route::delete('/{merchantId}/destroy-merchant','TabManageStoreController@destroy')->name('manage-store-destroy');

                            Route::prefix('/hours')->group(function(){

                                // display
                                Route::get('/','MerchantHoursController@index')->name('hours-list');
                                // form insert
                                Route::get('/create','MerchantHoursController@create')->name('hours-create');
                                // store
                                Route::post('/store','MerchantHoursController@store')->name('hours-store');
                                // form edit
                                Route::get('/edit','MerchantHoursController@edit')->name('hours-edit');
                                // update
                                Route::put('/update','MerchantHoursController@update')->name('hours-update');
                                // destroy
                                Route::delete('/destroy','MerchantHoursController@destroy')->name('hours-destroy');

                            });
                            Route::prefix('/fulfilment')->group(function(){

                                // display
                                Route::get('/','MerchantFulfilmentController@index')->name('fulfilment-list');
                                // form insert
                                Route::get('/create','MerchantFulfilmentController@create')->name('fulfilment-create');
                                // store
                                Route::post('/store','MerchantFulfilmentController@store')->name('fulfilment-store');
                                // form edit
                                Route::get('/edit','MerchantFulfilmentController@edit')->name('fulfilment-edit');
                                // update
                                Route::put('/update','MerchantFulfilmentController@update')->name('fulfilment-update');
                                // destroy
                                Route::delete('/destroy','MerchantFulfilmentController@destroy')->name('fulfilment-destroy');

                            });
                            Route::prefix('/category')->group(function(){

                                // display
                                Route::get('/','MerchantCategoryController@index')->name('category-list');
                                // form insert
                                Route::get('/create','MerchantCategoryController@create')->name('category-create');
                                // store
                                Route::post('/store','MerchantCategoryController@store')->name('category-store');
                                // form edit
                                Route::get('/edit','MerchantCategoryController@edit')->name('category-edit');
                                // update
                                Route::put('/update','MerchantCategoryController@update')->name('category-update');
                                // destroy
                                Route::delete('/destroy','MerchantCategoryController@destroy')->name('category-destroy');

                            });
                            Route::prefix('/product')->group(function(){

                                // display
                                Route::get('/','MerchantProductController@index')->name('merchant-product-list');
                                // form insert
                                Route::get('/create','MerchantProductController@create')->name('merchant-product-create');
                                // store
                                Route::post('/store','MerchantProductController@store')->name('merchant-product-store');
                                // form edit
                                Route::get('/edit','MerchantProductController@edit')->name('merchant-product-edit');
                                // update
                                Route::put('/update','MerchantProductController@update')->name('merchant-product-update');
                                // destroy
                                Route::delete('/destroy','MerchantProductController@destroy')->name('merchant-product-destroy');

                            });

                            Route::prefix('/extra-attribute')->group(function(){

                                // display
                                Route::get('/','MerchantExtraAttributeController@index')->name('extra-attribute-list');
                                // show data table
                                Route::get('/show-data','MerchantExtraAttributeController@showData')->name('extra-attribute-list-table');
                                // form insert
                                Route::get('/create','MerchantExtraAttributeController@create')->name('extra-attribute-create');
                                // store
                                Route::post('/store','MerchantExtraAttributeController@store')->name('extra-attribute-store');
                                // form edit
                                Route::get('/edit','MerchantExtraAttributeController@edit')->name('extra-attribute-edit');
                                // update
                                Route::put('/update','MerchantExtraAttributeController@update')->name('extra-attribute-update');
                                // destroy
                                Route::delete('/destroy','MerchantExtraAttributeController@destroy')->name('extra-attribute-destroy');

                            });

                        });

                    });

                    // tab manage accounts store
                    Route::namespace('TabManageAccounts')->group(function (){

                        Route::prefix('/account')->group(function () {
                            // display
                            Route::get('/', 'TabManageAccountController@index')->name('account-list');
                            // form insert
                            Route::get('/create', 'TabManageAccountController@create')->name('account-create');
                            // merchant appear
                            Route::get('/mechant-appear', 'TabManageAccountController@merchantAppear')->name('account-create-merchant-appear');
                            // store
                            Route::post('/store', 'TabManageAccountController@store')->name('account-store');
                            // form edit
                            Route::get('/edit', 'TabManageAccountController@edit')->name('account-edit');
                            // update
                            Route::put('/update', 'TabManageAccountController@update')->name('account-update');
                            // destroy
                            Route::delete('/destroy', 'TabManageAccountController@destroy')->name('account-destroy');
                        });

                    });

                    // tab discount
                    Route::namespace('TabDiscount')->group(function (){

                        Route::prefix('/discount')->group(function(){
                            // display
                            Route::get('/','TabDiscountController@index')->name('discount-list');
                            // form insert
                            Route::get('/create','TabDiscountController@create')->name('discount-create');
                            // store
                            Route::post('/store','TabDiscountController@store')->name('discount-store');
                            // form edit
                            Route::get('/edit','TabDiscountController@edit')->name('discount-edit');
                            // update
                            Route::put('/update','TabDiscountController@update')->name('discount-update');
                            // destroy
                            Route::delete('/destroy','TabDiscountController@destroy')->name('discount-destroy');
                        });

                    });

                    // tab store settings
                    Route::namespace('TabStoreSettings')->group(function (){

                        Route::prefix('/store-front')->group(function(){
                            // display
                            Route::get('/','TabStoreFrontController@index')->name('Store-front-data');
                            // form insert
                            Route::get('/form','TabStoreFrontController@form')->name('Store-front-form');
                            // store
                            Route::post('/form','TabStoreFrontController@store')->name('Store-front-store');
                            // form update
                            Route::get('/formUpdate','TabStoreFrontController@formUpdate')->name('Store-front-from-update');
                            // update
                            Route::put('/formUpdate','TabStoreFrontController@update')->name('Store-front-update');
                            // delete
                            Route::delete('/form','TabStoreFrontController@delete')->name('Store-front-delete');
                        });

                        Route::prefix('/fees')->group(function(){
                            // display
                            Route::get('/','TabFeesController@index')->name('fees-data');
                            // form insert
                            Route::get('/create','TabFeesController@create')->name('fees-create');
                            // store
                            Route::post('/store','TabFeesController@store')->name('fees-store');
                            // form update
                            Route::get('/edit','TabFeesController@edit')->name('fees-edit');
                            // update
                            Route::put('/update','TabFeesController@update')->name('fees-update');
                            // delete
                            Route::delete('/destroy','TabFeesController@destroy')->name('fees-destroy');
                        });

                    });

                    Route::namespace('TabHelpCenter')->group(function (){
                        // help center
                    });

                    Route::namespace('TabProducts')->group(function (){

                        //products
                        Route::get('/product','TabProductListController@index')
                        ->name('product-dashboard');
                        //products fetch
                        Route::post('/product/paginationFetch','TabProductListController@indexFetch')
                        ->name('product-dashboard-paginationfetch');

                        // edit product
                        Route::post('/product/edit','TabProductListController@edit')->name('product-edit');

                    });
                });

            });

            //logout
            Route::post('/logout','AuthController@logout')->name('logout-dashboard');

            //open settings
            Route::get('/setting','AuthController@settings')->name('setting-account-dashboard');
            //store settings
            Route::put('/setting','AuthController@storeSettings')->name('setting-account-dashboard');

            Route::middleware('checkAccountAndRole:superadmin')->namespace('SuperAdmin')->group(function ()
            {
                // superAdmin dashboard
                Route::get('/super-admin','SuperAdminDashboardController@index')->name('super-admin-main-dashboard');

                Route::namespace('TabAdministration')->group(function ()
                {
                    // manage company
                    Route::prefix('/company')->group(function(){
                        // display
                        Route::get('/','CompanyController@index')->name('company-list');
                        // show data table
                        Route::get('/show-data','CompanyController@showData')->name('company-list-table');
                        // form insert
                        Route::get('/create','CompanyController@create')->name('company-create');
                        // store
                        Route::post('/store','CompanyController@store')->name('company-store');
                        // form edit
                        Route::get('/edit','CompanyController@edit')->name('company-edit');
                        // update
                        Route::put('/update','CompanyController@update')->name('company-update');
                        // destroy
                        Route::delete('/destroy','CompanyController@destroy')->name('company-destroy');
                    });

                    // manage account admin
                    Route::prefix('/account-admin')->group(function(){
                        // display
                        Route::get('/','AccountAdminController@index')->name('account-admin-list');
                        // show data table
                        Route::get('/show-data','AccountAdminController@showData')->name('account-admin-list-table');
                        // form insert
                        Route::get('/create','AccountAdminController@create')->name('account-admin-create');
                        // brand appear
                        Route::get('/brand-appear', 'AccountAdminController@brandAppear')->name('account-admin-create-brand-appear');
                        // merchant appear
                        Route::get('/mechant-appear', 'AccountAdminController@merchantAppear')->name('account-admin-create-merchant-appear');
                        // store
                        Route::post('/store','AccountAdminController@store')->name('account-admin-store');
                        // form edit
                        Route::get('/edit','AccountAdminController@edit')->name('account-admin-edit');
                        // update
                        Route::put('/update','AccountAdminController@update')->name('account-admin-update');
                        // destroy
                        Route::delete('/destroy','AccountAdminController@destroy')->name('account-admin-destroy');
                    });
                });

                Route::namespace('TabManageLocation')->group(function ()
                {
                    // manage location admin
                    Route::prefix('/location')->group(function(){
                        // display
                        Route::get('/','LocationController@index')->name('location-list');
                        // show data table
                        Route::get('/show-data','LocationController@showData')->name('location-list-table');
                        // form insert
                        Route::get('/create','LocationController@create')->name('location-create');
                        // store
                        Route::post('/store','LocationController@store')->name('location-store');
                        // form edit
                        Route::get('/edit','LocationController@edit')->name('location-edit');
                        // update
                        Route::put('/update','LocationController@update')->name('location-update');
                        // destroy
                        Route::delete('/destroy','LocationController@destroy')->name('location-destroy');
                    });
                });

                Route::namespace('TabManageSquad')->group(function ()
                {

                    // manage squad-account admin
                    Route::prefix('/squad-account')->group(function(){
                        // display
                        Route::get('/','SquadAccountController@index')->name('squad-account-list');
                        // show data table
                        Route::get('/show-data','SquadAccountController@showData')->name('squad-account-list-table');
                        // form insert
                        Route::get('/create','SquadAccountController@create')->name('squad-account-create');
                        // store
                        Route::post('/store','SquadAccountController@store')->name('squad-account-store');
                        // form edit
                        Route::get('/edit','SquadAccountController@edit')->name('squad-account-edit');
                        // update
                        Route::put('/update','SquadAccountController@update')->name('squad-account-update');
                        // destroy
                        Route::delete('/destroy','SquadAccountController@destroy')->name('squad-account-destroy');
                    });

                    // manage squad-settlement admin
                    Route::prefix('/squad-settlement')->group(function(){
                        // display
                        Route::get('/','SquadSettlementController@index')->name('squad-settlement-list');
                        // show data table
                        Route::get('/show-data','SquadSettlementController@show')->name('squad-settlement-list-table');
                        // form insert
                        Route::get('/create','SquadSettlementController@create')->name('squad-settlement-create');
                        // store
                        Route::post('/store','SquadSettlementController@store')->name('squad-settlement-store');
                        // form edit
                        Route::get('/edit','SquadSettlementController@edit')->name('squad-settlement-edit');
                        // update
                        Route::put('/update','SquadSettlementController@update')->name('squad-settlement-update');
                        // destroy
                        Route::delete('/destroy','SquadSettlementController@destroy')->name('squad-settlement-destroy');
                    });

                });

                Route::namespace('TabMarketing')->group(function ()
                {
                    // manage banner admin
                    Route::prefix('/banner')->group(function(){
                        // display
                        Route::get('/','BannerController@index')->name('banner-list');
                        // show data table
                        Route::get('/show-data','BannerController@showData')->name('banner-list-table');
                        // form insert
                        Route::get('/create','BannerController@create')->name('banner-create');
                        // store
                        Route::post('/store','BannerController@store')->name('banner-store');
                        // form edit
                        Route::get('/edit','BannerController@edit')->name('banner-edit');
                        // update
                        Route::put('/update','BannerController@update')->name('banner-update');
                        // destroy
                        Route::delete('/destroy','BannerController@destroy')->name('banner-destroy');
                    });
                    // manage QR admin
                    Route::prefix('/qr')->group(function(){
                        // display
                        Route::get('/','QrController@index')->name('qr-list');
                        // show data table
                        Route::get('/show-data','QrController@showData')->name('qr-list-table');
                        // form insert
                        Route::get('/create','QrController@create')->name('qr-create');
                        // store
                        Route::post('/store','QrController@store')->name('qr-store');
                        // download qr
                        Route::get('/download','QrController@download')->name('poster-download');
                        // custom qr
                        Route::get('/custom-layout','QrController@formCustomQr')->name('poster-qr-form-custom-layout');
                        // update custom qr
                        Route::post('/update-layout','QrController@updateLayoutQr')->name('poster-qr-update-layout');
                        // form edit
                        Route::get('/edit','QrController@edit')->name('qr-edit');
                        // update
                        Route::put('/update','QrController@update')->name('qr-update');
                        // destroy
                        Route::delete('/destroy','QrController@destroy')->name('qr-destroy');
                    });
                    // manage AR admin
                    Route::prefix('/ar')->group(function(){
                        // display
                        Route::get('/','ArController@index')->name('ar-list');
                        // show data table
                        Route::get('/show-data','ArController@showData')->name('ar-list-table');
                        // form insert
                        Route::get('/create','ArController@create')->name('ar-create');
                        // store
                        Route::post('/store','ArController@store')->name('ar-store');
                        // form edit
                        Route::get('/edit','ArController@edit')->name('ar-edit');
                        // update
                        Route::put('/update','ArController@update')->name('ar-update');
                        // destroy
                        Route::delete('/destroy','ArController@destroy')->name('ar-destroy');
                    });

                });

                Route::namespace('TabFulfilment')->group(function ()
                {
                    // manage squad-account admin
                    Route::prefix('/delivery')->group(function(){
                        // display
                        Route::get('/','DeliveryController@index')->name('delivery-list');
                        // show data table
                        Route::get('/show-data','DeliveryController@showData')->name('delivery-list-table');
                        // form insert
                        Route::get('/create','DeliveryController@create')->name('delivery-create');
                        // store
                        Route::post('/store','DeliveryController@store')->name('delivery-store');
                        // form edit
                        Route::get('/edit','DeliveryController@edit')->name('delivery-edit');
                        // update
                        Route::put('/update','DeliveryController@update')->name('delivery-update');
                        // destroy
                        Route::delete('/destroy','DeliveryController@destroy')->name('delivery-destroy');
                    });

                });

            });
        });

        

    });

    // FrontEnd session =============================================================
    Route::namespace('FrontEnd')->group(function()
    {

        // bootstrap session =============================================================
        Route::namespace('Bootstrap')->group(function()
        {

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

            // Payment
            Route::prefix('payment')->namespace('Payment')->group(function () {
                Route::get('/stripe','StripeCheckoutController@sampleTakeMeToStripeHarcode');
                Route::get('/stripeVarSample','StripeCheckoutController@sampleTakeMeToStripeVars');

                Route::get('/stripe/success/{arviSessionId}',
                    'StripeCheckoutController@onSuccess')->name('stripe-success');
                Route::get('/stripe/failed/{arviSessionId}',
                    'StripeCheckoutController@onFailed')->name('stripe-failed');

            });
        });

        // Frontend oobe-indonesia =======================================================
        Route::prefix('/oobe-indonesia')->namespace('OobeIndonesia')->group(function ()
        {                
            
            // index
            Route::get('/','HomeController@index')->name('index-oobe');

            // about us
            Route::get('/about-us','HomeController@about')->name('about-us');

            // tnc and pp
            Route::get('/tnc','HomeController@tnc')->name('tnc');
            Route::get('/pp','HomeController@pp')->name('pp');

            // profile
            Route::prefix('/profile')->group(function(){
                Route::get('/','ProfileController@index')->name('profile');
                Route::post('/','ProfileController@update')->name('profile-update');
                Route::put('/saved-address','ProfileController@savedAddressUpdate')->name('saved-address-update');
                Route::delete('/saved-address','ProfileController@destroy')->name('saved-address-delete');
            });

            //signin
            Route::prefix('/account')->group(function(){
                Route::get('/','AuthController@index')->name('login-oobe-indonesia');
                Route::post('/','AuthController@login')->name('login-oobe-indonesia');

                Route::get('/signup','AuthController@create')->name('signup-oobe-indonesia');
                Route::post('/signup','AuthController@store')->name('store-oobe-indonesia');
                Route::get('/thankyou','AuthController@thankyou')->name('thankyou-oobe-indonesia');

                Route::get('/logout','AuthController@logout')->name('logout-oobe-indonesia');

                Route::post('/otp','AuthController@otp')->name('otp-oobe-indonesia');

                Route::get('/forget-password','AuthController@forgetPassword')->name('forget-password-oobe-indonesia');
                Route::post('/forget-password','AuthController@checkPhoneNumber')->name('check-number-oobe-indonesia');
                Route::get('/store-new-password','AuthController@inputNewPassword')->name('store-new-password-oobe-indonesia');
                Route::post('/store-new-password','AuthController@storeNewPassword')->name('store-new-password-oobe-indonesia');
            });

            // search
            Route::prefix('/search')->group(function(){
                Route::get('/','SearchController@index')->name('search-oobe-indonesia');
            });

            // store
            Route::prefix('/store')->group(function(){
                // open store, list product
                Route::get('/','StoreOrderController@index')->name('index-store-order');
                // open detail product to order
                Route::get('/show','StoreOrderController@show')->name('show-store-order');
                // open store order
                Route::post('/','StoreOrderController@store')->name('store-store-order');
            });

            // shopping cart
            Route::prefix('/shopping-cart')->group(function(){
                // open shopping-cart, list product
                Route::get('/','ShoppingCartController@index')->name('index-shopping-cart');
                // open detail product to order
                Route::get('/show','ShoppingCartController@show')->name('show-shopping-cart');
                // open shopping-cart order
                Route::post('/','ShoppingCartController@shopping-cart')->name('shopping-cart-shopping-cart');
            });

            // checkout
            Route::prefix('/checkout')->group(function(){
                // route checkout list
                Route::post('/check-out','CheckOutController@index')->name('list-checkout');
                Route::post('/delivery-order','CheckOutController@deliveryOrder')->name('delivery-checkout');
                Route::get('/search-district','CheckOutController@searchDistrict')->name('search-district');
                Route::get('/check-rates','CheckOutController@checkRates')->name('check-rates');
                Route::post('/payment-order','CheckOutController@paymentOrder')->name('payment-checkout');
                Route::get('/payment','CheckOutController@index')->name('payment-index');
                Route::post('/payment-process','CheckOutController@paymentProcess')->name('payment-process');
                Route::post('/payment-store','CheckOutController@store')->name('payment-store');
                
                // payment process
                Route::get('/payment-store/detail','CheckOutController@detail')->name('payment-store-detail');

                Route::get('/payment-store/generate-cash','CheckOutController@generateCash')->name('payment-store-generate-cash');
                Route::get('/payment-store/generate-qr','CheckOutController@generateQr')->name('payment-store-generate-qr');
                Route::get('/payment-store/generate-ew','CheckOutController@generateEw')->name('payment-store-generate-ew');
                Route::get('/payment-store/generate-va','CheckOutController@generateVa')->name('payment-store-generate-va');
                Route::get('/payment-store/generate-ro','CheckOutController@generateRo')->name('payment-store-generate-ro');
                
                Route::get('/payment-store/invoice','CheckOutController@invoice')->name('payment-invoice');

                Route::post('/payment-store/check-payment-callback','CheckOutController@checkPaymentCallback')->name('check-payment-callback');
                
                Route::get('/payment-store/pending','CheckOutController@pending')->name('payment-store-pending');
                Route::get('/payment-store/success','CheckOutController@success')->name('payment-store-success');
                Route::get('/payment-store/failed','CheckOutController@failed')->name('payment-store-failed');

                
            });

            // my order
            Route::prefix('/my-order')->group(function(){
                Route::get('/','MyOrderController@index')->name('my-order-index');
                Route::get('/detail','MyOrderController@show')->name('my-order-index-detail');
            });
        });

        // location ======================================================================
        Route::prefix('/area/{code}')->namespace('Area')->group(function ()
        {
            // index
            Route::get('/','HomeController@index')->name('index-area');

            // tnc and pp
            Route::get('/tnc','HomeController@tnc')->name('tnc-area');
            Route::get('/pp','HomeController@pp')->name('pp-area');

            // profile
            Route::prefix('/profile')->group(function(){
                Route::get('/','ProfileController@index')->name('profile-area');
                Route::post('/','ProfileController@update')->name('profile-update-area');
                Route::put('/saved-address','ProfileController@savedAddressUpdate')->name('saved-address-update-area');
                Route::delete('/saved-address','ProfileController@destroy')->name('saved-address-delete-area');
            });

            //signin
            Route::prefix('/account')->group(function(){
                Route::get('/','AuthController@index')->name('login-area');
                Route::post('/','AuthController@login')->name('login-area');

                Route::get('/signup','AuthController@create')->name('signup-area');
                Route::post('/signup','AuthController@store')->name('store-area');
                Route::get('/thankyou','AuthController@thankyou')->name('thankyou-area');

                Route::get('/logout','AuthController@logout')->name('logout-area');

                Route::post('/otp','AuthController@otp')->name('otp-area');

                Route::get('/forget-password','AuthController@forgetPassword')->name('forget-password-area');
                Route::post('/forget-password','AuthController@checkPhoneNumber')->name('check-number-area');
                Route::get('/store-new-password','AuthController@inputNewPassword')->name('store-new-password-area');
                Route::post('/store-new-password','AuthController@storeNewPassword')->name('store-new-password-area');
            });

            // search
            Route::prefix('/search')->group(function(){
                Route::get('/','SearchController@index')->name('search-area');
            });

            // store
            Route::prefix('/store')->group(function(){
                // open store, list product
                Route::get('/','StoreOrderController@index')->name('index-store-order-area');
                // open detail product to order
                Route::get('/show','StoreOrderController@show')->name('show-store-order-area');
                // open store order
                Route::post('/','StoreOrderController@store')->name('store-store-order-area');
            });

            // shopping cart
            Route::prefix('/shopping-cart')->group(function(){
                // open shopping-cart, list product
                Route::get('/','ShoppingCartController@index')->name('index-shopping-cart-area');
                // open detail product to order
                Route::get('/show','ShoppingCartController@show')->name('show-shopping-cart-area');
                // open shopping-cart order
                Route::post('/','ShoppingCartController@shopping-cart')->name('shopping-cart-shopping-cart-area');
            });

            // checkout
            Route::prefix('/checkout')->middleware(['cors'])->group(function(){
                // route checkout list
                Route::post('/check-out','CheckOutController@index')->name('list-checkout-area');
                Route::post('/delivery-order','CheckOutController@deliveryOrder')->name('delivery-checkout-area');
                Route::post('/payment-order','CheckOutController@paymentOrder')->name('payment-checkout-area');
                Route::get('/payment','CheckOutController@index')->name('payment-index-area');
                Route::post('/payment-store','CheckOutController@store')->name('payment-store-area');
                Route::get('/payment-store/pending','CheckOutController@pending')->name('payment-store-pending-area');
            });

            // my order
            Route::prefix('/my-order')->group(function(){
                Route::get('/','MyOrderController@index')->name('my-order-index-area');
                Route::get('/detail','MyOrderController@show')->name('my-order-index-detail-area');
            });

        });

        // store ======================================================================
        Route::prefix('/store/{code}')->namespace('Store')->group(function ()
        {
            // about us
            Route::get('/about-us','HomeController@about')->name('about-us-store');

            // tnc and pp
            Route::get('/tnc','HomeController@tnc')->name('tnc-store');
            Route::get('/pp','HomeController@pp')->name('pp-store');

            // profile
            Route::prefix('/profile')->group(function(){
                Route::get('/','ProfileController@index')->name('profile-store');
                Route::post('/','ProfileController@update')->name('profile-update-store');
                Route::put('/saved-address','ProfileController@savedAddressUpdate')->name('saved-address-update-store');
                Route::delete('/saved-address','ProfileController@destroy')->name('saved-address-delete-store');
            });

            //signin
            Route::prefix('/account')->group(function(){
                Route::get('/','AuthController@index')->name('login-store');
                Route::post('/','AuthController@login')->name('login-store');

                Route::get('/signup','AuthController@create')->name('signup-store');
                Route::post('/signup','AuthController@store')->name('store-store');
                Route::get('/thankyou','AuthController@thankyou')->name('thankyou-store');

                Route::get('/logout','AuthController@logout')->name('logout-store');

                Route::post('/otp','AuthController@otp')->name('otp-store');

                Route::get('/forget-password','AuthController@forgetPassword')->name('forget-password-store');
                Route::post('/forget-password','AuthController@checkPhoneNumber')->name('check-number-store');
                Route::get('/store-new-password','AuthController@inputNewPassword')->name('store-new-password-store');
                Route::post('/store-new-password','AuthController@storeNewPassword')->name('store-new-password-store');
            });

            // search
            Route::prefix('/search')->group(function(){
                Route::get('/','SearchController@index')->name('search-store');
            });

            // store
            // open store, list product
            Route::get('/','StoreOrderController@index')->name('index-store');
            // open detail product to order
            Route::get('/show','StoreOrderController@show')->name('show-store-order-store');
            // open store order
            Route::post('/','StoreOrderController@store')->name('store-store-order-store');

            // shopping cart
            Route::prefix('/shopping-cart')->group(function(){
                // open shopping-cart, list product
                Route::get('/','ShoppingCartController@index')->name('index-shopping-cart-store');
                // open detail product to order
                Route::get('/show','ShoppingCartController@show')->name('show-shopping-cart-store');
                // open shopping-cart order
                Route::post('/','ShoppingCartController@shopping-cart')->name('shopping-cart-shopping-cart-store');
            });

            // checkout
            Route::prefix('/checkout')->group(function(){

                 // route checkout list
                 Route::post('/check-out','CheckOutController@index')->name('list-checkout-store');
                 Route::post('/delivery-order','CheckOutController@deliveryOrder')->name('delivery-checkout-store');
                 Route::get('/delivery-order','StoreOrderController@index');
                 Route::post('/payment-order','CheckOutController@paymentOrder')->name('payment-checkout-store');
                 Route::get('/payment-order','StoreOrderController@index');
                 Route::post('/payment-process','CheckOutController@paymentProcess')->name('payment-process-store');
                 Route::post('/payment-store','CheckOutController@store')->name('payment-store-store');
                 
                 // payment process
                 Route::get('/payment-store/detail','CheckOutController@detail')->name('payment-store-detail-store');

                 Route::get('/payment-store/generate-cash','CheckOutController@generateCash')->name('payment-store-generate-cash-store');
                 Route::get('/payment-store/generate-qr','CheckOutController@generateQr')->name('payment-store-generate-qr-store');
                 Route::get('/payment-store/generate-ew','CheckOutController@generateEw')->name('payment-store-generate-ew-store');
                 Route::get('/payment-store/generate-va','CheckOutController@generateVa')->name('payment-store-generate-va-store');
                 Route::get('/payment-store/generate-ro','CheckOutController@generateRo')->name('payment-store-generate-ro-store');

                 Route::get('/payment-store/invoice','CheckOutController@invoice')->name('payment-invoice-store');
                 Route::post('/payment-store/check-payment-callback','CheckOutController@checkPaymentCallback')->name('check-payment-callback-store');
                 
                 Route::get('/payment-store/pending','CheckOutController@pending')->name('payment-store-pending-store');
                 Route::get('/payment-store/success','CheckOutController@success')->name('payment-store-success-store');
                 Route::get('/payment-store/failed','CheckOutController@failed')->name('payment-store-failed-store');

            });

            // my order
            Route::prefix('/my-order')->group(function(){
                Route::get('/','MyOrderController@index')->name('my-order-index-store');
                Route::get('/detail','MyOrderController@show')->name('my-order-index-detail-store');
            });

        });

        // Flavar =====================================================================
        Route::prefix('/flavar')->namespace('Flavar')->group(function ()
        {
            Route::get('/store','FlavarController@store')->name('store-flavar');
            Route::get('/stripe/success/{arviSessionId}','FlavarController@onSuccess')->name('stripe-success-flavar');
            Route::get('/stripe/failed/{arviSessionId}','FlavarController@onFailed')->name('stripe-failed-flavar');
        });


    });

});

// Xendit
Route::prefix('/xendit/callback')->namespace('API\Payment')->group(function () {
     // callback
     Route::post('/ew','XenditController@callbackEw');
     Route::post('/qr','XenditController@callbackQr');
     Route::post('/va','XenditController@callbackVa');
     Route::post('/ro','XenditController@callbackRo');
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
