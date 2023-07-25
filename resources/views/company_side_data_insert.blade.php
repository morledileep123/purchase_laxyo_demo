@extends('layouts.master')

@section('content')

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header">
      <div class="float-right">
        {{-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"> Add Side Name</i></button> --}} 
        <a href="{{ url('/company_side_name') }}" class="btn btn-secondary btn-sm"> Back</a>
      </div>
    <h5 class="main-title-w3layouts mb-1">Create Company Side Name</h5> 
    </div>
    <div class="card-body">
      <form action="{{route('company_side_name.store')}}" method="POST">
        @csrf
        <div class="row">
          <div class="form-group col-md-12">
            <label>Company Name</label>
            <input type="text" class="form-control" placeholder="Campany Name" name="company_name">
          </div>
          <div class="form-group col-md-12">
            <label>Full Address</label>
            <textarea class="form-control" rows="3" name="full_address" placeholder="Full Address"></textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Mobile No</label>
            <input type="text" class="form-control" placeholder="Mobile No" name="mobile_no">
          </div>
          <div class="form-group col-md-6">
            <label>GST No</label>
            <input type="text" class="form-control" placeholder="GST No" name="gstno">
          </div>
          <div class="form-group col-md-6">
            <label>Images</label>
            <input type="file" class="form-control" name="images">
          </div>
          <div class="form-group col-md-6">
            <label>Watermark Image</label>
            <input type="file" class="form-control" name="watermark_img">
          </div>
          <div class="form-group col-md-6">
            <label>Header Image</label>
            <input type="file" class="form-control" name="header_img">
          </div>
          <div class="form-group col-md-6">
            <label>Footer Image</label>
            <input type="file" class="form-control" name="footer_img">
          </div>
          
          <div class="form-group col-md-5">
            <label>First Code Company</label>
            <input type="text" class="form-control" placeholder="Campany Short Word" name="first_code_company">
          </div>
          <div class="form-group col-md-7">
            <label>Code Location</label>
            <input type="text" class="form-control" placeholder="Campany Location Short Word" name="code_location">
          </div>
          <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
        </div>        
      </form>
    </div>
  </div>
</div>






@endsection