@extends('../layouts.master')
@section('content')

<div class="container-fluid">

  {{--  Alert Message  --}} 
  <div class="container">
    @if ($errors->any())
      <div class="alert alert-warning alert-dismissible mt-3" role="alert">
        <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
        </button>
        <strong>Warning!</strong> Please check your all input Fields<br>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </div>
    @endif
  </div>
    <!-- Content Header (Page header) -->
  <div class="card shadow mx-1">
    <div class="content-header">
      <div class="container-wrap mx-3">
        <div class="row">
            <div class="col-sm-6">
              <h5 class="ml-2">Payment Voucher</h5>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
              </ol>
            </div>  
             <!-- /.col -->
        </div>
          <!-- /.row -->
      </div>
       <!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-body vendor-margin">
          <div class="row">
            <div class="col-md-12">
              <form action="{{route('payment.store')}}" method="POST" enctype="multipart/form-data">
                @csrf  
                <input type="hidden" name="vender_person_email" value="{{$data->vender_person_email}}">
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-7">
                  	<div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Vendor Details</h3>
                      </div>
                      <div class="card-body" style="margin-bottom:10px;">
                      	@if($data->vender_detail_infor != 'null')
                        	<h6>{!! nl2br(e($data->vender_detail_infor)) !!}</h6> 
                        	<input type="hidden" name="vendore_details" value="{{$data->vender_detail_infor}}" class="form-control">
                        @else
                          <h6>{{$data->vender_company}}</h6> 
                          <input type="hidden" name="vendore_details" value="{{$data->vender_company}}" class="form-control">
                        @endif         
                      </div>
                       <!-- /.card-body -->
                    </div>
                    <!-- general form elements -->
                  </div>
                  <div class="col-md-5">
                  	
                  </div>

                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Invoice NO</h3>
                      </div>
                      <div class="card-body">
                      	<p>{{$data->invoice_no}}</p>
                        <input type="hidden" name="invoice_no" value="{{$data->invoice_no}}" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Invoice Date</h3>
                      </div>
                      <div class="card-body">
                      	<p>{{date('d-m-Y', strtotime($data->invoice_date)) }}</p> 
                        <input type="hidden" name="invoice_date" value="{{$data->invoice_date}}" class="form-control">             
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Invoice amount <span style="color:red;">*</span></h3>
                      </div>
                      <div class="card-body">
                        <input type="number" value="{{$data->grand_total}}" name="invoice_amount" class="form-control">             
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">PO NO</h3>
                      </div>
                      <div class="card-body">
                        <p>{{$data->po_no}}</p>
                        <input type="hidden" name="po_no" value="{{$data->po_no}}" class="form-control">             
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">PO Date</h3>
                      </div>
                      <div class="card-body">
                         <p>{{date('d-m-Y', strtotime($data->po_date)) }}</p>
                        <input type="hidden" name="po_date" value="{{date('d-m-Y', strtotime($data->po_date)) }}" class="form-control">             
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Amount Paid <span style="color:red;">*</span></h3>
                      </div>
                      <div class="card-body">
                        <input type="number" name="amount_paid" class="form-control">             
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">GST <span style="color:red;">*</span></h3>
                      </div>
                      <div class="card-body">
                        <select class="form-control" name="gst">
                          <option hidden>GST</option>
                          <option value="Hold">Hold</option>
                          <option value="Released">Released</option>
                        </select>  
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">TDS <span style="color:red;">*</span></h3>
                      </div>
                      <div class="card-body">
                        <input type="text" name="tds" class="form-control">             
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Balance to be paid, If any</h3>
                      </div>
                      <div class="card-body">
                        <input type="number" name="balance_paid" value="0" class="form-control">             
                      </div>
                    </div>
                  </div>
                     
                </div>
             
            <button type="submit" name="submit" class="btn btn-primary sub-btn">Submit</button>
            {{-- <button type="submit" name="submit" class="btn btn-primary sub-btn" onclick="return confirm('Are you sure you want to submit this from?');">Send Quotation</button> --}}
          		</form>
            </div>
          </div>
              
        </div>
      </div>
    </div>
   
  </div>
</div>

@endsection
