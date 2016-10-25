<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==5)) {
		$id = $_GET['id'];
		mysql_query("DELETE FROM matkul WHERE id_matkul='$id'");
?>
	<center>Data Berhasil Dihapus<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
	</center>
	<meta http-equiv="refresh" content="1; url=index.php?page=matkul/tampil.php" />
<?php
	} else { 
		echo "<meta http-equiv='refresh' content='1; url=index.php'>"; 
	}
?>