<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	if(isset($_POST['id_jurusan'])){

		$id = $_POST['id_jurusan'];
		$jurusan = $_POST['jurusan'];
		$fakultas = $_POST['fakultas'];
	
		$cek =  mysql_num_rows(mysql_query("SELECT * FROM jurusan WHERE id_jurusan='$id' || jurusan='$jurusan'"));
		if ($cek == 0) {
			mysql_query("INSERT INTO jurusan(id_jurusan, jurusan, id_fakultas) VALUES('$id', '$jurusan', '$fakultas')");
			
			echo "<center>Data Berhasil Disimpan<br />
			<img src='assets/img/icon/true.png' width='72' height='72' /></center>
			<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";
	
		} else {
		
			echo "<center>Data Jurusan Tersebut Sudah Ada<br />
			<img src='assets/img/icon/false.png' width='72' height='72' /></center>
			<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";

 		} 
	} elseif (isset($_POST['id_fakultas'])) {
	
		$id = $_POST['id_fakultas'];
		$fakultas = $_POST['fakultas'];
	
		$cek =  mysql_num_rows(mysql_query("SELECT * FROM fakultas WHERE id_fakultas='$id' || fakultas='$fakultas'"));
		if ($cek == 0) {
			mysql_query("INSERT INTO fakultas(id_fakultas, fakultas) VALUES('$id', '$fakultas')");

			echo "<center>Data Berhasil Disimpan<br />
			<img src='assets/img/icon/true.png' width='72' height='72' /></center>
			<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";

		} else {

			echo "<center>Data Fakultas Tersebut Sudah Ada<br />
			<img src='assets/img/icon/false.png' width='72' height='72' /></center>
			<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";

 		} 
	} 
 ?>