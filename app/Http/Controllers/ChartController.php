<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Today's sales detail
        $data = DB::table('items')
        ->join('sales', 'items.item_id', '=', 'sales.item_id')
        ->select('sales.*', 'items.item_name')
        ->get();
        

        return $data;
    }
}
