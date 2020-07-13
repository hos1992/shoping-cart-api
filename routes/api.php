<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(function(){

    // products controller
    Route::get('get-all-products', 'ProductsController@getAll');

    // cart controller
    Route::post('add-to-cart', 'CartController@addToCart');
    Route::post('update-quantity', 'CartController@updateQuantity');
    Route::post('get-cart', 'CartController@getCart');
    Route::post('apply-coupon', 'CartController@applyCoupon');

    // Orders Controller
    Route::post('place-order', 'OrdersController@placeOrder');
    Route::post('get-session-orders', 'OrdersController@getSessionOrders');
    Route::post('change-order-status', 'OrdersController@changeOrderStatus');


});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
