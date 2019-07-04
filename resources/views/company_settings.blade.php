
@extends('layouts.master')
@section('content')
     <!-- Main content -->
     <section class="content">
        <div class="row">
          <div class="col-xs-12">
          @foreach($companies as $c)
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">User Management <strong></h3>
              </div>
              <!-- /.box-header -->
                  <div class="box-body">
                          
                    <div class="box">
                        <div class="box-header">
                        <!-- /.box-header -->
                        <h3 style="text-align:center">{{ $c->comp_name }}</h3>
                        <!-- box-body -->
                        <div class="box-body" id="box-user">
                        
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
            </div>
            @endforeach
          </div>
        </div>
      </section>
      <!-- /.content -->
@stop