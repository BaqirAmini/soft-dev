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
Route::get('test', 'AndroidAPIController@test');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
#ROUTES
#Login into system
Route::post('login', 'AndroidAPIController@onLogin');
Route::get('login', 'AndroidAPIController@onLogin');
#Load Data
Route::post('loadProduct', 'AndroidAPIController@onInventory');
#customers
    #load customers
    Route::post('listCustomer', 'AndroidAPIController@onListCustomer');
    Route::post('loadCustomer', 'AndroidAPIController@loadCustomer');
    # change customer-status
    Route::post('customerStatus', 'AndroidAPIController@onChangeCustomerStatus');
    # Edit customer
    Route::post('editCustomer', 'AndroidAPIController@onEditCustomer');
    # Check customers' balances
    Route::post('customerBalance', 'AndroidAPIController@onCheckCustomerBalance');
#/.Customers
# New Customer
Route::post('newCustomer', 'AndroidAPIController@onRegisterCustomer');
Route::get('newCustomer', 'AndroidAPIController@onRegisterCustomer');
# Categories
    #load categories of a specific company
    Route::post('listCategory', 'AndroidAPIController@onListCategory');
    Route::get('listCategory', 'AndroidAPIController@onListCategory');
    # Add new Category
    Route::post( 'newCategory', 'AndroidAPIController@onNewCategory');
    # Edit category
    Route::post( 'editCategory', 'AndroidAPIController@onEditCategory');
# Products
    # Add new product
    Route::post( 'newProduct', 'AndroidAPIController@onNewProduct');   
    Route::post( 'listProduct', 'AndroidAPIController@loadProduct');
    Route::post('editProduct', 'AndroidAPIController@onEditProduct');
# Reports
    # Today detailed-report
    Route::post('today', 'AndroidAPIController@salesReport');  
    # Yesterday detailed-report
    Route::post('yesterday', 'AndroidAPIController@salesReport');  
    # Last 7 days' detailed-report
    Route::post( 'lastSevenDay', 'AndroidAPIController@salesReport');  
    # Last 30 days' detailed-report
    Route::post( 'lastThirtyDay', 'AndroidAPIController@salesReport');  
    # This week detailed-report
    Route::post( 'thisWeek', 'AndroidAPIController@salesReport');  
    # Last week detailed-report
    Route::post( 'lastWeek', 'AndroidAPIController@salesReport');  
    # This month detailed-report
    Route::post( 'thisMonth', 'AndroidAPIController@salesReport');
    # Last month detailed-report
    Route::post('lastMonth', 'AndroidAPIController@salesReport');  
    # This year detailed-report
    Route::post('thisYear', 'AndroidAPIController@salesReport');  
    # Last year detailed-report
    Route::post('lastYear', 'AndroidAPIController@salesReport');  
    # All-time detailed-report
    Route::post('allTime', 'AndroidAPIController@salesReport');  
   
# Users
    # load users
    Route::post('listUser', 'AndroidAPIController@onListUser');
    # User-status
    Route::post( 'userStatus', 'AndroidAPIController@onChangeUserStatus');  
    # Register new user
    Route::post( 'registerUser', 'AndroidAPIController@onRegisterUser');  
    # set user role
    Route::post( 'setUserRole', 'AndroidAPIController@onSetUserRole');

# Generate Invoice & create sale
Route::post('createSale', 'AndroidAPIController@onCreateSale');
