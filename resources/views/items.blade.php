
@extends('layouts.master')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <!-- Header of items-page -->
                    <section class="content-header">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-item">Add Item</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-category">Add Category</button>
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
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>In Stock</th>
                                    <th>Purchase Price</th>
                                    <th>Sell Price</th>
                                    <th>Reg. Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td><img src="uploads/product_images/{{ $item->item_image }}" alt="Image" class="circle" height="30"
                                            width="30"></td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->item_desc }}</td>
                                    <td> @if($item->quantity > 5) <button class="btn-sm btn btn-info">{{ $item->quantity }}</button> @else
                                        <button class="btn-sm btn btn-danger">{{ $item->quantity }}</button> @endif </td>
                                    <td>{{ $item->purchase_price }}</td>
                                    <td>{{ $item->sell_price }}</td>
                                    <td>{{ Carbon\carbon::parse($item->created_at)->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn_delete_product" data-toggle="modal"
                                            data-target="#modal-delete-item" data-product-id="{{ $item->item_id }}"><i
                                                class="fa fa-trash"></i></button>
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
                    <li>Message</li>
                </ul>
                <form id="new_ctg_form">
                  @csrf
               
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">Category Name:</span>
                            <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">Description</span>
                            <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description (Optional)">
                        </div>
                    </div>
            
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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
                <form  enctype="multipart/form-data" id="item_form_data">
                  @csrf
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Category</strong></span>
                       <select name="item_category" id="item_category" class="form-control" required autofocus>
                           @foreach($ctgs as $ctg)
                                <option value="{{ $ctg->ctg_id }}" id="ctg_option">{{ $ctg->ctg_name }}</option>
                           @endforeach
                       </select>
                    </div><br>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Product</strong></span>
                            <input id="item_name" type="text" class="form-control" name="item_name" placeholder="Item Name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="custom-upload">
                            <span class="glyphicon glyphicon-picture"></span> Image
                            <input type="file" id="user_photo" class="upload customer-file-input form-control" name="item_image">
                        </label>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Quantity</strong></span>
                            <input id="qty" type="number" class="form-control" name="quantity" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Barcode</strong></span>
                            <input id="barcode" type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Purchase Price</strong></span>
                            <input id="purchase_price" type="number" class="form-control" name="purchase_price" placeholder="Purchase Price">
                            <span class="input-group-addon"><strong>Sell Price</strong></span>
                            <input id="sell_price" type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                        </div>
                    </div>
                <!-- Tax -->
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Taxable:</strong></span>
                        <select name="taxable" id="taxable" class="form-control">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <!-- tax --> 
            </div>
            </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" id="btn_add_item" class="btn btn-primary pull-left">Add Now</button>
                  </div>
            </form>
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
            <div class="register-box-body">
                <ul id="item_message" style="display:none">
                </ul>
                <form  enctype="multipart/form-data" id="edit_item_form_data">
                    <input type="hidden" name="item_id">
                  @csrf
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Product</strong></span>
                            <input  type="text" class="form-control" name="item_name" placeholder="Item Name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Desc</strong></span>
                            <input  type="text" class="form-control" name="item_desc" placeholder="Description">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Quantity</strong></span>
                            <input type="number" class="form-control" name="quantity" placeholder="Stock">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Barcode</strong></span>
                            <input  type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><strong>Purchase Price</strong></span>
                            <input type="number" class="form-control" name="purchase_price" placeholder="Purchase Price">
                            <span class="input-group-addon"><strong>Sell Price</strong></span>
                            <input  type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                        </div>
                    </div>
                <!-- Tax -->
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Taxable:</strong></span>
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
                      <button type="submit" class="btn btn-primary pull-left">Change</button>
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
  @stop
  
   