@extends('../layouts.master')

@section('content')
<!-- Modal Delete -->
<div class="modal fade" id="decline_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('remove_reqitem')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="exampleModalCenterTitle">Decline Request</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <textarea name="remove_reason" class="form-control" rows="5%" placeholder="Reason .."></textarea>          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Yes,Remove</button>
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
          <p class="modal-title" id="exampleModalCenterTitle">Decline Request</p>
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

<div class="container-fluid">
<div class="container">
  @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success ! </strong> {{ session('success') }}
    </div>
  @endif

  @if (Session::has('success_mail'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success ! </strong> {{ session('success_mail') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Please Give Reason .. </strong>
    </div>
  @endif

  @if (Session::has('delete'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Success ! </strong> {{ session('delete') }}
    </div>
  @endif
</div>

<div class="card shadow">
    <div class="card-header"> 
        <h2 class="card-title">Select Items</h2>
        <div class="float-sm-right">
            <a href="{{ '/user_request' }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
  
    <div class="card-body">
        <h5><strong>{{ "Site - ".App\SiteName::find($data[0]->site_id)->name }}</strong></h5>
        <div class="row">
            <div class="form-group col-md-6">
                <h5><label>User Name - </label>{{ $data[0]->username->name }}</h5>
            </div>
            <div class="form-group col-md-6">
                <h5><label>Email - </label>{{ $data[0]->username->email }}</h5>               
            </div>
        </div>
        <form action="{{ route('filter_dis_quo',$data[0]->prch_rfi_users_id)}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Item Number</th>
                            <th>Name</th>
                            <th>Current Stock</th>
                            <th>R-Qty</th>
                            <th>Send Qty</th>
                            <th>Expect Dt.</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>                    
                    <tbody>
                        <input type="hidden" id= "prchid" value="{{ $data[0]->prch_rfi_users_id }}">
                        @php $i=1; @endphp
                       
                        @foreach($data as $res)
                        @if($res->remove_item_status == 0)
                        <tr>
                        <td>{{ $i++ }}</td>
                        <input type="hidden" name="id[]" value="{{$res->id}}">
                        <input type="hidden" name="item_no[]" value="{{ $res->item_no }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}">
                        <input type="hidden" name="item_name[]" value="{{ $res->item_name }}" class="form-control item_name" readonly="" id="{{ "item_".$i }}">
                        <td><span>{{ $res->item_no }}</span></td>
                        <td>{{ $res->item_name }}</td>
                        <td>
                            @php $j=0; @endphp
                            @foreach($mem as $row)
                            
                                @if($row->isEmpty())
                                   @php echo " N/A "; @endphp                    
                                @else
                                     @php echo "$row[$j]"; @endphp                                
                                @endif                              
                               
                            @endforeach
                        </td>
                        <td><span>{{ $res->quantity }}</span></td>

                        <td><input type="text" name="squantity[]" value="{{ $res->quantity }}" class="form-control send" id=" {{"pass".$i }}" min="1"></td>
                        
                        <td>{{ $res->expected_date }}</td>

                        <td>status</td>

                        <td><button type="button" class="btn btn-danger remove_request" value="{{$res->id}}">Remove</button></td>
                        
                        </tr>

                        @else
                        <tr class="bg-light" style="color:Gray !important;">
                        <td>{{ $i++ }}</td>
                        <td><span>{{ $res->item_no }}</span></td>
                        <td>{{ $res->item_name }}</td>
                        <td>
                            @php $j=0; @endphp
                            @foreach($mem as $row)
                                @if($row->isEmpty())
                                   @php echo " N/A "; @endphp                    
                                @else
                                     @php echo "$row[$j]"; @endphp                                
                                @endif                            
                            @endforeach
                        </td>
                        <td><span>{{ $res->quantity }}</span></td>

                        <td><span>{{ $res->quantity }}</span></td>                        

                        <td>{{ $res->expected_date }}</td>

                        <td style="color:red;">Decline</td>  

                        <td><button type="button" class="btn btn-danger show_remove_request" value="{{$res->remove_reason}}">Reason</button></td>
                        </tr>
                        @endif
                        @endforeach
                                           
                    </tbody>
                </table> 
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">                
            </div>
        </div>
        </form>
	</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.send').on('blur', function(){
        var idnos = $(this).attr('id');
        var n = Array.from(idnos);
        var item_no = $("#item_"+n[5]).val();
        var prchid = $("#prchid").val();
        $.ajax({
            url: "{{ route('getstore_info')}}",
            type: 'GET',
            data: {'item_no':item_no,'prchid':prchid},
            success: function (data) {
             console.log(data);          
            }
        })    
    });

    //  remove rfi 
    $('.remove_request').click(function(e){
      e.preventDefault();
      var id = $(this).val();
      
      $('#id').val(id);

      $('#decline_request').modal('show');

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

