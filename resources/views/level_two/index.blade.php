<!DOCTYPE html>
<html lang="en">
<head>
	<title>JavaScript example</title>
	<meta charSet="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<style media="only screen">
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            box-sizing: border-box;
            -webkit-overflow-scrolling: touch;
        }

        html {
            position: absolute;
            top: 0;
            left: 0;
            padding: 0;
            overflow: auto;
        }

        body {
            padding: 1rem;
            overflow: auto;
        }
    </style>
	
</head>
<body>
	<div class="container">
		<div class="columns">
			<label class="option" for="selectedOnly">
			<input id="selectedOnly" type="checkbox">Selected Rows Only</label>
				<div>
					<button onclick="onBtExport()" style="font-weight: bold">Export to Excel</button>
				</div>
		</div>
		<div class="grid-wrapper">
			<div id="myGrid" class="ag-theme-alpine">
			</div>
		</div>
	</div>
	<script>var __basePath = './';</script>
	<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@28.2.1/dist/ag-grid-enterprise.min.js">
	</script>
	 <script src="main.js">
	</script> 

</body>
		<link rel="stylesheet" href="styles.css"/>
</html>