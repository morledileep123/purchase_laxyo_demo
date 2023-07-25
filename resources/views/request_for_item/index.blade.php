@extends('../layouts.master')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" rel="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('content')

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->

    <div class="card-header">
      <div class="row">
        <div class="col-md-12">
          <div class="float-right">
            <a href="{{ route('request_for_item.create') }}" class="btn btn-success">Create New RFI</a>
            <a href="{{ '/home' }}" class="btn btn-secondary">Back</a>
          </div>
          <h5>RFI's List</h5>
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
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Site</th>
              <th>User</th>
              <th>No of Item</th>
              <th>Item Requirement</th>
              <th>Generate Date</th>
              <th>Expected Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($request_for_items))
              
              @php $i = 0; @endphp
              @foreach($request_for_items as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ App\SiteName::find($row->site_name)->name }}</td>
                <td> </td>{{-- {{ App\User::find($row->user_id)->name}} --}}
                <td>{{ $row->count }}</td>
                <td>{{ $row->item }}</td>
                <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>

                @if($row->admin_approve == 1 && $row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
                <td class="text-success">Admin Approve</td>

                @elseif($row->purchase_status == 1 && $row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1)
                  <td class="text-primary">Purchase</td>

                @elseif($row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
                  <td class="text-primary">Manager Approve</td>

                @else
                <td class="text-primary">Processing</td>
                @endif

                <td>
                  <a class="btn btn-primary btn-sm" href=" {{ route('request_for_item.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $request_for_items->links() !!}
      </div>
    </div>
      
      <!-- /.container-fluid -->
    
    <!-- /.content -->
    </div>
</div>
@endsection