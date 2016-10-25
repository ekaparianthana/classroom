<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {
		$data = $_GET['data'];
		$id = $_GET['id'];
		if ($data == 'fak') {
			mysql_query("DELETE FROM fakultas WHERE id_fakultas='$id'");
		} else {
			mysql_query("DELETE FROM jurusan WHERE id_jurusan='$id'");
		}
?>
	<center>Data Berhasil Dihapus<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
	</center>
	<meta http-equiv="refresh" content="1; url=index.php?page=jurusan/tampil.php" />
<?php
	} else { 
		echo "<meta http-equiv='refresh' content='1; url=index.php'>"; 
	}
?>