@extends('../layouts.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header">
            <a href="{{ '/item' }}" class="btn btn-secondary btn-sm float-right">  Back</a>
            <h5>Create Item</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                    <div class="row">
                        <div class="col-md-12">
            <form action="{{ route('item.store') }}" method="post" class="create-form">
                @csrf
                <div class="row">
                     <div class="form-group col-md-6">
                        <label>Part Number</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                     <div class="form-group col-md-6">
                        <label>HSN Code</label>
                        <input type="text" class="form-control" placeholder="Add HSN Code" name="hsn_code" value="{{ old('hsn_code') }}">
                 @error('hsn_code')
                    <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                    </div>
                </div>

                 <div class="row">
                    <div class="form-group col-md-6">
                        <label>Category<span style="color:red"> *</span></label>
                        <select name="category_id" id="category" class="form-control">
                            <option disabled="" selected="" hidden>Select Category</option>
                            @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}" {{ old('category_id') == $categorys->id ? 'selected' : '' }}>{{ $categorys->name }}</option>
                            @endforeach
                          
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sub Category<span style="color:red"> *</span></label>
                        <select name="sub_category_id" id="subcategory" class="form-control">
                            <option disabled="" selected="" hidden>Select SubCategory</option>
                            @foreach ($subcategory as $subcategorys)
                                <option value="{{ $subcategorys->id }}" {{ old('sub_category_id') == $subcategorys->id ? 'selected' : '' }}>{{ $subcategorys->name }}</option>
                            @endforeach
                          
                        </select>
                    </div>
                </div>
                   

                 <div class="row">
                    <div class="form-group col-md-6">
                        <label>Item Name<span style="color:red"> *</span></label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }}">
                    </div>
                     <div class="form-group col-md-6">
                        <label>Description<span style="color:red"> *</span></label>
                        <input type="text" class="form-control" placeholder="Add Description" name="description" value="{{ old('description') }}">
                    </div>
                    </div>

                      
                <div class="row"> 
                     <div class="form-group col-md-6">
                         <label>Specification<span style="color:red"> *</span></label>
                        <select name="specification_name" id="specification" class="form-control">
                            <option disabled="" selected="" hidden>Select Specification</option>
                            @foreach ($specification  as $specifications)
                                <option value="{{ $specifications->name }}" {{ old('specification_name') == $specifications->name ? 'selected' : '' }}>{{ $specifications->name }}</option>
                            @endforeach  
                        </select>
                    </div>
                 <div class="form-group col-md-6">
                       <label>Select Unit<span style="color:red"> *</span></label>
                        <select name="unit_id" id="unit" class="form-control">
                            <option disabled="" selected="" hidden>Select UOM</option>
                            @foreach ($units  as $unit)
                                <option value="{{ $unit->name }}" {{ old('unit_id') == $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach  
                        </select>
                    </div>
                </div>

                <div class="row">
                      <div class="form-group col-md-6">
                        <label>Item Rate</label>
                        <input type="number" class="form-control" placeholder="Add rate" name="rate" value="{{ old('rate') }}">
                     </div> 
                    <div class="form-group col-md-6">
                        <label>Tax(GST%)</label>
                        <input type="text" class="form-control" placeholder="Add gst" name="gst" value="{{ old('gst') }}">
                     </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Brand/Model</label>
                         <input type="text" class="form-control" placeholder="" name="brand_id" value="{{ old('brand_id') }} ">
                     </div>

                    <div class="form-group col-md-6">
                        <label>Product/Service</label>
                        <select name="product_service_name" id="product" class="form-control">
                            <option disabled="" selected="" hidden>Select</option>
                            <option>Product</option>
                            <option>Service</option>    
                        </select>
                    </div>  
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Current Stock</label>
                        <input type="text" class="form-control" placeholder="Add stock" name="current_stock" >
                     </div>
                      <div class="form-group col-md-6">
                        <label>Min Stock Level</label>
                        <input type="number" class="form-control" placeholder="Add min stock" name="min_stock_level" value="{{ old('min_stock_level') }}">
                     </div>  
                </div>

                <div class="row"> 
                    <div class="form-group col-md-6">
                        <label>Max Stock Level</label>
                        <input type="number" class="form-control" placeholder="Add max stock" name="max_stock_level" value="{{ old('max_stock_level') }}">
                     </div>
                      <div class="form-group col-md-6">
                        <label>Select Department<span style="color:red"> *</span></label>
                         <input type="text" class="form-control" placeholder="Add department" name="department" value="{{ old('department') }}">
                    </div>  
                </div>

                <div class="row">  
                   <div class="form-group col-md-6">
                        <label>Location<span style="color:red"> *</span></label>
                         <select name="location" id="location" class="form-control">
                            <option disabled="" selected="" hidden>Select Site Name</option>
                            @foreach ($sites as $ste)
                                <option value="{{ $ste->name }}" {{ old('location') == $ste->name ? 'selected' : '' }}>{{ $ste->name }}</option>
                            @endforeach  
                        </select>
                     </div>
                     <div class="form-group col-md-6">
                        <label>Consumption</label>
                        <select name="consumption" class="form-control">
                            <option disabled="" selected="" hidden>Select level</option>
                            <option>level(1 year)</option>
                            <option>level(2 year)</option>
                            <option>level(3 year)</option> 
                        </select>
                    
                    </div>
                </div>
                    
                    <div class="row">  
                    <div class="form-group col-md-6">
                        <label>Consumable</label>
                        <input type="text" class="form-control" placeholder="" name="consumable" value="{{ old('consumerable') }} ">
                     </div>
                    </div>
                 
                <button type="submit" class="btn btn-primary">Submit</button>
         
            </form>
            </div> 
          </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
</script>
@endsection

{{-- {{ route('excel_import') }} --}}