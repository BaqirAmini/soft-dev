
@extends('layouts.master')
@section('content')
 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
{{--       {{ Breadcrumbs::render('comp-setting') }}--}}
 </div>
  <div class="content">
    <p id="new_customer_message" style="text-align: center;display: none;">Message</p>
        <!-- Horizontal Form -->
        <div class="box box-primary" id="box_for_specific_company">
          <div class="box-header">
            <div class="content-header">
              <h3 class="box-title">Register New Customer</h3>
            </div><br>
            <!-- ============  Company LOGO =============== -->
            <form id="specific_comp_logo_form" enctype="multipart/form-data" class="col-md-offset-1 col-sm-offset-1">
              @csrf
              <input type="hidden" name="cid" id="hidden_comp_id" value="">
              <div class="form-group pull-left" style="text-align:center" id="uploaded_image">
                <label class="company-logo pull-left">
                  <img class="img-circle img-bordered pull-left" @if(Auth::check()) src="/uploads/user_photos/user.png" @endif
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
{{--              <input type="hidden" name="cid" id="hidden_comp_id" value="">--}}
                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="business_name">Business Name</label>
                    <span class="asterisk">*</span>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="business_name" placeholder="Business Name" value="">
                  </div>
                </div>

                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="seller_permit_number">Seller Permit Number</label>
                        <span class="asterisk">*</span>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="seller_permit_number" placeholder="Seller Permit Number" value="">
                    </div>
                </div>

                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="first_name">First Name</label>
                    <span class="asterisk">*</span>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="control-label the-ast col-sm-2">
                    <label for="city">Last Name</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="phone">Phone</label>
                  <span class="asterisk">*</span>
                </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="contact">Email</label>
                </div>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="">
                  </div>
                </div>
                <div class="form-group">
                <div class="control-label the-ast col-sm-2">
                  <label for="account_number">Account Number</label>
                </div>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="account_number" placeholder="Account Number" value="">
                    &nbsp;
                  </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="account_type_ID">Account Type ID</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="account_type_ID" placeholder="Account Type ID" value="">
                        &nbsp;
                    </div>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label for="credit_limit" class="col-sm-2 control-label">Limit
                        Purchase</label>
                    <div class="col-sm-9">
                        <!-- radio -->
                        <label class="limit_purchase" style="margin-right: 50px;">
                            <input type="radio" name="limit_purchase" value="1" class="status"
                                   class="form-control"
                                   {{--@if($customers[0]->LimitPurchase === 1) checked @endif--}}>&nbsp;
                            Yes
                        </label>
                        <label class="credit_limit">
                            <input type="radio" name="limit_purchase" value="0" class="status"
                                   class="form-control"
                                  {{-- @if($customers[0]->LimitPurchase === 0) checked
                                   @endif checked--}}>&nbsp; No
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="account_balance">Account Balance</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" min="0" step="0.001" name="account_balance" placeholder="Account Balance" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="credit_limit">Credit Limit</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" min="0" step="0.001" name="credit_limit" placeholder="Credit Limit" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="credit_limit">Credit Limit</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" min="0" step="0.001" name="credit_limit" placeholder="Credit Limit" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="HQID">HQID</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="HQID" placeholder="HQID" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="country">Country</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="country" placeholder="Country" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="province">Province</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="province" placeholder="Province" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="address1">Address1</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="address1" placeholder="Address 1" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="address2">Address 2</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="address2" placeholder="Address 2" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="city">City</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="city" placeholder="City" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="zip_code">Zip Code</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="zip_code" placeholder="Zip Code" value="">
                    </div>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label for="employee" class="col-sm-2 control-label">Employee</label>
                    <div class="col-sm-9">
                        <!-- radio -->
                        <label class="employee" style="margin-right: 50px;">
                            <input type="radio" name="employee" value="1" class="status"
                                   class="form-control"
                                {{--@if($customers[0]->LimitPurchase === 1) checked @endif--}}>&nbsp;
                            Yes
                        </label>
                        <label class="credit_limit">
                            <input type="radio" name="employee" value="0" class="status"
                                   class="form-control"
                                {{-- @if($customers[0]->LimitPurchase === 0) checked
                                 @endif checked--}}>&nbsp; No
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="fax_number">Fax Number</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="fax_number" placeholder="Fax Number" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="tax_exempt">Tax Emempt</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="tax_exempt" placeholder="Tax Exempt" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="tax_exempt">Notes</label>
                    </div>
                    <div class="col-sm-9">
                        <textarea name="notes" class="form-control" id="" cols="5" rows="2"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="price_level">Price Level</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="price_level" placeholder="Price Level" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="control-label the-ast col-sm-2">
                        <label for="tax_number">Tax Number</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  name="tax_number" placeholder="Tax Number" value="">
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
@stop
