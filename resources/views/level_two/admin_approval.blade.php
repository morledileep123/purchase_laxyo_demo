@extends('../layouts.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
@section('content')
<!-- Modal Decline RFI item -->
<div class="modal fade" id="decline_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('remove_reqitem_by_admin')}}" method="POST">
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
          <button type="submit" class="btn btn-danger">Yes,Remove</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal hold items  -->
<div class="modal fade" id="hold_request_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('hold_reqitem_by_admin')}}" method="POST">
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

<!-- Show remove reason RFI -->
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
        {{-- <a href="{{ url('/export_items_excel',$data[0]->prch_rfi_id) }}" data-target="#theModal" data-toggle="modal" class="btn btn-success btn-sm">Open</a> --}}


        <a href="{{ url('/export_items_excel',$data[0]->prch_rfi_id) }}" class="btn btn-success btn-sm">Export data</a>
        <a href="{{ '/admin_view' }}" class="btn btn-secondary btn-sm">Back</a>
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

    {{-- <div id="theModal" class="modal fade text-center">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
      </div>
    </div> --}}
  
    <div class="card-body">
      <h5><strong>{{ "Site - ".App\SiteName::find($data[0]->site_name)->name }}</strong></h5>
      <div class="row">
        <div class="form-group col-md-6">
          <h5>User Name - <strong>{{ $data[0]->username->name }}</strong></h5>
          {{-- <h5>Manager Name - <strong>{{ $data[0]->manager->name }}</strong></h5> --}}
        </div>
        <div class="form-group col-md-6">
          <h5>Email - <strong>{{ $data[0]->username->email }}</strong></h5>               
          {{-- <h5>Email - <strong>{{ $data[0]->manager->email }}</strong></h5>                --}}
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <h5>Generate Dt. - <strong>{{date('d-m-Y', strtotime( $data[0]->request_date ))}}</strong></h5>           
        </div>
        <div class="form-group col-md-6">
          <h5>Expect Dt. - <strong>{{date('d-m-Y', strtotime( $data[0]->expected_date ))}}</strong></h5>               
        </div>
      </div>
      <form action="{{ route('admin_view.update',$data[0]->prch_rfi_id)}}" method="post">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-md-12">
          <div class="data_table">
            <table class="table table-bordered">
            <thead>
              <tr>
                <th>Sno</th>
                <th>Item Number</th>
                <th>Name</th>
                <th>Current Stock</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>                    
            <tbody>
              {{-- <input type="hidden" id="prchid" value="{{ $data[0]->id }}"> --}}
              @php $i=1; @endphp
             
              @foreach($data as $res)
              @if($res->dispatch_status == "1")
              <tr class="bg-light" style="color:Gray !important;">
              <td></td>
              <td>{{ $i++ }}</td>
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

              <td><span>{{ $res->m_quantity }}</span></td>                        

              <td>{{$res->description}}</td>

              <td><button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$res->dispatch_reason}}">Decline</button></td>

              </tr>


              @elseif($res->hold_status == "1")
              <tr class="bg-light" style="color:Gray !important;">
                <td></td>
                <td>{{ $i++ }}</td>
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

                <td><span>{{ $res->m_quantity }}</span></td>                        

                <td>{{$res->description}}</td>

                <td><button type="button" class="btn btn-primary btn-sm show_hide_request" value="{{$res->hold_reason}}">Hold</button></td>
              </tr>
              @else
              <tr> 
                <td>{{ $i++ }}</td>
                <input type="hidden" name="id[]" value="{{$res->id}}">
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
                
                <td><input type="text" name="m_quantity[]" value="{{ $res->m_quantity }}" class="form-control send " id=" {{"pass".$i }}" min="1"></td>

                <td><span>{{ $res->quantity_unit }}</span></td>
                
                <td>{{$res->description}}</td>

                @if($res->purchase_status == 1)
                <td class="text-primary">Purchase</td>
                @else
                <td>
                  <button type="button" class="btn btn-primary btn-sm hold_request" value="{{$res->id}}">Hold</button>
                  <button type="button" class="btn btn-danger btn-sm remove_request" value="{{$res->id}}">Decline</button>
                  
                </td>
                @endif

              </tr>
              @endif
              @endforeach
                                   
            </tbody>
          </table> 
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">

            {{-- <button class="btn btn-success" id="puch_status" href="{{url('purchase_reqitem_by_admin',$data[0]->prch_rfi_id)}}">Purchase</button> --}}
             
          </div>
                      
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

    //  Hold item rfi 
    $('.hold_request').click(function(e){
      e.preventDefault();
      var hold_id = $(this).val();
      $('#hold_id').val(hold_id);

      $('#hold_request_item').modal('show');

    });

    // show Hide rfi reason 
    $('.show_hide_request').click(function(e){
      e.preventDefault();
      var hide_reason = $(this).val();
      
      $('#hide_reason').val(hide_reason);

      $('#hide_request_show').modal('show');

    });



    $(".puch_status").click(function(e){
      e.preventDefault();
      var prch_id = $(this).val();

      jQuery.ajax({
      url:'/purchase_reqitem_by_admin',
      type:'get',
      data:'prch_id='+prch_id+'&_token={{csrf_token()}}',
      success:function(result){
        location.reload();
      }
      })
         // $("#b").val(a);
    });





});
</script>
@endsection

