@extends('../layouts.master')

@section('content')

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5>Edit Team</h5>
            <h4>Site name :- <strong>{{$teams->side_name}}</strong></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <div class="card-header" style="padding:4px; border:none;">
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
            <div class="row"> 
              @include('Teams.edit.team_name')
              @include('Teams.edit.superadmin_edit')
              @include('Teams.edit.accountant_edit')
              @include('Teams.edit.admin_edit')
              @include('Teams.edit.manager_edit')
              @include('Teams.edit.user_edit')
                         
            </div> 
          </div>
          <!-- /.col -->
          {{-- <div class="col-12">
              
            <div class="row">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Super Admin</h3>
                  </div>
                  <div class="card-body">
                    @foreach($superadmin_teams_details as $superadmin)
                    <h6>{{$superadmin->user_name}}</h6>
                    @endforeach
                  </div> 
                </div>
              </div>  
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Accountant</h3>
                  </div>
                  <div class="card-body">
                    @foreach($accountant_teams_details as $accountant)
                    <h6>{{$accountant->user_name}}</h6>
                    @endforeach
                  </div> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Admin</h3>
                  </div>
                  <div class="card-body">
                    @foreach($admin_teams_details as $admin)
                    <h6>{{$admin->user_name}}</h6>
                    @endforeach
                  </div> 
                </div>
              </div>                
            </div> 
    
          </div> --}}
          <!-- /.col -->

         {{--  <div class="col-12">
              
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">Manager/Cheaker</h3>
                  </div>
                  <div class="card-body">
                    @foreach($manager_teams_details as $manager)
                    <h6>{{$manager->user_name}}</h6>
                    @endforeach
                  </div> 
                </div>
              </div>  
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-light">
                    <h3 class="card-title">User/Maker</h3>
                  </div>
                  <div class="card-body">
                    @foreach($user_teams_details as $user)
                    <h6>{{$user->user_name}}</h6>
                    @endforeach
                  </div> 
                </div>
              </div>                
            </div> 
    
          </div> --}}
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



});
</script> 

@endsection