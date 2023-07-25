@extends('../layouts.master')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" rel="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
@section('content')

<div class="container">
  @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('success') }}
    </div>
  @endif
</div>
<div class="container">
  @if (Session::has('success_mail'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('success_mail') }}
    </div>
  @endif
</div>
<div class="container">
  @if(Session::has('delete'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Success !</strong> {{ session('delete') }}
    </div>
  @endif
</div>

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4>GRR Lists</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
              </div>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" style="width: 50%">
                  <a class="nav-link text-center active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Request GRR</b></a>
                </li>
                <li class="nav-item" style="width: 50%">
                  <a class="nav-link text-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>Send GRR</b></a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="inv-table">
                  <thead>
                  <tr>
                    <th>S No</th>
                    <th>Invoice no</th>
                    <th>GRR no</th>
                    <th>Vendor</th>
                    <th>Delivery date</th>
                    <th>Invoice date</th>
                    <th>S A Comment</th>
                    <th>Action</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @php $i=1; @endphp
                  @foreach($invoices as $row)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $row->invoice_no }}</td>                                  
                      <td>{{ $row->grn_no }}</td> 

                      @if(!empty($row->vender_company))        
                        <td>{{$row->vender_company}}</td>  
                      @else
                        <td style="white-space: pre-line">{{$row->vender_detail}}</td>        
                      @endif 

                      <td>{{ $row->delivery_date }}</td>
                      <td>{{ $row->invoice_date }}</td>
                      <td>{!! nl2br(e($row->superadmin_comment)) !!}</td>                     
                      
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
                          </button>
                          <div class="dropdown-menu">                           
                            <a class="dropdown-item" href="{{url('accountant_grr_view',$row->id )}}"><i class="fa fa-eye" aria-hidden="true"></i> View GRR</a>
                            <a class="dropdown-item" href="{{url('invoicedownloadaccountant',$row->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i> Download</a>
                          </div>
                        </div>
                      </td>
  
                    </tr>
                  @endforeach
                  
                  </tbody>
                  
                  </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="inv-table">
                  <thead>
                  <tr>
                    <th>S No</th>
                    <th>Invoice no</th>
                    <th>GRR no</th>
                    <th>Vendor</th>
                    <th>Delivery date</th>
                    <th>Invoice date</th>
                    <th>Action</th>                    
                  </tr>
                  </thead>
                  <tbody>
                  @php $i=1; @endphp
                  @foreach($invoices_send as $row)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $row->invoice_no }}</td>                                  
                      <td>{{ $row->grn_no }}</td> 

                      @if(!empty($row->vender_company))        
                        <td>{{$row->vender_company}}</td>  
                      @else
                        <td style="white-space: pre-line">{{$row->vender_detail}}</td>        
                      @endif 

                      <td>{{ $row->delivery_date }}</td>
                      <td>{{ $row->invoice_date }}</td>
                      
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
                          </button>
                          <div class="dropdown-menu"> 
                            <a class="dropdown-item" href="{{url('GGRApproveShow',$row->id )}}"><i class="fa fa-eye" aria-hidden="true"></i>  View</a>                          
                            <a class="dropdown-item" href="{{url('invoicedownloadaccountant',$row->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i> Download</a>
                            <a class="dropdown-item" href="{{route('payment.show',$row->id )}}"><i class="fa fa-credit-card" aria-hidden="true"></i> Payment Details</a>
                          </div>
                        </div>
                      </td>
  
                    </tr>
                  @endforeach
                  
                  </tbody>
                  
                  </table>
                  </div>
                </div>
                
              </div>                
              
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
</div>

<script>
  $(document).ready(function(){
    $('#inv-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'columnsToggle'
        ]
    });
    $('#myTab a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    });

  });
</script>
@endsection