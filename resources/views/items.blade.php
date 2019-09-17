
@extends('layouts.master')
@section('content')
<div class="content" style="margin-top:-12px;">
    {{--================ Breadcrumbs ==================--}}
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-left: -14px">
        {{ Breadcrumbs::render('inventory') }}
    </div>
    @if(count($errors) > 0)
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <ul style="color:darkred">
           @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
           @endforeach
        </ul>
    </div>
        <br>
    @endif
    @if($msg = Session::get('success'))
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <span style="color:cornflowerblue">{{ $msg }}</span>
        </div>
        <br>
    @elseif($msg = Session::get('error'))
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <span style="color:cornflowerblue">{{ $msg }}</span>
        </div>
        <br>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <!-- Header of items-page -->
                    <section class="content-header">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-item">Add Item</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-category">Add Category</button>
                {{--   Dropdown for Excel   --}}
                        <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">More
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Excel Sheets</li>
                                <li><a href="{{ route('item.export') }}">Export Excel</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#modal-excel">Import Excel</a></li>
                                <li class="divider"></li>
                                {{--<li class="dropdown-header">Dropdown header 2</li>
                                <li><a href="#">About Us</a></li>--}}
                            </ul>
                        </div>
                {{--   /. Dropdown for Excel   --}}
                    </section>
                </div>
               <div class="box-body">
                   <div class="box">
                       <div class="box-header">

<!-- Datatables -->
                        <table id="Item_data_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Barcode #</th>
                                    <th>Category</th>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>In Stock</th>
                                    <th>Taxable</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>Sell Price</th>
                                    <th>Reg. Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($items) || count($items) > 0)
                                @foreach($items as $item)
                                <tr>
                                    <td><img src="uploads/product_images/{{ $item->item_image }}" alt="Image" class="img-circle img-bordered-sm" height="30"
                                            width="30"></td>
                                    <td>{{ $item->barcode_number }}</td>
                                    <td>{{ $item->ctg_name }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->item_desc }}</td>
                                    <td> @if($item->quantity > 5) <strong class="text-primary">{{ $item->quantity }}</strong> @else
                                        <strong class="text-danger">{{ $item->quantity }}</strong> @endif </td>
                                    <td>{{ $item->taxable }}</td>
                                    <td></td>
                                    <td>{{ $item->purchase_price }}</td>
                                    <td>{{ $item->sell_price }}</td>
                                    <td>{{ Carbon\carbon::parse($item->created_at)->format('d M Y') }}</td>
                                    <td>
                                        {{--<button class="btn btn-danger btn-sm btn_delete_product" data-toggle="modal"
                                            data-target="#modal-delete-item" data-product-id="{{ $item->item_id }}"><i
                                                class="fa fa-trash"></i></button>--}}
                                        <button class="btn btn-primary btn-sm btn_edit_item" data-toggle="modal" data-target="#modal-edit-item"
                                            data-item-id="{{ $item->item_id }}" data-item-name="{{ $item->item_name }}"
                                            data-item-desc="{{ $item->item_desc }}" data-item-qty="{{ $item->quantity }}"
                                            data-item-barcode="{{ $item->barcode_number }}" data-item-purchase="{{ $item->purchase_price }}"
                                            data-item-taxable="{{ $item->taxable }}" data-item-sell="{{ $item->sell_price }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </table>
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>



<!-- Modals area -->
<!-- category modal -->
<div class="modal fade" id="modal-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Categories</h4>
        </div>
        <div class="modal-body">

            <div class="register-box-body">
                <ul id="ctg_message" style="display:none">
                </ul>
                <form class="form-horizontal" id="new_ctg_form">
                  @csrf
                    <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">Category Name <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-9">
                                <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description (Optional)">
                            </div>
                    </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">cancel</button>
                      <button type="submit" id="btn_add_ctg" class="btn btn-primary pull-left">Add Now</button>
                  </div>
            </form>
            </div>
        </div>
        <!-- end of modal-body div -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.categories modal -->
      <!-- /.categories modal -->
<!-- End of category-modal -->

<!-- New Items modal -->
<div class="modal fade" id="modal-item">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Items</h4>
        </div>
        <div class="modal-body">
            <div class="register-box-body">
                <ul id="item_message" style="display:none">
                </ul>
                <form class="form-horizontal" enctype="multipart/form-data" id="item_form_data">
                  @csrf
                  <div class="form-group">
                    <label for="category" class="col-sm-2 control-label">Category <span class="asterisk">*</span></label>
                    <div class="col-sm-9">
                        <select name="item_category" class="form-control item_category" required autofocus>
                            <option value="">--------------- Select a category --------------</option>
                            @foreach($ctgs as $ctg)
                            <option value="{{ $ctg->ctg_id }}" id="ctg_option">{{ $ctg->ctg_name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                    <div class="form-group">
                            <label for="product" class="col-sm-2 control-label">Item <span class="asterisk">*</span></label>
                         <div class="col-sm-9">
                                <input id="item_name" type="text" class="form-control" name="item_name" placeholder="Item Name">
                         </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-9">
{{--                            <input id="qty" type="number" class="form-control" name="quantity" placeholder="Quantity">--}}
                            <textarea name="description" id="description"  class="form-control" cols="30" rows="2" placeholder="Description"></textarea>
                        </div>
                    </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-9">
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" class="form-control" disabled>
                            <div class="input-group-addon">
                                <label class="logo-custom-upload">
                                    <span class="glyphicon glyphicon-picture"></span>
                                    <input type="file" id="company_logo" class="upload logo-file-input form-control" name="item_image">
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                    <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">Quantity <span class="asterisk">*</span></label>
                           <div class="col-sm-9">
                                <input id="qty" type="number" class="form-control" name="quantity" placeholder="Quantity">
                           </div>
                    </div>
                    <div class="form-group">
                            <label for="barcode" class="col-sm-2 control-label">Barcode</label>
                            <div class="col-sm-9">
                                <input id="barcode" type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="cost" class="col-sm-2 control-label">Cost <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <input id="purchase_price"  min="0" step="0.001" type="number" class="form-control" name="cost" placeholder="Cost">
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="sell-price" class="col-sm-2 control-label">Sell Price <span class="asterisk">*</span></label>
                       <div class="col-sm-9">
                            <input id="sell_price"  min="0" step="0.001" type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                       </div>
                    </div>
                <!-- Tax -->
                <div class="form-group">
                        <label for="taxable" class="col-sm-2 control-label">Taxable</label>
                       <div class="col-sm-9">
                            <select name="taxable" id="taxable" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                       </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn_add_item" class="btn btn-primary pull-left">Add Now</button>
                </div>
            </div>
            </form>
            </div>

        </div>
    </div>
        <!-- end of modal-body div -->
</div>
      <!-- new Item Modal -->

      <!-- Edit Item Modal-->
<div class="modal fade" id="modal-edit-item">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Items</h4>
        </div>
        <div class="modal-body">
            <ul id="item_edit_message" style="display:none">
            </ul>
            <div class="register-box-body">
                <form class="form-horizontal"  enctype="multipart/form-data" id="edit_item_form_data">
                    <input type="hidden" name="item_id">
                  @csrf
                    <div class="form-group">
                        <label for="product" class="col-sm-2 control-label">Category <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select name="item_category" class="form-control item_category" autofocus>
                                <option value="">---------- Select a category -----------</option>
                               @if(!empty($items) || count($items) > 0)
                                    @foreach($ctgs as $ctg)
                                        <option value="{{ $ctg->ctg_id }}" id="ctg_option" >{{ $ctg->ctg_name }}</option>
                                    @endforeach
                               @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                            <label for="product" class="col-sm-2 control-label">Item <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="item_name" placeholder="Item Name">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="desc" class="col-sm-2 control-label">Desc</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="item_desc" placeholder="Description">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">Quantity <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="quantity" placeholder="Stock">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="barcode" class="col-sm-2 control-label">Barcode</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="cost" class="col-sm-2 control-label">Cost <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                                <input type="number"  min="0" step="0.001" class="form-control" name="cost" placeholder="Cost">
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="sell-price" class="col-sm-2 control-label">Sell Price <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <input type="number"  min="0" step="0.001" class="form-control" name="sell_price" placeholder="Sell Price">
                        </div>
                    </div>
                <!-- Tax -->
                <div class="form-group">
                        <label for="taxable" class="col-sm-2 control-label">Taxable</label>
                     <div class="col-sm-9">
                            <select name="taxable" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                     </div>
                </div>
                <!-- tax -->

            </div>
            </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary pull-left" id="btn_edit_item_in_modal">Change</button>
                  </div>
            </form>
              </div>
        </div>
        <!-- end of modal-body div -->
</div>
      <!-- Edit Item Modal -->

       <!-- delete-item -->
    <div class="modal fade" id="modal-delete-item">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Product Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="item_id">
              <p>Are you sure you want delete this product?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary pull-left" onclick="deleteProduct();">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->
    <!-- /.delete-item -->
<div class="modal fade" id="modal-excel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Excel Sheets</h4>
            </div>
            <div class="modal-body">
                <ul id="msg_area" style="display:none">
                </ul>
                <div class="register-box-body">
                    <form action="{{ route('item.import') }}" method="post" enctype="multipart/form-data" class="form-horizontal" id="form-import-excel">
                        @csrf
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" id="item_excel_name" disabled="disabled">
                            <div class="input-group-addon">
                                <label class="excel_upload">
                                    <span>Choose</span>
                                    <input type="file" id="excel_file" class="upload logo-file-input form-control" name="excel_file">
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary pull-left">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end of modal-body div -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  @stop

