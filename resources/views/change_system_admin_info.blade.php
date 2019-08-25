@extends('layouts.master')
@section('content')
    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        {{ Breadcrumbs::render('sa-info') }}
    </div>
<section class="content" >
<div class="row">
    <div class="col-md-12" >
        <!-- Box -->
        <div class="box" id="user_profile_box">
            <p id="any_system_admin_msg" style="display: none;">
                Profile Message
            </p>
            <!-- box-header 1 -->
            <div class="box-header">
                <div class="content-header" style="text-align: center">
                    <h3 class="box-title">Change System Admin Info</h3>
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
                {{--   Profile picture of super-admin    --}}
                                    <form id="any_system_admin_edit_photo_form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $systemAdms[0]->id }}">
                                        <div class="form-group pull-left" style="text-align:center" id="upload_img_div">

                                                <label class="user-photo-custom-upload pull-left">
                                                    <img class="img-circle img-bordered pull-left"  src="/uploads/user_photos/{{ $systemAdms[0]->photo }}"  alt="User Photo" id="any_system_admin_img">
                                                    <input type="file" id="any_system_admin_photo" class="upload  form-control" name="user_photo">
                                                </label>

                                        </div>
                                    </form>
            {{--   Profile picture of super-admin    --}}
                                    <br>
                                    <span class="username">
                                        <a src="#">{{ $systemAdms[0]->name }} {{ $systemAdms[0]->lastname }}</a>
                                    </span>
                                    <span class="description">{{ $systemAdms[0]->role }}</span>
                                </div>

                            </div>
                            <!-- /.post -->

                            <!-- USER-INFO -->
                            <form class="form-horizontal" id="any_system_admin_edit_info" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $systemAdms[0]->id }}">
                                <!-- Username -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputName">User Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_name" type="text" class="form-control" value="{{ $systemAdms[0]->username }}"
                                            name="user_name" placeholder="User Name">
                                    </div>
                                </div>
                                <!-- First Name -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputName">First Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_name" type="text" class="form-control"
                                            value="{{ $systemAdms[0]->name }}" name="first_name"
                                            placeholder="First Name">
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="form-group">
                                    <label for="inputLastname" class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input id="user_lastname" type="text" class="form-control"
                                            value="{{ $systemAdms[0]->lastname }}" name="user_lastname"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <!-- User Phone -->
                                <div class="form-group">
                                    <label for="InputPhone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input id="user_phone" type="text" class="form-control"
                                            value="{{ $systemAdms[0]->phone }}" name="user_phone"
                                            placeholder="Phone">
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input id="user_email" type="email" class="form-control"
                                            value="{{ $systemAdms[0]->email }}" name="user_email"
                                            placeholder="Email (Optional)">
                                    </div>
                                </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <a href="{{ route('company') }}" type="button" class="btn btn-default">< Back</a>
                                    <button type="submit" class="btn btn-primary" id="btn_edit_user_info">Save</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="security">
                            <form class="form-horizontal" id="any_system_admin_reset_password">
                                <input type="hidden" name="user_id" value="{{ $systemAdms[0]->id }}">
                                @csrf
                                <div class="form-group">
                                    <label for="inputCurrentPass" class="col-sm-2 control-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
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
