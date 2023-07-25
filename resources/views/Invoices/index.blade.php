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

<!-- Show remove reason RFI -->
<div class="modal fade" id="decline_request_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalCenterTitle">Decline Reason</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea id="remove_reason" class="form-control" rows="6%" readonly></textarea>          
      </div>
    </div>
  </div>
</div>

<!-- Show Hold reason RFI -->
<div class="modal fade" id="hold_request_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalCenterTitle">Hold Reason</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea id="hold_reason" class="form-control" rows="6%" readonly></textarea>          
      </div>
    </div>
  </div>
</div>

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
            <h4>GRR Lists <small>(Goods Received Report)</small></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ route('GoodsReceivedNote.create') }}" class="btn btn-success btn-sm">Create New GRR</a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
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

            <div class="table-responsive">
            <table class="table table-bordered table-hover" id="inv-table">
            <thead>
            <tr>
              <th width="1%">S No</th>
              <th>Invoice no</th>
              <th>GRR no</th>
              <th>Vendors</th>
              <th>Delivery date</th>
              <th>Invoice date</th>    
              <th>Status</th>                
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

              @if($row->vender_detail_infor != 'null')
                <td>{!! nl2br(e($row->vender_detail_infor)) !!}</td> 
              @else
                <td>{{ $row->vender_company}}</td>  
              @endif                     
              <td>{{date('d-m-Y', strtotime($row->delivery_date)) }}</td>
              <td>{{date('d-m-Y', strtotime($row->invoice_date)) }}</td>

              @if($row->decline_status == 1 )
              <td><button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$row->decline_reason}}">Decline</button></td>

              @elseif($row->hold_status == 1 )
              <td><button type="button" class="btn btn-warning btn-sm show_hold_request" value="{{$row->hold_reason}}">Hold</button></td>

              @elseif($row->manager_aprove == 1 && $row->admin_status == 1 && $row->approve == 1)
              <td class="text-success">Approve</td>

              @elseif($row->manager_status == 1)
              <td class="text-primary">Processing</td>

              @else
              <td >Processing !</td>
              @endif

              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-xs dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
                  </button>
                  <div class="dropdown-menu">                           
                    <a class="dropdown-item" href="{{route('GoodsReceivedNote.show',$row->id )}}"><i class="fa fa-eye" aria-hidden="true"></i> View GRR</a>
                    <a class="dropdown-item" href="{{url('invoicedownloaduser',$row->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i> Download</a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            
            </tbody>
            
            </table>
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

    // show remove GRR reason 
    $('.show_remove_request').click(function(e){
      e.preventDefault();
      var remove_reason = $(this).val();
      
      $('#remove_reason').val(remove_reason);

      $('#decline_request_show').modal('show');

    });

    // show Hold GRR reason 
    $('.show_hold_request').click(function(e){
      e.preventDefault();
      var hold_reason = $(this).val();
      
      $('#hold_reason').val(hold_reason);

      $('#hold_request_show').modal('show');

    });
  });
</script>
@endsection