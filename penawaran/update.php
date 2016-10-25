<?php
	$id=$_GET['id'];
	$jurusan  = $_POST["jurusan"];
	$semester = $_POST["semester"];
	$thn_ajar = $_POST["thn_ajar"];
	$MataKuliah = $_POST["matkul"];
	$kelas = $_POST["kelas"];
	// $dosen = $_POST['dosen'];
	$hari = isset($_POST["hari"]) ? $_POST["hari"]: '';
	$jam1=isset($_POST["jam"]) ? $_POST["jam"] :'';


	if($jam1==''){
		$jam='';
	}else{
		$jam = implode(',',$jam1);
	}
	
	$ruangan = isset($_POST['ruangan']) ? $_POST['ruangan']: '' ;
	$tanggal = date("Y-m-d");
	$ket = $_POST["keterangan"];
	$nip_dosen = $_POST["nip_dosen"];
	

	$tgl = date("Y-m-d H:i:s");
	
	$idPenawaran = $MataKuliah . substr($thn_ajar,2,2) . $semester . $kelas;



	
					$querypenawaran=" UPDATE penawaran
									SET Id_MataKuliah='$MataKuliah',Id_Kelas='$kelas',Tahun='$thn_ajar',Semester = '$semester'
								WHERE Id_Penawaran='$id'";
						// echo $querypenawaran;
						// exit();
        
					// echo $idPenawaran;
					//$cek = mysql_query("SELECT * FROM penawaran WHERE Id_Penawaran = '$idPenawaran'");
					$query=mysql_query($querypenawaran);
					// $query = mysql_query("INSERT INTO penawaran(Id_Penawaran, Id_MataKuliah, Id_Kelas, Tahun, Semester, Ruang, Hari) 
					// 					 VALUES('$idPenawaran', '$MataKuliah', '$kelas', '$thn_ajar', '$semester', '', '')");
										 
					if($query){
						$query=mysql_query(
							" UPDATE jadwal
									SET id_ruangan='$ruangan',hari='$hari',jam='$jam',tanggal = '$tanggal', keterangan ='$ket'
								WHERE Id_Penawaran='$id'");
						// $query = mysql_query("INSERT INTO jadwal(id_ruangan, Id_Penawaran, hari, jam, Repetisi, tanggal, keterangan) 
						// 							VALUES('$ruangan', '$idPenawaran', '$hari', '$jam', '2', '$tanggal', '$ket')");
						$querypengampu=mysql_query(
							"UPDATE pengampu 
								SET NIP_Dosen='$nip_dosen'
								WHERE Id_Penawaran= '$id'
							");
						//$querypengampu=mysql_query("INSERT INTO pengampu VALUES('','$idPenawaran','$nip_dosen','')");
						
				?>
							<center>Data Berhasil Diubah<br />
							<img src="assets/img/icon/true.png" width="72" height="72" /></center>
							<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />
				<?php
					} else {
				?>
					<center>Jadwal Gagal Diubah<br />
					<img src="assets/img/icon/false.png" width="72" height="72" /></center>
					<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />
				<?php
					}


?>
       


