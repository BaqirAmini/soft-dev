<?php
#Super-admin
Route::get('super-admin', 'SuperAdminController@index')->name('superAdmin');
#SuperAdmin status
Route::post('super-admin/status', 'SuperAdminController@onStatus');
Route::post('super-admin/create', 'SuperAdminController@create');
# /. Super-admin
#Company
Route::get('company', 'CompanyController@index')->name('company');
Route::post('company/register', 'CompanyController@store');
# === Company-settings === #
Route::get('company/setting/{id?}', 'CompanyController@onSetCompany')->name('company.setting');
Route::post('company/logo', 'CompanyController@changeLogo');
Route::post('/company/setCompany', 'CompanyController@onSaveCompanySetting');
#===== company-status =====#
Route::post('company/status', 'CompanyController@onCompanyStatus');
Route::post('company/system-admin', 'CompanyController@createSystemAdmin');
Route::post('company/userCount', 'CompanyController@userCount');
#company
# =========================== Settings of A SEPECIFIC COMPANY =================
Route::get('myCompany', 'UserManageController@onDefault')->name('myCompany.specific');
Route::post('myCompany/setting', 'UserManageController@onSet')->name('myCompany.setting');
Route::post('myCompany/logo', 'UserManageController@onChangeLogo');
# ============================ /. Settings of A SPEFIC COMPANY ================

Route::get('register', function() {
    return view('auth.register');
});
//Items & Categorys
Route::get('category', 'CategoryController@index')->name('category');
Route::post('category/add', 'CategoryController@store');
Route::get('category/delete', 'CategoryController@destroy');
Route::post('category/edit', 'CategoryController@edit');

Route::get('item', 'ItemController@index')->name('item');
Route::post('item/add', 'ItemController@store');
Route::get('item/delete', 'ItemController@destroy');
Route::post('item/update', 'ItemController@update');

#User-Management
#users of a specific company
// Route::get('/users/{compId?}', 'UserManageController@usersOfSpecificCompany');
# Authenticated company can see    
Route::get('manageUser', 'UserManageController@index')->name('user');
Route::post('manageUser', 'UserManageController@changeRole');
Route::post('manageUser/status', 'UserManageController@onStatus'); 
 // Super-admin only changes status of system-admins
Route::post('systemAdmin/status', 'UserManageController@onSystemAdminStatus'); 
Route::get('manageUser/profile', 'UserManageController@showUserProfile')->name('profile');
Route::post('manageUser/register', 'UserManageController@createUser');
Route::post('manageUser/userInfo1', 'UserManageController@changePersonInfo');
Route::post('manageUser/userInfo2', 'UserManageController@changePassword');
Route::post('manageUser/userPhoto', 'UserManageController@changePhoto');
# End of User-Management

#Sales-management
Route::post('sale', 'SaleController@store');
Route::get('sale', 'SaleController@index')->name('sale');
Route::get('deleteSale', 'SaleController@destroy');
# /.Sales-management

#Customers
Route::post('customer', 'CustomerController@store');
Route::get('customer', 'CustomerController@index')->name('customer');
Route::get('customer/delete', 'CustomerController@destroy');
Route::post('customer/edit', 'CustomerController@edit');
#Purchase-history
Route::get('customer/custDetail/{id?}', 'CustomerController@onPurchaseHistory');
Route::post('customer/custDetail/payment', 'CustomerController@onPayment');
Route::get('customer/custDetail/invoice/detail/{invId?}', 'InvoiceController@onDetail');
// Route::get('customer/purHistory', 'CustomerController@onPurchaseHistory')->name('history');

# /.Customers

#Cart routes
Route::post('cart', 'CartController@addToCart');
Route::get('cart/removeItem', 'CartController@removeItem');
# /.Cart

#Invoice-routes
Route::post('invoice', 'InvoiceController@store');
// Route::post('invoice/delete', 'InvoiceController@index');
// Route::delete('invoice/delete', 'InvoiceController@destroy');
// Route::get('invoice/delete', ['as'=>'invoice.delete', 'uses'=>'InvoiceController@destroy']);
Route::get('invoice/print', 'InvoiceController@onPrint');
#Invoice

#Reports
Route::get('analytics/{time?}', 'ReportController@index')->name('report');
// ======================= CHARTS for sales ================= 
Route::get('reports/graph', 'ReportController@getThisMonth')->name('this_month');
#Reports
// /. =========================/. CHARTS for sales ============================

#testing
 Route::get('test', function() {
     return view('auth.register');
 });
// /.Items & Categories
Route::get('/', 'HomeController@index')->name('dashboard');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/dashboard/{time?}', 'HomeController@analytic');



// Route::post('api/login', 'AndroidAPIController@onLogin');
// Route::get('api/login', 'AndroidAPIController@onLogin');


