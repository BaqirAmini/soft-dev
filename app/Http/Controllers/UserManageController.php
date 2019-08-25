<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Auth;
use Doctrine\DBAL\Schema\Table;
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
            'first_name' => 'required|string|max:64|min:3',
            'last_name' => 'nullable|string|max:64',
            'phone' => 'required|unique:users|string|min:10',
            'email' => 'nullable|unique:users|email|max:128',
            'user_name' => 'required|string|max:128|min:5',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'

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
                        $user->save();
                    return response()->json([
                            'user_msg' => "User registered successfully!",
                            'result' => 'success',
                            'style' => 'color:grey'
                        ]);
                    }

                    return response()->json([
                        'user_msg' => 'Sorry, your user count has reached to its maximum size.',
                        'result' => 'over',
                        'style' => 'color:darkred'
                    ]);

            } else if($compStatus == 0) {
                return response()->json([
                    'user_msg' => 'Sorry, the company is not active.',
                     'result' => 'inactive',
                    'style' => 'color:darkred'
                ]);
            }

        } else {
            return response()->json([
                'user_msg' => $validation->errors()->all(),
                'result' => 'fail',
                'style' => 'color:darkred'
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
                                'style' => 'color:darkred'
                            ]);
                        }
                } else {
                    return response()->json([
                        'message' => 'Sorry, incorrect password.',
                        'style' => 'color:darkred'
                    ]);
                }
        } else {
            return response()->json([
                'message' => $val->errors()->all(),
                'style' => 'color:darkred'
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
            'cemail' => 'nullable|string|max:64'
        ]);

        if ($val->passes()) {
            $comp = Company::findOrfail($request->cid);
            $comp->comp_name = $request->cname;
            $comp->comp_state = $request->cstate;
            $comp->comp_city = $request->ccity;
            $comp->comp_address = $request->caddress;
            $comp->contact_no = $request->ccontact;
            $comp->email = $request->cemail;
            if ($comp->save()) {
                return response()->json([
                    'msg' => 'Company set successfully!',
                    'result' => 'success',
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
    public function onChangeLogo(Request $request)
    {
        $v = Validator::make($request->all(), [
            'company_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($v->passes()) {
            $company = Company::findOrfail($request->cid);
            if ($request->hasFile('company_logo')) {
                $image = $request->file('company_logo');
                $path = "uploads/logos/";
                $logo_name = rand() . '.' . $image->getClientOriginalExtension();
                $company->comp_logo = $logo_name;
                $image->move($path, $logo_name);
                $company->save();
                return response()->json([
                    'msg' => 'Logo changed successfully!',
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



    }
      # /. ============================== AUTHENTICATED/SPECIFIC COMPANY =========================

    # ======================================== profile of ANY-SYSTEM-ADMIN ==============================
//    Profile of any system-admin
    public function specificSystemAdminProfile($id = null) {
        $systemAdms = DB::table('users')->select('*')->where('id', $id)->get();
        return view('change_system_admin_info', compact('systemAdms'));
    }

//    Change personal info
    public function changeInfo1(Request $request) {
        $v = Validator::make($request->all(), [
            'user_name' => 'required|string|min:5|max:64',
            'first_name' => 'required|string|min:3|max:64',
            'user_lastname' => 'nullable|string|min:3|max:64',
            'user_phone' => 'required|string|min:10|max:64',
            'user_email' => 'nullable|string|min:10|max:64',
        ]);
        if ($v->passes()) {
            $sa = User::findorfail($request->user_id);
            $sa->username = $request->user_name;
            $sa->name = $request->first_name;
            $sa->lastname = $request->user_lastname;
            $sa->phone = $request->user_phone;
            $sa->email = $request->user_email;
            $sa->save();
            return response()->json([
               'result' => 'success',
               'msg' => 'System info changed successfully!',
               'style' => 'color:darkblue'
            ]);
        } else {
            return response()->json([
                'result' => 'fail',
                'msg' => $v->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }

    }

    //    Change Password
    public function changeInfo2(Request $request) {
        $v = Validator::make($request->all(), [
            'new_password' => 'required|string|min:6'
        ]);
        if ($v->passes()) {
            $sa = User::findorfail($request->user_id);
            $sa->password = Hash::make($request->new_password);
            $sa->save();
            return response()->json([
                'result' => 'success',
                'msg' => 'Password reset was successful!',
                'style' => 'color:darkblue'
            ]);
        } else {
            return response()->json([
                'result' => 'fail',
                'msg' => $v->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }

    }

    //    Change ANY-SYSTEM-ADMIN photo
    public function editSystemAdminPhoto(Request $request) {
        $v = Validator::make($request->all(), [
            'user_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->passes()) {
            $user = User::findorfail($request->user_id);
            if ($request->hasFile('user_photo')) {
                $img = $request->file('user_photo');
                $path = 'uploads/user_photos/';
                $img_name = rand().'.'.$img->getClientOriginalExtension();
                $user->photo = $img_name;
                $img->move($path, $img_name);
                $user->save();
                return response()->json([
                    'result' => 'success',
                    'msg' => 'Profile photo updated successfully!',
                    'style' => 'color:darkblue'
                ]);
            }
        } else {
            return response()->json([
                'result' => 'fail',
                'msg' => $v->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }
    }
    # ========================================/. profile of ANY-SYSTEM-ADMIN ==============================


    # ================================================= any User-profile that changed by system-admin ================================
    public function profile($uid = null) {
        if (Gate::allows('isSystemAdmin')) {
            $users = DB::table('users')->select('*')->where('id', $uid)->get();
            return view('change_any_user_info', compact('users'));
        }
    }

//    Change Personal Info
    public function editInfo1(Request $request) {
        $v = Validator::make($request->all(), [
           'user_name' => 'required|string|min:5|max:64',
           'first_name' => 'required|string|min:3|max:64',
           'user_lastname' => 'nullable|string|min:3|max:64',
           'user_phone' => 'required|string|min:10|max:64',
           'user_email' => 'nullable|string|min:10|max:64',
        ]);
        if ($v->passes()) {
            $user = User::findorfail($request->user_id);
            $user->username = $request->user_name;
            $user->name = $request->first_name;
            $user->lastname = $request->user_lastname;
            $user->phone = $request->user_phone;
            $user->email = $request->user_email;
            $user->save();
            return response()->json([
               'result' => 'success',
               'style' => 'color:darkblue',
               'msg' => 'User info changed successfully!'
            ]);
        } else {
            return response()->json([
                'result' => 'fail',
                'style' => 'color:darkred',
                'msg' => $v->errors()->all()
            ]);
        }

    }

//    Reset Any-user password
    public function resetUserInfo(Request $request) {
        $v = Validator::make($request->all(), [
            'new_password' => 'required|string|min:6'
        ]);
        if ($v->passes()) {
            $user = User::findorfail($request->user_id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
               'result' => 'success',
               'msg' => 'Password reset successfully!',
               'style' => 'color:darkblue'
            ]);
        } else {
            return response()->json([
               'result' => 'fail',
               'msg' => $v->errors()->all(),
               'style' => 'color:darkred'
            ]);
        }
    }

//    Change ANY-USER photo
    public function anyUserPhoto(Request $request) {
        $v = Validator::make($request->all(), [
           'user_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->passes()) {
            $user = User::findorfail($request->user_id);
            if ($request->hasFile('user_photo')) {
                $img = $request->file('user_photo');
                $path = 'uploads/user_photos/';
                $img_name = rand().'.'.$img->getClientOriginalExtension();
                $user->photo = $img_name;
                $img->move($path, $img_name);
                $user->save();
                return response()->json([
                   'result' => 'success',
                   'msg' => 'Profile photo updated successfully!',
                   'style' => 'color:darkblue'
                ]);
            }
        } else {
            return response()->json([
               'result' => 'fail',
               'msg' => $v->errors()->all(),
               'style' => 'color:darkred'
            ]);
        }
    }
    # =================================================/. any User-profile that changed by system-admin ================================

}
