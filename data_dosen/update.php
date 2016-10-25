<?php 
if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
	$id_lama = $_POST['id_lama'];
	$id = $_POST['id_dosen'];
	$nama = $_POST['nama_dosen'];
	$alamat = $_POST['alamat'];
	$jk	= $_POST['jk'];
	$email = $_POST['email'];
	$cek = mysql_num_rows(mysql_query("SELECT * FROM dosen WHERE id_dosen='$id' && nama='$nama'"));
	if ($cek==0) {
		mysql_query("UPDATE dosen SET id_dosen='$id', nama='$nama', alamat='$alamat', jk='$jk', email='$email' WHERE id_dosen='$id_lama'");
?>

		<center>Data Berhasil Diubah<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=data_dosen/tampil.php" />

<?php
	} else { 
?>
		<center>Data Sudah Ada<br />
		<img src="assets/img/icon/false.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=data_dosen/tampil.php" />
<?php }
} else {
	echo "<meta http-equiv='refresh' content='1; url=index.php'>";
}	
?>
