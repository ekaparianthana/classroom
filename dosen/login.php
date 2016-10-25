<?php
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/config.php";
	session_start();
	function anti_injection($data){
		$filler = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		return $filler;
	}
	
	
	$username = anti_injection($_POST['username']);
	$password = anti_injection($_POST['password']); 
	
	$query = mysql_query("SELECT * FROM dosen WHERE username='$username' && pass='$password'");
	if (!$query) {die("Permintaan gagal dilaksanakan");}
	$cek = mysql_num_rows($query);
	$baris = mysql_fetch_array($query);
	
	if ($cek == 1) {
		$_SESSION['dosen_login'] = 1;
		$_SESSION['id_dosen'] = $baris['id_dosen'];
		$_SESSION['username_dosen'] = $baris['username'];
		$_SESSION['jurusan_dosen'] = $baris['id_jurusan'];
	
?>
	<meta http-equiv="refresh" content="1; url=index.php" />
       
<?php 		
	} else {
?>
	<meta http-equiv="refresh" content="1; url=index.php?msg=gagal" />
<?php
	}
	
?>
