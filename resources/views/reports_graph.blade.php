
@extends('layouts.master')
@section('content')
<head>
  <!-- MORRIS CHART -->
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
  <script src="{{ asset('js/Chart.min.js') }}"></script>
</head>
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
<section class="content">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: -55px; margin-left: -15px">
            {{ Breadcrumbs::render('chart') }}
        </div>
  <div class="row">
     <div class="col-md-12">
        <div class="box box-primary">
         <!-- Box-header -->
          <div class="box-header">
            <div class="content-header">
              <h3 class="box-title">Sales Chart</h3>
            </div>
          </div>
         <!-- /. Box-header -->
          <hr>
     <!-- ================= Box-body =================== -->
          <div class="box-body">
            <!-- Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#this_month" data-toggle="tab">By Categories</a></li>
                <li><a href="#__category" data-toggle="tab">By Time</a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="this_month">
                    <div>
                      {!! $chart1->render() !!}
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="__category">
                    <div>
                      {!! $chart2->render() !!}
                    </div>
                  <!-- <a href="{{ route('customer') }}" type="button" class="btn btn-primary">&lt Back</a> -->
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /. Tabs -->
          </div>
     <!-- ================= /. Box-body =================== -->
        </div>
     </div>
  </div>
  </div>
  </section>
  <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
  <!-- ================= Bar chart ================== -->
  
  <!-- =================/. Bar chart ================== -->

  <!-- =====================  LINEAR chart ================== -->
 
  <!-- =====================/.  LINEAR chart ================== -->
@stop
