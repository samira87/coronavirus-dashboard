<!DOCTYPE html>
<html lang=en-US>
<head>
	<meta name=viewport content="width=device-width, initial-scale=1, initial-scale=1.0">
	<title>Coronavirus Dashboard</title>

    <script src="assets/bundle/js/jquery.slim.min.js" type="text/javascript"></script>
    <script src="assets/bundle/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="assets/js/content.js" type="text/javascript"></script>
	

    <link href="assets/bundle/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" data-theme-bootstrap>
    <link href="assets/bundle/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/bundle/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" data-theme-style>
	<link rel="stylesheet" type="text/css" href="assets/css/theme.css" >
	<link rel="shortcut icon" href="assets/images/favicon.png" type="image/png" sizes=32x32>
</head>

<body class="coronavirus-theme bg-dark theme-dark" data-spy="scroll" data-offset="80">
	<header>
	    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
	        <a class="navbar-brand" href="#"><h1 class="display-5 d-none d-md-inline">Coronavirus Dashboard</h1>
	            <span><i class="fa fa-virus"></i> | COVID-19 Tracker</span></a>
				<span class="pull-right"><i class="fa fa-adjust" data-theme-switch></i></span>
	    </nav>
	</header>
	
	<!-- main content -->
	<div id="atf"></div>
	<div id="btf">    
	    <div class="container-fluid">
	
	       <?php include_once('parts/dashboard.php'); ?>
		   
	    </div><!--end container-fluid-->
	</div>

	<!-- /main content -->
    <script async defer src="assets/js/script.js"></script>
    <script async defer src="assets/js/map.js"></script>
    <script async defer src="assets/js/chart.js"></script>
    <script async defer src="assets/js/top.js"></script>
    <script async defer src="assets/js/table.js"></script>
    <script async defer src="assets/js/news.js"></script>
    <script async defer src="assets/js/theme.js"></script>
	<script src='assets/bundle/js/a076d05399.js'></script>
</body>
</html>
 