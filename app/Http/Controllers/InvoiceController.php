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
    public function onDetail($id)
    {
        $compId = Auth::user()->comp_id;
        $sales = DB::table('categories')
            ->join('items', 'categories.ctg_id', '=', 'items.ctg_id')
            ->join('sales', 'sales.item_id', '=', 'items.item_id')
            ->select('categories.ctg_name', 'items.item_name', 'sales.*')
            ->where('sales.comp_id', $compId)
            ->where('sales.inv_id', $id)
            ->get();
        return view('invoice_detail', compact('sales'));
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
