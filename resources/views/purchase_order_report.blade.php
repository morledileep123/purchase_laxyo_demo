
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Top Navigation</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style>
    .sub-btn{
        width: fit-content;
        margin-left: 20px;
        margin-bottom: 20px;
    }

    .details{
        border: none !important;
        background: none !important;
    }
</style>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="../../index3.html" class="navbar-brand">
          <img src="../../dist/img/laxyo_pic.png" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
          {{-- <span class="brand-text font-weight-light">Laxyo PVT LTD</span> --}}
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h4 class="m-0"> Top Navigation <small>Example 3.0</small></h4>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid">
    <div class="card shadow mt-3">
        <div class="card-header">
          <h2 class="card-title">Send Quotation</h2>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                
               <div class="row">
                  <!-- left column -->
                    <div class="col-md-6">
                    <!-- general form elements -->
                        <div class="card">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Vendor Details</h3>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                         
                            <div class="card-body">
                              <div class="form-group">
                                <input type="text" name="company_name" class="form-control details" value="Yolax InfraEnergy Pvt Ltd" >
                                <input type="text" name="company_address" class="form-control details" value="Mahalaxmi nagar county park laxyo house ,Indore" >
                                <input type="text" name="phone_no" class="form-control details" value="Phone: +91-731-4043798, Mobile: 8815218210" >
                                <input type="text" name="gst_no" class="form-control details" value="GSTIN - 23AABCL3031E1Z9" >
                              </div>
                            </div>
                        </div>
                    </div>


                <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Company Address</h3>
                      </div>
                     
                        <div class="card-body">
                          <div class="form-group">
                            <textarea class="form-control rounded-0" rows="6" name="delivery_address"></textarea>
                            
                          </div>
                          
                        </div>
                        <!-- /.card-body -->
                      
                    </div>
                </div>

                <div class="col-md-12">
                <form action="{{route('vendor_quotation_send')}}" method="post">
                    @csrf
                  <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Items</h3>
                      </div>
                    <table id="invoice-item-table" class="table table-bordered">
                      <tr class="text-center">
                        <th>S.No</th>
                        <th>Item Name</th>     
                        <th>Description</th>
                        <th>Uom</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>   
                        <th>Remark</th> 
                      </tr>
                       @php $i=1; @endphp
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td>
                        <td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td><td>
                          <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                          <div id="itemList1" /></div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </form>
                </div>  

                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Delivery Location</h3>
                      </div>
                     
                        <div class="card-body">
                          <div class="form-group">
                            <textarea class="form-control rounded-0" rows="6" name="delivery_address"></textarea>   
                          </div>
                        </div>
                        <!-- /.card-body -->
                      
                    </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                      <div class="card-header bg-light">
                          <h3 class="card-title">Signature</h3>
                      </div>
                      <div class="card-body">
                          <div class="form-group">
                            <textarea class="form-control rounded-0" rows="6" name="delivery_address"></textarea>   
                          </div>
                        </div>
                  </div>
                </div>   

            </div>
        </div>
            
          </div>
        </div>
        <!-- /.card-body -->
         <button type="submit" name="submit" class="btn btn-primary sub-btn" onclick="return confirm('Are you sure you want to submit this from?');">Send Quotation</button>
    
    </div>

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
</html>
