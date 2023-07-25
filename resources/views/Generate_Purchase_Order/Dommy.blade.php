@extends('../layouts.master')
@section('content')
<style>
   #browserother{display:none;}
   .vendor-margin .form-group{
   margin-bottom: 4px;
   }
</style>
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
   function fill_items_select_box($connect)
   { 
     $query = DB::table('prch_req_quotation')->where('manager_status','=',1)->where('item_status','=',0)->pluck('item_name');
     //dd($query);
      $output = '';
      
      foreach($query as $row)
      {
       $output .= '<option value="'.$row.'">'.$row.'</option>';
      }
     return $output;
   }
   ?> 
<div class="container-fluid">
   <div class="card shadow mt-3">
      <!-- Content Wrapper. Contains page content -->
      <!-- Content Header (Page header) -->
      <div class="content-header">
         <div class="container-wrap ml-3">
            <div class="row">
               <div class="col-sm-6">
                  <h4 class="m-0"> Purcahse Order  <small> Create</small></h4>
               </div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <div class="container-fluid">
         <div class="card shadow mt-1">
            <div class="card-header">
               <h2 class="card-title ml-4">Send P O</h2>
               <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                  </button>
               </div>
            </div>
            <div class="card-body vendor-margin">
               <div class="row">
                  <div class="col-md-12">
                     <form action="{{route('generate_po.store')}}" method="post">
                        @csrf  
                        <div class="row">
                           <!-- left column -->
                           <div class="col-md-4">
                              <!-- general form elements -->
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Vendor Details</h3>
                                 </div>
                                 <!-- /.card-header -->
                                 <!-- form start -->
                                 <div class="card-body">
                                    <p style="margin:0px;">
                                       <select name="vender_details" id="vendor_data" class="form-control">
                                          <option selected hidden>Vendor</option>
                                          @foreach($vendors as $vendor)
                                          <option value="{{$vendor->id}}">{{$vendor->company}}</option>
                                          @endforeach
                                          <option value="abc" class="os">Other</option>
                                       </select>
                                    </p>
                                    <p style="color: red; margin:1px; font-size: 14px;">When manually inserting vendor details ,EMAIL is mandatory.</p>
                                    <div id="browserother">
                                       <input type="email" name="Other Browser" class="form-control" id="browserlabel" placeholder="Vendor Email" size="50" />
                                       <textarea name="Other Browser" id="browseradd" style="margin:1px; display:block;" class="form-control" type="text" rows="3" placeholder="Vendor Details" ></textarea>
                                    </div>
                                    <div class="form-group details">
                                       <textarea class="form-control" rows="5" name="vendor_address" id="data" style="display:block;"readonly></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Company Address</h3>
                                 </div>
                                 <div class="card-body">
                                    <select id="a" class="form-control">
                                       <option selected hidden>Location</option>
                                       <option value="1">Laxyo House , County Park Mahalaxmi Nagar , Indore</option>
                                       <option value="2">Laxyo Tower , T.I.T. Road , Ratlam</option>
                                    </select>
                                    <br>
                                    <div class="form-group">
                                       <textarea class="form-control" rows="5" name="company_address" id="country" readonly></textarea>
                                    </div>
                                 </div>
                                 <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Delivery Location</h3>
                                 </div>
                                 <div class="card-body">
                                    <select id="delivery_date" class="form-control">
                                       <option selected hidden>Sites Name</option>
                                       @foreach($sites as $site)
                                       <option value="{{$site->id}}">{{$site->name}}</option>
                                       @endforeach
                                    </select>
                                    <br>
                                    <div class="form-group">
                                       <textarea class="form-control" rows="5" name="delivery_address" id="location" style="display:block;"></textarea>   
                                    </div>
                                 </div>
                                 <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Items</h3>
                                 </div>
                                 <table id="invoice-item-table" class="table table-bordered table-responsive">
                                    <tr class="text-center">
                                       <th>S.No</th>
                                       <th>Item Name</th>
                                       <th>Description</th>
                                       <th>Quantity</th>
                                       <th>Unit</th>
                                       <th>Price</th>
                                       <th>Tax</th>
                                       <th>Total</th>
                                       <th>Comment</th>
                                       <th></th>
                                    </tr>
                                    <tr>
                                       <td><span id="sr_no">1</span></td>
                                       <td>
                                          <select name="item_name[]" id="item_name1" data-srno="1" class="form-control input-sm unit">
                                             <option hidden>Select Item Name</option>
                                             @foreach($items as $item)
                                             <option value="{{$item}}">{{$item}}</option>
                                             @endforeach
                                          </select>
                                          <div id="itemList1" /></div>
                                          <input type="hidden" name="user_id[]" id="user_id1" class="form-control input-sm" value="{{ Auth::user()->id }}" />
                                       </td>
                                       <td>
                                          <div class="row">
                                             <textarea name="description[]" id="description1" data-srno="1" class="form-control input-sm number_only description"></textarea>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number" name="quantity[]" id="quantity1" data-srno="1" class="form-control" required>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <select name="quantity_unit[]"id="quantity_unit" data-srno="1" class="form-control" required>
                                                <option hidden>Select unit</option>
                                                @foreach($units as $unit)
                                                <option value="{{$unit->name}}">{{$unit->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number" name="price[]" id="price" data-srno="1" class="form-control" required>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number" name="tax[]" id="tax" data-srno="1" class="form-control" required>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number" name="total[]" id="total" data-srno="1" class="form-control" required>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <textarea name="comment[]" id="description1" data-srno="1" class="form-control number_only comment"></textarea>
                                          </div>
                                       </td>
                                       <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">+</button></td>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                  </div>
                  <!-- left column -->
                  <div class="col-md-7">
                  <!-- general form elements -->
                  <div class="card">
                  <div class="card-header bg-light">
                  <h3 class="card-title">Payment Terms and Condition</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                  <div class="form-group">
                  <textarea cols='60' name='hbsifuvhhrh[]' class='form-control' rows='7'>1) Advance along with order&#13;&#10;2) Payment against perform invoice&#13;&#10;3) Payment against delivery &#13;&#10;4) Payment within days of receipt of materials </textarea>
                  </div>
                  </div>
                  </div>
                  </div>
                  <!-- Right column -->
                  <div class="col-md-5">
                  <!-- general form elements -->
                  <div class="card">
                  <div class="card-header bg-light">
                  <h3 class="card-title">Calculation</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                  <div class="form-group">
                  <textarea class="form-control" rows="5" name="vendor_address" id="data"></textarea>
                  </div>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card">
                  <div class="card-header bg-light">
                  <h3 class="card-title">Warranty And </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                  <div class="form-group">
                  <textarea cols='60' name='hbsifuvhhrh[]' class='form-control' rows='7'>1) Advance along with order&#13;&#10;2) Payment against perform invoice&#13;&#10;3) Payment against delivery &#13;&#10;4) Payment within days of receipt of materials </textarea>
                  </div>
                  </div>
                  </div>
                  </div>
             </div>
          </form>
           
               <button type="submit" name="submit" class="btn btn-primary sub-btn" onclick="return confirm('Are you sure you want to submit this from?');">Send Quotation</button>
                
              </div>
            </div>
          </div>
         </div>
    

    

    

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
   $(document).ready(function(){
     $("#a").change(function(){
       let a = $("#a").val();
       jQuery.ajax({
       url:'/company_full_detail',
       type:'get',
       data:'a='+a+'&_token={{csrf_token()}}',
       success:function(result){
         if(result){
             $("#country").val(result);
           }else{
             $("#college").empty();
           }
       }
       })
         // $("#b").val(a);
     });
   
   });
   
   $(document).ready(function(){
   
     var count = 1;
   
     $('#vendor_data').change(function(){ 
       var query = $(this).val();
       var values = {};
   
       if(query != '')
       {
         $.ajax({
           url:'/send_vendor',
           method:"POST",
           data:'query='+query+'&_token={{csrf_token()}}',
           success:function(response){
              
              $('#data').html(response);
           }
         });
       }
       else
       {
         $('#data').fadeOut();
       }
     });
   
   });
   
   
   $(document).ready(function(){
   
     $('#delivery_date').change(function(){ 
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
   $(document).ready(function(){
   
   var final_total_amt = $('#final_total_amt').text();
   var count = 1;
   
   $('#item_name'+count).on('click', function(){ 
     var query = $(this).val();
     if(query != '')
     {
       var _token = $('input[name="_token"]').val();
       $.ajax({
         url:"{{ route('item_details') }}",
         method:"POST",
         data:{query:query, _token:_token},
         success:function(data){
         console.log(data);
           $('#itemList'+count).fadeIn();  
           $('#description'+count).val(data);
   
         }
       });
     }
     else
     {
       $('#itemList'+count).fadeOut();
     }
   });
   
   $(document).on('click', '#add_row', function(){
     count++;
     
     $('#total_item').val(count);
     var html_code = '';
   
     html_code += '<tr id="row_id_'+count+'">';
     html_code += '<td><span id="sr_no">'+count+'</span></td>';
     
     html_code += '<td><div class="row"><select name="item_name[]" id="item_name'+count+'" class="form-control input-sm"  autocomplete="off"><option hidden>Select item<?php echo fill_items_select_box($connect ?? ''); ?></option></select></div><div id="itemList'+count+'"></div><input type="hidden" name="user_id[]" value="{{ Auth::user()->id }}" id="user_id'+count+'" class="form-control input-sm" /></td>';
   
     html_code += '<td><div class="row"><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm number_only description"></textarea></div></td>';
   
     html_code += '<td><div class="row"><input name="quantity[]" id="quantity'+count+'" data-srno="'+count+'" class="form-control input-sm"></div></div></td>';
   
     html_code += '<td><div class="row"><select name="quantity_unit[]" class="form-control input-sm quantity_unit"><option hidden>Select unit<?php echo fill_unit_select_box($connect ?? ''); ?></option></select></div></td>';
   
     html_code += '<td><div class="row"><input name="price[]" id="price'+count+'" data-srno="'+count+'" class="form-control input-sm"></div></td>';
   
     html_code += '<td><div class="row"><input name="tax[]" id="tax'+count+'" data-srno="'+count+'" class="form-control input-sm"></div></td>';
   
      html_code += '<td><div class="row"><input name="total[]" id="total'+count+'" data-srno="'+count+'" class="form-control input-sm number_only total"></div></td>';
   
     html_code += '<td><div class="row"><textarea name="comment[]" id="comment'+count+'" data-srno="'+count+'" class="form-control input-sm"></textarea></div></td>';
     html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>';
     html_code += '</tr>';
     $('#invoice-item-table').append(html_code);
   
     $('#item_name'+count).on('click', function(){ 
       var query = $(this).val();
   
       if(query != '')
       {
         var _token = $('input[name="_token"]').val();
         $.ajax({
           url:"{{ route('item_details') }}",
           method:"POST",
           data:{query:query, _token:_token},
           success:function(data){
             $('#itemList'+count).fadeIn();  
             $('#description'+count).val(data);
           }
         });
       }
       else
       {
         $('#itemList'+count).fadeOut();
       }
     });
     
     $(document).on('click', 'li', function(){ 
       $('#item_name'+count).val($(this).text()); 
       $('#itemList'+count).fadeOut(); 
     });
   
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
   
   
</script>
<script type="text/javascript">
   $(document).ready(function(){
     $('p select[name=vender_details]').change(function(e){
     if ($('p select[name=vender_details]').val() == 'abc'){
       $('#browserother').show();
       $('#data').hide();
     }else{
       $('#browserother').hide();
       $('#data').show();
     }
   })
   });
   
</script>