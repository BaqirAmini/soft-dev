<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;
use Validator;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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

        $customers = Customer::all()->where('comp_id', Auth::user()->comp_id);
        return view('customer', compact('customers'));
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
    # Create new customer
    public function store(Request $request)
    {
       $validation = Validator::make($request->all(), [
            'cName' => 'required|string|max:64',
            'cLastName' => 'nullable|string|max:64',
            'cPhone' => 'required|string|min:10|max:16',
            'cEmail' => 'nullable|string|email',
            'cState' => 'required|string|max:64',
            'cAddr' => 'required|string|max:256'
        ]); 
        if ($validation->passes()) {

            $customer = new Customer();
            $customer->comp_id = Auth::user()->comp_id;
            $customer->cust_name = $request->cName;
            $customer->cust_lastname = $request->cLastName;
            $customer->cust_phone = $request->cPhone;
            $customer->cust_email = $request->cEmail;
            $customer->cust_state = $request->cState;
            $customer->cust_addr = $request->cAddr;
            $customer->save();
            return response()->json([
                'message' => 'Customer registed successfully!',
                'style' => 'color:grey'
            ]);
            
        } else {
            return response()->json([
                'message' => $validation->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }
        
       
    }
    # Show balance of a specific customer
    public function onPurchaseHistory($id)
    {
        $purchases = DB::table('customers')
        ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
        ->join('payments', 'invoices.inv_id', '=', 'payments.inv_id')
        ->select('customers.*', 'invoices.*', 'payments.*')
        // ->where('customers.cust_id', $custId)
        ->where('customers.comp_id', Auth::user()->comp_id)
        ->where('customers.cust_id', $id)
        ->get();
        // return view('customer_purchase_history', compact('purchases'));
       return view('customer_purchase_history', compact('purchases'));
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
    # Edit a customer
    public function edit(Request $request)
    {
        $validator = $request->validate([
            'cName' => 'required|string|min:5|max:64'
        ]);
        $editCustomer = Customer::findOrfail($request->cId);
        $editCustomer->cust_name = $request->cName;
        $editCustomer->cust_lastname = $request->cLastName;
        $editCustomer->cust_phone = $request->cPhone;
        $editCustomer->cust_email = $request->cEmail;
        $editCustomer->cust_state = $request->cState;
        $editCustomer->cust_addr = $request->cAddr;
       
      if ($editCustomer->save()) {
        return "The customer edited!";  
      } else if($validator->fails()) {
          return json_encode(['errors'=>$validator->errors()->all()]);
      }
      
          
            
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
    # Delete a customer from database
    public function destroy(Request $request)
    {
        $deleted = Customer::destroy('cust_id', $request->custId);
        if ($deleted) {
            echo "Customer deleted!";   
        } else {
            echo "Sorry, customer not deleted, please try again.";
        }
        
    }
}
