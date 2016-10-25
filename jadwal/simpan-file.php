<?php
	$idTahunAjar = $_POST['idTahunAjar'];
	$page	 	 = $_POST['page'];
	$idJurusan	 = $_POST['idJurusan'];
	$file		 = $_FILES['file']['tmp_name'];
	
	$handle = fopen($file, "r");
	
	$count =0;
	while(($fileop = fgetcsv($handle,1000,",")) !==false) {
		$count++;
		if($count>1){
			
			// Get id ruangan 
			$query 	= mysql_query("SELECT id_ruangan FROM ruangan WHERE ruangan = '".$fileop[7]."' ");
			$cek	= mysql_num_rows($query);
			if ($cek>0) {
				$idRuangan = mysql_result($query,0);
			} else {
				// Beri Pesan Data Ruangan tidak Ada
				$idRuangan = "Tidak ada";
?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Pemberitahuan!</strong> Data Jadwal No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> tidak disimpan.  
                    Data Ruangan <?php echo $fileop[7]; ?> tidak ada di Database, Silahkan hubungi Admin Pusat.
				</div>
<?php 
			}
			
			// Get id aktivitas
			$query	= mysql_query("SELECT id_aktivitas FROM aktivitas WHERE nama_aktivitas LIKE '%".$fileop[2]."%' ");
			$cek 	= mysql_num_rows($query);
			if ($cek>0) {
				$idAktivitas = mysql_result($query,0);
			} else {
				
				// Get data mata kuliah
				$query	= mysql_query("SELECT id_matkul, matkul FROM matkul WHERE id_matkul = '$fileop[2]' ");
				$cek	= mysql_num_rows($query);
				if ($cek>0) {
					// input data aktivitas
					$aktivitas = mysql_result($query,0,0) . " - " . mysql_result($query,0,1);
					mysql_query("INSERT INTO aktivitas(nama_aktivitas,  id_jenis_aktivitas, id_jurusan) VALUES('$aktivitas', '1', '$idJurusan')");
					
					// Get data aktivitas yang tadi
					$query	= mysql_query("SELECT id_aktivitas FROM aktivitas WHERE nama_aktivitas = '$aktivitas'");
					$idAktivitas = mysql_result($query,0);
				} else {
					// Beri pesan Data Mata Kuliah tidak ada
					$idAktivitas = "Tidak ada";
?>
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Pemberitahuan!</strong>  Data Jadwal No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> tidak disimpan.
                        Data Mata Kuliah <?php echo $fileop[2];?> belum tersedia. Silahkan masukkan data di <a href="/classroom_schedules/index.php?page=matkul/input.php">link ini</a>.
					</div>
<?php
				}	
			}
			
			// GET id Kelas
			$query = mysql_query("select id_kelas from kelas where kelas = '".$fileop[6]."' && id_jurusan='$idJurusan'");
			$cek = mysql_num_rows($query);
			if ($cek>0){
				$idKelas = mysql_result($query,0);
			} else {
				// Beri pesan Data Kelas tidak ada
				$idKelas = "Tidak ada";
				
?>
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Pemberitahuan!</strong>  Data Jadwal No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> tidak disimpan.
                Data Kelas <?php echo $fileop[6];?> belum tersedia. Silahkan masukkan data di <a href="/classroom_schedules/index.php?page=jadwal/tampil-jadwal-kelas.php">link ini</a>.
			</div>
<?php
			}
						
			// GET id Dosen
			$idDosen = $fileop[9];
			/*
			$query	= mysql_query("SELECT id_dosen FROM dosen WHERE nama = '".$fileop[7]."' ");
			$cek	= mysql_num_rows($query);
			if ($cek>0) {
				$idDosen = mysql_result($query,0);
			} else {
				$idDosen = '00000';
			} */
			
			// GET Hari
			$hari = $fileop[4];
			
			// GET jam
			$jam = str_split($fileop[5]); 
			$jam = implode(',',$jam);
			
			// GET tanggal sekarang
			$tanggal = date("Y-m-d");
			
			if (($idRuangan != "Tidak ada")&&($idAktivitas != "Tidak ada")&&($idKelas != "Tidak ada")) {
				// Cek Jadwal 
				$query	= mysql_query("SELECT * FROM jadwal WHERE id_ruangan='$idRuangan' && id_aktivitas='$idAktivitas' && id_kelas='$idKelas' && hari='$hari' && jam='$jam' && id_thn_ajar='$idTahunAjar'");
				if (mysql_num_rows($query) == 0) {
					echo mysql_num_rows($query);
					echo $idRuangan . ", " . $idAktivitas . ", " . $idKelas . ", " . $hari . ", " . $jam . ", " . $idTahunAjar;
					// Simpan Jadwal 
					$query = mysql_query("INSERT INTO jadwal(id_ruangan, id_aktivitas, id_kelas, id_dosen, hari, jam, Repetisi, tanggal, id_thn_ajar, keterangan) VALUES('$idRuangan','$idAktivitas','$idKelas','$idDosen','$hari','$jam','2','$tanggal','$idTahunAjar','')");
				
					if ($query) {
						// Pesan Data berhasil di simpan
?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Pemberitahuan!</strong> Data Jadwal No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> berhasil disimpan.
						</div>
<?php
					} else {
						// Pesan Data Gagal disimpan
?>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Pemberitahuan!</strong> Data Jadwal No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> gagal disimpan.
						</div>

<?php 
					}
				}
			}
		}
	}	
?>
<?php
if ($page == "kelas") {
	echo '<center> <a href="index.php?page=jadwal/tampil-jadwal-kelas.php" class="btn btn-primary">Kembali Ke Jadwal Kelas</a></center>';
} else {
	echo '<center> <a href="index.php?page=jadwal/tampil-jadwal-ruangan.php" class="btn btn-primary">Kembali Ke Jadwal Ruangan</a></center>';
}
?>