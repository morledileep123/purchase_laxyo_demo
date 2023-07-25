@extends('../layouts.master')
@section('content')
 <style>
        tfoot {
            display: table-row-group;
        }
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }

        table input{
            background: transparent;
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: groove;
            background-color: #eee;
        }

        tfoot {
            display: table-header-group;
        }

        table input:focus-visible{
            outline: none;
        }
        .goods-pending{
            border: 1px solid blue;
            border-radius: 100px;
            font-size: 14px;
            color: blue;
        }
        .goods-pending:hover{
          color: blue;
        }
        .goods-processing{
            border: 1px solid #9c27b0;
            border-radius: 100px;
            font-size: 14px;
            color: #9c27b0;
        }
        .goods-processing:hover{
          color: #9c27b0; 
        }
        .goods-decline{
            border: 1px solid red;
            border-radius: 100px;
            font-size: 14px;
            color: red;
        }
        .goods-decline:hover{
          color: red;
        }
        .god-accept{
            border: 1px solid green;
            border-radius: 100px;
            font-size: 14px;
            color: green;
        }
        .god-accept:hover{
          color: green;
        }
    </style>

<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/transcation' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Users RFQ Listing</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <?php //dd($MailStatus[0]->id); die; ?>
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr class="text-center">
              <th>S.No</th>
              <th>Item Name</th>              
              <th>Quantity</th>              
              <th>Req. Date</th>
              <th>Description</th>
              <th>Send Quantity</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($data))
            @php $i = 0; @endphp
              @foreach($data as $row)
              {{-- {{ dd($row) }} --}}
              <tr class="text-center" id="bgclr{{$row->id}}">
                <td>{{ ++$i }}</td>
                <td>{{ $row->item_name }}</td>
                <td>{{ $row->quantity }}</td>                
                <td>{{ $row->expected_date }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->squantity }}</td>
                
                @if($row->item_status == 0)
                <td><p class="btn goods-pending">PENDING</p></td>
                @elseif($row->item_status == 1)
                <td><p class="btn goods-processing">PROCESSING</p></td>
                @elseif($row->item_status == 2)
                <td><p class="btn god-accept">ACCEPTED</p></td>
                @elseif($row->item_status == 3)
                <td><p class="btn goods-decline">DECLINED</p></td>
                @else
                <td class="text-success">FINISHED</td>
                @endif
                

              </tr>
                
              @endforeach
            @endif
          </tbody>
        </table>
        {{-- {{ $request_for_items->links() }} --}}
        {{-- {!! $data->links() !!} --}}
      </div>
    </div>
  </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
