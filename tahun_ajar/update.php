<?php 
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$id = $_POST['id_thn_ajar'];
	$semester = $_POST['semester'];
	$thn_ajar = $_POST['thn_ajar'];
	
	$cek = mysql_num_rows(mysql_query("SELECT * FROM thn_ajar WHERE smt='$semester' && thn_ajar='$thn_ajar'"));
	
	if ($cek==0) {
		mysql_query("UPDATE thn_ajar SET smt='$semester', thn_ajar='$thn_ajar' WHERE id_thn_ajar='$id'");

		echo "<center>Data Berhasil Diubah<br />
		<img src='assets/img/icon/true.png' width='72' height='72' /></center>
		<meta http-equiv='refresh' content='1; url=index.php?page=tahun_ajar/tampil.php' />";
		
	} else { 
		
		echo "<center>Data Sudah Ada<br />
		<img src='assets/img/icon/false.png' width='72' height='72' />
		</center>
		<meta http-equiv='refresh' content='2; url=index.php?page=tahun_ajar/tampil.php' />";
		
	}
?>
