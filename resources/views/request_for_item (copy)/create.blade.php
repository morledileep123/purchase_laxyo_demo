@extends('../layouts.master')
@section('content')

<div class="container-fluid">

  <div class="card">

    <!-- Default box -->
    <?php
    function fill_unit_select_box($connect)
    { 
      $query = DB::table('prch_unitofmeasurements')->pluck('name');
      //dd($query);
       $output = '';
       
       foreach($query as $row)
       {
        $output .= '<option value="'.$row.'">'.$row.'</option>';
       }
      return $output;
    }
    ?> 
       
    <div class="card-header"> 
      <h2 class="card-title">Create RFI <small>(Request for Items)</small></h2>
      <div class="float-sm-right">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
      </div>
    </div>
  {{--  Alert Message  --}}
    <div class="container">
      @if ($errors->any())
        <div class="alert alert-warning alert-dismissible mt-3" role="alert">
          <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
          </button>
          <strong>Warning!</strong> Please check your all input code<br>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </div>
      @endif
    </div>
    
  {{--  Alert Message  --}}
    
    <div class="card">
      <div class="card-body">
                
        <form action="{{ route('request_for_item.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-8">
              <label>For Site</label>
              <select name="site_name" id="site_name" data-srno="1" class="form-control input-sm" required>
                <option value="" hidden>Select Site</option>
                @foreach($site as $stee)
                <option value="{{$stee->id}}">{{$stee->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Expected date</label>
              <input type="date" name="expected_date" id="expected_date" class="form-control input-sm"  min="{{date("Y-m-d")}}" required>
            </div>
          </div>
          <br>
          <table id="invoice-item-table" class="table table-bordered">
            <tr class="text-center">
              <th>S.No</th>
              <th>Item Name</th>
              <th>Item No.</th>
              <th>current stock</th>
              <th>Quantity</th>
              <th>unit</th>
              <th>Remark</th>
              <th></th>
            </tr>
            <tr>
              <input type="hidden" name="user_id" id="user_id" class="form-control input-sm" value="{{ Auth::user()->id }}" >
              <td><span id="sr_no">1</span></td>
              <td>
                <input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" autocomplete="off" required>
                <div id="itemList1"></div>
                
              </td>
              <td colspan="4">
                <div class="row">
                  <div class="col-md-3">
                    <input type="text" name="item_no[]" id="item_no1" data-srno="1" class="form-control input-sm item_no" readonly>
                  </div>

                  <div class="col-md-3">
                    <input type="text" name="current_stock[]" id="current_stock1" data-srno="1" class="form-control input-sm current_stock" readonly/>
                  </div>

                  <div class="col-md-3">
                    <input type="number" name="quantity[]" id="quantity1" data-srno="1" class="form-control input-sm unit" required>
                  </div>

                  <div class="col-md-3">
                    <select name="quantity_unit[]"id="quantity_unit" data-srno="1" class="form-control input-sm unit" required>
                     <option>Select unit</option>
                     @foreach($units as $unit)
                      <option value="{{$unit->name}}">{{$unit->name}}</option>
                     @endforeach
                    </select>
                  </div>

                </div>
              </td>
              <td>
                <div class="row">
                
                  <div class="col-md-12">
                <textarea name="description[]" id="description1" data-srno="1" class="form-control input-sm number_only description" ></textarea>
                  </div>
                </div>
              </td>
              <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">+</button></td>
            </tr>
          </table>
          {{-- <button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4" onclick="return confirm('Are you sure you want to submit this from?');">Submit</button> --}}
          <button type="submit" name="submit" class="btn btn-primary px-4">Submit</button>
        </form>
      </div>
    </div>
  </div>
    

</div>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
  
  var final_total_amt = $('#final_total_amt').text();
  var count = 1;

  $('#item_name'+count).keyup(function(){ 
    var query = $(this).val();
    if(query != '')
    {
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('fetch') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
        console.log(data);
          $('#itemList'+count).fadeIn();  
          $('#itemList'+count).html(data);

        }
      });
    }
    else
    {
      $('#itemList'+count).fadeOut();
    }
  });
  
  $(document).on('click', 'li', function(){ 
    $('#item_name'+count).val($(this).text());
    var str = $(this).text();
      console.log(str);
    var sp = str.split("|");
    $('#item_no'+count).val(sp[1]);
    $('#current_stock'+count).val(sp[2]);
    $('#itemList'+count).fadeOut(); 
  });

  $(document).on('click', '#add_row', function(){
    count++;
    //alert("wrq");
    $('#total_item').val(count);
    var html_code = '';
    html_code += '<tr id="row_id_'+count+'">';
    html_code += '<td><span id="sr_no">'+count+'</span></td>';
    
    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" autocomplete="off" required/><div id="itemList'+count+'"></td>';

    html_code += '<td colspan="4"><div class="row"><div class="col-md-3"><input type="text" name="item_no[]" id="item_no'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_no" readonly/></div>   <div class="col-md-3"><input type="text" name="current_stock[]" id="current_stock'+count+'" data-srno="'+count+'" class="form-control input-sm number_only current_stock" readonly/></div>    <div class="col-md-3"><input type="number" name="quantity[]" id="quantity'+count+'" data-srno="1" class="form-control input-sm unit" required/></div>   <div class="col-md-3"><select name="quantity_unit[]" class="form-control input-sm quantity_unit"><option>Select unit<?php echo fill_unit_select_box($connect ?? ''); ?></option></select></div>     </td>';

    html_code += '<td><div class="row"><div class="col-md-12"><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm number_only description"></textarea></div></div></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-sm remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);

    $('#item_name'+count).keyup(function(){ 
      var query = $(this).val();
      if(query != '')
      {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:"{{ route('fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#itemList'+count).fadeIn();  
            $('#itemList'+count).html(data);
          }
        });
      }
      else
      {
        $('#itemList'+count).fadeOut();
      }
    });
    
    $(document).on('click', 'li', function(){ 
      $('#item_name'+count).val($(this).text()); 
      $('#itemList'+count).fadeOut(); 
    });

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


@endsection
