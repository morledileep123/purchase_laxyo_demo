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
                    <button type="button" class="btn dropdown-toggle btn-success" data-toggle="dropdown">
                        Create Document</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item border-bottom" href="{{route('transcation.create')}}">Request for quotation (RFQ)</a>
                        <a class="dropdown-item border-bottom" href="{{url('/so_create')}}">Service Order</a>
                        <a class="dropdown-item border-bottom" href="{{url('/oc_create')}}">Order Confirmation</a>
                        <a class="dropdown-item border-bottom" href="{{url('/sc_create')}}">Service Confirmation</a>
                        <a class="dropdown-item border-bottom" href="{{url('/inc_create')}}">Invoice</a>  
                        <a class="dropdown-item" href="{{url('/adhinc_create')}}">Adhoc Invoice</a>
                    </div>
                </div>
            </div>
            <!-- Second Row filter -->
            {{-- <div class="row mt-3">
                <div class="form-group col-md-4">
                    <select class="form-control rounded-pill" name="category" id="category">
                        <option selected="" disabled="" value="0">Transaction Type</option> 
                        <option value="0">All</option> 
                        <option value="0">Purchase Transactions</option> 
                        <option value="0">Sales Transactions</option>  
                  </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control rounded-pill" name="category" id="category">
                        <option selected="" disabled="" value="0">Goods/Service</option>
                        <option value="0">All</option> 
                        <option value="0">Goods</option> 
                        <option value="0">Service</option>
                        <option value="0">Sub Contract</option>  
                  </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control rounded-pill" name="category" id="category">
                        <option selected="" disabled="" value="0">Status</option>
                        <option value="0">All</option> 
                        <option value="0">Live</option> 
                        <option value="0">Draft</option>  
                  </select>
                </div>
            </div> --}}
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