<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
   
  </head>
  <body>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Items</h3>
        </div>
        <table id="invoice-item-table" class="table table-bordered">
          <tr class="text-center">
            <th width="2%">S.No</th>
            <th>Item Name</th>
            <th width="9%">PO QTY.</th>
            <th width="14%">Invoice QTY</th>
            <th width="14%">Approved QTY</th>
            <th>Remark</th>
            <th width="2%"><button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">+</button></th>
          </tr>
          <tr>
            <input type="hidden" name="user_id" id="user_id" class="form-control input-sm" value="{{ Auth::user()->id }}" >
            <td><span id="sr_no">1</span></td>
              {{-- <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required>   --}}
            <td><input list="browsers" name="item_name[]" id="item_name1" id="browser" class="form-control">
              <datalist id="browsers">
                @foreach($items_lists as $datas)
                <option value="{{$datas}}">{{$datas}}</option>
                @endforeach
              </datalist>
            </td>             
            
            <td>
              {{-- <input type="text" name="po_no[]" id="po_no1" data-srno="1" class="form-control input-sm po_no" readonly> --}}
            </td>

            <td><input type="number" name="invoice_qty[]" id="invoice_qty1" data-srno="1" class="form-control input-sm invoice_qty"></td>

            <td><input type="number" name="approve_items[]" id="approve_items1" data-srno="1" class="form-control input-sm unit"></td>

            <td><textarea name="description[]" id="description1" data-srno="1" class="form-control input-sm description"></textarea>
            </td>

            <td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>
          </tr>
        </table>

      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  <script>
$(document).ready(function(){
  
  var final_total_amt = $('#final_total_amt').text();
  var count = 1;

  $(document).on('click', '#add_row', function(){
    count++;
    //alert("wrq");
    $('#total_item').val(count);
    var html_code = '';
    html_code += '<tr id="row_id_'+count+'">';
    html_code += '<td><span id="sr_no">'+count+'</span></td>';
  
    html_code += '<td><input type="text" name="item_name[]" list="browsers" id="item_name'+count+'" class="form-control" required/><datalist id="browsers"></datalist><div id="itemList'+count+'"></td>';

    html_code += '<td></td>';

    html_code += '<td><input type="text" name="invoice_qty[]" id="invoice_qty'+count+'" class="form-control input-sm" autocomplete="off" required/><div id="itemList'+count+'"></td>';

    html_code += '<td><input type="text" name="approve_items[]" id="approve_items'+count+'" class="form-control input-sm" autocomplete="off" required/><div id="itemList'+count+'"></td>';

    html_code += '<td><div class="row"><div class="col-md-12"><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm description"></textarea></div></div></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);

  });
  
  $(document).on('click', '.remove_row', function(){
    var row_id = $(this).attr("id");
    var total_item_amount = $('#order_item_final_amount'+row_id).val();
    var final_amount = $('#final_total_amt').text();
    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
    $('#final_total_amt').text(result_amount);
    $('#row_id_'+row_id).remove();
    count--;
    $('#total_item').val(count);
  });
  
});
</script>
  </body>
</html>