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

	<div class="wrapper">
		<nav class="navbar navbar-light bg-light justify-content-between" style="background-color: #fff;">
			<div class="container">
				<a href="/">
					<img src="{{asset('assets/img/laxyo_pic.png')}}" class="thumbnail img-responsive" alt="Laxyo Energy LTD" style="max-width: 60%;">
				</a>

				<div class="form-inline">
					<div class="btn-group">
						@if($data->quotation_excel_sheet != null)
						<button class="btn btn-secondary ml-2" data-bs-toggle="modal" data-bs-target="#QuotationPDFModal">Quotation PDF</button> 
						@endif
						<button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
						</button>
						<div class="dropdown-menu">                           
							<a class="dropdown-item" href="javascript:printdoc();" onclick="window.print()" href="#"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
							<a class="dropdown-item" href="{{url('pdf_download',$data->id )}}">Download PDF</a>
							<a class="dropdown-item" href="{{route('generate_po.edit',$data->id )}}"><i class="fa fa-edit" aria-hidden="true"></i>Edit Purchase Order</a>	            
						</div>
						<a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Back</a>
					</div>			    
				</div>
			</div>
		</nav>
		<!-- /.navbar -->


		<!-- Main content -->
		<section>
			<div class="container my-3">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body" style="padding:0px;">
								<header>
									<img src="{{asset('assets/img/po_header_img.png')}}" style="width: 100%; object-fit: contain;">	
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

<!-- Quotation Pdf Modal -->
<div class="modal fade" id="QuotationPDFModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog modal-lg" style="height:100%;">
		<div class="modal-content" style="height:100%;">
			<div class="modal-header">
				<h5 class="modal-title fs-5" id="exampleModalLabel">Quotation DOC</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<iframe src="{{asset($data->quotation_excel_sheet)}}" width="600" height="780" style=" display:block;position: fixed;top: 66px;bottom: 0px;right: 0px;width: 100%;border: none;margin: 0;padding: 0;overflow: hidden;z-index: 3;height: 100%; margin-left:auto; margin-right:auto;"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>