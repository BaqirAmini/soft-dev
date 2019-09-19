@extends('layouts.master')
@section('content')
    {{--================ Breadcrumbs ==================--}}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('new-sale') }}
    </div>
    <!-- new-customer modal -->
    {{--<div class="modal fade" id="modal-customer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Customer</h4>
                    <ul id="msg_area" style="display:none">
                    </ul>
                </div>
                <div class="modal-body">
                    <p id="cust_message" style="display:none">Customer Message</p>
                    <div class="register-box-body">
                        <form class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="business_name" class="col-sm-2 control-label">Business Name <span
                                        class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    <input id="business_name" type="text" class="form-control" name="business_name"
                                           placeholder="Business Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cust_name" class="col-sm-2 control-label">First Name <span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    <input id="cust_name" type="text" class="form-control" name="cust_name"
                                           placeholder="Customer Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cust_lastname" class="col-sm-2 control-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input id="cust_lastname" type="text" class="form-control" name="cust_lastname"
                                           placeholder="Customer Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cust_phone" class="col-sm-2 control-label">Phone <span
                                        class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    <input id="cust_phone" type="text" class="form-control" name="cust_phone"
                                           placeholder="Customer Phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cust_email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input id="cust_email" type="text" class="form-control" name="cust_email"
                                           placeholder="Customer Email)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cust_state" class="col-sm-2 control-label">Province / State <span
                                        class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    <input id="cust_state" type="text" class="form-control" name="cust_state"
                                           placeholder="Province/State">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="cust_addr" class="col-sm-2 control-label">Address <span
                                        class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    <input id="cust_addr" type="text" class="form-control" name="cust_addr"
                                           placeholder="Address">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel
                                </button>
                                <button type="button" id="btn_add_customer" class="btn btn-primary pull-left">Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end of modal-body div -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>--}}
    <!-- /.new-customer modal -->

    <!-- Main content -->
    <section class="content" id="sale_section">
        <div class="row">
            {{-- ================================== Container of two-boxes ================== --}}
            <div class="col-md-4 container-fluid">
                {{-- ====================== for search ========================= --}}
                <div class="box box-primary" style="margin-bottom: 0">
                    <div class="box-header with-border">
                        <div class="content-header">
                            <h3 class="box-title">Find Customer</h3>
                        </div>
                    </div>
                    {{-- body--}}
                    <div class="box-body">
                        <div class="input-group col-md-12" id="choose-customer">
                            <input type="text" class="form-control" id="search_customer"
                                   placeholder="Type Customer's Name or Phone" required>
                            <div id="customer_search_result" style="z-index:-9999"></div>
                            {{--<select class="form-control" id="select_customer" required
                                    style="border: 2px solid rgb(211, 75, 75);">
                                <option value="">Select customer..</option>
                                @foreach($customers as $c)
                                    <option
                                        value="{{ $c->cust_id }}">{{ $c->cust_name }} {{ $c->cust_lastname }}</option>
                                @endforeach
                            </select>--}}
                            <span class="input-group-btn" style="padding-left: 20px;">
                          <a href="{{ route('customer.register') }}" class="btn btn-primary" id="btn_new_customer" type="button"><i class="fa fa-user-plus"
                                                                   style="padding:3px;"></i></a>
                        </span>
                            {{ csrf_field() }}
                        </div>
                    </div>
                    <div class="box-footer">
                        {{--================== customer should shown here=======================--}}
                        <div class="user-block customer_chosen_info" style="display: none">
                            <img class="img-circle img-bordered-sm" src="/uploads/user_photos/user.png"
                                 alt="user image">
                            <span class="username" id="customer_chosen">
                              <a href="#" id="link1"></a>
                              <a href="#" class="pull-right btn-box-tool" id="link_remove_customer_chosen"><i
                                      class="fa fa-times"></i></a>
                            </span>
                            <span class="description" id="customer_chosen_detail"></span>
                        </div>
                        <!-- /.user-block -->
                        {{--==================/. customer should shown here=======================--}}
                    </div>
                </div>

            {{-- ====================== /for search ========================= --}}
            <!-- left column -->
                <div>
                    <!-- general form elements -->
                    <div class="box box-solid" id="box_cart" style="margin-bottom: 0">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p id="inv_message" style="display:none;"></p>
                            <!-- /. customer-selection -->

                            <!-- sale-list -->
                            <div id="test">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <table class="col-md-12 table-responsive tbl-sales-label">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th>Discount (%)</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                @foreach($carts as $cart)
                                    <div class="sale-list col-md-10 col-sm-12 col-xs-12"
                                         style="display:block;">
                                        <input type="hidden" class="item_id" value="{{ $cart->id }}">
                                        <div class="col-xs-1 col-md-1">
                                            <a href="" class="btn_remove_sale"
                                               data-item-rid="{{ $cart->rowId }}"
                                               data-item-id="{{ $cart->id }}"
                                               data-item-qty="{{ $cart->qty }}"
                                               style="padding:5px 8px;">
                                                <i class="fa fa-remove"
                                                   style="color:rgb(165, 22, 22)"></i></a>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <a href="#" id="item_added_in_cart" style="font-size: 12px"> <span>{{ $cart->name }}</span></a>
                                        </div>
                                        <div class="col-xs-12 col-md-2" style="font-size: 12px">
                                            <a href="#" class="link_qty" id="test_n"> <span>{{ $cart->qty }}</span></a>
                                        </div>
                                        <div class="col-xs-12 col-md-2" style="font-size: 12px">
                                            <a href="#" class="link_price"><span>${{ $cart->price }}</span></a>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12" style="text-align: center">
                                            <div class="input-group">
                                                <a href="#" style="font-size: 12px">${{ $cart->qty * $cart->price }}</a>
                                            </div>
                                            <!-- discount --->
                                            <div class="pull-right" style="margin-top: -20px;margin-right: -55px;">
                                                <a href="#" class="link_discount" data-discount-id="{{ $cart->rowId }}" style="font-size: 12px">0</a>
                                                {{ csrf_field() }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total & Tax input -->
                            <div class="row col-md-12 col-sm-10" style="margin-bottom:50px;margin-top:20px;"
                                 id="total_area">
                                <div class="input-group col-sm-5 col-xs-11">
                                    <strong>Sub Total: </strong>
                                    <span id="sub_total" data-sub-total="{{ $subTotal }}">${{$subTotal}}</span>
                                </div>
                            </div>
                            <!-- /. Total & Tax input -->
                            {{--<!-- Payment -->
                            <div class="row col-sm-12" id="payment_area">
                                <div class="col-xs-6 col-sm-6" id="select_payment">
                                    <label for="payment_type" class="lbl_payment">Payment Type</label>
                                    <select name="payment_type" id="payment_type" class="form-control pull-left"
                                            onchange="selectPayment();" required style="margin-left:-12px;">
                                        <option value="">Select Payment...</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Master Card">Master Card</option>
                                        <option value="Debit Card">Debit Card</option>
                                    </select>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-xs-offset-2">
                                    <div class="checkbox pull-right" style="margin-top:20px;display: none"
                                         id="chk_area">
                                        <label>
                                            <input type="checkbox" id="paid_all"> Paid All
                                        </label>
                                    </div>
                                </div>
                                <!-- Amount Area -->
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-left:-25px;margin-top:15px;">
                                    <div class="col-md-4" id="trans_area" style="display: none;">
                                        <label for="transCode" id="lbl_trans_code">Trans #</label>
                                        <input type="number" class="form-control t-card" placeholder="Transaction"
                                               id="transCode" style="min-width: 120px;" required>
                                    </div>
                                    <div class="col-md-4" id="rvable" style="display: none;">
                                        <label for="payable" class="lbl_payment">Recievable</label>
                                        <input type="text" min="0" max="9999" class="form-control" placeholder="payable"
                                               id="payable" value="{{$subTotal}}" style="margin-left: 10px;min-width: 100px;">
                                    </div>
                                    <div class="col-md-4" id="rvd" style="display: none;">
                                        <label for="recieved" class="lbl_payment">Recieved</label>
                                        <input type="text" min="0" max="999"  class="form-control"
                                               placeholder="recieved" id="recieved" style="padding:0;text-align:center" required>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{--<button id="btn_print"
                                    class="btn btn-default pull-right btn_save_sale"
                                    data-toggle="modal"
                                    data-target="#modal-print"
                                    onclick="onSaveSale();"
                                    disabled>Save Sale
                            </button>--}}
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <div>
                    <!-- Box for btn Payment -->
                    <div class="box box-solid">
                        <div class="box-body">
                            <button class="col-md-12 col-lg-12 col-xs-12 col-sm-12 btn btn-default btn_payment" data-toggle="modal"
                                    data-target="#modal-payment-type" disabled>Pay
                            </button>
                        </div>
                    </div>
                    <!--/. Box for btn Payment -->
                </div>
            </div>
        {{-- ==================================/. Container of two-boxes ================== --}}
        <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-8" style="padding: 0px;">
                <div class="col-md-12" style="padding: 0px;">
                    <!-- Horizontal Form -->
                    <div class="box box-primary" id="box-items-for-sale">
                        <div class="box-header with-border">
                            <div class="content-header">
                                <div class="box-title">
                                    <h3 class="box-title">Items</h3>
                                </div>
                            </div>
                            {{--=============== Search items ==================--}}
                            <div class="input-group col-md-6 col-lg-6 col-sm-10 col-xs-10 pull-right"
                                 style="margin-right: 30px;">
                                <input type="text" name="search" placeholder="Search items or scan a barcode"
                                       class="form-control" required id="search_items">
                            </div>
                            {{--=============== /.Search items ==================--}}
                        </div>
                        <p id="stock_message" style="text-align:center;display:none"></p>
                        <div class="box-body">
                            <ul style="width:100%;margin-left: -15px;" id="list_items">
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->

            <!-- Invoice -->
            <section class="invoice" style="display:none;margin: 10px;" id="invoice">


                <!-- title row -->
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-xs-12">
                        <h3 class="page-header">
                            <i class="fa fa-globe" id="company_name"></i>
                            <b class="pull-right">Invoice # <span id="inv_no"></span></b><br>
                        </h3>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="invoice-info">
                    <div class="invoice-col" style="border-bottom: 1px darkgray dashed">

                        <table width="100%">
                            <tr>
                                <td>
                                    <strong>From</strong>
                                    <address id="company_address">
                                        <strong>Admin, Inc.</strong><br>
                                    </address>
                                </td>
                                <td>
                                    <strong>To</strong>
                                    <address id="customer_address">
                                    <!-- <strong>{{ $invoiceDetails[0]->cust_name }} {{ $invoiceDetails[0]->cust_lastname }}</strong><br> -->
                                        <span id="spn_cust_name"></span><br>
                                        <span id="customer_detail"></span>
                                    </address>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-md-offset-1 col-lg-offset-1 col-md-12 col-lg-12 col-sm-12 col-xs-12"
                         style="text-align: center;">
                        <table class="table table-responsive table-striped" id="print_table">
                            <thead>
                            <tr style="border-bottom: 1px darkgray dashed">
                                <th style="text-align: center;border-bottom: 1px darkgray dashed">Product</th>
                                <th style="text-align: center;border-bottom: 1px darkgray dashed">Qty</th>
                                <th style="text-align: center;border-bottom: 1px darkgray dashed">Price</th>
                                <th style="text-align: center;border-bottom: 1px darkgray dashed">Sub Total</th>
                            </tr>
                            </thead>
                            <tbody id="invoice_body">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                        <div>
                            <table class="pull-right" style="margin-right: -280px !important;">
                                <tr>
                                    <br>
                                    <th>Tax:</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td id="inv_total"></td>
                                </tr>
                            </table>
                        </div>
                        <div style="text-align: center">
                            <h4 style="margin-top: 400px;margin-left:150px;margin-right: -180px;"
                                class="col-md-offset-4 col-lg-offset-4 col-sm-offset-4">Thank you for your purchase</h4>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
    </section>
    <!-- /.Invoice -->

    <!-- MODAL -->
{{--    modal print now is useless   --}}
  {{--  <div class="modal fade" id="modal-print">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Invoice Print</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cust_id_for_print">
                    <input type="hidden" name="invoice_id_for_print">
                    <p>Do you want to print an invoice?</p>
                </div>
                <div class="modal-footer col-md-offset-3" id="btn_modal_print">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn_print_sale pull-left"><i class="fa fa-print"></i>
                        Print
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
--}}
    {{--  ------------------ Modal for choosing payment-type ----------------------  --}}
    <div class="modal fade" id="modal-payment-type">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body" id="payment_area">
                    <!-- Payment -->
                    <div class="form-group" id="select_payment">
                        <label>Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-control"
                                onchange="selectPayment();" required>
                            <option value="">Select Payment...</option>
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-4" id="trans_area" style="display: none">
                            <label id="lbl_trans_code">Transaction Code</label>
                            <input type="number" min="0" step="1" class="form-control t-card" id="transCode" placeholder="Transaction Code">
                        </div>
                        <div class="form-group col-xs-4" style="display: none" id="rvable">
                            <label class="lbl_payment">Receivable Amount</label>
                            <input type="hidden" name="total_to_pay" id="total_to_pay">
                            <input type="number" class="form-control" min="0" step="0.01" max="9999" placeholder="Receivable Amount" id="payable">
                        </div>
                        <div class="form-group col-xs-4" id="rvd" style="display: none">
                            <label  class="lbl_payment">Recieved Amount</label>
                            <input type="number"  class="form-control" placeholder="Recieved Amount" min="0" step="0.001" max="999" id="recieved">
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pull-left" id="chk_area" style="display: none;margin-left: -15px !important;">
                        <strong>Paid All</strong>
                        <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="checkbox" id="paid_all">
                                </span>
                            <input type="text" class="form-control" id="chk_value" readonly>
                        </div>

                        <!-- /input-group -->
                    </div>
                    <br><br>
                 {{--   <div class="col-xs-6 col-sm-6" id="select_payment">
                        <label for="payment_type" class="lbl_payment">Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-control pull-left"
                                onchange="selectPayment();" required style="margin-left:-12px;">
                            <option value="">Select Payment...</option>
                            <option value="Cash">Cash</option>
                            <option value="Master Card">Master Card</option>
                            <option value="Debit Card">Debit Card</option>
                        </select>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-xs-offset-2">
                        <div class="checkbox pull-right" style="margin-top:20px;display: none"
                             >
                            <label>
                                <input type="checkbox" > Paid All
                            </label>
                        </div>
                    </div>--}}
                    <!-- Amount Area -->
                    {{--<div class="col-md-12 col-sm-12 col-xs-12" style="margin-left:-25px;margin-top:15px;">
                        <div class="col-md-4" id="trans_area" style="display: none;">
                            <label for="transCode" id="lbl_trans_code">Trans #</label>
                            <input type="number" class="form-control t-card" placeholder="Transaction"
                                   id="transCode" style="min-width: 120px;" required>
                        </div>
                        <div class="col-md-4" id="rvable" style="display: none;">
                            <label for="payable" class="lbl_payment">Recievable</label>
                            <input type="text" min="0" max="9999" class="form-control" placeholder="payable"
                                   id="payable" value="{{$subTotal}}" style="margin-left: 10px;min-width: 100px;">
                        </div>
                        <div class="col-md-4" id="rvd" style="display: none;">
                            <label for="recieved" class="lbl_payment">Recieved</label>
                            <input type="text" min="0" max="999" class="form-control"
                                   placeholder="recieved" id="recieved" style="padding:0;text-align:center" required>
                        </div>
                    </div>--}}

                    <!--/. Payment -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-default pull-left btn_save_sale"  onclick="onSaveSale();" disabled>Save Sale</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    {{--  ------------------/. Modal for choosing payment-type ----------------------  --}}
    <!-- ========================= Editable values for CREATE-SALE====================================-->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
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
    <!-- =========================/. Editable values for CREATE-SALE====================================-->
    <!-- /. MODAL -->

    <!-- ========================= Content of POPOVER ======================= -->
    <div class="hidden">
        <div class="form-group ">
            <form id="popover_form">
                <input type="text" name="value" id="value" class="form-control" placeholder="Some value here..."><br>
                <button type="submit" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-ok"></span>
                </button>
                <button type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span>
                </button>
            </form>
        </div>
    </div>
    <!-- ========================= /. Content of POPOVER ======================= -->
@stop
