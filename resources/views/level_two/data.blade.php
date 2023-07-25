<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet">

  </head>
  <body>
  <form action="{{ route('admin_view.update',$data[0]->prch_rfi_id)}}" method="post">
  @csrf
  @method('PUT')
  <div class="row">
    <div class="col-md-12">
      <div class="data_table">
        <table class="table table-bordered" id="example">
        <thead>
          <tr>
            <th>Sno</th>
            <th>Item Number</th>
            <th>Name</th>
            <th>Current Stock</th>
            <th>R-Qty</th>
            <th>Send Qty</th>
            <th>Expect Dt.</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>                    
        <tbody>
          <input type="hidden" id="prchid" value="{{ $data[0]->prch_rfi_users_id }}">
          @php $i=1; @endphp
         
          @foreach($data as $res)
          @if($res->dispatch_status == 0)
          <tr>
          <td>{{ $i++ }}</td>
          <input type="hidden" name="id[]" value="{{$res->id}}">
          <input type="hidden" name="item_no[]" value="{{ $res->item_no }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}">
          <input type="hidden" name="item_name[]" value="{{ $res->item_name }}" class="form-control item_name" readonly="" id="{{ "item_".$i }}">
          <td><span>{{ $res->item_no }}</span></td>
          <td>{{ $res->item_name }}</td>
          <td>
            @php $j=0; @endphp
            @foreach($mem as $row)
            
              @if($row->isEmpty())
                 @php echo " N/A "; @endphp                    
              @else
                   @php echo "$row[$j]"; @endphp                                
              @endif                              
               
            @endforeach
          </td>
          <td><span>{{ $res->quantity }}</span></td>

          <td><input type="text" name="m_quantity[]" value="{{ $res->quantity }}" class="form-control send " id=" {{"pass".$i }}" min="1"></td>
          
          <td>{{ $res->expected_date }}</td>

          <td>status</td>

          <td><button type="button" class="btn btn-danger btn-sm remove_request" value="{{$res->id}}">Remove</button></td>
          
          </tr>

          @else
          <tr class="bg-light" style="color:Gray !important;">
          <td>{{ $i++ }}</td>
          <td><span>{{ $res->item_no }}</span></td>
          <td>{{ $res->item_name }}</td>
          <td>
            @php $j=0; @endphp
            @foreach($mem as $row)
              @if($row->isEmpty())
                  @php echo " N/A "; @endphp                    
              @else
                  @php echo "$row[$j]"; @endphp                                
              @endif                            
            @endforeach
          </td>
          <td><span>{{ $res->quantity }}</span></td>

          <td><span>{{ $res->quantity }}</span></td>                        

          <td>{{ $res->expected_date }}</td>

          <td style="color:red;">Decline</td>  

          <td><button type="button" class="btn btn-danger btn-sm show_remove_request" value="{{$res->dispatch_reason}}">Reason</button></td>
          </tr>
          @endif
          @endforeach
                               
        </tbody>
      </table> 
        @if($data[1]->admin_status == 0)
          <input type="submit" name="submit" value="Submit" class="btn btn-primary"> 
        @endif
      </div>
                  
    </div>
  </div>
  </form>


    <script src="{{ asset('dist/javaScript/custom.js') }}"></script>
    <script src="{{ asset('dist/javaScript/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/javaScript/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/datatables.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    
  </body>
</html>




