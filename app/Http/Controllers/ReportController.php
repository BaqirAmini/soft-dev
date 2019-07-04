<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
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
    public function daily()
    {
        
        // Total sales of today
        $todaySales = DB::table('sales')
        ->where('comp_id', Auth::user()->comp_id)
        ->where('sales.created_at', '>=', DB::raw('CURDATE()'))
        ->SUM('sales.subtotal');   

        // Today's sales detail
       $todays = DB::table('customers')
        ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
        ->join('payments', 'payments.inv_id', '=', 'invoices.inv_id')
        ->join('sales','invoices.inv_id', '=', 'sales.inv_id')
        ->join('items','sales.item_id', '=', 'items.item_id')
        ->select('customers.cust_name', 'customers.cust_lastname', 'payments.payment_type', 'payments.recieved_amount', 'payments.recievable_amount',  'sales.inv_id', 'sales.qty_sold', 'sales.created_at', 'items.item_image', 'items.item_name')
        ->where('sales.comp_id', Auth::user()->comp_id)
        ->where('sales.created_at', '>=', DB::raw('CURDATE()'))
        ->get(); 
     
        return view('daily_report', compact(['todaySales', 'todays']));
    }
    # Delete daily reports..
    public function deleteDaily(Request $request)
    {
        $deleted = DB::destroy('sale_id', $request->saleId)->where('comp_id', $request->compId);
        if ($deleted) {
            return response()->json([
                'delete_msg' => 'Sale deleted successfully!',
                'style' => 'color:greg'
            ]);
        } else {
            return response()->json([
                'delete_msg' => 'Sorry, sale not deleted, please, try again!',
                'style' => 'color:darkred'
            ]);
        }
        
    }
    public function weekly()
    {
            // Total sales of current-week
            $currentWeek = DB::table('sales')
            ->where('comp_id', Auth::user()->comp_id)
            ->where('sales.created_at', '<=', Carbon::now()->subDays(7)->startOfDay())
            ->SUM('sales.subtotal');   

             // This Week's sales detail
                $lastWeekSales = DB::table('customers')
                    ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
                    ->join('payments', 'payments.inv_id', '=', 'invoices.inv_id')
                    ->join('sales','invoices.inv_id', '=', 'sales.inv_id')
                    ->join('items','sales.item_id', '=', 'items.item_id')
                    ->select('customers.cust_name', 'customers.cust_lastname', 'payments.payment_type', 'payments.recieved_amount', 'payments.recievable_amount',  'sales.inv_id', 'sales.qty_sold', 'sales.created_at', 'items.item_image', 'items.item_name')
                    ->where('sales.comp_id', Auth::user()->comp_id)
                    ->where('sales.created_at', '<=', Carbon::now()->subDays(7)->startOfDay())
                    ->get(); 

        return view('weekly_report', compact(['currentWeek', 'lastWeekSales']));
    }
    public function monthly()
    {
         // Total sales of last-month
         $lastMonthTotal = DB::table('sales')
         ->where('comp_id', Auth::user()->comp_id)
         ->where('sales.created_at', '<=',Carbon::now()->subDays(30)->startOfDay())
         ->SUM('sales.subtotal');   

         // Last Month's sales detail
          $lastMonthDetails = DB::table('customers')
          ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
          ->join('payments', 'payments.inv_id', '=', 'invoices.inv_id')
          ->join('sales','invoices.inv_id', '=', 'sales.inv_id')
          ->join('items','sales.item_id', '=', 'items.item_id')
          ->select('customers.cust_name', 'customers.cust_lastname', 'payments.payment_type', 'payments.recieved_amount', 'payments.recievable_amount',  'sales.inv_id', 'sales.qty_sold', 'sales.created_at', 'items.item_image', 'items.item_name')
          ->where('sales.comp_id', Auth::user()->comp_id)
          ->where('sales.created_at', '<=', Carbon::now()->subDays(30)->startOfDay())
          ->get(); 
        return view('monthly_report', compact(['lastMonthTotal', 'lastMonthDetails']));
    }
    public function anually()
    {
         // Total sales of last-month
         $lastYearTotal = DB::table('sales')
         ->where('comp_id', Auth::user()->comp_id)
         ->where('sales.created_at', '<=', Carbon::now()->subDays(365)->startOfDay())
         ->SUM('sales.subtotal');   

         // Last Year's sales detail
         $lastYearDetails = DB::table('customers')
         ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
         ->join('payments', 'payments.inv_id', '=', 'invoices.inv_id')
         ->join('sales','invoices.inv_id', '=', 'sales.inv_id')
         ->join('items','sales.item_id', '=', 'items.item_id')
         ->select('customers.cust_name', 'customers.cust_lastname', 'payments.payment_type', 'payments.recieved_amount', 'payments.recievable_amount',  'sales.inv_id', 'sales.qty_sold', 'sales.created_at', 'items.item_image', 'items.item_name')
         ->where('sales.comp_id', Auth::user()->comp_id)
         ->where('sales.created_at', '<=', Carbon::now()->subDays(365)->startOfDay())
         ->get(); 

        return view('anually_report', compact(['lastYearTotal', 'lastYearDetails']));
    }

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
