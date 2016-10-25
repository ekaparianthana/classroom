<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	
	$jur = $_SESSION['jurusan'];
	
	$query = mysql_query("SELECT dosen.username, dosen.nama, history.kegiatan, history.tanggal as waktu, aktivitas.nama_aktivitas, kelas.kelas, ruangan.ruangan, hari_jadwal, jam_jadwal, tgl_jadwal, smt, thn_ajar  FROM `history`
inner JOIN jadwal ON history.id_jadwal = jadwal.id_jadwal 
INNER JOIN aktivitas ON aktivitas.id_aktivitas = history.id_aktivitas 
INNER JOIN kelas ON kelas.id_kelas = history.id_kelas 
INNER JOIN dosen ON dosen.id_dosen = history.id_dosen
INNER JOIN ruangan ON history.id_ruangan=ruangan.id_ruangan 
INNER JOIN thn_ajar USING(id_thn_ajar) WHERE aktivitas.id_jurusan = '$jur' ORDER BY id_history DESC");
	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data History </h2>
             </div>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
            </div>
        	<div class="box-content nopadding">
        		<table class="table table-hover table-nomargin table-bordered dataTable">
            		<thead>
                		<tr>
                    		<th style="text-align:center"> No </th>
                        	<th style="text-align:center"> Username </th>
                            <th style="text-align:center"> Nama Dosen </th>
                            <th style="text-align:center"> Kegiatan </th>
                            <th style="text-align:center"> Waktu </th>
                            <th style="text-align:center"> Nama Aktivitas </th>
                            <th style="text-align:center"> Kelas </th>
                            <th style="text-align:center"> Ruangan </th>
                            <th style="text-align:center"> Hari </th>
                            <th style="text-align:center"> Jam </th>
                            <th style="text-align:center"> Tanggal </th>
                            <th style="text-align:center"> Semester </th>

                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_history = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_history[0]"; ?> </td>
                            <td> <?php echo "$data_history[1]"; ?> </td>
                            <td> <?php echo "$data_history[2]"; ?> </td>
                            <td> <?php echo "$data_history[3]"; ?> </td>
                            <td> <?php echo "$data_history[4]"; ?> </td>
                            <td> <?php echo "$data_history[5]"; ?> </td>
                            <td> <?php echo "$data_history[6]"; ?> </td>
                            <td> <?php echo "$data_history[7]"; ?> </td>
                            <td> <?php echo "$data_history[8]"; ?> </td>
                            <td> <?php echo "$data_history[9]"; ?> </td>
                            <td> <?php echo $data_history[10] . " - " . $data_history[11]; ?> </td>
                        </tr>
                        
                        <?php $i++; } ?>
                    </tbody>
            	</table>
            </div>
        </div>
    </div>
</div>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>
