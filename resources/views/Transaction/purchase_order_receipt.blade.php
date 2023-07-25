@extends('../layouts.master')
@section('content')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="wrapper">
  <!-- Navbar -->
  

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h2>Purchase Order Receipt</h2>
          </div>
          <div class="col-sm-6">
          <a href="abc" rel="noopener" target="_blank" class="btn btn-default" style="float:right;" download><i class="fas fa-print"></i> Print</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <img src="dist/img/laxyo_pic.png" class="img-fluid">
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <!-- info row -->
              <div class="row invoice-info" style="border-bottom:1px solid #000;">
                <div class="col-sm-4 invoice-col">
                  <div class="box">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <div class="box">
                  To
                  <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                  </address>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <div class="box">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>
              </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="po-title2">
                 <h5 class="text-center">PO Details</h5>
               </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div>
                  <h6 style="display: inline-block; margin-right:10px;">PO Number</h6>
                  <h5 style="display: inline-block;">0123</h5>
                </div>
                <div>
                  <h6 style="display: inline-block; margin-right:10px;">Delivery Date</h6>
                  <h5 style="display: inline-block;">000</h5>
                </div>
                <div>
                  <h6 style="display: inline-block; margin-right:10px;">No of Items</h6>
                  <h5 style="display: inline-block;">1</h5>
                </div>
                </div>
                <div class="col-4">
                  <div>
                  <h6 style="display: inline-block; margin-right:10px;">PO Date</h6>
                  <h5 style="display: inline-block;">0.00</h5>
                </div>
                <div>
                  <h6 style="display: inline-block; margin-right:10px;">PO Amendment</h6>
                  <h5 style="display: inline-block;">0.00</h5>
                </div>
                <div>
                  <h6 style="display: inline-block; margin-right:10px;">PO Amount</h6>
                  <h5 style="display: inline-block;">0.00</h5>
                </div>
                </div>
              </div>

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Description</th>
                      <th>HSN Code</th>
                      <th>Quantity</th>
                      <th>Unit</th>
                      <th>Rate</th>
                      <th>Taxable Amount</th>
                      <th>IGST</th>
                      <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>Call of Duty</td>
                      <td>455-981-221</td>
                      <td>El snort testosterone trophy driving gloves handsome</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Need for Speed IV</td>
                      <td>247-925-726</td>
                      <td>Wes Anderson umami biodiesel</td>
                      <td>$50.00</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Monsters DVD</td>
                      <td>735-845-642</td>
                      <td>Terry Richardson helvetica tousled street art master</td>
                      <td>$10.70</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Grown Ups Blue Ray</td>
                      <td>422-568-642</td>
                      <td>Tousled lomo letterpress</td>
                      <td>$25.99</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                      <td>$64.50</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Total(before Tax)</th>
                        <td>$250.30</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              
              <!-- /.row -->
              <div class="row">
                <div class="col-8">
                  <div>
                  <h4 style="display: inline-block; margin-right:10px;">PO Amount</h4>
                  <h5 style="display: inline-block;">Two Hundred Forty Rupees and Sixty Paise Only</h5>
                </div>
                <div>
                  <h4 style="display: inline-block; margin-right:10px;">IGST</h4>
                  <h5 style="display: inline-block;">0.00</h5>
                </div>
                </div>
                <div class="col-4 table-responsive">
                  <table class="table table-bordered">
                    <thead>
                    <tr>
                      <th>CGST</th>
                      <th>SGST</th>
                      <th>IGST</th>
                      <th>Cess</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-8">
                  <h3 class="lead">Terms and conditions<h3>
                  <p class="" style="margin-top: 10px; font-size:16px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Total Tax</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Total(after Tax)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Grand Total </th>
                        <td>$265.24</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card">
                      <div class="card-header bg-light">
                          <h3 class="card-title">Digital Signature</h3>
                      </div>
                      <div class="card-body">
                          <img src="dist/img/new.png" class="img-fluid">   
                      </div>
                  </div>
                </div>
                <div class="col-9">
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
             
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
