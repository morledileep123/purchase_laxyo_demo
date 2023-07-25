@extends('layouts.master')

@section('content')

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header">
      <div class="float-right">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"> Add Side Name</i></button> 
        <a href="{{ route('company_side_name.create') }}" class="btn btn-success btn-sm"> Add Side Name</a>
        <a href="{{ '/home' }}" class="btn btn-secondary btn-sm">  Back</a>
      </div>
    <h5 class="main-title-w3layouts mb-1">Company Side Name</h5> 
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if($message = Session::get('success'))
          <div class="alert alert-success">
            <p>{{ $message }}</p>
          </div>
        @endif

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>ID</th>
              <th>Company Name</th>
              <th>Full Address</th>
              {{-- <th>mobile_no</th>
              <th>gstno</th>
              <th>image</th>
              <th>images</th>
              <th>header_img</th>
              <th>footer_img</th>
              <th>watermark_img</th>
              <th>first_code_company</th>
              <th>code_location</th> --}}
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($sides))
              @foreach ($sides as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->company_name }}</td>
                <td>{{ $row->full_address }}</td>
                {{-- <td>{{ $row->mobile_no}}</td>
                <td>{{ $row->gstno}}</td>
                <td>{{ $row->image}}</td>
                <td>{{ $row->images}}</td>
                <td>{{ $row->header_img}}</td>
                <td>{{ $row->footer_img}}</td>
                <td>{{ $row->watermark_img}}</td>
                <td>{{ $row->first_code_company}}</td>
                <td>{{ $row->code_location}}</td> --}}
                <td>
                  <a class="btn btn-success btn-sm" data-toggle="modal" data-id="{{ $row->id }}" data-target="#myModalView{{ $row->id }}">View</a>
                  <a class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{ $row->id }}" data-target="#myModal{{ $row->id }}">Edit</a>

                  <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?') == true) { getElementById('delete-form-{{ $row->id }}').submit(); }" class="btn btn-danger btn-sm">Delete</a>

                  <form id="delete-form-{{ $row->id }}" action="{{ route('company_side_name.destroy', $row->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $sides->links() !!}
      </div>
    </div>
  </div>
</div>

<!--Add Units Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Side Company</h5>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="addForm" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="form-group col-md-12">
              <label>Company Name</label>
              <input type="text" class="form-control" placeholder="Campany Name" id="company_name" name="company_name">
            </div>
            <div class="form-group col-md-12">
              <label>Full Address</label>
              <textarea class="form-control" rows="3" id="full_address" name="full_address" placeholder="Full Address"></textarea>
            </div>
            <div class="form-group col-md-6">
              <label>Mobile No</label>
              <input type="text" class="form-control" placeholder="Mobile No" id="mobile_no" name="mobile_no">
            </div>
            <div class="form-group col-md-6">
              <label>GST No</label>
              <input type="text" class="form-control" placeholder="GST No" id="gstno" name="gstno">
            </div>
            <div class="form-group col-md-6">
              <label>Image</label>
              <input type="file" id="image" name="image">
            </div>
            {{-- <div class="form-group col-md-6">
              <label>Images</label>
              <input type="file" id="images" name="images">
            </div> --}}
            <div class="form-group col-md-6">
              <label>Watermark Image</label>
              <input type="file" id="watermark_img" name="watermark_img">
            </div>
            <div class="form-group col-md-6">
              <label>Header Image</label>
              <input type="file" id="header_img" name="header_img">
            </div>
            <div class="form-group col-md-6">
              <label>Footer Image</label>
              <input type="file" id="footer_img" name="footer_img">
            </div>
            
            <div class="form-group col-md-5">
              <label>First Code Company</label>
              <input type="text" class="form-control" placeholder="Campany Short Word" id="first_code_company" name="first_code_company">
            </div>
            <div class="form-group col-md-7">
              <label>Code Location</label>
              <input type="text" class="form-control" placeholder="Campany Location Short Word" id="code_location" name="code_location">
            </div>
          </div>
          <button type="submit" name="submit" id="addUnit" class="btn btn-primary float-right">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Add Units Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--Update Units Modal -->
@foreach ($sides as $row)
<div class="modal fade" id="myModal{{ $row->id }}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Company Name</h5>
      </div>
      <div class="modal-body">
        <form id="updateForm{{ $row->id }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="form-group col-md-12">
              <label>Name</label>
              <input type="text" class="form-control" value="{{ $row->company_name }}" id="company_name" name="company_name">
              <input type="hidden" class="form-control" value="{{ $row->id }}" id="id" name="id">
            </div>
            <div class="form-group col-md-12">
              <label>Description</label>
              <textarea class="form-control" rows="3" id="full_address" name="full_address">{{ $row->full_address }}</textarea>
            </div>
            <div class="form-group col-md-6">
              <label>Mobile no</label>
              <input type="text" class="form-control" value="{{ $row->mobile_no }}" id="mobile_no" name="mobile_no">  
            </div>
            <div class="form-group col-md-6">
              <label>GST no</label>
              <input type="text" class="form-control" value="{{ $row->gstno }}" id="gstno" name="gstno">  
            </div>
            <div class="form-group col-md-12">
              <label>Image</label>
              <img src="{{asset('/'.$row->image)}}" alt="sign" style="width: 25%;">
              <input type="file" id="image" name="image">  
            </div>
            <div class="form-group col-md-12">
              <label>Header image</label>
              <img src="{{asset('/'.$row->header_img)}}" alt="Header Image" style="width: 25%;">
              <input type="file" id="header_img" name="header_img">  
            </div>
            <div class="form-group col-md-12">
              <label>Footer image</label>
              <img src="{{asset('/'.$row->footer_img)}}" alt="Footer Image" style="width: 25%;">
              <input type="file" id="footer_img" name="footer_img">    
            </div>
            <div class="form-group col-md-12">
              <label>Watermark image</label>
              <img src="{{asset('/'.$row->watermark_img)}}" alt="watermark img" style="width: 25%;">
              <input type="file" id="watermark_img" name="watermark_img">  
            </div>
            <div class="form-group col-md-6">
              <label>First Code Company</label>
              <input type="text" class="form-control" value="{{ $row->first_code_company }}" id="first_code_company" name="first_code_company">  
            </div>
            <div class="form-group col-md-6">
              <label>Code Location</label>
              <input type="text" class="form-control" value="{{ $row->code_location }}" id="code_location" name="code_location">  
            </div>
          </div>
          <button type="submit" name="submit" id="updateUnit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $("#updateForm{{ $row->id }}").on('submit', function(e){
    e.preventDefault();
    var id = '{{ $row->id }}';
    $.ajax({
      type: 'post',
      url: "company_side_name/"+id,
      data: $('#updateForm{{ $row->id }}').serialize(),
      success: function(data){
        alert('Company name Updated');
        location.reload();
      },
    });
  });
});
</script>
@endforeach
<!--Update Units Modal -->

<!--View Company name Modal -->
@foreach ($sides as $row)
<div class="modal fade" id="myModalView{{ $row->id }}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Company Name</h5>
      </div>
      <div class="container"> 
      <table class="table">
        <b>Company Name</b> : {{ $row->company_name }}<br><br>
        <b>Full Address</b> : {{ $row->full_address }}<br><br>
        <b>Mobile No</b> : {{ $row->mobile_no}}<br><br>
        <b>GST No</b> : {{ $row->gstno}}<br>
        <b>Image</b> : <img src="{{asset('/'.$row->image)}}" alt="sign" style="width: 30%;">
        <b>Watermark Image</b> :<img src="{{asset('/'.$row->watermark_img)}}" alt="Water mark" style="width: 20%;"><br><br>
        <b>Header Image</b> : <img src="{{asset('/'.$row->header_img)}}" alt="Header Image" style="width: 50%;"><br><br>

        <b>Footer Image</b> : <img src="{{asset('/'.$row->footer_img)}}" alt="Footer Image" style="width: 50%;"><br><br>

        <b>First Code Company</b> : {{ $row->first_code_company}}<br><br>
        <b>Code Location</b> : {{ $row->code_location}}<br><br>
      </table>
      </div>
    </div>
  </div>
</div>

@endforeach
<!--View Company name Modal -->


<script>
$(document).ready(function(){

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).on('submit','#addForm',function(e){
    e.preventDefault();

    let formData = new FormData($('#addForm')[0]);
    $.ajax({
      type: 'post',
      url: '/company_side_name_send',
      data: formData,
      contentType:false,
      processData : false,
      success: function(response){
        location.reload();
      },
    });
  });
});
</script>




@endsection