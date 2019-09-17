
@extends('layouts.master')
@section('content')
    {{--================ Breadcrumbs ==================--}}
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('category') }}
    </div>
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
                  </div>
                   <div class="box-body">
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
                              <td>{{ Carbon\carbon::parse($ctg->created_at)->format('m-d-Y') }}</td>
                              <td>
                                {{--<button class="btn btn-danger btn-sm btn-delete-ctg" data-ctg-id="{{ $ctg->ctg_id }}" data-toggle="modal"
                                  data-target="#modal-delete-category">
                                  <i class="fa fa-trash"></i>
                                </button>--}}
                                <button class="btn btn-primary btn-sm btn-edit-ctg" data-ctg-id="{{ $ctg->ctg_id }}"
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
            <ul id="ctg_message" style="display:none">

            </ul>
            <div class="register-box-body">
                <ul id="ctg_message" style="display: none">
                    <li>Message</li>
                </ul>
                <form class="form-horizontal" id="new_ctg_form">
                  @csrf

                    <div class="form-group">
                            <label for="ctg-name" class="col-sm-2 control-label">Category Name <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                              <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="ctg-desc" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-9">
                              <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description">
                            </div>
                    </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
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

<!-- Edit modal of category -->
<div class="modal fade" id="modal-edit-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <div class="content-header">
            <h4 class="modal-title">Edit Category</h4>
          </div>
        </div>
        <div class="modal-body">
          <span id="msg"></span>
            <div class="register-box-body">
                <form class="form-horizontal" id="edit-category-form">
                  @csrf
                <input type="hidden" name="ctgId" id="ctgId">
                    <div class="form-group">
                           <!-- Category Name -->
                           <div class="col-sm-2 control-label">
                              <label for="ctg_name">Category Name</label>
                              <span class="asterisk">*</span>
                           </div>
                            <div class="col-sm-9">
                              <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                            </div>
                    </div>
                    <div class="form-group">
                           <!-- Category description -->
                            <label for="ctg-desc" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-9">
                              <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description">
                            </div>
                    </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
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
      <ul id="item_message" style="display: none"></ul>
        <div class="register-box-body">
            </ul>
            <form class="form-horizontal" enctype="multipart/form-data" id="item_form_data">
              @csrf
               <div class="form-group">
                  <label for="category" class="col-sm-2 control-label">Category <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <select name="item_category" id="item_category" class="form-control" required autofocus>
                        <option value="">--------------- Select a category --------------</option>
                      @foreach($ctgs as $ctg)
                      <option value="{{ $ctg->ctg_id }}" id="ctg_option">{{ $ctg->ctg_name }}</option>
                      @endforeach
                    </select>
                  </div>
               </div>
                <div class="form-group">
                        <label for="item" class="col-sm-2 control-label">Item <span class="asterisk">*</span></label>
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
                          <input id="purchase_price" type="number" min="0" step="0.001" class="form-control" name="cost" placeholder="Cost">
                        </div>
                </div>
                <div class="form-group">
                  <label for="sell-price" class="col-sm-2 control-label">Sell Price <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <input id="sell_price" type="number" min="0" step="0.001" class="form-control" name="sell_price" placeholder="Sell Price">
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
            <!-- tax -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" id="btn_add_item" class="btn btn-primary pull-left">Add Now</button>
                </div>
        </div>
        </div>
        </form>
          </div>
    </div>
    <!-- end of modal-body div -->
  </div>
  <!-- /.modal-content -->
<!-- /.Modals-area -->


@endsection
