<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use App\Company;

use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
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
        $companies = DB::table('companies')->get();
        return view('company', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    # Create an Admin for company first to be able use the system
    public function createSystemAdmin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|string|max:64',
            'last_name' => 'nullable|string|max:64',
            'phone' => 'required|unique:users|string|min:10',
            'email' => 'nullable|unique:users|email|max:128',
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        if ($validation->passes()) {
            $user = new User();
            $user->comp_id = $request->company;
            $user->name = $request->first_name;
            $user->lastname = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save(); 
            return response()->json([
                'user_msg' => 'User registered successfully!',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'user_msg' => $validation->errors()->all(),
                'style' => 'color:red'
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    # Register NEW company
    public function store(Request $request)
    {
        $company = new Company();
        $validation = Validator::make($request->all(), [
            'comp_name' => 'required|unique:companies|string|max:64',
            'comp_state' => 'required|string|max:64',
            'comp_city' => 'required|string|max:128',
            'comp_address' => 'required|string|max:128',
            'comp_contact' => 'required|string|max:64',
            'comp_email' => 'nullable|string|max:64',
        ]);

        if ($validation->passes()) {
            $company->comp_name = $request->comp_name;
            $company->comp_state = $request->comp_state;
            $company->comp_city = $request->comp_city;
            $company->comp_address = $request->comp_address;
            $company->contact_no = $request->comp_contact;
            $company->email = $request->comp_email;
            $company->save();
            return response()->json([
                'comp_msg' => 'Company registered successfully!',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'comp_msg' => $validation->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    # Check companies to see if active or inactive
    public function onCompanyStatus(Request $request)
    {
        $company = Company::findOrfail($request->compId);
        $comp_status = $request->compStatus;
        if ($comp_status == 1) {
                $company->comp_status = 0;
        } else {
                $company->comp_status = 1;
        }
        // check if saved
        if ($company->save()) {
           if ($company->comp_status == 1) {
               return response()->json([
                    'remove_class' => 'btn-xs btn btn-danger',
                    'add_class' => 'btn-xs btn btn-success',
                    'label' => 'Active'
               ]);
           } else {
            return response()->json([
                'remove_class' => 'btn-xs btn btn-success',
                'add_class' => 'btn-xs btn btn-danger',
                'label' => 'Inactive'
           ]);
           }
           
        }
        
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function whichCompany()
    {
        $userId = Auth::user()->id;
        $companyId = Auth::user()->comp_id;
        $companies = DB::table('companies')
        ->join('users', 'companies.company_id', '=', 'users.comp_id')
        ->select('companies.*')
        ->where('users.id', $userId)
        ->get();
        return view('company_settings', compact('companies'));
    }

    #Change user-count of company
    public function userCount(Request $request)
    {
        $company = Company::findOrfail($request->compId);
        $company->user_count = $request->userCount;
        if ($company->save()) {
            return response()->json([
                'count_msg' => 'User count changed successfully!',
                'style' => 'color:darkblue'
            ]);
        } else {
            return response()->json([
                'count_msg' => 'Sorry, user count not changed!',
                'style' => 'color:darkred'
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
    public function destroy($id)
    {
        //
    }
}
