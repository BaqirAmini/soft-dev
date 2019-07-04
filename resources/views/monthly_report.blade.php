@extends('layouts.master')
@section('content')
<section class="content">
        <div class="row">
                    <section class="content-header">
                        <button class="btn btn-primary">Print</button>
                    </section>
                        <br>
                        <h3>Last Month's Total Sales: ${{ $lastMonthTotal }}</h3> <br>
            <!-- Datatables -->
            <table id="data_tbl7" class="table table-responsive col-md-12 col-xs-6 table-striped table-bordered">
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
                        @foreach($lastMonthDetails as $month)
                            <tr>
                                <td><img src="{{ asset('image/item_image/item.png') }}" alt="" width="30" height="30"></td>
                                <td>{{ $month->item_name }}</td>
                                <td>{{ $month->cust_name }}</td>
                                <td>{{ $month->inv_id }}</td>
                                <td>{{ $month->qty_sold }}</td>
                                <td>{{ $month->payment_type }}</td>
                                <td>{{ Carbon\carbon::parse($month->created_at)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </section>
@stop