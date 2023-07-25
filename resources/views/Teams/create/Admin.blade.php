<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>
  {{-- Admin --}}
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-light">
        <h3 class="card-title">Choose Admin</h3>
        <button type="button" id="prch_admin" class="btn btn-success btn-sm float-right">Add More</button>
      </div>
      <div class="table-responsive">  
        <table class="table " id="admin_dynamic_field">
          <td>
          <select name="prch_admin[]" class="form-control prch_admin" required>
            <option selected hidden> Admin</option>
            @foreach($prch_admin as $admin)
              <option value="{{$admin->id}}">{{$admin->name}}</option>
            @endforeach
          </select> 
          </td>
          <td><button type="button" id="delete_row_admin" class="btn btn-danger btn-sm">X</button></td> 
        </table>   
      </div>
    </div>
  </div>
  
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
  $(document).ready(function(){

    // remove product row
    $('#admin_dynamic_field').on('click',"#delete_row_admin",function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    // add new product row on invoice
    var cloned = $('#admin_dynamic_field tr:last').clone();
    $("#prch_admin").click(function(e) {
        e.preventDefault();
        cloned.clone().appendTo('#admin_dynamic_field'); 
    });

  });
  </script> 

</body>
</html>