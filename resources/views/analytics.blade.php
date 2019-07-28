@extends('layouts.master')
@section('content')
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
                  <div class="col-md-6 col-md-offset-3" id="report_print_area">
                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title"> {{ $schedule }} Sales</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table class="table">
                          <tr>
                            <th>Total</th>
                            <th>${{ $total }}</th>
                          </tr>
                          <tr>
                            <td>Recieved Amount</td>
                            <td>
                              ${{ $recieved }}
                            </td>
                          </tr>
                          <tr>
                            <td>Cash</td>
                            <td>
                              ${{ $cash }}
                            </td>
                          </tr>
                          <tr>
                            <td>Master Card</td>
                            <td>
                              ${{ $master }}
                            </td>
                          </tr>
                          <tr>
                            <td>Debit Card</td>
                            <td>
                              ${{ $debit }}
                            </td>
                          </tr>
                          <tr>
                            <td>Recievable Amount</td>
                            <td>
                              ${{ $recievable }}
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <button class="btn btn-primary pull-right" id="btn_print_reports"><i class="glyphicon glyphicon-print"></i></button>
                </div>
              </div>
             
           </div>
          </div>
      </div>
    </div>
  </div>
@stop