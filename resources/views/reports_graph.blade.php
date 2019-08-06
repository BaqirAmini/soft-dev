
@extends('layouts.master')
@section('content')
<head>
  <!-- MORRIS CHART -->
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
  <script src="{{ asset('js/Chart.min.js') }}"></script>
</head>
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
<section class="content">
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
                <li class="active"><a href="#this_month" data-toggle="tab">This Month</a></li>
                <li><a href="#__category" data-toggle="tab">Quantative Chart</a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="this_month">
                    <canvas id="myChart" width="200" height="50"></canvas>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="__category">
                    <canvas id="ctg_chart" width="200" height="50"></canvas>
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
  <script>
    
      var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
              label: '# of Sold Items',
              data: {!! json_encode($items) !!},
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
  </script>
  <!-- =================/. Bar chart ================== -->

  <!-- =====================  LINEAR chart ================== -->
  <script>
  var ctx = document.getElementById('ctg_chart');
  let chart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          label: 'First dataset',
          data: {!! $qty_sold !!},
          backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
        }],
        labels:{!! $items !!}
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              suggestedMin: 50,
              suggestedMax: 100
            }
          }]
        }
      }
    });</script>
  <!-- =====================/.  LINEAR chart ================== -->
@stop
