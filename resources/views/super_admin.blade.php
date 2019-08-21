
@extends('layouts.master')
@section('content')
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('superadmin') }}
    </div>

     <!-- Main content -->
     <section class="content">
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Super Admin(s)</h3>
              </div>
              <!-- /.box-header -->
                 <div class="box-body">
                <p id="role-msg" style="text-align:center;display: none"></p>
                  <div class="box">
                    <div class="box-header">
                      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-new-super-admin" id="btn-new-super-admin">Add Super Admin</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="box-user">
                      <table id="super_admin_data_tbl" class="table table-bordered table-striped test">
                        <thead>
                        <tr>
                          <th>Photo</th>
                          <th>User Name</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>   
                          @foreach($superAdmins as $sa)
                            <tr>
                                <td><a href="#"><img src="uploads/user_photos/{{ $sa->photo }}" alt="System Admin Photo" width="40" height="40"></a></td>
                                <td>{{ $sa->username }}</td>
                                <td>{{ $sa->name }}</td>
                                <td>{{ $sa->lastname }}</td>
                                <td>{{ $sa->phone }}</td>
                                <td>{{ $sa->email }}</td>
                                <td>
                                  <button
                                    class="btn-sa-set-status @if($sa->status == 0) btn-xs btn btn-danger @elseif($sa->status == 1) btn-xs btn btn-success @endif"
                                    data-sa-status-value="{{ $sa->status }}" data-sa-id="{{ $sa->id }}">@if($sa->status == 0) Inactive
                                    @elseif($sa->status == 1) Active @endif
                                  </button>
                                </td>
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
      </section>
      <!-- /.content -->

<!-- Modal-area -->
<!-- Super-admin-modal -->
<div class="modal fade" id="modal-new-super-admin">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title"><b>Super-admin Registeration</b></h5>
      </div>
      <div class="modal-body">
        
        <label for="message" id="sa_msg">
          <p class="pull-left" style="font-weight: normal">
          </p>
        </label>
        <div class="register-box-body">
          <form class="form-horizontal" id="form-new-super-admin" enctype="multipart/form-data">
            @csrf
            <!-- first-name -->
            <div class="form-group">
                <label for="super-admin-name" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-9">
                  <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name">
                </div>
                <div class="col-sm-1">
                  <span class="asterisk">*</span>
                </div>
            </div>
            <!-- /. first-name -->
            <div class="form-group">
                <label for="super-admin-lastname" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-9">
                  <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Lastname">
                </div>
            </div>
            <!-- phone -->
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">Phone</label>
                <div class="col-sm-9">
                  <input id="phone" type="text" class="form-control" name="phone" placeholder="Phone">
                </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
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
                  <select name="role" class="form-control">
                    <option value="Super Admin" name="role" readonly>Super Admin</option>
                  </select>
            </div>
              <div class="col-sm-1">
                <span class="asterisk">*</span>
              </div>
            </div>
            <!-- /roles -->
            <!-- Username -->
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label">User Name</label>
              <div class="col-sm-9">
                <input id="username" type="text" class="form-control" name="user_name" placeholder="User Name">
              </div>
              <div class="col-sm-1">
                <span class="asterisk">*</span>
              </div>
            </div>
            <!-- /. Username -->
            <!-- Password -->
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9">
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
            </div>
            <!-- confirm-password -->
            <div class="form-group">
                <label for="confirm" class="col-sm-2 control-label">Confirm Password</label>
               <div class="col-sm-9">
                  <input id="confirm_password" type="password" class="form-control" name="password_confirmation"
                    placeholder="Confirm Password">
               </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
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
<!-- Modal-area -->
@stop