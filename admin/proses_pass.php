<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
		$id = $_POST['id_admin'];
		$username = $_POST['username'];
		$username_lama = $_POST['username_lama'];
		$pass_lama = $_POST['pass_lama'];
		$pass_baru = $_POST['pass_baru'];
		
		mysql_query("UPDATE admin SET username='0' WHERE id_admin='$id'");
		
		$qrAdmin = mysql_query("SELECT username FROM admin WHERE username='$username'");
		$cekUsername=mysql_num_rows($qrAdmin);
		if ($cekUsername == 0) {
			$qcek = mysql_query("SELECT * FROM admin WHERE id_admin='$id' AND password='$pass_lama'");
			if (mysql_num_rows($qcek) == 1) {
				mysql_query("UPDATE admin SET username='$username', password='$pass_baru' WHERE id_admin='$id'");
				$_SESSION['username'] = $username;
				
				echo "<center>Data Berhasil Diubah<br />";
				echo "<img src='assets/img/icon/true.png' width='72' height='72' />";
				echo "</center>";
				echo "<meta http-equiv='refresh' content='1; url=index.php?page=admin/tampil.php' />";
								
			} else {
				mysql_query("update admin set username='$username_lama' where id_admin='$id'");
				
				echo "<center>Password lama anda tidak sesuai<br />
        			  <img src='assets/img/icon/false.png' width='72' height='72' /></center>
        			  <meta http-equiv='refresh' content='1; url=index.php?page=admin/ubah_pass.php&&id=<?php echo $id;?>' />";
						
			}
		} else {
			mysql_query("update admin set username='$username_lama' where id_admin='$id'");
			
			echo "<center>Username tidak boleh digunakan<br />
        	<img src='assets/img/icon/false.png' width='72' height='72' /></center>
        	<meta http-equiv='refresh' content='1; url=index.php?page=admin/ubah_pass.php&&id=<?php echo $id;?>' />";
        	
		} 		
?>
