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
        $this->middleware(['auth', 'can:isSuperAdmin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    # =============================== FOR SUPER-ADMIN to do something with companies ====================
    public function index()
    {
            $id = Auth::user()->id;
            $counts = DB::table('companies')
                ->join('users', 'companies.company_id', '=', 'users.comp_id')
                ->select('companies.user_count')
                ->first();
        $companies = DB::table('companies')->get();
        return view('company', compact(['companies', 'counts']));
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
            'user_name' => 'required|string|max:128|min:5',
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
            $user->username = $request->user_name;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'user_msg' => 'System admin registered successfully!',
                'result' => 'ok',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'user_msg' => $validation->errors()->all(),
                'result' => 'fail',
                'style' => 'color:darkred'
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
            'comp_contact' => 'required|string|max:64|min:10',
            'comp_email' => 'nullable|email|string|max:64|min:5'
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
                'result' => 'ok',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'comp_msg' => $validation->errors()->all(),
                'result' => 'fail',
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
    # Load a specific company when a link of companies clicked.
    public function onSetCompany($compId)
    {
        $users = DB::table('users')->select('*')->where('comp_id', $compId)->get();
        $companies = DB::table('companies')->where('company_id', $compId)->get();
        return view('company_setting', compact(['companies', 'compId', 'users']));
    }
    # Edit the specific loaded company while clicking the link
    public function onSaveCompanySetting(Request $request)
    {
        $company = Company::findOrfail($request->cid);

        $validation = Validator::make($request->all(), [
            'cname' => 'required|string|max:64|min:5',
            'cstate' => 'required|string|max:64',
            'ccity' => 'required|string|max:128',
            'caddress' => 'required|string|max:128',
            'ccontact' => 'required|string|max:64',
            'cemail' => 'nullable|string|max:64',
      ]);


      if ($validation->passes()) {
                if ($request->cname) {
                    $company->comp_name = $request->cname;
                }
                $company->comp_city = $request->ccity;
                $company->comp_address = $request->caddress;
                $company->comp_state = $request->cstate;
                $company->contact_no = $request->ccontact;
                $company->email = $request->cemail;
                $company->comp_status = $request->cstatus;
                $company->user_count = $request->ucount;


            if ($company->save()) {
                return response()->json([
                    'msg' => 'Changes saved successfully!',
                    'style' => 'color:darkblue'
                ]);
            } else {
                return response()->json([
                    'msg' => 'Sorry, something wrong, please try again.'
                ]);
            }
      } else {
          return response()->json([
            'msg' => '<ul><li>company name required</li><li>Province/State required</li><li>City required</li><li>Address required</li><li>Contact required</li></ul>',
            'style' => 'color:darkred'
          ]);
      }
    }

    # =================================== change a specific company LOGO ===========================
    public function changeLogo(Request $request)
        {
            $v = Validator::make($request->all(), [
                'company_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048'
            ]);
            if ($v->passes()) {
                $company = Company::findOrfail($request->cid);
                if ($request->hasFile('company_logo')) {
                    $img = $request->file('company_logo');
                    $path = "uploads/logos/";
                    $img_name = rand() . '.' . $img->getClientOriginalExtension();
                    $company->comp_logo = $img_name;
                    $img->move($path, $img_name);
                    $company->save();
                    return response()->json([
                        'message' => 'Logo changed successfully!',
                        'style' => 'color:darkblue',
                        'result' => 'ok'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => $v->errors()->all(),
                    'result' => 'fail',
                    'style' => 'color:darkred'
                ]);
            }

        }
    # =================================== /. change a specific company LOGO ===========================

    #==============================================Change user-count of company ================================================
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
# ================================ /. FOR SUPER-ADMIN to do some thing for companies ===================================

}
