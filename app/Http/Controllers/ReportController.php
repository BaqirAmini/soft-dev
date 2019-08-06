<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Gate;
use Illuminate\Support\Carbon;

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
            return view('analytics', compact('schedule', 'cash', 'master', 'debit', 'total', 'recieved', 'recievable'));
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
        $formated_date = '';
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $sales = DB::table('categories')
                ->join('items','categories.ctg_id', '=', 'items.ctg_id')
                ->join('sales', 'items.item_id', '=', 'sales.item_id')
                ->select('sales.*', 'categories.ctg_name', 'items.item_name')
                ->where('sales.comp_id', Auth::user()->comp_id)
                ->whereBetween('sales.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get();
            $items = $sales->pluck('item_name');
            // $dates = $sales->pluck('created_at');
            $dates = $sales->pluck('created_at');
            $qty_sold = $sales->pluck('qty_sold');
        
            
          return view('reports_graph', compact(['items', 'dates', 'qty_sold']));
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
