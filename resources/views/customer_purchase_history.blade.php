@extends('layouts.master')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Customers' Balance</h3>
        </div>
        <div class="box-body">
          <div class="box-header">
           <div class="box">
              <div class="box-body">
                <table id="data_tbl_purchase_history" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Invoice</th>
                      <th>Payment Type</th>
                      <th>Customer</th>
                      <th>Rcv. Amount</th>
                      <th>Recievable</th>
                      <th>Purchase Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($purchases as $pur)
                    <tr>
                      <td>{{ $pur->inv_id }}</td>
                      <td>{{ $pur->payment_type }}</td>
                      <td>{{ $pur->cust_name }} {{ $pur->cust_lastname }}</td>
                      <td>{{ $pur->recieved_amount }}</td>
                      <td>{{ $pur->recievable_amount }}</td>
                      <td>{{ Carbon\carbon::parse($pur->created_at)->format('d m Y') }}</td>
                      <td>
                        <button class="btn-sm btn btn-danger btn_delete_invoice" data-toggle="modal"
                          data-target="#modal-delete-invoice" data-inv-id="{{ $pur->inv_id }}">
                          Delete
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              
              </div>
           </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
        <!-- MODAL-AREA -->
            <!-- delete-invoice -->
    <div class="modal fade" id="modal-delete-invoice">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Invoice Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="cust_inv_id">
              <p>Are you sure you want delete this invoice?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary pull-left" onclick="deleteInvoice();">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    <!-- /.delete-invoice -->
        <!-- /. MODAL-AREA -->
@stop