<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laxyo - Purchase</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <style type="text/css">
    .welcome-db{
        padding: 12%;
        text-align: center;
        color: #000;
        background: beige;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      @php 
      $notificationData = DB::table('notificati')->where('notifiable_to',auth()->user()->id)->where('read_it','0')->get();
      @endphp          
       
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          @if(count($notificationData)!=0)
          <span class="badge badge-warning navbar-badge">{{count($notificationData)}}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{count($notificationData)}} Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            @foreach($notificationData as $notification)
            <div class="bg-blue-300">
              {{$notification->data}}
              <span class="float-right text-muted text-sm"> {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans()}} </span>
            </div>
            @endforeach
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{url('prch_Noti')}}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
        <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
          
        </a>
        <!-- Dropdown - User Information -->
        {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>{{ __('Logout') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div> --}}
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="http://www.laxyo.org/#/" class="brand-link" style="background-color: whitesmoke;">
    <img class="rounded mx-auto d-block img-fluid" src="https://www.laxyo.org/images/logos/logo.png" height="25">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group mt-3" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
  @role("purchase_superadmin")
    <!-- <li class="nav-item">
        <a class="nav-link" href="{{ '/role' }}">
          <i class="fa fa-lock" aria-hidden="true"></i>
          <span>Assign Role</span></a>
      </li>
    
      <li class="nav-item">
        <a class="nav-link" href="{{ '/members' }}">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span>Members</span></a>
      </li> -->
      

    <li class="nav-item">
      <a href="{{ route('item.index') }}" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>Items</p>
      </a>
    </li>
    
    <li class="nav-item">
      <a href="{{ route('vendor.index') }}" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>Vendors</p>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ url('purchase') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Purchase Order (PO)</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('store_item.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Warehouse Item</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('items_approval') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Request for Items</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('quotation_received_leveltwo') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Received Quotation</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('pucharse-details') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Puchase Detail</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('teams') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Teams</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('rfi_information') }}">
        <i class="nav-icon fas fa-file"></i>
        <span>RFI Information</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Setting</div>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>Masters
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ '/um' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Units of Measurement</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/company_side_name' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Company Side Name</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/category' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Items Category</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/subcategory' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Items Subcategory</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/warehouse' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Warehouses</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/gst_state_code' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>GST States</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ '/department' }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Department</p>
          </a>
        </li>
        
      </ul>
    </li>

  <!-- Divider -->
  @endrole
  @role("purchase_admin")
    <li class="nav-item">
      <a class="nav-link" href="{{ url('admin_view') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>RFI by Manager</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('admin_request_quotation') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Received for Quotation</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('vendor_quotation.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Quotation</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('generate_po') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Purchase Order (PO)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('quotation_received_levelone') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Received Quotation</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('store_item.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Warehouse Items</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('Enquiry.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Enquiry</span></a>
    </li>
    
  @endrole

  @role("prch_accountant")
    <li class="nav-item">
      <a class="nav-link" href="{{ url('accountant_grr_index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>GRR</span></a>
    </li> 
    <li class="nav-item">
      <a href="{{ route('vendor.index') }}" class="nav-link">
        <i class="fas fa-fw fa-chart-area"></i>
        <p>Vendors</p>
      </a>
    </li>  
    <li class="nav-item">
      <a href="{{ url('purchase_order_inform') }}" class="nav-link">
        <i class="fas fa-fw fa-chart-area"></i>
        <p>Purchase Order</p>
      </a>
    </li>      
    
  @endrole

  @role("purchase_manager")
  <li class="nav-item">
    <a class="nav-link" href="{{ url('manager_view') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>RFI by Users</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('quotation_manager') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Quotation</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('manager_request') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Request For Item</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('disable-to-dispatch') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Purchase Item(Filtered)</span></a>
  </li>

  <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <i class="fas fa-fw fa-cog"></i>
      <span>Request For Item</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('request_for_item.create') }}">Create RFI</a>
        <a class="collapse-item" href="{{ route('request_for_item.index') }}">RFI Listing</a>
      </div>
    </div>
  </li> -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Warehouse Items</span></a>
  </li>


  <li class="nav-item">
    <a class="nav-link" href="{{ route('rfq.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>View Request Quotations</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('approval_quotation') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Approval Quotation</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('mo-req-item') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Move Requested Items</span></a>
  </li>
  @endrole

  @role("purchase_user")
  <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>Request For Items (RFI)
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        
        <li class="nav-item">
          <a href="{{ route('request_for_item.create') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Create RFI</p>
          </a>
        </li>
         <li class="nav-item">
          <a href="{{ route('request_for_item.index') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>RFI Listing</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('GoodsReceivedNote.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>GRR/Invoice</span></a>
    </li>
  @endrole

  @role("store_admin")
  <li class="nav-item admin_css">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span class="admin_css">Items</span>
    </a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_management.index') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">PO Received</span></a>
  </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('item_of_stock') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">Your Stock</span></a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="{{ route('un_item_of_stock') }}">
      <i class="fas fa-fw fa-chart-area admin_css"></i>
      <span class="admin_css">Req Item unable</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('view_grn') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Generate GRN</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('receiving') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Stock Transfer</span></a>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('approve_dc') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Approve Stock Transfer</span></a>
  </li> --}}
  <li class="nav-item">
    <a class="nav-link" href="{{ route('users') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">User Management</span></a>
  </li>
  @endrole
  @role(["purchase_superadmin","purchase_admin"])
  <li class="nav-item">
    <a class="nav-link" href="{{ route('approve_dc') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span class="admin_css">Approve Stock Transfer</span></a>
  </li>
  @endrole

  <!-- @role("ratlam_warehouse"||"indore_warehouse")
  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_item.index') }}">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span>Items</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('store_management.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>PO Received</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('view_grn') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Generate GRN</span></a>
  </li>
  @endrole -->


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">       
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              
              <div class="card-body welcome-db">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                    <h3>Welcome <b>{{ ucwords(Auth::user()->name) }}</b> <br> Laxyo Purchase Dashboard</h3>
                    {{-- <div class="container-fluid">
                        <div class="card shadow mb-4">
                            <div class="card-body welcome-db">
                                <h3>Welcome <b>{{ ucwords(Auth::user()->name) }}</b> <br> Laxyo Purchase Dashboard</h3>
                            </div>
                        </div>
                    </div>
                     --}}
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>

                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </section>
          <!-- /.Left col -->
       
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>

