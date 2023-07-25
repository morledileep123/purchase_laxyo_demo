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
    <div class="alert alert-success alert-dismissible " role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('success') }}
    </div>
  @endif
</div>
<div class="card">  
  
 <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <div class="float-right">
            <a href="{{ url('vendoritems/create') }}" class="btn btn-success btn-sm">Add Vendor </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i>  Back</a>
          </div>
          <h5>Vendors and Items</h5>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display" id="example" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Vendor Name</th>
                <th>Material Code</th>
                <th>Material Desc</th>
                <th>Unit</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if (!empty($data))
                @foreach ($data as $row)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $row->vendor_name }}</td>
                  <td>{{ $row->material_code }}</td>
                  <td>{!! nl2br(e($row->material_desc)) !!}</td> 
                  <td>{{ $row->unit }}</td>
                  <td>{!! nl2br(e($row->address)) !!}</td>
                  {{-- <td>@if($row->na_gst == 0){{ $row->gst_number }}@else {{ 'N/A' }} @endif</td> --}}
                  <td style="padding: 8px 3px !important;">
                      <form action="{{ route('vendoritems.destroy',$row->id) }}" method="POST">
                      <a class="btn btn-success btn-xs" style="padding: 0px 0px !important;" href="{{ route('vendoritems.show',$row->id) }}"><i class="fa fa-eye btn-xs" aria-hidden="true"></i></a>
                      <a class="btn btn-primary btn-xs" href="{{ route('vendoritems.edit',$row->id) }}" style="padding: 0px 0px !important;"><i class="fa fa-edit btn-xs" aria-hidden="true"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-xs" style="padding: 0px 0px !important;"><i class="fa fa-trash btn-xs" aria-hidden="true"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>
          </div>
          <br>

        </div>
        <!-- /.card-body -->
        
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
</div>

</div>
<script>
  $(document).ready(function() {
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'columnsToggle'
      ]
    });
  });
</script>
@endsection