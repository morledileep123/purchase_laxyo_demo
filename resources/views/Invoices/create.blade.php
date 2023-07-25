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
  <div class="card shadow">
      <div class="content-header">
         <div class="container-wrap mx-3">
            <div class="row">
               <div class="col-sm-6">
                  <h5 class="m-0">Generate GRR</h5>
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
      
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form action="{{route('GoodsReceivedNote.store')}}" method="post" enctype="multipart/form-data">
            @csrf  
            <div class="row">
               <!-- left column -->
                <div class="col-md-4">
                <!-- general form elements -->
                    <div class="card">
                    <input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}"/>
                        <div class="card-header bg-light">
                          <h3 class="card-title">Goods Sent By</h3>
                        </div>                           
                        <div class="card-body">
                          <p style="margin:0px;">
                            <select name="vender_details" id="vendor_data" class="form-control">
                                <option selected hidden >Vendor</option>
                                @foreach($vendors as $vendor)
                                <option value="{{$vendor->id}}">{{$vendor->company}}</option>
                                @endforeach
                                <option value="abc" class="os">Other</option>
                            </select>
                          </p>
                          <div class="form-group details" style="margin-top:20px;">
                             <textarea class="form-control" rows="5" id="data" style="display:block;"readonly></textarea>
                          </div>
                          <div id="browserother" style="margin-top:21px;">
                            <textarea name="vender_detail" id="browseradd" class="form-control details" rows="5" placeholder="Vendor Details"></textarea>
                          </div>
                        </div>
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

                <div class="col-md-4">
                  <div class="card">
                     <div class="card-header bg-light">
                        <h3 class="card-title">Invoice to</h3>
                     </div>
                     <div class="card-body">
                        <select class="form-control" id="company" name="company_location">
                            <option selected hidden>Location</option>
                            <option value="1">Laxyo House, Indore </option>
                            <option value="2">Laxyo Tower, Ratlam </option>
                        </select>
                        <br>
                        <div>
                           <textarea class="form-control" rows="5" id="company_location" style="display:block;" readonly></textarea>   
                        </div> 
                     </div>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                        <h3 class="card-title">Invoice no</h3>
                        </div>
                        <div class="card-body">
                           <input type="text" name="invoice_no" class="form-control">
                        </div>                          
                  </div>
                </div>  
                <div class="col-md-4">  
                  <div class="card">
                    <div class="card-header bg-light">
                    <h3 class="card-title">Invoice date</h3>
                    </div>
                    <div class="card-body">
                       <input type="date" name="invoice_date" class="form-control">
                    </div>                      
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                           <h3 class="card-title">Delivery Date</h3>
                        </div>
                        <div class="card-body">
                           <input type="date" name="delivery_date" class="form-control">
                        </div>                            
                    </div>
                </div> 

               

               @include('Invoices.important')

            </div>
         
        <button type="submit" name="submit" class="btn btn-primary sub-btn">Generate Invoice</button>
      </form>
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
           url:'/send_vendor_invoice',
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
   
    $("#company").change(function(){
       let company = $("#company").val();
       
       jQuery.ajax({
       url:'/company_details',
       type:'get',
       data:'company='+company+'&_token={{csrf_token()}}',
       success:function(result){
          $("#company_location").html(result);
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





