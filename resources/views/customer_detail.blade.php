@extends('layouts.master')
@section('content')
    {{-- STYLES --}}
    <head>
        <style>
            #tlb_cust_detail th {
                text-align: center;
            }

            #tlb_cust_detail td {
                text-align: center;
            }

            {{-- To set alignment into center --}}
            #invoice_body td, #invoice_header th {
                text-align: center;
            }
        </style>


    </head>
    {{-- /.STYLES --}}


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('customer_detail') }}
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Box -->
                <div class="box" id="user_profile_box">
                    <ul id="profile_msg" style="display: none;">
                        Profile Message
                    </ul>
                    <!-- box-header 1 -->
                    <div class="box-header">
                        <strong class="col-md-offset-5 no-due-message"></strong>
                        <div class="content-header">
                            <h3 class="box-title">Customer Detail</h3>
                            <button type="button" class="btn btn-primary pull-right" id="btn_enable_cust_edit"><i
                                    class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header 1 -->
                    <!-- box-body -->
                    <div class="box-body">
                        <!-- Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#profile" data-toggle="tab" id="tab_comp_profile">Company
                                        Profile</a></li>
                                <li><a href="#transaction" data-toggle="tab" id="tab_transaction">Transactions</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">
                                    <!-- USER-INFO -->
                                    <form class="form-horizontal" id="cust-edit-profile-form"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="cust_id" value="{{ $customers[0]->cust_id }}">
                                        <!-- Seller Permit Number -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="seller_permit_number">Seller
                                                Permit Number <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="seller_permit_number" type="number" class="form-control"
                                                       value="{{ $customers[0]->SellerPermitNumber }}"
                                                       name="seller_permit_number"
                                                       placeholder="Seller Permit Number" readonly min="0">
                                            </div>
                                        </div>
                                        <!-- Username -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="business">Business Name <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="user_name" type="text" class="form-control"
                                                       value="{{ $customers[0]->business_name }}" name="business_name"
                                                       placeholder="Business Name" readonly>
                                            </div>
                                        </div>
                                        <!-- Customer Phone -->
                                        <div class="form-group">
                                            <label for="cust_phone" class="col-sm-2 control-label">Phone <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="user_phone" type="text" class="form-control"
                                                       value="{{ $customers[0]->cust_phone }}" name="cust_phone"
                                                       placeholder="Phone" readonly>
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input id="cust_phone" type="email" class="form-control"
                                                       value="{{ $customers[0]->cust_email }}" name="user_email"
                                                       placeholder="Email" readonly>
                                            </div>
                                        </div>
                                        <!-- Province/State -->
                                        <div class="form-group">
                                            <label for="state" class="col-sm-2 control-label">State/Province <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="state" type="text" class="form-control"
                                                       value="{{ $customers[0]->cust_state }}" name="cust_state"
                                                       placeholder="State/Province" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="credit_limit" class="col-sm-2 control-label">Credit
                                                Limit</label>
                                            <div class="col-sm-10">
                                                <input id="credit_limit" type="text" class="form-control"
                                                       value="{{ $customers[0]->CreditLimit }}" name="credit_limit"
                                                       placeholder="Credit Limit" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country" class="col-sm-2 control-label">Country <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="credit_limit" type="text" class="form-control"
                                                       value="{{ $customers[0]->Country }}" name="country"
                                                       placeholder="Country" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address1" class="col-sm-2 control-label">Address 1 <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="address1" type="text" class="form-control"
                                                       value="{{ $customers[0]->cust_addr }}" name="address1"
                                                       placeholder="Address 1" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address2" class="col-sm-2 control-label">Address 2 </label>
                                            <div class="col-sm-10">
                                                <input id="cust_address2" type="text" class="form-control"
                                                       value="{{ $customers[0]->Address2 }}" name="address2"
                                                       placeholder="Address2 (Optional)" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city" class="col-sm-2 control-label">City <span
                                                    class="asterisk">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="city" type="text" class="form-control"
                                                       value="{{ $customers[0]->City }}" name="city"
                                                       placeholder="City" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip_code" class="col-sm-2 control-label">Zip Code</label>
                                            <div class="col-sm-10">
                                                <input id="zip_code" type="text" class="form-control"
                                                       value="{{ $customers[0]->zip_code }}" name="zip_code"
                                                       placeholder="Zip Code" readonly>
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
                                                           @if($customers[0]->LimitPurchase === 1) checked @endif>&nbsp;
                                                    Yes
                                                </label>
                                                <label class="credit_limit">
                                                    <input type="radio" name="limit_purchase" value="0" class="status"
                                                           class="form-control"
                                                           @if($customers[0]->LimitPurchase === 0) checked
                                                           @endif checked>&nbsp; No
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-sm-offset-1 col-sm-10">
                                                <a href="{{ route('customer') }}" type="button" id="cancel_cust_edit"
                                                   class="btn btn-default" disabled>Cancel</a>
                                                <button type="submit" class="btn btn-primary" id="btn_edit_user_info"
                                                        disabled>Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="{{ route('customer') }}" type="button" class="btn btn-primary">&lt Back</a>
                                </div>
                                <!-- /.tab-pane -->
                                {{--                        @if(!empty($purchases) || count($purchases)>0)--}}
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
                                                    <td>Account Opened At</td>
                                                    @if(!empty($customers) || count($customers)>0)
                                                        <td>
                                                            {{  Carbon\carbon::parse($customers[0]->created_at)->format('m/d/Y') }}
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Account Number</td>
                                                    @if(!empty($customers) || count($customers)>0)
                                                        <td>
                                                            {{ $customers[0]->cust_id }}
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Account Type ID</td>
                                                    @if(!empty($customers) || count($customers)>0)
                                                        <td>
                                                            {{ $customers[0]->AccountTypeID }}
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{--<tr>
                                                    <td>Account Balance</td>
                                                    @if(!empty($customers) || count($customers)>0)
                                                        <td>
                                                            {{ $customers[0]->AccountBalance }}
                                                        </td>
                                                    @endif
                                                </tr>--}}
                                                <tr>
                                                    <td>Fax Number</td>
                                                    @if(!empty($customers) || count($customers)>0)
                                                        <td style="border-bottom: 1px dashed grey !important">
                                                            {{ $customers[0]->FaxNumber }}
                                                        </td>
                                                    @endif
                                                </tr>

                                                {{-- ==========================   Balance related ===================--}}
                                                <tr>
                                                    <th>Total Sales</th>
                                                    @if(!empty($newSaleObject) || count($newSaleObject)>0)
                                                        <th>${{  $totalSales }}</th>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Total Amount Paid</td>

                                                        <td>
                                                            ${{ $totalAmountPaid }}
                                                        </td>

                                                </tr>
                                                <tr>
                                                    <td>Total Amount Due</td>
                                                    @if(!empty($totalAmountDue))
                                                        <td>
                                                            ${{ $totalAmountDue }}
                                                        </td>
                                                    @else
                                                        <td>$0</td>
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
                                    {{--================= Two tables i.e. Invoices & Payments =================================== --}}
                                    <!-- tabs --->
                                        <div class="nav-tabs-custom">
                                            <!-- tabs list -->
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab_invoice" data-toggle="tab">Invoices</a>
                                                </li>
                                                <li><a href="#tab_payment" data-toggle="tab" >Payments</a></li>
                                            </ul>
                                            <!--/. tabs list -->
                                            <!-- TAB CONTENT -->
                                            <div class="tab-content">
                                                <!-- Tab-invoice-->
                                                <div class="active tab-pane" id="tab_invoice">
                                                    <div class="box box-solid">
                                                        <div class="box-body">
                                                            <table id="data_tbl_purchase_history"
                                                                   class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                                                                <thead id="invoice_header">
                                                                <tr>
                                                                    <th>Invoice #</th>
                                                                    <th>Payment Method</th>
                                                                    <th>Trans. Method</th>
                                                                    <th>Amount Paid</th>
                                                                    <th>Amount Due</th>
                                                                    <th>Total Invoice</th>
                                                                    <th>Transaction Date</th>
                                                                    <th>Receive payment</th>
                                                                    <!-- <th>Action</th> -->
                                                                </tr>
                                                                </thead>
                                                                <tbody id="invoice_body">
                                                                @if(!empty($newSaleObject) || count($newSaleObject)>0)
                                                                    @foreach($newSaleObject as $ns)
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#" class="invoice_detail"
                                                                                   data-inv-id="{{ $ns->inv_id }}">
                                                                                    {{ $ns->inv_id }}
                                                                                </a>
                                                                            </td>
                                                                            <td>{{ $ns->payment_method }}</td>
                                                                            <td>{{ $ns->trans_method }}</td>
                                                                            <td>${{ $ns->amount_paid }}</td>
                                                                            <td>${{ $ns->amount_due }}</td>
                                                                            <td>${{ $ns->total_invoice }}</td>
                                                                            <td>{{ Carbon\carbon::parse($ns->created_at)->format('m/d/Y') }}</td>
                                                                            <td>
                                                                                @if($ns->amount_due > 0)
                                                                                    <a href="#"
                                                                                       data-toggle="modal"
                                                                                       data-target="#modal-make-payment"
                                                                                       type="button"
                                                                                       class="btn btn-default btn-sm link_make_payment"
                                                                                       data-invoice-id="{{ $ns->inv_id }}">
                                                                                        <span class="glyphicon glyphicon-credit-card text-primary"></span>
                                                                                    </a>
                                                                                @else
                                                                                    <a href="#"
                                                                                       data-toggle="modal"
                                                                                       data-target="#"
                                                                                       type="button"
                                                                                       class="btn btn-default btn-sm link_btn_no_due"
                                                                                       data-invoice-id="{{ $ns->inv_id }}"
                                                                                        disabled>
                                                                                        <span class="glyphicon glyphicon-credit-card text-default"></span>
                                                                                    </a>
                                                                                @endif
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.Tab-invoice-->
                                                <!-- Tab-payment -->
                                                <div class="tab-pane" id="tab_payment">
                                                    <div class="box box-solid">
                                                        <div class="box-body">
                                                            <table id="data_tbl_purchase_history"
                                                                   class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                                                                <thead id="invoice_header">
                                                                <tr>
                                                                    <th>Invoice #</th>
                                                                    <th>Payment Method</th>
                                                                    <th>Trans. Method</th>
                                                                    <th>Amount Paid</th>
                                                                    <th>Amount Due</th>
                                                                    <th>Date</th>
                                                                    <!-- <th>Action</th> -->
                                                                </tr>
                                                                </thead>
                                                                <tbody id="invoice_body">
                                                                @if(!empty($paymentReceived) || count($paymentReceived)>0)
                                                                    @foreach($paymentReceived as $pr)
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#" class="invoice_detail"
                                                                                   data-inv-id="{{ $pr->inv_id }}">
                                                                                    {{ $pr->inv_id }}
                                                                                </a>
                                                                            </td>
                                                                            <td>{{ $pr->payment_method }}</td>
                                                                            <td>{{ $pr->trans_method }}</td>
                                                                            <td>${{ $pr->amount_paid }}</td>
                                                                            <td>${{ $pr->amount_due }}</td>
                                                                            <td>{{ Carbon\carbon::parse($pr->created_at)->format('m/d/Y') }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/. Tab-payment -->
                                            </div>
                                            <!--/. TAB CONTENT -->
                                        </div>
                                        <!--/. --->

                                    </div>
                                    <a href="{{ route('customer') }}" type="button" class="btn btn-primary">&lt Back</a>
                                    {{--@if($totalTransaction ==! 0)
                                        <button class="btn btn-primary pull-right btn_make_payment" data-toggle="modal"
                                                data-target="#modal-make-payment">Make a payment
                                        </button>
                                    @endif--}}
                                </div>
                            {{--                            @endif--}}
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /. Tabs -->

                        {{-- =========================================== More Details for Customer ======================================================================--}}
                        {{--<div class="box">
                            <div class="box-header">
                                <div class="content-header" style="text-align: center;font-size: 8px">
                                    <label class="box-title">More Details</label>
                                </div>
                            </div>
                            <div class="box-body col-md-offset-1">
                                <table
                                    class="table table-responsive col-md-12 col-lg-12 col-sm-2 col-xs-2" id="tlb_cust_detail">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>HQID</th>
                                        <th>Store ID</th>
                                        <th>Price Level</th>
                                        <th>Total Sales</th>
                                        <th>Assess Finance Charges</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $customers[0]->HQID }}</td>
                                        <td>{{ $customers[0]->StoreID }}</td>
                                        <td>{{ $customers[0]->PriceLevel }}</td>
                                        <td>{{ $customers[0]->TotalSales }}</td>
                                        <td>{{ $customers[0]->AssessFinanceCharges }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>--}}
                        {{-- ===========================================/. More Details for Customer ======================================================================--}}
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

    <!-- =======================================  MODALS ================================================= -->
    <div class="modal fade" id="modal-make-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Make a payment</h4>
                </div>
                <div class="modal-body">
                    <ul id="msg_area" style="display:none">
                    </ul>
                    <div class="register-box-body">
                        <form class="form-horizontal" id="form-make-payment">
{{--                            <input type="hidden" name="customer_id" value="{{ $customers[0]->cust_id }}">--}}
                            <input type="hidden" name="invoice_id" class="hidden_invoice_id">
                            @csrf
                            {{------------------ Payment type -----------------------}}
                        <!-- text input -->
                            <div class="form-group">
                                <label>Pay Amount</label>
                                <input type="number" name="pay_amount" min="0" step="0.01" class="form-control" placeholder="Pay Amount" autofocus>
                            </div>
                            <div class="form-group" id="transaction_code" style="display: none">
                                <label>Transaction Code</label>
                                <input type="number" name="transaction_code" min="0" step="1" class="form-control" placeholder="Transaction Code">
                            </div>
                            <!-- select -->
                            <div class="form-group">
                                <label>Select Payment Method</label>
                                <select class="form-control" name="payment_method" id="payment_method2">
                                    <option value="">------------------------------------------ Payment Method ------------------------------------------</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                </select>
                            </div>

                            {{------------------ /. Payment type -----------------------}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel
                                </button>
                                <button type="submit" id="btn_make_payment" data-c-id="{{ $customers[0]->cust_id }}"
                                        class="btn btn-primary pull-left" disabled>Save
                                </button>
                            </div>
                        </form>

                    </div>
                <!-- end of modal-body div -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- =======================================/.  MODALS ================================================= -->
@stop
