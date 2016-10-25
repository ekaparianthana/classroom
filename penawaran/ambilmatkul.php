
<?php

mysql_connect("localhost","root","");
mysql_select_db("classroom_schedule");

$jurusans = $_GET['jurusans'];
$matkul = mysql_query("SELECT * FROM matkul WHERE id_jurusan='$jurusans'");

if ($matkul === false) {
  die(mysql_error());
}

echo "<option>-- Pilih Matkul --</option>";
while($k = mysql_fetch_array($matkul)){
    echo "<option value=\"".$k['id_matkul']."\">".$k['matkul']."</option>\n";
}

?>
