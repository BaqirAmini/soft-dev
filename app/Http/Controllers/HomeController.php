<?php

namespace App\Http\Controllers;

use DB;
use Gate;
use Auth;
use Illuminate\Support\Carbon;

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
        $compId = Auth::user()->comp_id;
        # ================ Inventories ========= #
        
        $ctgs = DB::table('categories')->where('categories.comp_id', $compId)->get();
        $items = DB::table('items')
            ->join('categories', 'categories.ctg_id', '=', 'items.ctg_id')
            ->select('items.*',  'categories.ctg_name')
            ->where('items.comp_id',  $compId)
            ->get();
        # ============== /. Intories =========== #
        $users = DB::table('users')->where('comp_id', Auth::user()->comp_id);
        // Order of aggregate function like SUM() is important so, it should come after  WHERE()
  # ===================== TOTAL AMOUNT from sales -- recieved & recievable amount by cash, master card, debit card ============================== #  
        # ALL TIME
        $query =  DB::table('payments')
            ->select('*')
            ->where('comp_id', $compId)
            ->get();
        $recieved = $query->sum('recieved_amount');
        $recievable = $query->sum('recievable_amount');
        $totalAmount = $recievable + $recieved;   
  # ===================== /. TOTAL AMOUNT from sales -- recieved & recievable amount by cash, master card, debit card ============================== #       
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
        $companies = DB::table('companies')->select('*')->get();
        return view('dashboard', compact(['usersCount', 'totalAmount', 'custCount', 'invenTotal', 'compCount', 'allUsers', 'superAdminCount', 'companies', 'items', 'ctgs']) );
    }

    # ================================ Analytics on Dashboard ===================
    public function analytic($time)
    {
        $compId = Auth::user()->comp_id;
        $query = '';
        $cash = '';
        $master = '';
        $debit = '';
        $schedule = '';
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {

            # TODAY'S SALES
            if ($time == 'today') {
                $schedule = "Today's";
                $query = DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at',  DB::raw('CURDATE()'))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash of today
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
                # YESTERDAY'S SALES
            } elseif ($time == 'yesterday') {
                $schedule = "Yesterday's";
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at',  Carbon::now()->subDays(1))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash of Yerterday
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
                #LAST 7 DAYS
            } elseif ($time == 'last7days') {
                $schedule = "Last 7 Days'";
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash of LAST 7 DAYS
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
                # THIS WEEK'S SALES
            } elseif ($time == 'thisWeek') {
                $schedule = "This Week's";
                # This week
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for THIS WEEK
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
            } elseif ($time == 'lastWeek') {
                $schedule = "Last Week's";
                # LAST WEEK'S SALES
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->where('created_at', '<=',  Carbon::now()->subDays(7)->startOfDay())
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for LAST WEEK
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
            } elseif ($time == 'last30days') {
                $schedule = "Last 30 Day's";
                # LAST 30 DAYS' SALES
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash of LAST 30 DAYS
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
            } elseif ($time == 'thisMonth') {
                $schedule = "This Month's";
                # THIS MONTH
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for THIS MONTH
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');
            } elseif ($time == 'lastMonth') {
                $schedule = "Last Month's";
                # LAST MONTH
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for LAST MONTH
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
            } elseif ($time == 'thisYear') {
                $schedule = "This Year's";
                # THIS YEAR
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for THIS YEAR
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
            } elseif ($time == 'lastYear') {
                $schedule = "Last Year's";
                # LAST YEAR
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(365))
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for LAST YEAR
                $cash = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_type', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_type', 'Master Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_type', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
            } elseif ($time == 'allTime') {
                $schedule = "All The Time's";
                # ALL TIME
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->get();
                # to calculate total of credit-card, debit-card, or cash for ALL TIME
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Cash')->sum('recieved_amount');
                $master = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Master Card')->sum('recieved_amount');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_type', 'Debit Card')->sum('recieved_amount');
            }
            $recieved = $query->sum('recieved_amount');
            $recievable = $query->sum('recievable_amount');
            $total = $recievable + $recieved;
            return response()->json([
                'recieved' => $recieved,
                'recievable' => $recievable,
                'cash' => $cash,
                'master' => $master,
                'debit' => $debit,
                'schedule' => $schedule,
                'total' => $total
            ]);
        } else {
            abort(403, 'This action is unauthorized.');
        }
    }
}
