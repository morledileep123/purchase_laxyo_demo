<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>New Purchase</title > 
</head>
<body>
<!-- / main menu--> 
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header bg-light">
                <h3 class="card-title">Items</h3>
            </div>
            <div id="saman-row">
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr class="item_header">
                        <th width="2%" class="text-center">S No</th>
                        <th width="10%" class="text-center">Unit</th>
                        <th width="6%" class="text-center"> Qty</th>
                        <th width="6%" class="text-center">Rate</th>
                        <th width="5%" class="text-center">Tax(%)</th>
                        <th width="5%" class="text-center">Tax</th>
                        <th width="5%" class="text-center"> Discount</th>
                        <th width="2%" class="text-center">Amount</th>
                        
                        <th width="3%" class="last-item-row text-center">
                            <button type="button" class="btn btn-success btn-sm add-row" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="Add product row" id="addproduct">+</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <select name="quantity_unit[]"id="quantity_unit" data-srno="1" class="form-control" required>
                                <option hidden>Select unit</option>
                                @foreach($units as $unit)
                                <option value="{{$unit->name}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                   autocomplete="off" placeholder="Quantity"></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                   autocomplete="off" placeholder="Price"></td>
                        <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                   autocomplete="off" placeholder="Tax"></td>
                        <td class="text-center" id="texttaxa-0">0</td>
                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-0" onkeyup="rowTotal('0'), billUpyog()" autocomplete="off" placeholder="Discount"></td>
                        <td><strong><span class='ttlText' id="result-0">0</span></strong></td>
                        
                        <td class="text-center">
                            <button type="button" data-rowid="'+ cvalue +'" class="btn btn-danger removeProd btn-sm" title="Remove" >X</button>
                        </td>
                        <tr>
                            <td colspan="3"><input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter Item Name or select" id='productname-0'>
                             or <a href="#" class="item-select">Select a Item</a><div id="itemList1"/></div>
                            </td>
                            <td colspan="3"><textarea name="description[]" data-srno="1" class="form-control input-sm number_only description" placeholder="Description"></textarea>
                            </td>
                            <td colspan="3"><textarea name="comment[]" data-srno="1" class="form-control comment" placeholder="Comment"></textarea></td>
                        </tr>
                        <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                        <input type="hidden" name="disca[]" id="disca-0" value="0">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                    </tr> 
                    <tr class="last-item-row">
                        
                    </tr>
                    
                    </tbody>
                </table>
            </div>

          

            <input type="hidden" value="purchase/action" id="action-url">
            <input type="hidden" value="puchase_search" id="billtype">
            <input type="hidden" value="1" name="counter" id="ganak">
            <input type="hidden" value="%" name="taxformat" id="tax_format">
            <input type="hidden" value="%" name="discountFormat" id="discount_format">
            <input type="hidden" value="yes" name="tax_handle" id="tax_status">
            <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
 
        </div>
    </div>
    <div class="row">
          <!-- left column -->
          <div class="col-md-6">
          <!-- general form elements -->
          <div class="card">
          <div class="card-header bg-light">
          <h3 class="card-title">Payment Terms and Condition</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
          <div class="form-group">
          <div clas="row">
          <div class="col-md-12">
             <select id="a" class="form-control" name="terms1">
                <option selected hidden disabled>Advance along with PO</option>
                <option value="10% advance along with PO and balance on receipt of material.">10% advance along with PO and balance on receipt of material.</option>
                <option value=" 20% advance along with PO and balance on receipt of material."> 20% advance along with PO and balance on receipt of material.</option>
                <option value="30% advance along with PO and balance on receipt of material.">30% advance along with PO and balance on receipt of material.</option>
                <option value="40% advance along with PO and balance on receipt of material.">40% advance along with PO and balance on receipt of material.</option>
                <option value="50% advance along with PO and balance on receipt of material.">50% advance along with PO and balance on receipt of material.</option>
                <option value="60% advance along with PO and balance on receipt of material.">60% advance along with PO and balance on receipt of material.</option>
                <option value="100% advance along with PO.">100% advance along with PO.</option>
               
             </select>
          </div><br>
            <div class="col-md-12">
             <select id="a" class="form-control" name="terms2">
                <option selected hidden disabled>Advance against approval of drawing</option>
                <option value="10% Advance approval of drawing">10% Advance approval of drawing</option>
                <option value="15% Advance approval of drawing">15% Advance approval of drawing</option>
                <option value="30% Advance approval of drawing">30% Advance approval of drawing</option>
             </select>
          </div><br>
            <div class="col-md-12">
             <select id="a" class="form-control" name="terms3">
                <option selected hidden disabled>Balance payment</option>
                <option value="Payment shall be made within 30 -45 days from the date of Invoice after delivery.">Payment shall be made within 30 -45 days from the date of Invoice after delivery.</option>
                <option value="Payment shall be made within 15 days from the date of Invoice after delivery.">Payment shall be made within 15 days from the date of Invoice after delivery.</option>
                <option value="Payment shall be made within 30 days from the date of Invoice after delivery.">Payment shall be made within 30 days from the date of Invoice after delivery.</option>
                <option value="Payment shall be made within 7 days from the date of Invoice after delivery.">Payment shall be made within 7 days from the date of Invoice after delivery.</option>
                <option value="Payment shall be made within 90 days from the date of Invoice after delivery.">Payment shall be made within 90 days from the date of Invoice after delivery.</option>
                <option value="Payment shall be made within 60 days from the date of Invoice after delivery.">Payment shall be made within 60 days from the date of Invoice after delivery.</option>
             </select>
          </div>
          <br>
          <div class="col-md-12"> <h6>All above payment conditions will be applicable on total amount (excluding GST amount). GST amount shall be released on submission of R1 challan.</h6></div>
        </div>
          </div>
          </div>
          </div>
          </div>
          <!-- Right column -->
          <div class="col-md-6">
          <!-- general form elements --> <!--  <tr class="sub_c" style="display: table-row;">
                        <td colspan="6" align="right"><input type="hidden" value="0" id="subttlform"  name="subtotal"><strong> Total Tax</strong>
                        </td>
                        <td align="left" colspan="2">
                            <span id="taxr" class="lightMode">0</span></td>
                    </tr>
                    <tr class="sub_c" style="display: table-row;">
                        <td colspan="6" align="right">
                            <strong> Total Discount</strong></td>
                        <td align="left" colspan="2">
                            <span id="discs" class="lightMode">0</span></td>
                    </tr>

                    <tr class="sub_c" style="display: table-row;">
                        <td colspan="6" align="right">
                            <strong> Shipping</strong></td>
                        <td align="left" colspan="2"><input type="text" class="form-control shipVal" onkeypress="return isNumber(event)" placeholder="Value"  name="shipping" autocomplete="off" onkeyup="updateTotal()"></td>
                    </tr>

                    <tr class="sub_c" style="display: table-row;">
                        <td colspan="6" align="right"><strong> Grand Total </strong>
                        </td>
                        <td align="left" colspan="2"><input type="text" name="total" class="form-control" id="invoiceyoghtml" readonly="">
                        </td>
                    </tr> -->
            
            <div class="card">
              <div class="card-body" id="invoice_totals">
                <div class="row sub_c">
                    <strong> Total Tax :&nbsp;&nbsp;&nbsp;</strong>
                    <span id="taxr" class="lightMode">0</span>
                </div>        
                <div class="row">
                    <strong> Total Discount :&nbsp;</strong>
                    <span id="discs" class="lightMode">0</span>
                </div>
                <tr class="sub_c" style="display: table-row;">
                    <input type="hidden" class="form-control shipVal" onkeypress="return isNumber(event)" placeholder="Value"  name="shipping" autocomplete="off" onkeyup="updateTotal()" disabled>
                </tr>
                <div class="row">
                   <strong>Total Amount (After Tax) :&nbsp;&nbsp;</strong>
                   <!-- <span id="invoiceyoghtml" class="lightMode">0</span> -->
                   <div class="col-xs-3">
                       <input type="text" name="total" class="form-control" id="invoiceyoghtml" readonly>
                   </div>
                </div>
                <div class="row">
                    <strong>Any Additional Charges : </strong>              
                    <div class="col-6">
                        <select class="form-control" name="charges_head">
                            <option selected hidden disabled>Additional Charges</option>
                            <option value="Packing and Forwarding">Packing and Forwarding</option>
                            <option value="Freight">Freight</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Erection and charges">Erection and charges</option>
                            <option value="Inspection charges">Inspection charges</option>
                            <option value="Other">Other</option>   
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" name="charges" class="form-control">
                    </div>
                </div>
                <div class="row">
                   <div class="col-xs-4 col-xs-offset-5">
                      <strong>Grand Total :&nbsp;&nbsp;</strong>
                   </div>
                   <div class="col-xs-3">    
                      <input type="text" name="grand_total" id="amount1" class="form-control numbers">
                   </div>
                </div>
                <div class="row">
                   <div class="col-xs-4 col-xs-offset-5">
                      <strong>Grand Total in word :&nbsp;&nbsp;</strong>
                   </div>
                </div>
                <div class="row">
                   <div class="col-xs-3 w-100">    
                     <input type="text" name="amount_rupees" id="amount-rupees" class="form-control" readonly />
                   </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="col-md-8">
          <!-- general form elements -->
              <div class="card">
              <div class="card-header bg-light">
              <h3 class="card-title">Guarantee and Warranty</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
              <div class="form-group">
              <textarea cols='60' name='guarantee' class='form-control' rows='5'>The supplied parts should withstand a guarantee against any manufacturing defect for a period of 12 months from the date of use or 18 months from the date of delivery, whichever is earlier.</textarea>
              </div>
              </div>
              </div>
          </div>
          <div class="col-md-4">
          <!-- general form elements -->
              <div class="card">
              <div class="card-header bg-light">
              <h3 class="card-title">Quotation Excel Sheet</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                  <div class="form-group">
                    <input type="file" name="quotation_excel_sheet" id="imgupload" style="display:none">
                  <img src="{{asset('assets/img/PDF.jpg')}}" id="OpenImgUpload" style="width: 40%;min-height: 50px;"><br>
                  </div>
              </div>
              </div>
          </div>
          
        </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
 <script>

    $('#OpenImgUpload').click(function(){ 
        $('#imgupload').trigger('click');
    });

      var billtype = $('#billtype').val();
$('#addproduct').on('click', function () {
    var taxOn = $('#tax_status').val();
    var disOn = $('#discount_handle').val();
    var ganakChun = $('#ganak');
    var ganak = ganakChun.val();
    var cvalue = parseInt(ganak) + 1;
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
   var disp='';
   var taxp='';

//product row
    var data = '<tr><td>'+ cvalue +'</td> <td><select name="quantity_unit[]" class="form-control input-sm quantity_unit" id="quantity_unit-'+ cvalue +'"><option>Select unit<?php echo fill_unit_select_box($connect ?? ''); ?></option></select></td>  <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off" placeholder="Quantity" ></td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off" placeholder="Price" ></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off" placeholder="Tax" ></td> <td id="texttaxa-'+ cvalue +'" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-'+ cvalue +'" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off" placeholder="Discount" ></td>  <td><strong><span class=\'ttlText\' id="result-'+ cvalue +'">0</span></strong></td>  <td class="text-center"><button type="button" data-rowid="'+ cvalue +'" class="btn btn-danger removeProd btn-sm" title="Remove" >X</button> </td><input type="hidden" name="taxa[]" id="taxa-'+ cvalue +'" value="0"><input type="hidden" name="disca[]" id="disca-'+ cvalue +'" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-'+ cvalue +'" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-'+ cvalue +'" value="0"> </tr>  <tr> <td colspan="3"><input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter Item Name or select" id="productname-'+ cvalue +'"> or <a href="#" class="item-select">Select a Item</a><div id="itemList1"/></div></td> <td colspan="3"><textarea class="form-control description"  id="dpid-'+ cvalue +'" name="description[]" placeholder="Description" autocomplete="off"></textarea><br></td> <td colspan="3"><textarea class="form-control"  id="dpid-'+ cvalue +'" name="comment[]" placeholder="Comment" autocomplete="off"></textarea><br></td></tr>';
    //ajax request
   // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;
    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/'+billtype,
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'product_list',
                    row_num: row,
                    wid:$("#warehouses option:selected").val()
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(ui.item.data[3]);
            $('#discount-' + id[1]).val(ui.item.data[4]);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            rowTotal(0);
            billUpyog();
            rowTotal(id[1]); billUpyog();
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

    ganakChun.val(cvalue);
    var samanKullYog = samanYog();
    var totalTaxSum = shipTot();
    var totalBillVal = deciFormat(samanKullYog + totalTaxSum);
    $("#invoiceyoghtml").val(totalBillVal);
    $("#totalBill").html(totalBillVal);
    var sideh2=document.getElementById('rough').scrollHeight;
    var opx3=sideh2+50;
    document.getElementById('rough').style.height=opx3+"px";
});

//caculations
var precentCalc = function (total, percentageVal) {
    return (total / 100) * percentageVal;
};
//format
var deciFormat = function (minput) {
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + "-" + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var shipTot = function () {
if($('.shipVal').val()=='') {$('.shipVal').val(0);return 0;}
else{
    return deciFormat($('.shipVal').val());}
};
//product total
var samanYog = function () {

    var itempriceList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = $(this).val();

        if (vv === '') {
            vv = 0;
        }

        itempriceList.push(vv);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    var ganak =  parseInt($("#ganak").val())+1;
    console.log('indexc---'+ganak);
      for (var z = ganak; z>-1; z--) {
            if (parseFloat(itempriceList[z])>0) {
                sum += parseFloat(itempriceList[z]);
            }
            if (parseFloat($("#taxa-" + z).val())>0) {
                taxc += parseFloat($("#taxa-" + z).val());
            }
            if (parseFloat($("#disca-" + z).val())>0) {
                discs += parseFloat($("#disca-" + z).val());
            }
            console.log(sum);   console.log('tax--'+taxc);console.log('z--'+z);
    }
    discs = deciFormat(discs);
    taxc = deciFormat(taxc);
    sum = deciFormat(sum);
    $("#discs").html(discs);
    $("#taxr").html(taxc);
    return sum;

};




//actions
var deleteRow = function (num) {

    var prodTotalID;
    var prodttl;
    var subttl;
    var totalSubVal;
    var totalBillVal;
    var totalSelector = $("#subttlform");
    prodTotalID = "#total-" + num;
    prodttl =$(prodTotalID).val();
    subttl = totalSelector.val();
    totalSubVal = deciFormat(subttl - prodttl);
    totalSelector.val(totalSubVal);
    $("#subttlid").html(totalSubVal);
     totalBillVal = totalSubVal + shipTot;
    //final total
    $("#mahayog").html(deciFormat(totalBillVal));
    $("#invoiceyoghtml").val(deciFormat(totalBillVal));
};

var updateTotal = function () {

    var totalBillVal = deciFormat(parseFloat( samanYog()) + parseFloat(shipTot()));
    //refresh value
    $("#invoiceyoghtml").val(totalBillVal);
    $("#mahayog").html(totalBillVal);
    return totalBillVal;
};

var billUpyog = function () {

    $("#subttlform").val(samanYog());
    $("#invoiceyoghtml").val(updateTotal());
};

var rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if(discountVal=='') { $("#discount-"+numb).val(0);discountVal=0;}
    var vatVal = formInputGet("#vat", numb);
    if(vatVal=='') { $("#vat-"+numb).val(0);vatVal=0;}
    var taxo = 0;
    var disco = 0;
    var totalPrice = parseInt(amountVal)*priceVal;
    var tax_status = $("#tax_status").val();
      var disFormat = $("#discount_format").val();
 if (disFormat == '%' || disFormat == 'flat') {
     if (tax_status == 'yes') {
         var Inpercentage = precentCalc(totalPrice, vatVal);
         totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
         taxo = deciFormat(Inpercentage);
     console.log('percetn'+Inpercentage);  console.log('ttl'+totalValue);  console.log('price'+totalPrice); }
     else {
         totalValue = deciFormat(totalPrice);
     }
     if (disFormat == 'flat') {
         disco = deciFormat(discountVal);
         totalValue = parseFloat(totalValue) - parseFloat(discountVal);
     }
     else if (disFormat == '%') {
         var discount = precentCalc(totalValue, discountVal);
         totalValue = parseFloat(totalValue) - parseFloat(discount);
         disco = deciFormat(discount);
     }
     else {
         totalValue = deciFormat(totalValue);
     }
 } else{
//before tax
         if (disFormat == 'bflat') {
         disco = deciFormat(discountVal);
         totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
     }
     else if (disFormat == 'b_p') {
         var discount = precentCalc(totalPrice, discountVal);
         totalValue = parseFloat(totalPrice) - parseFloat(discount);
         disco = deciFormat(discount);
     }
     else {
         totalValue = deciFormat(totalPrice);
     }
     if (tax_status == 'yes') {
         var Inpercentage = precentCalc(totalValue, vatVal);
         totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
         taxo = deciFormat(Inpercentage);
         }
     else {
         totalValue = deciFormat(totalValue);
     }

}
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};

var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'on') {
        $(".tax_col").show();
        $("#tax_status").val('yes');
        $("#tax_format").val('%');
    }
    else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');
        $(".tax_col").hide();
    }
    var discount_handle = $("#discount_format").val();
    var tax_handle = $("#tax_status").val();
    formatRest(tax_handle, discount_handle);
}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);
    }
    else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_status").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat) {
    var amntArray = [];
    $('.amnt').each(function () {
        var v = deciFormat($(this).val());
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = deciFormat($(this).val());
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        var v = deciFormat($(this).val());
        vatArray.push(v);
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = deciFormat($(this).val());
        discountArray.push(v);
    });

    var taxr=0;var discsr=0;
    for (var i = 0; i < amntArray.length; i++) {

        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
             if (discountVal == '') {
                 discountVal = 0;
             }

         if (disFormat == '%' || disFormat == 'flat') {
             if (taxFormat == 'yes') {
                 var Inpercentage = precentCalc(result, vatVal);
                 var result = parseFloat(result) + Inpercentage;
                 taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                 $("#texttaxa-" + i).html(deciFormat(Inpercentage));
                 $("#taxa-" + i).val(deciFormat(Inpercentage));
             } else {
                 var result = parseFloat($("#amount-" + i).val()) * parseFloat($("#price-" + i).val());
                 $("#texttaxa-" + i).html('Off');
                 $("#taxa-" + i).val(0);
                 taxr += 0;
             }
             if (disFormat == '%') {
                 var Inpercentage = precentCalc(result, discountVal);
                 var result = parseFloat(result) - parseFloat(Inpercentage);
                 $("#disca-" + i).val(deciFormat(Inpercentage));
                 discsr = parseFloat(discsr) + parseFloat(Inpercentage);
             }  else {
                 var result = parseFloat(result) - parseFloat(discountVal);
                 $("#disca-" + i).val(deciFormat(discountVal));
                 discsr += parseFloat(discountVal);
             }
         }
         else {
             if (disFormat == 'b_p') {
                 var Inpercentage = precentCalc(result, discountVal);
                 var result = parseFloat(result) - parseFloat(Inpercentage);
                 $("#disca-" + i).val(deciFormat(Inpercentage));
                 discsr = parseFloat(discsr) + parseFloat(Inpercentage);
             } else {
                 var result = parseFloat(result) - parseFloat(discountVal);
                 $("#disca-" + i).val(deciFormat(discountVal));
                 discsr += parseFloat(discountVal);
             }
                if (taxFormat == 'yes') {
                 var Inpercentage = precentCalc(result, vatVal);
                 var result = parseFloat(result) + Inpercentage;
                 taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                 $("#texttaxa-" + i).html(deciFormat(Inpercentage));
                 $("#taxa-" + i).val(deciFormat(Inpercentage));
             } else {
                 var result = parseFloat($("#amount-" + i).val()) * parseFloat($("#price-" + i).val());
                 $("#texttaxa-" + i).html('Off');
                 $("#taxa-" + i).val(0);
                 taxr += 0;
             }
         }

        $("#total-" + i).val(deciFormat(result));
        $("#result-" + i).html(deciFormat(result));
        var sum = deciFormat(samanYog());
        var itemSum = shipTot();
        var totl = deciFormat(sum + itemSum);
        $("#subttlform").val(sum);
        $("#subttlid").html(sum);
        $("#mahayog").html(totl);
        $("#taxr").html(deciFormat(taxr));
        $("#discs").html(deciFormat(discsr));
        $("#invoiceyoghtml").val(totl);
    }
}

function refreshRows() {

}

//remove productrow


$( '#saman-row' ).on( 'click', '.removeProd', function () {

            var pidd = $(this).closest('tr').find('.pdIn').val();
            var pqty = $(this).closest('tr').find('.amnt').val();
            pqty = pidd + '-' + pqty;
            $('<input>').attr({
                type: 'hidden',
                id: 'restock',
                name: 'restock[]',
                value: pqty
            }).appendTo('form');
        $(this).closest('tr').remove();
        $('#d'+$(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
            $('.amnt').each(function (index) {
                rowTotal(index);billUpyog();
            });

        return false;
    });
$('#productname-0').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: baseurl + 'search_products/'+billtype,
            dataType: "json",
            method: 'post',
            data: {
                name_startsWith: request.term,
                type: 'product_list',
                row_num: 1,
                wid:$("#warehouses option:selected").val()
            },
            success: function (data) {
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(ui.item.data[3]);
        $('#discount-0').val(ui.item.data[4]);
        $('#dpid-0').val(ui.item.data[5]);
        rowTotal(0);
        billUpyog();
    }
});
 </script>
<!-- <script src="https://billing.ultimatekode.com/neo/assets/myjs/custom.js?v=3.3"></script> -->


</body>
</html>
