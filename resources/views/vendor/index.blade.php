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
<div class="card">  
  
 <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <div class="float-right">
            <a href="{{ url('vendor/create') }}" class="btn btn-success btn-sm">Add Vendor </a>
            <a href="{{ '/home' }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i>  Back</a>
          </div>
          <h5>Vendors Listing</h5>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display" id="example" width="100%" cellspacing="0">
              dfgnlkdfhg
            <thead>
              <tr>
                <th>S.No</th>
                <th>Company</th>
                <th>Vendor Type</th>
                <th>Product</th>
                <th>Person name</th>
                <th>GST No.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if (!empty($vendors))
                @foreach ($vendors as $row)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $row->company }}</td>
                  <td>{{ $row->vendor_type }}</td>
                  <td>{{ $row->product }}</td>
                  <td>{{ $row->person_name }}</td>
                  <td>{{ $row->gstin }}</td>
                  {{-- <td>@if($row->na_gst == 0){{ $row->gst_number }}@else {{ 'N/A' }} @endif</td> --}}
                  <td style="padding: 8px 3px !important;">
                      <form action="{{ route('vendor.destroy',$row->id) }}" method="POST">
                      <a class="btn btn-success btn-xs" style="padding: 0px 0px !important;" href="{{ route('vendor.show',$row->id) }}"><i class="fa fa-eye btn-xs" aria-hidden="true"></i></a>
                      <a class="btn btn-primary btn-xs" href="{{ route('vendor.edit',$row->id) }}" style="padding: 0px 0px !important;"><i class="fa fa-edit btn-xs" aria-hidden="true"></i></a>
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