@extends('../layouts.master')
@section('content')

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   	<div class="modal-header">
        <h5 class="modal-title">Update Vendor Record</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
      <div class="modal-body">
        	<span id="vendor_id"></span>
          <form action="{{url('edit_vendor_quotation')}}" method="POST">
          @csrf	
          <input type="hidden" name="rfq_no" id="rfq_no">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label class="control-label col-md-4">Company : </label>
            <div class="col-md-12">
             <input type="text" name="company" id="company" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Person email : </label>
            <div class="col-md-12">
             <input type="text" name="person_email" id="person_email" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Address : </label>
            <div class="col-md-12">
             <input type="text" name="address1" id="address1" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">State : </label>
            <div class="col-md-12">
             <input type="text" name="state" id="state" class="form-control" />
            </div>
           </div>
            <div class="form-group">
            <label class="control-label col-md-4">City : </label>
            <div class="col-md-12">
             <input type="text" name="city" id="city" class="form-control" />
            </div>
           </div>
           <br />
           <div class="form-group" align="center">
           	<button type="submit" name="submit" class="btn btn-primary">Update</button>
           </div>
          </form>
        </div>
     </div>
    </div>
</div>

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mx-3">
          <div class="col-sm-6">
            <h4>Update <small>Quotation</small></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
              </div>              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              	<header>
				    <img src="{{asset('/'.$data->header_img)}}" class="img-fluid" style="width: 100%; object-fit: contain;" alt="Responsive image" >	
				   	</header>   

					<div class="container-fluid"> 
					    
				    <div class="row">
					    <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">Quotation</h4>
						</div>
				    <br>

				    <form action="{{route('vendor_quotation.update',$data->id)}}" method="POST">
				      {{csrf_field()}}
				      {{method_field('PATCH')}}
				      <div class="row">
				        <div class="col-6">
				          <input type="text" name="rfq_id" class="form-control" value="{{$data->rfq_id}}">
				        </div>
				        <div class="col-6">
				        	<input type="text" name="date" value="{{$data->date}}" class="form-control">
				        </div>
				      </div>
				      <br>

					    <div class="row">
				        <div class="col-md-6">
				          <h6>To,</h6>
				          	@foreach($vendors_data as $rows)
		                <tr>
		                	{{-- <h6><a href="javascript:void(0)" onclick="editVendor()">{{$rows->company}}</a> </h6> --}}
		                	<h6 class="text-primary edit" id="{{$rows->id}}">{{$rows->company}}</h6>
				            	<h6>{{$rows->person_email}}</h6>
				            	<h6>{{$rows->address1}}</h6>
				            	<h6>{{$rows->state}}</h6>
				            	<h6>{{$rows->city}}</h6>
		                </tr>
		                @endforeach
				        </div>
				      </div>
				      <br>

				      <div>
				        <div class="row">
				          <div class="col"> 
				            <strong>Sub :</strong><input type="text" name="subject" value="{{$data->subject}}" class="form-control">
				            					          
				            <!-- <textarea class="form-control" name="subject_contents">{{$data->subject_contents}}</textarea> -->
				            <p>We are in the market for procurement of following items as detailed below.</p>
				          </div>
				        </div>
				      </div>
				      

				    <div class="row">
			        <div class="col-12">
			          <div class="table-responsive">
			            <table class="table" border="2">
			              <thead style="background-color:#f2f2f2">
			                <tr>
			                   <th width="5%">S.N</th>
			                   <th>Item Name</th>                       
			                   <th width="12%">Quantity </th>
			                   <th width="10%">Unit</th>
			                   <th>Description</th>
			                   <th>Remark</th>
			                </tr>
			              </thead>
			               <tbody>
			                @php $i=1; @endphp
			                @foreach($items as $key => $row)
			                <tr>
			                  <input type="hidden" name="rfq_no[]" value="{{$row->rfq_no}}">
			                  <td>{{$i++}}</td>
			                  <td><input type="text" name="item_name[]" value="{{$row->item_name}}" class="form-control"></td>
			                  <td> <input type="text" name="quantity[]" value="{{$row->quantity}}" class="form-control"></td>
			                  <td><input type="text" name="quantity_unit[]" value="{{$row->quantity_unit}}" class="form-control"></td>
			                  <td><input type="text" name="description[]" value="{{$row->description}}" class="form-control"></td>
			                  <td><input type="text" name="remark[]" value="{{$row->remark}}" class="form-control"></td>
			                 
			                </tr>
			                @endforeach
			              </tbody>
			            </table>          
			          </div>
			        </div>
			      </div>
			      <br>

			      <div class="row">
			        <div class="col-4">
			          <strong>Delivery Date : </strong>
			          <input type="text" name="delivery_date" value="{{date('d-m-Y', strtotime($data->delivery_date))}}" class="form-control">
			        </div>
			      </div>
			      <br> 

			      <div class="row">
			        <div class="col-6">
			          <strong>Consignee / Delivery Location : </strong>
			          <textarea class="form-control" name="delivery_address">{{$data->delivery_address}}</textarea>
			          
			          <strong>Contact Person : </strong>
			          <input type="text" name="person_name" value="{{$data->person_name}}" class="form-control">
			        </div>
			      </div>
			      <br> 


			      <div class="row">
			        <div class="col-6">
			          <strong>Address : -</strong>
			          <textarea class="form-control" name="full_address">{{$data->full_address}}</textarea>
			        </div>
			      </div>
			      <br> 

			      <div class="row">
			        <div class="col-md-12">
			          <strong>Billing Address : -</strong>
			          <p>Laxyo Energy Limited,<br>
			              46/1 T.I.T Road <br>
			              Ratlam M.P. -457001 <br>
			              GSTN No.23AABCL3031E1Z9</p>              
			        </div>
			      </div>
			      <br>

			      <div class="row">
		          <div class="col-md-12">
		            <p>Kindly acknowledge the purchase order.</p>
		            <p>Thanking you,</p>
		          </div>
			      </div>
			      <br>
			      <div class="row">
		          <div class="col-md-12">
		            <h5 style="padding-bottom:2px;">For Laxyo Energy Limited</h5>
		            <img src="{{$data->sign}}" style="width: 20%;">
		            
		            <select id="sign" class="form-control" name="sign">
		            	<option value="1">Laxyo House, Indore</option>
             		<option value="2">Laxyo Tower, Ratlam</option>
           			</select>
		            <h5>(Authorized Signatory)</h5>
		          	</div>
			      	</div>
			  
			      <button type="submit" name="submit" class="btn btn-primary">Update</button>

			      </form>
			      <br>
				  	<footer>
				    	<img src="{{asset('/'.$data->footer_img)}}" style="width: 100%;">
				  	</footer>
				  </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
	  $("#sign").change(function(){
       let sign = $("#sign").val();
       
       jQuery.ajax({
       url:'/company_sign_pics_update',
       type:'get',
       data:'sign='+sign+'&_token={{csrf_token()}}',
       success:function(result){
       	
        $('#signature').attr('src',result); 
       }
       })
         // $("#b").val(a);
    });

		$(document).on('click','.edit',function(){
		  var id = $(this).attr('id');
		  $("#vendor_id").val(id);
		  jQuery.ajax({
        url:'/company_vendor_modal',
        method:'POST',
        data:'id='+id+'&_token={{csrf_token()}}',
        success:function(html){
         	$('#id').val(html.id);
         	$('#company').val(html.company);
			    $('#person_email').val(html.person_email);
			    $('#address1').val(html.address1);
			    $('#state').val(html.state);
			    $('#city').val(html.city);
			    $('#rfq_no').val(html.rfq_no);
			    $('#formModal').modal('show');
        }
      })
		});
		});

		$("edit_vendor_quotation").submit(function(e){
			e.preventDefault();
			let id = $("#id").val();
			let company = $("#company").val();
			let person_email = $("#person_email").val();
			let address1 = $("#address1").val();
			let state = $("#state").val();
			let city = $("#city").val();
			let rfq_no = $("#rfq_no").val();
			
			let _token = $("#input[name=_token]").val();

			

		});

	
</script>


@endsection