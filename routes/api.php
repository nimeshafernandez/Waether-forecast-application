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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('permissions', 'API\ApiPermissionController');
Route::get('permissions/role/{id}', 'API\ApiPermissionController@permission_per_role');

Route::apiResource('warehouse', 'API\ApiWarehouseController');

Route::apiResource('brand', 'API\ApiBrandController');
Route::get('brand/warehouse/{id}', 'API\ApiBrandController@byWarehouse')->name('brand.warehouse');

Route::apiResource('category', 'API\ApiCategoryController');
Route::get('category/warehouse/{id}', 'API\ApiCategoryController@byWarehouse')->name('category.warehouse');

Route::apiResource('product', 'API\ApiProductController');
Route::get('product/warehouse/{id}', 'API\ApiProductController@byWarehouse')->name('product.warehouse');
Route::get('product/np/warehouse/{id}', 'API\ApiProductController@byWarehouseNonPaginate')->name('product.warehouse.non.paginate');
Route::get('product/search/{keyword}/warehouse/{warehouse}', 'API\ApiProductController@searchProductsByWarehouse')->name('product.warehouse.search');
Route::get('product/get/barcode/{barcode}/warehouse/{warehouse}', 'API\ApiProductController@getProductByBarcode')->name('product.get.from.barcode');

Route::apiResource('supplier', 'API\ApiSupplierController');
Route::get('supplier/get/all/{keyword}', 'API\ApiSupplierController@getAllSuppliersSearch')->name('supplier.get.all.search');
Route::get('supplier/get/all', 'API\ApiSupplierController@getAllSuppliers')->name('supplier.get.all');

Route::prefix('customer')->group(function () {
    Route::post('payment/{id}', 'API\ApiCustomerController@getPayment');
    Route::get('all',  'API\ApiCustomerController@getAllCustomers')->name('customer.all');
    Route::get('search/{keyword}', 'API\ApiCustomerController@search')->name('customer.search');
});
Route::apiResource('customer', 'API\ApiCustomerController');

Route::apiResource('user', 'API\ApiUserController');

Route::apiResource('role', 'API\ApiRoleController');
Route::get('role/get/user/{user}', 'API\ApiRoleController@getRolesBasedOnPermission')->name('role.userbased.list');

Route::group(['prefix' => 'stock'], function () {
    Route::get('warehouse/{id}', 'API\ApiStockController@byWarehouse')->name('stock.warehouse');
    Route::get('np/warehouse/{id}', 'API\ApiStockController@byWarehouseNonPaginate')->name('stock.warehouse.non.paginate');
    Route::get('search/{keyword}/warehouse/{warehouse}', 'API\ApiStockController@searchProductsByWarehouse')->name('stock.warehouse.search');
});
Route::apiResource('stock', 'API\ApiStockController');

Route::apiResource('pos', 'API\ApiPosController');

Route::prefix('receipt')->group(function () {
    Route::get('products/{receipt}', 'API\ApiReceiptController@showWithProduct')->name('receipt.with.product');
});
Route::apiResource('receipt', 'API\ApiReceiptController');

Route::prefix('translate')->group(function () {
    Route::get('sinhala/{keyword}', 'API\ApiTranslateController@toSinhala');
});

Route::group(['prefix' => 'dashboard'], function () {
   Route::get('get_daily_sales','API\ApiDashBoardController@daily_sales');
   Route::get('get_daily_credits','API\ApiDashBoardController@daily_credits');
   Route::get('get_sold_product','API\ApiDashBoardController@sold_products');
   Route::get('get_last_month_sales','API\ApiDashBoardController@month_sales');
   Route::get('get_total_sales','API\ApiDashBoardController@total_sales');
   Route::get('get_total_cost','API\ApiDashBoardController@total_costs');
   Route::get('get_income','API\ApiDashBoardController@income');
   Route::get('get_expense','API\ApiDashBoardController@expense');
   Route::get('get_top_selling_product','API\ApiDashBoardController@top_selling_product');
   Route::get('get_recent_invoice','API\ApiDashBoardController@recent_invoice');
   Route::get('get_recent_expense','API\ApiDashBoardController@recent_expense');


   Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

});



Route::post('add_todo','API\Apitodoscontroller@add_ToDo');

Route::get('get_todo_data','API\Apitodoscontroller@get_todo');

Route::get('search_todo_data/{serach_data}','API\Apitodoscontroller@search_todo_data');

Route::delete('delete_todo/{todo_id}','API\Apitodoscontroller@delete_todo_data');

Route::patch('update_todo/{todo_id}','API\Apitodoscontroller@update_todo_data');
