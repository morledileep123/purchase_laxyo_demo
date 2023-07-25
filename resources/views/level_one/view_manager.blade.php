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
            <a href="{{ '/home' }}" class="btn btn-secondary btn-sm px-2">Back</a>
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
                <li class="nav-item" style="width: 35%">
                  <a class="nav-link text-center active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Request RFI</b></a>
                </li>
                <li class="nav-item" style="width: 35%">
                  <a class="nav-link text-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>Approve RFI</b></a>
                </li>
                <li class="nav-item" style="width: 30%">
                  <a class="nav-link text-center" id="hold-tab" data-toggle="tab" href="#hold" role="tab" aria-controls="hold" aria-selected="false"><b>Hold RFI</b></a>
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
                        <td>{{ App\User::find($row->user_id)->name}}</td>
                        <td>{{$row->count}}</td>
                        <td>{{ $row->item }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>
                        <td>
                          <a class="btn btn-primary btn-sm" href=" {{ route('manager_view.edit',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                    @if (!empty($mngarrrove))
                      
                      @php $i = 0; @endphp
                      @foreach($mngarrrove as $row)
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ App\User::find($row->user_id)->name}}</td>
                        <td>{{$row->count}}</td>
                        <td>{{ $row->item }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->request_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->expected_date)) }}</td>

                        <td><a class="btn btn-primary btn-sm" href=" {{ route('manager_view.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </td>
                      </tr>
                      @endforeach
                    @endif
                  
                  </tbody>
                  
                  </table>
                  </div>
                </div>                

                <div class="tab-pane fade" id="hold" role="tabpanel" aria-labelledby="hold-tab">
                  <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="inv-table">
                    <thead>
                    <tr>
                      <th>S.No</th>
                      <th>From</th>                   
                      <th>Item Requirement</th>
                      <th>Generate Date</th>
                      <th>Expected Date</th>   
                      <th>Action</th>                  
                    </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @if (!empty($hold_datas))
                        
                        @php $i = 0; @endphp
                        @foreach($hold_datas as $hold_data)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ App\User::find($hold_data->user_id)->name}}</td>
                          
                          <td>{{ $hold_data->item }}</td>
                          <td>{{ date('d-m-Y', strtotime($hold_data->request_date)) }}</td>
                          <td>{{ date('d-m-Y', strtotime($hold_data->expected_date)) }}</td>

                          <td><a class="btn btn-primary btn-sm" href=" {{ url('manager_view_hold_item',$hold_data->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
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