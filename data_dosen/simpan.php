<?php
	$id = $_POST['id_dosen'];
	$nama = $_POST['nama_dosen'];
	$alamat = $_POST['alamat'];
	$jk	= $_POST['jk'];
	$email = $_POST['email'];
	$jur = $_SESSION['jurusan'];
	$username = $_POST['username'];
	$pass = $_POST['pass'];
	
	$cek =  mysql_num_rows(mysql_query("SELECT * FROM dosen WHERE id_dosen='$id' || nama='$nama'"));
	if ($cek == 0) {
		mysql_query("INSERT INTO dosen(id_dosen, nama, alamat, jk, email, id_jurusan, pass, username) VALUES('$id','$nama','$alamat', '$jk', '$email', '$jur', '$pass', '$username')");
?>
	<center>Data Berhasil Disimpan<br />
	<img src="assets/img/icon/true.png" width="72" height="72" /></center>
	<meta http-equiv="refresh" content="1; url=index.php?page=data_dosen/tampil.php" />

<?php
	} else {
?>
	<center>Data Mata Kuliah Tersebut Sudah Ada<br />
	<img src="assets/img/icon/false.png" width="72" height="72" /></center>
	<meta http-equiv="refresh" content="1; url=index.php?page=data_dosen/tampil.php" />
 
 <?php
 	}
 ?>
