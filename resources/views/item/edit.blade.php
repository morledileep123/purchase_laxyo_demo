@extends('../layouts.master')

@section('content')
<div class="container-fluid">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4>Update Item</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="card shadow mt-3">
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

            <form action="{{ route('item.update',$item->id) }}" class="create-form" method="POST">
                @csrf
                @method('PUT')
         <div class="row">
          <div class="col-md-12">
            <div class="itm-left">
             <!--  <div class="row">
                <div class="left-itm-head" style="background-color: rgb(224, 242, 241) !important;">
                  <h3>Basic Details</h3>
                </div>
              </div> -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Part Number</label>
                    <input type="text" class="form-control"  value="{{ $item->part_number }}" name="part_number">
                </div>
                <div class="form-group col-md-6">
                    <label>Item Name *</label>
                    <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ $item->item_name }}">
                </div>
            </div>

            <div class="row">      
                <div class="form-group col-md-6">
                    <label>Rate </label>
                    <input type="text" class="form-control" value="{{ $item->rate }}" name="rate">
                </div>
                <div class="form-group col-md-6">
                    <label>Unit *</label>
                    
                        {{-- <select class="form-control" name="unit_id">
                            <option>Select Unit</option>
                              @foreach ($units as $key => $unit)
                                <option value="{{ $key }}">{{ $unit->name }}</option>
                              @endforeach    
                        </select> --}}


                    <select name="unit_id" class="form-control">
                         <option disabled="" value="{{$item->unit_id}}" selected="">{{$item->unit_id}}</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" @if($unit->id == $item->unit_id) selected @endif>{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>HSN Code</label>
                        <input type="text" class="form-control" value="{{ $item->hsn_code }}" name="hsn_code">
                    </div>
                     <div class="form-group col-md-6">
                        <label>Tax</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="gst" value="{{ $item->gst }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <input type="text" class="form-control" value="{{ $item->description }}" name="description">
                    </div>
                </div>
          </div>
           </div>
          
         </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection