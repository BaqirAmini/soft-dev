
@extends('layouts.master')
@section('content')
<div class="modal fade" id="modal-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <b id="role_mgs"></b>
        <h4 class="modal-title"><b>User Management</b></i></h4>
      </div>
      <!-- @csrf -->
      <div class="modal-body">
          <h5 style="text-align:center"><strong>Choose a role</strong></h5>
                <br>
                <div class="row" class="col-md-12" style="margin:auto;text-align:center">
                    <input type="hidden" name="role_id" id="role_id">
                    <label class="radio-inline">
                    <input type="radio" name="role" value="System Admin" id="radio_admin" checked>Administrator
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="role" value="store manager" id="radio_super_user">Store Manageer
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="role" value="cashier" id="radio_user">Cashier
                    </label>          
                </div>
             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="btn_set_role" class="btn btn-primary pull-left" onclick="setRole();">Set Role</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

     <!-- Main content -->
     <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">User Management <strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                
            <div class="box">
              <div class="box-header">
           <button class="btn btn-primary" id="new_user" data-toggle="modal" data-target="#modal-new-user">New User</button>
              <!-- /.box-header -->
              <div class="box-body" id="box-user">
                <p id="role-msg" style="text-align:center;display: none"></p>
                <table id="data_tbl1" class="table table-bordered table-striped test">
                  <thead>
                  <tr>
                    <th>Photo</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                @foreach($users as $user)
                  <tr>
                    <td><a href="#"><img src="uploads/user_photos/{{$user->photo}}" alt="User Image" height="40" width="40"></a></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td id="r"><button class="btn btn-default btn-sm btn_role"  data-toggle="modal" data-target="#modal-user" data-user-id="{{ $user->id }}">
                      <i> {{ $user->role }} </i>
                  </button></td>
                    <td><button class="btn-user-set-status @if($user->status == 0) btn-xs btn btn-danger @elseif($user->status == 1) btn-xs btn btn-success @endif" 
                      data-user-status-value="{{ $user->status }}"
                      data-user-id="{{ $user->id }}">@if($user->status == 0) Inactive @elseif($user->status == 1) Active @endif</button></td>
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
<!-- new-user-modal -->
        <div class="modal fade" id="modal-new-user">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <div class="register-box-body">
                   
                      <p class="login-box-msg">Register a new user</p>
                  
                      <form id="new_user_form">
                        <input type="hidden" name="counter" value="0">
                        @csrf
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
                                <select name="role" class="form-control">
                                  <option value="Stock Manager" name="role">Stock Manager</option>
                                  <option value="Cashier" name="role">Cashier</option>
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
                              <input id="confirm_password" type="password" class="form-control" name="password_confirmation" placeholder="Retype Password">
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
<!-- /. new-user-modal -->

        <!-- User-profile-modal -->
        <div class="modal fade" id="modal-user-profile">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        <!-- /. User-profile-modal -->

<!-- Modal-area -->
@stop