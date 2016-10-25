<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	// $jurusan = $_SESSION['jurusan'];
	// $query = mysql_query("SELECT * FROM dosen WHERE id_jurusan='$jurusan' ORDER BY id_dosen ASC");
        $query = mysql_query("SELECT * FROM dosen ORDER BY id_dosen ASC")
	
?>
<div id="dialog-confirm" title="Hapus Data Dosen?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Dosen Pengajar </h2>
             </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=data_dosen/input.php"> <h2> <i class="icon-plus-sign"></i></h2> </a>
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
                        	<th style="text-align:center"> ID </th>
                            <th style="text-align:center"> Nama </th>
                            <th style="text-align:center"> Alamat </th>
                            <th style="text-align:center"> Email </th>
                            <th style="text-align:center"> Username </th>
                            <th style="text-align:center"> Password </th>
                        	<th style="text-align:center"> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_dosen = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_dosen[0]"; ?> </td>
                            <td> <?php echo "$data_dosen[1]"; ?> </td>
                            <td> <?php echo "$data_dosen[2]"; ?> </td>
                            <td> <?php echo "$data_dosen[4]"; ?> </td>
                            <td> <?php echo "$data_dosen[7]"; ?> </td>
                            <td> <?php echo "$data_dosen[6]"; ?> </td>
                            <td style="text-align:center">
                            	<a href="index.php?page=data_dosen/edit.php&amp;&amp;id=<?php echo "$data_dosen[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
		
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=data_dosen/hapus.php&&id=<?php echo "$data_dosen[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
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

