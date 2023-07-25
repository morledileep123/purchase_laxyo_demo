@extends('../layouts.master')

@section('content')
<!-- Modal remove items decline -->
<div class="modal fade" id="decline_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('remove_reqitem')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="exampleModalCenterTitle">Decline Reason</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <textarea name="dispatch_reason" class="form-control" rows="5%" placeholder="Reason .."></textarea>          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-sm">Yes,Remove</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Update expected delivery date -->
{{-- <div class="modal fade" id="update_delivery_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('remove_reqitem')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="exampleModalCenterTitle">Decline Reason</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" name="id" id="id">
            <input type="date" class="form-control" value="{{ $data[0]->expected_date }}" id="expected_date" name="expected_date">           
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-sm">Yes,Remove</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div> --}}
<div class="modal fade" id="update_delivery_date" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Expected Delivery Date</h5>
      </div>
      <div class="modal-body">
        <form action="{{url('/update_delivery_date')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="form-group col-md-12">
              <input type="hidden" name="id" value="{{ $data[0]->id }}">
              <label>Delivery Date</label>
              <input type="date" class="form-control" value="{{ $data[0]->expected_date }}" id="expected_date" name="expected_date">              
            </div>                      
          </div>
          <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal hold items  -->
<div class="modal fade" id="hold_request_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('hold_reqitem')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="exampleModalCenterTitle">Hold Reason</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="hold_id" id="hold_id">
          <textarea name="hold_reason" class="form-control" rows="5%" placeholder="Reason .."></textarea> 
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Yes,Hold</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

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

  <div class="card shadow">
    <div class="card-header"> 
      <h2 class="card-title">Select Items</h2>
      <div class="float-sm-right">
        <a href="{{ '/manager_view' }}" class="btn btn-secondary btn-sm">Back</a>
      </div>
    </div>

    <div class="container mt-2">
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
  
    <div class="card-body">
      <h5>{{ "Site - ".App\SiteName::find($data[0]->site_name)->name }}</h5>
      <div class="row">
        <div class="form-group col-md-6">
          <h5>User Name - {{ $data[0]->username->name }}</h5>
          <h5>Generate Dt. - {{date('d-m-Y', strtotime( $data[0]->request_date ))}}</h5> 
        </div>
        <div class="form-group col-md-6">
          <h5>Email-id - {{ $data[0]->username->email }}</h5>  
          <h5>Expected delivery Dt. - {{date('d-m-Y', strtotime( $data[0]->expected_date ))}} <a class="btn btn-primary btn-xs update_delivery_date"  value="{{$data[0]->id}}"> Update</a> </h5>  
        </div>
      </div>
      <form action="{{ route('manager_view.update',$data[0]->prch_rfi_id)}}" method="post">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-md-12 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="1%">S.No</th>        
                <th width="12%">Item Number</th>
                <th>Name</th>
                <th width="10%">Current Stock</th>
                <th width="10%">R-Qty</th>
                <th width="12%">Approve Qty</th>
                <th>Description</th>
                <th width="10%">Img</th>
                <th width="5%">Action</th>
              </tr>
            </thead>                    
            <tbody>
              <input type="hidden" id="prchid" value="{{ $data[0]->prch_rfi_users_id }}">
              @php $i=1; @endphp
             
              @foreach($data as $res)
              @if($res->hold_status == "1")

              <tr class="bg-light" style="color:Gray !important;">
              <td>{{ $i++ }}</td>
              <td><span>{{ $res->item_no }}</span></td>
              <td>{{ $res->item_name }}</td>
              <td>
                @php $j=0; @endphp
                @foreach($mem as $row)
                  @if($row->isEmpty())
                    <span style="color:red;">N/A</span>                     
                  @else
                    @php echo "$row[$j]"; @endphp                                
                  @endif                            
                @endforeach
              </td>
              <td><span>{{ $res->quantity }}</span></td>

              <td><span>{{ $res->quantity }}</span></td>                        

              <td>{{$res->description}}</td>


              <td><img src="{{asset($res->rfi_image)}}" class="show_img_request" value="{{$res->decline_reason}}" width="100%"></td>
             

              <td>
                <button type="button" class="btn btn-warning btn-sm show_hide_request" value="{{$res->hold_reason}}">Hold</button>

              </td>
              </tr>
              @elseif($res->dispatch_status == "1")

              <tr class="bg-light" style="color:Gray !important;">
              <td>{{ $i++ }}</td>
              <td><span>{{ $res->item_no }}</span></td>
              <td>{{ $res->item_name }}</td>
              <td>
                @php $j=0; @endphp
                @foreach($mem as $row)
                  @if($row->isEmpty())
                    <span style="color:red;">N/A</span>                     
                  @else
                    @php echo "$row[$j]"; @endphp                                
                  @endif                            
                @endforeach
              </td>
              <td><span>{{ $res->quantity }}</span></td>

              <td><span>{{ $res->quantity }}</span></td>                        

              <td>{{$res->description}}</td>
              
              <td><img src="{{asset($res->rfi_image)}}" class="show_img_request" value="{{$res->decline_reason}}" width="100%"></td>
             
              <td>
                <button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$res->dispatch_reason}}">Reason</button>
              </td>
              </tr>

              @else
              <tr>
              <td>{{ $i++ }}</td>
              <input type="hidden" name="id[]" value="{{$res->id}}">
              <input type="hidden" name="item_code[]" value="{{$res->item_code}}">
              <input type="hidden" name="item_no[]" value="{{ $res->item_no }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}">
              <input type="hidden" name="item_name[]" value="{{ $res->item_name }}" class="form-control item_name" readonly="" id="{{ "item_".$i }}">
              <td><span>{{ $res->item_no }}</span></td>
              <td>{{ $res->item_name }}</td>
              <td>
                @php $current_stock = App\item::where('item_number',$res->item_no)->pluck('current_stock')->first() @endphp 
               
                @if(is_null($current_stock))
                  <span style="color:red;">N/A</span> 
                @else 
                 @php echo "$current_stock"; @endphp                                
                @endif
              </td>
              <td><span>{{ $res->quantity }}</span></td>

              <td><input type="text" name="m_quantity[]" value="{{ $res->quantity }}" class="form-control send " id=" {{"pass".$i }}" min="1"></td>

              <td>{{$res->description}}</td>

             
              <td><img src="{{asset($res->rfi_image)}}" class="show_img_request" value="{{$res->decline_reason}}" width="100%"></td>
             
              
              <td>
                <button type="button" class="btn btn-warning btn-xs hold_request" value="{{$res->id}}">Hold</button>
                <button type="button" class="btn btn-danger btn-xs remove_request" value="{{$res->id}}">Remove</button>
              </td>
              
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

    //  remove item rfi 
    $('.remove_request').click(function(e){
      e.preventDefault();
      var id = $(this).val();
      
      $('#id').val(id);

      $('#decline_request').modal('show');

    });

    //  Hold item rfi 
    $('.hold_request').click(function(e){
      e.preventDefault();
      var hold_id = $(this).val();
      $('#hold_id').val(hold_id);

      $('#hold_request_item').modal('show');

    });

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
      alert(hide_reason);
      
      $('#hide_reason').val(hide_reason);

      $('#hide_request_show').modal('show');

    });

    // update delivery date 

    $('.update_delivery_date').click(function(e){
      e.preventDefault();
      var id = $(this).val();
      $('#id').val(id);

      $('#update_delivery_date').modal('show');

    });
  });
</script>
@endsection
