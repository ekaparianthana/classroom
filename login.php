<?php
	include dirname(__FILE__)."/config.php";
	session_start();
	function anti_injection($data){
		$filler = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		return $filler;
	}
	
	
	$username = anti_injection($_POST['username']);
	$password = anti_injection($_POST['password']); 
	
	$query = mysql_query("SELECT * FROM admin WHERE username='$username' && password='$password'");
	if (!$query) {die("Permintaan gagal dilaksanakan");}
	$cek = mysql_num_rows($query);
	$baris = mysql_fetch_array($query);
	
	if ($cek == 1) {
		$_SESSION['userlogin'] = 1;
		$_SESSION['user_id'] = $baris['id_admin'];
		$_SESSION['username'] = $baris['username'];
		$_SESSION['nama'] = $baris['nama'];
		$_SESSION['fakultas'] = $baris['id_fakultas'];
		$_SESSION['hak'] = $baris['status'];
	
?>
	<meta http-equiv="refresh" content="1; url=index.php?page=home.php" />
       
<?php 		
	} else {
?>
	<meta http-equiv="refresh" content="1; url=index.php?msg=gagal" />
<?php
	}
	
?>
