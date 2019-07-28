@extends('layouts.master')
@section('content')

<section class="content" >
<div class="row">
    <div class="col-md-12" >
        <!-- Box -->
        <div class="box" id="user_profile_box">
            <p id="profile_msg" style="display: none;">
                Profile Message
            </p>
            <!-- box-header 1 -->
            <div class="box-header">
                <div class="content-header">

                </div>
            </div>
            <!-- /.box-header 1 -->
            <!-- box-body -->
            <div class="box-body">
               <!-- Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#pInfo" data-toggle="tab">Personal Info</a></li>
                        <li><a href="#security" data-toggle="tab">Security</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="pInfo">
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <!-- user-profile-picture -->
                                    <form id="user-profile-photo-form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" @if(Auth::check()) value="{{ Auth::user()->id }}" @endif>
                                        <div class="form-group pull-left" style="text-align:center" id="uploaded_image">
                                            
                                                <label class="user-photo-custom-upload pull-left">
                                                    <img class="img-circle img-bordered pull-left"  @if(Auth::check()) src="/uploads/user_photos/{{ Auth::user()->photo }}" @endif alt="User Photo" id="user_profile_img">
                                                    <input type="file" id="user_profile_photo" class="upload  form-control" name="user_photo">
                                                </label>
                                          
                                        </div>
                                    </form>
                                    <!-- user-profile-picture -->
                                    <br>
                                    <span class="username">
                                        @if(Auth::check()) <a src="#">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</a> @endif
                                    </span>
                                    <span class="description">{{ Auth::user()->role }}</span>
                                </div>
                
                            </div>
                            <!-- /.post -->
                          
                            <!-- USER-INFO -->
                            <form class="form-horizontal" id="user-edit-profile-form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @endif">
                                <!-- Username -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputName">User Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_name" type="text" class="form-control" value="@if(Auth::check()){{ Auth::user()->username }}@endif"
                                            name="user_name" placeholder="First Name">
                                    </div>
                                </div>
                                <!-- First Name -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputName">First Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_name" type="text" class="form-control"
                                            value="@if(Auth::check()){{ Auth::user()->name }}@endif" name="first_name"
                                            placeholder="First Name">
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="inputLastname" class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_lastname" type="text" class="form-control"
                                            value="@if(Auth::check()) {{ Auth::user()->lastname }} @endif" name="user_lastname"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <!-- User Phone -->
                                <div class="form-group">
                                    <label for="InputPhone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input id="user_phone" type="text" class="form-control"
                                            value="@if(Auth::check()){{ Auth::user()->phone}}  @endif" name="user_phone"
                                            placeholder="Phone">
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input id="user_email" type="email" class="form-control"
                                            value="@if(Auth::check()) {{ Auth::user()->email }} @endif" name="user_email"
                                            placeholder="Email (Optional)">
                                    </div>
                                </div>
                
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn_edit_user_info">Save</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="security">
                            <form class="form-horizontal" id="password_edit_form">
                                <input type="hidden" name="user_id" value="@if(Auth::check()){{ Auth::user()->id }}@endif">
                                @csrf
                                <div class="form-group">
                                    <label for="inputCurrentPass" class="col-sm-2 control-label">Current Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="current_password" class="form-control" id="inputPassword" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNewPass" class="col-sm-2 control-label">New Password</label>
                
                                    <div class="col-sm-10">
                                        <input type="password" name="new_password" class="form-control" id="inputEmail" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNewPass" class="col-sm-2 control-label">Confirm Password</label>
                
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control" id="inputName" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="btn_edit_user_password">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
               <!-- /. Tabs -->
            </div>
            <!-- /box-body -->
        </div>
        <!-- /. Box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@stop