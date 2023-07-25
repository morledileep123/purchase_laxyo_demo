@extends('../layouts.master')

@section('content')
<?php
    $user_id = request()->segment('2');
?>
   
<div class="container-fluid">
  <a href="{{ url()->previous() }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2 ml-4 ">Select Quotation for Admin</h5>
  <div class="card shadow mt-3">
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('alert'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        <h4>Site : <b>{{ $detail->site_id }}</b></h4>
        <div class="row">
            <div class="form-group col-md-6">
                <h4>User Name : <b>{{ $detail->username->name }}</b></h4>
            </div>
            <div class="form-group col-md-6">
                <h4>Email : <b>{{ $detail->username->email }}</b></h4>
            </div>
        </div>

       
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" width="100%" id="userTable">
                    <thead >
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>  
                            <th>Request Qty</th>
                            <th>Expect Dt.</th>
                            <th>Description</th>
                            <th>Remark</th>
                            <th>Final Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                         
                    <tbody id="purchBody">
                        <form action="{{ route('send_rfq_manager',$data[0]->prch_rfi_users_id)}}" method="post">
                            @csrf
                            <input type="hidden" id= "prchid" value="{{ $data[0]->prch_rfi_users_id }}">
                            @php $i=1; @endphp
                            @php $j=0; @endphp

                            @foreach($data as $res)
                            {{-- {{dd($res->quantitystored)}} --}}
                            <tr>
                            <td>{{ ++$j }}</td>
                             <input type="hidden" name="id[]" value="{{ $res->id }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}">
                            <input type="hidden" name="item_name[]" value="{{ $res->item_name }}" class="form-control item_name" readonly="" id="{{ "item_".$i }}">
                            <input type="hidden" name="prch_rfi_users_id" value="{{ $res->prch_rfi_users_id }}" class="form-control prch_rfi_users_id" readonly="" >
                             <td>{{ $res->item_name }}</td>
                             <td><span>{{ $res->squantity }}</span></td>
                             <td>{{ $res->expected_date }}</td>
                             <td>{{ $res->description }}</td>
                             <td>{{ $res->remark }}</td>
                            
                            <td><input type="text" name="squantity[]" value="{{ $res->squantity }}"  class="form-control send" id=" {{"pass".$i }}"  min="1"></td>
                            @if($res->level1_status != 0)
                              <td class="text-success">Approved it For Next HOD Level</td>
                              @else
                              <td> <a class="btn btn-danger" href="{{ route('remove_req_quo',$res->id) }}" >Remove</a></td>
                            @endif
                            </tr>
                            @php $i++; @endphp
                             @endforeach
                        
                    </tbody>
                </table>   
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                   @if($res->level1_status == 0) 
                 <input class="btn btn-info" type="submit" value="Send To Admin" id="chkwar">
                 </form>
                 @elseif($res->squantity >= 0 && $res->direct_send == 1)
                  <p class="text-warning font-weight-bold text-center">Check Move Requested Items</p>
                   @elseif($res->squantity >= 0 && $res->manager_status == 1  && $res->mng_squantity_status == 1  && $res->quotation_status == 0 && $res->discard_status == 0 && $res->level2_status == 1)
                   <p class="text-success font-weight-bold text-center">Waiting to send Quotation</p>
                    @elseif($res->squantity >= 0 && $res->manager_status == 1  && $res->mng_squantity_status == 1  && $res->quotation_status == 0 && $res->discard_status == 0)
                   <p class="text-warning font-weight-bold text-center">Request is Waiting for Approval</p>
                    @elseif($res->squantity >= 0 && $res->manager_status == 1  && $res->quotation_status == 1  && $res->mng_squantity_status == 1)
                   <p class="text-success font-weight-bold text-center">Item Has been Send for Purchased</p>
                   @elseif($res->squantity >= 0 && $res->manager_status == 1  && $res->quotation_status == 0  && $res->mng_squantity_status == 1 && $res->discard_status == 2)
                   <p class="text-danger font-weight-bold text-center">Discared By Super-Admin</p>
                   @elseif($res->squantity >= 0 && $res->manager_status == 1  && $res->quotation_status == 0  && $res->mng_squantity_status == 1 && $res->discard_status == 1)
                   <p class="text-danger font-weight-normal text-center">Discared By Admin</p>
                 @else
                 <p class="text-secondary font-weight-bold text-center">Admin Approval Required</p>
                 @endif
               
            </div>
        </div>
      </div>
    </div>
</div>


@endsection

<style type="text/css">
    .avail-item-msg{
        color: #ad3636;
        margin-left: 10px;
        font-size: 12px;
        font-weight: bold;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });
  $('.send').on('blur', function(){
     var idnos = $(this).attr('id');
     var n = Array.from(idnos);
     var item_no = $("#item_"+n[5]).val();
     var prchid = $("#prchid").val();
     $.ajax({
        url: "{{  route('getstore_info')}}",
        type: 'GET',
         data: {'item_no':item_no,'prchid':prchid},
        success: function (data) {
         console.log(data);
      
        }
    })
     
   
    
  })
});
  </script>


