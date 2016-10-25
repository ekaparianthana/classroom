<?php
	
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	
	$idThnAjaran = $_GET['smt'];
	
if (isset($_GET['kelas'])) {
	$qThnAjar = mysql_query("select * from thn_ajar where id_thn_ajar = '$idThnAjaran'");
	$idKelas	 = $_GET['kelas'];
	$qKelas 	 = mysql_query("select kelas from kelas where id_kelas = '$idKelas'");
	
	$query = mysql_query("select matkul, id_matkul, sks, hari, jam, ruangan, nama, id_dosen from (select substr(nama_aktivitas,1,7) as kode, hari, jam, id_ruangan, id_dosen from jadwal inner join aktivitas using(id_aktivitas) where id_kelas=$idKelas and id_thn_ajar=$idThnAjaran) as tbl inner join matkul on kode = id_matkul inner join ruangan using(id_ruangan) inner join dosen using(id_dosen)");
	
	$semester = mysql_result($qThnAjar,0,'smt');
	$thnAjar  = mysql_result($qThnAjar,0,'thn_ajar');
	$kelas	  = mysql_result($qKelas,0);
	$no = 1;

	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename='Jadwal $kelas $semester $thnAjar.xls'" );
		
	echo "\n";
	echo "\t" . 'SEMESTER' . ' ' . $semester . ' ' . 'TAHUN' . ' ' . $thnAjar . "\n";
	echo "\n";
	echo "\t" . 'KELAS ' .  $kelas . "\n";
	echo "\n";
	echo 'No' . "\t" . 'Mata Kuliah' . "\t". 'Kode' . "\t" . 'SKS' . "\t" . 'Hari' . "\t" . 'Jam' . "\t" . 'Ruang' . "\t" . 'Nama Dosen' . "\t" . 'NIP' . "\n";
	while ($data = mysql_fetch_array($query)) {
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $data[4] . "\t" . $data[5] . "\t" . $data[6] . "\t" . $data[7] . "\n";
		
		$no++; 	
	}
} elseif (isset($_GET['ruangan'])){
	$qThnAjar = mysql_query("select * from thn_ajar where id_thn_ajar = '$idThnAjaran'");
	$idRuangan	 = $_GET['ruangan'];
	$qRuangan	 = mysql_query("select ruangan from ruangan where id_ruangan = '$idRuangan'");
	
	$query = mysql_query("select matkul, id_matkul, sks, hari, jam, kelas, nama, id_dosen from (select substr(nama_aktivitas,1,7) as kode, hari, jam, id_kelas, id_dosen from jadwal inner join aktivitas using(id_aktivitas) where id_ruangan=$idRuangan and id_thn_ajar=$idThnAjaran) as tbl inner join matkul on kode = id_matkul inner join kelas using(id_kelas) inner join dosen using(id_dosen) order by hari, jam");
	
	$semester = mysql_result($qThnAjar,0,'smt');
	$thnAjar  = mysql_result($qThnAjar,0,'thn_ajar');
	$ruangan  = mysql_result($qRuangan,0);
	$no = 1;

	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename='Jadwal di $ruangan $semester $thnAjar.xls'" );
		
	echo "\n";
	echo "\t" . 'SEMESTER' . ' ' . $semester . ' ' . 'TAHUN' . ' ' . $thnAjar . "\n";
	echo "\n";
	echo "\t" . 'Ruangan ' .  $ruangan . "\n";
	echo "\n";
	echo 'No' . "\t" . 'Mata Kuliah' . "\t". 'Kode' . "\t" . 'SKS' . "\t" . 'Hari' . "\t" . 'Jam' . "\t" . 'Kelas' . "\t" . 'Nama Dosen' . "\t" . 'NIP' . "\n";
	
	while ($data = mysql_fetch_array($query)) {
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $data[4] . "\t" . $data[5] . "\t" . $data[6] . "\t" . $data[7] . "\n";

		$no++; 	
	}
} elseif (isset($_GET['dosen'])){
	$qThnAjar = mysql_query("select * from thn_ajar where id_thn_ajar = '$idThnAjaran'");
	$idDosen	 = $_GET['dosen'];
	$qDosen	 = mysql_query("select nama from dosen where id_dosen = '$idDosen'");
	
	$query = mysql_query("select matkul, id_matkul, sks, hari, jam, kelas, ruangan from (select substr(nama_aktivitas,1,7) as kode, hari, jam, id_kelas, id_ruangan from jadwal inner join aktivitas using(id_aktivitas) where id_dosen='$idDosen' and id_thn_ajar='$idThnAjaran') as tbl inner join matkul on kode = id_matkul inner join kelas using(id_kelas) inner join ruangan using(id_ruangan) order by hari, jam");
	
	$semester = mysql_result($qThnAjar,0,'smt');
	$thnAjar  = mysql_result($qThnAjar,0,'thn_ajar');
	$dosen  = mysql_result($qDosen,0);
	$no = 1;

	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename='Jadwal $dosen $semester $thnAjar.xls'" );
		
	echo "\n";
	echo "\t" . 'SEMESTER' . ' ' . $semester . ' ' . 'TAHUN' . ' ' . $thnAjar . "\n";
	echo "\n";
	echo "\t" . 'Ruangan ' .  $dosen . "\n";
	echo "\n";
	echo 'No' . "\t" . 'Mata Kuliah' . "\t". 'Kode' . "\t" . 'SKS' . "\t" . 'Hari' . "\t" . 'Jam' . "\t" . 'Kelas' . "\t" . 'Ruangan' . "\n";
	
	while ($data = mysql_fetch_array($query)) {
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $data[4] . "\t" . $data[5] . "\t" . $data[6] . "\n";

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