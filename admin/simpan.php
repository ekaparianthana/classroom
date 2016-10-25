<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$jurusan = $_POST['jurusan'];
	$status = $_POST['status'];
	
	$cek =  mysql_num_rows(mysql_query("SELECT * FROM admin WHERE username='$username'"));
	if ($cek == 0) {
		mysql_query("INSERT INTO admin(nama, alamat, email, username, password, id_jurusan, status) VALUES('$nama','$alamat','$email','$username','$password','$jurusan','$status')");
		
		echo "<center>Data Berhasil Disimpan<br />";
		echo "<img src='assets/img/icon/true.png' width='72' height='72' /></center>";
		echo "<meta http-equiv='refresh' content='1; url=index.php?page=admin/tampil.php' />";

	} else {
		echo "<center>Data Dengan Username Tersebut Sudah Ada<br />";
		echo "<img src='assets/img/icon/false.png' width='72' height='72' /></center>";
		echo "<meta http-equiv='refresh' content='1; url=index.php?page=admin/tampil.php' />";

 	}
 ?>