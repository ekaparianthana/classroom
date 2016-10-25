<?php 
include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";

	$id = $_POST['id_admin'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];
	$jurusan = $_POST['jurusan'];
	
	mysql_query("UPDATE admin SET nama='$nama', alamat='$alamat', email='$email', id_jurusan='$jurusan' WHERE id_admin='$id'");
?>
		<center>Data Berhasil Diubah<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=admin/tampil.php" />
