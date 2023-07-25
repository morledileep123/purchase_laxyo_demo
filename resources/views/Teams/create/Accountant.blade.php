<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>
  {{-- Accounatnt --}}
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-light">
        <h3 class="card-title">Choose Accountant</h3>
        <button type="button" id="prch_accountant" class="btn btn-success btn-sm float-right">Add More</button>
      </div>
      <div class="table-responsive">  
        <table class="table " id="accountant_dynamic_field">
          <td>
          <select name="prch_accountant[]" class="form-control prch_accountant" required>
            <option selected hidden>Accountant</option>
            @foreach($prch_accountant as $accounatnt)
              <option value="{{$accounatnt->id}}">{{$accounatnt->name}}</option>
            @endforeach
          </select> 
          </td>
          <td><button type="button" id="delete_row_accountant" class="btn btn-danger btn-sm">X</button></td> 
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
    $('#accountant_dynamic_field').on('click',"#delete_row_accountant",function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    // add new product row on invoice
    var cloned = $('#accountant_dynamic_field tr:last').clone();
    $("#prch_accountant").click(function(e) {
        e.preventDefault();
        cloned.clone().appendTo('#accountant_dynamic_field'); 
    });

  });
  </script> 

</body>
</html>