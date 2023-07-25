@extends('../layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Header (Page header) -->
  <div class="card shadow mx-1">
    <div class="content-header">
        <div class="container-wrap mx-3">
            <div class="row">
               <div class="col-sm-6">
                  <h4 class="m-0">Quotation Order Lists</h4>
               </div>
               <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn dropdown-toggle btn-success" data-toggle="dropdown">
                    Create Document</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item border-bottom" href="{{url('/vendor_quotation/create')}}">Generate Quotation</a>
                    <a class="dropdown-item border-bottom" href="{{url('/generate_po/create')}}">Generate Purchase Order</a>
                </div>&nbsp;&nbsp;
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </ol>
                </div>  
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
    </div>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" style="width: 50%">
                    <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Requested by Sites</b></a>
                  </li>
                  <li class="nav-item" style="width: 50%">
                    <a class="nav-link text-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>RFQ By Vendor</b></a>
                  </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>From</th>
                          <th>To Site</th>                         
                          <th>No of Items</th>
                          <th>Items Names</th>
                          <th>Expected Date</th>
                          <th>status</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; @endphp
                        @foreach($data as $rec)
                         <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ App\User::find($rec->user_id)->name}}</td>
                            <td>{{ $rec->site_id }}</td>
                            <td>{{ (substr_count($rec->item,',')+1) }}</td>     
                            <td>{{ $rec->item }}</td>             
                            <td>{{ $rec->expected_date }}</td>   
                            <td><p>Pending</p></td>   
                            <td>
                                <a href="" class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"><i class="fa fa-lg fa-barcode"></i></a>
                                 &nbsp;&nbsp;&nbsp;
                                <a href="{{route('check_admin_rfq',$rec->id)}}"><i class="fa fa-lg fa-eye"></i></a>
                            </td>   
                            
                          {{--   @endrole --}}
                         </tr>
                        @endforeach
                      </tbody>
                    </table>                
                  </div>


                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Date</th>
                          <th>View</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; @endphp
                        {{-- @foreach($all_rec as $allRec)
                         <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $allRec->warehouse->name }}</td>
                            <td>{{ $allRec->site->job_describe }}</td>
                            <td>{{ $allRec->date }}</td>
                            <td>
                                <a href="{{ route('see_chalan',[$allRec->id]) }}" class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"><i class="fa fa-lg fa-barcode"></i></a>
                                
                                 &nbsp;&nbsp;&nbsp;
                                 <!-- <a href="{{ route('site_item_req',[$rec->receiving_req_id]) }}"><i class="fa fa-lg fa-eye"></i></a> -->
                            </td>
                            <td>
                                @if($allRec->complete == 0)
                                    <h5 style="color: yellow">Pending</h5>
                                @elseif($allRec->complete == 1 && $allRec->super_admin == 0)
                                    <h5 style="color: cyan">Processing</h5>
                                @elseif($allRec->complete == 1 && $allRec->super_admin == 1)
                                    <h5 style="color: green">Completed</h5>
                                @else
                                    <h5 style="color: red">Declined</h5>
                                @endif
                            </td>
                         </tr>
                        @endforeach --}}
                      </tbody>
                    </table>
                  </div>

                </div>
            </div>
    </div>
  </div>
 </div>
</div>


<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $(document).on('click', '.generateDC', function(){
        //alert()
        var request_id = $(this).data('id')
        $.ajax({
            type: 'get',
            url: 'generate_dc',
            data: {'request_id': request_id},
            beforeSend: function() { 
                   $("#generateBtn_"+request_id).text(' Loading ...');
                   $("#generateBtn_"+request_id).attr('disabled',true);
                  // $("#generateOthersBtn_"+request_id).attr('disabled',true);
                   //$("#generateOthersBtn_"+request_id).attr('disabled',true);
                 },
            success: function(res){

              window.location.href = "receiving";
              
              
            }
          });
      });
});

</script>


@endsection