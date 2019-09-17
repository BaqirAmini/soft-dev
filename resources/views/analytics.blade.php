@extends('layouts.master')
@section('content')
  {{--================ Breadcrumbs ==================--}}
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    @if(Request::is('analytics/today'))
      {{ Breadcrumbs::render('today') }}
    @elseif(Request::is('analytics/yesterday'))
      {{ Breadcrumbs::render('yesterday') }}
    @elseif(Request::is('analytics/last7days'))
      {{ Breadcrumbs::render('last7days') }}
    @elseif(Request::is('analytics/thisWeek'))
      {{ Breadcrumbs::render('thisWeek') }}
    @elseif(Request::is('analytics/lastWeek'))
      {{ Breadcrumbs::render('lastWeek') }}
    @elseif(Request::is('analytics/last30days'))
      {{ Breadcrumbs::render('last30days') }}
    @elseif(Request::is('analytics/thisMonth'))
      {{ Breadcrumbs::render('thisMonth') }}
    @elseif(Request::is('analytics/lastMonth'))
      {{ Breadcrumbs::render('lastMonth') }}
    @elseif(Request::is('analytics/thisYear'))
      {{ Breadcrumbs::render('thisYear') }}
    @elseif(Request::is('analytics/lastYear'))
      {{ Breadcrumbs::render('lastYear') }}
    @elseif(Request::is('analytics/allTime'))
      {{ Breadcrumbs::render('allTime') }}
    @endif
  </div>

  <div class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
                <section class="content-header">
                    <h3 class="box-title">Analytics</h3>
                </section>
            </div>
            <div class="box-body">
              <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                  <div class="col-md-6 col-md-offset-3 report_print_area">
                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title"> {{ $schedule }} Sales</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table class="table">
                          <tr>
                            <th>Total Sales</th>
                            <th>${{ $totalSales }}</th>
                          </tr>
                          <tr>
                            <td>Amount Paid</td>
                            <td>
                              ${{ $amountPaid }}
                            </td>
                          </tr>
                          <tr>
                            <td>Cash</td>
                            <td>
                              ${{ $cash }}
                            </td>
                          </tr>
                          <tr>
                            <td>Credit Card</td>
                            <td>
                              ${{ $credit }}
                            </td>
                          </tr>
                          <tr>
                            <td>Debit Card</td>
                            <td>
                              ${{ $debit }}
                            </td>
                          </tr>
                          <tr>
                            <td>Amound Due</td>
                            <td>
                              ${{ $amountDue }}
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <button class="btn btn-primary pull-right btn_print_reports"><i class="glyphicon glyphicon-print"></i></button>
                </div>
              </div>

           </div>
          </div>
      </div>
    </div>
  </div>
@stop
