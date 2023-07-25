<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Item </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="container-fluid p-2"> 
            <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Items Table</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-2">
                <table id="example" class="display nowrap table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Item Number</th>
                            <th>Part number</th>
                            <th>Item name</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Hsn code</th>
                            <th>GST</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                          <td>{{ $item->item_number }}</td>
                          <td>{{ $item->part_number }}</td>
                          <td>{{ $item->item_name }}</td>
                          <td>{{ $item->description }}</td>
                          <td>{{ $item->unit_id }}</td>
                          <td>{{ $item->rate }}</td>
                          <td>{{ $item->hsn_code }}</td>
                          <td>{{ $item->gst }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
</html>









                                      