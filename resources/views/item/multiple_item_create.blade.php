@extends('../layouts.master')
@section('content')
<?php
    $s = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 10);
?>  
<div class="container-fluid">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4>Add Multiple Items</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="container">   
                <form action="{{ route('excel_import') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <h2 class="text-center mt-3">Excel Import</h2><br><br>
                  <input type="file" name="excel_data" id="imgupload" style="display:none">
                  <img src="https://icons.iconarchive.com/icons/dakirby309/simply-styled/256/Microsoft-Excel-2013-icon.png" id="OpenImgUpload" style="max-width: 20%;"><br>
                  <span>
                    <p>1) Your Excel data should be in the format below.
                      <br>
                    2) In the Excel sheet, all columns should be filled. This is mandatory.</p>
                  </span>
                  <span class="text-muted">
                    <a class="float-r" href="{{ url('avhisheet') }}" title="Excel Download">Click Here to download sheet format</a>
                  </span>
                  <br><br>
                  <button type="submit" class="btn btn-primary block-center">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
  $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
</script>
@endsection

{{-- {{ route('excel_import') }} --}}