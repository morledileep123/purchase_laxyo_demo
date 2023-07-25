@extends('layouts.master')
@section('content')
<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5>Item and Vendors Lists</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">              
              <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
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
            <form id="studentForm">
              <div class="input-group">
                @csrf
                <input type="text" name="item_name" id="item_name" class="form-control" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" name="item_no" id="item_no" data-srno="1" class="form-control">
                <button class="btn btn-primary btn-sm" type="submit" id="submitButton">GO</button>&nbsp;&nbsp;&nbsp;
              </div>
            </form>
            <div id="itemList"></div>
            <div id="VendorList"></div>   
            <br>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="4%">S.no</th>
                  <th>Name</th>
                  <th>Company Name</th>
                  <th>Item name</th>
                  <th>Created Date</th>
                  <th width="9%">Action</th>
                </tr>
              </thead>
              <tbody id="bodyData">
                   
              </tbody>
            </table>          
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
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
  
  $('#item_name').keyup(function(){ 
    var query = $(this).val();
    if(query != '')
    {
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('fetchVendor') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
        console.log(data);
        // alert(data);
          $('#itemList').fadeIn();  
          $('#itemList').html(data);
        }
      });
    }
    else
    {
      $('#itemList').fadeOut();
    }
  });

  $(document).on('click', 'li', function(){ 
    $('#item_name').val($(this).text());
    var str = $(this).text();
    console.log(str);
    var sp = str.split("|");
    $('#item_no').val(sp[0]);
    $('#itemList').fadeOut(); 
  });

  $("#studentForm").submit(function(e){
    e.preventDefault();
    let item_no = $("#item_no").val();
    let _token = $("input[name=_token]").val();
    
    if(item_no != ""){
        $.ajax({
        url: "{{route('fetchVendorName')}}",
        type:"POST" ,
        data: {
          item_no:item_no,
          _token:_token
        },
        success: function(response) {
          console.log(response);
          var resultData = response.data;
          var bodyData = '';
          var i=1;
          $.each(resultData,function(index,row){
            var editUrl = "showVendorDetails"+'/'+row.id;
            bodyData+="<tr>"
            bodyData+="<td>"+ i++ +"</td><td>"+row.code+"</td><td>"+row.vendor_details_company+"</td><td>"+row.invoice_product+"</td>"
            +"<td>"+row.date+"</td><td><a class='btn btn-secondary btn-sm' href='"+editUrl+"'>Edit</a>"+"</td>";
            bodyData+="</tr>";
          })
          $("#bodyData").append(bodyData);           
        },
        error: function(response) {
            console.log(response.responseJSON)
        }
      });
    }else{
      alert("Please Type Properly");
    }

  });


});
</script>

@endsection