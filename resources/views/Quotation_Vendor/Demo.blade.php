<!DOCTYPE HTML>
<html>
<head>
	<script async='async' src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
	<link  rel="stylesheet" href="/dist/css/datatables.min.css"> 
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-4529508631166774",
		enable_page_level_ads: true
	  });
	</script>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="card">
    		<div class="card-header"><b>Select Excel File </b><input type="file" name="file"><span style="color:red;">only * xlsx extension file is allowed</span></div>
    		
    	</div>
		
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- webslesson_sidebarrightsec_AdSense1_1x1_as -->
		
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
        <div id="excel_data"></div>
    </div>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-87739877-1', 'auto');
		  ga('send', 'pageview');

	</script>
</body>
</html>


<script src="/dist/js/datatables.min.js"></script>
<script>

const excel_file = document.getElementById('excel_file');

excel_file.addEventListener('change', (event) => {

    if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
    {
        document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

        excel_file.value = '';

        return false;
    }

    var reader = new FileReader();

    reader.readAsArrayBuffer(event.target.files[0]);

    reader.onload = function(event){

        var data = new Uint8Array(reader.result);

        var work_book = XLSX.read(data, {type:'array'});

        var sheet_name = work_book.SheetNames;

        var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});

        if(sheet_data.length > 0)
        {
            var table_output = '<table class="table table-striped table-bordered">';

            for(var row = 0; row < sheet_data.length; row++)
            {

                table_output += '<tr>';

                for(var cell = 0; cell < sheet_data[row].length; cell++)
                {

                    if(row == 0)
                    {

                        table_output += '<th>'+sheet_data[row][cell]+'</th>';

                    }
                    else
                    {
                    	table_output += '<input type="text" value='+sheet_data[row][cell]+' disabled >';
                        // table_output += '<td>'+sheet_data[row][cell]+'</td>';

                    }

                }

                table_output += '</tr>';

            }

            table_output += '</table>';

            document.getElementById('excel_data').innerHTML = table_output;
        }

        excel_file.value = '';

    }

});

</script>