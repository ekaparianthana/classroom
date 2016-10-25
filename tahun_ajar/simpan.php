<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$semester = $_POST['semester'];
	$thn_ajar = $_POST['thn_ajar'];
	
	$cek =  mysql_num_rows(mysql_query("SELECT * FROM thn_ajar WHERE smt='$semester' && thn_ajar='$thn_ajar'"));
	if ($cek == 0) {
		mysql_query("INSERT INTO thn_ajar(smt, thn_ajar) VALUES('$semester','$thn_ajar')");

	echo "<center>Data Berhasil Disimpan<br />
	<img src='assets/img/icon/true.png' width='72' height='72' /></center>
	<meta http-equiv='refresh' content='1; url=index.php?page=tahun_ajar/tampil.php' />";

	} else {
	
	echo "<center>Data Tersebut Sudah Tersedia<br />
	<img src='assets/img/icon/false.png' width='72' height='72' /></center>
	<meta http-equiv='refresh' content='1; url=index.php?page=tahun_ajar/tampil.php' />";

 	}
 ?>