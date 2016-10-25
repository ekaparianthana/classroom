<?php 
	if (isset($_SESSION['dosen_login'])) {
	
		$id = $_POST['id_dosen'];
		$username = $_POST['username'];
		$username_lama = $_POST['username_lama'];
		$pass_lama = $_POST['pass_lama'];
		$pass_baru = $_POST['pass_baru'];
		
		mysql_query("UPDATE jadwal SET username='0' WHERE id_dosen='$id'");
		
		$qrDosen = mysql_query("SELECT username FROM dosen WHERE username='$username'");
		$cekUsername=mysql_num_rows($qrDosen);
		if ($cekUsername == 0) {
			$qcek = mysql_query("SELECT * FROM dosen WHERE id_dosen='$id' AND pass='$pass_lama'");
			if (mysql_num_rows($qcek) == 1) {
				mysql_query("UPDATE dosen SET username='$username', pass='$pass_baru' WHERE id_dosen='$id'");
				$_SESSION['username_dosen'] = $username;
?>
				<center>Data Berhasil Diubah<br />
				<img src="../assets/img/icon/true.png" width="72" height="72" />
				</center>
				<meta http-equiv="refresh" content="1; url=index.php?page=ubah_pass.php&&id=<?php echo $id;?>" />
<?php
			} else {
				mysql_query("update dosen set username='$username_lama' where id_dosen='$id'");
?>
				<center>Password lama anda tidak sesuai<br />
        		<img src="../assets/img/icon/false.png" width="72" height="72" /></center>
        		<meta http-equiv="refresh" content="1; url=index.php?page=ubah_pass.php&&id=<?php echo $id;?>" />			
<?php
			}
		} else {
			mysql_query("update dosen set username='$username_lama' where id_dosen='$id'");
?>
			<center>Username tidak boleh digunakan<br />
        	<img src="../assets/img/icon/false.png" width="72" height="72" /></center>
        	<meta http-equiv="refresh" content="1; url=index.php?page=ubah_pass.php&&id=<?php echo $id;?>" />		
<?php
		} 	
	} else {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}	
?>
