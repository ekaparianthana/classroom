<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	
	$query = mysql_query("SELECT id_ruangan, ruangan, fakultas, status FROM ruangan INNER JOIN fakultas USING(id_fakultas) ORDER BY fakultas ASC");
	
?>
<div id="dialog-confirm" title="Hapus Data Ruangan?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Ruangan </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=ruangan/input.php"> <h2> <i class="icon-plus-sign"></i></h2> </a>
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
                        	<th> Nama Ruangan </th>
                            <th> Fakultas </th>
                            <th> Status Ruangan </th>
                        	<th> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_ruangan = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_ruangan[1]"; ?> </td>
                            <td> <?php echo "$data_ruangan[2]"; ?> </td>
                            <td> <?php echo "$data_ruangan[3]"; ?> </td>
                            <td>
                            	<a href="index.php?page=ruangan/edit.php&&id=<?php echo "$data_ruangan[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
								
                                 <a href="javascript:;" onclick="return konfirmasi('index.php?page=ruangan/hapus.php&&id=<?php echo "$data_ruangan[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
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

