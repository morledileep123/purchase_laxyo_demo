
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
        <h4 style="text-align:center; margin-top: 5px;">Purchase Order</h4>
      </div>
      <br>

      <div class="row">
        <div class="col" style="margin-left:10px;">
          <h5>PO No : {{$data->code}}&nbsp;</h5>
        </div>
        <div class="col" style="margin-right:20px;">
          <p class="float-right">Date : {{$data->date}}</p>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-md-6" style="margin-left:10px;">
          <h6>To,</h6>
            <h6>{{$data->vender_detail}}</h6>
       
            <h6>{{$data->vendor_details_company}}</h6>
            <h6>{{$data->vendor_details_company_email}}</h6>
            <h6>{{$data->vendor_details_company_mobile}}</h6>
            <h6>{{$data->vendor_details_city}}</h6>
            <h6>{{$data->vendor_details_state}}</h6>
            <h6>{{$data->vendor_details_pin}}</h6>
            <h6>{{$data->vendor_details_person_email}}</h6>
        </div>
      </div>
      <br>

      <div>
        <div class="row">
          <div class="col"> 
            <p><strong>Sub : </strong>{{$data->subject}}</p>
            <p><strong>Reference : </strong>{{$data->quotation_no}}</p>
            <p>Dear Sir, <br>{{$data->subject_contents}}</p>
          </div>
        </div>
      </div>

      <div class="row">
          <table class="table" border="2">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Tax</th>
                <th>Sub Total</th>
                <th>Total</th>
                <th>Comment</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $row)
                <tr>
                  <td>{{$row->invoice_product}}</td>
                  <td>{{$row->description}}</td>
                  <td>{{$row->invoice_product_qty}}</td>
                  <td>{{$row->quantity_unit}}</td>
                  <td>{{$row->invoice_product_price}}</td>
                  <td>{{$row->invoice_product_tax}}</td>
                  <td>{{$row->total}}</td>
                  <td>{{$row->invoice_product_sub}}</td>
                  <td>{{$row->comment}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>          
      </div>
      <br>

      <div class="row">
          <div class="col-7">
            <strong>Payment Terms and Condition</strong>
            <p>{{$data->terms1}}</p>
            <p>{{$data->terms2}}</p>
            <p>{{$data->terms3}}</p>
            <strong>Guarantee And Warranty</strong>
            <p>{{$data->guarantee}}</p>
          </div>
          <div class="float-right" style="margin-right:10px;">
            <div class="col-5">
            <p style="margin-left:80px;"><strong>Sub Total</strong>&nbsp; : &nbsp; {{$data->invoice_subtotal}}</p>
            <p style="margin-left:80px;"><strong>Total Tax</strong>&nbsp; : &nbsp; {{$data->invoice_discount}}</p>
            <p style="margin-left:80px;"><strong>Final Amount</strong>&nbsp; : &nbsp; {{$data->grand_total}}</p>
            <p style="margin-left:80px;"><strong>Final Amount In words</strong>&nbsp; : &nbsp; <br>{{$data->amount_rupees}}</p>
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
          <p>{{$data->perosn_name}}</p>
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
            <p>Kindly acknowledge the purchase order.</p>
            <p>Thanking you,</p>
          </div>
      </div>
      <br>
      
      <div class="row">
          <div class="col-md-12">
            <h5>For Laxyo Energy Limited</h5>
            <img src="{{$data->sign}}" style="width: 20%;">
            <h5>(Authorized Signatory)</h5>
          </div>
      </div>

  <footer>
    <img src="{{asset('assets/img/po_footer_img.png')}}" style="width: 100%;">
  </footer>
  </div>
   
  </body>
</html>
