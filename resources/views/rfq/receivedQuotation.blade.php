@extends('../layouts.sbadmin2')
@section('content')
<?php 
	$qid = request()->segment('2');
?>
<div class="container-fluid">
		<a href="{{ '/rfq' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
	  <h5 class="main-title-w3layouts mb-2">Received Quotation</h5>
  	<div class="card shadow mb-4">
  		<div class="card-body">
				<div class="table-responsive">
					@if ($errors->any())
			        <div class="alert alert-danger">
			            <strong>Warning!</strong> Please check your input code<br><br>
			            <ul>
			                @foreach ($errors->all() as $error)
			                    <li>{{ $error }}</li>
			                @endforeach
			            </ul>
			        </div>
			    @endif
				  <div class="col-md-12 wrap">
			    	<div class="row mb-3">
					    <div class="col-md-12">
					    	<button id="numBntAsc" class="btn btn-dark float-right ml-2">Low To High</button>
					    	<button id="numBntDesc" class="btn btn-dark float-right">High To Low</button>
					    </div>
					  </div>

						  				<h3><b>{{ 'Site:-'.App\sites::find($vendor[0]->site_id)->job_describe}}</b></h3>
				    <?php 
				  		foreach ($vendor as $key) {	
				  			$row = $key;
				  			$vids = $row->QuotationReceived->vendorsDetail->id;
				  	?>
				  		<div class="row box pt-3" style="@if($row->level2_status==1 && $vids==$row->vendor_id) background: #0d8c46 @endif">
						  	<div class="col-md-12">
						  			<div class="col-md-2 float-left leftdiv">
						  				<div class="text-center" style="@if($row->level2_status==1 && $vids==$row->vendor_id) color: #fff @else color: black @endif">
						  						<h5>{{ $row->QuotationReceived->vendorsDetail->firm_name }}</h5>
						  						<p>{{ $row->QuotationReceived->vendorsDetail->name }}</p>
						  						<span class="span1" style="float: left">{{ $row->QuotationReceived->quotion_id }}</span>
						  						<span class="span2" style="float: right">{{ $row->QuotationReceived->vendorsDetail->register_number }}</span>
						  				</div>
						  			</div>
						  			<div class="col-md-8 float-left div-center">
						  				<table class="@if($row->level2_status==1 && $vids==$row->vendor_id) table table-borderless @else table @endif" style="@if($row->level2_status==1 && $vids==$row->vendor_id) color: #fff; @else color: black @endif">
											  <thead>
											    <tr>
											      <th scope="col">#</th>
											      <th scope="col">Item Name</th>
											      <th scope="col">Qty/Price</th>
											      <th scope="col">Amount</th>
											      <th scope="col">Tax</th>
											      <th scope="col">Total</th>
											    </tr>
											  </thead>
											  <tbody>
											  	<?php 
											  		$n = 1;
											  		$total = 0;
											  		$data = json_decode($row->QuotationReceived->items);
											  		foreach($data as $val){
											  			$vid = $row->QuotationReceived->vender_id; 
											  			if($vid == $row->QuotationReceived->vendorsDetail->id){
												  			if($n > 0){
											  	?>
											    <tr>
											      <th scope="row">{{ $n }}</th>
											      <td>{{ $val->item_name }}</td>
											      <td>{{ $val->item_quantity }} x {{ $val->item_price }}</td>
											      <td>Rs. {{ $val->item_actual_amount }}</td>
											      <td>{{ (!empty($val->item_tax1_rate)) ? $val->item_tax1_rate: 0 }}%</td>
											      <td>Rs. {{ $val->item_total_amount }} <?php $total +=$val->item_total_amount; ?></td>
											    </tr>
											    <?php } $n++; } } ?>
											  </tbody>
											</table>
						  			</div>
						  			<div class="col-md-2 div-right ttlamt">
						  				<div class="text-center mt-5" style="@if($row->level2_status==1 && $vids==$row->vendor_id) color: #fff @else color: black @endif">
						  						<h3>Total</h3>
						  						<span>Rs. {{$total}}</span>
						  				</div>
						  			</div>
						  	</div>
						  	<div class="col-md-12">
						  			<div class="div-border">
						  				<div class="container-fluid mt-2 mb-2" style="@if($row->level2_status==1 && $vids==$row->vendor_id) color: #fff; @else color: black @endif">
						  					<h5>Terms and Conditions: </h5>
												<?php echo (!empty($row->QuotationReceived->terms))?$row->QuotationReceived->terms:'No terms and conditions available'; ?>
											</div>
						  			</div>
						  	</div>
						  	<div class="col-md-12 mb-3">
						  			<div class="div-border">
						  				<form id="addForm{{ $row->QuotationReceived->vendorsDetail->id }}" @if($row->quote_id == $qid && $row->manager_status == 1) style="pointer-events:none;" @endif >
						  					@csrf
						  					<table class="table table-bordered" style="@if($row->level2_status==1 && $vids==$row->vendor_id) color: #fff; @else color: black; margin-bottom: 0; border:1px solid #000 @endif">
						  							<tr id="managerStatusID">
							  							<td>
							  								Manager : 
							  								@if($row->manager_status == 1 && $row->vendor_id == $row->QuotationReceived->vendorsDetail->id)
							  									@if($row->manager_status == 1 && $qid == $row->rfi_id)
							  										<span style=" color:#38fd38; font-weight: bold">Approved</span>
							  									@endif
							  								@else
									  								<span style="margin-left: 20px;">
									  									<input type="radio" name="manager_status" value="1" id="approveit"> Approve
									  								</span> 
								  							@endif
							  								<input type="hidden" name="quotion_id" value="{{ $row->id }}" id="pqtid">
							  								<!-- <input type="hidden" name="quote_id" value="{{ request()->segment(2) }}">
							  								<input type="hidden" name="vender_id" value="{{ $row->id }}"> -->
							  							</td>
							  							<td>
							  								Level 1 : 
							  								@if($row->manager_status == 1 && $row->vendor_id == $row->QuotationReceived->vendorsDetail->id)
							  									@if($row->level1_status == 1) 
							  										<span style=" color:#38fd38; font-weight: bold">Approved</span> 
							  									@elseif($row->level1_status == 2)
							  										<span style=" color:#ff9a00; font-weight: bold">Discard</span>
							  									@else
																		------
							  									@endif
							  								@endif
							  							</td>
							  							<td>
							  								Level 2 : 
							  								@if($row->manager_status == 1 && $row->vendor_id == $row->QuotationReceived->vendorsDetail->id)
							  									@if($row->level2_status == 1) 
							  										<span style=" color:#38fd38; font-weight: bold">Approved</span> 
							  									@elseif($row->level2_status == 2)
							  										<span style=" color:#ff9a00; font-weight: bold">Discard</span>
							  									@else
																		------
							  									@endif
							  								@endif
							  							</td>
							  						</tr>
						  					</table>
						  				</form>
						  			</div>
						  	</div>
					  	</div>
						<?php } ?>
				  </div>
				</div>
			</div>
		</div>
</div>

@endsection
<script src='/themes/sb-admin2/vendor/jquery/jquery.min.js'></script>
<script type="text/javascript">
	$(function(){
    var number = [];
    $('.box').each(function(){
      var numArr = [];
      numArr.push($('.ttlamt', this).text());
      numArr.push($(this));
      number.push(numArr);
      number.sort();
    })
    $('#numBntAsc').on('click', function(){
    	var asc = number.sort();
      $('.box').remove();
      for(var i=0; i<asc.length; i++){
        $('.wrap').append(asc[i][1]);
      }
    })
    $('#numBntDesc').on('click', function(){
    	var rev = number.sort().reverse();
      $('.box').remove();
      for(var i=0; i<number.length; i++){
        $('.wrap').append(rev[i][1]);
      }
    })
  })
</script>
<style>
	.leftdiv{
		height: 200px !important;
		overflow: hidden;
		border: 1px solid black;
	}
	.leftdiv > div{
		padding: 6px;
		margin-top: 36px;
	}
	.leftdiv > .span1{
		font-size: 12px;
	}
	.leftdiv > .span2{
		font-size: 12px;
	}
	.div-center{
		height: 200px !important;
		overflow-x: hidden;
		border: 1px solid black;
	}
	.div-right{
		height: 200px !important;
		overflow: hidden;
		border: 1px solid black;
	}
	.div-border{
		border: 1px solid black;
	}
	.quoteDisabled{
		background-color: #dcdab2;
    opacity: 0.4;
	}
</style>
<?php
	foreach ($vendor as $keys) {
		$rows = $keys;
		$rfi_id = $row->rfi_id;
		if($rfi_id == $qid && $row->manager_status == 1 ){
?>
	<style> 
		#managerStatusID{
			pointer-events:none !important;
      background-color:grey !important;
		}
	</style>
<?php
		}
?>
<script>
$(document).ready(function() {
  $("#addForm"+{{ $rows->QuotationReceived->vendorsDetail->id }}).on('click', function(e) {
 		e.preventDefault();
 		var status = "<?php echo $row->manager_status; ?>";
 		var rfi_id = "<?php echo $row->rfi_id; ?>";
 		var qid = "<?php echo $qid; ?>";
 		if(status == 1 && rfi_id == qid){
 				alert("Already Approved");
 		}else{
 		if(confirm("are you sure you wants to approve this Vendor Quotation"))
 		{
	 		$.ajax({
	        type: 'post',
	        url: '/QuotationApproval',
	        data: $('#addForm'+{{ $rows->QuotationReceived->vendorsDetail->id }}).serialize(),
	        success: function(data) {
	        	console.log(data);
	          	alert("Quotation Approved");
	          	location.reload();
	        },
	    });
	 	} }
	});
  $("#approveit").on('click',function(){

    //alert($("#pqtid").val());

  })
});
</script>
<?php } ?>