<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use function GuzzleHttp\json_encode;
use App\Customer;
use App\Sale;
use App\Invoice;
use App\Category;
use App\Payment;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Carbon;
use App\Item;
use App\User;
use App\Company;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Timer\Timer;

class AndroidAPIController extends Controller
{
    #Login for system-admin
    public function onLogin(Request $request) {
         $username = $request->username;
         $password = $request->password;

        if (Auth::attempt(['username' => $username, 'password' => $password, 'status'=>1])) {
            $users = DB::table('users')->select('*')->where('username', $username)->get();
               foreach ($users as $user) {
                   $compId = $user->comp_id;
                   $userId = $user->id;
                   $fname = $user->name;
                   $lname = $user->lastname;
                   $phone = $user->phone;
                   $role = $user->role;
                   $status = $user->status;
                   $photo = $user->photo;

                   return response()->json([
                        'compId' => $compId,
                        'userId' => $userId,
                        'fname' => $fname,
                        'lname' => $lname,
                        'phone' => $phone,
                        'role' => $role,
                        'status' => $status,
                        'photo' => $photo
                   ]);
               }
        } else {
            return "fail";
        }
    }

    # Load inventory-data into API
    # This API end-point requires the client side application to send company-id with the request to get company specific data
    public function onInventory(Request $request)
    {
        $items = DB::table('items')->select('*')->where('comp_id', $request->compId)->get();
            return json_encode($items);
    }

    # Load customers based on a specific company
    # This API end-point requires the client side application to send company-id with the request to get company specific data
    public function onListCustomer(Request $request)
    {
        $customers = DB::table('customers')->select('*')->where('comp_id', $request->compId)->get();
        if (isset($customers)) {
            return json_encode($customers);
        } else {
            return "not found";
        }
    }

    # Register new customer
    public function onRegisterCustomer(Request $request)
    {
         $customer = new Customer();
         $customer->comp_id = $request->compId;
         $customer->cust_name = $request->custName;
         $customer->cust_lastname = $request->custLastName;
         $customer->cust_phone = $request->custPhone;
         $customer->cust_email = $request->custEmail;
         $customer->cust_state = $request->custState;
         $customer->cust_addr = $request->custAddress;

        if ($customer->save()) {
            return "success";
        } else {
            return "fail";
        }
    }

    # Edit customer using his/her ID
    public function onEditCustomer(Request $request)
    {
         $customer = Customer::findOrfail($request->custId);
         $customer->comp_id = $request->compId;
         $customer->cust_name = $request->custName;
         $customer->cust_lastname = $request->custLname;
         $customer->cust_phone = $request->custPhone;
         $customer->cust_email = $request->custEmail;
         $customer->cust_state = $request->custState;
         $customer->cust_addr = $request->custAddress;

        if ($customer->save()) {
            return "success";
        } else {
            return "fail";
        }
    }

    # Change customer-status
    public function onChangeCustomerStatus(Request $request)
    {
        $message = "";
        $customer = Customer::findOrfail($request->custId);
        $statusValue = $request->statusValue;
        $customer->cust_status = $statusValue;

        if ($customer->save()) {
             if ($customer->cust_status == 1) {
                 $message = "active";
                 echo $message;
             }
           elseif ($customer->cust_status == 0) {
                $message = "inactive";
                echo $message;
            }
        }
    }

    # Show balance of a specific customer
    public function onCheckCustomerBalance(Request $request)
    {
        $purchases = DB::table('customers')
            ->join('invoices', 'customers.cust_id', '=', 'invoices.cust_id')
            ->join('payments', 'invoices.inv_id', '=', 'payments.inv_id')
            ->select('customers.*', 'invoices.*', 'payments.*')
            // ->where('customers.cust_id', $custId)
            ->where('customers.comp_id', $request->compId)
            ->where('customers.cust_id', $request->custId)
            ->get();
        // return view('customer_purchase_history', compact('purchases'));
        // return view('customer_purchase_history', compact('purchases'));
        return json_encode($purchases);
    }

    # Create invoice, sale, and payment
    public function onCreateSale(Request $request)
    {
        $productId = '';
        $qtySold = '';
        $json = json_decode($request-> params, true);
        $compID = $json[0]["compId"];
        $custID = $json[0]["custId"];
        $invoice = new Invoice();
        $invoice->comp_id = $compID;
        $invoice->cust_id = $custID;
        if ($invoice->save()) {
            $invoiceId = DB::table('invoices')->where('cust_id', $custID)->orderBy('inv_id', 'desc')->limit(1)->value('inv_id');
            foreach ($json as $obj) {
                $productId = $obj['id'];
                $qtySold = $obj['qty'];
                $sold = Sale::create([
                    'inv_id' => $invoiceId,
                    'comp_id' => $compID,
                    'item_id' => $productId,
                    'qty_sold' => $qtySold,
                    'sell_price' => $obj['price'],
                    'tax' => 3,
                    # This is a calculated field which is not required to be stored in database and can be calculated in application level any time.
                    'subtotal' => $obj['subtotal']
                ]);
                # Decrease in-stock products based on sold quantities
                DB::table('items')->where('item_id', $productId)->update(['quantity' => DB::raw('GREATEST(quantity - ' . $qtySold . ', 0)')]);

            }
            if ($sold) {
                $payment = new Payment();
                $payment->inv_id = $invoiceId;
                $payment->comp_id = $compID;
                $payment->trans_code = $request->transCode;
                $payment->payment_type = $request->payType;
                $payment->recieved_amount = $request->recieved;
                $payment->recievable_amount = $request->recievable;
                if ($payment->save()) {
                    return "success!";
                }
            }
        }

    }
    # register new category
    public function onNewCategory(Request $request)
    {
        $category = new Category();
        $category->comp_id = $request->compId;
        $category->ctg_name = $request->ctgName;
        $category->ctg_desc = $request->ctgDesc;
        if ($category->save()) {
            return "success";
        } else {
            return "fail";
        }
    }
    # load categories
    public function onListCategory(Request $request)
    {
        $categories = DB::table('categories')->select('*')->where('comp_id', $request->compId)->get();
        return json_encode($categories);
    }
    # Edit Category
    public function onEditCategory(Request $request)
    {
        $category = Category::findOrfail($request->ctgId);
        $category->ctg_name = $request->ctgName;
        $category->ctg_desc = $request->ctgDesc;
        if ($category->save()) {
            return "success";
        } else {
            return "fail";
        }

    }

    # Add new product
    public function onNewProduct(Request $request)
    {
        $item = new Item();
        $item->comp_id = $request->compId;
        $item->ctg_id = $request->ctgId;
        $item->item_name = $request->pName;
        $item->item_desc = $request->pDesc;
        $item->quantity = $request->pQty;
        $item->barcode_number = $request->pBarcode;
        $item->purchase_price = $request->pPurchase;
        $item->sell_price = $request->pSell;
        $item->discount = 0;
        $item->taxable = $request->pTaxable;
        if ($item->save()) {
            return "success";
        } else {
            return "fail";
        }

    }
    # Load products
    public function loadProduct(Request $request)
    {
        $items = DB::table('items')->select('*')->where('ctg_id', $request->ctgId)->where('comp_id', $request->compId)->get();
        return json_encode($items);

    }

    /* ============ DAILY, WEEKLY, MONTHLY, MORE... REPORTS ================= */
    # Daily reports
    public function salesReport(Request $request)
    {
        $time = $request->timeValue;
        $query = '';
        $cash = '';
        $master = '';
        $debit = '';

        if ($time == 0) {
            $query = DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at',  DB::raw('CURDATE()'))
                ->get();
            # to calculate total of credit-card, debit-card, or cash of today
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  DB::raw('CURDATE()'))->sum('recieved_amount');
        } elseif ($time == 1) {
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at',  Carbon::now()->subDays(1))
                ->get();
            # to calculate total of credit-card, debit-card, or cash of Yerterday
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(1))->sum('recieved_amount');
        } elseif ($time == 2) {
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                ->get();
            # to calculate total of credit-card, debit-card, or cash of LAST 7 DAYS
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate( 'created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate( 'created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate( 'created_at', '>=', Carbon::now()->subDays(7))->sum('recieved_amount');
        } elseif ($time == 3) {
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                ->get();
            # to calculate total of credit-card, debit-card, or cash of LAST 30 DAYS
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())->sum('recieved_amount');
        } elseif($time == 4) {
            # This week
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->get();
            # to calculate total of credit-card, debit-card, or cash for THIS WEEK
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('recieved_amount');
        } elseif ($time == 5) {
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->where('created_at', '<=',  Carbon::now()->subDays(7)->startOfDay())
                ->get();
            # to calculate total of credit-card, debit-card, or cash for LAST WEEK
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate('created_at',  Carbon::now()->subDays(7))->sum('recieved_amount');
        } elseif ($time == 6) {
            # THIS MONTH
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->get();
            # to calculate total of credit-card, debit-card, or cash for THIS MONTH
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('recieved_amount');

        } elseif ($time == 7) {
            # LAST MONTH
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                ->get();
            # to calculate total of credit-card, debit-card, or cash for LAST MONTH
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(30))->sum('recieved_amount');
        } elseif ($time == 8) {
            # THIS YEAR
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                ->get();
            # to calculate total of credit-card, debit-card, or cash for THIS YEAR
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->whereBetween('created_at',  [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('recieved_amount');
        } elseif ($time == 9) {
            # LAST YEAR
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->whereDate('created_at', '<=', Carbon::now()->subDays(365))
                ->get();
            # to calculate total of credit-card, debit-card, or cash for LAST YEAR
            $cash = DB::table('payments')->where('comp_id', $request->compId)->whereDate('payment_type', 'Cash')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->whereDate('payment_type', 'Master Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->whereDate('payment_type', 'Debit Card')->whereDate('created_at', '<=', Carbon::now()->subDays(365))->sum('recieved_amount');
        } elseif($time == 10) {
            # ALL TIME
            $query =  DB::table('payments')
                ->select('*')
                ->where('comp_id', $request->compId)
                ->get();
            # to calculate total of credit-card, debit-card, or cash for ALL TIME
            $cash = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Cash')->sum('recieved_amount');
            $master = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Master Card')->sum('recieved_amount');
            $debit = DB::table('payments')->where('comp_id', $request->compId)->where('payment_type', 'Debit Card')->sum('recieved_amount');
        }
        $recieved = $query->sum('recieved_amount');
        $recievable = $query->sum('recievable_amount');
        $total = $recievable + $recieved;
        return response()->json([
            'cash' => $cash,
            'master' => $master,
            'debit' => $debit,
            'total' => $total,
            'recieved' => $recieved,
            'recievable' => $recievable
        ]);
    }

/* ============ /. DAILY, WEEKLY, MONTHLY, MORE... REPORTS ================= */
    # List all users
    public function onListUser(Request $request)
    {
        $users = DB::table('users')->where('comp_id', $request->compId)->get();
        return json_encode($users);
    }

    # Change user-status
    public function onChangeUserStatus(Request $request)
    {
        $userMessage = "";
        $user = User::findOrfail($request->userId);
        $statusValue = $request->statusValue;
        $user->status = $statusValue;

        if ($user->save()) {
            if ( $user->status == 1) {
                $userMessage = "active";
                echo $userMessage;
            } elseif ( $user->status == 0) {
                $userMessage = "inactive";
                echo $userMessage;
            }
        }
    }

    # Register new user
    public function onRegisterUser(Request $request)
    {
        $users = DB::table('users')->where('comp_id', $request->compId)->get();
        $count = $users->count();
        $countValues = DB::table('companies')
                ->join('users', 'companies.company_id', '=', 'users.comp_id')
                ->select('companies.user_count', 'companies.comp_status')
                ->where('users.id', $request->userId)
                ->get();
            $user_count = $countValues[0]->user_count;
            $compStatus = $countValues[0]->comp_status;

            if ($compStatus == 1) {

                if ($count < $user_count) {
                    $user = new User();
                    $user->comp_id = $request->compId;
                    $user->name = $request->uFname;
                    $user->lastname = $request->uLastname;
                    $user->phone = $request->uPhone;
                    $user->email = $request->uEmail;
                    $user->role = $request->uRole;
                    $user->username = $request->uName;
                    $user->password = Hash::make($request->uPassword);
                    $user->save();
                    return response()->json([
                        'user_msg' => "User registered successfully!"
                    ]);
                }
                return response()->json([
                    'user_msg' => 'Sorry, your user count has reached to its maximum size.'
                ]);
            } else if ($compStatus == 0) {
                return response()->json([
                    'user_msg' => 'Sorry, the company is not active.'
                ]);
            }
    }
    # Set User's role
    public function onSetUserRole(Request $request)
    {
        $user = User::findOrfail($request->userId);
        $user->role = $request->role;
        if ($user->save()) {
            return "success";
        } else {
            return "fail";
        }

    }
}
