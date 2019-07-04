@extends('layouts.master')

@section('content')
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
  @can('isSystemAdmin')
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
        <a href="{{ route('user') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
        <a href="{{ route('sale') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
        <a href="{{ route('customer') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
        <a href="{{ route('item') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    @endcan
    <!-- ./col -->
    @can('isSuperAdmin')
    <!-- Stores/companies -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $compCount }}</h3>
            <p>Companies</p>
          </div>
          <div class="icon">
            <i class="ion ion-briefcase"></i>
          </div>
          <a href="{{ route('company') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- /. stores/companies -->
    <!-- Stores/companies -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $allUsers }}</h3>
            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-stalker"></i>
          </div>
          <a href="{{ route('user') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- /. stores/companies -->
    <!-- Stores/companies -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ $custCount }}</h3>
            <p>More...</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-add"></i>
          </div>
          <a href="{{ route('customer') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- /. stores/companies -->
    <!-- Stores/companies -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ $custCount }}</h3>
            <p>Settings</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-settings"></i>
          </div>
          <a href="{{ route('customer') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- /. stores/companies -->
  @endcan
  </div>
 
  <!-- List of companies -->
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
                  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-new-company"
                    id="btn-new-company">New Company</button>
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
                        <td>{{ $company->comp_name }}</td>
                        <td>{{ $company->comp_state }}</td>
                        <td>{{ $company->comp_city }}</td>
                        <td>{{ $company->comp_address }}</td>
                        <td>{{ $company->contact_no }}</td>
                        <td>{{ $company->email }}</td>
                        @csrf
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
  <!-- /. List of companies -->
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
          <div class="input-group  col-md-12 com-sm-12 col-xs-6">
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
          <form id="system_admin_form">
            @csrf
            <!-- roles -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                <select name="company" class="form-control">
                  @foreach($companies as $c)
                  <option value="{{ $c->company_id }}" name="company" active>{{ $c->comp_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- first-name -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name">
              </div>
            </div>
            <!-- /. first-name -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Lastname">
              </div>
            </div>
            <!-- phone -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                <input id="phone" type="number" class="form-control" name="phone" placeholder="Phone">
              </div>
            </div>
            <!-- email -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input id="email" type="email" class="form-control" name="email" placeholder="Email (Optional)">
              </div>
            </div>

            <!-- roles -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                <select name="role" class="form-control">
                  <option value="System Admin" name="role" readonly>System Admin</option>
                </select>
              </div>
            </div>

            <!-- /roles -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
              </div>
            </div>
            <!-- confirm-password -->
            <div class="form-group has-feedback">
              <div class="input-group has-feedback">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
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
          <form id="new_company_form">
            @csrf
            <!-- User couunt/limitation -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>Users:</strong></span>
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
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>Company Name:</strong></span>
                <input id="comp_name" type="text" class="form-control" name="comp_name" placeholder="Company Name">
              </div>
            </div>
            <!-- /. Company State -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>State/Province:</strong></span>
                <input id="comp_state" type="text" class="form-control" name="comp_state"
                  placeholder="Location State/Province">
              </div>
            </div>
            <!-- /. Company City -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>City:</strong></span>
                <input id="comp_city" type="text" class="form-control" name="comp_city" placeholder="City">
              </div>
            </div>
            <!-- Company-Address -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>Address:</strong></span>
                <input id="comp_address" type="text" class="form-control" name="comp_address"
                  placeholder="Company Address">
              </div>
            </div>
            <!-- Company-Contact -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>Contact:</strong></span>
                <input id="comp_contact" type="text" class="form-control" name="comp_contact" placeholder="Contact NO">
              </div>
            </div>
            <!-- Company-Email -->
            <div class="form-group has-feedback">
              <div class="input-group">
                <span class="input-group-addon"><strong>Email:</strong></span>
                <input id="comp_email" type="email" class="form-control" name="comp_email" placeholder="Email">
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modal-new-user"
                id="btn_system_admin">Add System Admin</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Register</button>
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
<!--  ======================= /. MODALS ================= -->
@endsection
