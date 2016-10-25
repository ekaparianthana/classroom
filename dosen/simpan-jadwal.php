<?php
	$jurusan = $_SESSION["jurusan_dosen"];
	$idThnAjar = $_POST["idThnAjar"];
	$idJAktivitas = $_POST["j_aktivitas"];
	$Aktivitas = $_POST["Aktivitas"];
	$kelas = $_POST["kelas"];
	$jam = implode(',',$_POST["jam"]);
	$repetisi = $_POST["repetisi"];
	$hari = $_POST["hari"];
	$dosen = $_POST["idDosen"] ; 
	if ($_POST["tanggal"] != null ){
		$tanggal = $_POST["tanggal"];
		$array = explode('/',$tanggal);
		$tanggal = $array[2] . "-" . $array[0] . "-" . $array[1];
	} else {
		$tanggal = "0000-00-00";
	}
	$ket = $_POST["keterangan"];
	$ruangan = $_POST["idRuangan"];
	//$idAdmin = $_SESSION['user_id'];
	$tgl = date("Y-m-d H:i:s");
	
	
	$cek = mysql_num_rows(mysql_query("SELECT * FROM aktivitas WHERE nama_aktivitas='$Aktivitas' && id_jurusan='$jurusan'"));
	if($cek==0){
		mysql_query("INSERT INTO aktivitas(nama_aktivitas, id_jenis_aktivitas, id_jurusan) VALUES('$Aktivitas', '$idJAktivitas', '$jurusan')");
	}
	
	$query = mysql_query("SELECT id_aktivitas FROM aktivitas WHERE nama_aktivitas='$Aktivitas' && id_jurusan='$jurusan'");
	$idAktivitas = mysql_result($query,0);
	$query = mysql_query("INSERT INTO jadwal(id_ruangan, id_aktivitas, id_kelas, id_dosen, hari, jam, repetisi, tanggal, id_thn_ajar, keterangan) 
						 VALUES('$ruangan', '$idAktivitas', '$kelas', '$dosen', '$hari', '$jam', '$repetisi', '$tanggal', '$idThnAjar', '$ket')");
	if($query){
		$getID = mysql_query("SELECT id_jadwal FROM jadwal WHERE id_aktivitas='$idAktivitas' && id_kelas='$kelas' && id_thn_ajar='$idThnAjar'");
		$id_jadwal = mysql_result($getID, 0);
		
		$query_history = mysql_query("INSERT INTO history(id_jadwal, kegiatan, tanggal, id_ruangan, id_aktivitas, id_kelas, id_dosen, hari_jadwal, jam_jadwal, tgl_jadwal) VALUES('$id_jadwal', 'Tambah Jadwal', '$tgl', '$ruangan', '$idAktivitas', '$kelas', '$dosen', '$hari', '$jam', '$tanggal') ");

?>
			<center>Data Berhasil Disimpan<br />
			<img src="../assets/img/icon/true.png" width="72" height="72" /></center>
			<meta http-equiv="refresh" content="2; url=index.php?page=tampil-jadwal.php" />
<?php
	} else {
?>
	<center>Jadwal Gagal Disimpan<br />
	<img src="../assets/img/icon/false.png" width="72" height="72" /></center>
	<meta http-equiv="refresh" content="2; url=index.php?page=tampil-jadwal.php" />
<?php
	}
?>