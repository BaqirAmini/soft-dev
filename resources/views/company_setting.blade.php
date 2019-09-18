@extends('layouts.master')
@section('content')
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    {{ Breadcrumbs::render('company_setting') }}
  </div>

  <div class="content">
    <head>
      <style>
        .company-status {
          margin-right: 50px;
        }
      </style>
    </head>
      <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="box-header">
                  <ul style="display:none" id="conf_msg">
                  </ul>
                    <button
                        type="button" class="btn btn-primary pull-right" data-toggle="modal"
                        data-target="#modal-new-user"
                        id="btn_system_admin" style="margin-left:10px;display: none">
                        Add System Admin
                    </button>
                </div>
                <div class="nav-tabs-custom">
                  <!-- ======================= TABS links ====================== -->
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#configure-company" data-toggle="tab" id="tab_configure">Configure</a></li>
                    <li><a href="#user-of-specific-company" data-toggle="tab" id="tab_users">Users</a></li>
                  </ul>
                  <!-- =====================/. TABS links =========================== -->
                     <div class="tab-content">
                       <!-- ==============Tab for company-configuration================= -->
                       <div class="active tab-pane" id="configure-company">
                         <div class="box-header" id="cheader">
                           @foreach($companies as $c)
                              <form id="form_company_logo"  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="cid" value="{{ $c->company_id }}">
                                <div class="form-group" style="text-align:center" id="uploaded_image">
                                  <label class="company-logo-custom-upload pull-left">
                                    <img class="img-circle img-bordered" src="/uploads/logos/{{ $c->comp_logo }}" alt="User Photo" id="company_logo_img">
                                    <input type="file" id="company_logo" class="upload  form-control" name="company_logo">
                                  </label>
                                </div>
                              </form>
                            @endforeach
                         </div>
                          <!-- form start -->
                          @foreach($companies as $c)
                          <form class="form-horizontal" id="form-company-detail" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                              <p id="comp-setting-msg" style="text-align: center;display: none;">Message</p>
                              <input type="hidden" name="cid" id="hidden_comp_id" value="{{ $compId }}">
                              <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Company Name <span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="cname" placeholder="Company Name" value="{{ $c->comp_name }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="state" class="col-sm-2 control-label">State/Province <span class="asterisk">*</span></label>

                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="cstate" placeholder="State" value="{{ $c->comp_state }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">City <span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ccity" placeholder="City" value="{{ $c->comp_city }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">Company Address <span class="asterisk">*</span></label>

                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="caddress" placeholder="Address" value="{{ $c->comp_address }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="contact" class="col-sm-2 control-label">Contact # <span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ccontact" placeholder="Contact NO" value="{{ $c->contact_no }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-9">
                                  <input type="email" class="form-control" name="cemail" placeholder="Email" value="{{ $c->email }}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Company Status</label>
                                <div class="col-sm-9">
                                  <!-- radio -->
                                  <label class="company-status">
                                    <input type="radio" name="cstatus" value="1" class="status" @if($c->comp_status == 1) checked @endif
                                    class="form-control">&nbsp; Active
                                  </label>
                                  <label class="company-status">
                                    <input type="radio" name="cstatus" value="0" class="status" @if($c->comp_status == 0) checked @endif
                                    class="form-control">&nbsp; Inactive
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="user-count" class="col-sm-2 control-label">User Count <span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                  <select name="ucount" class="form-control" id="company_user_count" required autofocus>
                                    <option value="" name="company">------------ Select User Count ------------</option>
                                    <option value="1" name="company">1 User</option>
                                    <option value="2" name="company">2 Users</option>
                                    <option value="3" name="company">3 Users</option>
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
                              <!-- /.box-body -->
                              <div class="box-footer">
                                <!-- <button type="button" class="btn btn-default">Cancel</button> -->
                                <a href="{{ route('company') }}" type="button" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                              <!-- /.box-footer -->
                            </div>
                          </form>
                          @endforeach
                       </div>
                      <!-- ============== /. Tab for company-configuration================= -->

                        <!-- ====================== Users of a specific company ==================== -->
                        <div class="tab-pane" id="user-of-specific-company">
                          <p id="role-msg" style="text-align:center;display: none"></p>
                          <table id="data_tbl_for_specific_users" class="table table-bordered table-striped test">
                            <thead>
                              <tr>
                                <th>Photo</th>
                                <th>User Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                           <div style="display: none">{{ $counter = 0 }}</div>
                              @foreach($users as $user)
                              <tr>
                                <td><a  @if($user->role === 'System Admin') href="#" class="any_system_admin_link" data-sa-id="{{ $user->id }}" @endif>
                                        <img src="/uploads/user_photos/{{$user->photo}}" class="img-circle img-bordered" alt="User Image" height="40" width="40">
                                    </a>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td><button
                                    class="btn-system-admin-set-status @if($user->status == 0) btn-xs btn btn-danger @elseif($user->status == 1) btn-xs btn btn-success @endif"
                                    data-user-status-value="{{ $user->status }}" data-user-id="{{ $user->id }}"
                                    @if($user->role !== "System Admin") disabled @endif>@if($user->status == 0) Inactive @elseif($user->status == 1) Active @endif</button>
                                </td>
                              </tr>

                              <div style="display: none">
                                  {{ $counter++ }}
                              </div>
                              @endforeach
                           <input type="hidden" name="index" value="{{ $counter }}" data-user-count="{{ $companies[0]->user_count }}">
                            </tbody>
                          </table>
                        </div>
                        <!-- ====================== /. Users of a specific company ==================== -->
                     </div>

                </div>
              </div>


            </div>

        </div>
      </div>
  </div>

  <!-- =============================== MODALS ================================== -->
  <!-- System-admin-modal -->
  <div class="modal fade" id="modal-new-user">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h5 class="modal-title"><b>Company System Admin Registeration</b></h5>
        </div>
        <div class="modal-body">
          <p id="status-msg" style="text-align:center;display: none"></p>
          <div class="register-box-body">
            <form class="form-horizontal" id="system_admin_form">
              @csrf
              <!-- roles -->
              <div class="form-group">
                <label for="company" class="col-sm-2 control-label">Company</label>
                <div class="col-sm-9">
                    <select name="company" class="form-control" readonly>
                      @foreach($companies as $c)
                       <option value="{{ $c->company_id }}" name="company">{{ $c->comp_name }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <!-- first-name -->
              <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">First Name <span class="asterisk">*</span></label>
                <div class="col-sm-9">
                  <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name">
                </div>
              </div>
              <!-- /. first-name -->
              <div class="form-group">
                <label for="lastname" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-9">
                  <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Lastname">
                </div>
              </div>
              <!-- phone -->
              <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">Phone <span class="asterisk">*</span></label>
                <div class="col-sm-9">
                  <input id="phone" type="text" class="form-control" name="phone" placeholder="Phone">
                </div>
              </div>
              <!-- email -->
              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-9">
                  <input id="email" type="email" class="form-control" name="email" placeholder="Email (Optional)">
                </div>
              </div>

              <!-- roles -->
              <div class="form-group">
                <label for="role" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-9">
                  <select name="role" class="form-control" readonly>
                    <option value="System Admin" name="role" readonly>System Admin</option>
                  </select>
                </div>
              </div>
              <!-- /roles -->
              <!-- Username -->
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">User Name <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <input id="username" type="text" class="form-control" name="user_name" placeholder="User Name">
                  </div>
                </div>
              <!-- /. Username -->
              <!-- Password -->
              <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password <span class="asterisk">*</span></label>
                <div class="col-sm-9">
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
              </div>
              <!-- confirm-password -->
              <div class="form-group">
                <label for="confirm" class="col-sm-2 control-label">Confirm Password <span class="asterisk">*</span></label>
                <div class="col-sm-9">
                  <input id="confirm_password" type="password" class="form-control" name="password_confirmation"
                    placeholder="Confirm Password">
                </div>
              </div>

              <div class="modal-footer">
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
  <!-- /. System-admin-modal -->
  <!-- =============================== /. MODALS ================================== -->
@stop
<?php ?>
