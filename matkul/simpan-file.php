<?php
	$idJurusan 	= $_POST['idJurusan'];
	$file		= $_FILES['file']['tmp_name'];
	
	$handle		= fopen($file, 'r');
	$count = 0;
	while(($fileop = fgetcsv($handle, 1000, ",")) !== false ){
		$count++;
		if ($count > 1) {
			//Cek Keberadaan Data
			$cek = mysql_num_rows(mysql_query("SELECT * FROM matkul WHERE id_matkul='$fileop[2]' && matkul='$fileop[1]'"));
			if ($cek == 0) {
				// Masukkan Data Mata Kuliah
				$query = mysql_query("INSERT INTO matkul(id_matkul, matkul, sks, penawaran, id_jurusan) VALUES('$fileop[2]','$fileop[1]','$fileop[3]', '$fileop[4]', '$idJurusan')");
				
				if($query) {
					// Pesan Data Berhasil disimpan
?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Pemberitahuan!</strong> Data Mata Kuliah No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> berhasil disimpan.
					</div>
<?php
				} else {
					// Pesan Data Gagal disimpan
?>
					<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Pemberitahuan!</strong> Data Mata Kuliah No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> gagal disimpan.
					</div>
<?php
				}
			} else {
				// Berikan Pesan kalau Data sudah ada
?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Pemberitahuan!</strong> Data Mata Kuliah No. <?php echo $fileop[0] . ". " . $fileop[1]; ?> sudah ada di Database.  
				</div>
<?php
			}
		}
	}
?>

<center> <a href="index.php?page=matkul/tampil.php" class="btn btn-primary">Kembali Ke Halaman Mata Kuliah</a></center>