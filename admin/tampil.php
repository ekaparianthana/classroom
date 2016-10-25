<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 9)) { 
	
	$query = mysql_query("SELECT * FROM admin INNER JOIN jurusan USING(id_jurusan) ORDER BY status DESC, id_admin ASC");
?>
<div id="dialog-confirm" title="Hapus Data Admin?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Admin </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=admin/input.php"> <h2> <i class="icon-plus-sign"></i></h2> </a>
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
                    		<th> No </th>
                        	<!--<th> Id Admin </th>-->
                        	<th width="20%"> Nama </th>
                        	<th> Alamat </th>
                        	<th> E-mail </th>
                        	<th> Username </th>
                        	<th> Jurusan </th>
                        	<th> Status </th>
                        	<th> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_admin = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_admin[2]"; ?> </td>
                            <td> <?php echo "$data_admin[3]"; ?> </td>
                            <td> <?php echo "$data_admin[4]"; ?> </td>
                            <td> <?php echo "$data_admin[5]"; ?> </td>
                            <td> <?php echo "$data_admin[8]"; ?> </td>
                            <td> <?php if($data_admin[7] == 9) {echo "Super Admin";} else {echo "Admin Jurusan";} ?> </td>
                            <td>
                            	<a href="index.php?page=admin/edit.php&&id=<?php echo "$data_admin[1]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
                                <?php if ($_SESSION['username'] == $data_admin[5]) {
								?>
                                <a href="index.php?page=admin/ubah_pass.php&&id=<?php echo "$data_admin[1]";?>" class="btn" rel="tooltip" title="Ubah Password"><i class="icon-key"></i></a>
                                <?php } else { ?>
								<!-- <a href="index.php?page=admin/hapus.php&&id=<?php //echo "$data_admin[1]";?>" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a> -->
                                
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=admin/hapus.php&&id=<?php echo "$data_admin[1]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
                                <?php } ?>
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

