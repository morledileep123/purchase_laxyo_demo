<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>GRR</title>

    <style>
    .modal-autoheight .modal-body {
      position: relative;
      overflow-y: auto;
      min-height: 300px !important;
     
    }
    </style>
  </head>
  <body>

  <div class="wrapper">

    <nav class="navbar navbar-light bg-light justify-content-between" style="background-color: #fff;">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            @if($data->decline_status == null && $data->hold_status == null)
            <form action="{{url('sendadmin/'.$data->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
              <input type="hidden" name="id" value="{{$data->id}}">
              <input type="hidden" name="team_id" value="{{$data->team_id}}">
              <button class="btn btn-success btn-sm" style="color:white" name="submit">Send to Admin</button>
            </form>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#HoldreasonModal">Hold</button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">Reject</button>      
            @endif
          </div>
        </div>

        <a href="/">
        <img src="{{asset('assets/img/laxyo_pic.png')}}" class="thumbnail img-responsive" alt="Laxyo Energy LTD" style="max-width: 60%;">
        </a>

      <div class="form-inline">
        <div class="btn-group">
          <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">Action
          </button>
          <div class="dropdown-menu">  
            <a class="dropdown-item" href="javascript:printdoc();" onclick="window.print()" href="#"><i class="fa fa-print" aria-hidden="true"></i> Print</a>  
            <a class="dropdown-item" href="{{url('invoicedownloadmanager',$data->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i>PDF Download</a>                        
          </div>
          <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Back</a>
        </div>
      </div>
      </div>
    </nav>
    <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section>
      <div class="container my-3">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding:0px;">
                            
                <div class="container-fluid">
                  <div class="row mt-4">
                    <h4 style="text-align:center; display: block; margin: 0 auto; margin-top: 20px !important;">GRR</h4>
                  </div>
                  <br>

                  <div class="container-fluid ml-5">
                    <div class="row">
                      <div class="col-md-8">
                        <p>GRR no : {{$data->grn_no}}</p>
                        <p>PO no : {{$data->po_no}}</p>
                        <p>Invoice no : {{$data->invoice_no}}</p>
                        <p>Delivery Date : {{date('d-m-Y', strtotime($data->delivery_date))}}</p>
                      </div>
                      <div class="col-md-4">
                        <p>GRR Date : {{date('d-m-Y', strtotime($data->grr_date)) }}</p>
                        <p>PO Date : {{date('d-m-Y', strtotime($data->po_date)) }}</p>
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
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table" border="2">
                          <thead style="background-color:#f2f2f2">
                            <tr>
                              <th width="1%">S.N</th>
                              <th>Item Name</th>                       
                              <th width="9%">PO QTY</th>
                              <th>Invoice QTY</th>
                              <th>Approved QTY</th>                             
                              <th>Remark</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php $i=1; @endphp
                            @foreach($items as $key => $row)
                            <tr>
                              <td>{{$i++}}</td>
                              <td>{{$row->item_name}}</td>
                              <td>{{$row->po_qty}}</td>                              
                              <td>{{$row->invoice_qty}}</td>
                              <td>{{$row->approve_items}}</td>
                              <td>{!! nl2br(e($row->description)) !!}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>          
                      </div>
                    </div>
                  </div>
                  <br> 

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-6">
                        <p><strong>Comment : </strong>{!! nl2br(e($data->comments)) !!}</p> 
                      </div>
                      <div class="col-md-6">
                        <p><strong>Final Amount : </strong>{{$data->grand_total}}</p> 
                        <p><strong>Final Amount In words : </strong>{{$data->amount_rupees}}</p> 
                      </div>
                    </div>
                    <br>
                  </div>
                  
                  <div class="container-fluid">
                    <div class="row">
                      @if($data->invoice_doc != null)
                        <div class="col-md-6">
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#InvoiceModal">Invoice DOC </button> 
                        </div>
                      @endif
                      @if($data->lorry_receipt_doc != null)
                        <div class="col-md-6">
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#larryModal">Lorry Reciept DOC </button> 
                        </div>
                      @endif                                           
                    </div>
                    <br>
                  </div>

                  </div>

                </div>
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      </section>
   
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


</div>
<!-- ./wrapper -->
    
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
  $(document).ready(function(){

    $('.DeleteReason').click(function(e){
      e.preventDefault();

      var reject = $(this).val();
      $('#reject').val(reject);

      $('#DeleteReasonModal').modal('show');

    });

    function resize() {
      var winHeight = $(window).height();
      $(".modal-autoheight .modal-body").css({
        width: "auto",
        height: (winHeight - 200) + "px"
      });
    }

  });
</script>

<!-- Modal Decline reason -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject GRR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('reject_invoice', $data->id)}}" method="post">
        @csrf
        <div class="modal-body">
          <textarea class="form-control" name="reject" rows="5" placeholder="Reason .."></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Hold reason -->
<div class="modal fade" id="HoldreasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hold GRR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('hold_grr_reason', $data->id)}}" method="post">
        @csrf
        <div class="modal-body">
          <textarea class="form-control" name="hold_reason" rows="5" placeholder="Reason .."></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal show reason -->
<div class="modal fade" id="DeleteReasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Declined Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <textarea name="reject" class="form-control" id="reject" rows="7%" cols="48%" readonly></textarea>
      </div>
    </div>
  </div>
</div>

<!-- Invoice Modal -->
<div class="modal fade" id="InvoiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog modal-lg" style="height:100%;">
    <div class="modal-content" style="height:100%;">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Invoice DOC</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe src="{{asset($data->invoice_doc)}}" width="600" height="780" style=" display:block;position: fixed;top: 66px;bottom: 0px;right: 0px;width: 100%;border: none;margin: 0;padding: 0;overflow: hidden;z-index: 3;height: 100%; margin-left:auto; margin-right:auto;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Lorry Reciept Modal -->
<div class="modal fade" id="larryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog modal-lg" style="height:100%;">
    <div class="modal-content" style="height:100%;">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Lorry Reciept</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe src="{{asset($data->lorry_receipt_doc)}}" width="600" height="780" style=" display:block;position: fixed;top: 66px;bottom: 0px;right: 0px;width: 100%;border: none;margin: 0;padding: 0;overflow: hidden;z-index: 3;height: 100%; margin-left:auto; margin-right:auto;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>


