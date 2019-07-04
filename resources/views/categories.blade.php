
@extends('layouts.master')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <section class="content-header">
              <button class="btn btn-primary" data-toggle="modal" data-target="#modal-item">Add Item</button>
              <button class="btn btn-info" data-toggle="modal" data-target="#modal-category">Add Category</button>
            </section>
          </div>

          <div class="box-body">
              <div class="box">
                  <div class="box-header">
                      <span id="msg"></span>
                      <!-- Datatables -->
                      <table id="data_tbl4" class="table table-striped col-md-12 col-xs-6 table-bordered">
                        <thead>
                          <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Reg. Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($ctgs as $ctg)
                          <tr>
                            <td>{{ $ctg->ctg_name }}</td>
                            <td>{{ $ctg->ctg_desc }}</td>
                            <td>{{ $ctg->created_at }}</td>
                            <td>
                              <button class="btn btn-danger btn-sm btn-delete-ctg" data-ctg-id="{{ $ctg->ctg_id }}" data-toggle="modal"
                                data-target="#modal-delete-category">
                                <i class="fa fa-trash"></i>
                              </button>
                              <button class="btn btn-warning btn-sm btn-edit-ctg" data-ctg-id="{{ $ctg->ctg_id }}"
                                data-ctg-name="{{ $ctg->ctg_name }}" data-ctg-desc="{{ $ctg->ctg_desc }}" data-toggle="modal"
                                data-target="#modal-edit-category">
                                <i class="fa fa-pencil"></i>
                              </button>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
              </div>
      
          </div>
        </div>
      </div>
    </div>
</section>
<!-- Modals area -->
<!-- modal delete-category -->
<div class="modal fade" id="modal-delete-category">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Delete Category</h4>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="ctg_id"  id="ctg_id">
              <p>Are you sure you want delete this category?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary pull-left" id="btn-delete-ctg">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<!-- modal delete-category -->

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
                <ul id="ctg_message">
                    <li>Message</li>
                </ul>
                <form id="new_ctg_form">
                  @csrf
               
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description">
                        </div>
                    </div>
            
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" id="btn_add_ctg" class="btn btn-primary">Add Now</button>
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

<!-- Edit modal of category -->
<div class="modal fade" id="modal-edit-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Category</h4>
        </div>
        <div class="modal-body">
            <div class="register-box-body">
                <p class="login-box-msg">Edit Category</p>
                <form id="edit-category-form">
                  @csrf
                <input type="hidden" name="ctgId" id="ctgId">
                    <div class="form-group has-feedback">
                           <!-- Category Name -->
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                           <!-- Category description -->
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description">
                        </div>
                    </div>
            
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" id="btn_edit_ctg" class="btn btn-primary pull-left">Edit</button>
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
  <!-- Edit modal of category -->
<!-- End of category-modal -->

<!-- Items modal -->
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
                <li>Item Message</li>
            </ul>
            <form  enctype="multipart/form-data" id="item_form_data">
              @csrf
                <div class="input-group">
                    <span class="input-group-addon"><strong>Category:</strong></span>
                   <select name="item_category" id="item_category" class="form-control" required autofocus>
                       @foreach($ctgs as $ctg)
                            <option value="{{ $ctg->ctg_id }}" id="ctg_option">{{ $ctg->ctg_name }}</option>
                       @endforeach
                   </select>
                </div><br>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Item Name:</strong></span>
                        <input id="item_name" type="text" class="form-control" name="item_name" placeholder="Item Name">
                    </div>
                </div>
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon"><strong>Description:</strong></span>
                    <input id="item_desc" type="text" class="form-control" name="item_desc" placeholder="Description (Optional)">
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
                        <span class="input-group-addon"><strong>Quantity:</strong></span>
                        <input id="qty" type="number" class="form-control" name="quantity" placeholder="Quantity">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Barcode:</strong></span>
                        <input id="barcode" type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><strong>Purchase Price:</strong></span>
                        <input id="purchase_price" type="number" class="form-control" name="purchase_price" placeholder="Purchase Price">
                        <span class="input-group-addon"><strong>Sell Price:</strong></span>
                        <input id="sell_price" type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                    </div>
                </div>
            <div class="form-group has-feedback">
                <div class="input-group">
                    <span class="input-group-addon"><strong>Discount:</strong></span>
                    <input id="discount" type="number" class="form-control" name="discount" placeholder="Discount">
                </div>
            </div>
            <!-- Tax -->
            <div class="form-group has-feedback">
                <div class="input-group">
                    <span class="input-group-addon"><strong></strong>Taxable:</strong></span>
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
  <!-- /.modal-content -->
<!-- /.Modals-area -->


@endsection