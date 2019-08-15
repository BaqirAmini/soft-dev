@extends('layouts.master')
@section('content')
<body class="hold-transition login-page">
        <div class="login-box">
          <div class="login-logo">
            <img src="{{ asset('uploads/cashco_blue.png') }}" alt="Logo" width="130" height="50">
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <form id="login" action="{{ route('login') }}" method="post">
                @csrf
              <div class="form-group has-feedback">
                <!-- To change email to username, name, name attribute of these forms should just the same as fields in database - users table  -->
              @if ($errors->has('username'))
                  <span class="invalid-feedback" role="alert">
                      <strong style="color:rgb(240, 126, 126);font-size: 12px;">{{ $errors->first('username') }}</strong>
                  </span><br>
              @endif
              @if (Session::has('inactive'))
                  <span class="invalid-feedback" role="alert">
                      <strong style="color:rgb(240, 126, 126);font-size: 12px;">{{ Session::get('inactive') }}</strong>
                  </span><br><br>
              @endif
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="name" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="User Name" autofocus>
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
                  <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" autofocus>
                </div>
              </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-xs-5 col-md-5 col-lg-5 col-md-offset-4 col-xs-offset-4 col-lg-offset-4">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" name="remember_me"> Remember Me
                    </label>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button><br>
                  <a href="{{ route('password.request') }}">Forgot Password</a>
                </div>
                <!-- /.col -->
              </div>
            </form>
        </div>
        <!-- /.login-box -->
</body>
@stop