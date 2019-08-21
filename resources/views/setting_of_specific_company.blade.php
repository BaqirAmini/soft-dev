
@extends('layouts.master')
@section('content')
 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
       {{ Breadcrumbs::render('comp-setting') }}
 </div>
  <div class="content">      
    <p id="comp-setting-msg" style="text-align: center;display: none;">Message</p>
        <!-- Horizontal Form -->
        <div class="box box-primary" id="box_for_specific_company">
          <div class="box-header">
            <div class="content-header">
              <h3 class="box-title">Configure Company</h3>
            </div><br>
            <!-- ============  Company LOGO =============== -->
          @foreach($companies as $c)
            <form id="specific_comp_logo_form" enctype="multipart/form-data" class="col-md-offset-1 col-sm-offset-1">
              @csrf
              <input type="hidden" name="cid" id="hidden_comp_id" value="{{ $c->company_id }}">
              <div class="form-group pull-left" style="text-align:center" id="uploaded_image">
                <label class="company-logo pull-left">
                  <img class="img-circle img-bordered pull-left" @if(Auth::check()) src="/uploads/logos/{{ $c->comp_logo }}" @endif
                    alt="Logo" id="specific_company_logo">
                  <input type="file" id="clogo" class="upload form-control" name="company_logo">
                </label>
              </div>
            </form>
            <!-- ============= /. Company LOGO ================= -->
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <form class="form-horizontal" id="form_specific_company_setting" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="cid" id="hidden_comp_id" value="{{ $c->company_id }}">
                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="company_name">Name</label>
                    <span class="asterisk">*</span>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="cname" placeholder="Company Name" value="{{ $c->comp_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="state">State / Province</label>
                    <span class="asterisk">*</span>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="cstate" placeholder="State" value="{{ $c->comp_state }}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="city">City</label>
                    <span class="asterisk">*</span>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ccity" placeholder="City" value="{{ $c->comp_city }}">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="address">Address</label>
                  <span class="asterisk">*</span>
                </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="caddress" placeholder="Address" value="{{ $c->comp_address }}">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="contact">Contact #</label>
                  <span class="asterisk">*</span>
                </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ccontact" placeholder="Contact NO" value="{{ $c->contact_no }}">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="cemail">Email</label>
                </div>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" name="cemail" placeholder="Email" value="{{ $c->email }}">
                    &nbsp;
                  </div>
                </div>


              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{ route('dashboard') }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
  </div>
@endforeach
@stop