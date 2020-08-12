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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix'=>'', ['middleware' => ['XSS']], 'namespace'=>'Api'], function(){
    
    
    //app logo and name
    Route::get('app_info', 'AppController@app');
    
	// for user
	Route::post('register', 'UserController@signUp');
    Route::post('verify_phone', 'UserController@verifyPhone');
    Route::post('forget_password', 'UserController@forgotPassword');
    Route::post('verify_otp', 'UserController@verifyOtp');
    Route::post('change_password', 'UserController@changePassword');
    Route::post('login', 'UserController@login');
    Route::post('checkotp', 'UserController@checkOTP');
    Route::post('myprofile', 'UserController@myprofile');
    //////address///////
    Route::post('add_address', 'AddressController@address');
    Route::get('city', 'AddressController@city');
    Route::post('society', 'AddressController@society');
    Route::post('show_address', 'AddressController@show_address');
    Route::post('select_address', 'AddressController@select_address');
    Route::post('edit_address', 'AddressController@edit_add');
    Route::post('remove_address', 'AddressController@rem_user_address');
    
    ////category product, product_varient///////
    Route::get('cat', 'CategoryController@cat');
    Route::post('varient', 'CategoryController@varient');
    Route::post('dealproduct', 'CategoryController@dealproduct');
    
    //orders//
     Route::post('make_an_order', 'OrderController@order');
     Route::post('ongoing_orders', 'OrderController@ongoing');
     Route::get('cancelling_reasons', 'OrderController@cancel_for');
     Route::post('delete_order', 'OrderController@delete_order');
     Route::post('top_selling', 'OrderController@top_selling');
     Route::post('checkout', 'OrderController@checkout');
     Route::post('completed_orders', 'OrderController@completed_orders');
     Route::post('recentselling', 'OrderController@recentselling');
    
    //coupon//
    Route::post('apply_coupon', 'CouponController@apply_coupon');
    Route::post('couponlist', 'CouponController@coupon_list');
    Route::post('walletamount', 'WalletController@walletamount');
    
    //search//
    Route::post('search', 'SearchController@search');
    
    //currency//
     Route::get('currency', 'CurrencyController@currency');
    /////time slot////// 
    Route::post('timeslot', 'TimeslotController@timeslot'); 
  
    //////minimum/maximum order value///////
    Route::get('minmax', 'CartvalueController@minmax'); 
     
    /////rating/////
    Route::post('review_on_delivery', 'RatingController@review_on_delivery');
    
    ////pages//
     Route::get('appaboutus', 'PagesController@appaboutus');
     Route::get('appterms', 'PagesController@appterms');
     
     //banner//
     Route::get('banner', 'BannerController@bannerlist');
     
     Route::get('catee', 'CategoryController@cate');
     Route::post('cat_product', 'CategoryController@cat_product');
     
     //wallet
     Route::post('recharge_wallet', 'WalletController@add_credit');
     Route::post('totalbill', 'WalletController@totalbill');
     Route::post('show_recharge_history', 'WalletController@show_recharge_history');
     
     
     //notification by///
     Route::post('notifyby', 'NotifybyController@notifyby');
     Route::post('updatenotifyby', 'NotifybyController@updatenotifyby');
     
    //secbanner//
    Route::get('secondary_banner', 'BannerController@secbannerlist');
     
     //redeem rewards//
      Route::post('redeem_rewards', 'RewardController@redeem');
      Route::get('rewardvalues', 'RewardController@rewardvalues');
      
      //notifications//
      Route::post('notificationlist', 'UsernotificationController@notificationlist');
      Route::post('read_by_user', 'UsernotificationController@read_by_user');
      Route::post('mark_all_as_read', 'UsernotificationController@mark_all_as_read');
      Route::post('delete_all_notification', 'UsernotificationController@delete_all');
      
     //////cancel order list////
      Route::post('can_orders', 'OrderController@can_orders');
      ///profile edit
      Route::post('profile_edit', 'UserController@profile_edit');
      ///////what's new//////
       Route::post('whatsnew', 'OrderController@whatsnew');
       
       ////rewardlines////
       Route::post('rewardlines', 'RewardController@rewardlines');
       
       //top six categories//
        Route::post('topsix', 'CategoryController@top_six');
        
         //Delivery fee info////
        Route::get('delivery_info', 'AppController@delivery_info');
        
        /////user_block_check////
         Route::post('user_block_check', 'UserController@user_block_check');
         
         Route::post('forgot_password','forgotpasswordController@forgot_password'); 
         Route::get('checkotponoff','forgotpasswordController@checkotponoff'); 
         Route::get('pymnt_via','PaymentController@pymnt_via');
        
       
      
});

Route::group(['prefix'=>'store', ['middleware' => ['XSS']], 'namespace'=>'Storeapi'], function(){
    
    //////store login/////
    Route::post('store_login', 'StoreloginController@store_login');
    Route::post('store_profile', 'StoreloginController@storeprofile');
    
      Route::post('storetoday_orders', 'StoreorderController@todayorders');
    Route::post('storenextday_orders', 'StoreorderController@nextdayorders');
    Route::post('productcancelled', 'StoreorderController@productcancelled');
    Route::post('order_rejected', 'StoreorderController@order_rejected');
    Route::post('storeconfirm', 'AssignController@storeconfirm');
    
    
    Route::post('productselect', 'AddproductController@productselect');
    Route::post('storeproducts', 'AddproductController@store_products');
    Route::post('store_stock_update', 'AddproductController@stock_update');
    Route::post('store_delete_product', 'AddproductController@delete_product');
    Route::post('store_add_products', 'AddproductController@add_products');
    Route::post('earn', 'AmountController@earn');
    
  //notifications//
  Route::post('notificationlist', 'NotificationController@notificationlist');
  Route::post('read_by_store', 'NotificationController@read_by_store');
  Route::post('all_as_read', 'NotificationController@all_as_read');
  Route::post('delete_all_notification', 'NotificationController@delete_all');
  Route::post('nearbydboys','AssignController@delivery_boy_list');
  Route::post('cart_invoice','StoreinvoiceController@cart_invoice');
    
});


Route::group(['prefix'=>'driver', ['middleware' => ['XSS']], 'namespace'=>'Driverapi'], function(){
    Route::post('driver_login', 'DriverloginController@driver_login');
    Route::post('driver_profile', 'DriverloginController@driverprofile');
    Route::post('ordersfortoday', 'DriverorderController@ordersfortoday');
    Route::post('ordersfornextday', 'DriverorderController@ordersfornextday');
    Route::post('out_for_delivery', 'DriverorderController@delivery_out');
    Route::post('delivery_completed', 'DriverorderController@delivery_completed');
    Route::post('avg_rating', 'RatingController@avg_rating');
    Route::get('map_api', 'MapController@map_api_key');
    Route::post('completed_orders', 'DriverorderController@completed_orders');
    Route::post('update_status', 'DriverstatusController@status');
    
});


Route::group(['prefix'=>'', ['middleware' => ['XSS']], 'namespace'=>'Ios'], function(){
    
    
	// for user
	Route::post('ios_register', 'UserController@ios_signUp');
	Route::post('ios_com', 'IosordersController@completed_orders');
	Route::post('ios_on', 'IosordersController@ongoing');
	Route::post('ios_cart_add', 'CartController@add_to_cart');
	Route::post('ios_make_order', 'CartController@make_an_order');
	Route::post('show_cart', 'CartController@show_cart');
});

