
@extends('layouts.master')
@section('content')
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
          <div class="col-md-6">
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
                                <th>Delete</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Tax</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                        <hr>
                      @foreach($carts as $cart)
                        <div class="row sale-list col-md-12 col-xs-12" style="display:block">
                          <input type="hidden" class="item_id" value="{{ $cart->id }}">
                          <div class="col-xs-1 col-md-1">
                              <button class="btn btn-danger btn_remove_sale" data-item-id="{{ $cart->rowId }}" style="padding:5px 8px;"><i class="fa fa-remove"></i></button>
                          </div>
                          <div class="col-xs-12 col-md-3">
                            <input type="text" class="form-control item_name"  placeholder="Item" value="{{ $cart->name }}" readonly>
                          </div>
                          <div class="col-xs-12 col-md-2">
                            <input type="number" class="form-control item_qty" min="0" value="{{ $cart->qty }}" placeholder="Qty" readonly>
                          </div>
                          <div class="col-xs-12 col-md-2">
                            <input type="number"  class="form-control price" value="{{ $cart->price }}"  min="0" placeholder="Price" value="">
                          </div>
                          <div class="col-xs-12 col-md-2">   
                          <div class="input-group">
                            <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">$</span>
                            <input type="number" class="form-control subtotal" style="padding-right: 0px;padding-left: 0px;" min="0" step="0.01" placeholder="Sub Total" value="{{ $cart->qty * $cart->price }}" readonly>
                          </div>
                        </div>
                        <div class="col-xs-12 col-md-2"> 
                          <div class="input-group">
                            <span class="input-group-addon" style="padding-right: 5px;padding-left: 5px;">$</span>
                            <input type="number" class="form-control tax_value" style="padding-right: 0px;padding-left: 0px;" min="0" step="0.01" placeholder="Tax" name="tax_value" >
                          </div>
                       </div>
                       </div>
                    @endforeach
                      </div>
              
                     <!-- Total & Tax input -->
                <div class="row col-md-12 col-sm-10" style="margin-bottom:50px;margin-top:20px;" id="total_area">
                      <div class="input-group col-sm-5 col-xs-11">
                        <span class="input-group-addon"><strong>Sub Total</strong></span>
                        <input type="text" class="form-control col-md-5 col-xs-5 col-sm-5" max="999999.9999" id="total" value="{{$subTotal}}" placeholder="Total">
                      </div>
                </div>
                <!-- /. Total & Tax input -->
                <!-- Payment -->
                <div class="row col-md-12"  id="payment_area">
                  <div class="col-xs-4" id="select_payment" style="display: none;">
                    <label for="payment_type" class="lbl_payment">Payment Type</label>
                      <select name="payment_type" id="payment_type" class="form-control pull-left" onchange="selectPayment();" required style="margin-left:-12px;">
                          <option value="">Select Payment...</option>
                          <option value="Cash">Cash</option>
                          <option value="Master Card">Master Card</option>
                          <option value="Debit Card">Debit Card</option>
                      </select>
                  </div>
                  <div class="col-xs-4 col-xs-offset-3">
                      <div class="checkbox pull-right" style="margin-top:20px;display: none" id="chk_area">
                        <label>
                          <input type="checkbox" id="paid_all"> Paid All
                        </label>
                      </div>
                  </div>
                  <!-- Amount Area -->
                      <div class="col-md-12 col-xs-12" style="margin-left:-25px;margin-top:15px;">
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
          <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Items</h3>
              </div>
              <p id="stock_message" style="text-align:center;display:none">Message</p>
                <div class="box-body">
                        <table id="data_tbl3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th>Photo</th>
                                    <th>Item</th>
                                    <th>In Stock</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><a href="#"><img src="uploads/product_images/{{ $item->item_image }}" alt="Item Image" height="30" width="30" class="img-circle img-bordered-xs"></a></td>
                                    <td>{{ $item->item_name }}</td>
                                    <td> @if($item->quantity > 5) <button class="btn-sm  btn btn-info">{{ $item->quantity }}</button> @elseif($item->quantity <= 5) <button class="btn-sm btn btn-danger">{{ $item->quantity }}</button> @endif</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn_add_sale" 
                                            data-item-id="{{ $item->item_id }}"
                                            data-item-name="{{ $item->item_name }}"
                                            data-item-price="{{ $item->sell_price }}" 
                                            data-item-taxable="{{ $item->taxable }}" 
                                            >
                                               Add
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
          <!--/.col (right) -->
        </div>
        <!-- /.row -->

    <!-- Invoice -->
    <section class="invoice" style="display:none" id="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe" id="company_name" ></i>, Inc.
            <small class="pull-right" id="sold_date"></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <h1></h1>
        <div class="col-sm-4 invoice-col">
          From
          <address id="company_address">
            <strong>Admin, Inc.</strong><br>
          </address>
        </div><hr>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address id="customer_address">
            <!-- <strong>{{ $invoiceDetails[0]->cust_name }} {{ $invoiceDetails[0]->cust_lastname }}</strong><br> -->
            <strong><span id="spn_cust_name"></span></strong><br>
            <span id="customer_detail"></span>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice # <span id="inv_no"></span></b><br>
          <br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped" id="print_table">
            <thead>
            <tr>
              <th style="margin-right:30px;">Qty</th>
              <th style="margin-right:30px;">Product</th>
              <th style="margin-right:30px;">Sub Total</th>
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
        <div class="col-xs-6">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Total:</th>
                <td id="inv_total"></td>
              </tr>
              <tr>
                <th>Tax:</th>
                <td id="inv_total"></td>
              </tr>
            </table>
          </div>
          <h4 >Thank you for your purchase</h4>
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
  <div class="modal-dialog">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn_print_sale"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /. MODAL -->
@stop
