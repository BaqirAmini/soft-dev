<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema; //Import Schemacl
use Illuminate\Support\ServiceProvider;
use View;
use Auth;
use DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        schema::defaultStringLength(191); //Solved by increasing StringLength
        View::composer('inc.sidebar', function($v) {
            if (Auth::check()) {
                $compId = Auth::user()->comp_id;
                // Pass data to @include-files (inc.sidebar)
                $logo = DB::table('companies')
                    ->select('companies.*')
                    ->where('companies.company_id', $compId)
                    ->get();
            }
            $v->with('logo', $logo);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
