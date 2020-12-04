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

Route::get('/', function () {
    return view('pages.index');
});
Route::get('/dashboard/login', 'AdminLogin@login')->name('dashboard.login');
Route::post('/dashboard/signup', 'AdminLogin@signup')->name('dashboard.signup');
Route::post('/dashboard/login', 'AdminLogin@check')->name('dashboard.check');
Route::get('/dashboard/404', 'AdminLogin@notFound')->name('dashboard.not');
Route::get('/dashboard/test', 'DashboardController@test');


Route::name('dashboard.')->prefix('dashboard')->middleware(['isAdmin'])->group(
    function () {
        Route::get('logout', 'AdminLogin@logout')->name('logout');
        Route::post('/dashboard/translate', 'DashboardController@translate')->name('translate');
        
        Route::middleware(['hasAccess'])->group(
            function () {
                Route::get('index', 'DashboardController@index')->name('index');
                Route::post('index', 'DashboardController@show')->name('index.show');
                Route::resource('profile', 'AdminController');
                Route::resource('setting', 'SettingController');
                Route::resource('type', 'TypeController');
                Route::resource('tag', 'TagController');
                Route::resource('city', 'CityController');
                Route::resource('user', 'UserController');
                Route::resource('product', 'ProductController');
                Route::resource('card', 'CardinfoController');
                Route::resource('support', 'HelpController');
                Route::resource('cart', 'CartController');
                Route::resource('employee', 'EmployeeController');
                Route::resource('company', 'CompanyController');
                Route::resource('bizzcoin', 'BizzpaymentController');
                Route::resource('subcategory', 'SubcategoryController');
                Route::resource('grouped', 'GroupedController');
                Route::post('/product/subctegory', 'ProductController@getSub')->name('product.subctegory');
                Route::post('/product/grouped', 'ProductController@getGr')->name('product.grouped');
                Route::post('setting/more/{id}', 'SettingController@more')->name('setting.more');
            }
        );
    }
);
