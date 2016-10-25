<?php
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



	//cek keberaddan data id_penawaran
        $query_penawaran = mysql_query("SELECT Id_Penawaran FROM penawaran WHERE Id_Penawaran = '$idPenawaran' ");
        $cek_penawran = mysql_num_rows($query_penawaran);


        if($cek_penawran > 0){
                    $idPenawaran = mysql_result($query_penawaran,0);
                    // echo '
                    // <div class="alert alert-danger">
                    //     <button type="button" class="close" data-dismiss="alert">&times;</button>
                    //     <strong>Pemberitahuan!</strong>  Data Penawaran '.$id_matakuliah.' Duplikat
                    // </div>
                    // ';
                  ?>
						<center>Jadwal Gagal Disimpan, Data Penawaran Duplikat<br />
					<img src="assets/img/icon/false.png" width="72" height="72" /></center>
					<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />

                  <?php 

        } else {

        
					// echo $idPenawaran;
					//$cek = mysql_query("SELECT * FROM penawaran WHERE Id_Penawaran = '$idPenawaran'");
					
					$query = mysql_query("INSERT INTO penawaran(Id_Penawaran, Id_MataKuliah, Id_Kelas, Tahun, Semester, Ruang, Hari) 
										 VALUES('$idPenawaran', '$MataKuliah', '$kelas', '$thn_ajar', '$semester', '', '')");
										 
					if($query){
						$query = mysql_query("INSERT INTO jadwal(id_ruangan, Id_Penawaran, hari, jam, Repetisi, tanggal, keterangan) 
													VALUES('$ruangan', '$idPenawaran', '$hari', '$jam', '2', '$tanggal', '$ket')");
						$querypengampu=mysql_query("INSERT INTO pengampu VALUES('','$idPenawaran','$nip_dosen','')");
						
				?>
							<center>Data Berhasil Disimpan<br />
							<img src="assets/img/icon/true.png" width="72" height="72" /></center>
							<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />
				<?php
					} else {
				?>
					<center>Jadwal Gagal Disimpan<br />
					<img src="assets/img/icon/false.png" width="72" height="72" /></center>
					<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />
				<?php
					}


		}
				?>
       


