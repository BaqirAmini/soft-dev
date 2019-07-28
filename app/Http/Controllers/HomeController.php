<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        # ================ Inventories ========= #
        $compId = Auth::user()->comp_id;
        $ctgs = DB::table('categories')->where('categories.comp_id', $compId)->get();
        $items = DB::table('items')
            ->join('categories', 'categories.ctg_id', '=', 'items.ctg_id')
            ->select('items.*',  'categories.ctg_name')
            ->where('items.comp_id',  $compId)
            ->get();
        # ============== /. Intories =========== #
        $users = DB::table('users')->where('comp_id', Auth::user()->comp_id);
        // Order of aggregate function like SUM() is important so, it should come after  WHERE()
        $sales = DB::table('sales')->where('comp_id', Auth::user()->comp_id)->sum('subtotal');
        // number of registered customers
        $custCount = DB::table('customers')->where('comp_id', Auth::user()->comp_id)->count();
        // number of registered companies
        $compCount = DB::table('companies')->count();
        // number of all registered users except Super-admin(app owner)
        $allUsers = DB::table('users')->where('id', '>', 8)->where('status', 1)->count();
        // Number of super Admins
        $superAdminCount = DB::table('users')->where('role', 'Super Admin')->count();
        // Total of products in-stock
        $invenTotal = DB::table('items')->where('comp_id', Auth::user()->comp_id)->sum('quantity');
        $usersCount = $users->count();
        # To return list of COMPANIES to Dashboard
        $companies = DB::table('companies')->get();
        return view('dashboard', compact(['usersCount', 'sales', 'custCount', 'invenTotal', 'compCount', 'allUsers', 'superAdminCount', 'companies', 'items', 'ctgs']) );
    }
}
