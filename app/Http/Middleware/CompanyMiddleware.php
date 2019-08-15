<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if (Auth::user()->role === 'Super Admin') {
               return $next($request);
       }
          if (Auth::user()->company->comp_status == 1) {
               return $next($request);
          } else {
               Auth::logout();
               return redirect('login')->with('inactive', 'Sorry, this company is not active...!');
          }
       
    }
}
