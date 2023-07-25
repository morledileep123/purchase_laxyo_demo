
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Purchase Order</title>
  </head>
  <style>

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
</style>
  <body>
    <div id="watermark">
      <img src="{{asset('assets/img/BG_image.png')}}" height="100%" width="100%">
    </div>
  <header>
     <img src="{{asset('assets/img/po_header_img.png')}}" style="width: 100%;  object-fit: contain;" >
   </header>   
  
 <div class="container-fluid"> 
    
      <div class="row">
        <h4 style="text-align:center; margin-top: 6px;">Quotation</h4>
      </div>
      <br>

      <div class="row">
        <div class="col" style="margin-left:10px;">
          <h5>Quotation No : {{$data->rfq_id}}&nbsp;</h5>
        </div>
        <div class="col" style="margin-right:20px;">
          <p class="float-right">Date : {{$data->date}}</p>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-md-6" style="margin-left:10px;">
          <h6>To,</h6>
            <h6>{{$vendors_data->company}}</h6>
            <h6>{{$vendors_data->person_email}}</h6>
            <h6>{{$vendors_data->address1}}</h6>
            <h6>{{$vendors_data->state}}</h6>
            <h6>{{$vendors_data->city}}</h6>
        </div>
      </div>
      <br>

      <div>
        <div class="row">
          <div class="col"> 
            <p><strong>Sub : </strong>{{$data->subject}}</p>
            <p>Dear Sir,</p>
            <p>We are in the market for procurement of following items as detailed below.</p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" border="2">
              <thead style="background-color:#f2f2f2">
                <tr>
                   <th width="6%">S.N</th>
                   <th>Item Name</th>                       
                   <th>Quantity </th>
                   <th>Unit</th>
                   <th>Description</th>
                   <th>Remark</th>
                </tr>
              </thead>
               <tbody>
                @php $i=1; @endphp
                @foreach($items as $key => $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->item_name}}</td>
                  <td>{{$row->quantity}}</td>
                  <td>{{$row->quantity_unit}}</td>
                  <td>{{$row->description}}</td>
                  <td>{{$row->remark}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>          
          </div>
        </div>
      </div>
      <br>


      <div class="row">
        <div class="col-12">
          <p><strong>Delivery Date : - </strong>{{$data->delivery_date}}</p>
        </div>
      </div>
      <br> 

      <div class="row">
        <div class="col-12">
          <strong>Consignee / Delivery Location : </strong>
          <p>{{$data->delivery_address}}</p>
          <strong>Contact Person : </strong>
          <p>{{$data->person_name}}</p>
        </div>
      </div>
      <br> 

      <div class="row">
        <div class="col-md-12">
          <strong> Address : -</strong>
          <p>{{$data->full_address}}</p>              
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-md-12">
          <strong>Billing Address : -</strong>
          <p>Laxyo Energy Limited,<br>
              46/1 T.I.T Road <br>
              Ratlam M.P. -457001 <br>
              GSTN No.23AABCL3031E1Z9</p>              
        </div>
      </div>
      <br>

      <div class="row">
          <div class="col-md-12">
            <p>You are requested to send your techno commercial offer at the earliest.</p>
            <p>Kindly acknowledge the Quotation letter.</p>
            <p>Thanking you,</p>
          </div>
      </div>
      <br>
      
      <div class="row">
          <div class="col-md-12">
            <h5>For Laxyo Energy Limited</h5>
             <img src="{{asset('/'.$data->image)}}" style="width: 20%;">
            <h5>(Authorized Signatory)</h5>
          </div>
      </div>

  <footer>
    <img src="{{asset('assets/img/po_footer_img.png')}}" style="width: 100%;">
  </footer>
  </div>
   
  </body>
</html>
