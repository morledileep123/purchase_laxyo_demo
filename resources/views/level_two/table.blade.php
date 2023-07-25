@extends('../layouts.master')
@section('content')

<div class="container-fluid">
  <div class="card">
  <!-- Content Header (Page header) -->

    <div class="card-header">
      <div class="row">
        <div class="col-md-12">
          <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
          </div>
          <h5>Export Items</h5>
        </div>
      </div>
    </div>

    <!-- Main content -->

    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="mb-3">
            <button id="allotBtn" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Select rows</button>
            <input type="button" value="Get Export" onclick="GetSelected()" class="btn btn-primary btn-sm"/>
            <button onClick="location.reload(true);" class="btn btn-primary btn-sm"><i class="fas fa-sync-alt"></i> Refresh Page</button>
          </div>

          <table class="table table-bordered" id="data">
            <tr>
              <th style="width:10px">&nbsp;</th>
              <th>Name</th>
              <th>Qty</th>
              <th>Unit</th>
              <th>Description</th>          
            </tr>

            <tbody id="studentListBody">
              @php $i=1; @endphp
              @foreach($data as $res)
              <tr role="row" class="odd">
                <td class="centeralign hideFirstTD sorting_1">
                  <div class="checkbox checkbox-success ">
                    <input class="commoncheckbox" type="checkbox" id="studentId_-5ab87edaff24ae1204000857" name="studentId_-5ab87edaff24ae1204000857" value="5ab87edaff24ae1204000857"> 
                    <label></label>
                  </div>
                </td>
                <td>{{ $res->item_name }}</td>
                <td>{{ $res->m_quantity }}</td>
                <td>{{ $res->quantity_unit }}</td>                
                <td>{{$res->description}}</td>
              </tr>
              @endforeach  
            </tbody>
          </table>           
        </div>
          <!-- /.col -->
      </div>
    </div>
      
      <!-- /.container-fluid -->
    
    <!-- /.content -->
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
      
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).on("click", "#allotBtn", function () {
      $('#studentListBody tr [type="checkbox"]').each(function(i, chk) {
        if (!chk.checked) {
          $("#studentListBody tr:nth-child("+(i+1)+")").css("display", "none");
        }
      });
    });
    function GetSelected(){
      let data=document.getElementById('data');
      var fp=XLSX.utils.table_to_book(data,{sheet:'vishal'});
      XLSX.write(fp,{
        bookType:'xlsx',
        type:'base64'
      });
      XLSX.writeFile(fp, 'Items.xlsx');
    }
  </script>
@endsection