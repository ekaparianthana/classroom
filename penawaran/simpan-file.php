<?php
	//$idJurusan 	= $_POST['idJurusan'];
	$thn_ajar	= $_POST['thn_ajar'];
	$thn		= substr($thn_ajar,2,2);
	$semester	= $_POST['semester'];
	$file		= $_FILES['file']['tmp_name'];
	
	$handle		= fopen($file, 'r');
	$count = 0;
	while(($fileop = fgetcsv($handle, 1000, ",")) !== false ){
		$count++;
		if ($count > 1) {
			
			// GET Id Penawaran
			// Cek Keberadaan Data
			$kls = substr($fileop[6],1,1);
			$id_penawaran = $fileop[2].$thn.$semester.$kls;
			$query_penawaran = mysql_query("SELECT Id_Penawaran FROM penawaran WHERE Id_Penawaran = '$id_penawaran' ");
			$cek = mysql_num_rows($query_penawaran);
			if ($cek > 0) {
				$id_penawaran = mysql_result($query_penawaran,0);
			} else {
				// Get Data Mata Kuliah
				$query = mysql_query("SELECT id_matkul FROM matkul WHERE id_matkul = '$fileop[2]'");
				$cek = mysql_num_rows($query);
				
				if($cek > 0){
					// Masukkan Data Penawaran
					$query = mysql_query("INSERT INTO penawaran(Id_Penawaran,Id_MataKuliah, Id_Kelas, Tahun, Semester) VALUES('$id_penawaran','$fileop[2]','$kls','$thn_ajar', '$semester')");
					
					// Get Id penwaran yg baru dimasukkan
					$query = mysql_query("SELECT Id_Penawaran FROM penawaran WHERE Id_Penawaran = '$id_penawaran' ");
					$id_penawaran = mysql_result($query,0);
				} else {
					// Beri Pesan DAta Mata Kuliah Tidak ada.
					$id_penawaran = "0";
				
?>
				<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Pemberitahuan!</strong>  Data Penawaran No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> tidak disimpan.
                        Data Mata Kuliah <?php echo $fileop[2];?> belum tersedia. Silahkan masukkan data di <a href="/classroom_schedules/index.php?page=matkul/input.php">link ini</a>.
					</div>
<?php
				}
			}
			
			// GET Hari
			$hari = $fileop[4];
			
			// GET jam
			$jam = str_split($fileop[5]); 
			$jam = implode(',',$jam);
			
			// GET kelas
			$Id_Kelas = substr($fileop[6],1,1);
			
			// GET tanggal sekarang
			$tanggal = date("Y-m-d");
			
			// Get id ruangan 
			$query 	= mysql_query("SELECT id_ruangan FROM ruangan WHERE ruangan = '".$fileop[7]."' ");
			$cek	= mysql_num_rows($query);
			if ($cek>0) {
				$idRuangan = mysql_result($query,0);
			} else {
				// Beri Pesan Data Ruangan tidak Ada
				$idRuangan = "0";
?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Pemberitahuan!</strong> Data Penawaran No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> tidak disimpan.  
                    Data Ruangan <?php echo $fileop[7]; ?> tidak ada di Database, Silahkan Masukkan Data Ruangan tersebut terlebih dahulu!
				</div>
<?php 
			}
			
			if (($idRuangan != "0")&&($id_penawaran != "0")) {
				//Cek Jadwal
				$query = mysql_query("SELECT * FROM jadwal WHERE id_ruangan='$idRuangan' && id_penawaran='$id_penawaran' && hari='$hari' && jam='$jam'");
				if (mysql_num_rows($query) == 0) {
					// Simpan Jadwal 
					$query = mysql_query("INSERT INTO jadwal(id_ruangan, Id_Penawaran, hari, jam, Repetisi, tanggal, id_thn_ajar, keterangan) VALUES('$idRuangan','$id_penawaran','$hari','$jam','2','$tanggal','0','')");
					
					// Simpan Pengempu
					//$q_pengempu("INSERT INTO pengempu(Id_Penawaran, NIP_Dosen) VALUES('$id_penawaran, '$fileop[9]')");
					
					if ($query) {
						// Pesan Data berhasil di simpan
?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Pemberitahuan!</strong> Data Penawaran No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> berhasil disimpan.
						</div>
<?php
					} else {
						// Pesan Data Gagal disimpan
?>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Pemberitahuan!</strong> Data Penawaran No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> gagal disimpan.
						</div>

<?php 
					}
				}
			}
			
		}
	}
?>

<center> <a href="index.php?page=penawaran/tampil.php" class="btn btn-primary">Kembali Ke Halaman Penawaran</a></center>