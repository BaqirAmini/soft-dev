<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
            $ctgs = Category::all()->where('comp_id', Auth::user()->comp_id);
            return view('categories', compact('ctgs'));
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


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'ctg_name' => 'required|string|unique:categories|unique:categories,ctg_name',
            'ctg_desc' => 'nullable|string|max:256'
        ]);

        if ($validation->passes()) {
            $ctg = new Category();
            $userId = Auth::user()->id;
            $compId = Auth::user()->comp_id;
            $countValues = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.comp_status')
            ->where('users.id', $userId)
            ->get();
            $compStatus = $countValues[0]->comp_status;
                    if ($compStatus == 1) {
                        $ctg->comp_id = $compId;
                        $ctg->ctg_name = $request->ctg_name;
                        $ctg->ctg_desc = $request->ctg_desc;
                        $ctg->save();
                        return response()->json([
                            'ctg_msg' => 'The category added successfully',
                            'result' => 'success',
                            'style' => 'color:grey'
                        ]);
                    } else if( $compStatus == 0) {
                        return response()->json([
                            'ctg_msg' => 'Sorry, the company is deactivated, please make contact with the system admin.',
                            'result' => 'fail',
                            'style' => 'color:darkred'
                        ]);
                    }

        } else {
            return response()->json([
                'ctg_msg' => $validation->errors()->all(),
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
    public function edit(Request $request)
    {
        $ctg = Category::findOrfail($request->ctgId);
        $validation =  Validator::make($request->all(), [
            'ctg_name' => 'required|string|max:64',
            'ctg_desc' => 'nullable|max:128|string'
        ]);
        if ($validation->passes()) {
            $ctg->ctg_name = $request->ctg_name;
            $ctg->ctg_desc = $request->ctg_desc;
            $ctg->save();
            return response()->json([
                'msg' => 'The category edited successfully!',
                'result' => 'success',
                'style' => 'color:grey'
            ]);
        } else {
            return response()->json([
                'msg' => $validation->errors()->all(),
                'result' => 'fail',
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
    public function destroy(Request $request)
    {
        if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
            $deleted = Category::destroy('ctg_id', $request->cid);

            if ($deleted) {
                return response()->json([
                    'msg' => 'The category deleted successfully!',
                    'style' => 'color:grey'
                ]);
            } else {
                return response()->json([
                    'msg' => 'Sorry, the category not deleted!',
                    'style' => 'color:darkred'
                ]);
            }
        } else {
            abort(403, 'This action is unauthorized.');
        }



    }
}
