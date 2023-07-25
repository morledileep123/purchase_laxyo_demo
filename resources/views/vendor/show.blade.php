@extends('../layouts.master')

@section('content')
<div class="container-fluid">
    {{-- <a href="{{ '/vendor' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Show Vendor</h5> --}}

    <div class="card shadow mb-4">
        <div class="card-header">
            <a href="{{ '/vendor' }}" class="btn btn-secondary btn-sm float-right"><i class="fa fa-arrow-left"></i>  Back</a>
            <h5 class="main-title-w3layouts">View Vendors Details</h5>
        </div>
        <div class="card-body">
    		
            <div class="row">
                <div class="form-group col-md-5">
                    <p><strong>Company Name : </strong> {{$vendor->company}}</p>                    
                </div>
                <div class="form-group col-md-3">
                    <p><strong>Vendor Type : </strong> {{$vendor->vendor_type}}</p> 
                </div>
                <div class="form-group col-md-4">
                    <p><strong>Products : </strong> {{$vendor->product}}</p> 
                </div>
            </div>
			<div class="row">
                <div class="form-group col-md-4">
                    <p><strong>Company Email-id : </strong> {{$vendor->company_email}}</p> 
                </div>
                <div class="form-group col-md-4">
                    <p><strong>Company mobile no : </strong> {{$vendor->company_mobile}}</p> 
                </div>                    
                <div class="form-group col-md-4">
                    <p><strong>gstin : </strong> {{$vendor->gstin}}</p> 
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <p><strong>Address 1 : </strong> {{$vendor->address1}}</p> 
                </div>
                <div class="form-group col-md-6">
                    <p><strong>Address 2 : </strong> {{$vendor->address2}}</p> 
                </div>
            </div>
             <div class="row">
                <div class="form-group col-md-3">
                    <p><strong>City : </strong> {{$vendor->city}}</p>
                </div>
                <div class="form-group col-md-3">
                    <p><strong>State : </strong> {{$vendor->state}}</p>
                </div>                    
                <div class="form-group col-md-3">
                    <p><strong>Country : </strong> {{$vendor->country}}</p>
                </div>
                <div class="form-group col-md-3">
                    <p><strong>PIN No : </strong> {{$vendor->pin}}</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <p><strong>Name of Contact Person : </strong> {{$vendor->person_name}}</p>
                </div>
                <div class="form-group col-md-4">
                    <p><strong>Contact Person Email-id : </strong> {{$vendor->person_email}}</p>
                </div>                    
                <div class="form-group col-md-4">
                    <p><strong>Contact Person Phone no : </strong> {{$vendor->person_mobile}}</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <p><strong>Account No : </strong> {{$vendor->account_no}}</p>
                </div>
                <div class="form-group col-md-6">
                    <p><strong>Account name : </strong> {{$vendor->account_name}}</p>
                </div>                    
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <p><strong>IFSC Code : </strong> {{$vendor->ifsc_code}}</p>
                </div>
                <div class="form-group col-md-8">
                    <p><strong>Name of Bank and Branch : </strong> {{$vendor->name_of_bank}}</p>
                </div>                    
            </div>
            
        </div>
    </div>
</div>
@endsection