<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Data Table </title>
    <meta content="" name="description">
    <meta content="Author" name="MJ Maraz">
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- ========================================================= -->



    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet">





</head>
<!-- =============== Design & Develop By = MJ MARAZ   ====================== -->

<body>
    <header class="header_part">
        <img src="assets/images/logo.png" alt="" class="img-fluid">
        <h4>How to Make - Data Table - Bootstrap 5</h4>
    </header>
    <!-- =======  Data-Table  = Start  ========================== -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="data_table">
                    <table id="example" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- =======  Data-Table  = End  ===================== -->
    <!-- ============ Java Script Files  ================== -->



    <script src="{{ asset('dist/javaScript/custom.js') }}"></script>
    <script src="{{ asset('dist/javaScript/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/javaScript/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/datatables.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('dist/javaScript/bootstrap.bundle.min.js') }}"></script>




</body>

</html>
