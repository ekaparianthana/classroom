<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {
		$id = $_GET['id'];
		mysql_query("DELETE FROM thn_ajar WHERE id_thn_ajar='$id'");
?>
	<center>Data Berhasil Dihapus<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
	</center>
	<meta http-equiv="refresh" content="1; url=index.php?page=tahun_ajar/tampil.php" />
<?php
	} else { 
		echo "<meta http-equiv='refresh' content='1; url=index.php'>"; 
	}
?>