
</style>
@extends('layouts.master')
@section('content')
  <div class="content">
    <head>
      <style>
        .company-status {
          margin-right: 50px;
        }
      </style>
    </head>
      
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Configure Company</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" id="form-company-detail">
            @csrf
            <div class="box-body">
              <input type="hidden" name="company_id" id="hidden_comp_id">
              <div class="form-group">
                <label for="logo" class="col-sm-2 control-label">Logo</label>
                <div class="col-sm-10">
                <label class="custom-upload">
                  Choose<br>Avatar
                  <input type="file" id="company_logo" class="upload customer-file-input form-control" name="company-logo">
                </label>
                <strong id="comp-setting-msg" style="margin-left:100px;display: none">Message</strong>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Company Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="comp-name" placeholder="Company Name">
                </div>
              </div>
              <div class="form-group">
                <label for="state" class="col-sm-2 control-label">State/Province</label>
              
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="comp-state" placeholder="State">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">City</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="comp-city" placeholder="City">
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="col-sm-2 control-label">Company Address</label>
              
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="comp-address" placeholder="Address">
                </div>
              </div>
              <div class="form-group">
                <label for="contact" class="col-sm-2 control-label">Contact NO</label>
              
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="comp-contact" placeholder="Contact NO">
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
              
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="comp-email" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">Company Status</label>
                <div class="col-sm-10">
                  <!-- radio -->
                      <label class="company-status">
                        <input type="radio" name="company-status" class="status"checked class="form-control">&nbsp; Active
                      </label>
                      <label class="company-status">
                        <input type="radio" name="company-status" class="status" checked  class="form-control">&nbsp; Inactive
                      </label>
                </div>
              </div>
              <div class="form-group">
                <label for="user-count" class="col-sm-2 control-label">Users</label>
              
                <div class="col-sm-10">
                  <select name="user-count" class="form-control">
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
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <!-- <div class="checkbox">
                    <label>
                      <input type="checkbox"> Remember me
                    </label>
                  </div> -->
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <!-- <button type="button" class="btn btn-default">Cancel</button> -->
              <button type="submit" class="btn btn-info pull-right">Save</button>
            </div>
            <!-- /.box-footer -->
          </form>
          
      
  </div>
@stop