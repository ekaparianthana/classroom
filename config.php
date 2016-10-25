<?php
	include dirname(__FILE__)."/server.php";
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	$select = mysql_select_db($dbname,$con);
	if (!$con) {die("Gagal melakukan koneksi ke database server.");}
	if (!$select) {die("Database tidak tersedia");} 
?>