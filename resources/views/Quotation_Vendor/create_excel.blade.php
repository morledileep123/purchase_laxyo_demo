@extends('../layouts.master')
@section('content')
<style>
    .sub-btn{
        width: fit-content;
        margin-left: 20px;
        margin-bottom: 20px;
    }
    .details{
        border: none !important;
        background: none !important;
    }
</style>
<div class="container-fluid">
    {{--  Alert Message  --}}
    @if (Session::has('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

         {{--  Alert Message  --}}
    <div class="card shadow mt-3">
      <!-- Default box -->
       <?php
      function fill_unit_select_box($connect)
      { 
        $query = DB::table('prch_unitofmeasurements')->pluck('name');
        //dd($query);
         $output = '';
         
         foreach($query as $row)
         {
          $output .= '<option value="'.$row.'">'.$row.'</option>';
         }
        return $output;
      }
      ?> 

       <?php
      function fill_vendor_select_box($connect)
      { 
        $query = DB::table('prch_vendors')->pluck('company');
        //dd($query);
         $output = '';
         
         foreach($query as $row)
         {
          $output .= '<option value="'.$row.'">'.$row.'</option>';
         }
        return $output;
      }
      ?> 
        
    <div class="card-header"> 
        <h2 class="card-title">Generate Quotation with Excel</h2>
        <div class="float-sm-right">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
        <div class="col-md-12">
            <form action="{{route('vendor_quotation.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <!-- left column -->
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Select Vendor</h3>
                            <button type="button" name="add" id="vendore_company" class="btn btn-success btn-sm float-right">Add More</button>
                        </div>
                        <div class="table-responsive">  
                            <table class="table " id="dynamic_field">
                                <td>
                                <select name="vendore_company[]" class="form-control vendore_company" required>
                                   <option hidden>Select Vendor</option>
                                   @foreach($vendors as $vendor)
                                    <option value="{{$vendor->company}}">{{$vendor->company}}</option>
                                   @endforeach
                                </select> 
                                </td>
                                <td><button type="button" name="add" id="delete-row" class="btn btn-danger btn-sm">X</button></td> 
                            </table>   
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                     <div class="card-header bg-light">
                        <h3 class="card-title"> Consignee / Delivery Location</h3>
                     </div>
                     <div class="card-body">
                        <select id="delivery_address" name="delivery_address_data"  class="form-control">
                           <option selected hidden>Sites Name</option>
                           @foreach($sites as $site)
                           <option value="{{$site->id}}">{{$site->name}}</option>
                           @endforeach
                        </select>
                        <br>
                        <div>
                           <textarea class="form-control" rows="4" name="delivery_address" id="location" style="display:block;"></textarea>   
                        </div>
                     </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card">
                     <div class="card-header bg-light">
                        <h3 class="card-title">Buyer Location</h3>
                     </div>
                     <div class="card-body">
                        <select class="form-control" name="code_location">
                            <option selected hidden>Location</option>
                            <option value="1">Laxyo House, Indore </option>
                            <option value="2">Laxyo Tower, Ratlam </option>
                        </select>
                        {{--<br>
                        <div>
                           <textarea class="form-control" rows="4" name="delivery_address" id="location" style="display:block;"></textarea>   
                        </div> --}}
                     </div>
                  </div>
                </div>

                 <div class="col-md-8">
                  <div class="card">
                    <div class="card-header bg-light">
                      <h3 class="card-title">Subject</h3>
                    </div>
                    <div class="card-body">
                      <input type="text" name="subject" class="form-control" value="Inquire for">
                    </div>
                     <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Delivery Date</h3>
                        </div>
                        <div class="table-responsive">  
                            <table class="table">
                            <td><input type="date" name="delivery_date" name="delivery_date" class="form-control"></td>                               
                          </table>
                        </div>
                    </div>
                </div>
                               
                <div class="col-md-8">
                  <div class="card">
                     <div class="card-header bg-light">
                        <h4 class="card-title">Person Name and Mobile No </h4>
                        {{-- <small>Consignee / Delivery Location</small> --}}
                     </div>
                     <div class="card-body">
                        <input type="text" name="person_name" class="form-control" placeholder="Name - number">
                     </div>
                  </div>
                </div>
                
                @include('Quotation_Vendor.Demo', array('some'=>'data'))

            </div>
            <button type="submit" class="btn btn-primary mt-3">Generate Quotation</button>
            {{-- <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary" id="submit_form">Generate Quotation</button> --}}
            </form>
        </div>
        </div>
    </div>
    <!-- /.card-body -->
    </div>

</div>

{{-- Model add product --}}
<div id="insert" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select Product</h4>
      </div>
      <div class="modal-body">
         <select name="item_name[]" id="item_name1" data-srno="1" class="form-control input-sm unit">
             <option selected hidden>Select Item</option>
            @foreach($items as $item)
            <option value="{{$item}}">{{$item}}</option>
            @endforeach
         </select>
      </div>
      <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn btn-primary" id="selected">Add</button>
         <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<style type="text/css">
  .items-dropdown{
    height: 250px !important;
    overflow-x: hidden !important;
    background: #dadada !important;
    width: 100% !important;
  }
  .items-dropdown > li{
    padding: 5px !important;
    border-bottom: 1px solid #8c4949 !important;
}
</style>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){



    // remove product row
    $('#dynamic_field').on('click',"#delete-row",function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    // add new product row on invoice
    var cloned = $('#dynamic_field tr:last').clone();
    $("#vendore_company").click(function(e) {
        e.preventDefault();
        cloned.clone().appendTo('#dynamic_field'); 
    });


     $(document).on('click', ".item-select", function(e) {

         e.preventDefault;

         var product = $(this);
         $('#insert').modal({ backdrop: 'static', keyboard: false }).one('click', '#selected', function(e) {
            
            var query = $('#insert').find("option:selected").text();
            
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                  url:"{{ route('items_details') }}",
                  method:"POST",
                  data:{query:query, _token:_token},
                  success:function(data){
                  console.log(data);
                    var sp = data.split("|");
                    $(product).closest('tr').find('.item_name').val(query);
                    $(product).closest('tr').find('#quantity'+count).val(sp[0]);
                    $(product).closest('tr').find('#quantity_unit'+count).val(sp[1]);
                    $(product).closest('tr').find('#description'+count).val(sp[2]);
            
                  }
               });
               return false;
            }
            else
            {
               $('#itemList').fadeOut();
            }
         });
      });


     $('#delivery_address').change(function(){ 
       var query = $(this).val();
       var values = {};
       
       if(query != '')
       {
         $.ajax({
           url:'/retrive_delivery_location',
           method:"POST",
           data:'query='+query+'&_token={{csrf_token()}}',
           success:function(response){ 
             if(response){
             $("#location").val(response);
             }else{
               $("#location").empty();
             }
              //$('#location').append(response);
           }
         });
       }
       else
       {
         $("#location").empty();
       }
     });

});
</script> 
@endsection

