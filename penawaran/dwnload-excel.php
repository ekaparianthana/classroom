<?php
	
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	$jurusan = $_GET['jurusan'];
	$tahun	 = $_GET['tahun'];
	$semester= $_GET['semester'];
	// $sql = "SELECT * FROM (SELECT matkul, MID(Id_Penawaran,8,7) AS kdmk, sks, JS, Id_Kelas, semester_posisi, LEFT(Id_Penawaran,5) AS jurusan FROM penawaran INNER JOIN matkul ON (penawaran.Id_MataKuliah = matkul.id_matkul) WHERE tahun = '$tahun' AND penawaran.semester = '$semester') AS tabel WHERE jurusan = '$jurusan' order by semester_posisi, Id_Kelas";
	$sql = '
	SELECT matkul, matkul.id_matkul, matkul.sks, matkul.js, penawaran.Id_Kelas, penawaran.semester, dosen.nama, dosen.nip
FROM penawaran
INNER JOIN matkul ON penawaran.Id_MataKuliah = matkul.id_matkul
INNER JOIN pengampu
USING ( Id_Penawaran )
INNER JOIN dosen ON pengampu.NIP_Dosen = dosen.nip
WHERE dosen.id_jurusan = "'.$jurusan.'"
	';
	// echo $sql;
	// exit();
	$query = mysql_query($sql);
	
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename=SuratKeputusanMengajarJurusan$jurusan.xls" );
	echo 'No.' . "\t" . 'Mata Kuliah' . "\t" . 'Kode MK' . "\t" . 'SKS' . "\t" . 'JS' . "\t" . 'KLS' . "\t" . 'SMT' . "\t" . 'Nama Dosen'. "\t" .'NIP' . "\n";
	$no = 0;
	while ($data = mysql_fetch_array($query)) {
		$no++;
		$smt = getSMT($data[5]);
		echo $no . "\t" . $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $data[4] . "\t" . $smt . "\t" . $data[6] . "\t" . $data[7] . "\n"; 
	}


function getSMT($smt) {
	$semester = array("I", "II" , "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII", "XIII", "XIV");
	$smt = (int)$smt;
	$result = 'I';
	for ($i = 1; $i <= count($semester); $i++) {
		if ($smt == $i) {
			$result = $semester[$i-1];
		}
	} 
	return $result;
}

?>