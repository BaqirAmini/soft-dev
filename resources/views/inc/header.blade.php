<!-- User-profile-modal -->
<div class="modal fade" id="modal-user-profile">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4>Change User Profile</h4>
            <strong id="message" style="display:none"></strong>
            
        </div>
        <div class="modal-body">
                <div class="register-box-body">
                  <!-- user-profile-picture -->
                   <form id="user-profile-picture-form">
                     @csrf
                      <input type="hidden" name="user_id" @if(Auth::check()) value="{{ Auth::user()->id }}" @endif>   
                        <div class="form-group" style="text-align:center" id="uploaded_image">
                            <img id="user_avatar" @if(Auth::check()) src="/uploads/user_photos/{{ Auth::user()->photo }}"@endif alt="User Photo" width="80" height="80"><br>
                        </div>
                          <h5 style="text-align:center;margin:auto;"><b>@if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                              @endif</b></h5><br>
                        <div class="input-group col-md-6" id="choose-profile-photo">
                          <label  class="custom-upload">
                            Choose<br>Avatar
                              <input type="file" id="user_photo" class="upload customer-file-input form-control" name="user_photo">    
                          </label>
                              
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary" id="change_profile_photo">Update</button>
                            </span>
                        </div><br>
                    </form>
                    <!-- user-profile-picture -->
                      <form class="form-horizontal" id="user-edit-profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @endif">
                        <!-- First Name -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">First Name:</span>
                                  <input id="user_name" type="text" class="form-control" value="@if(Auth::check()) {{ Auth::user()->name }} @endif" name="user_name" placeholder="First Name">
                              </div>
                           </div>
                        <!-- Last Name -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">Last Name:</i></span>
                                  <input id="user_lastname" type="text" class="form-control" value="@if(Auth::check()) {{ Auth::user()->lastname }} @endif" name="user_lastname" placeholder="Last Name">
                              </div>
                           </div>
                        <!-- User Phone -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">Phone:</span>
                                  <input id="user_phone" type="number" class="form-control" value="@if(Auth::check()) {{ Auth::user()->phone }}  @endif" name="user_phone" placeholder="Phone">
                              </div>
                           </div>
                        <!-- Email -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">Email:</span>
                                  <input id="user_email" type="email" class="form-control" value="@if(Auth::check()) {{ Auth::user()->email }} @endif" name="user_email" placeholder="Email">
                              </div>
                           </div>
                           <!-- Old-password -->
                           <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">Password:</span>
                                  <input id="current_password" type="password" class="form-control" name="current_password" placeholder="Current Password">
                              </div>
                           </div>
                        <!-- New Password -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">New Password:</span>
                                  <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password">
                              </div>
                           </div>
                        <!-- Confirm password -->
                            <div class="form-group has-feedback">
                              <div class="input-group">
                                  <span class="input-group-addon">Retype Password:</span>
                                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password">
                              </div>
                           </div>
                       
                        <div class="form-group">
                          <div class="col-md-12">
                              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button> &nbsp;
                              <button type="button" class="btn btn-primary" id="btn_update_profile">Save</button>
                          </div><br>
                          <span id="user-msg" style="margin-top:10px;"></span>    
                        </div>
                      </form>
                     </div>
                  </div>
            </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
      </div>

<header class="main-header">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>OS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Xamuor</b> POS</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
    
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
            
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="/uploads/user_photos/{{ Auth::user()->photo }}" class="user-image" alt="User Image">
                  <span class="hidden-xs">@if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }} @endif</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                @if(Auth::check())    <img src="/uploads/user_photos/{{ Auth::user()->photo }}" class="img-circle" alt="User Image"> @endif
    
                    <p>
                        @if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }}  @endif - Super Admin
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-user-profile">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-logout">Logout</a>
                    </div>
                  </li>
                </ul>
              
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
 