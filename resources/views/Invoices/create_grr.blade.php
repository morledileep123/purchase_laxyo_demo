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

<div class="container-fluid">
    <!-- Content Header (Page header) -->
  <div class="card shadow mx-1">
      <div class="content-header">
         <div class="container-wrap mx-3">
            <div class="row">
               <div class="col-sm-6">
                  <h5 class="m-0">Create GRR <small>(Goods Received Report)</small></h5>
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
      <div class="card shadow">
          <div class="card-body vendor-margin">
              <div class="row">
                <div class="col-md-12">
                  <form action="{{route('GoodsReceivedNote.store')}}" method="post" enctype="multipart/form-data">
                    @csrf  
                    <div class="row">
                       <!-- left column -->
                        <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card">
                        <input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}"/>
                            <div class="card-header bg-light">
                              <h3 class="card-title">Goods Sent By</h3>
                            </div>                           
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
                              {{-- <div class="form-group details" style="margin-top:20px;">
                                 <textarea class="form-control" rows="4" id="data" style="display:block;"readonly></textarea>
                              </div> --}}

                              <div id="browserother">
                                <textarea name="vender_detail_infor" id="browseradd" style="margin:0px; display:block; margin-top:24px;" class="form-control" type="text" rows="4"></textarea>
                              </div>
                              <div class="details">
                                 <textarea class="form-control" rows="4" name="vender_detail" id="data" style="display:block;margin-top:20px;"readonly></textarea>
                              </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="card">
                             <div class="card-header bg-light">
                                <h3 class="card-title">Consignee / Delivery Location</h3>
                             </div>
                             <div class="card-body">
                                <select id="delivery_address" name="delivery_location" class="form-control">
                                   <option selected hidden>Sites Name</option>
                                   @foreach($sites as $site)
                                   <option value="{{$site->id}}">{{$site->name}}</option>
                                   @endforeach
                                </select>
                                <br>
                                <div>
                                   <textarea class="form-control" rows="4" id="location" style="display:block;" readonly></textarea>   
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
                                    <h3 class="card-title">Invoice Date</h3>
                                </div>
                                <div class="card-body">
                                   <input type="date" name="invoice_date" class="form-control">
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-4">    
                            <div class="card">
                                <div class="card-header bg-light">
                                   <h3 class="card-title">GRR Date</h3>
                                </div>
                                <div class="card-body">
                                   <input type="date" name="grr_date" class="form-control">
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-4">    
                            <div class="card">
                                <div class="card-header bg-light">
                                   <h3 class="card-title">PO NO</h3>
                                </div>
                                <div class="card-body">
                                   <input type="text" name="po_no" class="form-control">
                                </div>
                            </div>
                        </div>                       
                        <div class="col-md-4">    
                            <div class="card">
                                <div class="card-header bg-light">
                                   <h3 class="card-title">PO Date</h3>
                                </div>
                                <div class="card-body">
                                   <input type="date" name="po_date" class="form-control">
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

                         @include('Invoices.item_table')

                    
                        <div class="col-md-6">
                          <!-- general form elements -->
                            <div class="card">
                              <div class="card-header bg-light">
                                <h3 class="card-title">Notice / Comment / Remarks</h3>
                              </div>
                              <div class="card-body">
                              <textarea class="form-control" rows="5" name="comments" style="display:block;"></textarea> 
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                <div class="row">
                                   <div class="col-xs-4 col-xs-offset-5">
                                      <strong>Grand Total Amount:&nbsp;&nbsp;</strong>
                                   </div>
                                   <div class="col-xs-3">    
                                      <input type="text" name="grand_total" id="amount1" class="form-control numbers">
                                   </div>
                                </div>
                                <div class="row">
                                   <div class="col-xs-4 col-xs-offset-5">
                                      <strong>Grand Total Amount in word :&nbsp;&nbsp;</strong>
                                   </div>
                                </div>
                                <div class="row">
                                   <div class="col-xs-3 w-100">    
                                     <input type="text" name="amount_rupees" id="amount_rupees" class="form-control" readonly/>
                                   </div>
                                </div>
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                              <div class="card-header bg-light">
                                <h3 class="card-title">Invoice Image / PDF</h3>
                              </div>
                              <div class="card-body">
                              <input type="file" name="invoice_doc" class="form-control">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                              <div class="card-header bg-light">
                                <h3 class="card-title">Lorry Receipt Image / PDF</h3>
                              </div>
                              <div class="card-body">
                              <input type="file" name="lorry_receipt_doc" class="form-control">
                              </div>
                            </div>
                        </div>
                        
                    </div>

                       {{-- @include('Invoices.important') --}}

                </div>
                 
                <button type="submit" name="submit" class="btn btn-primary sub-btn">Send GRR</button>
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
   
      
      var words="";

      $(function() {
          $("#amount1").on("keydown keyup", per);
         function per() {
            var totalamount = Number($("#amount1").val());
            $("#totalval").val(totalamount);
            words = toWords(totalamount);
            $("#amount_rupees").val(words);
         }
      });
   
   });
   

   
</script>





