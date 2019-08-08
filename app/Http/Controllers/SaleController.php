<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Customer;
use App\Sale;
use App\Invoice;
use DB;
use Gate;
use Cart;
use Auth;
use App\Payment;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
    }
class SaleController extends Controller
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
            if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
                    #cart
                    $carts = Cart::content();
                    $total = Cart::total(2, '.', '');
                    $subTotal = Cart::subtotal(2, '.', '');
                    $tax = Cart::tax();
                    # /.cart
                    $sales = DB::table('companies')
                        ->join('items', 'companies.company_id', '=', 'items.comp_id')
                        ->join('sales', 'items.item_id', '=', 'sales.item_id')
                        ->join('invoices', 'invoices.inv_id', '=', 'sales.inv_id')
                        ->select('sales.*', 'items.item_name', 'companies.*', 'invoices.*')
                        ->where('items.comp_id', Auth::user()->comp_id)
                        ->get();

                    $customers = Customer::all()->where('comp_id', Auth::user()->comp_id);
                    $items = Item::all()->where('comp_id', Auth::user()->comp_id);
                    return view('create_sale', compact(['items', 'customers', 'sales', 'carts', 'total', 'subTotal', 'tax']));

            } else {
                abort(403, 'This action is unauthorized.');
            }
            
    }

    public function invoice()
    {
        
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
    {   $customerId = $request->custID;
        $tCode = $request->transCode;
        $paymentType = $request->payment;
        $recieved = $request->recieved;
        $recievable = $request->recieveable;
        # current company-id
        $compId = Auth::user()->comp_id;
        # currend user-id to define who sells 
        $seller = Auth::user()->id;

        # First generate invoice in TABLE invoices that is needed in TABLE payments
        $invoice = new Invoice();
        $companies = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.comp_status')
            ->where('users.id', Auth::user()->id)
            ->get();
        $compStatus = $companies[0]->comp_status;
        if ($compStatus == 1) {
            $invoice->cust_id = $customerId;
            $invoice->comp_id = $compId;
            $invoice->user_id = $seller;
            $invoiceGenerated = $invoice->save();
            if ($invoiceGenerated) {
                # To get invoice-id based on customer-id from invoices
                $invoiceId = DB::table('invoices')->where('cust_id', $customerId)->orderBy('inv_id', 'desc')->limit(1)->value('inv_id');
                $carts = Cart::content();

                # Payment & transaction
                $payment = new Payment();
                $payment->inv_id = $invoiceId;
                $payment->comp_id = $compId;
                $payment->trans_type = "Debit";
                $payment->trans_code = $tCode;
                $payment->payment_type = $paymentType;
                $payment->recieved_amount = $recieved;
                $payment->recievable_amount = $recievable;
                if ($payment->save()) {
                    foreach ($carts as $data) {
                        $sold = Sale::create([
                            'inv_id' => $invoiceId,
                            'comp_id' => $compId,
                            'item_id' => $data->id,
                            'qty_sold' => $data->qty,
                            'sell_price' => $data->price,
                            'tax' => 3,
                            'subtotal' => $data->price * $data->qty,
                        ]);
                    }
                    if ($sold) {
                        Cart::destroy($carts);
                        return response()->json([
                            'sale_msg' => 'The products sold successfully!',
                            'invoice_id' => $invoiceId,
                            'style' => 'color:grey',

                        ]);
                    }
                }
            }
        } else if ($compStatus == 0) {
            return response()->json([
                'sale_msg' => 'Sorry, customer not selected, try to see if your company is activated.',
                'style' => 'darkred'
            ]);
        }
        # /. Genereate invoice .....
          
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
    public function destroy(Request $request)
    {
        if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
            $deleteSale = Sale::destroy('sale_id', $request->saleID);
            if ($deleteSale) {
                echo "Sale deleted!";
            } else {
                echo "Sorry, sale not deleted!";
            }
        } else {
            abort(403, 'This action is unauthorized.');
        }
    }

}
