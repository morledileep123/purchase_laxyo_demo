
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
       <!-- myFontstyles -->
    <!-- <link rel="stylesheet" href="/storage/fonts/calibri-regular.ttf"> -->
    <title>GRR</title>
  </head>
  <style>
    @font-face {
    font-family: 'calibriregular';
    src: url("{{asset('storage/fonts/calibri-regular.ttf')}}")format("truetype");
    font-weight: normal;
    font-style: normal;

}
   body {
            font-family: 'calibriregular';
                }
  * {
    margin: 0;
    padding: 0;
  }

  #watermark{
     position: fixed;
     bottom:   10cm;
     left:     5.5cm;
     width:    8cm;
     height:   8cm;
     z-index:  -1000;
   }

  footer{
    position: fixed; 
    bottom: 20px; 
    left: 0cm; 
    right: 0cm;
    height: 2cm;                      
  }

  .row:after {
  content: "";
  display: table;
  clear: both;
}

  .col{
  float: left;
  width: 50%;
  padding: 10px;
  }

</style>
<body> 
  <div class="container-fluid"> 
    <div class="row">
      <h4 style="text-align:center; margin-top: 20px;">GRR</h4>
    </div>
  
    <div class="row">
      <div class="col" style="margin-left:30px;margin-top: 12px;">
        <p>GRR no :  {{$data->grn_no}}</p>
        <p>PO no :  {{$data->po_no}}</p>
        <p>Invoice no :  {{$data->invoice_no}}</p>
        <p>Delivery Date : {{date('d-m-Y', strtotime($data->delivery_date))}}</p>
      </div>
      <div class="col"  style="margin-left:66px;margin-top: 12px;">
        <p>GRR Date :  {{date('d-m-Y', strtotime($data->grr_date)) }}</p>
        <p>PO Date :  {{date('d-m-Y', strtotime($data->po_date)) }}</p>
        <p>Invoice date : {{date('d-m-Y', strtotime($data->invoice_date)) }}</p>     
      </div>
    </div>

    <div class="row">
      <div class="col" style="margin-left:30px;">
          <small>Vendor Detail</small>
             
          <h6>{{$data->vender_company}}</h6> 
          <h6>{{$data->vender_email}}</h6>
          <h6>{{$data->vender_address1}}</h6>
          <h6>{{$data->vender_address2}}</h6>
          <h6>{{$data->vender_state}}</h6>
          <h6>{{$data->vender_city}}</h6> 
          <h6>{{$data->vender_person_name}}</h6> 
          <h6>{{$data->vender_person_email}}</h6> 
          <h6>{{$data->vender_person_no}}</h6> 
      </div>
      <div class="col">
        <small>Delivery Location</small>
        <h6>{!! nl2br(e($data->delivery_location)) !!}</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table class="table" border="2">
            <thead style="background-color:#f2f2f2">
              <tr>
                <th>S.N</th>
                <th>Item Name</th>                       
                <th>PO QTY</th>
                <th>Invoice QTY</th>
                <th>Approved QTY</th>                             
                <th>Remark</th>
              </tr>
            </thead>
             <tbody>
              @php $i=1; @endphp
              @foreach($items as $key => $row)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$row->item_name}}</td>
                <td>{{$row->po_qty}}</td>                              
                <td>{{$row->invoice_qty}}</td>
                <td>{{$row->approve_items}}</td>
                <td>{!! nl2br(e($row->description)) !!}</td>
              </tr>
              @endforeach
            </tbody>
          </table>          
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col" style="margin-left:12px;">
        <strong>Comment : </strong><p>{!! nl2br(e($data->comments)) !!}</p> 
      </div>
      <div class="col">
        <p><strong>Final Amount : </strong>{{$data->grand_total}}</p> 
        <strong>Final Amount In words : </strong><p style="padding-right:24px;">{{$data->amount_rupees}}</p>   
      </div>
    </div>

  </div>
</body>
</html>


