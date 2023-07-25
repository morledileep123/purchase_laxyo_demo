@extends('../layouts.master')

@section('content')

<div class="container-fluid">
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Products & Services</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BankDetails">Bank Details</button> --}}
    {{-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ExcellSheet">Excel Sheet</button> --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <a href="{{ '/vendor' }}" class="btn btn-secondary btn-sm float-right">  Back</a>
            <h5>Update Vendor</h5>
        </div>
        <div class="card-body">
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

             <div class="card">
              {{-- <div class="card-header">
                <h3 class="card-title">Single Vendor <small>Create form</small></h3>
                <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#ExcellSheet">Excel Sheet</button>
              </div> --}}
              <!-- /.card-header -->
              <!-- form start -->
                <form action="{{ route('vendor.update',$vendor->id) }}" method="POST">
                 @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" name="company" class="form-control" value="{{ $vendor->company }}" id="company" placeholder="Enter campany name">
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                        <label for="company">vendor Type </label>
                        <input type="text" name="vendor_type" class="form-control" id="vendor_type" value="{{ $vendor->vendor_type }}" >
                        {{-- <label>Vendor Type</label>
                            <select name="vendor_type" class="form-control vendor_type">
                                <option>{{ $vendor->vendor_type }}</option>                                
                                <option label="Supplier" value="Supplier">Supplier</option>
                                <option label="Buyer" value="Buyer">Buyer</option>
                                <option label="Both" value="Both">Both</option>
                            </select>
                        @error('vendor_type')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                        </div>

                        <div class="form-group col-md-8">
                            <label for="product">Product </label>
                            <input type="text" class="form-control" id="product" value="{{ $vendor->product }}" name="product">
                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-md-4">
                            <label for="company_email">Company Email-id *</label>
                            <input type="email" class="form-control" id="company_email" value="{{ $vendor->company_email }}" name="company_email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="company_mobile">Company mobile no *</label>
                            <input type="text" class="form-control" id="company_mobile" value="{{ $vendor->company_mobile }}" name="company_mobile">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gstin">gstin </label>
                            <input type="text" class="form-control" id="gstin" value="{{ $vendor->gstin }}" name="gstin">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="address1">Address 1 </label>
                            <input type="text" class="form-control" id="address1" value="{{ $vendor->address1 }}" name="address1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address2">Address 2 </label>
                            <input type="text" class="form-control" id="address2" value="{{ $vendor->address2 }}" name="address2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="city">City *</label>
                            <input type="text" class="form-control" id="city" value="{{ $vendor->city }}" name="city">
                        </div>
                        <div class="form-group col-md-3">
                        <label>State</label>
                        
                            <select name="state" class="form-control pass_division">
                                <option>{{ $vendor->state }}</option>
                                <option label="Andaman and Nicobar Islands" value="Andaman and Nicobar IslandsN">Andaman and Nicobar Islands</option>
                              <option label="Andhra Pradesh" value="Andhra Pradesh">Andhra Pradesh</option>
                              <option label="Arunachal Pradesh" value="Arunachal Pradesh">Arunachal Pradesh</option>
                              <option label="Assam" value="Assam">Assam</option>
                              <option label="Bihar" value="Bihar">Bihar</option>
                              <option label="Chandigarh" value="Chandigarh">Chandigarh</option>
                              <option label="Chhattisgarh" value="Chhattisgarh">Chhattisgarh</option>
                              <option label="Dadra and Nagar Haveli" value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                              <option label="Daman and Diu" value="Daman and Diu">Daman and Diu</option>
                              <option label="Delhi" value="Delhi">Delhi</option>
                              <option label="Goa" value="Goa">Goa</option>
                              <option label="Gujarat" value="Gujarat">Gujarat</option>
                              <option label="Haryana" value="Haryana">Haryana</option>
                              <option label="Himachal Pradesh" value="Himachal Pradesh">Himachal Pradesh</option>
                              <option label="Jammu and Kashmir" value="Jammu and Kashmir">Jammu and Kashmir</option>
                              <option label="Jharkhand" value="Jharkhand">Jharkhand</option>
                              <option label="Karnataka" value="Karnataka">Karnataka</option>
                              <option label="Kerala" value="Kerala">Kerala</option>
                              <option label="Lakshadweep" value="Lakshadweep">Lakshadweep</option>
                              <option label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>
                              <option label="Maharashtra" value="Maharashtra">Maharashtra</option>
                              <option label="Manipur" value="Manipur">Manipur</option>
                              <option label="Meghalaya" value="Meghalaya">Meghalaya</option>
                              <option label="Mizoram" value="Mizoram">Mizoram</option>
                              <option label="Nagaland" value="Nagaland">Nagaland</option>
                              <option label="Orissa" value="Orissa">Orissa</option>
                              <option label="Puducherry" value="Puducherry">Puducherry</option>
                              <option label="Punjab" value="Punjab">Punjab</option>
                              <option label="Rajasthan" value="Rajasthan">Rajasthan</option>
                              <option label="Sikkim" value="Sikkim">Sikkim</option>
                              <option label="Tamil Nadu" value="Tamil Nadu">Tamil Nadu</option>
                              <option label="Telangana State (TS)" value="Telangana State (TS)">Telangana State (TS)</option>
                              <option label="Tripura" value="Tripura">Tripura</option>
                              <option label="Uttar Pradesh" value="Uttar Pradesh">Uttar Pradesh</option>
                              <option label="Uttarakhand" value="Uttarakhand">Uttarakhand</option>
                              <option label="West Bengal" value="West Bengal">West Bengal</option>
                            </select>
                            
                            
                        @error('pass_division')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="country">Country </label>
                            <input type="text" class="form-control" id="country" value="{{ $vendor->country }}" name="country">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="pin">PIN NO </label>
                            <input type="text" class="form-control" id="pin" value="{{ $vendor->pin }}" name="pin">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="person_name">Name of Contact Person *</label>
                            <input type="text" class="form-control" id="person_name" value="{{ $vendor->person_name }}" name="person_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="person_email">Contact Person Email-id </label>
                            <input type="email" class="form-control" id="person_email" value="{{ $vendor->person_email }}" name="person_email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="person_mobile">Contact Person Phone no *</label>
                            <input type="text" class="form-control" id="person_mobile" value="{{ $vendor->person_mobile }}" name="person_mobile">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="account_no">Account No</label>
                            <input type="text" class="form-control" id="account_no" value="{{ $vendor->account_no }}" name="account_no">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control" id="account_name" value="{{ $vendor->account_name }}" name="account_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="ifsc_code">IFSC Code </label>
                            <input type="text" class="form-control" id="ifsc_code" value="{{ $vendor->ifsc_code }}" name="ifsc_code">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="name_of_bank">Name of Bank and Branch </label>
                            <input type="text" class="form-control" id="name_of_bank" value="{{ $vendor->name_of_bank }}" name="name_of_bank">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

@endsection