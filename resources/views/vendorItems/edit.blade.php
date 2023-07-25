@extends('../layouts.master')

@section('content')

<div class="container-fluid">

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header">
      <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm float-right">  Back</a>
      <h5>Update and Items description Vendor</h5>
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
      <form action="{{ route('vendoritems.update',$vendor->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="card-body">
      <div class="row">
        <div class="form-group col-md-6">
          <label for="vendor_name">Vendor Name</label>
          <input type="text" name="vendor_name" class="form-control" value="{{ $vendor->vendor_name }}">
        </div>
        <div class="form-group col-md-6">
          <label for="company">Address </label>
          <textarea class="form-control" name="address"  rows="3"> {{ old('address', $vendor->address) }}</textarea>
        </div>       
      </div>

      <div class="row">
        <div class="form-group col-md-4">
          <label for="product">Material code </label>
          <input type="text" class="form-control" value="{{ $vendor->material_code }}" name="material_code">
        </div>
        <div class="form-group col-md-4">
          <label for="company_mobile">Material description</label>
          <textarea class="form-control" name="material_desc"  rows="3"> {{ old('material_desc', $vendor->material_desc) }}</textarea>
        </div>
        <div class="form-group col-md-4">
          <label>Unit</label>
          <select class="form-control" id="type" name="unit">
            @foreach($units as $unit)
              <option value="{{ $unit->name }}" {{ $unit->name == $vendor->unit ? 'selected' : '' }}>{{ $unit->name }}</option>
            @endforeach
          </select>       
        </div>
      </div>

      <div class="row">
          <div class="form-group col-md-4">
            <label for="city">City *</label>
            <input type="text" class="form-control" id="city" value="{{ $vendor->city }}" name="city">
          </div>
          <div class="form-group col-md-4">
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
          <div class="form-group col-md-4">
            <label for="country">Country </label>
            <input type="text" class="form-control" id="country" value="{{ $vendor->country }}" name="country">
          </div>
        </div>
        
        <div class="row">
          <div class="form-group col-md-4">
            <label for="gst_no">GST NO</label>
            <input type="text" class="form-control" value="{{ $vendor->gst_no }}" name="gst_no">
          </div>
          <div class="form-group col-md-4">
            <label for="mobile_no">Mobile NO </label>
            <input type="text" class="form-control" value="{{ $vendor->mobile_no }}" name="mobile_no">
          </div>
          <div class="form-group col-md-4">
            <label for="mail_id">Email ID</label>
            <input type="email" class="form-control" value="{{ $vendor->mail_id }}" name="mail_id">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label for="account_no">Account No</label>
            <input type="text" class="form-control" value="{{ $vendor->account_no }}" name="account_no">
          </div>
          <div class="form-group col-md-6">
            <label for="bank_name">Account Name</label>
            <input type="text" class="form-control" value="{{ $vendor->bank_name }}" name="bank_name">
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