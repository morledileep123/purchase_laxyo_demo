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
            <h2 class="card-title">Send Quotation</h2>
            <div class="float-sm-right">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
            <div class="col-md-12">
                <form action="{{route('vendor_quotation_send')}}" method="post">
                    @csrf
                <div class="row">
                  <!-- left column -->
                    <div class="col-md-6">
                    <!-- general form elements -->
                        <div class="card">
                          <div class="card-header bg-light">
                            <h3 class="card-title">Buyer Details</h3>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                         
                            <div class="card-body">
                              <div class="form-group">
                                <input type="text" name="company_name" class="form-control details" value="Yolax InfraEnergy Pvt Ltd" >
                                <input type="text" name="company_address" class="form-control details" value="Mahalaxmi nagar county park laxyo house ,Indore" >
                                <input type="text" name="phone_no" class="form-control details" value="Phone: +91-731-4043798, Mobile: 8815218210" >
                                <input type="text" name="gst_no" class="form-control details" value="GSTIN - 23AABCL3031E1Z9" >
                              </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title">Delivery Location</h3>
                            </div>
                            <div class="card-body">
                              <div class="form-group">
                                <textarea class="form-control rounded-0" rows="6" name="delivery_address" placeholder="Full Address Details"></textarea>
                              </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                      <div class="card">
                         <div class="card-header bg-light">
                            <h3 class="card-title"> Delivery Location</h3>
                         </div>
                         <div class="card-body">
                            <select id="delivery_date" class="form-control">
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
                         <!-- /.card-body -->
                      </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title">Select Vendor</h3>
                                <button type="button" name="add" id="vendore_company" class="btn btn-success btn-sm float-right">Add More</button>
                            </div>
                            <div class="table-responsive">  
                                <table class="table table-bordered" id="dynamic_field">  
                                    <tr>  
                                        <td>
                                        <select name="vendore_company[]" class="form-control vendore_company" required>
                                           <option hidden>Select Vendor</option>
                                           @foreach($vendors as $vendor)
                                            <option value="{{$vendor->company}}">{{$vendor->company}}</option>
                                           @endforeach
                                        </select> 
                                        </td>
                                        <td><button type="button" name="add" id="delete-row" class="btn btn-danger btn-sm">X</button></td>  
                                    </tr>  
                                </table>   
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title">Delivery Date</h3>
                            </div>
                            <div class="table-responsive">  
                                <table class="table table-bordered">
                                    <tr>
                                    <td><input type="date" name="delivery_date" name="delivery_date" class="form-control"></td>
                                   </tr>
                              </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title">Items</h3>
                            </div>
                            <table id="invoice-item-table" class="table table-bordered">
                          <tr class="text-center">
                            <th>S.No</th>
                            <th>Item Name</th>     
                            <th width="15%">Quantity</th>
                            <th width="16%">unit</th>
                            <th>Description</th>
                            <th>Remark</th>
                            <th width="4%"></th>   
                          </tr>
                          <tr>
                            <td><span id="sr_no">1</span></td>
                            <td>
                              <input type="text" name="item_name[]" class="form-control input-sm item_name" autocomplete="off" required>
                              or <a href="#" class="item-select">Select a Item</a><div id="itemList1"/></div>
                            </td>
                            <td>
                              <input type="number" name="quantity[]" id="quantity1" class="form-control input-sm quantity" required>
                            </td>

                            <td><select name="quantity_unit[]" id="quantity_unit1" class="form-control input-sm quantity_unit" required>
                                   <option>Select unit</option>
                                   @foreach($units as $unit)
                                    <option value="{{$unit->name}}">{{$unit->name}}</option>
                                   @endforeach
                                </select>
                            </td>
                                
                            <td><textarea name="description[]" id="description1" class="form-control input-sm number_only description" ></textarea></td>                            
                            <td>
                              <textarea name="remark[]" id="remark1" class="form-control input-sm number_only remark" ></textarea> 
                            </td>
                            <div>
                              <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">Add</button></td>
                            </div>
                          </tr>
                        </table>

                        </div>
                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary">Send Quotation to Vendor</button> --}}
                <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary" id="submit_form">Send Quotation to Vendor</button>
                </form>
            </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

</div>

<!-- Modal Send mail-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Quotation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Send</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
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



@endsection

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
  
  var final_total_amt = $('#final_total_amt').text();
  var count = 1;
  
  $(document).on('click', '#add_row', function(){
    count++;
    //alert("wrq");
    $('#total_item').val(count);
    var html_code = '';
    html_code += '<tr id="row_id_'+count+'">';
    html_code += '<td><span id="sr_no">'+count+'</span></td>';
    
    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm item_name" autocomplete="off" required/><div id="itemList'+count+'"></div><input type="hidden" name="user_id[]" value="{{ Auth::user()->id }}" id="user_id'+count+'" class="form-control input-sm" />or <a href="#" class="item-select">Select a Item</a><div id="itemList1"/></div></td>';

    html_code += '<td><input type="number" name="quantity[]" id="quantity'+count+'" data-srno="1" class="form-control input-sm unit" required/> </td>';

    html_code += '<td> <select name="quantity_unit[]" class="form-control input-sm quantity_unit" id="quantity_unit'+count+'"><option>Select unit<?php echo fill_unit_select_box($connect ?? ''); ?></option></select> </td>';

    html_code += '<td><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm number_only description"></textarea></td>';

    html_code += '<td><div class="row"><div class="col-md-12"><textarea name="remark[]" id="remark'+count+'" data-srno="'+count+'" class="form-control input-sm number_only remark"></textarea></div></div></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);

  });


  $(document).on('click', '.remove_row', function(){
    var row_id = $(this).attr("id");
    $('#row_id_'+row_id).remove();
    count--;
    $('#total_item').val(count);
  });


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


      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $("#submit_form").click(function(e){

        e.preventDefault();

        var vendore_company = $("option[name=vendore_company").val();
        alert(vendore_company);
        var url = '{{ url('vendore_company_email') }}';

        $.ajax({
           url:url,
           method:'POST',
           data:{
                  Code:vendore_company, 
                },
           success:function(response){
            alert(response);
              if(response.success){
                  alert(response.message) //Message come from controller
              }else{
                  alert("Error")
              }
           },
           error:function(error){
              console.log(error)
           }
        });
    });

  
});




 
</script>