@extends('../layouts.master')

@section('content')

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

<div class="container-fluid">


<div class="card shadow">
    <div class="card-header"> 
      <h2 class="card-title">Select Items</h2>
      <div class="float-sm-right">
        <a class="btn btn-success export_all btn-sm">Export data</a>
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
  
    <div class="card-body">
      <h5><strong>{{ "Site - ".App\SiteName::find($data[0]->site_name)->name }}</strong></h5>
      <div class="row">
        <div class="form-group col-md-6">
          <h5>User Name - <strong>{{ $data[0]->username->name }}</strong></h5>
          <h5>Manager Name - <strong>{{ $data[0]->manager->name }}</strong></h5>
        </div>
        <div class="form-group col-md-6">
          <h5>Email - <strong>{{ $data[0]->username->email }}</strong></h5>               
          <h5>Email - <strong>{{ $data[0]->manager->email }}</strong></h5>               
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
  
      <div class="row">
        <div class="col-md-12">
          <div class="data_table">
            <table class="table table-bordered">
            <thead>
              <tr>
                <th><input type="checkbox" id="master" class="sub_chk" data-id=""></th>
                <th>Sno</th>
                <th>Item Number</th>
                <th>Name</th>
                <th>Current Stock</th>
                <th>Send Qty</th>
                <th>Description</th>
                <th>Status</th>
                
              </tr>
            </thead>                    
            <tbody>
              <input type="hidden" id="prchid" value="{{ $data[0]->prch_rfi_users_id }}">
              @php $i=1; @endphp
             
              @foreach($data as $res)
              
              <tr>
              <td><input type="checkbox" class="sub_chk" data-id="{{$res->prch_rfi_id}}"></td> 
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
             
              <td>{{ $res->m_quantity }}</td>
              
              <td>{{ $res->description }}</td>

              @if( $res->dispatch_status == 1 )
              <td><button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$res->dispatch_reason}}">Reason</button></td>
              @elseif($res->admin_approve == 1 && $res->admin_status == 1)
              <td class="text-success">Approve</td>
              @elseif($res->purchase_status == 1)
              <td class="text-primary">Purchase</td>
              @else
              <td >Something Wrong</td>
              @endif

              </tr>
              
              @endforeach
                                   
            </tbody>
          </table> 
             
          </div>
                      
        </div>
      </div>
	</div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){

  $('#master').on('click', function(e){  
    if($(this).is(':checked',true))    
    {  
      $(".sub_chk").prop('checked', true);    
    } else {    
      $(".sub_chk").prop('checked',false);    
    }    
  }); 

  $('.export_all').on('click', function(e) {
      
      var allVals = [];  
      
      $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
      });  

      if(allVals.length <=0)  
      {  
        alert("Please select Check Box.");  
      }else {  
        // var check = confirm("Are you sure you want to delete this row?");  

        var ids = allVals.join(","); 
        
        $.ajax({
          url:'/rfi_items_export',
          method:"POST",
          data:'ids='+ids+'&_token={{csrf_token()}}',
          success:function(response){
            console.log(response.data);
            // if(response.data){
            //   alert("OK");
            // }else{
            //   $("#location").empty();
            // }
          },
          error: function (data) {
            alert(data.responseText);
          }
        });

        $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
        });
          
      }  
    });


    // if(data['success']) {
    //   $(".sub_chk:checked").each(function(){  
    //       // $(this).parents("tr").remove();
    //   });
    //   alert(data['success']);
    // }else if (data['error']){
    //   alert(data['error']);
    // }else {
    //   alert('Whoops Something went wrong!!');
    // }

    // -------------------- 

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

