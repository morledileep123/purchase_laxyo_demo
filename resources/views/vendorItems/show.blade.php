@extends('../layouts.master')

@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header">
      <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm float-right"> Back</a>
      <h5 class="main-title-w3layouts">View Vendors and Items Details</h5>
    </div>
    <div class="card-body">

      <div class="row">
        <div class="form-group col-md-6">
          <p><strong>Vendor Name : </strong> {{$vendor->vendor_name}}</p>                    
        </div>
        <div class="form-group col-md-6">
          <p><strong>Address : </strong> {!! nl2br(e($vendor->address)) !!}</p> 
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <p><strong>Material code : </strong> {{$vendor->material_code}}</p> 
        </div>
        <div class="form-group col-md-4">
          <p><strong>Material description : </strong> {!! nl2br(e($vendor->material_desc)) !!}</p> 
        </div>                    
        <div class="form-group col-md-4">
          <p><strong>Unit : </strong> {{$vendor->unit}}</p> 
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <p><strong>Country : </strong> {{$vendor->country}}</p>
        </div>
        <div class="form-group col-md-4">
          <p><strong>State : </strong> {{$vendor->state}}</p>
        </div>
        <div class="form-group col-md-4">
          <p><strong>City : </strong> {{$vendor->city}}</p>
        </div>    
      </div>

      <div class="row">
        <div class="form-group col-md-4">
          <p><strong>GST No: </strong> {{$vendor->gst_no}}</p>
        </div>
        <div class="form-group col-md-4">
          <p><strong>Phone no  : </strong> {{$vendor->mobile_no}}</p>
        </div>                    
        <div class="form-group col-md-4">
          <p><strong>Email-id : </strong> {{$vendor->mail_id}}</p>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-6">
          <p><strong>Account No : </strong> {{$vendor->account_no}}</p>
        </div>
        <div class="form-group col-md-6">
          <p><strong>Account or bank name : </strong> {{$vendor->bank_name}}</p>
        </div>                    
      </div>
    </div>
  </div>
</div>
@endsection