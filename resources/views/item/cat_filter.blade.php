<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Table with Search Column Feature</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    table input{
        background: transparent;
        border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: groove;
        background-color: #eee;
  }

    tfoot {
        display: table-header-group;
    }

  table input:focus-visible{
    outline: none;
  }

  .col-filter{
    float:right;
  }

  .col-filter a{
    text-decoration: none;
    cursor: pointer;
    color: #000;

  }
</style>
</head>
<body>
    <table id="example" class="display" style="width:100%">
         <thead>
            <tr style="background-color:#007bff!important; color:#fff;">
           <!--    <th>S.No</th> -->
              <th>Item Code</th>
              <th>Part Number</th>   
              <th>Item Name</th>
              <th>Unit</th>
              <th>Rate</th>
              <th>HSN Code</th>
              <th>GST%</th>
              <th>Buy/Sale/Both</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Vendor Name</th>
              <th>vendor Location</th>  
              <th>Product/Service</th>
              <th>Current Stock</th>
              <th>Min Stock level</th>
              <th>Max Stock level</th>
              <th>Department</th>
              <th>Location</th>  
              <th>Consumption</th> 
              <th>Consumable</th>                
            </tr>
          </thead>
        <tbody id="tbl-tbody">
            @if (!empty($items))
              @foreach ($items as $row)
              <tr>
                <!-- <td>{{ $row->id }}</td> -->
                <td>{{ $row->item_number }}</td>
                <td>{{ $row->part_number }}</td>
                <td>{{ $row->item_name }}
                  <div class="dropout">
        <button class="more">
         <span></span>
         <span></span>
         <span></span>
        </button>
        <ul>
          <li>
              <a href="{{ route('item.edit',$row->id) }}"><i class="fa fa-external-link btn-xs" style="margin-left:12px;" aria-hidden="true"></i></a>
          </li>

          <form action="{{ route('item.destroy',$row->id) }}" method="POST">
                 @csrf
                @method('DELETE')
                <li>
                    <button type="submit" style="border:none; background:none; margin-left:7px;"><i class="fa fa-trash btn-danger btn-xs" aria-hidden="true"></i></button>
                </li>
            </form>     
        </ul>
      </div>
                
                </td>
                <td>{{ $row->unit_id }}</td> 
                <td>{{ $row->rate }}</td>  
                <td>{{ ($row->hsn_code) ? $row->hsn_code : 'N/A' }}</td>
                <td>{{ $row->gst }}</td>
                <td>{{ $row->buy_sale_both }}</td>
                <td>{{ $row->category_id }}</td>
                <td>{{ $row->brand_id}}</td>
                <td>{{ $row->vendor_name }}</td>
                <td>{{ $row->vendor_location }}</td> 
                <td>{{ $row->product_service_name }}</td>
                <td>{{ $row->current_stock }}</td>
                <td>{{ $row->min_stock_level }}</td>
                <td>{{ $row->max_stock_level }}</td>
                <td>{{ $row->dapartment}}</td>
                <td>{{ $row->location }}</td>
                <td>{{ $row->consumption }}</td>
                <td>{{ $row->consumable }}</td>                           
              </tr>
              @endforeach
            @endif
          </tbody>
    </table>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
    // Setup - add a text input to each footer cell
    
    // DataTable
    var table = $('#example').DataTable({
        initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },
    });


    $('tfoot').each(function () {
    $(this).insertAfter($(this).siblings('thead'));
});
});
</script>
<script type="text/javascript">
 document.querySelector('table').onclick = ({
  target
}) => {
  if (!target.classList.contains('more')) return
  document.querySelectorAll('.dropout.active').forEach(
    (d) => d !== target.parentElement && d.classList.remove('active')
  )
  target.parentElement.classList.toggle('active')
}
</script>
</body>
</html>