<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Item;
use Excel;
use Validator;

class ItemController extends Controller
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
            $compId = Auth::user()->comp_id;
            $ctgs = DB::table('categories')->where('categories.comp_id', $compId)->get();
            $items = DB::table('items')
                ->join('categories', 'categories.ctg_id', '=', 'items.ctg_id')
                ->select('items.*',  'categories.ctg_name')
                ->where('items.comp_id',  $compId)
                ->get();
            return view('items', compact(['ctgs', 'items']));
        } else {
            abort(403, 'This action is unauthorized.');
        }
    }

/*======================= Import/Export Excel =====================*/
    public function importExcel(Request $request) {
        /*$request->validate([
           'excel_file' => 'required|mimes:xlsx, xls'
        ]);*/
            if ($request->hasFile('excel_file')) {
                $path = $request->file('excel_file')->getRealPath();
                $data = Excel::load($path)->get();
                foreach ($data->toArray() as $key => $value) {
                    /*foreach ($value as $row) {
                        $insert_data[] = array(
                            'comp_id' => $row[Auth::user()->comp_id],
                            'ctg_id' => 23,
                            'sup_id' => $row['supplier'],
                            'item_name' => $row['item_name'],
                            'item_desc' => $row['item_desc'],
                            'item_image' => $row['item_image'],
                            'puchase_price' => $row['puchase_price'],
                            'sell_price' => $row['sell_price'],
                            'quantity' => $row['qty'],
                            'barcode_number' => $row['barcode'],
                            'discount' => $row['discount'],
                            'taxable' => $row['taxable'],
                        );
                    }
                    DB::table('items')->insert($insert_data);*/

                }
                /*if (!empty($insert_data)) {
                    DB::table('items')->insert($insert_data);
                    return back()->with('success', 'Excel data imported successfully!');
                }*/

            }
    }

//    Export excel
    public function exportExcel() {
        if (Gate::allows('isSystemAdmin') || Gate::allows('isStockManager')) {
            $compId = Auth::user()->comp_id;
            $items = DB::table('items')
                ->join('categories', 'categories.ctg_id', '=', 'items.ctg_id')
                ->select('items.*',  'categories.ctg_name')
                ->where('items.comp_id',  $compId)
                ->get()->toArray();
            $items_array[] = array('Category', 'Item', 'Desc', 'In Stock', 'Barcode #', 'Taxable', 'Purchase Price', 'Sell Price', 'Reg. Date');
            foreach ($items as $item) {
                $items_array[] = array(
                  'Category' => $item->ctg_name,
                  'Item' => $item->item_name,
                  'Desc' => $item->item_desc,
                  'In Stock' => $item->quantity,
                  'Barcode #' => $item->barcode_number,
                  'Taxable' => $item->taxable,
                  'Puchase Price' => '$'.$item->purchase_price,
                  'Sell Price' => '$'.$item->sell_price,
                  'Reg. Date' => carbon::parse($item->created_at)->format('d-M-Y')
                );
            }
            Excel::create('Items In Inventory', function ($excel) use ($items_array) {
                $excel->setTitle('Items In Inventory');
                $excel->sheet('Items In Inventory', function ($sheet) use ($items_array) {
                   $sheet->fromArray($items_array, null, 'A1', false, false);
                });
            })->download('xlsx');

        } else {
            abort(403, 'This action is unauthorized.');
        }
    }
/* ============================= Import/Export Excel ========================*/

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
            'item_name' => 'required|string|max:64',
            'item_desc' => 'nullable|string|max:128',
            'quantity' => 'required|integer|max:64',
            'purchase_price' => 'required|between: 0, 99.99|max:64',
            'purchase_price' => 'required|between: 0, 99.99|max:64',
            'quantity'=>'required|integer|not_in:0|regex:/[1-9][0-9]+/',
            'discount' => 'nullable|between: 0, 99.99|max:64',
            'barcode_number' => 'nullable|integer|min:10',
        ]);
        if ($validation->passes()) {
            $userId = Auth::user()->id;
            $compId = Auth::user()->comp_id;

            $companies = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.comp_status')
            ->where('users.id', $userId)
            ->get();
            $compStatus = $companies[0]->comp_status;
            $item = new Item();
                if ($compStatus == 1) {
                    if ($request->hasFile('item_image')) {
                        $image = $request->file('item_image');
                        $path = "uploads/product_images/";
                        $new_name = rand().'.'.$image->getClientOriginalExtension();
                        $item->item_image =  $new_name;
                        $image->move($path, $new_name);
                    }
                    $item->comp_id = $compId;
                    $item->ctg_id = $request->item_category;
                    $item->item_name = $request->item_name;
                    $item->quantity = $request->quantity;
                    $item->barcode_number = $request->barcode_number;
                    $item->purchase_price = $request->purchase_price;
                    $item->sell_price = $request->sell_price;
                    $item->discount = $request->discount;
                    $item->taxable = $request->taxable;
                    $item->save();
                    return response()->json([
                        'item_msg' => 'Item added successfully!',
                        'result' => 'success',
                        'style' => 'color:grey'
                    ]);
                } else if($compStatus == 0) {
                    return response()->json([
                        'item_msg' => 'Sorry, the company is deactivated, please make contact with the system admin.',
                        'result' => 'fail',
                        'style' => 'color:darkred'

                    ]);
                }
        } else {
            return response()->json([
                'item_msg' => $validation->errors()->all(),
                'result' => 'fail',
                'style'=>'color:darkred'
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'item_name' => 'required|string|max:64',
            'item_desc' => 'nullable|string|max:128',
            'quantity' => 'required|integer|max:64',
            'purchase_price' => 'required|between: 0, 99.99|max:64',
            'barcode_number' => 'nullable|integer|min:10',
        ]);
        if ($validation->passes()) {
            $editItem = Item::findOrfail($request->item_id);
            $editItem->ctg_id = $request->item_category;
            $editItem->item_name = $request->item_name;
            $editItem->item_desc = $request->item_desc;
            $editItem->quantity = $request->quantity;
            $editItem->barcode_number = $request->barcode_number;
            $editItem->purchase_price = $request->purchase_price;
            $editItem->sell_price = $request->sell_price;
            $editItem->discount = $request->discount;
            $editItem->taxable = $request->taxable;

            if($editItem->save()) {
                return response()->json([
                    'edit_msg' => 'The product changed successfully!',
                    'result' => 'success',
                    'style' => 'color:grey'
                ]);
            }
        } else {
            return response()->json([
                'edit_msg' => $validation->errors()->all(),
                'result' => 'fail',
                'style' => 'color:darkred'
            ]);
        }


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
            $itemDeleted = Item::destroy('item_id', $request->itemId);
            if ($itemDeleted) {
                return response()->json([
                    'msg' => 'Product deleted successfully!',
                    'style' => 'color:red'
                ]);
            } else {
                return response()->json([
                    'msg' => 'Sorry, product not deleted, please try again!',
                    'style' => 'color:darkred'
                ]);
            }
        } else {
            abort(403, 'This action is unauthorized.');
        }


    }
}
