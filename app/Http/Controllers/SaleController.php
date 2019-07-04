<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Customer;
use App\Sale;
use DB;
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
        #cart
            $carts = Cart::content();
            $total = Cart::total();
            $subTotal = Cart::subtotal();
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
    {
        # current company-id
        $compId = Auth::user()->comp_id;
        # To get invoice-id based on customer-id from invoices
        $invoiceId = DB::table('invoices')->where('cust_id', $request->custID)->orderBy('inv_id', 'desc')->limit(1)->value('inv_id');
        # 
        
        $carts = Cart::content();
        
            # Payment & transaction
           $payment = new Payment();
           $payment->inv_id = $invoiceId;
           $payment->comp_id = $compId;
           $payment->trans_code = $request->transCode;
           $payment->payment_type = $request->payment;
           $payment->recieved_amount = $request->recieved;
           $payment->recievable_amount = $request->recieveable;
           if($payment->save()) {

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
                    'style' => 'color:grey',
                    
                 ]);
            
               }
           }
          
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
         $deleteSale = Sale::destroy('sale_id', $request->saleID);
         if ($deleteSale) {
             echo "Sale deleted!";
         } else {
             echo "Sorry, sale not deleted!";
         }
         
    }
}
