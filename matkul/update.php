<?php 
if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==5)) {
	$id_lama = $_POST['id_lama'];
	$id = $_POST['id_matkul'];
	$matkul = $_POST['matkul'];
	$sks = $_POST['sks'];
	$cek = mysql_num_rows(mysql_query("SELECT * FROM matkul WHERE id_matkul='$id' && matkul='$matkul'"));
	if ($cek==0) {
		mysql_query("UPDATE matkul SET id_matkul='$id', matkul='$matkul', sks='$sks' WHERE id_matkul='$id_lama'");
?>

		<center>Data Berhasil Diubah<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=matkul/tampil.php" />

<?php
	} else { 
?>
		<center>Data Sudah Ada<br />
		<img src="assets/img/icon/false.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=matkul/tampil.php" />
<?php }
} else {
	echo "<meta http-equiv='refresh' content='1; url=index.php'>";
}	
?>
