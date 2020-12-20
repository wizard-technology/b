<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'isStop',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('forgetpassword', 'AuthController@forgetpassword');
    Route::post('verify_reset_password', 'AuthController@verify_reset_password');
    Route::post('change_password', 'AuthController@change_password');
    Route::get('home', 'HomeController@home');  
    Route::get('types', 'HomeController@types');
    Route::get('company', 'HomeController@company');
    Route::get('product/{id}', 'HomeController@product');
    Route::get('product/get/{text}', 'HomeController@onSearch');
    Route::get('product/type/{type}', 'HomeController@getByType');
    Route::get('product/subcategory/{subcategory}', 'HomeController@getBySubcategory');
    Route::get('bizzcoin', 'HomeController@bizzcoin');
    Route::get('terms', 'HomeController@terms');
    Route::get('subcategory', 'HomeController@subcategories');
    Route::get('subcategory/get/{id}', 'HomeController@getSubcategory');
    Route::get('grouped/get/{id}', 'HomeController@getGrouped');
    Route::get('product/grouped/get/{id}', 'HomeController@getProduct');
    Route::get('product/company/get/{id}', 'HomeController@getProductCompany');
    Route::post('test', 'TestController@test');
    Route::post('web_hook/8wYSv7949xI2QkeYkByqnj6pxkbXUYsR/pb5rA7eo7OIUJkfwUr2ToBdARVDAb10o', 'HomeController@web_hook')->name('web_hook');

    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::get('user', 'AuthController@user');
        Route::get('logout', 'AuthController@logout');
        Route::post('password', 'AuthController@password');
        Route::post('send/report', 'HomeController@sendReport');
        Route::get  ('get/report', 'HomeController@getReport');
        Route::group([
            'middleware' => ['isUser'],
        ], function () {
            Route::post('verify', 'AuthController@verify_user');
            Route::group([
                'middleware' => 'checkVerify',
            ], function () {
                Route::put('update', 'AuthController@updateInfo');
                Route::get('product/user/{id}', 'HomeController@productUser');
                Route::post('favorate/{id}', 'HomeController@favorate');
                Route::get('favorates', 'HomeController@favorateGet');
                Route::post('addToCart', 'HomeController@addToCart');
                Route::get('cart', 'HomeController@cartGet');
                Route::get('history', 'HomeController@cartGroup');
                Route::get('history/item/{cart}', 'HomeController@cartFinished');
                Route::post('cart/delete', 'HomeController@cartDelete');
                Route::post('cart/amount', 'HomeController@amountChange');
                Route::post('checkout', 'HomeController@checkOut');
                Route::post('payment', 'HomeController@payment');
                Route::post('payment/redeem', 'HomeController@payment_redeem');
                Route::get('mainscreen', 'HomeController@isNotificationAndCheckout');
                Route::get('open/notification', 'HomeController@openNotification');
            });
        });
        
    });

   
});
