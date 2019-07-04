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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancel</button>
        
          <button type="submit" class="btn btn-danger pull-left" onclick="document.getElementById('logout-form1').submit();">Logout</button>
        
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
<aside class="main-sidebar">
       <!-- sidebar: style can be found in sidebar.less -->
       <section class="sidebar">
         <!-- Sidebar user panel -->
         <div class="user-panel">
           
           <div class="pull-left image">
        <a href="#">@if(Auth::check())<img src="/uploads/user_photos/{{ Auth::user()->photo }}" width="40" height="40" class="img-circle" alt="User Image"
          data-toggle="modal" data-target="#modal-user-profile"> @endif</a>
           </div>
           <div class="pull-left info">
             <p> @if(Auth::check()) {{ Auth::user()->name }} {{ Auth::user()->lastname }} @endif</p>
             <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
           </div>
         </div>
       
         <!-- sidebar menu: : style can be found in sidebar.less -->
         <ul class="sidebar-menu" data-widget="tree">
           <li class="header">MAIN NAVIGATION</li>
           <li>
             <a href="{{ route('dashboard') }}">
               <i class="fa fa-dashboard"></i> <span>Dashboard</span>
             </a>
           </li>
         @can('isSuperAdmin')  
           <li>
             <a href="{{ route('company') }}">
               <i class="fa fa-home"></i> <span>Companies/Stores</span>
             </a>
           </li>
          @endcan
          @can('isSystemAdmin')
           <li>
             <a href="{{ route('customer') }}">
               <i class="fa fa-users"></i>
               <span>Customers</span>
               <!-- <span class="pull-right-container">
                 <span class="label label-primary pull-right">4</span>
               </span> -->
             </a>
           </li>
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
           <!-- sales -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Sales</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('sale') }}"><i class="fa fa-circle-o"></i> Create Sale</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Sales Report</a></li>
              </ul>
            </li>
            <!-- Reports -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sticky-note"></i>
                <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Tabular Reports 
                  <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                  </span></a>
                  <ul class="treeview-menu">
                      <li><a href="{{ route('daily') }}"><i class="fa fa-check"></i> Daily</a></li>
                      <li><a href="{{ route('weekly') }}"><i class="fa fa-check"></i> Weekly</a></li>
                      <li><a href="{{ route('monthly') }}"><i class="fa fa-check"></i> Monthly</a></li>
                      <li><a href="{{ route('annually') }}"><i class="fa fa-check"></i> Annually</a></li>
                  </ul>
                </li>
                <li>
                  <a href="{{ url('reports/graph') }}"><i class="fa fa-circle-o"></i> Chart Reports</a></li>
              </ul>
            </li>
            @endcan
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
                  <li><a href="{{ route('company.setting') }}"><i class="fa fa-circle-o"></i> More</a></li>
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