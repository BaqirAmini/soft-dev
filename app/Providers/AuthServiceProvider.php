<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use App\User;
use DB;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

         // for super user (owner of app)
         Gate::define('isSuperAdmin', function($user){
            return $user->role === 'Super Admin';
        });
        // for admin of the stores
         Gate::define('isSystemAdmin', function($user){
            return $user->role === 'System Admin';
        });
        // super user 
         Gate::define('isStockManager', function($user){
            return $user->role === 'Stock Manager';
        });
        // user
        Gate::define('isCashier', function($user){
            return $user->role === 'Cashier';
        });
    }
}
