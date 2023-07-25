@extends('layouts.master')
@section('content')
<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5>Purchase Order Lists</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
              	<div class="float-right">
			            <ol class="float-sm-right">
			            <button type="button" class="btn dropdown-toggle btn-success btn-sm" data-toggle="dropdown">Create Document</button>
			            <div class="dropdown-menu">
		                <a class="dropdown-item border-bottom" href="{{url('/ItemsAndVendor')}}">Vendors</a>
		                <a class="dropdown-item border-bottom" href="{{url('/vendoritems')}}">Items and Vendors</a>
			            </div>&nbsp;&nbsp;
			            	<a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
			            </ol>
		        		</div>                
              </div>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="my-2">
                <form action="{{route('Enquiry.index')}}" method="get">
                @csrf
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="date" class="form-control" name="end_date">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-sm" type="submit">GET</button>
                </div>
                </form>
            </div>
            <div class="my-2">
            	<select name="vendor_company" class="form-control">
                <option value="">Select Vendor</option>
                @foreach ($vendors as $key => $vendor)
                   <option value="{{$vendor->company}}">{{$vendor->company}}</option>
                @endforeach
              </select>
            </div>
            <div class="table-responsive">
	            <table class="table table-bordered" id="user-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Company Name</th>
                        <th>Items Names</th>
                        <th>Created date</th>
                        {{-- <th scope="col">Approve person</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bodyData">
                  @foreach ($data as $key => $row)
                  <tr class="bodyDataloopdata">
                    <th scope="row">{{ ++$key }}</th>
                    <td>{{ $row->code }}</td>

                    @if($row->vendor_details_company != '')
                      <td>{{ $row->vendor_details_company }}</td> 
                    @else
                      <td>{{ $row->vender_detail }}</td>
                    @endif
                                
                    <td>{{ $row->invoice_product }}</td>
                    <td>{{ $row->date }}</td>
                    	                    
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">Action
                        </button>
                        <div class="dropdown-menu">      
                          <a class="dropdown-item" href="{{route('Enquiry.show',$row->id )}}"><i class="fa fa-eye" aria-hidden="true"></i>  View</a>                     
                          <a class="dropdown-item" href="{{url('pdf_download',$row->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"></i>  Download</a>                            
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
	            </table>
        		</div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
    $('select[name="vendor_company"]').on('change',function(){
      var vendorCompany = $(this).val();
      let _token = $("input[name=_token]").val();
      
      if(vendorCompany != "") {

        $.ajax({
          url: "{{url('send_vendor_company')}}",
          type:"POST" ,
          data: {
            vendorCompany:vendorCompany,
            _token:_token
          },
          success:function(data) {         
          console.log(data);
          var resultData = data.data;
          var bodyData = '';
          var i=1;
          $.each(resultData,function(index,row){
            var editUrl = "EnquiryShow"+'/'+row.id;
            bodyData+="<tr>"
            bodyData+="<td>"+ i++ +"</td><td>"+row.code+"</td><td>"+row.vendor_details_company+"</td><td>"+row.invoice_product+"</td>"
            +"<td>"+row.date+"</td><td><a class='btn btn-secondary btn-sm' href='"+editUrl+"'>View</a>"+"</td>";
            bodyData+="</tr>";
          })
          $(".bodyDataloopdata").hide();
          $("#bodyData").append(bodyData); 
           

          }
        });
      }else{
        $('select[name="city"]').empty();
      }
    });
  });

</script>
@endsection