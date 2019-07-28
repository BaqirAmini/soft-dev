
</style>
@extends('layouts.master')
@section('content')
  <div class="content">      
    <p id="comp-setting-msg" style="text-align: center;display: none;">Message</p>
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Configure Company</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          @foreach($companies as $c)
            <form class="form-horizontal" id="form_specific_company_setting" enctype="multipart/form-data">
              @csrf
              <div class="box-body">
                <input type="hidden" name="cid" id="hidden_comp_id" value="{{ $c->company_id }}">
                    <!-- /.form group -->
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Logo</label>
                    <div class="col-sm-9">
                        <div class="input-group col-sm-12 col-md-12">
                          <input type="text" class="form-control"  disabled>
                          <div class="input-group-addon">
                            <label class="logo-custom-upload">
                              <img src="uploads/logos/{{ $c->comp_logo }}" alt="Logo" height="15" width="15">
                              <input type="file" id="company_logo" class="upload logo-file-input form-control" name="clogo">
                            </label>
                          </div>
                        </div>
                    </div>
                    
                  </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Company Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="cname" placeholder="Company Name" value="{{ $c->comp_name }}">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="state" class="col-sm-2 control-label">State/Province</label>
                
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="cstate" placeholder="State" value="{{ $c->comp_state }}">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ccity" placeholder="City" value="{{ $c->comp_city }}">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Company Address</label>
                
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="caddress" placeholder="Address" value="{{ $c->comp_address }}">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="contact" class="col-sm-2 control-label">Contact NO</label>
                
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ccontact" placeholder="Contact NO" value="{{ $c->contact_no }}">
                  </div>
                  <div class="col-sm-1">
                    <span class="asterisk">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                
                  <div class="col-sm-9">
                    <input type="email" class="form-control" name="cemail" placeholder="Email" value="{{ $c->email }}">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{ route('dashboard') }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-info">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          @endforeach
      
  </div>
@stop