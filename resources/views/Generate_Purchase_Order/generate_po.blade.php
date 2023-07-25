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
    <!-- Content Header (Page header) -->
    <div class="card shadow mt-3">
      <div class="content-header">
         <div class="container-wrap ml-3">
            <div class="row">
               <div class="col-sm-6">
                  <h4 class="m-0"> Purcahse Order  <small> Create</small></h4>
               </div>
               <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
                  </ol>
                </div>  
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
      </div>

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
                     <form action="{{route('generate_po.store')}}" method="post" enctype="multipart/form-data">
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
                                 <input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}" />
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
                                    
                                    <div id="browserother">
                                       <p style="color: red; margin:1px; font-size: 14px;">When manually inserting vendor details ,EMAIL is mandatory.</p>
                                       <input type="email" name="vender_email" class="form-control" id="browserlabel" placeholder="Vendor Email" size="50" />
                                       <textarea name="vender_detail_infor" id="browseradd" style="margin:0px; display:block;" class="form-control" type="text" rows="3" placeholder="Vendor Details" ></textarea>
                                    </div>
                                    <div class="form-group details" style="margin-top:20px;">
                                       <textarea class="form-control" rows="5" name="vender_detail" id="data" style="display:block;"readonly></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Subject and Body contents</h3>
                                 </div>
                                 <div class="card-body" style="margin-bottom:10px;">
                                     <input type="text" name="subject" value="Purchase order for " class="form-control" style="margin-bottom:20px;">                      
                                 
                                    <textarea type="text" name="subject_contents" class="form-control" rows="5"> With reference to your quotation and subsequent discussion, we are pleased to place Order for the purchase of following items as detailed below under stipulated Terms and Conditions:</textarea>                                     
                                 </div>
                                 <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Consignee / Delivery Location</h3>
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
                           <div class="col-md-3">
                              <div class="card">
                                <div class="card-header bg-light">
                                   <h3 class="card-title">Quotation NO</h3>
                                </div>
                                <div class="card-body"> 
                                   <input type="text" name="quotation_no" class="form-control" value="Quotation no                  Date ">
                                </div>
                                <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="card">
                                <div class="card-header bg-light">
                                   <h3 class="card-title">Delivery Date</h3>
                                </div>
                                <div class="card-body">
                                   <input type="date" name="delivery_date" class="form-control">
                                </div>
                                <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">PO code Location</h3>
                                 </div>
                                 <div class="card-body">
                                    <div class="form-group">
                                       <select class="form-control" name="code_location">
                                         <option selected hidden>code Location</option>
                                         <option value="IND">Laxyo House, Indore / IND</option>
                                         <option value="RAM">Laxyo Tower, Ratlam / RAM</option>
                                       </select>  
                                    </div>
                                 </div>
                                 <!-- /.card-body -->
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Person Name and Mobile No <small>Consignee / Delivery Location</small></h3>
                                 </div>
                                 <div class="card-body">
                                    <div class="form-group">
                                       <input type="text" name="perosn_name" class="form-control" placeholder="Name and number">
                                    </div>
                                 </div>
                              </div>
                           </div>


                            <div class="col-md-12">
                              <div class="card" >
                                 <div class="card-header bg-light">
                                    <h3 class="card-title">Items</h3>
                                 </div>
                                 <table id="invoice_table" class="table table-bordered table-responsive">
                                    <thead>
                                       <tr class="text-center">                                    
                                       <th>Item Name</th>
                                       <th>Description</th>
                                       <th>Quantity</th>
                                       <th>Unit</th>
                                       <th>Unit Price</th>
                                       <th>Tax</th>
                                       <th>Sub Total</th>
                                       <th>Total</th>
                                       <th>Comment</th>
                                       <th>
                                          <button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm add-row">+</button>
                                       </th>
                                    </tr>
                                    </thead>
                                    <tbody><tr>                                       
                                       <td>
                                          <input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter Item Name or select">
                                          or <a href="#" class="item-select">Select a Item</a>
                                          <div id="itemList1" /></div>
                                          
                                       </td>
                                       <td>
                                          <div class="row">
                                             <textarea name="description[]" data-srno="1" class="form-control input-sm number_only description"></textarea>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number" name="invoice_product_qty[]" id="quantity1" data-srno="1"  class="form-control calculate invoice_product_price required" required>
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
                                            <input type="number" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" aria-describedby="sizing-addon1" placeholder="0.00">
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="text" class="form-control calculate" name="invoice_product_tax[]">
                                          </div>
                                       </td>
                                        <td>
                                          <div class="row">
                                             <input type="number" class="form-control calculate-sub" name="total[]" id="total" value="0.00" aria-describedby="sizing-addon1" readonly>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <input type="number"  class="form-control calculate-total" name="invoice_product_sub[]" id="invoice_product_sub" value="0.00" aria-describedby="sizing-addon1" readonly>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="row">
                                             <textarea name="comment[]" data-srno="1" class="form-control number_only comment"></textarea>
                                          </div>
                                       </td>
                                       <td><button type="button" name="add_row" id="add_row" class="btn btn-danger btn-sm delete-row">X</button>
                                      </td>
                                    </tr></tbody>
                                 </table>
                              </div>
                           </div>
                        

                  </div>
                  <div class="row">
                  <!-- left column -->
                  <div class="col-md-8">
                  <!-- general form elements -->
                  <div class="card">
                  <div class="card-header bg-light">
                  <h3 class="card-title">Payment Terms and Condition</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                  <div class="form-group">
                  <div clas="row">
                  <div class="col-md-12">
                     <select id="a" class="form-control" name="terms1">
                        <option selected hidden disabled>Advance along with PO</option>
                        <option value="5% Advance along with PO">5% Advance along with PO</option>
                        <option value="10% Advance along with PO">10% Advance along with PO</option>
                        <option value="15% Advance along with PO">15% Advance along with PO</option>
                        <option value="20% Advance along with PO">20% Advance along with PO</option>
                        <option value="25% Advance along with PO">25% Advance along with PO</option>
                     </select>
                  </div><br>
                    <div class="col-md-12">
                     <select id="a" class="form-control" name="terms2">
                        <option selected hidden disabled>Advance against approval of drawing</option>
                        <option value="10% Advance approval of drawing">10% Advance approval of drawing</option>
                        <option value="15% Advance approval of drawing">15% Advance approval of drawing</option>
                     </select>
                  </div><br>
                    <div class="col-md-12">
                     <select id="a" class="form-control" name="terms3">
                        <option selected hidden disabled>Balance payment</option>
                        <option value="Balance payment against performa invoice along with taxes at the time of dispatch">Balance payment against performa invoice along with taxes at the time of dispatch</option>
                        <option value="Balance payment against receipt of material within 7 days">Balance payment against receipt of material within 7 days</option>
                        <option value="10% Payment after receipt vendor dispatch within 30 days">10% Payment after receipt vendor dispatch within 30 days</option>
                        <option value="10% Payment by LC">10% Payment by LC</option>
                        <option value="Balance payment by LC">Balance payment by LC</option>
                     </select>
                  </div>
               </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  <!-- Right column -->
                  <div class="col-md-4">
                  <!-- general form elements -->
                    
                    <div class="card">
                      <div class="card-body" id="invoice_totals">
                        <div class="row">
                           <div class="col-xs-4 col-xs-offset-5">
                              Total (Before Tax) :&nbsp;&nbsp;
                           </div>
                           <div class="col-xs-3">
                              <span class="invoice-sub-total">0.00</span>
                              <input type="hidden" name="invoice_subtotal" id="invoice_subtotal" placeholder="0.00">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-4 col-xs-offset-5">
                              Total Tax :&nbsp;&nbsp;
                           </div>
                           <div class="col-xs-3">
                              <span class="invoice-discount">0.00</span>
                              <input type="hidden" name="invoice_discount" id="invoice_discount" placeholder="0.00">
                           </div>
                        </div>          
                        <div class="row">
                           <div class="col-xs-4 col-xs-offset-5">
                              Total Amount (After Tax) :&nbsp;&nbsp;
                           </div>
                           <div class="col-xs-3">
                              <span class="invoice-total">0.00</span>                           
                              <input type="hidden" name="invoice_total" id="invoice_total">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-4 col-xs-offset-5">
                              <strong>Grand Total :&nbsp;&nbsp;</strong>
                           </div>
                           <div class="col-xs-3">    
                              <input type="text" name="grand_total" id="amount1" class="form-control numbers">
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-4 col-xs-offset-5">
                              <strong>Grand Total in word :&nbsp;&nbsp;</strong>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-3 w-100">    
                             <input type="text" name="amount_rupees" id="amount-rupees" class="form-control" readonly />
                           </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <div class="col-md-8">
                  <!-- general form elements -->
                  <div class="card">
                  <div class="card-header bg-light">
                  <h3 class="card-title">Guarantee And Warranty</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                  <div class="form-group">
                  <textarea cols='60' name='guarantee' class='form-control' rows='7'>The supplied parts should withstand a guarantee against any manufacturing defect for a period of 12 months from the date of use or 18 months from the date of delivery, whichever is earlier.</textarea>
                  </div>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card">
                       <div class="card-header bg-light">
                          <h3 class="card-title">Stamp Signatory <small>Digital Signed</small></h3>
                       </div>
                       <div class="card-body">
                           <select id="sign" class="form-control" name="sign">
                             <option selected hidden>Location</option>
                             <option value="1">Laxyo House, Indore</option>
                             <option value="2">Laxyo Tower, Ratlam</option>
                           </select>
                          <br>
                          <div class="form-group">
                            <img src="" id="signature">
                          </div>
                       </div>
                       <!-- /.card-body -->
                     </div>
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary sub-btn">Send Purchase Order</button>
                {{-- <button type="submit" name="submit" class="btn btn-primary sub-btn" onclick="return confirm('Are you sure you want to submit this from?');">Send Quotation</button> --}}
              </form>
                 </div>
              </div>
                
         </div>
       </div>
    </div>
   
</div>
</div>

{{-- Model --}}
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
<script src="https://apis.google.com/js/platform.js"></script>
<script src="https://www.allphptricks.com/demo/2018/july/convert-numbers-into-words/js/num-to-words.js"></script>
<script src="https://www.allphptricks.com/demo/2018/july/convert-numbers-into-words/js/jquery.min.js"></script>
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



      $('p select[name=vender_details]').change(function(e){
     if ($('p select[name=vender_details]').val() == 'abc'){
       $('#browserother').show();
       $('#data').hide();
     }else{
       $('#browserother').hide();
       $('#data').show();
     }
   })
   
    $("#sign").change(function(){
       let sign = $("#sign").val();
       jQuery.ajax({
       url:'/company_sign_pics',
       type:'get',
       data:'sign='+sign+'&_token={{csrf_token()}}',
       success:function(result){
        $('#signature').attr('src',result); 
       }
       })
         // $("#b").val(a);
     })

    $("#action_create_invoice").click(function(e) {
      e.preventDefault();
       actionCreateInvoice();
      });

      

   // remove product row
    $('#invoice_table').on('click', ".delete-row", function(e) {
      e.preventDefault();
         $(this).closest('tr').remove();
        calculateTotal();
    });

    // add new product row on invoice
    var cloned = $('#invoice_table tr:last').clone();
    $(".add-row").click(function(e) {
        e.preventDefault();
        cloned.clone().appendTo('#invoice_table'); 
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
                  url:"{{ route('item_details') }}",
                  method:"POST",
                  data:{query:query, _token:_token},
                  success:function(data){
                  console.log(data);
                      
                    $(product).closest('tr').find('.invoice_product').val(query);
                    $(product).closest('tr').find('.description').val(data);
            
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

     calculateTotal();
       
      $('#invoice_table').on('input', '.calculate', function () {
          updateTotals(this);
          calculateTotal();
      });

      $('#invoice_totals').on('input', '.calculate', function () {
          calculateTotal();
      });

      $('#invoice_product').on('input', '.calculate', function () {
          calculateTotal();
      });

      $('.remove_vat').on('change', function() {
           calculateTotal();
      });

   function updateTotals(elem) {

        var tr = $(elem).closest('tr'),
            quantity = $('[name="invoice_product_qty[]"]', tr).val(),
           price = $('[name="invoice_product_price[]"]', tr).val(),
            isPercent = $('[name="invoice_product_tax[]"]', tr).val().indexOf('%') > -1,
            percent = $.trim($('[name="invoice_product_tax[]"]', tr).val().replace('%', '')),
           subtotal = parseInt(quantity) * parseFloat(price);
           cal_total = parseInt(quantity) * parseFloat(price);

           $('.calculate-sub', tr).val(subtotal.toFixed(2));
        if(percent && $.isNumeric(percent) && percent !== 0) {
            if(isPercent){
                cal_total = cal_total - ((parseFloat(percent) / 100) * cal_total);
            } else {
                cal_total = cal_total - parseFloat(percent);
            }
        } else {
            $('[name="invoice_product_tax[]"]', tr).val('');
        }

       $('.calculate-total', tr).val(cal_total.toFixed(2));
       
   }

   function calculateTotal() {
       
       var grandTotal = 0,
         SubTotal = 0,
         disc = 0,
         c_ship = parseInt($('.calculate.shipping').val()) || 0;

       $('#invoice_table tbody tr').each(function() {
            var c_total = $('.calculate-total', this).val(),
                c_sbt = $('.calculate-sub', this).val(),
                quantity = $('[name="invoice_product_qty[]"]', this).val(),
                price = $('[name="invoice_product_price[]"]', this).val() || 0,
                cal_total = parseInt(quantity) * parseFloat(price);
                cal_sub_total = parseInt(quantity) * parseFloat(price);
            
            grandTotal += parseFloat(c_total);
            SubTotal += parseFloat(c_sbt);
            disc += cal_total - parseFloat(c_total);
       });

         // VAT, DISCOUNT, SHIPPING, TOTAL, SUBTOTAL:
         var calculation_total = parseFloat(grandTotal);
         var calculation_sub_total = parseFloat(SubTotal);
       
         finalTotal = parseFloat(grandTotal + c_ship);
         vat = parseInt($('.invoice-vat').attr('data-vat-rate'));
         
         $('.invoice-sub-total').text(calculation_sub_total.toFixed(2));
         $('#invoice_subtotal').val(calculation_sub_total.toFixed(2));
         $('.invoice-discount').text(disc.toFixed(2));
         $('#invoice_discount').val(disc.toFixed(2));

         $('.invoice-total').text((finalTotal).toFixed(2));
         $('#invoice_total').val((finalTotal).toFixed(2));

   }

      $(".numbers").keypress(function (e) {
         //if the letter is not digit then display error and don't type anything
         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           //display error message
                  return false;
         }
      });

      var words="";

      $(function() {
          $("#amount1").on("keydown keyup", per);
         function per() {
            var totalamount = Number($("#amount1").val());
            $("#totalval").val(totalamount);
            words = toWords(totalamount);
            $("#amount-rupees").val(words);
         }
      });
   
   });
   

   
</script>





