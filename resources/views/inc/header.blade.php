<!-- User-profile-modal -->


<header class="main-header">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="/uploads/cashco_white.png" alt="Logo" width="40" height="20"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="/uploads/cashco_white.png" alt="Logo" width="70" height="35"></span>
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
            
                <a href="{{ route('profile') }}">
                  <img src="/uploads/user_photos/{{ Auth::user()->photo }}" class="user-image img-bordered" alt="User Image" style="width: 35px;height:35px;margin-top:-6px;">
                  <span class="hidden-xs">@if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }} @endif</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                @if(Auth::check())    <img src="/uploads/user_photos/{{ Auth::user()->photo }}" class="img-circle" alt="User Image"> @endif
    
                    <p>
                        @if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }}   - {{ Auth::user()->role }} @endif
                      <!-- <small>Member since Nov. 2018</small> -->
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('profile') }}" class="btn btn-default btn-flat" >Profile</a>
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
      
 