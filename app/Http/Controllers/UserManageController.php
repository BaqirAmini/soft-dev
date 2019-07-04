<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
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

    public function index()
    { 
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $compId = Auth::user()->comp_id;
            $users = DB::table('users')->where('comp_id', $compId)->get();
            $count = $users->count();

            // $users = DB::table('users')->get();
            // $count = $users->count();
            return view('users', compact(['users', 'count']));
        }   
        
    }
    #Manage roles...
    public function changeRole(Request $request) {
            $user = User::findOrFail($request->id);
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
        $users = DB::table('users')->where('comp_id', $compId)->get();
        $count = $users->count();
        # end of count
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|string|max:64',
            'last_name' => 'nullable|string|max:64',
            'phone' => 'required|unique:users|string|min:10',
            'email' => 'nullable|unique:users|email|max:128',
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
                        $user->password = Hash::make($request->password);
                        $user->save(); 
                    return response()->json([
                            'user_msg' => "User registered successfully!",
                            'style' => 'color:grey'
                        ]); 
                    }
                    
                    return response()->json([
                        'user_msg' => 'Sorry, your user count has reached to its maximum size.',
                        'style' => 'color:darkred'
                    ]);
     
            } else if($compStatus == 0) {
                return response()->json([
                    'user_msg' => 'Sorry, the company is not active.',
                    'style' => 'color:darkred'
                ]);
            }
          
        } else {
            return response()->json([
                'user_msg' => $validation->errors()->all(),
                'style' => 'color:red'
            ]);
        }
        
    }

    # Change user profile
    public function changeProfile(Request $request) {
         Validator::make($request->all(), [
            'phone' => 'nullable|unique:users|string|min:10',
        ]);
        
        $user = User::findOrFail($request->userId);
     
        // existing password in db
        $currentPass = $request->currentPass;
        $newPass = $request->newPass;
        $confirm = $request->confirmPass;
        if ($currentPass == "" || $newPass == "" || $confirm == "") {
            // dd("required fields");
            return "Current password, new password and confirmation required!";
        }
        elseif (!Hash::check($currentPass, Auth::user()->password)) {
            // dd('not equal with old password');
            return "Sorry, password is wrong";
        }
        elseif ($newPass !== $confirm) {
            // dd('not confirmed!');
            return "Sorry, password confirmation does not match with new password!";
        } else {
            
            $user->password = Hash::make($newPass);
            $user->name =  $request->userName;
            $user->lastname =  $request->userLastName;
            $user->phone = $request->userPhone;
            $user->email = $request->userEmail;
            $user->save();
            // dd('ok now');
            return "Your profile updated successfully!";
        }
    }
    // Change photo of profile
    public function changePhoto(Request $request) {
       $validation = Validator::make($request->all(), [
            'user_photo' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048'
       ]); 
       if ($validation->passes()) {
        $user = User::findOrfail($request->user_id);
        $image = $request->file('user_photo');
        $path = "uploads/user_photos/";
        $new_name = rand().'.'.$image->getClientOriginalExtension();
        $user->photo =  $new_name;
        $image->move($path, $new_name);
        $user->save();
        return response()->json([
            'message' => 'Profile photo updated successfully!',
            'uploaded_image' => '<img src="'.$path.$new_name.'" alt="User Photo" width="50" height="50">',
            'style' => 'color:lightblue'
        ]);
       } else {
           return response()->json([
                'message' => $validation->errors()->all(),
                'uploaded_image' => '',
                'style' => 'color:red'
           ]);
       }
       
    }
    #User-statsu management
    public function onStatus(Request $request)
    {
        $user = User::findOrfail($request->userId);
        $statusValue = $request->statusValue;
        if ($statusValue == 1) {
            $user->status = 0;  
        } else if( $statusValue == 0) {
            $user->status = 1;  
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
    // Activate status
//     public function onActivate(Request $request)
//     {
//        /* $uid = $request->userId;
//         $status = $request->userStatus;
//         DB::table('users')->where('id', $uid)->update(array('status'=>$status)); */
//        $user = User::findOrfail($request->userId);
//         $user->status = $request->userStatus;
//         $user->save(); 
        
//             return response()->json([
//                 'msg' => 'Activated',
//                 'add_class' => 'btn-xs btn btn-success',
//                 'remove_class' => 'btn-xs btn btn-danger'
//             ]);
        
// } 
//     // Deactivate status
//     public function onDeactivate(Request $request)
//     {
//         $uid = $request->userId;
//         $status = $request->userStatus;
//         DB::table('users')->where('id', $uid)->update(array('status'=>$status));
//       /*  $user = User::findOrfail($request->userId);
//         $user->status = $request->userStatus;
//         $user->save(); */
        
//             return response()->json([
//                 'msg' => 'Deactivated',
//                 'add_class' => 'btn-xs btn btn-danger',
//                 'remove_class' => 'btn-xs btn btn-success'
//             ]);
        
//     }
}
