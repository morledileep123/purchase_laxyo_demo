@extends('../layouts.master')

@section('content')

<!-- Show Decline reason RFI -->
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

<!-- Show Hode reason RFI -->
<div class="modal fade" id="hide_request_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalCenterTitle">Hold Reason</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea id="hide_reason" class="form-control" rows="6%" readonly></textarea>          
      </div>
    </div>
  </div>
</div>


<div class="container-fluid">
	<div class="card shadow mb-4">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-6">
          <h5>View RFI details</h5>
        </div>
        <div class="col-sm-6">
          <div class="float-sm-right">
            <a href="{{ url('rfi_information') }}" class="btn btn-secondary btn-sm">Back</a>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body">		
      <div class="row">
        <div class="col-md-4">
          <h5>Site - {{ App\SiteName::find($item[0]->site_name)->name }}</h5>
          <h5>User - {{ App\User::find($item[0]->user_id)->name }}</h5>
        </div>
        <div class="col-md-4">
          <h5>Generate DT - {{ date('d/m/Y', strtotime($item[0]->request_date)) }}</h5>

          @if($item[0]->manager_id != NULL)         
            <h5>Manager - {{ App\User::find($item[0]->manager_id)->name }}</h5>    
          @else
            <td></td>        
          @endif          
        </div>
        <div class="col-md-4">
          <h5>Expected DT - {{ date('d/m/Y', strtotime($item[0]->expected_date)) }}</h5>

          @if($item[0]->admin_id != NULL)         
            <h5>Manager - {{ App\User::find($item[0]->admin_id)->name }}</h5>    
          @else
            <td></td>        
          @endif        
        </div>
      </div>
      <br>

      <table id="invoice-item-table" class="table table-bordered">
        <tr>
          <th width="1%">S.No</th>
          <th>Item Name</th>
          <th>Item No.</th>
          <th width="12%">Quantity</th>
          <th width="12%">Sending qty</th>
          <th>Remark</th>
          <th width="10%">Img</th>
          <th width="5%">Status</th>
        </tr>
        @php $m = 1; @endphp
        @foreach($item as $row)
        <tr>
          <td>{{ $m++ }}</td>
          <td>{{ $row->item_name }}</td>
          <td>{{ $row->item_no }}</td>
          <td>{{ $row->quantity }}  {{ $row->quantity_unit }}</td>
          <td>{{ $row->a_quantity }}</td>
          <td>{{ $row->description }}</td>

          @if($row->rfi_image != null)
          <td><img src="{{asset($row->rfi_image)}}" class="show_img_request" value="{{$row->decline_reason}}" width="100%"></td>
          @endif

          @if($row->hold_status == 1)
          <td><button type="button" class="btn btn-primary btn-sm show_hide_request" value="{{$row->hold_reason}}">Hold</button></td>

          @elseif($row->dispatch_status == 1)
          <td><button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$row->dispatch_reason}}">Decline</button></td>
           

          @elseif($row->admin_approve == 1 && $row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
            <td class="text-success">Admin Approve</td>

          @elseif($row->admin_status == 1 && $row->manager_approve  == 1 && $row->manager_status == 1 )
            <td class="text-primary">Manager Approve</td>

          @else
          <td class="text-primary">Processing</td>
          @endif
        </tr>
        @endforeach
      </table>
    </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
  // show remove rfi reason 
  $('.show_remove_request').click(function(e){
    e.preventDefault();
    var remove_reason = $(this).val();
    
    $('#remove_reason').val(remove_reason);

    $('#decline_request_show').modal('show');

  });

  // show Hide rfi reason 
  $('.show_hide_request').click(function(e){
    e.preventDefault();
    var hide_reason = $(this).val();
    
    $('#hide_reason').val(hide_reason);

    $('#hide_request_show').modal('show');

  });

});
</script>

@endsection