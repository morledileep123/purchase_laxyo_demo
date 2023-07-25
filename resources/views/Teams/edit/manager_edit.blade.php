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
          @foreach($manager_teams_details as $manager)
            <h6>{{$manager->user_name}}</h6>
            <button type="button" class="btn btn-danger btn-xs remove_manager" value="{{$manager->id }}">Remove</button>              
          @endforeach 
          </div>        
        </div>

        <br>
        <div class="row">
          <div class="col-md-6">  
            <form action="{{url('NewManager')}}" method="POST">
              @csrf
              <input type="hidden" name="team_id" value="{{$teams->id}}">
              <select name="prch_manager" class="form-control prch_manager" required>
                <option selected hidden>Manager</option>
                @foreach($prch_manager as $manager)
                  <option value="{{$manager->id}}">{{$manager->name}}</option>
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
      $('.remove_manager').on("click",function(){
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