<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Auth;
use Gate;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    # List users for authenticated System-admin
    public function index()
    { 
        if (Gate::allows('isSystemAdmin')) {
            if (Auth::check()) {
                $userId = Auth::user()->id;
                $compId = Auth::user()->comp_id;
                $users = DB::table('users')->where('comp_id', $compId)->get();
                $count = $users->count();

                # ============== Enable/Disable button (Add User) based on defined user-count ===================
                # Exclude user-status only regard existing users
                $registeredUSers = DB::table('users')->where('comp_id', $compId)->get();
                # Check active users
                $activeUsers = DB::table('users')->where('comp_id', $compId)->where('status', 1)->get();
                $activeCount = $registeredUSers->count();
                $existingCount = $activeUsers->count();
                $countValues = DB::table('companies')
                    ->join('users', 'companies.company_id', '=', 'users.comp_id')
                    ->select('companies.user_count', 'companies.comp_status')
                    ->where('users.id', $userId)
                    ->get();
                // See number of define users in companies
                $user_count = $countValues[0]->user_count;
                # ================ /. Enable/Disable button (Add User) =====================
                return view('users', compact(['users', 'count', 'user_count', 'activeCount', 'existingCount']));
            } 
        } else {
            abort(403, 'This action is unauthorized.');
        }
          
        
    }
    # List users of a specific company that Super-admin can see
   /* public function usersOfSpecificCompany($compId)
    {
        $users = DB::table('users')->select('*')->where('comp_id', $compId)->get();
        return view('company_setting', compact('users'));
    } */
    # /. 
    #Manage roles...
    public function changeRole(Request $request) {
            $user = User::findOrFail($request->role_id);
            $user->role = $request->role;
            if($user->save()) {
                return response()->json([
                    'role_msg' => 'The role changed successfully!'
                ]);
                
            } else {
               return response()->json([
                'role_msg' => 'The role changed successfully!'
               ]);
            }
        
    }
    #Change user status
    public function changeStatus(Request $request) {
        $user = User::findOrfail('id', $request->userId);
        $user->status = $request->status;
        
        if ($user->save()) {
            return response()->json([
                's_value' => $user->status
            ]);
        } else {
           return response()->json([
                's_value' => 'failed!'
           ]);
        }
    }
    # Register new user...
    public function createUser(Request $request) {
        # to know count of users
        $userId = Auth::user()->id;
        $compId = Auth::user()->comp_id;
        $users = DB::table('users')->where('comp_id', $compId)->where('status', 1)->get();
        $count = $users->count();
        # end of count
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|string|max:64|min:5',
            'first_name' => 'required|string|max:64',
            'last_name' => 'nullable|string|max:64',
            'phone' => 'required|unique:users|string|min:10',
            'email' => 'nullable|unique:users|email|max:128',
            'user_name' => 'required|unique:users|string|max:128|min:5',
            'password' => 'required|string|min:6|confirmed'

        ]);
        
        if ($validation->passes()) {
            $user = new User();
            $countValues = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.user_count', 'companies.comp_status')
            ->where('users.id', $userId)
            ->get();
            $user_count = $countValues[0]->user_count;
            $compStatus = $countValues[0]->comp_status;

            if ($compStatus == 1) {
                  
                    if( $count < $user_count ) {
                        $user->comp_id = $compId;
                        $user->name = $request->first_name;
                        $user->lastname = $request->last_name;
                        $user->phone = $request->phone;
                        $user->email = $request->email;
                        $user->role = $request->role;
                        $user->username = $request->user_name;
                        $user->password = Hash::make($request->password);
                        $user->username = $request->user_name;
                        $user->save(); 
                    return response()->json([
                            'user_msg' => "User registered successfully!",
                            'result' => "success",
                            'style' => 'color:grey'
                        ]); 
                    }
                    
                    return response()->json([
                        'user_msg' => 'Sorry, your user count has reached to its maximum size.',
                        'result' => "over",
                        'style' => 'color:darkred'
                    ]);
     
            } else if($compStatus == 0) {
                return response()->json([
                    'user_msg' => 'Sorry, the company is not active.',
                     'result' => 'innactive',
                    'style' => 'color:darkred'
                ]);
            }
          
        } else {
            return response()->json([
                'user_msg' => $validation->errors()->all(),
                'result' => 'fail',
                'style' => 'color:red'
            ]);
        }
        
    }

    # =================================== USER-PROFILE ==================================
    // Show User Profile
    public function showUserProfile()
    {
        return view('user_profile');
    }

    # Change user Password
    public function changePassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $val = Validator::make($request->all(), [
            'current_password' => 'required|string|max:128',
            'new_password' => 'required|string|min:6|max:128',
            'password_confirmation' => 'required'
        ]);

        if ($val->passes()) {
            // existing password in db
            $currentPass = $request->current_password;
            $newPass = $request->new_password;
            $confirm = $request->password_confirmation;

                // Check to see if $currentPass matches the one in db
                if (Hash::check($currentPass, Auth::user()->password)) {
                    # First confirm password
                        if ($newPass === $confirm) {
                            $user->password = Hash::make($newPass);
                            if ($user->save()) {
                                return response()->json([
                                    'message' => 'Password changed successfully!',
                                    'style' => 'color:lightblue'
                                ]);
                            }
                        } else {
                            return response()->json([
                                'message' => 'Sorry, password confirmation does not match, try again.',
                                'style' => 'color:red' 
                            ]);
                        }
                } else {
                    return response()->json([
                        'message' => 'Sorry, incorrect password.',
                        'style' => 'color:red'
                    ]);
                }
        } else {
            return response()->json([
                'message' => $val->errors()->all(),
                'style' => 'color:red'
            ]);
        }
    }
    # ============================== UPDATE ONLY USER-PHOTO ===============================
    public function changePhoto(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_photo' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2048'
        ]);
        if ($val->passes()) {
            $photo = '';
            $user = User::findOrfail($request->user_id);
            if ($request->hasFile('user_photo')) {
                $image = $request->file('user_photo');
                $path = "uploads/user_photos/";
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $photo = $new_name;
                $user->photo = $photo;
                $image->move($path, $new_name);
                $user->save();
                return response()->json([
                    'message' => 'photo changed successfully!',
                    'style' => 'color:lightblue'

                ]);
            }
        } else {
            return response()->json([
                'message' => $val->errors()->all(),
                'style' => 'color:red'
            ]);
        }
        
        
    }
    # ========================= /. Update only USER-PHOTO ========================
    // Change photo of profile
    public function changePersonInfo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => 'required|string|max:64|min:5',
            'first_name' => 'required|string|max:64|min:5',
            'user_lastname' => 'nullable|string|max:64|min:5',
            'user_phone' => 'required|string|max:32|min:10',
            'user_email' => 'nullable|string|max:64|min:10'
        ]);
        if ($validation->passes()) {
            $user = User::findOrfail($request->user_id);
            $user->name = $request->first_name;
            $user->lastname = $request->user_lastname;
            $user->phone = $request->user_phone;
            $user->email = $request->user_email;
            $user->username = $request->user_name;
            $user->save();
            return response()->json([
                'message' => 'User info updated successfully!',
                'style' => 'color:lightblue'
            ]);
        } else {
            return response()->json([
                'message' => $validation->errors()->all(),
                'style' => 'color:red'
            ]);
        }
    }
    # ================================== /. USER-PROFILE ================================

    #User-statsu management
    public function onStatus(Request $request)
    {
        # to know count of users
        $userId = Auth::user()->id;
        $compId = Auth::user()->comp_id;
        $users = DB::table('users')->where('comp_id', $compId)->where('status', 1)->get();
        $count = $users->count();

        $countValues = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.user_count', 'companies.comp_status')
            ->where('users.id', $userId)
            ->get();
        // See number of define users in companies
        $user_count = $countValues[0]->user_count;
        
        $user = User::findOrfail($request->userId);
        $statusValue = $request->statusValue;
        if ($statusValue == 1) {
            $user->status = 0;  
        } else if( $statusValue == 0) {
            if ($count < $user_count) {
                $user->status = 1;  
            } else {
                return response()->json([
                    'user_msg' => 'Sorry, your user count has reached to its maximum size.',
                    'user_count' => "over",
                    'style' => 'color:darkred'
                ]);
            }
            
          
        }
        
        if($user->save()) {
            if ($user->status == 1) {
                return response()->json([
                    'remove_class' => 'btn-xs btn btn-danger',
                    'add_class' => 'btn-xs btn btn-success',
                    'label' => 'Active'
                ]);
            } else if($user->status == 0) {
                return response()->json([
                    'remove_class' => 'btn-xs btn btn-success',
                    'add_class' => 'btn-xs btn btn-danger',
                    'label' => 'Inactive'
                ]);
            }
            
        } else {
            return 'User status not changed!';
        }
    }
    # ==================================== CHANGE STATUS OF SYSTEM-ADMINS ===============================
    public function onSystemAdminStatus(Request $request)
    {
       
        if (Gate::allows('isSuperAdmin')) {
                $user = User::findOrfail($request->userId);
                $statusValue = $request->statusValue;
                if ($statusValue == 1) {
                    $user->status = 0;
                } else if ($statusValue == 0) {
                    $user->status = 1;
                }

                if ($user->save()) {
                    if ($user->status == 1) {
                        return response()->json([
                            'remove_class' => 'btn-xs btn btn-danger',
                            'add_class' => 'btn-xs btn btn-success',
                            'label' => 'Active'
                        ]);
                    } else if ($user->status == 0) {
                        return response()->json([
                            'remove_class' => 'btn-xs btn btn-success',
                            'add_class' => 'btn-xs btn btn-danger',
                            'label' => 'Inactive'
                        ]);
                    }
                } else {
                    return 'User status not changed!';
                }
        } else {
            abort(403, 'This action is unauthorized.');
        }
        
    }

    # ======================== AUTHENTICATED/SPECIFIC COMPANY ====================== 
    // The default settings of company
    public function onDefault()
    {
        $userId = Auth::user()->comp_id;
        $companies = DB::table('companies')->select('*')->where('company_id', $userId)->get();
        return view('setting_of_specific_company', compact('companies'));
    }

    // Now update this company
    public function onSet(Request $request)
    {
        # Validate the fields of a specific company
        $val = Validator::make($request->all(), [
            'cname' => 'required|string|max:64|min:5',
            'cstate' => 'required|string|max:64',
            'ccity' => 'required|string|max:128',
            'caddress' => 'required|string|max:128',
            'ccontact' => 'required|string|max:64',
            'cemail' => 'nullable|string|max:64',
            'clogo' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2048'
        ]);

        if ($val->passes()) {
            $comp = Company::findOrfail($request->cid);
            $comp->comp_name = $request->cname;
            $comp->comp_state = $request->cstate;
            $comp->comp_city = $request->ccity;
            $comp->comp_address = $request->caddress;
            $comp->contact_no = $request->ccontact;
            $comp->email = $request->cemail;

            if ($request->hasFile('clogo')) {
                $image = $request->file('clogo');
                $path = "uploads/logos/";
                $logo_name = rand() . '.' . $image->getClientOriginalExtension();
                $comp->comp_logo = $logo_name;
                $image->move($path, $logo_name);
            }
            if ($comp->save()) {
                return response()->json([
                    'msg' => 'success',
                    'style' => 'color:darkblue'
                ]);
            }
        } else {
            return response()->json([
                // 'msg' => '<ul><li>Company name required.</li><li>State required.</li><li>City required.</li><li>Address required.</li><li>Contact required.</li><li>Email required.</li></ul>',
                'msg' => $val->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }
    }
      # /. ============================== AUTHENTICATED/SPECIFIC COMPANY =========================
  
}
