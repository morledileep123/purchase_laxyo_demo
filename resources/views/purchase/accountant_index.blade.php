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

<!-- Modal -->
<div class="modal fade" id="delete_po" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form action="{{route('generate_po.destroy', 'id')}}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="exampleModalCenterTitle">Delete Purchase Order</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <strong>Are you sure you want to delete this Purchase Order</strong>
          <input type="hidden" name="po_id" id="po_id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Yes , Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

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
  @if (Session::has('delete'))
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
            <h5>Purchase Order Lists</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ url('/home') }}" class="btn btn-secondary btn-sm">Back</a>
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
                <th>S No</th>
                <th>Code</th>
                <th>GEN Person</th>
                <th>Company Name</th>
                <th>Items Names</th>
                <th>Created date</th>
                {{-- <th>Approve Person</th> --}}
                {{-- <th>Status</th> --}}
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @php $i=1; @endphp
              @foreach($approve_po as $row)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $row->code }}</td>
                  <td>{{ $row->admin_id->name }}</td>

                  @if($row->vendor_details_company != '')
                      <td>{{ $row->vendor_details_company }}</td> 
                  @else
                      <td>{{ $row->vender_detail }}</td>
                  @endif
                              
                  <td>{{ $row->invoice_product }}</td>
                  <td>{{ $row->date }}</td>
                  {{-- <td>{{ $row->super_admin->name }}</td> --}}
                  {{-- <td>
                    @if($row->super_admin_status == 'A')
                      <h6 class="text-success">Approve</h6>
                    @elseif($row->super_admin_status == 'D')
                      <button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$row->dispatch_reason}}">Decline</button>
                    @else
                      <h6 class="text-primary">Some thing wrong</h6>
                    @endif

                  </td> --}}
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-secondary btn-xs dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
                      </button>
                      <div class="dropdown-menu">                           
                        <a class="dropdown-item" href="{{url('purchase_order_view',$row->id )}}"><i class="fa fa-eye" aria-hidden="true"></i> View Purchase Order</a>
                        <a class="dropdown-item" href="{{url('purchase_order_inform_download',$row->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i>  Download</a>                        
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

    $('.delete_purchase_order').click(function(e){
      e.preventDefault();

      var id = $(this).val();
      $('#po_id').val(id);

      $('#delete_po').modal('show');

    });

    // show remove rfi reason 
    $('.show_remove_request').click(function(e){
      e.preventDefault();
      var remove_reason = $(this).val();
      
      $('#remove_reason').val(remove_reason);

      $('#decline_request_show').modal('show');

    });

  });
</script>

@endsection