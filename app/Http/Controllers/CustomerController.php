<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Customer;
use App\Payment;
use Auth;
use Excel;
use Illuminate\Support\Facades\Gate;
use Validator;
use function GuzzleHttp\json_encode;
use DB;

class CustomerController extends Controller
{
    public $totalDue = 0;
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
    # new_customer.blade.php to register a customer
    public function registerCustomer()
    {
        if (Gate::allows('isSystemAdmin')) {
            return view('new_customer');
        } else {
            abort(403, 'This action is unauthorized.');
        }
    }

    # Search customers by name or phone to sell something on
    public function searchCustomer(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('customers')
                ->where('comp_id', Auth::user()->comp_id)
                ->where(function ($q) use ($query) {
                    $q->where('cust_phone', 'LIKE', "%$query%");
                    $q->orWhere('cust_name', 'LIKE', "%$query%");
                })
                ->get();
            $total_row = $data->count();

            if ($total_row > 0) {
                $output = '<ul class="dropdown-menu col-md-12"
                            style="display:block;position: relative;box-shadow:1px 2px 3px lightgrey">';
                foreach ($data as $row) {
                    $output .= '<li><a href="#" data-li-id="' . $row->cust_id . '" 
                        class="cust_search_li"> 
                        <img src="/uploads/user_photos/user.png" alt="Customer_photo" class="img-circle img-md" style="margin:auto 15px auto 10px;">
                        <input type="hidden" name="spn_cust_name" value="' . $row->cust_name . '">
                        <input type="hidden" name="spn_cust_lastname" value="' . $row->cust_lastname . '">
                        <input type="hidden" name="spn_seller_permit" value="' . $row->SellerPermitNumber . '">
                        <span class="hidden-xs username" style="font-size: 12px;color: #79b0d3">' . $row->business_name . '</span><br>
                        <span class="hidden-xs description" style="font-size: 10px">' . $row->cust_phone . '</span><br>
                        <span class="hidden-xs description" style="font-size: 10px">' . $row->cust_name . ' &nbsp;' . $row->cust_lastname . ' (' . $row->SellerPermitNumber . ')</span></a></li>';
                }
                $output .= '</ul>';
            } else {
                  $output = '<ul class="dropdown-menu col-md-12"
                            style="display:block;position: relative;box-shadow:1px 2px 3px lightgrey;text-align: center">No Customer Found.</ul>';
            }
            /*return response()->json([
              'result' => $output
           ]); */
            echo $output;
        }
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
            'business_name' => 'required|string|max:128|min:5|unique:customers,business_name',
            'seller_permit_number' => 'required|numeric|min:4|unique:customers,SellerPermitNumber',
            'first_name' => 'required|string|min:3|max:64',
            'last_name' => 'nullable|string|min:3|max:64',
            'phone' => 'required|string|min:10|max:16|unique:customers,cust_phone',
            'email' => 'nullable|string|email|unique:customers,cust_email',
            'account_number' => 'nullable|numeric|unique:customers,AccountNumber',
            'account_type_ID' => 'nullable|numeric|unique:customers,AccountTypeID',
            'limit_purchase' => 'boolean',
            'account_balance' => 'nullable|numeric|between:0,999999999.99',
            'credit_limit' => 'nullable|numeric|between:0,999999999.99',
            'HQID' => 'nullable|numeric',
            'country' => 'required|string|min:3',
            'province' => 'required|string|min:3|max:64',
            'address1' => 'required|string|min:16|max:191',
            'address2' => 'nullable|string|min:16|max:191',
            'city' => 'required|string|min:3|max:64',
            'zip_code' => 'nullable|numeric|min:4',
            'employee' => 'boolean',
            'fax_number' => 'nullable|numeric|unique:customers,FaxNumber',
            'tax_exempt' => 'boolean',
            'notes' => 'nullable|string|max:256',
            'price_level' => 'nullable|numeric|between:0,999999999.99',
            'tax_number' => 'nullable|numeric|unique:customers,TaxNumber'
        ]);
        if ($validation->passes()) {

            $customer = new Customer();

            /* ----------- Upload customer photo -----------------*/
            if ($request->hasFile('customer_photo')) {
                $image = $request->file('customer_photo');
                $path = "uploads/customer_photos/";
                $imageName = rand() . '.' . $image->getClientOriginalExtension();
                $customer->cust_photo = $imageName;
                $image->move($path, $imageName);
            }
            /* ----------- /.Upload customer photo ----------------- */

            $customer->comp_id = Auth::user()->comp_id;
            $customer->UserID = Auth::user()->id;
            $customer->business_name = $request->business_name;
            $customer->SellerPermitNumber = $request->seller_permit_number;
            $customer->cust_name = $request->first_name;
            $customer->cust_lastname = $request->last_name;
            $customer->cust_phone = $request->phone;
            $customer->cust_email = $request->email;
            $customer->AccountNumber = $request->account_number;
            $customer->AccountTypeID = $request->account_type_ID;
            $customer->LimitPurchase = $request->limit_purchase;
            $customer->AccountBalance = $request->account_balance;
            $customer->CreditLimit = $request->credit_limit;
            $customer->HQID = $request->HQID;
            $customer->Country = $request->country;
            $customer->cust_state = $request->province;
            $customer->cust_addr = $request->address1;
            $customer->Address2 = $request->address2;
            $customer->City = $request->city;
            $customer->zip_code = $request->zip_code;
            $customer->Employee = $request->employee;
            $customer->FaxNumber = $request->fax_number;
            $customer->TaxExempt = $request->tax_exempt;
            $customer->Notes = $request->notes;
            $customer->PriceLevel = $request->price_level;
            $customer->TaxNumber = $request->tax_number;

            $customer->save();
            return response()->json([
                'message' => 'Customer registered successfully!',
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
        $newSaleObject = DB::table('customers')
            ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
            ->join('payments', 'invoices.inv_id', '=', 'payments.inv_id')
            ->where('payments.comp_id', Auth::user()->comp_id)
            ->where('invoices.cust_id', $id)
            ->where('payments.trans_method', 'New Sale')
            ->orderBy('payments.payment_id', 'DESC')
            ->get();


//        List all invoices that contain Payment Received for customer transactions history
       $paymentReceived = DB::table('customers')
            ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
            ->join('payments', 'invoices.inv_id', '=', 'payments.inv_id')
            // ->where('customers.cust_id', $custId)
            ->where('payments.comp_id', Auth::user()->comp_id)
            ->where('invoices.cust_id', $id)
            ->where('payments.trans_method', 'Payment Received')
            ->orderBy('payments.payment_id', 'DESC')
            ->get();

//        customer personal-info
        $customers = DB::table('customers')->select('*')->where('comp_id', Auth::user()->comp_id)->where('cust_id', $id)->get();

//        Total Amount Paid
        $totalAmountPaid = $newSaleObject->sum('amount_paid') + $paymentReceived->sum('amount_paid');

//        $totalAmountDue = 23;
//        New Sale
        $totalSales = $newSaleObject->sum('total_invoice');

        //        Total Amount Due
        $totalAmountDue = $totalSales - $totalAmountPaid;
        if (count($newSaleObject) >= 0) {
            return view('customer_detail', compact(['customers', 'newSaleObject','totalSales', 'totalAmountPaid', 'totalAmountDue', 'paymentReceived']));
        } else {
//           return back()->with('no_purchase', 'Sorry, this customer has not done any transaction yet.');
            return view('customer_detail', compact(['customers', 'newSaleObject', 'totalSales', 'totalAmountPaid', 'totalAmountDue', 'paymentReceived']));
        }
    }

    # ================================ Make a payment ===================================
    public function onPayment(Request $request)
    {
//        $newSale = Payment::findOrfail($request->invoice_id);
        $payment = new Payment();
//        $invoiceId = DB::table('invoices')->where('cust_id', $request->customer_id)->orderBy('inv_id', 'desc')->limit(1)->value('inv_id');
//        $amountPaid = DB::table('payments')->where('inv_id', $request->invoice_id)->value('amount_paid');
//        $newSale = Payment::findorfail('inv_id', $request->invoice_id);?
        $amountDue = DB::table('payments')->where('inv_id', $request->invoice_id)->orderBy('payment_id', 'desc')->limit(1)->value('amount_due');
        $totalInvoice = DB::table('payments')->where('inv_id', $request->invoice_id)->value('total_invoice');
        $v = Validator::make($request->all(), [
            'pay_amount' => 'required|numeric|between:0,999999999999.99',
            'transaction_code' => 'nullable|numeric|between:0,999999999999'
        ]);
        if ($v->passes()) {
            /*$recAmount = $request->reciept_amount;
            $pay = Payment::where('inv_id', '=', $invoiceId)->first();
            $pay->amount_paid += $recAmount;
            $pay->amount_due -= $recAmount;
            $pay->trans_type = "Credit";*/

//            Save payment in to table payments

            $payment->inv_id = $request->invoice_id;
            $payment->comp_id = Auth::user()->comp_id;
            $payment->trans_method = "Payment Received";
            if ($request->has('transaction_code')) {
                $payment->trans_code = $request->transaction_code;
            }
            $payment->payment_method = $request->payment_method;
//            $receivedAmount += $request->pay_amount;
            $amountDue -= $request->pay_amount;
            $payment->amount_paid = $request->pay_amount;
            $payment->amount_due = $amountDue;
            DB::table('payments')->where('inv_id', $request->invoice_id)->where('trans_method', 'New Sale')->update(['amount_due' => $amountDue]);
            $this->totalDue = $amountDue;
            $payment->total_invoice = $totalInvoice;
            if ($payment->save()) {
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
            'seller_permit_number' => 'required|numeric|min:4|unique:customers,SellerPermitNumber,' . $request->cust_id . ',cust_id',
            'business_name' => 'nullable|string|min:3|max:64',
            'cust_phone' => 'required|string|min:10|max:64',
            'cust_email' => 'nullable|email|min:6|max:64',
            'cust_state' => 'required|string|min:4|max:64',
            'address1' => 'required|string|min:4|max:64',
            'address2' => 'nullable|string|min:4|max:64',
            'country' => 'required|string|min:3',
            'city' => 'required|string|min:3',
            'zip_code' => 'nullable|numeric|min:4'
        ]);

        if ($v->passes()) {
            $editCustomer = Customer::findOrfail($request->cust_id);
            $editCustomer->business_name = $request->business_name;
            $editCustomer->SellerPermitNumber = $request->seller_permit_number;
            $editCustomer->cust_phone = $request->cust_phone;
            $editCustomer->cust_email = $request->cust_email;
            $editCustomer->cust_state = $request->cust_state;
            $editCustomer->cust_addr = $request->address1;
            $editCustomer->Address2 = $request->address2;
            $editCustomer->Country = $request->country;
            $editCustomer->City = $request->city;
            $editCustomer->zip_code = $request->zip_code;
            $editCustomer->LimitPurchase = $request->limit_puchase;
            $editCustomer->CreditLimit = $request->credit_limit;
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
    /*public function destroy(Request $request)
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


    }*/

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
                            'AccountTypeID' => $row['account_type_id'],
                            'created_at' => carbon::now(),
                            'updated_at' => carbon::now(),
                            'LimitPurchase' => $row['limit_purchase'],
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
                            'TaxNumber' => $row['tax_number'],
                            'UserID' => Auth::user()->id,
                            'SalesRepID' => $row['sales_rep_id'],
                            'PriceLevel' => $row['price_level'],
                            'TotalSavings' => $row['total_savings'],
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
                'tax_number',
                'user_id',
                'sales_rep_id',
                'price_level',
                'total_savings',
            );
            foreach ($customers as $customer) {
                $customers_array[] = array(
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
                    'tax_number' => $customer->TaxNumber,
                    'user_id' => $customer->UserID,
                    'sales_rep_id' => $customer->SalesRepID,
                    'price_level' => $customer->PriceLevel,
                    'total_savings' => $customer->TotalSavings,
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

    /* ========================================= Upload Customer Photo =======================================*/
    # This is moved into function store above
    /*public function onUploadPhoto(Request $request) {
        $v = Validator::make($request->all(), [
            'customer_photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($v->passes()) {
            $customer = new Customer();
            if ($request->hasFile('customer_photo')) {
                $image = $request->file('customer_photo');
                $path = "uploads/customer_photos/";
                $logo_name = rand() . '.' . $image->getClientOriginalExtension();
                $customer->comp_logo = $logo_name;
                $image->move($path, $logo_name);
                $customer->save();
                return response()->json([
                    'msg' => 'Customer photo updated successfully!',
                    'style' => 'color:darkblue',
                    'result' => 'success'
                ]);
            }
        } else {
            return response()->json([
                'msg' => $v->errors()->all(),
                'style' => 'color:darkred',
                'result' => 'fail'
            ]);
        }

    }*/
    /* ========================================= /. Upload Customer Photo =======================================*/
}
