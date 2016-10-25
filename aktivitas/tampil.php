<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	$jurusan = $_SESSION['jurusan'];
	$query = mysql_query("SELECT jenis_aktivitas, nama_aktivitas, id_aktivitas FROM aktivitas INNER JOIN jenis_aktivitas USING(id_jenis_aktivitas) WHERE id_jurusan='$jurusan' ORDER BY nama_aktivitas ASC");
	
?>
<div id="dialog-confirm" title="Hapus Data Aktivitas?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Aktivitas </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=aktivitas/input.php"> <h2> <i class="icon-plus-sign"></i></h2> </a>
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
                        	<th style="text-align:center"> Jenis Aktivitas </th>
                            <th style="text-align:center"> Nama Aktivitas </th>
                            <th style="text-align:center"> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_aktivitas = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_aktivitas[0]"; ?> </td>
                            <td> <?php echo "$data_aktivitas[1]"; ?> </td>
                            <td style="text-align:center">
                            	<a href="index.php?page=aktivitas/edit.php&&id=<?php echo "$data_aktivitas[2]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
                                
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=aktivitas/hapus.php&&id=<?php echo "$data_aktivitas[2]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
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