
@extends('layouts.master')
@section('content')
  {{--================ Breadcrumbs ==================--}}
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {{ Breadcrumbs::render('new-sale') }}
  </div>
<!-- new-customer modal -->
<div class="modal fade" id="modal-customer">
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
            <form  class="form-horizontal">
                @csrf
                  <div class="form-group">
                    <label for="business_name" class="col-sm-2 control-label">Business Name <span class="asterisk">*</span></label>
                    <div class="col-sm-9">
                      <input id="business_name" type="text" class="form-control" name="business_name" placeholder="Business Name">
                    </div>
                  </div>
                    <div class="form-group">
                      <label for="cust_name" class="col-sm-2 control-label">First Name <span class="asterisk">*</span></label>
                      <div class="col-sm-9">
                        <input id="cust_name" type="text" class="form-control" name="cust_name" placeholder="Customer Name">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="cust_lastname" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-9">
                          <input id="cust_lastname" type="text" class="form-control" name="cust_lastname" placeholder="Customer Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cust_phone" class="col-sm-2 control-label">Phone <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="cust_phone" type="text" class="form-control" name="cust_phone" placeholder="Customer Phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cust_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-9">
                          <input id="cust_email" type="text" class="form-control" name="cust_email" placeholder="Customer Email)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cust_state" class="col-sm-2 control-label">Province / State <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="cust_state" type="text" class="form-control" name="cust_state" placeholder="Province/State">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="cust_addr" class="col-sm-2 control-label">Address <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                          <input id="cust_addr" type="text" class="form-control" name="cust_addr" placeholder="Address">
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                      <button type="button" id="btn_add_customer" class="btn btn-primary pull-left">Register</button>
                    </div>
            </form>
            </div>
      </div>
      <!-- end of modal-body div -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.new-customer modal -->

 <!-- Main content -->
 <section class="content" id="sale_section">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary" id="box_cart">
              <div class="box-header with-border">
                <h3 class="box-title">Customer & Payment</h3>
              </div>
              <!-- /.box-header -->
                <div class="box-body">
                  <p id="inv_message" style="display:none;"></p>
                  <!-- customer-selection -->
                    <div class="input-group col-md-12" id="choose-customer">
                        <select class="form-control" id="select_customer" required style="border: 2px solid rgb(211, 75, 75);">
                          <option value="">Select customer..</option>
                          @foreach($customers as $c)
                              <option value="{{ $c->cust_id }}">{{ $c->cust_name }} {{ $c->cust_lastname }}</option>
                          @endforeach
                        </select>
                        <span class="input-group-btn" style="padding-left: 20px;">
                          <button class="btn btn-primary" id="btn_new_customer" type="button" data-toggle="modal" data-target="#modal-customer"><i class="fa fa-user-plus" style="padding:3px;"></i></button>
                        </span>
                    </div><br>
                <!-- /. customer-selection -->

                <!-- sale-list -->
                      <div  id="test">
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
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                        <hr>
                      @foreach($carts as $cart)
                        <div class="sale-list col-md-12 col-sm-12 col-xs-12" style="display:block;text-align: center">
                          <input type="hidden" class="item_id" value="{{ $cart->id }}">
                          <div class="col-xs-1 col-md-1">
                              <a href="" class="btn_remove_sale" data-item-id="{{ $cart->rowId }}" style="padding:5px 8px;"><i class="fa fa-remove"  style="color:rgb(165, 22, 22)"></i></a>
                          </div>

                         <div class="col-xs-12 col-md-3">
                            <a href="#"> <span>{{ $cart->name }}</span></a>
                         </div>
                          <div class="col-xs-12 col-md-3">
                            <a href="#" class="link_qty" id="test_n"> <span>{{ $cart->qty }}</span></a>
                          </div>
                          <div class="col-xs-12 col-md-3">
                            <a href="#" class="link_price"><span>${{ $cart->price }}</span></a>
                          </div>
                        <div class="input-group">
                         <a href="#">${{ $cart->qty * $cart->price }}</a>
                        </div>

                       </div>
                    @endforeach
                      </div>

                     <!-- Total & Tax input -->
                <div class="row col-md-12 col-sm-10" style="margin-bottom:50px;margin-top:20px;" id="total_area">
                      <div class="input-group col-sm-5 col-xs-11">
                        <strong>Sub Total: </strong>
                        <span id="sub_total" data-sub-total = "{{ $subTotal }}">${{$subTotal}}</span>
                      </div>
                </div>
                <!-- /. Total & Tax input -->
                <!-- Payment -->
                <div class="row col-sm-12"  id="payment_area">
                  <div class="col-xs-6 col-sm-6" id="select_payment" style="display: none;">
                    <label for="payment_type" class="lbl_payment">Payment Type</label>
                      <select name="payment_type" id="payment_type" class="form-control pull-left" onchange="selectPayment();" required style="margin-left:-12px;">
                          <option value="">Select Payment...</option>
                          <option value="Cash">Cash</option>
                          <option value="Master Card">Master Card</option>
                          <option value="Debit Card">Debit Card</option>
                      </select>
                  </div>
                  <div class="col-xs-4 col-sm-4 col-xs-offset-2">
                      <div class="checkbox pull-right" style="margin-top:20px;display: none" id="chk_area">
                        <label>
                          <input type="checkbox" id="paid_all"> Paid All
                        </label>
                      </div>
                  </div>
                  <!-- Amount Area -->
                      <div class="col-md-12 col-sm-12 col-xs-12" style="margin-left:-25px;margin-top:15px;">
                        <div class="col-md-4" id="trans_area" style="display: none;">
                          <label for="transCode" id="lbl_trans_code">Trans #</label>
                          <input type="number" class="form-control t-card" placeholder="Transaction Code" id="transCode">
                        </div>
                          <div class="col-md-4" id="rvable" style="display: none;">
                            <label for="payable" class="lbl_payment">Recievable</label>
                              <input type="text" min="0" max="9999"  class="form-control" placeholder="payable" id="payable" value="{{$subTotal}}">
                          </div>
                          <div class="col-md-4" id="rvd" style="display: none;">
                            <label for="recieved" class="lbl_payment">Recieved</label>
                              <input type="text" min="0" max="999" step="0.01" class="form-control"  placeholder="recieved" id="recieved" style="padding:0;text-align:center">
                          </div>
                      </div>
                </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button id="btn_print"
                      class="btn btn-default pull-right btn_save_sale"
                      data-toggle="modal"
                      data-target="#modal-print"
                      onclick="onSaveSale();"
                      disabled >Save Sale</button>
                </div>
            </div>
            <!-- /.box -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-8" style="padding: 0px;">
            <!-- Horizontal Form -->
            <div class="box box-primary" id="box-items-for-sale">
              <div class="box-header with-border">
                <div class="content-header">
                    <div class="box-title">
                        <h3 class="box-title">Items</h3>
                    </div>
                </div>
                  {{--=============== Search items ==================--}}
                  <form action="{{ route('sale.search') }}" enctype="multipart/form-data" method="post" class="pull-right col-sm-12 col-md-6 col-lg-6" id="search_item_form">
                      {{ csrf_field() }}
                      <div class="input-group  col-lg-offset-2">
                          <input type="text" name="search" placeholder="Search items to sell"
                                 class="form-control" required>
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class=" glyphicon glyphicon-search"></span>
                            </button>
                          </span>
                      </div>
                  </form>
                  {{--=============== /.Search items ==================--}}
              </div>
              <p id="stock_message" style="text-align:center;display:none"></p>
                <div class="box-body">
                     <ul style="width:100%;margin-left: -15px;">
                       @foreach($items as $item)
                       <li style="list-style: none">
                        <a href="#" data-item-id="{{ $item->item_id }}"
                                    data-item-name="{{ $item->item_name }}"
                                    data-item-price="{{ $item->sell_price }}"
                                    class="link_add_item">
                          <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                            <div class="info-box" style="background: rgb(243, 247, 248);color: black;"  style="min-width: 250px;">
                              <!-- <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span> -->
                              <span class="info-box-icon" style="background: rgb(243, 247, 248)">
                                <img src="{{ url('/uploads/product_images/'.$item->item_image) }}" alt="Item Image"
                                  height="60" width="60" style="margin-top:-10px">
                              </span>
                              <div class="info-box-content">
                                <span class="info-box-text" style="font-size:12px;">{{ $item->item_name }}</span>
                                <span class="info-box-text">${{ $item->sell_price }}</span>
                                <span class="info-box-number">{{ $item->quantity }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>
                        </a>
                        @if($item->quantity <= 0)
                          <a href="#" data-item-id="{{ $item->item_id }}"
                                    data-item-name="{{ $item->item_name }}"
                                    data-item-price="{{ $item->sell_price }}"
                                    class="link_add_item" readonly>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box" style="text-align: center;background: rgb(243, 247, 248);color: black;">
                              <!-- <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span> -->
                              <span class="info-box-icon" style="background: rgb(243, 247, 248)">
                                <img src="uploads/product_images/{{ $item->item_image }}" alt="Item Image"
                                  height="90" width="90" style="margin-top:-10px">
                              </span>

                              <div class="info-box-content">
                                <span class="info-box-text">{{ $item->item_name }}</span>
                                <span class="info-box-text">${{ $item->sell_price }}</span>
                                <span class="info-box-number">{{ $item->quantity }}</span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>
                        </a>
                        @else

                        @endif
                       </li>
                       @endforeach
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
            <i class="fa fa-globe" id="company_name" ></i>
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
        <div class="col-md-offset-1 col-lg-offset-1 col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align: center;">
          <table class="table table-responsive table-striped" id="print_table">
            <thead>
            <tr style="border-bottom: 1px darkgray dashed">
              <th style="text-align: center;border-bottom: 1px darkgray dashed">Qty</th>
              <th style="text-align: center;border-bottom: 1px darkgray dashed">Product</th>
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
              <h4  style="margin-top: 400px;margin-left:150px;margin-right: -180px;" class="col-md-offset-4 col-lg-offset-4 col-sm-offset-4">Thank you for your purchase</h4>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
      </section>
  <!-- /.Invoice -->

<!-- MODAL -->
<div class="modal fade" id="modal-print">
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
        <button type="button" class="btn btn-primary btn_print_sale pull-left"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
        <button type="submit" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-ok"></span></button>
        <button type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></button>
      </form>
    </div>
  </div>
<!-- ========================= /. Content of POPOVER ======================= -->
@stop
