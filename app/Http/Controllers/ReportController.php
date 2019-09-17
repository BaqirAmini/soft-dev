<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Gate;
use Charts;
use Illuminate\Support\Carbon;
use Faker\Provider\tr_TR\Payment;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    # View Tabular-reports
     public function index($time)
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
            return view('analytics', compact('schedule', 'cash', 'credit', 'debit', 'totalSales', 'amountPaid', 'amountDue'));
        } else {
            abort(403, 'This action is unauthorized.');
        }

     }

     # ===================================== CHARTS REPORT =============================
     public function chart()
     {
         if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            return view('reports_graph');
         } else {
             abort(403, 'This action is unauthorized.');
         }
     }

     public function getThisMonth()
     {
        $formated_data = [];
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $sales = DB::table('items')
                ->join('sales', 'items.item_id', '=', 'sales.item_id')
                ->select('sales.created_at', 'sales.qty_sold', 'sales.item_id', 'items.item_name', 'items.item_id')
                ->where('sales.comp_id', Auth::user()->comp_id)
                ->whereBetween('sales.created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
            ->get();
            $items = $sales->pluck('item_name');
            // $dates = $sales->pluck('created_at');
            $dates = $sales->pluck('created_at');
            $qty_sold = $sales->pluck('qty_sold');
            $chart1 = Charts::create('area', 'highcharts')
                ->title('Sold Categories')
                ->labels($items)
                ->values($qty_sold)
                ->elementLabel("Items")
                ->dimensions(1000, 500)
                ->responsive(true);

            $chart2 = Charts::create('pie', 'highcharts')
                ->title('Sold Categories')
                ->labels($sales->pluck('created_at'))
                ->values($qty_sold)
                ->elementLabel("Items")
                ->dimensions(1000, 500)
                ->responsive(false);




        //   return view('reports_graph')->with('chart', $chart);
        return view('reports_graph', compact(['chart1', 'chart2']));
            // return $items;

        } else {
            abort(403, 'This action is unauthorized.');
        }
     }
     # ====================================== /. CHARTS REPORT ========================

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
