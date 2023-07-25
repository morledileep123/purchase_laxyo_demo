<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title></title>
</head>
<body>
  {{-- Team Name --}}
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light">
        <h3 class="card-title">Group name</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group col-md-12">
             <input type="text" id="team_name" name="team_name" value="{{ $teams->team_name }}" class="form-control">
             <input type="hidden" class="form-control" value="{{ $teams->id }}" id="id" name="id">
          </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-sm" id="team_update">Update</button>
      </div>      
    </div>
  </div>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$(document).ready(function(){

  $('#team_name').change(function(){
    let query = {{ $teams->id }};
    let team_name = $("#team_name").val();
       
    if(team_name != '')
    {    
      $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/teams_name_update",
        data: {
           _token : $('meta[name="csrf-token"]').attr('content'), 
           team_name:team_name,
           query:query,
        },
        dataType: "text",
        success:function(response){
          $('#data').html(response);
          window.location.reload();
        }
      });
    }
    else
    {
      $('#data').fadeOut();
    }
  });
});

// $.ajax({
      //   url:'/teams_name_update',
      //   method:"POST",
      //   data: {team_name:team_name, query:query},
      //   // data:'team_name='+team_name+'query='+query+'&_token={{csrf_token()}}',
      //   success:function(response){
      //     alert(response);
      //     $('#data').html(response);
      //   }
      // });


  // $.ajax({
  //   url:'/teams_name_update',
  //   type:'POST',
  //   data: {team_name:team_name, query:query},
  //   success:function(html){
  //     alert(html);
  //     $('#data').html(response);
  //   }
  // });

  // $("#a").change(function(){
  //      let a = $("#a").val();
  //      jQuery.ajax({
  //      url:'/company_full_detail',
  //      type:'get',
  //      data:'a='+a+'&_token={{csrf_token()}}',
  //      success:function(result){
  //        if(result){
  //            $("#country").val(result);
  //          }else{
  //            $("#college").empty();
  //          }
  //      }
  //      })
  //        // $("#b").val(a);
  //    });



  // $("#updateForm{{ $teams->id }}").on('submit',function(e){
  //   e.preventDefault();
   
  //   var id = '{{ $teams->id }}';
  //   alert(id);
  //   $.ajax({
  //     type: 'post',
  //     url:'/teams_name_update',
  //     data: $('#updateForm{{ $teams->id }}').serialize(),
  //     success: function(data) {
  //       alert(data);
  //       location.reload();
  //     },
  //   });
  // });



</script> 
</body>
</html>