<!-- logout-modal -->
<div class="modal fade" id="modal-logout">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirm Logout</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer col-md-offset-3">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancel</button>

          <button type="submit" class="btn btn-primary pull-left" onclick="document.getElementById('logout-form1').submit();">Logout</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display:none">
    @csrf
</form>
<!-- /.modal -->
<!-- /.logout-modal -->

@if(!Request::is('login') && !Request::is('logout'))
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="min-height: 100% !important">
       <!-- sidebar: style can be found in sidebar.less -->
       <section class="sidebar">
         <!-- Sidebar user panel -->
         <div class="user-panel">

           <div class="pull-left image">
               @if(isset($logo[0])) <a href="{{ route('myCompany.specific') }}"><img src="/uploads/logos/{{ $logo[0]->comp_logo }}" class="img-circle img-bordered img-sm"
                  alt="Logo"></a>
                @endif
           </div>
              @if(isset($logo[0]))
                <div class="pull-left info">
                  <p>{{ $logo[0]->comp_name }}</p>
                  <a href="#">{{ $logo[0]->email }}</a>
                </div>
              @endif
         </div>

         <!-- sidebar menu: : style can be found in sidebar.less -->
         <ul class="sidebar-menu" data-widget="tree">
           <li class="header">MAIN NAVIGATION</li>
           <li class="active">
             <a href="{{ route('dashboard') }}">
               <i class="fa fa-dashboard"></i> <span>Dashboard</span>
             </a>
           </li>
         @can('isSuperAdmin')
           <!-- <li>
             <a href="{{ route('company') }}">
               <i class="fa fa-home"></i> <span>Companies/Stores</span>
             </a>
           </li> -->
          @endcan
<!-- Settings for companies -->
        @can('isSuperAdmin')
        <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="{{ route('company') }}">
                  <i class="fa fa-home"></i> <span>Companies/Stores</span>
                </a>
            </li>
            <li>
              <a href="{{ route('superAdmin') }}"><i class="fa fa-users"></i>Super Admins</a>
            </li>
          </ul>
        </li>
        @endcan

         @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isCashier', App\User::class))
           <li>
             <a href="{{ route('customer') }}">
               <i class="fa fa-users"></i>
               <span>Customers</span>
               <!-- <span class="pull-right-container">
                 <span class="label label-primary pull-right">4</span>
               </span> -->
             </a>
           </li>
          @endif
          <!-- Only Stock-manager can see these -->
          @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isStockManager', App\User::class))
              <li>
                <a href="{{ route('item') }}">
                  <i class="fa fa-bank"></i> <span>Inventories</span>
                </a>
              </li>
              <li>
                <a href="{{ route('category') }}">
                  <i class="fa fa-cubes"></i>
                  <span>Categories</span>
                </a>
              </li>
          @endif
          @can('isSystemAdmin')
           <!-- sales -->
            <li><a href="{{ route('sale') }}">
              <i class="fa fa-shopping-cart"></i> <span>New Sale</span></a>
            </li>
          @endcan
          @if(Auth::user()->can('isSystemAdmin', App\User::class) || Auth::user()->can('isCashier', App\User::class))
            <!-- Reports -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sticky-note"></i>
                <span>Analytics</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-circle-o"></i>
                        Tabular
                    </a>
                   {{-- <a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> Tabular
                    <span class="pull-right-container">
                     --}}{{-- <i class="fa fa-angle-left pull-right"></i>--}}{{--
                    </span></a>--}}
                  {{--<ul class="treeview-menu">
                    <li><a href="{{ route('report', ['id'=>'today']) }}"><i class="fa fa-check"></i> Today</a></li>
                    <li><a href="{{ route('report', ['id'=>'yesterday']) }}"><i class="fa fa-check"></i> Yesterday</a></li>
                    <li><a href="{{ route('report', ['id' => 'last7days']) }}"><i class="fa fa-check"></i> Last 7 days</a></li>
                    <li><a href="{{ route('report', ['id' => 'thisWeek']) }}"><i class="fa fa-check"></i> This Week</a></li>
                    <li><a href="{{ route('report', ['id' => 'lastWeek']) }}"><i class="fa fa-check"></i> Last Week</a></li>
                    <li><a href="{{ route('report', ['id' => 'last30days']) }}"><i class="fa fa-check"></i> Last 30 days</a></li>
                    <li><a href="{{ route('report', ['id' => 'thisMonth']) }}"><i class="fa fa-check"></i> This Month</a></li>
                    <li><a href="{{ route('report', ['id' => 'lastMonth']) }}"><i class="fa fa-check"></i> Last Month</a></li>
                    <li><a href="{{ route('report', ['id' => 'thisYear']) }}"><i class="fa fa-check"></i> This Year</a></li>
                    <li><a href="{{ route('report', ['id' => 'lastYear']) }}"><i class="fa fa-check"></i> Last Year</a></li>
                    <li><a href="{{ route('report', ['id' => 'allTime']) }}"><i class="fa fa-check"></i> All The Time</a></li>
                  </ul>--}}
                </li>
                <li>
                  <a href="{{ route('graph') }}"><i class="fa fa-circle-o"></i> Charts</a>
                </li>
              </ul>
            </li>
           @endif
            <!-- Users & settings -->
            @can('isSystemAdmin')
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-gear"></i>
                  <span>Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{ route('user') }}"><i class="fa fa-circle-o"></i> Users</a></li>
                  <li><a href="{{ route('myCompany.specific') }}"><i class="fa fa-circle-o"></i> Company Setting</a></li>
                </ul>
              </li>
            @endcan
            <!-- Users & settings -->
             <li>
                 <a href="#" data-toggle="modal" data-target="#modal-logout">
                   <i class="fa fa-power-off"></i>
                   <span>Log Out</span>
                 </a>
             </li>
         </ul>
       </section>
       <!-- /.sidebar -->
     </aside>
@endif
