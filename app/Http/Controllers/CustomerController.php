<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Customer;
use App\Payment;
use Auth;
use Excel;
use Illuminate\Support\Facades\Gate;
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
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $customers = Customer::all()->where('comp_id', Auth::user()->comp_id);
            return view('customer', compact('customers'));
        } else {
            abort(403, 'This action is unauthorized.');
        }


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
            'cBName' => 'required|string|max:128|min:5',
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
            $customer->business_name = $request->cBName;
            $customer->cust_name = $request->cName;
            $customer->cust_lastname = $request->cLastName;
            $customer->cust_phone = $request->cPhone;
            $customer->cust_email = $request->cEmail;
            $customer->cust_state = $request->cState;
            $customer->cust_addr = $request->cAddr;
            $customer->save();
            return response()->json([
                'message' => 'Customer registed successfully!',
                'result' => 'success',
                'style' => 'color:grey'
            ]);

        } else {
            return response()->json([
                'message' => $validation->errors()->all(),
                'result' => 'fail',
                'style' => 'color:darkred'
            ]);
        }


    }
    # Show balance of a specific customer
    public function onPurchaseHistory($id = null)
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
        $recieved = $purchases->sum('recieved_amount');
        $recievable = $purchases->sum('recievable_amount');
        $totalTransaction = $recievable + $recieved;
        if (count($purchases) > 0 ) {
            return view('customer_detail', compact(['purchases', 'recieved', 'recievable', 'totalTransaction']));
        } else {
            abort(403, 'Sorry, this customer has not purchased anything yet.');
        }
    }

    # ================================ Make a payment ===================================
    public function onPayment(Request $request)
    {
        $invoiceId = DB::table('invoices')->where('cust_id', $request->customer_id)->orderBy('inv_id', 'desc')->limit(1)->value('inv_id');
        $v = Validator::make($request->all(), [
            'reciept_amount' => 'required|numeric|between:0,999999999999.99'
        ]);
        if ($v->passes()) {
            $recAmount = $request->reciept_amount;
            $pay = Payment::where('inv_id', '=', $invoiceId)->first();
            $pay->recieved_amount += $recAmount;
            $pay->recievable_amount -= $recAmount;
            $pay->trans_type = "Credit";
            if ($pay->save()) {
                return response()->json([
                    'result' => 'success',
                    'style' => 'color:darkblue',
                    'message' => 'Thanks, payment was success!'
                ]);
            }
        } else {
            return response()->json([
                'result' => 'fail',
                'style' => 'color:darkred',
                'message' => $v->errors()->all()
            ]);
        }




    }
    # ================================/. Make a payment ===================================
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
        $v = Validator::make($request->all(), [
            'cust_firstname' => 'required|string|min:5|max:64',
            'cust_lastname' => 'nullable|string|min:5|max:64',
            'business_name' => 'nullable|string|min:5|max:64',
            'cust_phone' => 'required|string|min:10|max:64',
            'cust_email' => 'nullable|email|min:6|max:64',
            'cust_state' => 'required|string|min:4|max:64',
            'cust_address' => 'required|string|min:4|max:64'
        ]);

        if ($v->passes()) {
            $editCustomer = Customer::findOrfail($request->cust_id);
            $editCustomer->business_name = $request->business_name;
            $editCustomer->cust_name = $request->cust_firstname;
            $editCustomer->cust_lastname = $request->cust_lastname;
            $editCustomer->cust_phone = $request->cust_phone;
            $editCustomer->cust_email = $request->cust_email;
            $editCustomer->cust_state = $request->cust_state;
            $editCustomer->cust_addr = $request->cust_address;
            $editCustomer->save();
            return response()->json([
                'cust_msg' => 'Customer edited successfully!',
                'style' => 'color:grey'
            ]);
        }
        else  {
            return response()->json([
                'cust_msg' => $v->errors()->all(),
                'style' => 'color:red'
            ]);
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
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $deleted = Customer::destroy('cust_id', $request->custId);
            if ($deleted) {
                echo "Customer deleted!";
            } else {
                echo "Sorry, customer not deleted, please try again.";
            }
        } else {
            abort(403, 'This action is unauthorized');
        }


    }

    /*======================= Import/Export Excel =====================*/
    public function importExcel(Request $request) {
        /*$request->validate([
           'excel_file' => 'required|mimes:xlsx, xls'
        ]);*/
        if ($request->hasFile('excel_file')) {
            $path = $request->file('excel_file')->getRealPath();
            $data = Excel::load($path)->get();
            foreach ($data->toArray() as $key => $value) {
                foreach ($value as $row) {
                    $insert_data[] = array(
                        'comp_id' => $row[Auth::user()->comp_id],
                        'ctg_id' => $row['ctg'],
                        'sup_id' => $row['supplier'],
                        'item_name' => $row['item_name'],
                        'item_desc' => $row['item_desc'],
                        'item_image' => $row['item_image'],
                        'puchase_price' => $row['puchase_price'],
                        'sell_price' => $row['sell_price'],
                        'quantity' => $row['qty'],
                        'barcode_number' => $row['barcode'],
                        'discount' => $row['discount'],
                        'taxable' => $row['taxable'],
                    );
                }
            }
            if (!empty($insert_data)) {
                DB::table('items')->insert($insert_data);
                return back()->with('success', 'Excel data imported successfully!');
            }

        }
    }

//    Export excel
    public function exportExcel() {
        $c = '';
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $compId = Auth::user()->comp_id;
            $c = Company::where('company_id', $compId)->get(['comp_name']);
            $customers = Customer::where('comp_id', $compId)->get();
            $customers_array[] = array('Business Name', 'First Name', 'Last Name', 'Phone', 'Email', 'State/Province', 'Address', 'Reg. Date');
            foreach ($customers as $customer) {
                $customers_array[] = array(
                    'Business Name' => $customer->business_name,
                    'First Name' => $customer->cust_name,
                    'Last Name' => $customer->cust_lastname,
                    'Phone' => $customer->cust_phone,
                    'Email' => $customer->cust_email,
                    'State/Province' => $customer->cust_state,
                    'Address' => $customer->cust_addr,
                    'Reg. Date' => carbon::parse($customer->created_at)->format('d-M-Y')
                );
            }
            Excel::create('Customer', function ($excel) use ($customers_array) {
                $excel->setTitle('Customers');
                $excel->sheet('Customers', function ($sheet) use ($customers_array) {
                    $sheet->fromArray($customers_array, null, 'A1', false, false);
                });
            })->download('xlsx');

        } else {
            abort(403, 'This action is unauthorized.');
        }
    }
    /* ============================= Import/Export Excel ========================*/
}
