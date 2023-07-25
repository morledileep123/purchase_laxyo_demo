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
            <ol class="float-sm-right">
            <button type="button" class="btn dropdown-toggle btn-success" data-toggle="dropdown">
                Create Document</button>
            <div class="dropdown-menu">
                <a class="dropdown-item border-bottom" href="{{url('/vendor_quotation/create')}}">Generate Quotation</a>
                <a class="dropdown-item border-bottom" href="{{url('/create_quotation_excel')}}">Generate Quotation with Excel</a>
                <a class="dropdown-item border-bottom" href="{{url('/generate_po/create')}}">Generate Purchase Order</a>
            </div>&nbsp;&nbsp;
              <a href="{{ '/home' }}" class="btn btn-secondary btn-sm">Back</a>
            </ol>
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
      <div class="row">
        <div class="col-12">

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" style="width: 50%">
              <a class="nav-link text-center active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Request RFI</b></a>
            </li>
            <li class="nav-item" style="width: 50%">
              <a class="nav-link text-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>Approve RFI</b></a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>From</th>
                  <th>No of Item</th>
                  <th>Item Requirement</th>
                  <th>Generate Date</th>
                  <th>Expected Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if (!empty($request_for_items))
                  
                  @php $i = 0; @endphp
                  @foreach($request_for_items as $row)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td></td>
                    {{-- <td>{{ App\User::find($row->manager_id)->name}}</td> --}}
                    <td>{{$row->count}}</td>
                    <td>{{ $row->item }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>
                    <td>
                      <a class="btn btn-primary btn-sm" href=" {{ route('admin_view.edit',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
            {!! $request_for_items->links() !!}
            </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="table-responsive">
              <table class="table table-bordered table-hover" id="inv-table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>From</th>
                  <th>No of Item</th>
                  <th>Item Requirement</th>
                  <th>Generate Date</th>
                  <th>Expected Date</th>
                  <th>Action</th>                
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @if (!empty($adminapprove))
                  
                  @php $i = 0; @endphp
                  @foreach($adminapprove as $row)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ App\User::find($row->manager_id)->name}}</td>
                    <td>{{$row->count}}</td>
                    <td>{{ $row->item }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>

                    <td><a class="btn btn-primary btn-sm" href=" {{ route('admin_view.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  @endforeach
                @endif
              
              </tbody>
              
              </table>
              </div>
            </div>
            
          </div>                
            
        </div>
        <!-- /.col -->
      </div>
    </div>
      
      <!-- /.container-fluid -->
    
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

    $('.delete_invoice').click(function(e){
      e.preventDefault();

      var id = $(this).val();
      $('#invoice_id').val(id);

      $('#delete_invoice').modal('show');

    });
  });
</script>
@endsection