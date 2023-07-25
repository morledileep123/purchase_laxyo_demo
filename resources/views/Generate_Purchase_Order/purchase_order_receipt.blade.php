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
          <h5>PO No : {{$po_data->code}}&nbsp;</h5>
        </div>
        <div class="col" style="margin-right:20px;">
          <p class="float-right">Date : {{$po_data->date}}</p>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-md-6" style="margin-left:10px;">
          <h6>To,</h6>
            <h6>{{$po_data->vender_detail}}</h6>
            <h6>{{$po_data->vendor_details_company}}</h6>
            <h6>{{$po_data->vendor_details_company_email}}</h6>
            <h6>{{$po_data->vendor_details_company_mobile}}</h6>
            <h6>{{$po_data->vendor_details_city}}</h6>
            <h6>{{$po_data->vendor_details_state}}</h6>
            <h6>{{$po_data->vendor_details_pin}}</h6>
            <h6>{{$po_data->vendor_details_person_email}}</h6>
        </div>
      </div>
      <br>

      <div>
        <div class="row">
          <div class="col"> 
            <p><strong>Sub : </strong>{{$po_data->subject}}</p>
            <p><strong>Reference : </strong>{{$po_data->quotation_no}}</p>
            <p>Dear Sir, <br>{{$po_data->subject_contents}}</p>
          </div>
        </div>
      </div>

      <div class="row">
          <table class="table" border="2">
            <thead>
              <tr>
               <th>Item Name</th>
               <th>Description</th>
               <th>Unit</th>
               <th>Quantity</th>
               <th>Rate</th>
               <th>Tax(%)</th>
               <th>Tax</th>
               <th>Discount</th>
               <th>Amount</th>
               <th>Comment</th>
              </tr>
            </thead>
            <tbody>
              @foreach($po_datas['invoice_product'] as $key=> $row)
                <tr>
                <td>{{$row}}</td>
                <td>{{$po_datas['description'][$key]}}</td>
                <td>{{$po_datas['quantity_unit'][$key]}}</td>
                <td>{{$po_datas['product_qty'][$key]}}</td>
                <td>{{$po_datas['product_price'][$key]}}</td>
                <td>{{$po_datas['product_tax'][$key]}}</td>
                <td>{{$po_datas['taxa'][$key]}}</td>
                <td>{{$po_datas['product_discount'][$key]}}</td>
                <td>{{$po_datas['product_subtotal'][$key]}}</td>
                <td>{{$po_datas['comment'][$key]}}</td>
               </tr> 
              @endforeach
           
            </tbody>
          </table>         
      </div>
      <br>

      <div class="row">
          <div class="col-7">
            <strong>Payment Terms and Condition</strong>
            <p>{{$po_data->terms1}}</p>
            <p>{{$po_data->terms2}}</p>
            <p>{{$po_data->terms3}}</p>
            <strong>Guarantee And Warranty</strong>
            <p>{{$po_data->guarantee}}</p>
          </div>
          <div class="float-right" style="margin-right:10px;">
            <div class="col-5">
            <p style="margin-left:80px;"><strong>Sub Total</strong>&nbsp; : &nbsp; {{$po_data->invoice_subtotal}}</p>
            <p style="margin-left:80px;"><strong>Total Tax</strong>&nbsp; : &nbsp; {{$po_data->invoice_discount}}</p>
            <p style="margin-left:80px;"><strong>Final Amount</strong>&nbsp; : &nbsp; {{$po_data->grand_total}}</p>
            <p style="margin-left:80px;"><strong>Final Amount In words</strong>&nbsp; : &nbsp; <br>{{$po_data->amount_rupees}}</p>
            </div>
          </div>
      </div>

      <br> 

      <div class="row">
        <div class="col-12">
          <p><strong>Delivery Date : - </strong>{{$po_data->delivery_date}}</p>
        </div>
      </div>
      <br> 

      <div class="row">
        <div class="col-12">
          <strong>Consignee / Delivery Location : </strong>
          <p>{{$po_data->delivery_address}}</p>
          <strong>Contact Person : </strong>
          <p>{{$po_data->perosn_name}}</p>
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
          <img src="{{$po_data->sign}}" style="width: 20%;">
          <h5>(Authorized Signatory)</h5>
        </div>
      </div>
  
  <footer>
    <img src="{{asset('assets/img/po_footer_img.png')}}" style="width: 100%;">
  </footer>
  </div>
  
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
   
  </body>
</html>
