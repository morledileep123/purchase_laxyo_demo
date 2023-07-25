<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>
  {{-- Manager/Cheaker --}}
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light">
        <h3 class="card-title"> Manager</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
          @foreach($user_teams_details as $user)
            <h6>{{$user->user_name}}</h6>
            <button type="button" class="btn btn-danger btn-xs remove_user" value="{{$user->id }}">Remove</button>              
          @endforeach 
          </div>        
        </div>

        <br>
        <div class="row">
          <div class="col-md-6">  
            <form action="{{url('NewUser')}}" method="POST">
              @csrf
              <input type="hidden" name="team_id" value="{{$teams->id}}">
              <select name="prch_user" class="form-control prch_user" required>
                <option selected hidden>User</option>
                @foreach($prch_user as $user)
                  <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
              </select> 
              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </form>
          </div>          
        </div>   
      </div>
    </div>
  </div>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script>
    $(document).ready(function(){
      $('.remove_user').on("click",function(){
        var response = confirm("Do you realy want remove ?");
        if(response == true)
        {
          var id = $(this).val();
            $.ajax({
            url:'/remove_team_member_name',
            type:'POST',
            data:'id='+id+'&_token={{csrf_token()}}',
            success:function(result){
              alert("Super Admin remove ");
              window.location.reload();
            }
          });
        }else{
           alert("ok not remove");
        }
      });

    });    
  </script> 

</body>
</html>