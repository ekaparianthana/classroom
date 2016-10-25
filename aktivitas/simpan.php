<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";

	$idJAktivitas = $_POST["j_aktivitas"];
	$Aktivitas = $_POST["Aktivitas"];
	$jurusan = $_POST["jurusan"];
	
	$cek = mysql_num_rows(mysql_query("SELECT * FROM aktivitas WHERE nama_aktivitas='$Aktivitas' && id_jurusan='$jurusan'"));
	if($cek==0){
		mysql_query("INSERT INTO aktivitas(nama_aktivitas, id_jenis_aktivitas, id_jurusan) VALUES('$Aktivitas', '$idJAktivitas', '$jurusan')");

		echo "Data Berhasil Disimpan.";
	
	} else {

		echo "Data Aktivitas Tersebut Sudah Ada.";

	}
?>
