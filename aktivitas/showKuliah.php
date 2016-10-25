<?php session_start();
	
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";

	$jur = $_SESSION['jurusan'];
	$matkul = array();
	$query = "SELECT id_matkul, matkul FROM `matkul` WHERE id_jurusan='$jur' ORDER BY matkul";
	$result = mysqli_query($con, $query);
	while($obj = mysqli_fetch_object($result)){
		$matkul[] = $obj;
	}
	echo '{"matkul":'.json_encode($matkul).'}';
?>

