<?php session_start();
	include dirname(__FILE__)."/config.php"; // error disini	

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
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="assets/css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="assets/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
    <!-- dataTables -->
	<link rel="stylesheet" href="assets/css/plugins/datatable/TableTools.css">
    <!-- chosen -->
	<link rel="stylesheet" href="assets/css/plugins/chosen/chosen.css">
	<!-- icheck -->
	<link rel="stylesheet" href="assets/css/plugins/icheck/all.css">
    <!-- Theme CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="assets/css/themes.css">
    <!-- select2 -->
	<link rel="stylesheet" href="assets/css/plugins/select2/select2.css">
    <link rel="stylesheet" href="assets/css/plugins/select2/select2-bootstrap.min.css">
    <!-- multi select -->
	<link rel="stylesheet" href="assets/css/plugins/multiselect/multi-select.css">
	<!-- Datepicker -->
	<link rel="stylesheet" href="assets/css/plugins/datepicker/datepicker.css">
    <!-- Fullcalendar -->
	<link rel="stylesheet" href="assets/css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="assets/css/plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Font -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Ubuntu:300,400,700" >
    <!-- Notify -->
	<link rel="stylesheet" href="assets/css/plugins/gritter/jquery.gritter.css">
    
	<!-- jQuery -->
	<script src="assets/js/jquery.min.js"></script>
    
	<!-- Nice Scroll -->
	<script src="assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- Validation -->
	<script src="assets/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="assets/js/plugins/validation/additional-methods.min.js"></script>
    <!-- icheck -->
	<script src="assets/js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- jQuery UI -->
    <script src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="assets/js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="assets/js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="assets/js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="assets/js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
    <script src="assets/js/plugins/jquery-ui/jquery.ui.slider.js"></script>
	<!-- slimScroll -->
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- Form -->
	<script src="assets/js/plugins/form/jquery.form.min.js"></script>
    <!-- dataTables -->
	<script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="assets/js/plugins/datatable/TableTools.min.js"></script>
	<script src="assets/js/plugins/datatable/ColReorderWithResize.js"></script>
	<script src="assets/js/plugins/datatable/ColVis.min.js"></script>
	<script src="assets/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/plugins/datatable/jquery.dataTables.grouping.js"></script>
	<!-- Chosen -->
	<script src="assets/js/plugins/chosen/chosen.jquery.min.js"></script>
    <!-- imagesLoaded -->
	<script src="assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
    <!-- Bootbox -->
	<script src="assets/js/plugins/bootbox/jquery.bootbox.js"></script>
    <!-- select2 -->
	<script src="assets/js/plugins/select2/select2.min.js"></script>
    <!-- MultiSelect -->
	<script src="assets/js/plugins/multiselect/jquery.multi-select.js"></script>
    <!-- Datepicker -->
	<script src="assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Moment -->
    <script src="assets/js/plugins/momentjs/jquery.moment.js"></script>
    <!-- FullCalendar -->
	<script src="assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- JQuery-QRCode -->
    <script src="assets/js/plugins/jqury-qrcode/jquery.qrcode-0.12.0.min.js"></script>
    <!-- JS ZIP -->
    <script src="assets/js/plugins/jszip/jszip.min.js"></script>
    <!-- Bootbox -->
	<script src="assets/js/plugins/bootbox/jquery.bootbox.js"></script>
    <!-- Notify -->
    <script src="assets/js/plugins/gritter/jquery.gritter.min.js"></script>
    
	<!-- Theme framework -->
	<script src="assets/js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="assets/js/application.min.js"></script>
   <!-- main scripts -->
	<script src="assets/js/main.js"></script>
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/img/favicon-app.ico" />
    
</head>

<?php
	if (isset($_SESSION['userlogin'])) { 
?>
<body>
	<div id="navigation">
		<div class="container">
			<a href="#" id="brand">CSAI</a>
			<ul class='main-nav'>
            <?php
				echo "<li> <a href='index.php?page=home.php'> <i class='icon-home'> </i> <span> Beranda </span> </a> </li>";
				if ($_SESSION['hak'] == 1) {
					echo "<li> <a href='index.php?page=penawaran/tampil.php'> <span> Penawaran </span> </a> </li>";
					echo "<li> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> <i class='icon-calendar'> </i> 
									<span> Jadwal</span>
									<span class='caret'></span> 
								</a>  
								<ul class='dropdown-menu'>
									<li> <a href='index.php?page=jadwal/tampil-jadwal-ruangan.php'> Ruangan </a> </li>
									<li> <a href='index.php?page=jadwal/tampil-jadwal-kelas.php'> Kelas </a> </li>
									<li> <a href='index.php?page=jadwal/tampil-jadwal-dosen.php'> Dosen </a> </li>
								</ul>
						  </li>";
					echo "<li> <a href='index.php?page=matkul/tampil.php'> <span> Mata Kuliah </span> </a> </li>";
					echo "<li> <a href='index.php?page=data_dosen/tampil.php'> <span> Dosen Pengajar </span> </a> </li>";
					echo "<li> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> <i class='icon-calendar'> </i> 
									<span> Master Data</span>
									<span class='caret'></span> 
								</a>  
								<ul class='dropdown-menu'>
									<li> <a href='index.php?page=ruangan/tampil.php'> Data Ruangan </a> </li>
									<li> <a href='index.php?page=kelas/tampil-jadwal-kelas.php'> Data Kelas </a> </li>
									<li> <a href='index.php?page=jurusan/tampil.php'> Data Jurusan </a> </li>
									<li> <a href='index.php?page=data_dosen/tampil.php'> Data Dosen </a> </li>
								</ul>
						  </li>";
				}
				if ($_SESSION['hak'] == 9) {
					echo "<li> <a href='index.php?page=admin/tampil.php'> <span> Admin Jurusan </span> </a> </li>";
                	echo "<li> <a href='index.php?page=tahun_ajar/tampil.php'> <span> Tahun Ajar </span> </a> </li>";
                	echo "<li> <a href='index.php?page=jurusan/tampil.php'> <span> Fakultas & Jurusan </span> </a> </li>";
                	echo "<li> <a href='index.php?page=ruangan/tampil.php'> <span> Ruangan </span> </a> </li>";
				}
			?>
			</ul>
            
			<div class="user">
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-user"></i> <span><?php echo $_SESSION['nama']; ?> </span> </a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="index.php?page=admin/ubah_pass.php&&id=<?php echo $_SESSION['user_id'];?>">Pengaturan Akun</a>
						</li>
						<li>
							<a href="index.php?page=logout.php">Sign Out</a>
						</li>
					</ul>
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
						if (!isset($page)){include dirname(__FILE__)."/halaman_login.php";} else { include dirname(__FILE__)."/$page";}
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

<?php
	} else { 
		include dirname(__FILE__)."/halaman_login.php";
	}
?>
</html>

