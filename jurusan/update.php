<?php 
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";

if (isset($_POST['id_jurusan'])) {
	$id_lama = $_POST['id_jurusan_lama'];
	$id = $_POST['id_jurusan'];
	$jurusan = $_POST['jurusan'];
	$cek = mysql_num_rows(mysql_query("SELECT * FROM jurusan WHERE id_jurusan='$id' && jurusan='$jurusan'"));
	if ($cek==0) {
		mysql_query("UPDATE jurusan SET id_jurusan='$id', jurusan='$jurusan' WHERE id_jurusan='$id_lama'");

		echo "<center>Data Berhasil Diubah<br />
		<img src='assets/img/icon/true.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";
		
	} else { 

		echo "<center>Data Sudah Ada<br />
		<img src='assets/img/icon/false.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";
	}
} elseif (isset($_POST['id_fakultas'])) {
	$id_lama = $_POST['id_fakultas_lama'];
	$id = $_POST['id_fakultas'];
	$fakultas = $_POST['fakultas'];
	$cek = mysql_num_rows(mysql_query("SELECT * FROM fakultas WHERE id_fakultas='$id' && fakultas='$fakultas'"));
	if ($cek==0) {
		mysql_query("UPDATE fakultas SET id_fakultas='$id', fakultas='$fakultas' WHERE id_fakultas='$id_lama'");
		
		echo "<center>Data Berhasil Diubah<br />
		<img src='assets/img/icon/true.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";
	
	} else {
		echo "<center>Data Sudah Ada<br />
		<img src='assets/img/icon/false.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='1; url=index.php?page=jurusan/tampil.php' />";
	}
}

?>
