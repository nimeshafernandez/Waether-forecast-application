<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::post('locklogin', 'LockScreenController@lockScreenLogin')->name('lockscreenlogin');
    Route::get('lockscreen', 'LockScreenController@lockScreen')->name('lockscreen');

    Route::resource('warehouse', 'WarehouseController');

    Route::resource('user', 'UserController');

    Route::resource('roles', 'RoleController');

    Route::resource('product', 'ProductController');

    Route::resource('category', 'CategoryController');

    Route::resource('brand', 'BrandController');

    Route::resource('supplier', 'SupplierController');

    Route::group(['prefix' => 'customer'], function () {
        Route::get('overview', 'CustomerController@overview')->name('credit.customer.overview');
        Route::get('payment', 'CustomerController@payment')->name('credit.payment');
    });
    Route::resource('customer', 'CustomerController');

    Route::resource('stock', 'GrnController');

    Route::resource('pos', 'PosController');

    

});
