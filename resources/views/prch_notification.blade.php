<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Top Navigation</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="/" class="navbar-brand">
        <img src="{{asset('assets/img/laxyo_pic.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Notifications Dropdown Menu -->
        @php 
        $notificationData = DB::table('notificati')->where('notifiable_to',auth()->user()->id)->where('read_it','0')->latest()->get();
        $notificationDataShow = DB::table('notificati')->where('notifiable_to',auth()->user()->id)->where('read_it','0')->latest()->take(5)->get();
        @endphp          
         
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{count($notificationData)}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{count($notificationData)}} Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              @foreach($notificationDataShow as $notification)
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
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
       
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <div class="row">
            <div class="col-5 col-sm-2">
              <div class="card">
                <div class="card-header"><h5 class="text-center">Status</h5 ></div>
                <div class="card-body">
                  <div class="nav flex-column nav-tabs h-40" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link text-center active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Unread</a>
                  <a class="nav-link text-center" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Read</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-7 col-sm-10">
              <div class="tab-content" id="vert-tabs-tabContent">
                <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                  <div class="content mb-2">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="card shadow mb-4">
                            <div class="card-header">
                              <div class="float-right">
                                <button class="btn btn-danger btn-sm delete-all" data-url="">Delete All</button>
                                <a href="{{url('/home')}}" class="btn btn-secondary btn-sm">Back</a>
                              </div>
                              <h5 class="main-title-w3layouts">Unread Notifications</h5> 
                            </div>
                            <div class="card-body">
                            <div class="table-responsive">
                              @if($message = Session::get('success'))
                                <div class="alert alert-success">
                                  <p>{{ $message }}</p>
                                </div>
                              @endif
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th><input type="checkbox" id="check_all"></th>
                                    <th>S.No</th>
                                    <th>Request Person Name</th>
                                    <th>Data</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                    <th>Link</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if(!empty($unreads))
                                  @php $i=1; @endphp
                                  @foreach ($unreads as $row)
                                  <tr id="tr_{{$row->id}}">
                                    <td><input type="checkbox" class="checkbox" data-id="{{$row->id}}"></td>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ App\User::find($row->notifiable_id)->name}}</td>
                                    <td>{{ $row->data }}</td>                                                
                                    <td>{{ $row->created_at->format('j F Y') }}</td>                                   
                                    <td><a class="btn btn-secondary btn-sm" href="{{route('prch_Noti.edit',$row->id) }}"><i class="fa fa-window-close" aria-hidden="true"></i> Dismiss</a></td>
                                    <td><a href="{{ $row->page_link }}" class="btn btn-success btn-sm">Edit</a></td>

                                  </tr>
                                  @endforeach
                                  @endif
                                </tbody>
                              </table>
                              {!! $unreads->links() !!}
                            </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.col-md-6 -->
                      </div>
                      <!-- /.row -->
                    </div><!-- /.container-fluid -->
                  </div>

                </div>
                <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                  <div class="content mb-2">
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="card shadow mb-4">
                            <div class="card-header">
                              <div class="float-right">
                                <a href="{{url('/home')}}" class="btn btn-secondary btn-sm">Back</a>
                              </div>
                              <h5 class="main-title-w3layouts">Read Notifications</h5> 
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                @if($message = Session::get('success'))
                                  <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                  </div>
                                @endif
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>S.No</th>
                                      <th>Request Person Name</th>
                                      <th>data</th>
                                      <th>Request Date</th>
                                      <th>Dismiss Date</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>

                                    @php $i=1; @endphp
                                    @foreach ($reads as $row)
                                      <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ App\User::find($row->notifiable_id)->name}}</td>
                                        <td>{{ $row->data }}</td>
                                        <td>{{ $row->created_at->format('j F Y') }}</td>
                                        <td>{{ $row->updated_at->format('j F Y') }}</td>        
                                        
                                      </tr>
                                    @endforeach
                                    
                                  </tbody>
                                </table>
                                {!! $reads->links() !!}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.col-md-6 -->
                      </div>
                      <!-- /.row -->
                    </div><!-- /.container-fluid -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
<script type="text/javascript">
$(document).ready(function () {
  $('#check_all').on('click', function(e) {
    if($(this).is(':checked',true))  
    {
    $(".checkbox").prop('checked', true);  
    } else {  
    $(".checkbox").prop('checked',false);  
    }  
  });
  $('.checkbox').on('click',function(){
    if($('.checkbox:checked').length == $('.checkbox').length){
    $('#check_all').prop('checked',true);
    }else{
    $('#check_all').prop('checked',false);
    }
  });
  $('.delete-all').on('click', function(e) {
    var idsArr = [];  
    $(".checkbox:checked").each(function() {  
      idsArr.push($(this).attr('data-id'));
    });  
    if(idsArr.length <=0)  
    {  
      alert("Please select atleast one record to delete.");  
    }else{  
      if(confirm("Are you sure, you want to delete the selected Notification ?")){  
        var strIds = idsArr.join(","); 
        
        $.ajax({
          url: "/delete-multiple-category",
          type: 'POST',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: 'id='+strIds,
          success: function (data) {
            // alert(data);
          if (data['status']==true) {
            $(".checkbox:checked").each(function() {  
            $(this).parents("tr").remove();
            });
            alert(data['message']);
          } else {
            alert('Whoops Something went wrong!!');
          }
          },
          error: function (data) {
          alert(data.responseText);
          }
        });
      }  
    }  
  });
  $('[data-toggle=confirmation]').confirmation({
    rootSelector: '[data-toggle=confirmation]',
    onConfirm: function (event, element) {
    element.closest('form').submit();
    }
  });   
});
</script>
</html>