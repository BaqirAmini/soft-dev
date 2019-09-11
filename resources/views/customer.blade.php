@extends('layouts.master')
@section('content')
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('customer') }}
    </div>
  <div class="content">
      @if(count($errors) > 0)
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <ul style="color:darkred">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      @if($msg = Session::get('success'))
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <span style="color: #0b93d5">{{ $msg }}</span>
              </div><br>
      @endif
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
                @can('isSystemAdmin')
                  <section class="content-header">
                      <a href="{{ route('customer.register') }}" type="button" class="btn btn-primary">Add Customer</a>
                      {{--   Dropdown for Excel   --}}
                      <div class="dropdown pull-right">
                          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">More
                              <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                              <li class="dropdown-header">Excel Sheets</li>
                              <li><a href="{{ route('customer.export') }}">Export Excel</a></li>
                              <li><a href="#" data-toggle="modal" data-target="#modal-customer-excel">Import Excel</a></li>
                              <li class="divider"></li>
                             {{-- <li class="dropdown-header">Dropdown header 2</li>
                                <li><a href="#">About Us</a></li>--}}
                          </ul>
                      </div>
                      <br>

                    <div>
                        @if($msg = Session::get('no_purchase'))
                            <h4 style="color: darkred">{{$msg}}</h4>
                        @endif
                    </div>
                      {{--   /. Dropdown for Excel   --}}
                  </section>
                @endcan
            </div>
            <div class="box-body">
              <div class="box">
                  <div class="box-header">
                      <!-- Datatables -->
                      <table id="data_tbl5" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Photo</th>
                            <th>Business Name</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>State/Province</th>
                            <th>Address</th>
                            <th>Reg. Date</th>
                            <!-- <th>Action</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($customers as $customer)
                          <tr>
                            <td><a href="#"><img src="{{ asset('image/user_image/user.png') }}" alt="" height="30" width="30"></a></td>
                            <td>
                            <a href="#" class="customer-detail" data-cust-id="{{ $customer->cust_id }}">
                              {{ $customer->business_name }}
                            </a>
                            </td>
                            <td>{{ $customer->cust_name }} </td>
                            <td>{{ $customer->cust_lastname }}</td>
                            <td>{{ $customer->cust_phone }}</td>
                            <td>{{ $customer->cust_email }}</td>
                            <td>{{ $customer->cust_addr }}</td>
                            <td>{{ $customer->cust_state }}</td>
                            <td>{{ Carbon\carbon::parse($customer->created_at)->format('M d Y')  }}</td>
                            <!-- <td>
                              <button class="btn btn-danger btn-sm delete-customer" data-cust-id="{{ $customer->cust_id }}"
                                data-toggle="modal" data-target="#modal-delete-customer">
                                <i class="fa fa-trash"></i>
                              </button>
                            </td> -->
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
  </div>
        <!-- </div>
    </section> -->

    <!-- Modal AREA -->

    <!-- delete-customer -->
    <div class="modal fade" id="modal-delete-customer">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Customer Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="cust_id">
              <p>Are you sure you want delete this customer?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="deleteCustomer();">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    <!-- /.delete-customer -->

     <!-- edit-customer -->
     <div class="modal fade" id="modal-edit-customer">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Customer Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cust_id">
                  <p>Are you sure you want delete this customer?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" onclick="deleteCustomer();">Delete</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        <!-- /.edit-customer -->
<!-- new-customer modal -->
{{--<div class="modal fade" id="modal-customer">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add New Customer</h4>
              <ul id="msg_area" style="display:none">

              </ul>
            </div>
            <div class="modal-body">
              <p id="cust_message" style="display:none">Customer Message</p>
                <div class="register-box-body">
                    <form  class="form-horizontal">
                        @csrf
                        <!-- Business Name -->
                        <div class="form-group">
                          <label for="business_name" class="col-sm-2 control-label">Business Name <span class="asterisk">*</span></label>
                          <div class="col-sm-9">
                            <input id="business_name" type="text" class="form-control" name="business_name" placeholder="Business Name">
                          </div>
                        </div>
                        <!-- Customer First Name -->
                        <div class="form-group">
                            <label for="cust-name" class="col-sm-2 control-label">First Name <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                              <input id="cust_name" type="text" class="form-control" name="cust_name" placeholder="Customer Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cust-lastname" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-9">
                              <input id="cust_lastname" type="text" class="form-control" name="cust_lastname" placeholder="Customer Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                              <input id="cust_phone" type="text" class="form-control" name="cust_phone" placeholder="Customer Phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-9">
                              <input id="cust_email" type="text" class="form-control" name="cust_email" placeholder="Customer Email (Optional)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-sm-2 control-label">Province / State <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                              <input id="cust_state" type="text" class="form-control" name="cust_state" placeholder="Province/State">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Adress <span class="asterisk">*</span></label>
                            <div class="col-sm-9">
                              <input id="cust_addr" type="text" class="form-control" name="cust_addr" placeholder="Address">
                            </div>
                        </div>
                    </form>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                          <button type="button" id="btn_add_customer" class="btn btn-primary pull-left">Add Now</button>
                      </div>
                  </div>
            </div>
            <!-- end of modal-body div -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>--}}
      <!-- /.new-customer modal -->

      <!-- customer-profile -->
      <div class="modal fade" id="customer-profile">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Customer Details</h4>
              </div>
              <div class="modal-body">
                <!-- profile-tabs -->

                        <div class="nav-tabs-custom">
                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">About</a></li>
                            <li><a href="#timeline" data-toggle="tab" id="purchase_history">Balance</a></li>
                          @can('isSystemAdmin')
                            <li><a href="#settings" data-toggle="tab">Edit</a></li>
                          @endcan
                          </ul>
                          <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                              <!-- Post -->
                              <div class="post">
                                <div class="user-block">
                                  <img class="img-circle img-bordered-sm" src="{{ asset('image/user_image/user.png') }}" alt="user image">
                                      <span class="username">
                                        <a href="#" id="custName">Jonathan Burke Jr.</a>
                                        <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                                      </span>
                                  <span class="description">Shared publicly - 7:30 PM today</span>
                                </div>
                                <!-- /.user-block -->
                               <p id="customer-phone">Customer Phone</p>
                               <p id="customer-email">Customer Email</p>
                              </div>
                              <!-- /.post -->
                            </div>

                            <div class="tab-pane" id="settings">
                              <form class="form-horizontal" id="customer-profile-form">
                                <input type="hidden" name="cust_id">
                                <!-- customer name -->
                                    <div class="form-group">
                                          <label for="first-name" class="col-sm-2 control-label">First Name</label>
                                         <div class="col-sm-9">
                                            <input id="edit_cust_name" type="text" class="form-control" name="cust_name" placeholder="Customer Name">
                                         </div>
                                          <div class="col-sm-1 control-label">
                                            <span class="asterisk">*</span>
                                          </div>
                                   </div>
                                <!-- customer lastname -->
                                    <div class="form-group">
                                          <label for="last-name" class="col-sm-2 control-label">Last Name</label>
                                          <div class="col-sm-9">
                                            <input id="edit_cust_lastname" type="text" class="form-control" name="cust_lastname" placeholder="Customer Last Name">
                                          </div>
                                   </div>
                                <!-- customer phone -->
                                    <div class="form-group">
                                          <label for="phone" class="col-sm-2 control-label">Phone</label>
                                         <div class="col-sm-9">
                                            <input id="edit_cust_phone" type="number" class="form-control" name="cust_phone" placeholder="Customer Phone">
                                         </div>
                                          <div class="col-sm-1 control-label">
                                            <span class="asterisk">*</span>
                                          </div>
                                   </div>
                                <!-- customer email -->
                                    <div class="form-group">
                                          <label for="email" class="col-sm-2 control-label">Email</label>
                                          <div class="col-sm-9">
                                            <input id="edit_cust_email" type="email" class="form-control" name="cust_email" placeholder="Customer Email">
                                          </div>
                                   </div>
                                <!-- customer state -->
                                    <div class="form-group">
                                          <label for="state" class="col-sm-2 control-label">Province / State</label>
                                          <div class="col-sm-9">
                                            <input id="edit_cust_state" type="text" class="form-control" name="cust_state" placeholder="Customer State">
                                          </div>
                                          <div class="col-sm-1 control-label">
                                            <span class="asterisk">*</span>
                                          </div>
                                   </div>
                                <!-- customer address -->
                                    <div class="form-group">
                                          <label for="address" class="col-sm-2 control-label">Address</label>
                                          <div class="col-sm-9">
                                            <input id="edit_cust_addr" type="text" class="form-control" name="cust_addr" placeholder="Customer Address">
                                          </div>
                                          <div class="col-sm-1 control-label">
                                            <span class="asterisk">*</span>
                                          </div>
                                   </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default pull-left" id="btn-edit-customer" data-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-primary pull-left" id="btn-edit-customer">Change</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.tab-pane -->
                          </div>
                          <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                <!-- /. profile-tabs -->
              </div>

            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /. customer-profile -->

    <div class="modal fade" id="modal-customer-excel">
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
                        <form action="{{ route('customer.import') }}" method="post"  enctype="multipart/form-data"  class="form-horizontal">
                            @csrf
                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" id="excel_name" disabled="disabled">
                                <div class="input-group-addon">
                                    <label class="excel_upload">
                                        <span>Choose</span>
                                        <input type="file" id="excel_import_file" class="upload logo-file-input form-control" name="excel">
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
    <!-- /. Modal AREA -->
@stop
