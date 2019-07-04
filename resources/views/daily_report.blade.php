@extends('layouts.master')
@section('content')
<section class="content">
    <div class="row">
                <section class="content-header">
                    <button class="btn btn-primary">Print</button>
                </section>
                    <br>
                    <h3>Today's Total Sales: ${{ $todaySales }}</h3> <br>
                    <p id="delete_sale_msg"></p>
        <!-- Datatables -->
        <table id="data_tbl6" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Customer</th>
                        <th>Invoice #</th>
                        <th>Qty Sold</th>
                        <th>Payment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todays as $today)
                        <tr>
                            <td><img src="{{ asset('image/item_image/item.png') }}" alt="" width="30" height="30"></td>
                           <td>{{ $today->item_name }}</td>
                           <td>{{ $today->cust_name }}</td>
                           <td>{{ $today->inv_id }}</td>
                           <td>{{ $today->qty_sold }}</td>
                           <td>{{ $today->payment_type }}</td>
                           <td>{{ Carbon\carbon::parse($today->created_at)->format('d F Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</section>
  
@stop