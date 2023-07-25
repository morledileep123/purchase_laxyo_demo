@extends('../layouts.master')

@section('content')

<div class="card">  

<div class="card-header">
   <h5>Export Items data</h5>
</div>

<div class="card-body">
  <a href="javascript:void(0)" style="margin-bottom: 20px;" class="link_delete btn btn-success btn-sm" onclick="export_all()">Export</a>
  <div> 
    <form method="post" id="frm">
    <table id="data" class="table table-bordered table-hover ">
      <tr>
        <th width="15%"><input type="checkbox" onclick="select_all()"  id="delete"/></th>
        <th>Name</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Description</th>
      </tr>
      @php $i=1; @endphp
      @foreach($data as $res)
        <tr>
        <td><input id="{{ $res->id}}" name="checkbox[]" type="checkbox"></td>
        <td>{{ $res->item_name }}</td>
        <td>{{ $res->m_quantity }}</td>
        <td>{{ $res->quantity_unit }}</td>
        <td>{{$res->description}}</td>
        </tr>
      @endforeach
    </table>
    </form>
  </div>
</div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js" ></script>
<script type="text/javascript">
function select_all(){
  if(jQuery('#delete').prop("checked")){
    jQuery('input[type=checkbox]').each(function(){
      jQuery('#'+this.id).prop('checked',true);
    });
  }else{
    jQuery('input[type=checkbox]').each(function(){
      jQuery('#'+this.id).prop('checked',false);
    });
  }
}

function export_all(){

  jQuery('input[type=checkbox]').each(function(){

    if(jQuery('#'+this.id).prop("checked")){

      let data = document.getElementById('data');
      
      var fp = XLSX.utils.table_to_book(data,{sheet:'sheet1'});
        XLSX.write(fp,{
          bookType:'xlsx',
          type:'base64',
        });
        XLSX.writeFile(fp, 'Items.xlsx');
    }
  });
}
</script>
@endsection