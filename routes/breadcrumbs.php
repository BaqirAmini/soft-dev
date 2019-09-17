<?php
/**
 * Created by PhpStorm.
 * User: Baqir Amini
 * Date: 8/20/2019
 * Time: 3:12 PM
 */
// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
   $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > customers
Breadcrumbs::for('customer', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Customers', route('customer'));
});
//
Breadcrumbs::for('new-customer', function ($trail) {
    $trail->parent('customer');
    $trail->push('New Customer', route('customer.register'));
});

// Dashboard > Customers > Customer Detail
Breadcrumbs::for('customer_detail', function ($trail) {
    $trail->parent('customer');
    $trail->push('Customer Details', route('customer'));
});

// Dashboard > Customers > Customer Details > Invoice Details
Breadcrumbs::for('invoice-detail', function ($trail) {
    $trail->parent('customer_detail');
    $trail->push('Invoice Details', route('invoice.detail'));
});

// Dashboard > Inventories
Breadcrumbs::for('inventory', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Inventories', route('item'));
});

// Dashboard > Categories
Breadcrumbs::for('category', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Categories', route('category'));
});

// Dashboard > New-sale
Breadcrumbs::for('new-sale', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('New Sale', route('sale'));
});
/*==================== TABULAR / CHARTS analytics =================== */
// Dashboard > today
Breadcrumbs::for('today', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Today', route('report'));
});

// Dashboard > yesterday
Breadcrumbs::for('yesterday', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Yesterday', route('report'));
});

// Dashboard > Last 7 days
Breadcrumbs::for('last7days', function ($trail) {
   $trail->parent('dashboard');
   $trail->push('Last 7 Days', route('report'));
});

// Dashboard > This week
Breadcrumbs::for('thisWeek', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('This Week', route('report'));
});

// Dashboard > Last Week
Breadcrumbs::for('lastWeek', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Last Week', route('report'));
});

// Dashboard > Last 30 Days
Breadcrumbs::for('last30days', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Last 30 Days', route('report'));
});

// Dashboard > This Month
Breadcrumbs::for('thisMonth', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('This Month', route('report'));
});

// Dashboard > Last Month
Breadcrumbs::for('lastMonth', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Last Month', route('report'));
});

// Dashboard > This Year
Breadcrumbs::for('thisYear', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('This Year', route('report'));
});

// Dashboard > Last Year
Breadcrumbs::for('lastYear', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Last Year', route('report'));
});

// Dashboard > All Time
Breadcrumbs::for('allTime', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('All Time', route('report'));
});

// Dashboard / Charts
Breadcrumbs::for('chart', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Charts', route('graph'));
});
/*==================== /. TABULAR analytics =================== */

// Dashboard / Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('user'));
});

// Dashboard > Users > User Info
Breadcrumbs::for('user-info', function ($trail) {
   $trail->parent('users');
   $trail->push('User Info', route('user.info'));
});

// Dashboard / Company Setting
Breadcrumbs::for('comp-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Company Setting', route('company'));
});

/*======================== Super Admin pages ============================*/
// Dashboard / Companies/stores
Breadcrumbs::for('stores', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Companies', route('company'));
});

// Dashboard > Stores > company-setting
Breadcrumbs::for('company_setting', function ($trail) {
    $trail->parent('stores');
    $trail->push('Company Setting', route('company'));
});

// Dashboard > Stores > company-setting > System-Admin Info
Breadcrumbs::for('sa-info', function ($trail) {
    $trail->parent('company_setting');
    $trail->push('System-Admin Info', route('superadmin.profile'));
});

// Dashboard > Super Admins
Breadcrumbs::for('superadmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Super Admins', route('superAdmin'));
});

/*========================/. Super Admin pages ============================*/


