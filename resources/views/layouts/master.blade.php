<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta id="token" name="token" content="{{csrf_token() }}">
  <title>CashCo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="asset" id="asset" content="{{ asset('/') }}">
  <!-- My-own styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <!-- Icon in title-bar -->
  <link rel="icon" type="/uploads/ic_cashco_for_title.png" href="/uploads/ic_cashco_for_title.png">
  <!-- bootstrap -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- datatables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css') }}"> -->


  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">

  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/skins/skin-blue.min.css') }}">
  <!-- date-picker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

  <!-- MORRIS CHART -->
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">

    {{--    bootstrap X-editable css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-editable.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<!-- Body -->
<body @if(!Request::is('login')) class="hold-transition skin-blue sidebar-mini sidebar-collapse" @endif>
<div class="wrapper">

  {!! Charts::assets() !!}

  @if(!Request::is('login') && !Request::is('logout'))
      @include('inc.header')
  @endif
  <!-- Left side column. contains the logo and sidebar -->
     @if(Auth::check()) @include('inc.sidebar') @endif
  <!-- Content Wrapper. Contains page content -->
  <div @if(!Request::is('login')) class="content-wrapper" @endif>
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section  class="content content-fluid" >
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
 @if(!Request::is('login')) @include('inc.footer') @endif


<!-- REQUIRED JS SCRIPTS -->


<!-- PRINT.JS -->
<script src="{{ asset('js/print.js') }}"></script>
<!-- PRINT.JS -->



<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery/dist/jquery.slim.js') }}"></script>
<!-- Own-js files -->
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/inventory.js') }}"></script>
<script src="{{ asset('js/user_role.js') }}"></script>
<script src="{{ asset('js/customer.js') }}"></script>
<script src="{{ asset('js/create_sale.js') }}"></script>
<script src="{{ asset('js/user_profile.js') }}"></script>
<script src="{{ asset('js/category.js') }}"></script>
<script src="{{ asset('js/company.js') }}"></script>
<script src="{{ asset('js/reports.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>



<!-- AdminLTE App -->
<script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

<!-- MORRIS CHART -->
<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>
<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/dist/js/demo.js') }}"></script>
<!-- ChartJS http://www.chartjs.org/-->
<script src="{{ asset('/bower_components/chart.js/Chart.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script> -->

<!-- datatables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- <script src="{{ asset('bower_components/datatables.net-bs/js/responsive.bootstrap.min.js') }}"></script> -->
<!-- jQuery Number
<script src="{{ asset('js/jquery.number.min.js') }}"></script> -->
 <!-- date-picker -->
{{-- <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">--}}

      {{--  js file of x-editable    --}}
  <script src="{{ asset('js/bootstrap-editable.min.js') }}"></script>

</div>
</body>

</html>
