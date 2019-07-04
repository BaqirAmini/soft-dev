
@extends('layouts.master')
@section('content')
<head>
  <!-- MORRIS CHART -->
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
</head>
  <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
<section class="content">
  <div class="row">
      <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Anuall Sales Chart</h3>
  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <canvas id="annual" width="800" height="450"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly</h3>
  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <canvas id="monthly" width="800" height="450"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
        </div>
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Weekly</h3>
  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <canvas id="weekly" width="800" height="450"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Daily Sales Chart</h3>
  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <canvas id="daily" width="800" height="450"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
        </div>
        <!-- /.col (RIGHT) -->
      </div>
  </div>
  </section>
  <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
      // Chart of weekly report
      Morris.Donut({
       element: 'weekly',
       data: [
         {label: "Sales A", value: 12},
         {label: "Sales B", value: 30},
         {label: "Sales C", value: 20}
       ]
     });
// Variables for BAR-CHART of chart.js
var LABELS = new Array();
var QTY = new Array();
var YEAR = new Array();
$.ajax({
  type: "GET",
  url: "{{ route('chart') }}",
  success: function (response) {
    console.log(response);
    $.each(response, function (i, elem) { 
      var d = new Date(Date.parse(elem.created_at));
      var date = d.getFullYear();
       LABELS.push(elem.item_name);
       QTY.push(elem.qty_sold);
       YEAR.push(date);
    });
  }, 
  error: function (error) { 
    console.log(error);
   }
});
 // Bar chart
new Chart(document.getElementById("annual"), {
    type: 'bar',
    data: {
      labels: YEAR,
      datasets: [
        {
          label: LABELS,
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Annual Produts Sales'
      }
    }
});
  
// Daily-Sales with pie-chart
new Chart(document.getElementById("daily"), {
    type: 'pie',
    data: {
      labels: YEAR,
      datasets: [
        {
          label: LABELS,
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});

// Weekly-Sales with pie-chart
new Chart(document.getElementById("weekly"), {
  type: 'line',
  data: {
    labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
    datasets: [{ 
        data: [86,114,106,106,107,111,133,221,783,2478],
        label: "Africa",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: [282,350,411,502,635,809,947,1402,3700,5267],
        label: "Asia",
        borderColor: "#8e5ea2",
        fill: false
      }, { 
        data: [168,170,178,190,203,276,408,547,675,734],
        label: "Europe",
        borderColor: "#3cba9f",
        fill: false
      }, { 
        data: [40,20,10,16,24,38,74,167,508,784],
        label: "Latin America",
        borderColor: "#e8c3b9",
        fill: false
      }, { 
        data: [6,3,2,2,7,26,82,172,312,433],
        label: "North America",
        borderColor: "#c45850",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'World population per region (in millions)'
    }
  }
});

    
    });
  </script>
@stop
