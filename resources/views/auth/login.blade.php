@extends('layouts.master')
@section('content')
<body class="hold-transition login-page">
        <div class="login-box">
          <div class="login-logo">
            <h3>Xamuor Login</h3>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <form id="login" action="{{ route('login') }}" method="post">
                @csrf
              <div class="form-group has-feedback">
              @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                      <strong style="color:rgb(240, 126, 126);font-size: 12px;">{{ $errors->first('name') }}</strong>
                  </span><br>
              @endif
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="User Name">
              </div>
              </div>
              <div class="form-group has-feedback">
              @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong style="color:rgb(240, 126, 126);font-size: 12px;">{{ $errors->first('password') }}</strong>
                  </span>
              @endif
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                </div>
              </div>
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox"> Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin-left:-20px;">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
        </div>
        <!-- /.login-box -->
        </body>
@stop