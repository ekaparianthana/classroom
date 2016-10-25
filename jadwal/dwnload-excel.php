<?php
	
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	session_start();
	$idThnAjaran = $_GET['smt'];
	if (isset($_SESSION['userlogin'])) {
		$id_jurusan	= $_SESSION['jurusan'];
	} elseif (isset($_SESSION['dosen_login'])) {
		$id_jurusan = $_SESSION['jurusan_dosen'];
	} else {
		$id_jurusan = $_GET['jurusan'];
	}
	
	
if (($_GET['data']) == 'jadwal') {
	$qThnAjar = mysql_query("select * from thn_ajar where id_thn_ajar = '$idThnAjaran'");
	//$idKelas	 = $_GET['kelas'];
	$qJurusan 	 = mysql_query("select jurusan from jurusan where id_jurusan = '$id_jurusan'");
	
	$query = mysql_query("select matkul, id_matkul, sks, hari, jam, kelas, ruangan, nama, id_dosen from (select substr(nama_aktivitas,1,7) as kode, hari, jam, id_kelas, id_ruangan, id_dosen from jadwal inner join aktivitas using(id_aktivitas) where id_thn_ajar='$idThnAjaran' && id_jurusan='$id_jurusan') as tbl inner join matkul on kode = id_matkul inner join kelas using(id_kelas) inner join ruangan using(id_ruangan) inner join dosen using(id_dosen) order by kelas, hari, jam");
	
	$semester = mysql_result($qThnAjar,0,'smt');
	$thnAjar  = mysql_result($qThnAjar,0,'thn_ajar');
	$jurusan  = mysql_result($qJurusan,0);
	$no = 1;

	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename='Jadwal $jurusan $semester $thnAjar.xls'" );
		
	echo "\n";
	echo "\t" . 'SEMESTER' . ' ' . $semester . ' ' . 'TAHUN' . ' ' . $thnAjar . "\n";
	echo "\n";
	echo "\t" . 'Jurusan ' .  $jurusan . "\n";
	echo "\n";
	echo 'No' . "\t" . 'Mata Kuliah' . "\t". 'Kode' . "\t" . 'SKS' . "\t" . 'Hari' . "\t" . 'Jam' . "\t" . 'Kelas' . "\t" . 'Ruang' . "\t" . 'Nama Dosen' . "\t" . 'NIP' . "\n";
	while ($data = mysql_fetch_array($query)) {
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $data[4] . "\t" . $data[5] . "\t" . $data[6] . "\t" . $data[7] . "\t" . $data[8] . "\n";
		
		$no++; 	
	}
} else {
	$query = mysql_query("select matkul, id_matkul, sks, js, kelas, nama, id_dosen from (select substr(nama_aktivitas,1,7) as kode, hari, jam, id_ruangan, id_dosen, id_kelas from jadwal inner join aktivitas using(id_aktivitas) where  id_thn_ajar='$idThnAjaran' && repetisi='2') as tbl inner join matkul on kode = id_matkul inner join ruangan using(id_ruangan) inner join dosen using(id_dosen) inner join kelas using(id_kelas) order by kelas");
	
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename='Laporan Jadwal.xls'" );
	echo 'No.' . "\t" . 'Mata Kuliah' . "\t" . 'Kode MK' . "\t" . 'SKS' . "\t" . 'JS' . "\t" . 'KLS' . "\t" . 'SMT' . "\t" . 'Nama Dosen'. "\t" .'NIP' . "\n";
	$no = 0;
	while ($data = mysql_fetch_array($query)) {
		$no++;
		$kls = substr($data[4],strlen($data[4])-1,1);
		$smt = getSMT(substr($data[4],0,strlen($data[4])-1));
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $kls . "\t" . $smt . "\t" . $data[5] . "\t" . $data[6] . "\n"; 
	}
}

function getSMT($smt) {
	$semester = array("I", "II" , "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII", "XIII", "XIV");
	$smt = (int)$smt;
	for ($i = 1; $i <= count($semester); $i++) {
		if ($smt == $i) {
			$result = $semester[$i-1];
		}
	} 
	return $result;
}
?>