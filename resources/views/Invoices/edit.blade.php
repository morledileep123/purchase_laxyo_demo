@extends('../layouts.master')
@section('content')

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mx-3">
          <div class="col-sm-6">
            <h4>Update <small>GRR</small></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ url('manager_grr_index') }}" class="btn btn-secondary btn-sm">Back</a>
              </div>              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">  
              <form action="{{url('managerinvoiceUpdate',$data->id)}}" method="POST">
              @csrf
              
              <div class="container-fluid"> 
                        
                <div class="row">
                  <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">GRR</h4>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-8">
                    <p>GRR no :  {{$data->grn_no}}</p>
                    <p>PO no :  {{$data->po_no}}</p>
                    <p>Invoice no :  {{$data->invoice_no}}</p>
                    <p>Delivery Date : {{date('d-m-Y', strtotime($data->delivery_date))}}</p>
                  </div>
                  <div class="col-md-4">
                    <p>GRR Date :  {{date('d-m-Y', strtotime($data->grr_date)) }}</p>
                    <p>PO Date :  {{date('d-m-Y', strtotime($data->po_date)) }}</p>
                    <p>Invoice date : {{date('d-m-Y', strtotime($data->invoice_date)) }}</p>                  
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-7">
                    <small>Vendor Detail</small>

                      @if($data->vender_detail_infor != 'null')
                        <h6>{!! nl2br(e($data->vender_detail_infor)) !!}</h6> 
                      @else
                        <h6>{{$data->vender_company}}</h6> 
                        <h6>{{$data->vender_email}}</h6>
                        <h6>{{$data->vender_address1}}</h6>
                        <h6>{{$data->vender_address2}}</h6>
                        <h6>{{$data->vender_state}}</h6>
                        <h6>{{$data->vender_city}}</h6> 
                        <h6>{{$data->vender_person_name}}</h6> 
                        <h6>{{$data->vender_person_email}}</h6> 
                        <h6>{{$data->vender_person_no}}</h6> 
                      @endif 
                    
                  </div>
                  <div class="col-md-5">
                    <small>Delivery Location</small>
                    <p>{{$data->delivery_location}}</p>
                  </div>
                </div>
                <br>

                <div class="row table-responsive">
                <table class="table" border="2">
                  <thead>
                  <tr>
                    <th width="1%">S.N</th>
                    <th width="25%">Item Name</th>                       
                    <th width="9%">PO QTY</th>
                    <th width="15%">Invoice QTY</th>
                    <th width="15%">Approved QTY</th>                             
                    <th>Remark</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php $i=1; @endphp
                  @foreach($items as $key => $row)
                  <tr>
                    <td>{{$i++}}</td>
                    <input type="hidden" name="invoice_no_code[]" value="{{$row->invoice_no_code}}">
                    <td>{{$row->item_name}}</td>
                    <td>{{$row->po_qty}}</td>
                    <td><input type="text" name="invoice_qty[]" value="{{$row->invoice_qty}}" class="form-control"></td>
                    <td><input type="text" name="approve_items[]" value="{{$row->approve_items}}" class="form-control"></td>
                    <td>{{$row->description}}</td>
                    
                  </tr>
                  @endforeach
                  </tbody>
                </table>          
                </div>
                <br>
                 
                <div class="col-5 float-right">
                <p><strong>Final Amount : </strong>{{$data->grand_total}}</p> 
                <p><strong>Final Amount In words : </strong>{{$data->amount_rupees}}</p> 
                </div>
                          
              </div>

              <div class="row">
                <div class="col-12">
                  <strong>Comment :</strong>
                  <textarea type="text" class="form-control" style="white-space: pre-line" name="comments">{{ $data->comments }}</textarea> 
                </div>
              </div>
              <br> 

              <br>
              <button type="submit" name="submit" class="btn btn-primary">Update</button>

              </form>
              <br>    
            </div>
          </div>
        </div>
      </div>
     </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    
  $(document).ready(function(){
    $("#sign").change(function(){
     let sign = $("#sign").val();
     
     jQuery.ajax({
       url:'/company_sign_pics_update',
       type:'get',
       data:'sign='+sign+'&_token={{csrf_token()}}',
       success:function(result){
        
        $('#signature').attr('src',result); 
       }
       })
         // $("#b").val(a);
    });

  });
</script>

@endsection