<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Data Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <style>
        tfoot {
            display: table-row-group;
        }
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }

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
        .goods-link{
            border: 1px solid green;
            border-radius: 100px;
            font-size: 14px;
        }
        .god-link{
            border: 1px solid red;
            border-radius: 100px;
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="table-responsive">
        <table id="examplee" class="table table-bordered display" style="width:100%">
            <thead>
                <tr class="text-center" style="background-color: #0c637f!important; color:#fff;">
                    <th>Company Name</th>
                    <th>Transaction Name</th>
                    <th>Document Number</th>
                    <th>Goods Status</th>
                    <th>Last Modified</th>
                </tr>
            </thead>
            <tbody id="tbl-tbody">
                <tr class="text-center">
                    <td>Surya Demo Supplier</td>
                    <td>Dummy Purchase Order Transaction</td>
                    <td>PO - PO00001</td>
                    <td>
                        <a href="#" class="btn text-success goods-link">Received</a>
                        <!-- <button class="btn rounded-pill">Received</button> -->
                    </td>
                    <td>30/06/2022, 10:00</td>
                </tr>
                <tr class="text-center">
                    <td>Merc Demo Buyer</td>
                    <td>Dummy Order Confirmation Transaction</td>
                    <td>OC - OC00001</td>
                    <td>
                        <a href="#" class="btn text-danger god-link">Not Dispatched</a>
                    </td>
                    <td>30/06/2022, 10:00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="color:#fff;">
                    <td>Company Name</td>
                    <td>Transaction Name</td>
                    <td>Document Number</td>
                    <td>Goods Status</td>
                    <td>Last Modified</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#examplee tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    // DataTable
    var table = $('#examplee').DataTable({
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
</body>
</html>