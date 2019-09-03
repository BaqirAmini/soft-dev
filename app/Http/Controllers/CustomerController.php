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
     * @param \Illuminate\Http\Request $request
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
//        Customers' transactions
        $purchases = DB::table('customers')
            ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
            ->join('payments', 'invoices.inv_id', '=', 'payments.inv_id')
            ->select( 'invoices.*', 'payments.*')
            // ->where('customers.cust_id', $custId)
            ->where('customers.comp_id', Auth::user()->comp_id)
            ->where('customers.cust_id', $id)
            ->get();

//        customer personal-info
        $customers = DB::table('customers')->select('*')->where('comp_id', Auth::user()->comp_id)->where('cust_id', $id)->get();

        // return view('customer_purchase_history', compact('purchases'));
        $recieved = $purchases->sum('recieved_amount');
        $recievable = $purchases->sum('recievable_amount');
        $totalTransaction = $recievable + $recieved;
        if (count($purchases) > 0) {
            return view('customer_detail', compact(['customers','purchases', 'recieved', 'recievable', 'totalTransaction']));
        } else {
//           return back()->with('no_purchase', 'Sorry, this customer has not done any transaction yet.');
            return view('customer_detail', compact(['customers','purchases', 'recieved', 'recievable', 'totalTransaction']));
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
        } else {
            return response()->json([
                'cust_msg' => $v->errors()->all(),
                'style' => 'color:red'
            ]);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required'
        ]);
        if ($request->hasFile('excel')) {
            $filePath = $request->file('excel')->getRealPath();
            $data = Excel::load($filePath)->get();
            $value = $data->toArray();
            if (!empty($data) && $data->count()) {
                if ($data->count() > 0) {
                    foreach ($value as $row) {
                        $insert_customer[] = array(
                            'AccountNumber' => $row['account_number'],
                            'AccountTypeID' => $row['account_type_id'],
                            'created_at' => carbon::now(),
                            'updated_at' => carbon::now(),
                            'LimitPurchase' => $row['limit_purchase'],
                            'AccountBalance' => $row['account_balance'],
                            'CreditLimit' => $row['credit_limit'],
                            'TotalSales' => $row['total_sales'],
                            'last_visit' => $row['last_visit'],
                            'total_visit' => $row['total_visits'],
                            'CurrentDiscount' => $row['current_discount'],
                            'business_name' => $row['business_name'],
                            'comp_id' => Auth::user()->comp_id,
                            'HQID' => $row['hq_id'],
                            'Country' => $row['country'],
                            'cust_state' => $row['province'],
                            'cust_addr' => $row['address1'],
                            'Address2' => $row['address2'],
                            'City' => $row['city'],
                            'zip_code' => $row['zip_code'],
                            'StoreID' => $row['store_id'],
                            'Title' => $row['title'],
                            'Employee' => $row['employee'],
                            'cust_name' => $row['first_name'],
                            'cust_lastname' => $row['last_name'],
                            'cust_phone' => $row['phone'],
                            'cust_status' => $row['status'],
                            'FaxNumber' => $row['fax_number'],
                            'TaxExempt' => $row['tax_exempt'],
                            'Notes' => $row['notes'],
                            'cust_email' => $row['email'],
                            'DBTimeStamp' => $row['db_time_stamp'],
                            'TaxNumber' => $row['tax_number'],
                            'UserID' => Auth::user()->id,
                            'SalesRepID' => $row['sales_rep_id'],
                            'PriceLevel' => $row['price_level'],
                            'TotalSavings' => $row['total_savings'],
                            'AssessFinanceCharges' => $row['assess_finance_charges'],
                        );
                    }
                    if (!empty($insert_customer)) {
//                        DB::table('categories')->select('ctg_id')->where()->get();
                        DB::table('customers')->insert($insert_customer);
                    }
                    return back()->with('success', 'Excel data imported successfully!');
                }
            }
        }

    }

//    Export excel
    public function exportExcel()
    {
        $c = '';
        if (Gate::allows('isSystemAdmin') || Gate::allows('isCashier')) {
            $compId = Auth::user()->comp_id;
            $c = Company::where('company_id', $compId)->get(['comp_name']);
            $customers = Customer::where('comp_id', $compId)->get();
            $customers_array[] = array(
                'account_number',
                'account_type_id',
                'account_opened',
                'limit_purchase',
                'account_balance',
                'credit_limit',
                'total_sales',
                'last_visit',
                'total_visits',
                'current_discount',
                'business_name',
                'hq_id',
                'country',
                'province',
                'address1',
                'address2',
                'city',
                'zip_code',
                'store_id',
                'id',
                'title',
                'employee',
                'first_name',
                'last_name',
                'phone',
                'status',
                'fax_number',
                'tax_exempt',
                'notes',
                'email',
                'db_time_stamp',
                'tax_number',
                'user_id',
                'sales_rep_id',
                'price_level',
                'total_savings',
                'assess_finance_charges',
            );
            foreach ($customers as $customer) {
                $customers_array[] = array(
                    'account_number' => $customer->AccountNumber,
                    'account_type_id' => $customer->AccountTypeID,
                    'account_opened' => carbon::parse($customer->created_at)->format('m-D-Y'),
                    'limit_purchase' => $customer->LimitPurchase,
                    'account_balance' => $customer->AccountBalance,
                    'credit_limit' => $customer->CreditLimit,
                    'total_sales' => $customer->TotalSales,
                    'last_visit' => $customer->last_visit,
                    'total_visits' => $customer->total_visit,
                    'current_discount' => $customer->CurrentDiscount,
                    'business_name' => $customer->business_name,
                    'hq_id' => $customer->HQID,
                    'country' => $customer->Country,
                    'province' => $customer->cust_state,
                    'address1' => $customer->cust_addr,
                    'address2' => $customer->Address2,
                    'city' => $customer->City,
                    'zip_code' => $customer->zip_code,
                    'store_id' => $customer->StoreID,
                    'id' => $customer->cust_id,
                    'title' => $customer->Title,
                    'employee' => $customer->Employee,
                    'first_name' => $customer->cust_name,
                    'last_name' => $customer->cust_lastname,
                    'phone' => $customer->cust_phone,
                    'status' => $customer->cust_status,
                    'fax_number' => $customer->FaxNumber,
                    'tax_exempt' => $customer->TaxExempt,
                    'notes' => $customer->Notes,
                    'email' => $customer->cust_email,
                    'db_time_stamp' => $customer->DBTimeStamp,
                    'tax_number' => $customer->TaxNumber,
                    'user_id' => $customer->UserID,
                    'sales_rep_id' => $customer->SalesRepID,
                    'price_level' => $customer->PriceLevel,
                    'total_savings' => $customer->TotalSavings,
                    'assess_finance_charges' => $customer->AssessFinanceCharges,
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
