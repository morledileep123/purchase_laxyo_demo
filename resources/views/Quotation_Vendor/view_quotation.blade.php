<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Purchase Order</title>
  </head>
  <body>

  	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header" style="padding-bottom: 0px;">
	        	<p>Send Purchase Order </p>
	          <button type="button" class="close" data-dismiss="modal">×</button>
	        </div>
	        <form action="{{url('send_Quotation_mail')}}" method="POST">
	        	@csrf
	        <div class="modal-body">
	        	<h6>To <span style="color:red">*</span></h6> 
	        	<input type="hidden" name="id" value="{{$data->id}}">
	        	{{-- <input type="text" name="vendor_details_company_email" value="{{$data->vendor_details_company_email}}" class="form-control" readonly> --}}
	        	@foreach($vendors_data as $rows)
              <tr>
              	<input type="hidden" name="person_email[]" value="{{$rows->person_email}}">
              	<h6>{{$rows->company}} - {{$rows->person_email}}</h6>
	            </tr>
            @endforeach
	        	<br>
	        	<h6>Subject <span style="color:red">*</span></h6>
	        	<input type="text" name="subject" value="{{$data->subject}}" class="form-control" readonly>
	          <br>
	          <div id="show_hide" style="display:none;">
		          <div class="row" id="add_input_row">
			          <div class="col-12">
			          	CC
			          	<button class="btn btn-success btn-sm float-right" id="add-row">Add</button>
			        	</div>
			        	<div class="col-md-12 mt-2 addrow" style="display:inline-flex;">
			          	<input type="email" name="send_cc[]" class="form-control" style="margin-right: 6px;">
			          	<button class="btn btn-danger btn-sm float-right" id="delete-row">X</button>
			          </div>
		          </div>
		          <br>
		          BCC
		          <input type="text" name="send_bcc" class="form-control" placeholder="">
	          </div><br>
	          Message
	          <textarea type="text" name="message" class="ckeditor form-control" placeholder="About Messgae"></textarea> 
	        </div>
	        <div class="modal-footer" style="justify-content: space-between;">
	        	<button type="button" class="btn btn-default btn-sm" id="ShowHide">CC/BCC show/hide</button>
	          <button type="submit" class="btn btn-primary btn-sm">Send Email</button>
	        </div>
	      	</form>
	      </div>
	      
	    </div>
	  </div>

  	<div class="wrapper">
  
	  <nav class="navbar navbar-light bg-light justify-content-between" style="background-color: #fff;">
		  <div class="container">
		  	<button type="button" class="btn btn-success send_purchase_order" value="{{$data->id}}" style="color:white">Send Email to Vendor</button>
		  	<a href="/">
	        <img src="{{asset('assets/img/laxyo_pic.png')}}" class="thumbnail img-responsive" alt="Laxyo Energy LTD" style="max-width: 60%;">
	      </a>

			  <div class="form-inline">
			    <div class="btn-group">
			    	<button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
	          </button>
	          <div class="dropdown-menu">                           
	           <a class="dropdown-item" href="{{route('vendor_quotation.edit',$data->id )}}"><i class="fa fa-edit" aria-hidden="true"></i>Edit Purchase Order</a>
	           </div>
	           <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Back</a>
	        </div>
			    
			  </div>
		  </div>
		</nav>
	  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section>
      <div class="container my-3">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding:0px;">
                <header>
				     <img src="{{asset('/'.$data->header_img)}}" style="width: 100%; object-fit: contain;" >	
				   	</header> 
						    
				      <div class="container-fluid">
				      	<div class="row">
				        <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">Quotation</h4>
				      	</div>
				      	<br>

				      <div class="row ml-4">
				        <div class="col">
				          <h5>Quotation No : {{$data->rfq_id}}&nbsp;</h5>
				        </div>
				        <div class="col" style="margin-right:60px;">
				          <p class="float-right">Date : {{$data->date}}</p>
				        </div>
				      </div>
				      <br>

				      <div class="row ml-4">
				        <div class="col-md-6">
				          <h6>To,</h6>
				          	@foreach($vendors_data as $rows)
		                <tr>
		                	<h6><a href="{{url('quotation_pdf_download',[$rows->id, $data->id] )}}">{{$rows->company}}</a></h6>
		                	<!-- <h6 class="text-primary">{{$rows->company}}</h6> -->
				            	<h6>{{$rows->person_email}}</h6>
				            	<h6>{{$rows->address1}}</h6>
				            	<h6>{{$rows->state}}</h6>
				            	<h6>{{$rows->city}}</h6>
		                </tr>
		                @endforeach
				        </div>
				      </div>
				      <br>
				      {{--  <div class="row">
				        <div class="col-md-6">
				          <h6>To,</h6>
				            <h6>{{$vendors_data->company}}</h6>
				            <h6>{{$vendors_data->person_email}}</h6>
				            <h6>{{$vendors_data->address1}}</h6>
				            <h6>{{$vendors_data->state}}</h6>
				            <h6>{{$vendors_data->city}}</h6>
				        </div>
				      </div>
				      <br> --}}
				   
			        <div class="row ml-4">
			          <div class="col"> 
			            <p><strong>Sub : </strong>{{$data->subject}}</p>
            			<p>Dear Sir,</p>
            			<p>We are in the market for procurement of following items as detailed below.</p>
			          </div>
			        </div>
				   
							<div class="row">
				        <div class="col-12">
				          <div class="table-responsive">
				            <table class="table" border="2">
				              <thead style="background-color:#f2f2f2">
				                <tr>
				                   <th width="6%">S.N</th>
				                   <th>Item Name</th>                       
				                   <th>Quantity </th>
				                   <th width="8%">Unit</th>
				                   <th width="13%">Description</th>
				                   <th>Remark</th>
				                </tr>
				              </thead>
				               <tbody>
				                @php $i=1; @endphp
				                @foreach($items as $key => $row)
				                <tr>
				                  <td>{{$i++}}</td>
				                  <td>{{$row->item_name}}</td>
				                  <td>{{$row->quantity}}</td>
				                  <td>{{$row->quantity_unit}}</td>
				                  <td>{{$row->description}}</td>
				                  <td>{{$row->remark}}</td>
				                </tr>
				                @endforeach
				              </tbody>
				            </table>          
				          </div>
				        </div>
				      </div>
				      <br>
					   

				      <div class="row ml-4">
				        <div class="col-12">
				          <p><strong>Delivery Date :  </strong>{{$data->delivery_date}}</p>
				        </div>
				      </div> 

				      <div class="row ml-4">
				        <div class="col-12">
				          <strong>Consignee / Delivery Location : </strong>
				          <p>{!! nl2br(e($data->delivery_address)) !!}</p>
				          <strong>Contact Person : </strong>
				          <p>{{$data->person_name}}</p>
				        </div>
				      </div> 

				      <div class="row ml-4">
				        <div class="col-md-12">
				          <strong> Address : </strong>
				          <p>{!! nl2br(e($data->full_address)) !!}</p>              
				        </div>
				      </div>				     

				      <div class="row ml-4">
				        <div class="col-md-12">
				          <strong>Billing Address : </strong>
				          <p>Laxyo Energy Limited,<br>
				              46/1 T.I.T Road <br>
				              Ratlam M.P. -457001 <br>
				              GSTN No.23AABCL3031E1Z9</p>              
				        </div>
				      </div>
				      

				      <div class="row ml-4">
			          <div class="col-md-12">
			            <p>Kindly acknowledge the purchase order.</p>
			            <p>Thanking you,</p>
			          </div>
				      </div>
				      				      
				      <div class="row ml-4">
			          <div class="col-md-12">
			            <h5>For Laxyo Energy Limited</h5>
			             <img src="{{asset('/'.$data->image)}}" style="width: 20%;">
			            <h5>(Authorized Signatory)</h5>
			          </div>
				      </div>
				      
				       <br>
				       <br>
				      </div>
					  <footer>
					    <img src="{{asset('/'.$data->footer_img)}}" style="width: 100%;">
					  </footer>
							 
              	</div>
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
   
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


</div>
<!-- ./wrapper -->

	<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
    
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

  <script>
  $(document).ready(function(){

  	$(document).on('click','.send_purchase_order',function(){
  		var po_id = $(this).val();

  		$('#myModal').modal('show');

  		$(document).on('click','#ShowHide',function(){
	  		
	  		$('#show_hide').toggle('show');
	  		
	  	});

	  	// remove product row
	    $('#add_input_row').on('click', "#delete-row", function(e) {
	      e.preventDefault();
	         $(this).closest('.addrow').remove();
	    });

	    // add new product row on invoice
	    var cloned = $('#add_input_row .addrow:last').clone();
	    $("#add-row").click(function(e) {
	        e.preventDefault();
	        cloned.clone().appendTo('#add_input_row'); 
	    });
  		
  		$('.ckeditor').ckeditor();
  	});
  });
</script>

  </body>
  </html>


