<?php	
	include $_SERVER['DOCUMENT_ROOT']."/classroom_schedules/server.php";
	$id_mysql=mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname,$id_mysql);		
	
?>