<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Purchase Order</title>
  </head>
  <body>


  <!-- Modal Delete -->
	<div class="modal fade" id="decline_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <form action="{{url('remove_req_purchase_order')}}" method="POST">
	      @csrf
	      <div class="modal-content">
	        <div class="modal-header">
	          <p class="modal-title" id="exampleModalCenterTitle">Decline Reason</p>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
	            <input type="hidden" name="id" value="{{$data->id}}">
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

  	<div class="wrapper">
  
	  <nav class="navbar navbar-light bg-light justify-content-between" style="background-color: #fff;">
		  <div class="container">
			<div class="ad">
		  	<form action="{{url('approve_req_purchase_order')}}" style="float: left; margin-right: 6px;" method="POST">
	      @csrf
	      <input type="hidden" name="id"  value="{{$data->id}}" class="btn btn-success">
	      <button type="submit" name="submit" class="btn btn-success" value="submit" style="color:white">Approve</button>
	    	</form>

		  	<a type="button" class="btn btn-danger" id="remove_request" value="{{$data->id}}" style="color:white;">Decline</a>
		  </div>
	  	<a href="/">
        <img src="{{asset('assets/img/laxyo_pic.png')}}" class="thumbnail img-responsive" alt="Laxyo Energy LTD" style="max-width: 60%;">
      </a>

		  <div class="form-inline">
		    <div class="btn-group">
		    	<button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
          </button>
          <div class="dropdown-menu">                           
            <a class="dropdown-item" href="javascript:printdoc();" onclick="window.print()" href="#"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
            <a class="dropdown-item" href="{{url('pdf_download',$data->id )}}">Generate PDF</a>
            <a class="dropdown-item" href="{{route('purchase.edit',$data->id )}}"><i class="fa fa-edit" aria-hidden="true"></i>Edit Purchase Order</a>
          </div>
           <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Back</a>
        </div>
		    
		  </div>
		  </div>
		</nav>
	  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section>
      <div class="container">
        <div class="row my-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding:0px;">
                <header>
						     <img src="{{asset('assets/img/po_header_img.png')}}" style="width: 100%; object-fit: contain;" >	
						   	</header> 
						    
				      <div class="container-fluid">
				      	<div class="row">
				        <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">Purchase Order</h4>
				      </div>
				      <br>

				      <div class="row">
				        <div class="col">
				          <h5>PO No : {{$data->code}}&nbsp;</h5>
				        </div>
				        <div class="col" style="margin-right:20px;">
				          <p class="float-right">Date : {{$data->date}}</p>
				        </div>
				      </div>
				      <br>

				      <div class="row">
				        <div class="col-md-6">
				          <h6>To,</h6>
				            <h6>{{$data->vender_detail}}</h6>
				       
				            <h6>{{$data->vendor_details_company}}</h6>
				            <h6>{{$data->vendor_details_company_email}}</h6>
				            <h6>{{$data->vendor_details_company_mobile}}</h6>
				            <h6>{{$data->vendor_details_city}}</h6>
				            <h6>{{$data->vendor_details_state}}</h6>
				            <h6>{{$data->vendor_details_pin}}</h6>
				            <h6>{{$data->vendor_details_person_email}}</h6>
				        </div>
				      </div>
				      <br>

				   
			        <div class="row">
			          <div class="col"> 
			            <p><strong>Sub : </strong>{{$data->subject}}</p>
			            @if($data->quotation_no != null)
			              <p><strong>Reference : </strong>{{$data->quotation_no}}</p> 
			            @endif
			            <p>Dear Sir, <br>{{$data->subject_contents}}</p>
			          </div>
			        </div>
				   
				      <div class="row">
				      	<div class="col-12">
				      <div class="table-responsive">
			          <table class="table" border="2">
			            <thead>
			              <tr>
			              	 <th>S no</th>
			                 <th>Item Name</th>
			                 <th>Description</th>
			                 <th>Unit</th>
			                 <th>Qty</th>
			                 <th>Rate</th>
			                 <th>Tax(%)</th>
			                 <th>Discount</th>
			                 <th>Amount</th>
			                 <th>Comment</th>
			              </tr>
			            </thead>
			            <tbody>
			            	@php $i=1; @endphp
			              @foreach($items as $key => $row)
			                <tr>
			                	<td>{{$i++}}</td>
			                  <td>{{$row->invoice_product}}</td>
			                  <td>{{$row->description}}</td>
			                  <td>{{$row->quantity_unit}}</td>
			                  <td>{{$row->product_qty}}</td>
			                  <td>{{$row->product_price}}</td>
			                  <td>{{$row->product_tax}}</td>
			                  <td>{{$row->product_discount}}</td>
			                  <td>{{$row->product_subtotal}}</td>
			                  <td>{{$row->comment}}</td>
			                </tr>
			              @endforeach
			            </tbody>
			          </table>          
				      </div>
				    	</div>
				      </div>
					   

				      <div class="row">
				          <div class="col-7">
				            <strong>Payment Terms and Condition</strong>
				            <p>{{$data->terms1}}</p>
				            <p>{{$data->terms2}}</p>
				            <p>{{$data->terms3}}</p>
				            <strong>Guarantee And Warranty</strong>
				            <p>{{$data->guarantee}}</p>
				          </div>
				         
			            <div class="col-5 float-right">
			            {{-- <p style="margin-left:80px;"><strong>Sub Total</strong>&nbsp; : &nbsp; {{$data->invoice_subtotal}}</p>
			            <p style="margin-left:80px;"><strong>Total Tax</strong>&nbsp; : &nbsp; {{$data->invoice_discount}}</p> --}}
			            <p style="margin-left:80px;"><strong>Final Amount</strong>&nbsp; : &nbsp; {{$data->grand_total}}</p>
			            <p style="margin-left:80px;"><strong>Final Amount In words</strong>&nbsp; : &nbsp; <br>{{$data->amount_rupees}}</p>
			            </div>
				          
				      </div>

				      <br> 

				      <div class="row">
				        <div class="col-12">
				          <p><strong>Delivery Date : </strong> {{date('d-m-Y', strtotime($data->delivery_date))}}</p>
				        </div>
				      </div>
				      <br> 

				      <div class="row">
				        <div class="col-12">
				          <strong>Consignee / Delivery Location : </strong>
				          <p>{{$data->delivery_address}}</p>
				          <strong>Contact Person : </strong>
				          <p>{{$data->perosn_name}}</p>
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
				            <h5 style="padding-bottom:12px;">For Laxyo Energy Limited</h5>
				            <img src="{{asset('/'.$data->sign)}}" alt="signn" style="width: 20%;">
				            <h5>(Authorized Signatory)</h5>
				          </div>
				      </div>
				      
				       <br>
				       <br>
				      </div>
					  <footer>
					    <img src="{{asset('assets/img/po_footer_img.png')}}" style="width: 100%;">
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

    
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){

    //  remove rfi 
    $('#remove_request').click(function(e){
    	
      e.preventDefault();
      jQuery.noConflict();
      var id = $(this).val();
      
      $('#id').val(id);

      $('#decline_request').modal('show');

    });
});
</script>

</body>
</html>