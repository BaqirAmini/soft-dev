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
         $this->middleware(['auth', 'compAuth']);
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
  # ===================== TOTAL AMOUNT from sales -- recieved & recievable amount by cash, credit card, debit card ============================== #
        # ALL TIME
        $queryPaymentReceived =  DB::table('payments')
            ->where('comp_id', $compId)
            ->where('trans_method', 'Payment Received')
            ->get();
        $queryNewSale =  DB::table('payments')
            ->where('comp_id', $compId)
            ->where('trans_method', 'New Sale')
            ->get();

        $recieved = $queryPaymentReceived->sum('amount_paid') + $queryNewSale->sum('amount_paid');
        $totalAmount = $queryNewSale->sum('total_invoice');
        $recievable = $totalAmount - $recieved;
  # ===================== /. TOTAL AMOUNT from sales -- recieved & recievable amount by cash, credit card, debit card ============================== #
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
        $credit = '';
        $debit = '';
        $schedule = '';
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {

            # TODAY'S SALES
            if ($time == 'today') {
                $schedule = "Today's";
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at',  DB::raw('CURDATE()'))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at',  DB::raw('CURDATE()'))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/
                /*$query = DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at',  DB::raw('CURDATE()'))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash of today
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('amount_paid');
                # YESTERDAY'S SALES
            } elseif ($time == 'yesterday') {
                $schedule = "Yesterday's";

                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at',  Carbon::now()->subDays(1))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at',  Carbon::now()->subDays(1))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

               /* $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at',  Carbon::now()->subDays(1))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash of Yerterday
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('amount_paid');
                #LAST 7 DAYS
            } elseif ($time == 'last7days') {
                $schedule = "Last 7 Days'";

                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/


                /*$query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash of LAST 7 DAYS
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->sum('amount_paid');
                # THIS WEEK'S SALES
            } elseif ($time == 'thisWeek') {
                $schedule = "This Week's";
                # This week
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

               /* $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for THIS WEEK
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount_paid');
            } elseif ($time == 'lastWeek') {
                $schedule = "Last Week's";
                # LAST WEEK'S SALES
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->where('created_at', '<=',  Carbon::now()->subDays(7)->startOfDay())
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->where('created_at', '<=',  Carbon::now()->subDays(7)->startOfDay())
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

                /*$query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->where('created_at', '<=',  Carbon::now()->subDays(7)->startOfDay())
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for LAST WEEK
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('amount_paid');
            } elseif ($time == 'last30days') {
                $schedule = "Last 30 Day's";
                # LAST 30 DAYS' SALES
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

              /*  $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash of LAST 30 DAYS
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('amount_paid');
            } elseif ($time == 'thisMonth') {
                $schedule = "This Month's";
                # THIS MONTH
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/
              /*
                $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for THIS MONTH
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount_paid');
            } elseif ($time == 'lastMonth') {
                $schedule = "Last Month's";
                # LAST MONTH
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

               /* $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for LAST MONTH
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('amount_paid');
            } elseif ($time == 'thisYear') {
                $schedule = "This Year's";
                # THIS YEAR
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

               /* $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for THIS YEAR
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('amount_paid');
            } elseif ($time == 'lastYear') {
                $schedule = "Last Year's";
                # LAST YEAR
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(365))
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(365))
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

               /* $query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->whereDate('created_at', '<=', Carbon::now()->subDays(365))
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for LAST YEAR
                $cash = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_method', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_method', 'Credit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->whereDate('payment_method', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('amount_paid');
            } elseif ($time == 'allTime') {
                $schedule = "All The Time's";
                # ALL TIME
                /* --------------- Query for Payment Received & New Sale -----------------------*/
                $queryPaymentReceived =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'Payment Received')
                    ->get();
                $queryNewSale =  DB::table('payments')
                    ->where('comp_id', $compId)
                    ->where('trans_method', 'New Sale')
                    ->get();
                /* ---------------/. Query for Payment Received & New Sale -----------------------*/

                /*$query =  DB::table('payments')
                    ->select('*')
                    ->where('comp_id', $compId)
                    ->get();*/
                # to calculate total of credit-card, debit-card, or cash for ALL TIME
                $cash = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Cash')->sum('amount_paid');
                $credit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Credit Card')->sum('amount_paid');
                $debit = DB::table('payments')->where('comp_id', $compId)->where('payment_method', 'Debit Card')->sum('amount_paid');
            }
           /* $recieved = $query->sum('amount_paid');
            $recievable = $query->sum('amount_due');
            $total = $recievable + $recieved;*/

            $amountPaid = $queryPaymentReceived->sum('amount_paid') + $queryNewSale->sum('amount_paid');
            $totalSales = $queryNewSale->sum('total_invoice');
            $amountDue = $totalSales - $amountPaid;
            return response()->json([
                'recieved' => $amountPaid,
                'recievable' => $amountDue,
                'cash' => $cash,
                'credit' => $credit,
                'debit' => $debit,
                'schedule' => $schedule,
                'total' => $totalSales
            ]);
        } else {
            abort(403, 'This action is unauthorized.');
        }
    }
}
