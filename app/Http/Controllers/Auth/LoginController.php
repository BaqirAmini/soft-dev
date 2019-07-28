<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    public function authenticate(Request $request) {
        # this is not working you should refere 'AuthenticateUsers.php' inside laravel>foundation>auth
        if (Auth::attempt(['username' => $request->user_name, 'password' => $request->password, 'status'=>1])) {
                return redirect()->intended('login');
        } 
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    // protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
