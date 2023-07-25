@extends('../layouts.master')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" rel="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<style type="text/css">
  tfoot input {
    width: 100%;
    padding: 4px;
    box-sizing: border-box;
  }
</style>

@section('content')

<div class="container-fluid">
  <div class="card">

    <div class="card-header">
      <div class="row">
        <div class="col-md-12">
          <div class="float-right">
            <a href="{{ '/home' }}" class="btn btn-secondary btn-sm">Back</a>
          </div>
          <h5>RFI Information</h5>
        </div>
      </div>
    </div>

    <!-- Main content -->

    <div class="card-body">
      <div class="container" style="margin-bottom: 0px;">
        @if (Session::has('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
              <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
          </div>
        @endif
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="example" class="display" style="width:100%">
          <thead>
            <tr>
              <th width="1">S.No</th>
              <th>Site</th>
              <th>User</th>
              <th width="7%">No of Item</th>
              <th>Item Requirement</th>
              <th>Generate Date</th>
              <th>Expected Date</th>
              {{-- <th>Status</th> --}}
              <th width="1">Action</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($request_for_items))
              
              @php $i = 0; @endphp
              @foreach($request_for_items as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ App\SiteName::find($row->site_name)->name }}</td>
                <td>{{ App\User::find($row->user_id)->name}} </td>
                <td>{{ $row->count }}</td>
                <td>{{ $row->item }}</td>
                <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>

                {{-- @if($row->admin_approve == 1 && $row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
                <td class="text-success">Admin Approve</td>

                @elseif($row->purchase_status == 1 && $row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1)
                  <td class="text-primary">Purchase</td>

                @elseif($row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
                  <td class="text-primary">Manager Approve</td>

                @else
                <td class="text-primary">Processing</td>
                @endif --}}

                <td>
                  <a class="btn btn-primary btn-sm" href=" {{ route('rfi_information.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>S.No</th>
              <th>Site</th>
              <th>User</th>
              <th>No of Item</th>
              <th>Item Requirement</th>
              <th>Generate Date</th>
              <th>Expected Date</th>
              <th></th>
            </tr>
        </tfoot>
        </table>
        {{-- {!! $request_for_items->links() !!} --}}
      </div>
    </div>
      
      <!-- /.container-fluid -->
    
    <!-- /.content -->
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });
 
    // DataTable
    var table = $('#example').DataTable({
      initComplete: function () {
        // Apply the search
        this.api()
          .columns()
          .every(function () {
              var that = this;

              $('input', this.footer()).on('keyup change clear', function () {
                  if (that.search() !== this.value) {
                      that.search(this.value).draw();
                  }
              });
          });
      },
    });
  });
</script>
@endsection