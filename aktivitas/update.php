<?php
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
		$id_aktivitas = $_POST['id_aktivitas'];
		$jAktivitas = $_POST['j_aktivitas'];
		$aktivitas = $_POST['Aktivitas'];
		
		$cek = mysql_num_rows(mysql_query("SELECT * FROM aktivitas WHERE id_jenis_aktivitas='$jAktivitas' && nama_aktivitas='$aktivitas'"));
		if ($cek==0) {
			mysql_query("UPDATE aktivitas SET id_jenis_aktivitas='$jAktivitas', nama_aktivitas='$aktivitas' WHERE id_aktivitas='$id_aktivitas'");
			echo $id_aktivitas;
?>
		<center>Data Berhasil Diubah<br />
		<img src="assets/img/icon/true.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=aktivitas/tampil.php" />
<?php 
		} else {
?>
		<center>Data Sudah Ada<br />
		<img src="assets/img/icon/false.png" width="72" height="72" />
		</center>
		<meta http-equiv="refresh" content="1; url=index.php?page=aktivitas/tampil.php" />
<?php
		}
	} else {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}
?>