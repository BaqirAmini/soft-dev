@extends('layouts.master')

@section('content')
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
  @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class) || Auth::user()->can('isCashier', App\User::class))
    <div class="col-lg-3 col-xs-6" id="test">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $usersCount }}</h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-stalker"></i>
        </div>
        @can('isSystemAdmin')
         <a href="{{ route('user') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endcan
      </div>
    </div>
    
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>${{ $sales }}</h3>
          <p>Sales</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        @if(Auth::user()->can('isSystemAdmin', App\User::class))
          <a href="{{ route('sale') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endif
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $custCount }}</h3>
          <p>Customers</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-contacts"></i>
        </div>
        @if(Auth::user()->can('isSystemAdmin', App\User::class))
          <a href="{{ route('customer') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endif
      </div>
    </div>
    
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $invenTotal }}</h3>
          <p>Inventories</p>
        </div>
        <div class="icon">
          <i class="ion ion-archive"></i>
        </div>
        @if(Auth::user()->can('isSystemAdmin', App\User::class))
         <a href="{{ route('item') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endif
      </div>
    </div>
    <!-- ./col -->
    @endif
    <!-- ./col -->
    @can('isSuperAdmin')
    <!-- Stores/companies -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $compCount }}</h3>
            <p>Companies</p>
          </div>
          <div class="icon">
            <i class="ion ion-briefcase"></i>
          </div>
          <!-- <a href="{{ route('company') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- /. stores/companies -->
    <!-- Stores/companies -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $allUsers }}</h3>
            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-stalker"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- /. stores/companies -->
    <!-- Stores/companies -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ $superAdminCount }}</h3>
            <p>Super Admins</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-stalker"></i>
          </div>
          <!-- <a href="{{ route('superAdmin') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- /. stores/companies -->
  @endcan
  </div>
 
  <!-- List of companies -->
      @can('isSuperAdmin')
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Companies</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
    
              <div class="box">
                <div class="box-header">
                  <button class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal-new-company" id="btn-new-company">Add Company</button>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="box-user">
                  <table id="data_comp_tbl" class="table table-bordered table-striped test">
                    <thead>
                      <tr>
                        <th>Company</th>
                        <th>State/Province</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Contact NO</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($companies as $company)
                      <tr>
                        <td><a href="#" class="company-detail-link"
                          data-comp-id="{{ $company->company_id }}">{{ $company->comp_name }}</a></td>
                        <td>{{ $company->comp_state }}</td>
                        <td>{{ $company->comp_city }}</td>
                        <td>{{ $company->comp_address }}</td>
                        <td>{{ $company->contact_no }}</td>
                        <td>{{ $company->email }}</td>
                        <td><button
                            class="btn-set-status @if($company->comp_status == 0) btn-xs btn btn-danger @elseif($company->comp_status == 1) btn-xs btn btn-success @endif"
                            data-comp-status-value="{{ $company->comp_status }}"
                            data-comp-id="{{ $company->company_id }}">@if($company->comp_status == 0) Inactive
                            @elseif($company->comp_status == 1)Active @endif</button></td>
                        <td><button class="fa fa-pencil btn btn-default btn-set-user-count"
                            data-comp-id="{{ $company->company_id }}" data-toggle="modal"
                            data-target="#modal-edit-user-count"> <span
                              class="label label-primary">{{ $company->user_count }}</span> </button></td>
                      </tr>
    
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        @endcan
  <!-- /. List of companies -->

  <!-- ============= Products in INVENTORIES ==============-->
  @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class) || Auth::user()->can('isCashier', App\User::class))
      <div class="box">
        <div class="box-header">
          <!-- Header of items-page -->
          <section class="content-header">
            @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class)) 
                  <button class="btn btn-primary" data-toggle="modal" data-target="#modal-item">Add Item</button>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#modal-category">Add Category</button>
            @endif
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
                    @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class))
                      <th>Action</th>
                    @endif
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
                    @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class)) 
                        <td>
                          <button class="btn btn-danger btn-sm btn_delete_product" data-toggle="modal" data-target="#modal-delete-item"
                            data-product-id="{{ $item->item_id }}"><i class="fa fa-trash"></i></button>
                          <button class="btn btn-primary btn-sm btn_edit_item" data-toggle="modal" data-target="#modal-edit-item"
                            data-item-id="{{ $item->item_id }}" data-item-name="{{ $item->item_name }}" data-item-desc="{{ $item->item_desc }}"
                            data-item-qty="{{ $item->quantity }}" data-item-barcode="{{ $item->barcode_number }}"
                            data-item-purchase="{{ $item->purchase_price }}" data-item-taxable="{{ $item->taxable }}"
                            data-item-sell="{{ $item->sell_price }}">
                            <i class="fa fa-pencil"></i>
                          </button>
                        </td>
                    @endif
                  </tr>
                  @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
  @endif
  <!-- ============== /. INVENTORIES ================= -->
</section>
<!-- /.content -->

<!-- =============================== MODALS ==================================== -->
<!-- Modal-area -->
<!-- Increase/Decrease User-Counts -->
<div class="modal fade" id="modal-edit-user-count">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change User Count</h4>
      </div>
      <div class="modal-body">
        <h5>Set user count from the below list</h5>
        <!-- User-Count -->
        <div class="form-group has-feedback">
          <input type="hidden" name="input_comp_id">
          <div class="input-group  col-md-10 com-sm-10 col-xs-12 col-md-offset-1">
            <select name="company_user_count" class="form-control">
              <option value="1" name="company_user_count">1 User</option>
              <option value="2" name="company_user_count">2 Users</option>
              <option value="3" name="company_user_count">3 Users</option>
              <option value="4" name="company_user_count">4 Users</option>
              <option value="5" name="company_user_count">5 Users</option>
              <option value="6" name="company_user_count">6 Users</option>
              <option value="7" name="company_user_count">7 Users</option>
              <option value="8" name="company_user_count">8 Users</option>
              <option value="9" name="company_user_count">9 Users</option>
              <option value="10" name="company_user_count">10 Users</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn_set_user_count pull-left"
          onclick="onUserCount();">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /. Increase/Decrease User-Counts -->

<!-- New Company MODAL -->
<div class="modal fade" id="modal-new-company">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title"><b>Company Registeration</b></h5>
      </div>
      <div class="modal-body">
        <!-- Message area -->
        <ul id="role-msg" style="display: block">
        </ul>
        <div class="register-box-body">
          <form class="form-horizontal" id="new_company_form">
            @csrf
            <!-- User couunt/limitation -->
            <div class="form-group">
                <label for="users" class="col-sm-2 control-label">Users</label>
              <div class="col-sm-9">
                  <select name="user_count" class="form-control">
                    <option value="1" name="company">1 User</option>
                    <option value="2" name="company">2 Users</option>
                    <option value="4" name="company">4 Users</option>
                    <option value="5" name="company">5 Users</option>
                    <option value="6" name="company">6 Users</option>
                    <option value="7" name="company">7 Users</option>
                    <option value="8" name="company">8 Users</option>
                    <option value="9" name="company">9 Users</option>
                    <option value="10" name="company">10 Users</option>
                  </select>
              </div>
            </div>
            <!-- User couunt/limitation -->
            <!-- Company-Name -->
            <div class="form-group">
                <label for="company" class="col-sm-2 control-label">Company Name</label>
                <div class="col-sm-9">
                  <input id="comp_name" type="text" class="form-control" name="comp_name" placeholder="Company Name">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- /. Company State -->
            <div class="form-group">
                <label for="state" class="col-sm-2 control-label">State / Province</label>
               <div class="col-sm-9">
                  <input id="comp_state" type="text" class="form-control" name="comp_state" placeholder="Location State/Province">
               </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- /. Company City -->
            <div class="form-group">
                <label for="city" class="col-sm-2 control-label">City</label>
                <div class="col-sm-9">
                  <input id="comp_city" type="text" class="form-control" name="comp_city" placeholder="City">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- Company-Address -->
            <div class="form-group">
                <label for="address" class="col-sm-2 control-label">Address</label>
                <div class="col-sm-9">
                  <input id="comp_address" type="text" class="form-control" name="comp_address" placeholder="Company Address">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- Company-Contact -->
            <div class="form-group">
                <label for="contact" class="col-sm-2 control-label">Contact</label>
               <div class="col-sm-9">
                  <input id="comp_contact" type="text" class="form-control" name="comp_contact" placeholder="Contact NO">
               </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- Company-Email -->
            <div class="form-group">
               <label for="email" class="col-sm-2 control-label">Email</label>
               <div class="col-sm-9">
                  <input id="comp_email" type="email" class="form-control" name="comp_email" placeholder="Email">
               </div>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modal-new-user"
                id="btn_system_admin">Add System Admin</button> -->
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary pull-left">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- New Compan MODAL -->
  <!-- ============== MODALS related to INVENTORIES ===============-->
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
            <form class="form-horizontal" id="new_ctg_form">
              @csrf
  
              <div class="form-group has-feedback">
                  <label for="ctg-name" class="col-sm-2 control-label">Category Name</label>
                  <div class="col-sm-9">
                    <input id="ctg_name" type="text" class="form-control" name="ctg_name" placeholder="Category Name">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                  <label for="desc" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-9">
                    <input id="ctg_desc" type="text" class="form-control" name="ctg_desc" placeholder="Description (Optional)">
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
                <label for="category" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-9">
                  <select name="item_category" id="item_category" class="form-control" required autofocus>
                    @foreach($ctgs as $ctg)
                    <option value="{{ $ctg->ctg_id }}" id="ctg_option">{{ $ctg->ctg_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
              </div>
              <div class="form-group">
                  <label for="item" class="col-sm-2 control-label">Item</label>
                  <div class="col-sm-9">
                    <input id="item_name" type="text" class="form-control" name="item_name" placeholder="Item Name">
                  </div>
                      <div class="col-sm-1">
                        <span class="asterisk">*</span>
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
                  <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                  <div class="col-sm-9">
                    <input id="qty" type="number" class="form-control" name="quantity" placeholder="Quantity">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                  <label for="barcode" class="col-sm-2 control-label">Barcode</label>
                  <div class="col-sm-9">
                    <input id="barcode" type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                  </div>
              </div>
              <div class="form-group">
                  <label for="purchase-price" class="col-sm-2 control-label">Purchase Price</label>
                  <div class="col-sm-9">
                    <input id="purchase_price" type="number" class="form-control" name="purchase_price" placeholder="Purchase Price">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                <label for="sell-price" class="col-sm-2 control-label">Sell Price</label>
                <div class="col-sm-9">
                  <input id="sell_price" type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
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
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
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
            <form class="form-horizontal" enctype="multipart/form-data" id="edit_item_form_data">
              <input type="hidden" name="item_id">
              @csrf
              <div class="form-group">
                  <label for="item" class="col-sm-2 control-label">Item</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_name" placeholder="Item Name">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                  <label for="desc" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_desc" placeholder="Description">
                  </div>
              </div>
              <div class="form-group">
                  <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="quantity" placeholder="Stock">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                  <label for="barcode" class="col-sm-2 control-label">Barcode</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="barcode_number" placeholder="Barcode Number">
                  </div>
              </div>
              <div class="form-group">
                  <label for="purchase-price" class="col-sm-2 control-label">Purchase Price</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="purchase_price" placeholder="Purchase Price">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
              </div>
              <div class="form-group">
                <label for="sell-price" class="col-sm-2 control-label">Sell Price</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" name="sell_price" placeholder="Sell Price">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
              </div>
              <!-- Tax -->
              <div class="form-group has-feedback">
                  <label for="taxable" class="col-sm-2 control-label">Taxable</label>
                <div class="col-sm-9">
                      <select name="taxable" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
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
  <!-- ==============/. MODALS related to INVENTORIES ============= -->
<!-- Modal-area -->
<!--  ======================= /. MODALS ================= -->
@endsection
