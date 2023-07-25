@extends('../layouts.master')
@section('content')

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mx-3">
          <div class="col-sm-6">
            <h4>Update <small>Purchase Order</small></h4>
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
					     <img src="{{asset('assets/img/po_header_img.png')}}" class="img-fluid" style="width: 100%; object-fit: contain;" alt="Responsive image" >	
					   	</header>   

						 	<div class="container-fluid"> 
						    
					      <div class="row">
						      <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">Purchase Order</h4>
						    </div>
					      <br>

					      <form action="{{url('update_PO',$data->id)}}" method="Post">
					      @csrf
					      <div class="row">
					        <div class="col-6">
					          <input type="text" name="code" class="form-control" value="{{$data->code}}">
					        </div>
					        <div class="col-6">
					        	<input type="text" name="date" value="{{$data->date}}" class="form-control">
					        </div>
					      </div>
					      <br>

					      <div class="row">
					        <div class="col-md-6">
					          <h6>To,</h6>
					          @if($data->vender_detail != '')
					       
					            <input type="text" name="vender_detail" value="{{$data->vender_detail}}" class="form-control">
					          @else

					            <input type="text" name="vendor_details_company" value="{{$data->vendor_details_company}}" class="form-control">
					            <input type="text" name="vendor_details_company_email" value="{{$data->vendor_details_company_email}}" class="form-control">
					            <input type="text" name="vendor_details_company_mobile" value="{{$data->vendor_details_company_mobile}}" class="form-control">
					            <input type="text" name="vendor_details_city" value="{{$data->vendor_details_city}}" class="form-control">
					            <input type="text" name="vendor_details_state" value="{{$data->vendor_details_state}}" class="form-control">
					            <input type="text" name="vendor_details_pin" value="{{$data->vendor_details_pin}}" class="form-control">
					            <input type="text" name="vendor_details_person_email" value="{{$data->vendor_details_person_email}}" class="form-control">
					          @endif

					        </div>
					      </div>
					      <br>

					      <div>
					        <div class="row">
					          <div class="col"> 
					            <strong>Sub :</strong><input type="text" name="subject" value="{{$data->subject}}" class="form-control">
					            <br>
					            <strong>Reference : </strong><input type="text" name="quotation_no" value="{{$data->quotation_no}}" class="form-control"> 
					            <br>
					          
					            <textarea class="form-control" name="subject_contents">{{$data->subject_contents}}</textarea>

					          </div>
					        </div>
					      </div>
					      <br>
					      <div class="row table-responsive">
				          <table class="table" border="2">
				            <thead>
				              <tr>
				                 <th width="10%">Item Name</th>
				                 <th width="10%">Description</th>
				                 <th width="5%">Unit</th>
				                 <th width="5%">Qty</th>
				                 <th width="4%">Rate</th>
				                 <th width="4%">Tax(%)</th>
				                 <th width="5%">Dis</th>
				                 <th width="5%">Amount</th>
				                 <th width="10%">Comment</th>
				              </tr>
				            </thead>
				            <tbody>
				              @foreach($items as $key => $row)
				                <tr>
				                	 <input type="hidden" name="order_id[]" value="{{$row->order_id}}">
				                  <td><input type="text" name="invoice_product[]" value="{{$row->invoice_product}}" class="form-control"></td>
				                  <td><textarea class="form-control" name="description[]">{{$row->description}}</textarea></td>
				                  <td><input type="text" name="quantity_unit[]" value="{{$row->quantity_unit}}" class="form-control"></td>
				                  <td>{{$row->product_qty}}</td>
				                  <td>{{$row->product_price}}</td>
				                  <td>{{$row->product_tax}}</td>
				                  <td>{{$row->product_discount}}</td>
				                  <td>{{$row->product_subtotal}}</td>
				                  <td><textarea class="form-control" name="comment[]">{{$row->comment}}</textarea></td>
				                </tr>
				              @endforeach
				            </tbody>
				          </table>          
					      </div>
						    <br>

					      <div class="row">
				          <div class="col-7">
				            <strong>Payment Terms and Condition</strong>
				            <br>
				            <p>Advance along with PO</p>
				            <select id="a" class="form-control" name="terms1" value="{{$data->terms1}}">
			                <option value="{{$data->terms1}}" hidden>{{$data->terms1}}</option>
			                <option value="5% Advance along with PO">5% Advance along with PO</option>
			                <option value="10% Advance along with PO">10% Advance along with PO</option>
			                <option value="15% Advance along with PO">15% Advance along with PO</option>
			                <option value="20% Advance along with PO">20% Advance along with PO</option>
			                <option value="25% Advance along with PO">25% Advance along with PO</option>
			                <option value="30% Advance along with PO">30% Advance along with PO</option>
			                <option value="50% Advance along with PO">50% Advance along with PO</option>
			                <option value="100% Advance along with PO">100% Advance along with PO</option>
			             	</select><br>

			             	<p>Advance against approval of drawing</p>
				           	<select id="a" class="form-control" name="terms2">
			                <option value="{{$data->terms2}}" hidden>{{$data->terms2}}</option>
			                <option value="10% Advance approval of drawing">10% Advance approval of drawing</option>
			                <option value="15% Advance approval of drawing">15% Advance approval of drawing</option>
			                <option value="15% Advance approval of drawing">30% Advance approval of drawing</option>
			             	</select><br>

			             	<p>Balance payment</p>
			             	<select id="a" class="form-control" name="terms3">
			                <option value="{{$data->terms3}}" hidden>{{$data->terms3}}</option>
			                <option value="Balance payment against performa invoice along with taxes at the time of dispatch">Balance payment against performa invoice along with taxes at the time of dispatch</option>
			                <option value="Balance payment against receipt of material within 7 days">Balance payment against receipt of material within 7 days</option>
			                <option value="10% Payment after receipt vendor dispatch within 30 days">10% Payment after receipt vendor dispatch within 30 days</option>
			                <option value="10% Payment by LC">10% Payment by LC</option>
			                <option value="Balance payment by LC">Balance payment by LC</option>
			             	</select>
				          	<br>
				            <strong>Guarantee And Warranty</strong>
				            <textarea class="form-control" name="guarantee">{{$data->guarantee}}</textarea>
				          </div>
				         
			            <div class="col-5 float-right">
			            {{-- <p style="margin-left:80px;"><strong>Sub Total</strong>&nbsp; : &nbsp; {{$data->invoice_subtotal}}</p>
			            <p style="margin-left:80px;"><strong>Total Tax</strong>&nbsp; : &nbsp; {{$data->invoice_discount}}</p> --}}
			            <p style="margin-left:20px;"><strong>Final Amount</strong>&nbsp; : &nbsp;{{$data->grand_total}} </p>
			            <p style="margin-left:20px;"><strong>Final Amount In words</strong>&nbsp; : &nbsp;{{$data->amount_rupees}}</p>
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
					          <input type="text" name="perosn_name" value="{{$data->perosn_name}}" class="form-control">
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
				          <div class="col-md-6">
				            <h5 style="padding-bottom:12px;">For Laxyo Energy Limited</h5>
				            <select id="sign" class="form-control" name="sign">
				            	<option value="1">Laxyo House, Indore</option>
                     	<option value="2">Laxyo Tower, Ratlam</option>
                   	</select>
                   	<div class="form-group">
	                    <img src="" id="signature">
	                  </div>
	                  <img src="{{asset('/'.$data->sign)}}" style="width: 20%;">
				            <h5>(Authorized Signatory)</h5>
				          </div>
					      </div>
					      <br>
					      <button type="submit" name="submit" class="btn btn-primary">Update</button>

					      </form>
					      <br>
						  <footer>
						    <img src="{{asset('assets/img/po_footer_img.png')}}" style="width: 100%;">
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

	});
</script>

@endsection