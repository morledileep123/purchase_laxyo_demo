@extends('../layouts.master')

@section('content')

<!-- Show remove reason RFI -->
<div class="modal fade" id="hold_reason_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

<div class="container-fluid">

	<div class="card shadow">
    <div class="card-header"> 
      <h2 class="card-title">Select Items</h2>
      <div class="float-sm-right">
        <a href="{{ '/manager_view' }}" class="btn btn-secondary btn-sm">Back</a>
      </div>
    </div>

    <div class="card-body">
      <h5><strong>{{ "Site - ".App\SiteName::find($data[0]->site_name)->name }}</strong></h5>
      <div class="row">
        <div class="form-group col-md-6">
           <h5>User Name - {{ $data[0]->username->name }}</h5>
           <h5>Email - {{ $data[0]->username->email }}</h5> 
        </div>
        <div class="form-group col-md-6">
           <h5>Generate Dt. - {{date('d-m-Y', strtotime( $data[0]->request_date ))}}</h5>               
           <h5>Expect Dt. - {{date('d-m-Y', strtotime( $data[0]->expected_date ))}}</h5>               
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Sno</th>
                <th>Item Number</th>
                <th>Name</th>
                <th>R-Qty</th>
                <th>Description</th>
                <th>Status</th>
              </tr>
            </thead>                    
            <tbody>
              @php $i=1; @endphp
             
              @foreach($data as $res)
             
              <tr>
              <td>{{ $i++ }}</td>
              <input type="hidden" name="id[]" value="{{$res->id}}">
              <input type="hidden" name="item_no[]" value="{{ $res->item_no }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}">
              <input type="hidden" name="item_name[]" value="{{ $res->item_name }}" class="form-control item_name" readonly="" id="{{ "item_".$i }}">
              <td><span>{{ $res->item_no }}</span></td>
              <td>{{ $res->item_name }}</td>
              <td><span>{{ $res->quantity }}</span></td>              

              <td>{{ $res->description }}</td>
             
              <td><button type="button" class="btn btn-primary btn-sm show_hold_request" value="{{$res->hold_reason}}">Hold</button></td>
              
              </tr>

              @endforeach
                                   
            </tbody>
          </table>                         
        </div>
      </div>
     
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // show Hold rfi reason 
    $('.show_hold_request').click(function(e){
      e.preventDefault();
      var hold_reason = $(this).val();
      
      $('#hold_reason').val(hold_reason);

      $('#hold_reason_show').modal('show');

    });
  });
</script>
@endsection

