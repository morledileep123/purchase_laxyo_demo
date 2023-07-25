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
            <h5>Create new teams</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
                {{-- <a href="{{ route('teams.create') }}" class="btn btn-success btn-sm">Create New teams</a> --}}
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
            <form action="" method="POST" enctype="multipart/form-data">  
            @csrf  
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Group name</h3>
                  </div>
                  <div class="card-body">
                    <input type="text" name="site_name" class="form-control">
                  </div> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose Site</h3>
                  </div>
                  <div class="card-body">
                    <select name="site_name_id" class="form-control">
                      <option selected hidden>Sites Name</option>
                      @foreach($sites as $site)
                      <option value="{{$site->id}}">{{$site->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              {{-- Super Admin --}}
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose Super Admin</h3>
                    <button type="button" id="prch_super_admin" class="btn btn-success btn-sm float-right">Add More</button>
                  </div>
                  <div class="table-responsive">  
                    <table class="table " id="super_admin_dynamic_field">
                      <td>
                      <select name="prch_super_admin[]" class="form-control prch_super_admin" required>
                        <option selected hidden>Super Admin</option>
                        @foreach($prch_user as $site)
                          <option value="{{$site->id}}">{{$site->name}}</option>
                        @endforeach
                      </select> 
                      </td>
                      <td><button type="button" id="delete_row_super_admin" class="btn btn-danger btn-sm">X</button></td> 
                    </table>   
                  </div>
                </div>
              </div>

              {{-- Accountant  --}}
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose Accountant</h3>
                  </div>
                  <div class="card-body">
                    <select name="site_name_id" class="form-control">
                      <option selected hidden>Accountant</option>
                      @foreach($prch_accountant as $site)
                      <option value="{{$site->id}}">{{$site->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              {{-- Admin --}}
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose Admin</h3>
                  </div>
                  <div class="card-body">
                    <select name="site_name_id" class="form-control">
                      <option selected hidden>Admin</option>
                      @foreach($prch_admin as $site)
                      <option value="{{$site->id}}">{{$site->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose Manager</h3>
                  </div>
                  <div class="card-body">
                    <select name="site_name_id" class="form-control">
                      <option selected hidden>Manager</option>
                      @foreach($prch_manager as $site)
                      <option value="{{$site->id}}">{{$site->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Choose User </h3>
                  </div>
                  <div class="card-body">
                    <select name="site_name_id" class="form-control">
                      <option selected hidden>User </option>
                      @foreach($prch_user as $site)
                      <option value="{{$site->id}}">{{$site->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              
                
            </div> 
            <button type="submit" name="submit" class="btn btn-primary sub-btn">Generate GRR</button>
            </form>
    
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

  // remove product row
  $('#super_admin_dynamic_field').on('click',"#delete_row_super_admin",function(e){
      e.preventDefault();
      $(this).closest('tr').remove();
  });

  // add new product row on invoice
  var cloned = $('#super_admin_dynamic_field tr:last').clone();
  $("#prch_super_admin").click(function(e) {
      e.preventDefault();
      cloned.clone().appendTo('#super_admin_dynamic_field'); 
  });

});
</script> 

@endsection