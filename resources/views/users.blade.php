
@extends('layouts.master')
@section('content')
    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('users') }}
    </div>

<div class="modal fade" id="modal-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>User Management</b></h4>
      </div>
      <!-- @csrf -->
      <div class="modal-body">
          <div class="register-box-body">
            <form class="form-horizontal" id="user_role_form">
              <input type="hidden" name="role_id" id="role_id" >
              @csrf
              <div class="form-group">
                <label for="role" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-10">
                    <select name="role" id="select_role" class="col-sm-10 form-control">
                      <option value="">-------- Select Role --------</option>
                      <option value="System Admin">System Admin</option>
                      <option value="Stock Manager">Stock Manager</option>
                      <option value="Cashier">Cashier</option>
                    </select>
                </div>
              </div>
              <div class="modal-footer">
                <input type="button" value="Cancel" class="btn btn-default pull-left" data-dismiss="modal">
                <input type="submit" id="btn_save_in_modal_user" value="Save" class="btn btn-default pull-left" disabled>
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

     <!-- Main content -->
     <section class="content" id="users_list">
        <div class="row">
          <div class="col-lg-12 col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="content-header">
                    <h3 class="box-title">User Management</h3>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">

            <div class="box">
                <div class="box-header">
                    <div class="box-header">
                      @if( $activeCount < $user_count or $existingCount < $user_count) <button class="btn btn-primary" id="add_user"
                        data-toggle="modal" data-target="#modal-new-user">Add User</button>
                        @else
                        <button class="btn btn-default" disabled id="add_user" data-toggle="modal" data-target="#modal-new-user">Add
                          User</button>
                        @endif

                    </div>
                </div>
                <div class="box-body">
                  <ul id="status_msg" style="display: none;">message....</ul>
                    <!-- /.box-header -->
                    <div class="box-body" id="box-user">
                      <table id="data_tbl1" class="table table-bordered table-striped test">
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
                          @foreach($users as $user)
                          <tr>
                            <td>
                                <a @if($user->role !== 'System Admin') href="#" data-user-id="{{ $user->id }}"  class="which-user" @endif ><img src="uploads/user_photos/{{$user->photo}}" alt="User Image" height="40" width="40" class="img-circle img-bordered"></a>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td id="r"><button class="btn btn-default btn-sm btn_role" data-toggle="modal" data-target="#modal-user"
                                data-user-id="{{ $user->id }}">
                                <i> {{ $user->role }} </i>
                              </button></td>
                            <td><button
                                class="btn-user-set-status @if($user->status == 0) btn-xs btn btn-danger @elseif($user->status == 1) btn-xs btn btn-success @endif"
                                data-user-status-value="{{ $user->status }}" data-user-id="{{ $user->id }}">@if($user->status == 0)
                                Inactive @elseif($user->status == 1) Active @endif</button></td>
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
            </div>
          </div>
        </div>
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
                <ul id="role-msg" style="display: none"></ul>
                  <div class="register-box-body">
                      <p class="login-box-msg">Register a new user</p>

                      <form class="form-horizontal" id="new_user_form">
                        <!-- <input type="hidden" name="counter" value="0"> -->
                        @csrf
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
                          <label for="role" class="col-sm-2 control-label">Role <span class="asterisk">*</span></label>
                               <div class="col-sm-9">
                                  <select name="role" class="form-control">
                                    <option value="Stock Manager" name="role">Stock Manager</option>
                                    <option value="Cashier" name="role">Cashier</option>
                                  </select>
                               </div>
                        </div>
                          <!-- /roles -->
                          <!-- Username -->
                            <div class="form-group">
                              <label for="username" class="col-sm-2 control-label">User Name <span class="asterisk">*</span></label>
                              <div class="col-sm-9">
                                <input id="username" type="text" class="form-control" name="user_name" placeholder="User Name">
                              </div>
                            </div>
                          <!-- /Username -->
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
