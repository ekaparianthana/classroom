<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
		$id = $_GET['id'];
		mysql_query("DELETE FROM penawaran WHERE Id_Penawaran='$id'");
		mysql_query("DELETE FROM pengampu WHERE Id_Penawaran='$id'");
		mysql_query("DELETE FROM jadwal WHERE Id_Penawaran='$id'");
?>
	<center>Data Berhasil Dihapus<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
	</center>
	<meta http-equiv="refresh" content="1; url=index.php?page=penawaran/tampil.php" />
<?php
	} else { 
		echo "<meta http-equiv='refresh' content='1; url=index.php'>"; 
	}
?>