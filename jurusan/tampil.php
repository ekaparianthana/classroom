<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	
	$query = mysql_query("SELECT id_jurusan, jurusan, fakultas, id_fakultas FROM jurusan INNER JOIN fakultas USING(id_fakultas) ORDER BY id_jurusan ASC");
	$fquery = mysql_query("SELECT * FROM fakultas ORDER BY id_fakultas ASC");
	
?>
<div id="dialog-confirm" title="Hapus Data Fakultas/Jurusan?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Fakultas </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=jurusan/input.php&&data=fak"> <h2> <i class="icon-plus-sign"></i></h2> </a>
                </div>
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
                        	<th style="text-align:center"> Kode Fakultas </th>
                        	<th style="text-align:center"> Nama Fakultas </th>
                        	<th style="text-align:center"> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_fakultas = mysql_fetch_array($fquery)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_fakultas[0]"; ?> </td>
                            <td> <?php echo "$data_fakultas[1]"; ?> </td>
                            <td style="text-align:center">
                            	<a href="index.php?page=jurusan/edit.php&&data=fak&&id=<?php echo "$data_fakultas[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
								
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=jurusan/hapus.php&&data=fak&&id=<?php echo "$data_fakultas[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
                            </td>
                        </tr>
                        
                        <?php $i++; } ?>
                    </tbody>
            	</table>
            </div>
        </div>
    </div>
    
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Jurusan </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=jurusan/input.php&&data=jur"> <h2> <i class="icon-plus-sign"></i></h2> </a>
                </div>
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
                        	<th style="text-align:center"> Kode Jurusan </th>
                        	<th style="text-align:center"> Nama Jurusan </th>
                            <th style="text-align:center"> Fakultas </th>
                        	<th style="text-align:center"> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_jurusan = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_jurusan[0]"; ?> </td>
                            <td> <?php echo "$data_jurusan[1]"; ?> </td>
                            <td> <?php echo "$data_jurusan[2]"; ?> </td>
                            <td style="text-align:center">
                            	<a href="index.php?page=jurusan/edit.php&&data=jur&&id=<?php echo "$data_jurusan[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
                                
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=jurusan/hapus.php&&data=jur&&id=<?php echo "$data_jurusan[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
                                
                                <a href="index.php?page=jurusan/ruang_jur.php&&idjur=<?php echo "$data_jurusan[0]";?>&&idfak=<?php echo "$data_jurusan[3]";?>" class="btn" rel="tooltip" title="Lihat daftar ruangan"><i class="icon-eye-open"></i></a>
                            </td>
                        </tr>
                        
                        <?php $i++; } ?>
                    </tbody>
            	</table>
            </div>
        </div>
    </div>
</div>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>

