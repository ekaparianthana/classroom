<?php session_start();
	include dirname(dirname(__FIlE__)) . "/config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<title>Classroom Schedule and Activity Information</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="../assets/css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="../assets/css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="../assets/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
    <!-- dataTables -->
	<link rel="stylesheet" href="../assets/css/plugins/datatable/TableTools.css">
    <!-- chosen -->
	<link rel="stylesheet" href="../assets/css/plugins/chosen/chosen.css">
	<!-- icheck -->
	<link rel="stylesheet" href="../assets/css/plugins/icheck/all.css">
    <!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="../assets/css/themes.css">
    <!-- select2 -->
	<link rel="stylesheet" href="../assets/css/plugins/select2/select2.css">
    <link rel="stylesheet" href="../assets/css/plugins/select2/select2-bootstrap.min.css">
    <!-- multi select -->
	<link rel="stylesheet" href="../assets/css/plugins/multiselect/multi-select.css">
	<!-- Datepicker -->
	<link rel="stylesheet" href="../assets/css/plugins/datepicker/datepicker.css">
    <!-- Fullcalendar -->
	<link rel="stylesheet" href="../assets/css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="../assets/css/plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Font -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Ubuntu:300,400,700" >
    <!-- Notify -->
	<link rel="stylesheet" href="../assets/css/plugins/gritter/jquery.gritter.css">
    
	<!-- jQuery -->
	<script src="../assets/js/jquery.min.js"></script>
    
	<!-- Nice Scroll -->
	<script src="../assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- Validation -->
	<script src="../assets/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="../assets/js/plugins/validation/additional-methods.min.js"></script>
    <!-- icheck -->
	<script src="../assets/js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- jQuery UI -->
    <script src="../assets/js/jquery-ui.js"></script>
	<script src="../assets/js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="../assets/js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="../assets/js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="../assets/js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="../assets/js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
    <script src="../assets/js/plugins/jquery-ui/jquery.ui.slider.js"></script>
	<!-- slimScroll -->
	<script src="../assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="../assets/js/bootstrap.min.js"></script>
	<!-- Form -->
	<script src="../assets/js/plugins/form/jquery.form.min.js"></script>
    <!-- dataTables -->
	<script src="../assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="../assets/js/plugins/datatable/TableTools.min.js"></script>
	<script src="../assets/js/plugins/datatable/ColReorderWithResize.js"></script>
	<script src="../assets/js/plugins/datatable/ColVis.min.js"></script>
	<script src="../assets/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
	<script src="../assets/js/plugins/datatable/jquery.dataTables.grouping.js"></script>
	<!-- Chosen -->
	<script src="../assets/js/plugins/chosen/chosen.jquery.min.js"></script>
    <!-- imagesLoaded -->
	<script src="../assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
    <!-- Bootbox -->
	<script src="../assets/js/plugins/bootbox/jquery.bootbox.js"></script>
    <!-- select2 -->
	<script src="../assets/js/plugins/select2/select2.min.js"></script>
    <!-- MultiSelect -->
	<script src="../assets/js/plugins/multiselect/jquery.multi-select.js"></script>
    <!-- Datepicker -->
	<script src="../assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Moment -->
    <script src="../assets/js/plugins/momentjs/jquery.moment.js"></script>
    <!-- FullCalendar -->
	<script src="../assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- JQuery-QRCode -->
    <script src="../assets/js/plugins/jqury-qrcode/jquery.qrcode-0.12.0.min.js"></script>
    <!-- JS ZIP -->
    <script src="../assets/js/plugins/jszip/jszip.min.js"></script>
    <!-- Bootbox -->
	<script src="../assets/js/plugins/bootbox/jquery.bootbox.js"></script>
    <!-- Notify -->
    <script src="../assets/js/plugins/gritter/jquery.gritter.min.js"></script>
    
	<!-- Theme framework -->
	<script src="../assets/js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="../assets/js/application.min.js"></script>
   <!-- main scripts -->
	<script src="../assets/js/main.js"></script>
	<!-- Favicon -->
	<link rel="shortcut icon" href="../assets/img/favicon-app.ico" />
    
</head>

<body>
	<div id="navigation">
		<div class="container">
			<a href="#" id="brand">CSAI</a>
			<ul class='main-nav'>
            		<li> <a href='index.php?page=ruangan.php'> <span> Jadwal Ruangan </span> </a> </li>
                    <li> <a href='index.php?page=kelas.php'> <span> Jadwal Kelas </span> </a> </li>
                    <li> <a href='index.php?page=dosen.php'> <span> Jadwal Dosen </span> </a> </li>
			</ul>
            
      		<div class="user">
            	<div class="dropdown">
					<a href="/classroom_schedules/index.php"> <span> Login Admin </span> </a>
				</div>
            </div>
		</div>
	</div> <!-- navigation -->
    
    <div class="container" id="content"> 
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1 style="color:#000066">Classroom Schedule and Activity Information</h1>
					</div>
					<div class="pull-right">
						<ul class="stats">
							<li class='darkblue'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>
				</div> <!-- page-header -->
                
				<div class="row-fluid">
					<?php
						if (isset($_GET['page'])){$page = $_GET['page'];}
						if (!isset($page)){include dirname(__FILE__) . "/sambutan.html";} else { include dirname(__FILE__) . "/$page";}
					?>
				</div> <!-- row --> 
			</div> <!-- container -->
		</div> <!-- main -->
        <div id="footer">
			<p>
				Classroom Schedule and Activity Information Web Based System <span class="font-grey-4">|</span> <a href="#">Contact</a> <span class="font-grey-4">|</span> <a href="#">Imprint</a> 
			</p>
			<a href="#" class="gototop"><i class="icon-arrow-up"></i></a>
		</div> <!-- footer -->  
    </div> <!-- content -->         
</body>

</html>


