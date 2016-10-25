<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {
		$id = $_GET['id'];
		mysql_query("DELETE FROM admin WHERE id_admin='$id'");
?>
	<center>Data Berhasil Dihapus<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
	</center>
	<meta http-equiv="refresh" content="1; url=index.php?page=admin/tampil.php" />
<?php
	} else { 
		echo "<meta http-equiv='refresh' content='1; url=index.php'>"; 
	}
?>