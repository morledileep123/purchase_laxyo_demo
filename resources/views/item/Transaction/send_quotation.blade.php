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

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
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


                <div class="col-md-6">
                    <div class="card">
                      <div class="card-header bg-light">
                        <h3 class="card-title">Delivery Location</h3>
                      </div>
                     
                        <div class="card-body">
                          <div class="form-group">
                            <textarea class="form-control rounded-0" rows="6" name="delivery_address" placeholder="Full Address Details"></textarea>
                            
                          </div>
                          
                        </div>
                        <!-- /.card-body -->
                      
                    </div>
                </div>


                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Select Vendor</h3>
                        </div>
                        <div class="table-responsive">  
                            <table class="table table-bordered" id="dynamic_field">  
                                <tr>  
                                    <td>
                                    <select name="vendore_company[]" id="vendore_company" data-srno="1"  class="form-control vendore_company"  required/>
                                       <option>Select Vendor</option>
                                       @foreach($vendors as $vendor)
                                        <option value="{{$vendor->company}}">{{$vendor->company}}</option>
                                       @endforeach
                                    </select> 
                                    </td>
                                    <td><button type="button" name="add" id="add" class="btn btn-success btn-sm">Add More</button></td>  
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
                                <td><input type="date" name="delivery_date" class="form-control"></td>
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
                    <th>Quantity</th>
                    <th>unit</th>
                    <th>Description</th>
                    <th>Remark</th>
                    <th></th>   
                  </tr>
                  <tr>
                    <td><span id="sr_no">1</span></td>
                    <td>
                      <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required/>
                      <div id="itemList1" /></div>
                    </td>
                    <td colspan="3">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="number" name="quantity[]" id="quantity1" data-srno="1" class="form-control input-sm unit" required/>
                        </div>

                         <div class="col-md-3">
                          <select name="quantity_unit[]"id="quantity_unit" data-srno="1" class="form-control input-sm unit" required/>
                           <option>Select unit</option>
                           @foreach($units as $unit)
                            <option value="{{$unit->name}}">{{$unit->name}}</option>
                           @endforeach
                          </select>
                        </div>

                        <div class="col-md-5">
                      <textarea name="description[]" id="description1" data-srno="1" class="form-control input-sm number_only description" ></textarea>
                        </div>

                      </div>
                    </td>
                    <td>
                      <div class="row">
                      
                        <div class="col-md-12">
                      <textarea name="remark[]" id="remark1" data-srno="1" class="form-control input-sm number_only remark" ></textarea>
                        </div>
                      </div>
                    </td>
                    <div align="right">
                  <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">Add More</button></td>
                </div>
                  </tr>
                </table>
               

                    </div>
                </div>
            </div>
        </div>
            
          </div>
        </div>
        <!-- /.card-body -->
         <button type="submit" name="submit" class="btn btn-primary sub-btn" onclick="return confirm('Are you sure you want to submit this from?');">Send Quotation to Vendor</button>
     </form>
    </div>

</div>
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
    
    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" autocomplete="off" required/><div id="itemList'+count+'"></div><input type="hidden" name="user_id[]" value="{{ Auth::user()->id }}" id="user_id'+count+'" class="form-control input-sm" /></td>';

    html_code += '<td colspan="3"><div class="row"> <div class="col-md-4"><input type="number" name="quantity[]" id="quantity'+count+'" data-srno="1" class="form-control input-sm unit" required/></div> <div class="col-md-3"><select name="quantity_unit[]" class="form-control input-sm quantity_unit"><option>Select unit<?php echo fill_unit_select_box($connect ?? ''); ?></option></select></div>   <div class="col-md-5"><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm number_only description"></textarea></div>   </td>';

    html_code += '<td><div class="row"><div class="col-md-12"><textarea name="remark[]" id="remark'+count+'" data-srno="'+count+'" class="form-control input-sm number_only remark"></textarea></div></div></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);

  });





  
  $(document).on('click', '.remove_row', function(){
    var row_id = $(this).attr("id");
    var total_item_amount = $('#order_item_final_amount'+row_id).val();
    var final_amount = $('#final_total_amt').text();
    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
    $('#final_total_amt').text(result_amount);
    $('#row_id_'+row_id).remove();
    count--;
    $('#total_item').val(count);
  });

  
});




 $(document).ready(function(){      
      var postURL = "<?php echo url('addmore'); ?>";
      var i=1;  


      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="col-md-12"><select name="vendore_company[]" class="form-control input-sm vendore_company"><option>Select vendor<?php echo fill_vendor_select_box($connect ?? ''); ?></option></select></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      $('#submit').click(function(){            
           $.ajax({  
                url:postURL,  
                method:"POST",  
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)  
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                    }
                }  
           });  
      });  


      function printErrorMsg (msg) {
         $(".print-error-msg").find("ul").html('');
         $(".print-error-msg").css('display','block');
         $(".print-success-msg").css('display','none');
         $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
         });
      }
    });  
</script>