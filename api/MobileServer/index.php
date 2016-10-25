<?PHP
//include dirname(__FILE__)."/koneksi.php";
if (!isset($_GET['cmd'])){
	$cmd = "";
}else{
	$cmd = $_GET['cmd'];	
}

switch ($cmd){
	//FUNCTION USER//
	case "GetArrayJurusan"    		: GetArrayJurusan();     		break;
	case "GetArraySmester"    		: GetArraySmester();     		break;
	case "GetArrayJadwal"    		: GetArrayJadwal();     		break;
	case "GetArrayJadwalKelas"		: GetArrayJadwalKelas();		break;
	case "GetArrayJadwalDosen"		: GetArrayJadwalDosen();		break;
	case "GetArrayRuangan"    		: GetArrayRuangan();     		break;
	case "GetArrayKelas"			: GetArrayKelas();				break;
	case "GetArrayDosen"			: GetArrayDosen();				break;
	case "RuanganKosong"    		: RuanganKosong();     			break;
	case "JamKosong"    			: JamKosong();     				break;
	case "CekRuangan"    			: CekRuangan();     			break;
	case "LogIn"					: LogIn();						break;
	case "UpdatePengumuman"			: UpdatePengumuman();			break;
	case "PindahJadwal"				: PindahJadwal();				break;
	case "UbahPassword"				: UbahPassword();				break;
	case "GetArrayMatkul"			: GetArrayMatkul();				break;
	case "SimpanJadwal"				: SimpanJadwal();				break;
	case "HapusJadwal"				: HapusJadwal();				break;
	
}


function GetArrayJurusan(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$sql="select * from jurusan";
	$hasil=mysql_query($sql);
	
	print('{data_jurusan:[');
	while($baris=mysql_fetch_row($hasil)){	
		$data = array(
									'id_jurusan'     =>$baris[0],
									'jurusan'      	 =>$baris[1]
						);
		echo json_encode($data);
		echo ",";	
	}
	print(']}');
}

function GetArraySmester(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$sql="select * from thn_ajar order by thn_ajar";
	$hasil=mysql_query($sql);
	
	print('{data_smester:[');
	while($baris=mysql_fetch_row($hasil)){	
		$data = array(
									'id_thn_ajar'     =>$baris[0],
									'smester'      	  =>$baris[1] ." ". $baris[2]
						);
		echo json_encode($data);
		echo ",";	
	}
	print(']}');
}


function GetArrayJadwal(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$NamaRuangan 	= $_GET["NamaRuangan"];
	$Tanggal		= $_GET["Tanggal"];
	$IDTahunAjar	= $_GET["IDTahunAjar"];
	$Hari 			= GetNamaHari($Tanggal);
	$IDRuangan		= GetIDRuangan($NamaRuangan);
	
	print('{data_jadwal:[');
	$str = "ABCDEFGHIJKLMNO";
	$strlen = strlen( $str );
	for( $i = 0; $i < $strlen; $i++ ) {
    			$Jam = substr( $str, $i, 1 );
   
				//Cek Berdasarkan Ruangan, Hari dan Jam (Repitisi 2 : Setiap Minggu, Sesuai Hari)
				$sql="select * from jadwal where 	id_ruangan='$IDRuangan' 
													and hari='$Hari' 
													and id_thn_ajar ='$IDTahunAjar'
													and Repetisi = '2'
													and jam LIKE '%$Jam%'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=>$JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
				}else{
					//Cek Berdasarkan Ruangan dan Jam (Repetisi 1 : Setiap Hari, Sesuai Jam)
					$sql="select * from jadwal where 	id_ruangan='$IDRuangan'  
														and id_thn_ajar ='$IDTahunAjar' 
														and Repetisi = '1'
														and jam LIKE '%$Jam%'";
					$hasil=mysql_query($sql);
					$baris=mysql_fetch_row($hasil);
					if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
					}else{
						//Cek Berdasarkan Ruangan dan Jam (Repetisi 0 : Sekali Sesuai Tanggal)
						$sql="select * from jadwal where 	id_ruangan='$IDRuangan'  
															and id_thn_ajar ='$IDTahunAjar' 
															and tanggal='$Tanggal'
															and Repetisi = '0'
															and jam LIKE '%$Jam%'";
						$hasil=mysql_query($sql);
						$baris=mysql_fetch_row($hasil);
						if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
						}else{
							$data = array(
										'Jam'     		=>$Jam,
										'Jadwal'  		=>"" ,
										'Keterangan'  	=>""
							);
							echo json_encode($data);
							echo ",";
						}
						
					}
					
					
				}
	 }
	 print(']}');
}

function GetArrayJadwalKelas(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDKelas	 	= $_GET["IDKelas"];
	$Tanggal		= $_GET["Tanggal"];
	$IDTahunAjar	= $_GET["IDTahunAjar"];
	$Hari 			= GetNamaHari($Tanggal);
	
	print('{data_jadwal:[');
	$str = "ABCDEFGHIJKLMNO";
	$strlen = strlen( $str );
	for( $i = 0; $i < $strlen; $i++ ) {
    			$Jam = substr( $str, $i, 1 );
   
				//Cek Berdasarkan Ruangan, Hari dan Jam (Repitisi 2 : Setiap Minggu, Sesuai Hari)
				$sql="select * from jadwal where 	id_kelas='$IDKelas' 
													and hari='$Hari' 
													and id_thn_ajar ='$IDTahunAjar'
													and Repetisi = '2'
													and jam LIKE '%$Jam%'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaRuangan($baris[1]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=>$JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
				}else{
					//Cek Berdasarkan Ruangan dan Jam (Repetisi 1 : Setiap Hari, Sesuai Jam)
					$sql="select * from jadwal where 	id_kelas='$IDKelas'  
														and id_thn_ajar ='$IDTahunAjar' 
														and Repetisi = '1'
														and jam LIKE '%$Jam%'";
					$hasil=mysql_query($sql);
					$baris=mysql_fetch_row($hasil);
					if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaRuangan($baris[1]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
					}else{
						//Cek Berdasarkan Ruangan dan Jam (Repetisi 0 : Sekali Sesuai Tanggal)
						$sql="select * from jadwal where 	id_kelas='$IDKelas'  
															and id_thn_ajar ='$IDTahunAjar' 
															and tanggal='$Tanggal'
															and Repetisi = '0'
															and jam LIKE '%$Jam%'";
						$hasil=mysql_query($sql);
						$baris=mysql_fetch_row($hasil);
						if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaRuangan($baris[1]);
							}
							if(GetNamaDosen($baris[4])!=""){
								$JadwalTemp = $JadwalTemp . "/" . GetNamaDosen($baris[4]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10]
							);
							echo json_encode($data);
							echo ",";	
						}else{
							$data = array(
										'Jam'     		=>$Jam,
										'Jadwal'  		=>"" ,
										'Keterangan'  	=>""
							);
							echo json_encode($data);
							echo ",";
						}
						
					}
					
					
				}
	 }
	 print(']}');
}

function GetArrayJadwalDosen(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDDosen	 	= $_GET["IDDosen"];
	$Tanggal		= $_GET["Tanggal"];
	$IDTahunAjar	= $_GET["IDTahunAjar"];
	$Hari 			= GetNamaHari($Tanggal);
	
	print('{data_jadwal:[');
	$str = "ABCDEFGHIJKLMNO";
	$strlen = strlen( $str );
	for( $i = 0; $i < $strlen; $i++ ) {
    			$Jam = substr( $str, $i, 1 );
   
				//Cek Berdasarkan Ruangan, Hari dan Jam (Repitisi 2 : Setiap Minggu, Sesuai Hari)
				$sql="select * from jadwal where 	id_dosen='$IDDosen' 
													and hari='$Hari' 
													and id_thn_ajar ='$IDTahunAjar'
													and Repetisi = '2'
													and jam LIKE '%$Jam%'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]) . "/" . GetNamaRuangan($baris[1]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=>$JadwalTemp,
									'Keterangan'  	=>$baris[10],
									'IdJadwal'		=>$baris[0],
									'Repetisi'		=>$baris[7]
							);
							echo json_encode($data);
							echo ",";	
				}else{
					//Cek Berdasarkan Ruangan dan Jam (Repetisi 1 : Setiap Hari, Sesuai Jam)
					$sql="select * from jadwal where 	id_dosen='$IDDosen'  
														and id_thn_ajar ='$IDTahunAjar' 
														and Repetisi = '1'
														and jam LIKE '%$Jam%'";
					$hasil=mysql_query($sql);
					$baris=mysql_fetch_row($hasil);
					if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]) . "/" . GetNamaRuangan($baris[1]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10],
									'IdJadwal'		=>$baris[0],
									'Repetisi'		=>$baris[7]
							);
							echo json_encode($data);
							echo ",";	
					}else{
						//Cek Berdasarkan Ruangan dan Jam (Repetisi 0 : Sekali Sesuai Tanggal)
						$sql="select * from jadwal where 	id_dosen='$IDDosen'  
															and id_thn_ajar ='$IDTahunAjar' 
															and tanggal='$Tanggal'
															and Repetisi = '0'
															and jam LIKE '%$Jam%'";
						$hasil=mysql_query($sql);
						$baris=mysql_fetch_row($hasil);
						if($baris > 0){	
							$JadwalTemp = GetNamaAktivitas($baris[2]);
							if(GetNamaKelas($baris[3]) != ""){
								$JadwalTemp = $JadwalTemp . " / " . GetNamaKelas($baris[3]) . "/" . GetNamaRuangan($baris[1]);
							}
							$data = array(
									'Jam'     		=>$Jam,
									'Jadwal'  		=> $JadwalTemp,
									'Keterangan'  	=>$baris[10],
									'IdJadwal'		=>$baris[0],
									'Repetisi'		=>$baris[7]
							);
							echo json_encode($data);
							echo ",";	
						}else{
							$data = array(
										'Jam'     		=>$Jam,
										'Jadwal'  		=>"" ,
										'Keterangan'  	=>"",
										'IdJadwal'		=>"",
										'Repetisi'		=>""
							);
							echo json_encode($data);
							echo ",";
						}
						
					}
					
					
				}
	 }
	 print(']}');
}


function GetArrayRuangan(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan 	= $_GET["IDJurusan"];
	
	$sql="select * from ruang_jurusan where id_jurusan='$IDJurusan'";
	$hasil=mysql_query($sql);
	print('{data_ruangan:[');
	while($baris=mysql_fetch_row($hasil)){	
		$data = array(
					'id_ruangan'  => $baris[2],
					'ruangan' => GetNamaRuangan( $baris[2])
					);
		echo json_encode($data);
		echo ",";	
	}
	print(']}');
}

function GetArrayKelas(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan 	 = $_GET["IDJurusan"];
	$IDTahunAjar = $_GET["IDTahunAjar"];
	
	$sql="SELECT * FROM `kelas` where 
			id_jurusan = '$IDJurusan' and 
			if( (select smt from thn_ajar where id_thn_ajar = '$IDTahunAjar') = 'Ganjil',
				cast(left(kelas, length(kelas)-1) as decimal)%2 != 0,
				cast(left(kelas, length(kelas)-1) as decimal)%2 = 0)
			order by kelas";
				
	$hasil=mysql_query($sql);
	print('{data_kelas:[');
	while($baris=mysql_fetch_row($hasil)){
		$data = array(
									'id_kelas'     =>$baris[0],
									'kelas'        =>$baris[1]
						);
		echo json_encode($data);
		echo ",";
	}
	print(']}');
}

function GetArrayDosen(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan = $_GET["IDJurusan"];
	
	$sql="select * from dosen where id_jurusan='$IDJurusan'";
	$hasil=mysql_query($sql);
	print('{data_dosen:[');
	while($baris=mysql_fetch_row($hasil)){
		$data = array(
									'id_dosen'     =>$baris[0],
									'NamaDosen'    =>$baris[1]
						);
		echo json_encode($data);
		echo ",";
	}
	print(']}');
}

function GetArrayMatkul(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan = $_GET["IDJurusan"];
	$IDTahunAjar = $_GET["IDTahunAjar"];
	$query = "select smt from thn_ajar where id_thn_ajar = '$IDTahunAjar'";
	$hasil = mysql_fetch_row(mysql_query($query));
	$Smt = $hasil[0];
	$sql = "Select id_matkul, matkul from matkul where id_jurusan = '$IDJurusan' and penawaran = '$Smt' order by id_matkul";
	$hasil = mysql_query($sql);
	print('{data_matkul:[');
	while($baris=mysql_fetch_row($hasil)){
		$data = array(
						'id_matkul' => $baris[0],
						'matkul'    => $baris[1]
				);
		echo json_encode($data);
		echo ",";
	}
	print(']}');
}

function RuanganKosong(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan 		= $_GET["IDJurusan"];
	$Hari			= $_GET["Hari"];
	$ListJam		= $_GET["ListJam"];
	$IDTahunAjar	= $_GET["IDTahunAjar"];
	$Tag			= $_GET["Tag"];
	
	if ($Tag == "CariRuangan") {
		print("<body style='font-size:20px;'><b><p align='center'>Hasil Pencarian</p></b>");
	} else {
		print('{data_ruangan:[');
	}
	
	//Mencari List Ruangan yaang dimiliki Jurusan
	$sqlJurusan="select * from ruang_jurusan where id_jurusan='$IDJurusan'";
	$hasilJurusan=mysql_query($sqlJurusan);
	while($barisJurusan=mysql_fetch_row($hasilJurusan)){	
		  	$IDRuangan = $barisJurusan[2];
			$Terpakai = 0; //inisialisasi tidak terpakai
			
			//Cek penggunaan ruang tsb pada tiap jam sesuai hari
			$strlen = strlen( $ListJam );
			for( $i = 0; $i < $strlen; $i++ ) {
						$Jam = substr( $ListJam, $i, 1 );
			
						//Cek Berdasarkan Ruangan, Hari dan Jam (Repitisi 2 : Setiap Minggu, Sesuai Hari)
						$sql="select * from jadwal where 	id_ruangan='$IDRuangan'
															and hari='$Hari' 
															and id_thn_ajar ='$IDTahunAjar'
															and Repetisi = '2'
															and jam LIKE '%$Jam%'";
						$hasil=mysql_query($sql);
						$baris=mysql_fetch_row($hasil);
						if($baris > 0){
									$Terpakai = 1;
									$i = $strlen; //hentikan analisa ruangan tsb.
										
						}else{
							//Cek Berdasarkan Ruangan dan Jam (Repetisi 1 : Setiap Hari, Sesuai Jam)
							$sql="select * from jadwal where 	id_ruangan='$IDRuangan'  
																and id_thn_ajar ='$IDTahunAjar' 
																and Repetisi = '1'
																and jam LIKE '%$Jam%'";
							$hasil=mysql_query($sql);
							$baris=mysql_fetch_row($hasil);
							if($baris > 0){	
									$Terpakai = 1;
									$i = $strlen; //hentikan analisa ruangan tsb.	
							}
						}
	
		
			}
			
			//Jika setelah dianalisa, ruangan tetap tidak terpakai maka tampilkan
			if($Terpakai == 0){
				if ($Tag == "PindahJadwal") {
					$data = array(
								"idRuangan"		=> $IDRuangan,
								"namaRuangan" 	=> GetNamaRuangan($IDRuangan)
					);
					echo json_encode($data);
					echo ",";
				} else {
					print(GetNamaRuangan($IDRuangan) . "<br>");
				}
			}
	}
	if ($Tag == "PindahJadwal") {
		echo ']}';
	}
}

function JamKosong(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$NamaRuangan 	= $_GET["NamaRuangan"];
	$IDTahunAjar	= $_GET["IDTahunAjar"];
	$IDKelas		= $_GET["IDKelas"];
	$IDRuangan		= GetIDRuangan($NamaRuangan);
	$ListHari=array("Senin","Selasa","Rabu","Kamis","Jumat");
	$ListJam="ABCDEFGHIJKL";
	
	print("<body style='font-size:20px;'><b><p align='center'>Hasil Pencarian</p></b>");
	
	//Cek penggunaan sesuai hari
	for( $i = 0; $i < 5; $i++ ) {
	$Hari = $ListHari[$i];
	print($Hari . " = ");
	
			//Cek penggunaan ruang tsb pada tiap jam sesuai hari
			$strlen = strlen( $ListJam );
			for( $j = 0; $j < $strlen; $j++ ) {
						$Jam = substr( $ListJam, $j, 1 );
			
						//Cek Berdasarkan Ruangan, Hari dan Jam (Repitisi 2 : Setiap Minggu, Sesuai Hari)
						$sql="select * from jadwal where 	(id_ruangan='$IDRuangan'
															and hari='$Hari' 
															and id_thn_ajar ='$IDTahunAjar'
															and Repetisi = '2'
															and jam LIKE '%$Jam%') or 
															(id_kelas='$IDKelas'
															and hari='$Hari' 
															and id_thn_ajar ='$IDTahunAjar'
															and Repetisi = '2'
															and jam LIKE '%$Jam%')"; 
															
						$hasil=mysql_query($sql);
						$baris=mysql_fetch_row($hasil);
						if($baris > 0){
									//Tidak Lakukan Apa-Apa.			
						}else{
							//Cek Berdasarkan Ruangan dan Jam (Repetisi 1 : Setiap Hari, Sesuai Jam)
							$sql="select * from jadwal where 	(id_ruangan='$IDRuangan'  
																and id_thn_ajar ='$IDTahunAjar' 
																and Repetisi = '1'
																and jam LIKE '%$Jam%') or 
																(id_kelas='$IDKelas'  
																and id_thn_ajar ='$IDTahunAjar' 
																and Repetisi = '1'
																and jam LIKE '%$Jam%')";
							$hasil=mysql_query($sql);
							$baris=mysql_fetch_row($hasil);
							if($baris > 0){	
								//Tidak Lakukan Apa-Apa.	
							}else{
								//Ruangan  tidak terpakai
								print($Jam . ",");	
							}
						}
			}
			

	print("<br>");
	}
}

function CekRuangan(){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$NamaRuangan 	= $_GET['NamaRuangan'];
	
	$sql="select * from ruangan where ruangan='$NamaRuangan'";
	$hasil=mysql_query($sql);
	$baris=mysql_fetch_row($hasil);
	if($baris > 0){		
			$data = array('hasil'  =>"1");
			echo json_encode($data);					
	}else{						
			$data = array('hasil'  =>"0");
			echo json_encode($data);						
	}
	
}

function LogIn() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$user = $_GET['username'];
	$pass = $_GET['pass'];
	$query = "select * from dosen where username = '$user' and pass = '$pass'";
	$hasil = mysql_query($query);
	$baris = mysql_fetch_row($hasil);
	if ($baris == 0) {
		$data = array(
				'status' => "gagal",
				'pesan'  => "Maaf, Username/Password Anda Salah."
		);
		echo json_encode($data);
	} else {
		$data = array(
				'status'  => "sukses",
				'idDosen' => $baris[0],
				'userName'=> $baris[7] 
		);
		echo json_encode($data);
	}
}

function UpdatePengumuman() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$id = $_GET['id'];
	$ket = $_GET['ket'];
	$query = "update jadwal set keterangan = '$ket' where id_jadwal = '$id'";
	$hasil = mysql_query($query);
	if (!$hasil) {
		$data = array(
				'status' => 'gagal',
				'pesan'	 => 'Pengumuman gagal di pos.'
				);
				echo json_encode($data);
	} else {
		$data = array(
				'status' => 'sukses',
				'pesan'	 => 'Pengumuman berhasil di pos.'	
		);
		echo json_encode($data);
	}
}

function PindahJadwal() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJadwal = $_GET['IDJadwal'];
	$Repetisi = $_GET['Repetisi'];
	$Hari	  = $_GET['Hari'];
	$Tanggal  = $_GET['Tanggal'];
	$JamTmp	  = $_GET['Jam'];
	$Ruangan  = $_GET['Ruangan'];
	
	$jam = str_split($JamTmp);
	$jam = implode(',',$jam);
	$IDRuangan = GetIDRuangan($Ruangan);
	
	if ($Repetisi == "0") {
		$query = "select * from jadwal where id_jadwal = '$IDJadwal'";
		$hasil = mysql_query($query);
		$data  = mysql_fetch_row($hasil);
		if ($data > 0) {
			if ($data[7] == "0") {
				$query = "update jadwal set id_ruangan = '$IDRuangan', hari = '$Hari', jam = '$jam' where id_jadwal = '$IDJadwal'";
			} else {
				$query = "insert into jadwal(id_ruangan, id_aktivitas, id_kelas, id_dosen, hari, jam, Repetisi, tanggal, id_thn_ajar, keterangan)
					  values('$IDRuangan', '$data[2]', '$data[3]', '$data[4]', '$Hari', '$jam', '$Repetisi', '$Tanggal', '$data[9]', '')";
			}
			
			$hasil = mysql_query($query);
			
			if (!$hasil){
				$data = array (
					'status' => 'gagal',
					'pesan'  => 'Jadwal gagal disimpan.'
				);
				echo json_encode($data);
			} else {
				$data = array(
					'status' => 'sukses',
					'pesan'  => 'Jadwal berhasil disimpan.'
				);
				echo json_encode($data);
			}
		}
	} else {
		$query = "update jadwal set id_ruangan = '$IDRuangan', hari = '$Hari', jam = '$jam' where id_jadwal = '$IDJadwal'";
		$hasil = mysql_query($query);
		if (!$hasil){
				$data = array (
					'status' => 'gagal',
					'pesan'  => 'Jadwal gagal dipindahkan.'
				);
				echo json_encode($data);
			} else {
				$data = array(
					'status' => 'sukses',
					'pesan'  => 'Jadwal berhasil dipindahkan.'
				);
				echo json_encode($data);
			}
	}
}

function UbahPassword() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDDosen	= $_GET['IDDosen'];
	$username	= $_GET['UserName'];
	$PassLama	= $_GET['PassLama'];
	$PassBaru	= $_GET['PassBaru'];
	
	$query 	= "select * from dosen where id_dosen = '$IDDosen' && pass = '$PassLama'";
	$cek	= mysql_query($query);
	if ($cek) {
		$query = "update dosen set pass = '$PassBaru', username = '$username' where id_dosen = '$IDDosen'";
		$hasil = mysql_query($query);
		if ($hasil) {
			$data = array(
				'status' => 'sukses',
				'pesan'  => 'Password berhasil diubah.'
			);
			echo json_encode($data);
		}
	} else {
		$data = array(
			'status' => 'gagal',
			'pesan'  => 'Password Lama Tidak Sesuai.'
		);
		echo json_encode($data);	
	}
}

function SimpanJadwal() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$IDJurusan 	 = $_GET['IDJurusan'];
	$IDTahunAjar = $_GET['IDTahunAjar'];
	$Aktivitas   = $_GET['Aktivitas'];
	$IDKelas     = $_GET['IDKelas'];
	$IDRuangan   = $_GET['IDRuangan'];
	$jam_tmp	 = str_split($_GET['Jam']);
	$Jam		 = implode(',',$jam_tmp);
	$Repetisi	 = $_GET['Repetisi'];
	$Hari		 = $_GET['Hari'];
	$Tanggal	 = $_GET['Tanggal'];
	$IDDosen	 = $_GET['IDDosen'];
	$tgl = date("Y-m-d H:i:s");
	
	$cek = mysql_num_rows(mysql_query("SELECT * FROM aktivitas WHERE nama_aktivitas='$Aktivitas' && id_jurusan='$IDJurusan'"));
	if($cek==0){
		mysql_query("INSERT INTO aktivitas(nama_aktivitas, id_jenis_aktivitas, id_jurusan) VALUES('$Aktivitas', '1', '$IDJurusan')");
	}
	
	$query = mysql_query("SELECT id_aktivitas FROM aktivitas WHERE nama_aktivitas='$Aktivitas' && id_jurusan='$IDJurusan'");
	$idAktivitas = mysql_result($query,0);
	
	$query = mysql_query("INSERT INTO jadwal(id_ruangan, id_aktivitas, id_kelas, id_dosen, hari, jam, repetisi, tanggal, id_thn_ajar, keterangan) 
						 VALUES('$IDRuangan', '$idAktivitas', '$IDKelas', '$IDDosen', '$Hari', '$Jam', '$Repetisi', '$Tanggal', '$IDTahunAjar', '')");
						 
	if($query){
		$getID = mysql_query("SELECT id_jadwal FROM jadwal WHERE id_aktivitas='$idAktivitas' && id_kelas='$IDKelas' && id_thn_ajar='$IDTahunAjar'");
		$id_jadwal = mysql_result($getID, 0);
		
		$query_history = mysql_query("INSERT INTO history(id_jadwal, kegiatan, tanggal, id_ruangan, id_aktivitas, id_kelas, id_dosen, hari_jadwal, jam_jadwal, tgl_jadwal) VALUES('$id_jadwal', 'Tambah Jadwal', '$tgl', '$IDRuangan', '$idAktivitas', '$IDKelas', '$IDDosen', '$Hari', '$Jam', '$Tanggal') ");
		
		$data = array(
				'status' => 'sukses',
				'pesan'  => 'Jadwal Berhasil Disimpan.'
			);
			echo json_encode($data);
	} else {
		$data = array(
				'status' => 'gagal',
				'pesan'  => 'Jadwal Gagal Disimpan.'
			);
			echo json_encode($data);	
	}
}

function HapusJadwal() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$idJadwal = $_GET['IDJadwal'];
	$sql = "delete from jadwal where id_jadwal='$idJadwal'";
	$hasil = mysql_query($sql);
	if ($hasil) {
		$data = array(
				'status' => 'sukses',
				'pesan'  => 'Jadwal Berhasil Dihapus.'
			);
			echo json_encode($data);
	} else {
		$data = array(
				'status' => 'gagal',
				'pesan'  => 'Jadwal Gagal Dihapus.'
			);
			echo json_encode($data);
	}
}
/////////////////////////////////////////////////FUNGSI PEMBANTU////////////////////////////////////

function GetNamaHari($tanggal){
				$result="";
				$timestamp = strtotime($tanggal);
				$day = date( "w", $timestamp);
				switch($day){
									case"0"; $result="Minggu"; break;
									case"1"; $result="Senin"; break;
									case"2"; $result="Selasa"; break;
									case"3"; $result="Rabu"; break;
									case"4"; $result="Kamis"; break;
									case"5"; $result="Jumat"; break;
									case"6"; $result="Sabtu"; break;
							}
				return $result;
}

function GetIDRuangan ($NamaRuangan){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$result="";
	
				$sql="select * from ruangan where ruangan='$NamaRuangan'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){	
					$result = $baris[0];
				}
	return $result;
}

function GetNamaRuangan ($IDRuangan){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$result="";
	
				$sql="select * from ruangan where id_ruangan='$IDRuangan'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){	
					$result = $baris[1];
				}
	return $result;
}

function GetNamaKelas ($IDKelas){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$result="";
	
				$sql="select * from kelas where id_kelas='$IDKelas'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){	
					$result = $baris[1];
				}
	return $result;
}

function GetNamaAktivitas ($IDAktivitas){
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$result="";
	
				$sql="select * from aktivitas where id_aktivitas='$IDAktivitas'";
				$hasil=mysql_query($sql);
				$baris=mysql_fetch_row($hasil);
				if($baris > 0){	
					$result = $baris[1];
				}
	return $result;
}

function GetNamaDosen ($IDDosen) {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$result="";
		$sql = "select * from dosen where id_dosen='$IDDosen'";
		$hasil = mysql_query($sql);
		$baris = mysql_fetch_row($hasil);
		if($baris>0){
			$result = $baris[1];
		}
	return $result;
}

?>