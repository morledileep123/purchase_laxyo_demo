@extends('../layouts.master')
<link rel="stylesheet" src="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
@section('content')

<div class="container-fluid">
  <a href="{{ route('item.create') }}" class="main-title-w3layouts mb-2 float-right back-btn"><i class="fa fa-arrow-left"></i>Back</a>
  <h5 class="main-title-w3layouts mb-2">Item Details</h5>
  <div class="card shadow mt-3">
    <div class="card-body">
      <form class="create-form">
     <div class="row">
      <div class="col-md-7">
        <div class="itm-left">
          <div class="row">
            <div class="left-itm-head" style="background-color: rgb(224, 242, 241) !important;">
              <h3>Basic Details</h3>
            </div>
          </div>
        <div class="row">
                     <div class="form-group col-md-6">
                        <label>Part Number</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Item Name</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>

          <div class="row">
                     <div class="form-group col-md-6">
                        <label>Item Number</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Item Name</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>

          <div class="row">
                     <div class="form-group col-md-6">
                        <label>Type</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>

          <div class="row">
                     <div class="form-group col-md-6">
                        <label>Unit</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Price</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
           </div>

        <div class="row">
                     <div class="form-group col-md-6">
                        <label>HSN Code</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tax</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>
      </div>
       </div>
       <div class="col-md-5">
        <div class="itm-ryt">
          <div class="row">
            <div class="ryt-itm-head" style="background-color: rgb(224, 242, 241) !important;">
              <h3>Stock Details</h3>
            </div>
          </div>
        <div class="row">
                     <div class="form-group col-md-6">
                        <label>Total Stock</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reject Stock</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>
        <div class="row">
                     <div class="form-group col-md-6">
                        <label>Min Stock Level</label>
                        <input type="text" class="form-control" value="{{ old('part_number') }} " name="part_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Max Stock Level</label>
                        <input type="text" class="form-control" placeholder="Add Name" name="item_name" value="{{ old('item_name') }} ">
                    </div>
                </div>
      </div>
      </div>
     </div>
   </form>
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
      $('#category').on('change',function(){
           var catid = $(this).val();
          $.ajax({
                 type: "GET",
                 url: "{{ route('item-cat') }}?id="+catid,
                 success: function(res){
                  if(res){
                    //console.log(res);
                       $("#department").empty();
                       $("#department").append('<option value="">select department</option>');
                       $.each(res,function(index, rece){
                        $("#department").append('<option value='+rece.department_name['id']+'>'+rece.department_name['name']+'</option>')
                    });
                    
                  }
                }
                      });

      })

      $("#department").on('change', function(){
         var dep = $(this).val();
         var cat = $("#category").val();
         $.ajax({
                url: "{{  route('items-filter')}}",
                type: 'GET',
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'dep':dep,'cat':cat},
                success: function (data) {
                 console.log(data);
               if(data){
                       $('#item-table').empty().html(data);
                }
                 
                }
            })
      });

    });
</script>
@endsection