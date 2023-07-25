@extends('../layouts.master')

@section('content')
<div class="container-fluid">
    <!-- <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a> -->
    <h5 class="main-title-w3layouts mb-2">View RFI</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
						
            <form action="" method="post">
                @csrf
                @method('PUT')
                <h4><strong>{{ "Site - ".App\SiteName::find($requestForItem[0]->site_id)->name }}</strong></h4>
                <table id="invoice-item-table" class="table table-bordered">
		            <tr>
		              <th>S.No</th>
		              <th>Item Name</th>
		              <th>Item No.</th>
		              <th>Expected Dt.</th>
		              <th>Quantity</th>
		              <th>Sending qty</th>
		             {{--  <th>Indent</th> --}}
		              <th>Remark</th>
		              <th></th>
		            </tr>
		            @php $m = 1; @endphp
		            @foreach($requestForItem as $row)
		            <tr>
		              <td>
		              	<span id="sr_no">{{$m++}}</span>
		              </td>
		              <td>
		              	<input type="text" name="item_name[]" id="item_name" class="form-control input-sm" value="{{ $row->item_name }}" readonly="" />
		              </td>
		              <td>
		              	<input type="text" name="item_no[]" id="item_no1" data-srno="1" class="form-control input-sm item_no" value="{{ $row->item_no }}" readonly/>
                       </td>
		              <td>
                        <input type="date" name="expected_date[]" value="{{ $row->expected_date }}" id="expected_date" data-srno="1" class="form-control input-xs" readonly/>
                      </td>
		              <td>
		                   <input type="text" name="quantity[]" id="quantity1" data-srno="1" class="form-control input-xs" value="{{ $row->quantity }}  {{ $row->quantity_unit }}" readonly="" />
		               </td>
		                <td>
		                   <input type="text" name="quantity[]" id="quantity1" data-srno="1" class="form-control input-sm" value="{{ $row->fquantity }}" readonly="" />
		                </td>
		               {{-- <td>
                          <input type="text" name="indent[]" id="indent" data-srno="1" class="form-control input-sm unit" value="{{ App\IndentReq::find($row->indent)->name }}" readonly="" />
                       </td> --}}
		               <td> 
                  			<textarea name="description[]" id="description1" data-srno="1" class="form-control input-sm description" readonly="">{{ $row->description }}</textarea>
                   
		               </td>


		              @if($row->remove_item_status == 0)
		              <td class="text-secondary">Pending</td>
		              @elseif($row->remove_item_status == 2)
		              <td class="text-danger">Declined</td>
		              @elseif($row->remove_item_status == 3)
		              <td class="text-secondary">Processing</td>
		              @else
		              <td class="text-success">Accepted</td>
		              @endif
		            </tr>
		           @endforeach
		          </table>
              
            </form>
        </div>
    </div>
</div>
@endsection