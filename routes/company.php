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

Route::post('login', 'AuthController@login');
Route::post('register', 'CompanyAppController@register');
Route::get('city', 'CompanyAppController@city');

Route::group(
    [
        'middleware' => ['auth:api', 'isCompany'],
    ],
    function () {
        Route::get('company/user', 'AuthController@company');
        Route::get('user', 'AuthController@user');
        Route::post('upload/image', 'CompanyAppController@upload');
        Route::group(
            [
                'middleware' => ['checkVerify'],
            ],
            function () {
                Route::post('update/company', 'CompanyAppController@update');
                Route::post('product/company/add', 'CompanyAppController@addProduct');
                Route::post('product/company/update', 'CompanyAppController@updateProduct');
                Route::post('product/company/delete', 'CompanyAppController@deleteProduct');
                Route::post('product/company/image', 'CompanyAppController@addImage');
                Route::get('products', 'CompanyAppController@getProduct');
                Route::get('get/redeem/code', 'CompanyAppController@getRedeem');
                Route::post('scan/redeem/code', 'CompanyAppController@scanRedeem');

            }
        );
        Route::post('upload/image', 'CompanyAppController@upload');
    }
);
