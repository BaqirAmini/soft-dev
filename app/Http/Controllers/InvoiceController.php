<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use Auth;
use Gate;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
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
    public function index()
    {
        //
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
        $invoice = new Invoice();
        $compId = Auth::user()->comp_id;
        $companies = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.comp_status')
            ->where('users.id', Auth::user()->id)
            ->get();
        $compStatus = $companies[0]->comp_status;
        if ($compStatus == 1) {
                $invoice->cust_id = $request->custId;
                $invoice->comp_id = $compId;
                $invoice->save();
                return response()->json([
                    'inv_msg' => 'Customer selected!',
                    'style' => 'color:grey',
                    'invoice_id' => $invoice->inv_id
                ]);
                  
        } else if( $compStatus == 0) {
            return response()->json([
                'inv_msg' => 'Sorry, customer not selected, try to see if your company is activated.',
                'style' => 'darkred'
            ]);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Fetch data of a specific customer for print
    public function onPrint(Request $request)
    {
        if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
            $invoiceDetails = DB::table('companies')
                ->join('items', 'companies.company_id', '=', 'items.comp_id')
                ->join('sales', 'items.item_id', '=', 'sales.item_id')
                ->join('invoices', 'invoices.inv_id', '=', 'sales.inv_id')
                ->join('customers', 'customers.cust_id', '=', 'invoices.cust_id')
                ->select('companies.comp_name', 'companies.comp_state', 'companies.comp_address', 'companies.contact_no', 'companies.comp_address', 'companies.email', 'sales.*', 'items.item_name', 'items.item_desc', 'items.barcode_number', 'invoices.inv_id', 'customers.cust_name', 'customers.cust_lastname', 'customers.cust_phone', 'customers.cust_state', 'customers.cust_addr')
                ->where('items.comp_id', Auth::user()->comp_id)
                ->where('invoices.cust_id', $request->cid)
                ->where('invoices.inv_id', $request->invoiceId)
                ->get();
            return   $invoiceDetails;
        } else {
            abort(403, 'This action is unauthorized.');
        }
        
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
    public function destroy(Request $request)
    {
        $deleted = Invoice::destroy('inv_id', $request->invId);
        
        if ($deleted) {
            return response()->json([
                'msg'=>'The invoice delete successfully!',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'msg'=>'Sorry, the invoice not deleted!',
                'style' => 'color:darkred'
            ]);
        }
        
    }
}
