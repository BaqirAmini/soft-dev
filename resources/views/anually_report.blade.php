@extends('layouts.master')
@section('content')
<section class="content">
        <div class="row">
                    <section class="content-header">
                        <button class="btn btn-primary">Print</button>
                    </section>
                        <br>
                        <h3>Last Year's Total Sales: ${{ $lastYearTotal }}</h3> <br>
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
                        @foreach($lastYearDetails as $year)
                            <tr>
                                <td><img src="{{ asset('image/item_image/item.png') }}" alt="" width="30" height="30"></td>
                                <td>{{ $year->item_name }}</td>
                                <td>{{ $year->cust_name }}</td>
                                <td>{{ $year->inv_id }}</td>
                                <td>{{ $year->qty_sold }}</td>
                                <td>{{ $year->payment_type }}</td>
                                <td>{{ Carbon\carbon::parse($year->created_at)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </section>
@stop