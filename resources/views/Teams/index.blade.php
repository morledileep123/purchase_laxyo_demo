@extends('../layouts.master')

@section('content')

<div class="container">
  @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
          <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('success') }}
    </div>
  @endif
</div>
<div class="container">
  @if (Session::has('success_mail'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('success_mail') }}
    </div>
  @endif
</div>
<div class="container">
  @if(Session::has('delete'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
      </button>
      <strong>Success !</strong> {{ session('delete') }}
    </div>
  @endif
</div>

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5>Teams Lists</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                <a href="{{ route('teams.create') }}" class="btn btn-success btn-sm">Create New Team</a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
              </div>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="table-responsive">
            <table class="table table-bordered table-hover" id="inv-table">
            <thead>
            <tr>
              <th width="6%">S No</th>
              <th>Team Name</th>
              <th>Site Name</th>          
              <th width="25%">Action</th>
            </tr>
            </thead>
            <tbody>
              @php $i=0; @endphp
              @foreach($teams as $data)
              <tr>
                <td>{{++$i}}</td>
                <td>{{$data->team_name}}</td>
                <td>{{$data->side_name}}</td>
                <td>
                  <form action="{{ route('teams.destroy', $data->id ) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <a href="{{url('teams',$data->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View</a>
                  <a href="{{route('teams.edit',$data->id)}}" class="btn btn-success btn-xs"><i class="fas fa-edit"></i> Edit</a>
                  <button type="submit" class=" btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this ?')"><i class="fa fa-trash"></i> Delete</button>
                  </form>
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

@endsection