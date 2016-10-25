<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$ruangan = $_POST['ruangan'];
	$fakultas = $_POST['fakultas'];
	$status = $_POST['sruangan'];
	
	$cek =  mysql_num_rows(mysql_query("SELECT * FROM ruangan WHERE ruangan='$ruangan' && id_fakultas='$fakultas'"));
	if ($cek == 0) {
		mysql_query("INSERT INTO ruangan(ruangan, status, id_fakultas) VALUES('$ruangan','$status','$fakultas')");

		echo "<center>Data Berhasil Disimpan<br />
	<img src='assets/img/icon/true.png' width='72' height='72' /></center>
	<meta http-equiv='refresh' content='1; url=index.php?page=ruangan/tampil.php' />";
	
	} else {

		echo "<center>Data ruangan Tersebut Sudah Ada<br />
	<img src='assets/img/icon/false.png' width='72' height='72' /></center>
	<meta http-equiv='refresh' content='1; url=index.php?page=ruangan/tampil.php' />";
    
 	}
 ?>