@extends('layouts.master')

@section('content')

<div class="container-fluid">

  <div class="card">

    <div class="card-header">
      <div class="float-right">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"> Add Consignee Name</i></button> 
        <a href="{{ '/home' }}" class="btn btn-secondary btn-sm">  Back</a>
      </div>
      <h5 class="main-title-w3layouts mb-1">Consignee Person Details</h5> 
    </div>

  
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
          <div class="alert alert-success">
            <p>{{ $message }}</p>
          </div>
        @endif

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Name and Number</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($consigne_person))
            @foreach ($consigne_person as $row)
            <tr>
              <td>{{ ++$i }}</td>
              <td>{{ $row->name }}</td>
              <td>
                <a class="btn btn-primary" data-toggle="modal" data-id="{{ $row->id }}" data-target="#myModal{{ $row->id }}">Edit</a>

                <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?') == true) { getElementById('delete-form-{{ $row->id }}').submit(); }" class="btn btn-danger">Delete</a>

                <form id="delete-form-{{ $row->id }}" action="{{ route('ConsigneePersonDetails.destroy', $row->id) }}" method="POST" style="display: none;">
                  @csrf
                  @method('DELETE')
                  
                </form>
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
        {!! $consigne_person->links() !!}
      </div>
    </div>
  </div>
  
</div>

<!--Add Units Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">Add Consignee Person</h4>
	        </div>
	        <div class="modal-body">
          	<form action="" method="" id="addForm">
	            @csrf
	            <div class="row">
                <div class="form-group col-md-12">
                  <label>Name</label>
                  <input type="text" class="form-control" placeholder="Name - Number" id="name" name="name">
                </div>
	            </div>
	            <button type="submit" name="submit" id="addPerson" class="btn btn-primary float-right">Submit</button>
		        </form>
	        </div>
      	</div>
    </div>
</div>
<!--Add Units Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--Update Units Modal -->
@foreach ($consigne_person as $row)
<div class="modal fade" id="myModal{{ $row->id }}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Consignee Person</h4>
        </div>
        <div class="modal-body">
          <form id="updateForm{{ $row->id }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="form-group col-md-12">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $row->name }}" id="name" name="name">
                <input type="hidden" class="form-control" value="{{ $row->id }}" id="id" name="id">
              </div>
            </div>
            <button type="submit" name="submit" id="updateperson" class="btn btn-primary float-right">Update</button>
          </form>
        </div>
      </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $("#updateForm{{ $row->id }}").on('submit', function(e) {
    e.preventDefault();
    var id = '{{ $row->id }}';
    $.ajax({
      type: 'post',
      url: "ConsigneePersonDetails/"+id,
      data: $('#updateForm{{ $row->id }}').serialize(),
      success: function(data) {
        alert('Person details Updated');
        location.reload();
      },
    });
  });
});
</script>
@endforeach
<!--Update Units Modal -->
<script>
$(document).ready(function() {
   $("#addForm").on('submit', function(e) {
   	e.preventDefault();
 		$.ajax({
      type: 'post',
      url: '/ConsigneePersonDetails',
      data: $('#addForm').serialize(),
      success: function(data) {
        alert(data);
        location.reload();
      },
    });
	});
});
</script>


@endsection