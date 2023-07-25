@extends('../layouts.master')
@section('content')
<style>
  .form-control{
    border: 1px solid #9400D3;
  }
</style>
<div class="container-fluid">
    <div class="card shadow mt-3">
        <div class="card-body">
            <!-- First Row -->
            <div class="row">
                <div class="col-md-10">
                    <h3 class="main-title-w3layouts mb-2">Transactions</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{route('transcation.create')}}" class="btn btn-success">Create Quotation</a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>    
                </div>
            </div>
            <!-- Second Row filter -->
            <br>
        <div id="item-table">
            <div class="table-responsive">
        <table id="examplee" class="table table-bordered display" style="width:100%">
            <thead>
                <tr class="text-center" style="background-color: #0c637f!important; color:#fff;">
                    <th>S.No</th>
                    <th>Items</th>
                    <th>No of Items</th>
                    <th>Expected Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            @php
                $i = 0;
            @endphp

            <tbody id="tbl-tbody">
                @foreach($data as $row)
                    <tr class="text-center">
                        <td>{{ ++$i }}</td>
                        <td>{{ $row->item }}</td>
                        <td>{{ (substr_count($row->item,',')+1) }}</td>
                        <td>{{ $row->expected_date }}</td>                        
                        <td>
                            <a href="{{route('check_users_rfq',$row->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
      $("#department").on('change', function(){
         var dep = $(this).val();
         var cat = $("#category").val();
         $.ajax({
                url: "{{  route('items-filter')}}",
                type: 'GET',
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'dep':dep,'cat':cat},
                success: function (data) {
                 console.log(data);
               if(data){
                       $('#item-table').empty().html(data);
                }
                 
                }
            })
      });
     });
</script>
@endsection