<?php
	$id = $_POST['id_matkul'];
	$matkul = $_POST['matkul'];
	$sks = $_POST['sks'];
	$jur = $_SESSION['jurusan'];
	$penawaran = $_POST['penawaran'];
	
	$cek =  mysql_num_rows(mysql_query("SELECT * FROM matkul WHERE id_matkul='$id' && matkul='$matkul'"));
	if ($cek == 0) {
		mysql_query("INSERT INTO matkul(id_matkul, matkul, sks, penawaran, id_jurusan) VALUES('$id','$matkul','$sks', '$penawaran', '$jur')");
?>
	<center>Data Berhasil Disimpan<br />
	<img src="assets/img/icon/true.png" width="72" height="72" /></center>
	<meta http-equiv="refresh" content="1; url=index.php?page=matkul/tampil.php" />

<?php
	} else {
?>
	<center>Data Mata Kuliah Tersebut Sudah Ada<br />
	<img src="assets/img/icon/false.png" width="72" height="72" /></center>
	<meta http-equiv="refresh" content="1; url=index.php?page=matkul/tampil.php" />
 
 <?php
 	}
 ?>