@extends('../layouts.master')

@section('content')
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.min.css'>
<link rel='stylesheet' href='https://rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css'>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/extensions/export/bootstrap-table-export.js'></script>
<script src="http://frontendfreecode.com/codes/files/tableExport.js"></script>


<div class="container-fluid">

<div class="card shadow">
  <div class="card-header"> 
    <h2 class="card-title">Select Items For Export Excel</h2>
    <div class="float-sm-right">
      <a href="{{ '/admin_view' }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
  </div>
  
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="data_table">
          <div id="toolbar">
            <select class="form-control">
              <option value="">Export Basic</option>
              <option value="all">Export All</option>
              <option value="selected">Export Selected</option>
            </select>
          </div>
          <table class="table table-bordered" id="table" data-toggle="table" data-search="true"
       data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
              <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th>Name</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Remark</th>
              </tr>
            </thead>                    
            <tbody>
              @php $i=1; @endphp
              @foreach($data as $res)
              
              <tr>
                <td class="bs-checkbox"><input  ></td>
                <td>{{ $res->item_name }}</td>
                <td>{{ $res->m_quantity }}</td>
                <td>{{ $res->quantity_unit }}</td>                
                <td>{{$res->description}}</td>
                <td></td>
              </tr>
              @endforeach
                                   
            </tbody>
          </table>
           
        </div>
                    
      </div>
    </div>
  </div>
</div>
</div>
<div id="bcl"><a style="font-size:8pt;text-decoration:none;" href="http://www.devanswer.com">Free Frontend</a></div>

<script>
var $table = $('#table');
$(function () {
    $('#toolbar').find('select').change(function () {
        $table.bootstrapTable('refreshOptions', {
            exportDataType: $(this).val()
        });
    });
})
var trBoldBlue = $("table");
$(trBoldBlue).on("click", "tr", function () {
    $(this).toggleClass("bold-blue");
});
</script>


@endsection


<!-- @extends('../layouts.master')

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
@endsection -->