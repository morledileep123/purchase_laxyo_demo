@extends('../layouts.master')
@section('content')

<div class="container-fluid">

  <!-- Content Header (Page header) -->
  <div class="card shadow">
    <div class="content-header">
      <div class="container-wrap">
        <div class="row">
            <div class="col-sm-6">
              <h5 class="ml-2">Payment Voucher Details</h5>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
              </ol>
            </div>  
             <!-- /.col -->
        </div>
          <!-- /.row -->
      </div>
       <!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-body vendor-margin">
           <div class="row">
        <div class="col-md-12">
          <div class="row">
            <!-- left column -->
            <div class="col-md-7">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Vendor Details</h3>
                </div>
                <div class="card-body" style="margin-bottom:10px;">
                  <h6>{!! nl2br(e($data->vendore_details)) !!}</h6> 
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Payment Person Name </h3>
                </div>
                <div class="card-body" style="margin-bottom:10px;">
                  <h6>{{$user_name}}</h6> 
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Invoice NO</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->invoice_no}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Invoice Date</h3>
                </div>
                <div class="card-body">
                  <p>{{date('d-m-Y', strtotime($data->invoice_date)) }}</p> 
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Invoice amount</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->invoice_amount }}</p>          
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">PO NO</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->po_no}}</p>             
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">PO Date</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->po_date}}</p>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Amount Paid</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->amount_paid}}</p>             
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Payment Date</h3>
                </div>
                <div class="card-body">
                  <p>{{date('d-m-Y', strtotime($data->payment_date)) }}</p>             
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">GST</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->gst}}</p>              
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">TDS</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->tds}}</p>           
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-light">
                  <h3 class="card-title">Balance to be paid, If any</h3>
                </div>
                <div class="card-body">
                  <p>{{$data->balance_paid}}</p>             
                </div>
              </div>
            </div>
               
          </div>
         
        </div>
        </div>
              
        </div>
      </div>
    </div>
   
  </div>
</div>

@endsection
