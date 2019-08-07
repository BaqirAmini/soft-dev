@extends('layouts.master')
@section('content')

<section class="content" >
<div class="row">
    <div class="col-md-12" >
        <!-- Box -->
        <div class="box" id="user_profile_box">
            <ul id="profile_msg" style="display: none;">
                Profile Message
            </ul>
            <!-- box-header 1 -->
            <div class="box-header">
                <div class="content-header">
                    <button type="button" class="btn btn-primary pull-right" id="btn_enable_cust_edit"><i class="fa fa-pencil"></i></button>  
                </div>
            </div>
            <!-- /.box-header 1 -->
            <!-- box-body -->
            <div class="box-body">
               <!-- Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                        <li><a href="#transaction" data-toggle="tab">Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <!-- USER-INFO -->
                            <form class="form-horizontal" id="cust-edit-profile-form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="cust_id" value="{{ $purchases[0]->cust_id }}"> 
                                <!-- Username -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="business">Business Name <span class="asterisk">*</span></label>
                                    <div class="col-sm-10">
                                        <input id="user_name" type="text" class="form-control" value="{{ $purchases[0]->business_name }}" name="business_name" placeholder="Business Name" readonly> 
                                    </div>
                                </div>
                                <!-- First Name -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputName">First Name <span class="asterisk">*</span></label>
                                    <div class="col-sm-10">
                                    <input id="cust_firstname" type="text" class="form-control" value="{{ $purchases[0]->cust_name }}" name="cust_firstname"
                                            placeholder="First Name" readonly> 
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="inputLastname" class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input id="cust_lastname" type="text" class="form-control" value="{{ $purchases[0]->cust_lastname }}" name="cust_lastname"  placeholder="Last Name" readonly>
                                    </div>
                                </div>
                                <!-- Customer Phone -->
                                <div class="form-group">
                                    <label for="cust_phone" class="col-sm-2 control-label">Phone <span class="asterisk">*</span></label>
                                    <div class="col-sm-10">
                                        <input id="user_phone" type="text" class="form-control" value="{{ $purchases[0]->cust_phone }}" name="cust_phone" placeholder="Phone" readonly> 
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input id="cust_phone" type="email" class="form-control" value="{{ $purchases[0]->cust_email }}" name="user_email" placeholder="Email" readonly>
                                    </div>
                                </div>
                                <!-- Province/State -->
                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">State/Province <span class="asterisk">*</span></label>
                                    <div class="col-sm-10">
                                        <input id="state" type="text" class="form-control" value="{{ $purchases[0]->cust_state }}" name="cust_state" placeholder="State/Province" readonly> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Address <span class="asterisk">*</span></label>
                                    <div class="col-sm-10">
                                        <input id="cust_address" type="text" class="form-control" value="{{ $purchases[0]->cust_addr }}" name="cust_address"  placeholder="Address" readonly> 
                                    </div>
                                </div>
                            <br>
                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-10">
                                        <a href="{{ route('customer') }}" type="button" id="cancel_cust_edit" class="btn btn-default" disabled>Cancel</a>
                                        <button type="submit" class="btn btn-primary" id="btn_edit_user_info" disabled>Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="transaction">
                           <div class="box">
                               <div class="box-header">
                                   <div class="content-header cust-transaction">
                                       <h3 class="box-title">Summary</h3>
                                   </div>
                               </div>
                                <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <th>Total Transaction Amount</th>
                                        @if(!empty($purchases) || count($purchases)>0)
                                            <th>${{  $totalTransaction }}</th>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td>Total Paid Amount</td>
                                        @if(!empty($purchases) || count($purchases)>0)
                                            <td>
                                               ${{ $recieved }}
                                            </td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td>Total Balance Amount</td>
                                        @if(!empty($purchases) || count($purchases)>0)
                                            <td>
                                               ${{ $recievable }}
                                            </td>
                                        @endif
                                        </tr>
                                    </table>
                                </div>
                           </div>
                               <div class="box">
                                   <div class="box-header">
                                       <div class="content-header  cust-transaction">
                                         <h3 class="box-title">Transactions</h3>
                                       </div>
                                   </div>
                                  <div class="box">
                                    <div class="box-body">
                                        <table id="data_tbl_purchase_history" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Invoice #</th>
                                                    <th>Payment Type</th>
                                                    <th>Paid</th>
                                                    <th>Balance</th>
                                                    <th>Transaction Date</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($purchases) || count($purchases)>0)
                                                @foreach($purchases as $pur)
                                                <tr>
                                                    <td>
                                                        <a href="#" class="invoice_detail" data-inv-id="{{ $pur->inv_id }}">
                                                            {{ $pur->inv_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $pur->payment_type }}</td>
                                                    <td>{{ $pur->recieved_amount }}</td>
                                                    <td>{{ $pur->recievable_amount }}</td>
                                                    <td>{{ Carbon\carbon::parse($pur->created_at)->format('d/m/Y') }}</td>
                                        
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                               </div>
                                <a href="{{ route('customer') }}" type="button" class="btn btn-primary">&lt Back</a>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
               <!-- /. Tabs -->
            </div>
            <!-- /box-body -->
        </div>
        <!-- /. Box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@stop