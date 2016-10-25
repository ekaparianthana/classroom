<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak'])) {
		$query = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar, smt");	
	
?>
<div id="dialog-confirm" title="Hapus Data Tahun Ajaran?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<div class="pull-left">
            	<h2> <i class="icon-reorder"></i> Data Tahun Ajar </h2>
            </div>
            <div class="pull-right">
        		<div style="padding-right:50px">
                	<a href="index.php?page=tahun_ajar/input.php"><h2> <i class="icon-plus-sign"></i> </h2> </a>
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
                        	<th> Semester </th>
                        	<th> Tahun Ajar </th>
                            <th> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php $i=1; while ($data = mysql_fetch_array($query)) { ?>
                                                <tr>
                        	<td> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data[1]"; ?> </td>
                            <td> <?php echo "$data[2]"; ?> </td>
                            <td>
                            	<a href="index.php?page=tahun_ajar/edit.php&&id=<?php echo "$data[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
								
                                <a href="javascript:;" onclick="return konfirmasi('index.php?page=tahun_ajar/hapus.php&&id=<?php echo "$data[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
                            </td>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>