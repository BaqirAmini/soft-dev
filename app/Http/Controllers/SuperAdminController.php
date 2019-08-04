<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:isSuperAdmin']);
    }
    # View all super admins if exist
    public function index()
    {
        $companies = DB::table('companies')->get();

        $superAdmins = DB::table('users')->select('*')->where('role', 'Super Admin')->get();
        return view('super_admin', compact(['superAdmins', 'companies']));
        
    }

    # Create new super-admins
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'first_name' => 'required|string|max:64|min:3',
            'last_name' => 'nullable|string|max:64|min:3',
            'phone' => 'required|unique:users|string|max:16|min:10',
            'email' => 'nullable|unique:users|string|max:64',
            'user_name' => 'required|string|max:64|min:5',
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($v->passes()) {
            $sa = new User();
            $sa->name = $request->first_name;
            $sa->lastname = $request->last_name;
            $sa->phone = $request->phone;
            $sa->email = $request->email;
            $sa->role = $request->role;
            $sa->username = $request->user_name;
            $sa->password = Hash::make($request->password);
            if ($sa->save()) {
                return response()->json([
                    'super_msg' => 'Super admin added successfully!',
                    'style' => 'color:darkblue;font-size:12px'
                ]);
            }
        } else {
            return response()->json([
                'super_msg' => $v->errors()->all(),
                'style' => 'color:darkred'
            ]);
        }
        
    }
    #SUPER-ADMIN statsu management
    public function onStatus(Request $request)
    {
        $sa = User::findOrfail($request->saId);
        $statusValue = $request->statusValue;
        if ($statusValue == 1) {
            $sa->status = 0;
        } else if ($statusValue == 0) {
                $sa->status = 1;
        }

        if ($sa->save()) {
            if ($sa->status == 1) {
                return response()->json([
                    'remove_class' => 'btn-xs btn btn-danger',
                    'add_class' => 'btn-xs btn btn-success',
                    'label' => 'Active'
                ]);
            } else if ($sa->status == 0) {
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
}
