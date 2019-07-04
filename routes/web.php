<?php

#Company
Route::get('company', 'CompanyController@index')->name('company');
Route::post('company/register', 'CompanyController@store');
# === Company-settings === #
Route::get('company/setting', 'CompanyController@whichCompany')->name('company.setting');
Route::post('company/setting', 'CompanyController@index');
#===== company-status =====#
Route::post('company/status', 'CompanyController@onCompanyStatus');
Route::post('company/admin', 'CompanyController@createSystemAdmin');
Route::post('company/userCount', 'CompanyController@userCount');
#company

Route::get('register', function() {
    return view('auth.register');
});
//Items & Categorys
Route::get('category', 'CategoryController@index')->name('category');
Route::post('category/add', 'CategoryController@store');
Route::get('category/delete', 'CategoryController@destroy');
Route::post('category/edit', 'CategoryController@edit');

Route::get('item', 'ItemController@index')->name('item') /*->middleware('roleAuth')*/;
Route::post('item/add', 'ItemController@store');
Route::get('item/delete', 'ItemController@destroy');
Route::post('item/update', 'ItemController@update');

#User-Management
Route::get('manageUser', 'UserManageController@index')->name('user');
Route::post('manageUser', 'UserManageController@changeRole');
/*Route::post('manageUser/status/activate', 'UserManageController@onActivate');
Route::post('manageUser/status/deactivate', 'UserManageController@onDeactivate'); */
Route::post('manageUser/status', 'UserManageController@onStatus'); 
Route::post('manageUser/profile', 'UserManageController@changeProfile');
Route::post('manageUser/register', 'UserManageController@createUser');
Route::post('manageUser/profilePhoto', 'UserManageController@changePhoto');
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
Route::get('customer/purHistory/{id?}', 'CustomerController@onPurchaseHistory');
// Route::get('customer/purHistory', 'CustomerController@onPurchaseHistory')->name('history');

# /.Customers

#Cart routes
Route::post('cart', 'CartController@addToCart');
Route::get('cart/removeItem', 'CartController@removeItem');
# /.Cart

#Invoice-routes
Route::post('invoice', 'InvoiceController@store');
Route::post('invoice/delete', 'InvoiceController@index');
// Route::delete('invoice/delete', 'InvoiceController@destroy');
// Route::get('invoice/delete', ['as'=>'invoice.delete', 'uses'=>'InvoiceController@destroy']);
Route::get('invoice/print', 'InvoiceController@onPrint');
#Invoice

#Reports
Route::get('reports/daily', 'ReportController@daily')->name('daily');
Route::get('reports/daily/delete', 'ReportController@deleteDaily');
Route::get('reports/weekly', 'ReportController@weekly')->name('weekly');
Route::get('reports/monthly', 'ReportController@monthly')->name('monthly');
Route::get('reports/anually', 'ReportController@anually')->name('annually');
Route::get('reports/daily/delete', 'ReportController@deleteDaily');
Route::get('reports/graph', function() {
    return view('reports_graph');
});
#Reports

#Charts
Route::get('charts', 'ChartController@index')->name('chart');
#charts

#testing
Route::get('test', function() {
    return view('test');
});
// /.Items & Categories
Route::get('/', 'HomeController@index')->name('dashboard');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

// Route::post('api/login', 'AndroidAPIController@onLogin');
// Route::get('api/login', 'AndroidAPIController@onLogin');


