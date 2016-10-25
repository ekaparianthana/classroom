<?php
	 require_once('../config.php');
	// echo '<pre>';
	// print_r($_POST);
	// exit();

	//$halaman = $_GET["id"];
	// $jurusan = $_SESSION["jurusan"];
	// $jurusan = '05502';
	$thn_ajar = $_POST["idThnAjar"];
	//$idJAktivitas = $_POST["j_aktivitas"];
	//$Aktivitas = $_POST["Aktivitas"];
	$idRuangan = $_POST["idRuangan"];
	$id_matakuliah = $_POST["id_matkul"];
	$semester_kelas=$_POST["kelas_pilih"];
	$repetisi=$_POST['repetisi'];
	 $tanggal_now=$_POST['tanggal_insert'];
	$semester = substr($semester_kelas, 0,1);
	$kelas = substr($semester_kelas, 1,2);

	//$kelas = $_POST["kelas"];
	$jam = implode(',',$_POST["jam"]);
	//$repetisi = $_POST["repetisi"];
	$hari = $_POST["hari"];
	$nip_dosen = $_POST["dosen"];
	//$dosen = (empty($_POST["dosen"])) ? '00000' : $_POST["dosen"] ; 
	// if ($_POST["tanggal"] != null ){
	// 	$tanggal = $_POST["tanggal"];
	// 	$array = explode('/',$tanggal);
	// 	$tanggal = $array[2] . "-" . $array[0] . "-" . $array[1];
	// } else {
	// 	$tanggal = "0000-00-00";
	// }
	$ket = $_POST["keterangan"];
	//$ruangan = $_POST["idRuangan"];
	//$idAdmin = $_SESSION['user_id'];
	$tgl = date("Y-m-d H:i:s");
	
	

	$id_penawaran =$id_matakuliah . substr($thn_ajar,2,2) . $semester . $kelas;
	//cek keberaddan data id_penawaran
    $select_pen = "SELECT Id_Penawaran FROM penawaran WHERE Id_Penawaran = '$id_penawaran'";
 
    $query_penawaran = mysql_query($select_pen);

    $cek_penawran = mysql_num_rows($query_penawaran);
	
	 if($cek_penawran > 0){
                    $id_penawaran = mysql_result($query_penawaran,0);
                    // echo 0;
                    ?>
						<script type="text/javascript">
							alert("Data Sudah Ada Gagal Disimpan");
							window.location="../index.php?page=jadwal/tampil-jadwal-ruangan.php";

						</script>
                    <?php
                }
                else
                {

                		 $sql="INSERT INTO penawaran VALUES('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','','')";
                        // echo 'penawaran = '.$sql.'<br>';

                        $result = mysql_query($sql);
                       
                        $sql="INSERT INTO pengampu VALUES('','$id_penawaran','$nip_dosen','')";
                        // echo 'pengampu = '.$sql.'<br>';

                        $result = mysql_query($sql);




                        $sql="INSERT INTO jadwal VALUES('','$idRuangan','$id_penawaran','$hari','$jam','$repetisi','$tanggal_now','$thn_ajar','')";
                        // echo 'jadwal = '.$sql.'<br>';

                        $result = mysql_query($sql);
                        if($result){

                        	?>
						<script type="text/javascript">
							alert("Data Berhasil Disimpan");
							window.location="../index.php?page=jadwal/tampil-jadwal-ruangan.php";

						</script>
                    <?php
                        	// // echo 1;
                         //    echo '<div class="alert alert-info">
                         //        <button type="button" class="close" data-dismiss="alert">&times;</button>
                         //        <strong>Pemberitahuan!</strong>  Data Penawaran '.$id_matakuliah.' Berhasil disimpan
                         //        <br> Kembali ke Halaman Penawaran <a href="index.php?page=jadwal/tampil-jadwal-ruangan.php">Kembali</a>

                         //    </div>';
                        }


                }
	

?>