<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM admin INNER JOIN jurusan USING(id_jurusan) WHERE id_admin='$id'");
		$qjurusan = mysql_query("SELECT * FROM jurusan ORDER BY id_jurusan ASC");
		$data = mysql_fetch_array($query);	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Edit Data Admin </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=admin/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="nama" class="control-label"> Nama </label>
                    	<div class="controls">
                    		<input type="text" name="nama" id="nama" class="input-xlarge" data-rule-maxlength="30" value="<?php echo "$data[2]";?>" data-rule-required="true">
                        	<input type="hidden" name="id_admin" id="id_admin" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="alamat" class="control-label"> Alamat </label>
                    	<div class="controls">
                    		<input type="text" name="alamat" id="alamat" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[3]";?>">
                    	</div>
                	</div>
                	<div class="control-group">
						<label for="email" class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email" id="email" class="input-xlarge" data-rule-email="true" data-rule-required="true" value="<?php echo "$data[4]";?>">
						</div>
					</div>
                	<div class="control-group">
                		<label for="jurusan" class="control-label"> Jurusan </label>
                    	<div class="controls">
                    		<select name="jurusan" id="jurusan" class="select2-me input-xlarge" data-rule-required="true">
                            <?php
								while ($data_jurusan=mysql_fetch_array($qjurusan)) {
									if ($data[0]==$data_jurusan[0]) {
										echo "<option value='$data_jurusan[0]' selected='selected'>$data_jurusan[1]</option>";
									} else {
										echo "<option value='$data_jurusan[0]'>$data_jurusan[1]</option>";
									}
								}
							?>
                            </select>
                    	</div>
                	</div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan" id="submit">
					</div>
            	</form>
        	</div> 
        </div>
    </div>
</div>

<?php
	} else  {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}
?>