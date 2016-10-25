<?php 
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$id = $_POST['id_ruangan'];
	$ruangan = $_POST['ruangan'];
	$status = $_POST['sruangan'];
	$fakultas = $_POST['fakultas'];
	$cek = mysql_num_rows(mysql_query("SELECT * FROM ruangan WHERE ruangan='$ruangan' && id_fakultas='$fakultas'"));
	if ($cek==0) {
		mysql_query("UPDATE ruangan SET ruangan='$ruangan', status='$status', id_fakultas='$fakultas' WHERE id_ruangan='$id'");

		echo "<center>Data Berhasil Diubah<br />
		<img src='assets/img/icon/true.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=ruangan/tampil.php' />";

	} else {
     
		echo "<center>Data Sudah Ada<br />
		<img src='assets/img/icon/false.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=ruangan/tampil.php' />";
    }

?>
