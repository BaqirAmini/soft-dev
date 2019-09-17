
@extends('layouts.master')
@section('content')
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('stores') }}
    </div>
     <!-- Main content -->
     <section class="content">
        <div class="row">
          <div class="col-xs-12">
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
                    <td><a href="#" class="company-detail-link" data-comp-id="{{ $company->company_id }}">{{ $company->comp_name }}</a></td>
                    <td>{{ $company->comp_state }}</td>
                    <td>{{ $company->comp_city }}</td>
                    <td>{{ $company->comp_address }}</td>
                    <td>{{ $company->contact_no }}</td>
                    <td>{{ $company->email }}</td>
                    <td><button class="btn-set-status @if($company->comp_status == 0) btn-xs btn btn-danger @elseif($company->comp_status == 1) btn-xs btn btn-success @endif"
                      data-comp-status-value="{{ $company->comp_status }}"
                      data-comp-id = "{{ $company->company_id }}">@if($company->comp_status == 0) Inactive @elseif($company->comp_status == 1)Active @endif</button></td>
                    <td><button class="fa fa-pencil btn btn-default btn-set-user-count" data-comp-id="{{ $company->company_id }}" data-toggle="modal" data-target="#modal-edit-user-count"> <span class="label label-primary">{{ $company->user_count }}</span> </button></td>
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
      </section>
      <!-- /.content -->

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
            <div class="input-group  col-md-12 com-sm-12 col-xs-6">
                <select name="company_user_count" class="form-control" id="company_user_count">
                    <option value="">-------- Select User Count ----------</option>
                  @for($a = 1; $a <= 10; $a++)
                      <option value="{{ $a }}" name="company_user_count" {{--@foreach($counts as $c) @if($c == $a) selected @endif @endforeach--}}>{{ $a }} User(s)</option>
                  @endfor
                </select>
              </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-default btn_set_user_count pull-left" onclick="onUserCount();" disabled="disabled">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /. Increase/Decrease User-Counts -->
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
              <div class="col-sm-10">
                  <select name="company" class="form-control">
                    @foreach($companies as $c)
                    <option value="{{ $c->company_id }}" name="company" active>{{ $c->comp_name }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <!-- first-name -->
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-10">
                  <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name">
                </div>
            </div>
            <!-- /. first-name -->
            <div class="form-group">
                <label for="lastname" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-10">
                  <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Lastname">
                </div>
            </div>
            <!-- phone -->
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">Phone</label>
                <div class="col-sm-10">
                  <input id="phone" type="number" class="form-control" name="phone" placeholder="Phone">
                </div>
            </div>
            <!-- email -->
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input id="email" type="email" class="form-control" name="email" placeholder="Email (Optional)">
                </div>
            </div>

            <!-- roles -->
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-10">
                  <select name="role" class="form-control">
                    <option value="System Admin" name="role" readonly>System Admin</option>
                  </select>
                </div>
            </div>

            <!-- /roles -->
            <div class="form-group">
                <label for="Password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 control-label">
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
            </div>
            <!-- confirm-password -->
            <div class="form-group">
                <label for="confirm" class="col-sm-2 control-label">Confirm Password</label>
               <div class="col-sm-10">
                  <input id="confirm_password" type="password" class="form-control" name="password_confirmation"
                    placeholder="Retype Password">
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
                      <label for="users" class="col-sm-2 control-label">Users <span class="asterisk">*</span></label>
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
                        <label for="company-name" class="col-sm-2 control-label">Company Name <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="comp_name" type="text" class="form-control" name="comp_name" placeholder="Company Name">
                        </div>
                </div>
                <!-- /. Company State -->
                <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State / Province <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="comp_state" type="text" class="form-control" name="comp_state" placeholder="Location State/Province">
                        </div>
                </div>
                <!-- /. Company City -->
                <div class="form-group">
                        <label for="city" class="col-sm-2 control-label">City <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="comp_city" type="text" class="form-control" name="comp_city" placeholder="City">
                        </div>
                </div>
                <!-- Company-Address -->
                <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="comp_address" type="text" class="form-control" name="comp_address" placeholder="Company Address">
                        </div>
                </div>
                <!-- Company-Contact -->
                <div class="form-group">
                        <label for="contact" class="col-sm-2 control-label">Contact <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="comp_contact" type="text" class="form-control" name="comp_contact" placeholder="Contact NO">
                        </div>
                </div>
                <!-- Company-Email -->
                <div class="form-group has-feedback">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-9">
                          <input id="comp_email" type="email" class="form-control" name="comp_email" placeholder="Email">
                        </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-success pull-left"  data-toggle="modal" data-target="#modal-new-user" id="btn_system_admin">Add System Admin</button> -->
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

<!-- Modal-area -->

@stop
