@extends('../layouts.master')
<link rel="stylesheet" src="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
@section('content')
<style>
  .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

 /* toggle-switch-css*/
</style>
<!-- Begin Page Content -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
 -->
<div class="container-fluid">
  <div class="card shadow">
    <div class="card-header">
        <a href="{{ '/home' }}" class="btn btn-secondary btn-sm float-right">  Back</a>
        <h5>Item Listing</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <form id="addForm">
          @csrf
            <div class="row">
              <div class="form-group col-md-5">
                  <select name="category_id" id="category" class="form-control">
                    <option selected="" hidden>Filter By Category</option>
                    @foreach ($category as $categorys)
                        <option value="{{ $categorys->id }}" {{ old('category_id') == $categorys->id ? 'selected' : '' }}>{{ $categorys->name }}</option>
                    @endforeach
                  </select> 
              </div>
              <div class="form-group col-md-5">
                  <select class="form-control filter-border" name="location" id="location">
                    <option selected="" hidden value="0">Filter By Site Name</option>
                    @foreach($sites as $ste)
                      <option value="{{$ste->name}}">{{$ste->name}}</option>
                    @endforeach
                  </select>    
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
      <div class="btn-group">
      <button type="button" class="btn add-item-btn dropdown-toggle" data-toggle="dropdown">Add Item</button>
      <!-- <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"> -->
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('item.create') }}">Single Item</a>
        <a class="dropdown-item" href="{{ route('export_pdf') }}">Multiple Items</a>
        <a class="dropdown-item" href="{{ route('fetchItems') }}">Excel</a>
      </div>
    </div>
    </div>   
  <div class="col-md-5 bg-light">
    <div class="item-menu">
     <div class="row">
      <div class="col-md-6">
        <div class="stock-status" style="display: inline-block;">
        <h3 class="stock-head">Stock Value</h3>
        {{-- <h2 class="val" id="stockcount">{{$stock}}</h2> --}}
        </div>
      </div>

      <div class="col-md-6">
        <div class="invent">
         <i class="fa fa-bar-chart" aria-hidden="true" style="color:rgb(4, 139, 103) !important;"></i>
         <h3 class="stock-head">Inventory Dashboard</h3>
       </div>
      </div>
     </div>
    </div>
  </div>
 
              </div>
              <!-- <div class="row">
               
            </div> -->
        </form>
        <br>
        <div id="item-table">   
            @include('item.table')
        </div>
        </div>
  </div>
</div>

<!-- script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script> -->
<!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script> -->
<script>
    $(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     
     $('#category').on('change' ,function () {
        var catListId = $(this).val();
        {
         $.ajax({
           type:'get',
           url:"{{ route('item-cat') }}?id="+catListId,
           success:function(data){
      
                                   $('#item-table').empty(data);
                                   $('#item-table').html(data);
           }
        });
       }
    });

     $('#location').on('change' ,function () {
        var siteListId = $(this).val();
        {
         $.ajax({
           type:'get',
           url:"{{ route('item-location') }}?name="+siteListId,
           success:function(data){
                                   $('#item-table').empty(data);
                                   $('#item-table').html(data);
           }
        });
       }
    });

    });

</script>
@endsection