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
    <div class="card shadow mt-1">
      <div class="content-header">
         <div class="container-wrap mx-4">
            <div class="row">
               <div class="col-sm-6">
                  <h4 class="m-0">Generate Purcahse Order</h4>
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
               <h2 class="card-title ml-4">Create <small>Purchase Order</small></h2>
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

                           @include('Generate_Purchase_Order.important')


                  </div>
                  
                <button type="submit" name="submit" class="btn btn-primary sub-btn">Generate Purchase Order</button>
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


   $(document).on('click', ".item-select", function(e){

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





