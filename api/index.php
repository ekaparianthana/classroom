

<?php

require dirname(__FILE__).'/Slim/Slim.php';

$app = new Slim();

// =========== resources url =========== //
$app->get('/jadwal/ruangan/:id_ruangan/:semester/:tahun', 'getJadwalRuangan');
$app->get('/jadwal/kelas/:id_kelas/:semester/:tahun/:id_jurusan', 'getJadwalKelas');
$app->get('/jadwal/dosen/:id_dosen/:id_thn_ajar', 'getJadwalDosen');
$app->get('/jadwal/:id_jadwal', 'getJadwalById');
$app->put('/jadwal/keterangan/:id_jadwal','updateKeterangan');
$app->put('/jadwal/:id_jadwal','updateJadwal');
$app->delete('/jadwal/:id_jadwal','deleteJadwal');

$app->get('/jurusan', 'getJurusan');
$app->get('/thn_ajar', 'getTahunAjar');
$app->get('/ruangan/jurusan/:id_jurusan','getRuangan');
$app->get('/ruangan/fakultas/:id_jurusan','getRuanganFakultas');
$app->post('/ruangan/:id_jurusan/:id_ruangan', 'addRuangJurusan');
$app->delete('/ruangan/:id_jurusan/:id_ruangan', 'deleteRuangJurusan');
$app->get('/matkul/:id_jurusan/:penawaran', 'getMatkul');
$app->get('/kelas/:id_jurusan/:tahun/:semester','getKelas');
$app->get('/dosen/:id_jurusan','getDosen');

// ===== resource validation ======== //
$app->get('/jadwal/cek/:id_ruangan/:id_kelas/:hari/:thnAjar', 'cekJadwal');
$app->get('/jadwal/cek_kelas/:hari/:jam/:thnAjar', 'cekJadwalKelas');

// ======= resource edit kelas ========= //
$app->get('/cek/:kelas/:id_jurusan','cekKelas');
$app->post('/kelas/simpan/:kelas/:id_jurusan' , 'simpanKelas');
$app->delete('/kelas/hapus/:id_kelas', 'deleteKelas');

//========== History =========== //
$app->post('/history', 'updateHistory');

$app->run();

// ========= manajemen data jadwal ========= //

// mendapatkan data jadwal pada ruangan '$id_ruangan' dan tahun ajar '$id_thn_ajar' untuk mengakses request ke 
// http://localhost/classroom_schedules/api/$id_ruangan/$id_thn_ajar

function getJadwalRuangan($id_ruangan, $semester, $tahun) {
	$sql = "SELECT id_jadwal, jam, tanggal, jadwal.hari, ruangan, matkul, concat(matkul.semester_posisi, penawaran.Id_Kelas) as kelas, repetisi, keterangan, Id_Penawaran 
	FROM `jadwal` 
	INNER JOIN penawaran USING(Id_Penawaran) 
	INNER JOIN ruangan USING (id_ruangan) 
	INNER JOIN matkul ON (matkul.id_matkul = penawaran.Id_MataKuliah) 
	where ruangan = :id_ruangan and penawaran.Tahun = :tahun 
	and penawaran.semester % 2 = :semester";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_ruangan", $id_ruangan);
		$stmt->bindParam("tahun", $tahun);
		$stmt->bindParam("semester", $semester);
		$stmt->execute();
		$schedule = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"jadwal": ' . json_encode($schedule) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage().'}}';
	}
}

// mendapatkan data jadwal pada kelas '$id_kelas' dan tahun ajar '$id_thn_ajar' untuk mengakses request ke 
// http://localhost/classroom_schedules/api/$id_kelas/$id_thn_ajar

function getJadwalKelas($id_kelas, $semester, $tahun, $id_jurusan) {
	//$id = getIdKelas($id_kelas,$id_jurusan);
	$sql = "SELECT id_jadwal, jam, tanggal, jadwal.hari, ruangan, matkul, CONCAT(matkul.semester_posisi,penawaran.Id_Kelas) AS kelas, repetisi, keterangan, id_ruangan, Id_Penawaran FROM jadwal INNER JOIN penawaran USING (Id_Penawaran) INNER JOIN matkul ON (matkul.id_matkul = penawaran.Id_MataKuliah) INNER JOIN ruangan USING (id_ruangan) WHERE penawaran.Semester % 2 = :semester && penawaran.tahun = :tahun && CONCAT(matkul.semester_posisi,penawaran.Id_Kelas) = :id_kelas && Left(Id_Penawaran,5) = :id_jurusan";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_kelas", $id_kelas);
		$stmt->bindParam("semester", $semester);
		$stmt->bindParam("tahun", $tahun);
		$stmt->bindParam("id_jurusan", $id_jurusan);
		$stmt->execute();
		$schedule = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"jadwal": ' . json_encode($schedule) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage().'}}';
	}
}

function getJadwalDosen($id_dosen, $id_thn_ajar) {
	$sql = "SELECT id_jadwal, jam, tanggal, hari, ruangan, nama_aktivitas, kelas, repetisi, keterangan, nama, id_ruangan, id_kelas, id_aktivitas FROM `jadwal` 
	INNER JOIN ruangan USING(id_ruangan) INNER JOIN aktivitas USING(id_aktivitas) 
	LEFT JOIN kelas USING(id_kelas) 
	INNER JOIN dosen USING(id_dosen)
	WHERE id_dosen=:id_dosen and id_thn_ajar=:id_thn_ajar";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_dosen", $id_dosen);
		$stmt->bindParam("id_thn_ajar", $id_thn_ajar);
		$stmt->execute();
		$schedule = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"jadwal": ' . json_encode($schedule) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage().'}}';
	}
}

// getJadwal By Id
function getJadwalById($id_jadwal) {
	$sql = "SELECT id_jadwal, jam, tanggal, hari, ruangan, nama_aktivitas, kelas, repetisi, keterangan, id_jenis_aktivitas, nama FROM `jadwal` 
	INNER JOIN kelas USING(id_kelas) 
	INNER JOIN aktivitas USING(id_aktivitas) 
	LEFT JOIN ruangan USING(id_ruangan) 
	INNER JOIN dosen USING(id_dosen)
	WHERE id_jadwal=:id_jadwal";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_jadwal", $id_jadwal);
		$stmt->execute();
		$jadwal = $stmt->fetchObject();  
		$db = null;
		echo json_encode($jadwal); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateKeterangan($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$aktivitas = json_decode($body);
	$sql = "UPDATE jadwal SET keterangan=:keterangan WHERE id_jadwal=:id_jadwal";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("keterangan", $aktivitas->keterangan);
		$stmt->bindParam("id_jadwal", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($aktivitas); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateJadwal($id_jadwal) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$aktivitas = json_decode($body);
	$sql = "UPDATE jadwal SET hari=:hari, jam=:jam, tanggal=:tanggal WHERE id_jadwal=:id_jadwal";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("tanggal", $aktivitas->tanggal);
		$stmt->bindParam("jam", $aktivitas->jam);
		$stmt->bindParam("hari", $aktivitas->hari);
		$stmt->bindParam("id_jadwal", $id_jadwal);
		$stmt->execute();
		$db = null;
		echo json_encode($aktivitas); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteJadwal($id_jadwal) {
	$sql = "DELETE FROM jadwal WHERE id_jadwal=:id_jadwal";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_jadwal", $id_jadwal);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
// ========= manajemen data jurusan ========= //

// mendaptakan semua data jurusan untuk mengakses request ke link http://localhost/classroom_schedules/api/jurusan

function getJurusan() {
	$sql = "SELECT * FROM jurusan ORDER BY id_fakultas";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);
		$jurusan = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"jurusan": ' . json_encode($jurusan) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

// ========= manajemen data tahun ajar ========= //

// mendapatkan semua data tahun ajar untuk mengakses requet ke link http://localhost/classroom_schedules/api/thn_ajar

function getTahunAjar() {
	$sql = "SELECT * FROM thn_ajar ORDER BY id_thn_ajar DESC";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);
		$thn_ajar = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"thn_ajar": ' . json_encode($thn_ajar) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

// ============== Ruangan =================== //
function getRuangan($id_jurusan) {


	$sql = "SELECT id_ruangan, ruangan, status FROM ruangan INNER JOIN ruang_jurusan USING(id_ruangan) WHERE id_jurusan=:id_jurusan ORDER BY ruangan";
	try{
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->execute();
		$ruangan = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"ruangan": ' . json_encode($ruangan) . '}';
	}catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getRuanganFakultas($id_jurusan) {
	$sql = "SELECT id_ruangan, ruangan, status, id_jurusan FROM `ruangan` LEFT JOIN ruang_jurusan USING(id_ruangan) 
			WHERE id_fakultas=(SELECT id_fakultas FROM jurusan WHERE id_jurusan = :id_jurusan)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->execute();
		$ruangan = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"ruanganFakultas": ' . json_encode($ruangan) . '}';
	} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function addRuangJurusan($id_jurusan, $id_ruangan) {
	$sql = "INSERT INTO ruang_jurusan (id_jurusan, id_ruangan) VALUES (:id_jurusan, :id_ruangan)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_jurusan", $id_jurusan);
		$stmt->bindParam("id_ruangan", $id_ruangan);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function deleteRuangJurusan($id_jurusan, $id_ruangan) {
	$sql = "DELETE FROM ruang_jurusan WHERE id_jurusan=:id_jurusan AND id_ruangan=:id_ruangan";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_jurusan", $id_jurusan);
		$stmt->bindParam("id_ruangan", $id_ruangan);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

// ================= Mata Kuliah ================= //
function getMatkul($id_jurusan,$penawaran) {
	$sql = "SELECT id_matkul, matkul, sks FROM `matkul` WHERE id_jurusan=:id_jurusan AND penawaran=:penawaran ORDER BY id_matkul";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->bindParam("penawaran",$penawaran);
		$stmt->execute();
		$matkul = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"matkul":' . json_encode($matkul) . '}'; 
	}catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

// ============== Kelas =================== //
function getKelas($id_jurusan,$tahun, $semester) {
	$sql = "SELECT * FROM (SELECT concat(semester_posisi,Id_Kelas) as Kelas , Left(Id_Penawaran,5) as Jurusan FROM penawaran
			inner join matkul on (penawaran.Id_MataKuliah = matkul.id_matkul) 
			WHERE Tahun = :tahun and penawaran.Semester % 2 = :semester
			group by Kelas) as tkelas WHERE tkelas.Jurusan = :id_jurusan ORDER BY Kelas";



	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->bindParam("tahun",$tahun);
		$stmt->bindParam("semester",$semester);
		$stmt->execute();
		$kelas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"kelas":' . json_encode($kelas) . '}';
	}catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function cekKelas($kelas, $id_jurusan) {
	$sql = "SELECT id_kelas, kelas FROM kelas WHERE kelas=:kelas AND id_jurusan=:id_jurusan";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("kelas",$kelas);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->execute();
		$cek = $stmt->fetchObject();
		$db = null;
		echo json_encode($cek);
	}catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function simpanKelas($kelas, $id_jurusan) {
	$sql = "INSERT INTO kelas (kelas, id_jurusan) VALUES (:kelas, :id_jurusan)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("kelas",$kelas);
		$stmt->bindParam("id_jurusan",$id_jurusan);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function deleteKelas($id_kelas) {
	$sql = "DELETE FROM kelas WHERE id_kelas=:id_kelas";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_kelas", $id_kelas);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

// ================ Validasi Jadwal =================== //


function cekJadwal($id_ruangan, $id_kelas, $hari, $thnAjar) {
	$sql = "SELECT GROUP_CONCAT(jam SEPARATOR ',') AS 'jam' FROM jadwal WHERE (id_ruangan=:id_ruangan OR id_kelas=:id_kelas) AND hari = :hari AND id_thn_ajar= :thnAjar GROUP BY hari";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id_ruangan", $id_ruangan);
		$stmt->bindParam("id_kelas", $id_kelas);
		$stmt->bindParam("hari", $hari);
		$stmt->bindParam("thnAjar", $thnAjar);
		$stmt->execute();
		$cek = $stmt->fetchObject();  
		$db = null;
		echo json_encode($cek); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

// cek jadwal kelas
function cekJadwalKelas($hari, $jam, $thnAjar) {
	$jamX = "%$jam%";
	$sql = "SELECT id_kelas, id_ruangan, id_dosen FROM jadwal WHERE hari =:hari AND jam LIKE :jam AND id_thn_ajar =:thnAjar";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam('hari',$hari);
		$stmt->bindParam('jam',$jamX);
		$stmt->bindParam('thnAjar',$$thnAjar);
		$stmt->execute(); //'hari' => $hari, 'jam' => '%'.$jam.'%'
		$cek = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($cek);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

// ================ DOSEN =========================//
function getDosen($id_jurusan) {
	$sql = "SELECT * FROM dosen WHERE id_jurusan=:id_jurusan";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam('id_jurusan', $id_jurusan);
		$stmt->execute();
		$dosen = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"dosen":'.json_encode($dosen). '}';
	} catch (PDOException $e) {
		echo '{"error":{"text:'. $e->getMessage() .'}}';
	}
}

// ============== HISTORY CHANEL =================== //
function updateHistory() {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$history = json_decode($body);
	$sql = "INSERT INTO history(id_jadwal, kegiatan, tanggal, id_ruangan, id_aktivitas, id_kelas, id_dosen, hari_jadwal, jam_jadwal, tgl_jadwal) VALUES(:id_jadwal, :kegiatan, :tgl, :ruangan, :id_aktivitas, :id_kelas, :id_dosen, :hari, :jam, :tanggal) ";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id_jadwal",$history->id_jadwal);
		$stmt->bindParam("kegiatan",$history->kegiatan);
		$stmt->bindParam("tgl",$history->tanggal);
		$stmt->bindParam("ruangan",$history->id_ruangan);
		$stmt->bindParam("id_aktivitas",$history->id_aktivitas);
		$stmt->bindParam("id_kelas",$history->id_kelas);
		$stmt->bindParam("id_dosen",$history->id_dosen);
		$stmt->bindParam("hari",$history->hariJadwal);
		$stmt->bindParam("jam",$history->jamJadwal);
		$stmt->bindParam("tanggal",$history->tglJadwal);
		$stmt->execute();
		$db = null;
		echo json_encode($history);
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

// fungsi pembantu 
function getIdKelas($namaKelas, $idJurusan) {
	$query = "SELECT id_kelas FROM kelas WHERE kelas = :namaKelas && id_jurusan = :idJurusan";
	try {
		$db = getConnection();
		$stmt = $db->prepare($query);
		$stmt->bindParam('namaKelas', $namaKelas);
		$stmt->bindParam('idJurusan', $idJurusan);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
	} catch (PDOException $e){
		echo '{"error":{"text:'. $e->getMessage() .'}}';
	}
	return $data->id_kelas;
}


// ========= manajemen koneksi database ========= // 
function getConnection() {
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/server.php";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

?>