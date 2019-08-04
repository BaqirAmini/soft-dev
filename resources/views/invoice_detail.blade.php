@extends('layouts.master')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- box-header -->
                <div class="box-header">
                    <div class="content-header" style="text-align: center">
                        <h3 class="box-title">Invoice Details</h3>
                    </div>
                </div>
                <!-- box-body -->
                <div class="box-body">
                    <table id="data_tbl_invoice_detail" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Qty Sold</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
                                <th>Subtotal</th>
                                <th>Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($sales as $s)
                            <tr>
                                <td>{{ $s->ctg_name }}</td>
                                <td>{{ $s->item_name }}</td>
                                <td>{{ $s->qty_sold }}</td>
                                <td>${{ $s->sell_price }}</td>
                                <td></td>
                                <td>${{ $s->subtotal }}</td>
                                <td>{{ Carbon\carbon::parse($s->created_at)->format('m/d/Y') }}</td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop