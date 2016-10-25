
<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
		if ($_GET['data']=='fak') {
			$id = $_GET['id'];
			$query = mysql_query("SELECT * FROM fakultas WHERE id_fakultas='$id'");
			$data = mysql_fetch_array($query);	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Edit Fakultas </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=jurusan/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="id_fakultas" class="control-label"> Kode Fakultas </label>
                    	<div class="controls">
                    		<input type="text" name="id_fakultas" id="id_fakultas" class="input-xlarge" data-rule-maxlength="2" data-rule-number="true" value="<?php echo "$data[0]";?>" data-rule-required="true">
                            <input type="hidden" name="id_fakultas_lama" id="id_fakultas_lama" value="<?php echo "$data[0]";?>" />
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="fakultas" class="control-label"> Nama Fakultas </label>
                    	<div class="controls">
                    		<input type="text" name="fakultas" id="fakultas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan" name="data_fak">
					</div>
            	</form>
        	</div> 
        </div>
    </div>
</div>

<?php
		}
		if ($_GET['data']=='jur') {
			$id = $_GET['id'];
			$query = mysql_query("SELECT id_jurusan, jurusan, id_fakultas FROM jurusan INNER JOIN fakultas USING(id_fakultas) WHERE id_jurusan='$id'");
			$fquery = mysql_query("SELECT * FROM fakultas");
			$data = mysql_fetch_array($query);
?>
<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Edit Jurusan </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=jurusan/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="id_jurusan" class="control-label"> Kode Jurusan </label>
                    	<div class="controls">
                    		<input type="text" name="id_jurusan" id="id_jurusan" class="input-xlarge" data-rule-maxlength="5" data-rule-number="true" value="<?php echo "$data[0]";?>" data-rule-required="true">
                            <input type="hidden" name="id_jurusan_lama" id="id_jurusan_lama" value="<?php echo "$data[0]";?>" />
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="jurusan" class="control-label"> Nama Jurusan </label>
                    	<div class="controls">
                    		<input type="text" name="jurusan" id="jurusan" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                    	<label for="fakultas" class="control-label"> Fakultas </label>
                        <div class="controls">
                        	<select name="fakultas" id="fakultas" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="--Pilih Fakultas--">
                            <option value=""></option>
                            <?php
								while ($fakultas=mysql_fetch_array($fquery)) {
									if ($data[2]==$fakultas[0]) {
										echo "<option value='$fakultas[0]' selected='selected'>$fakultas[1]</option>>";
									} else {
										echo "<option value='$fakultas[0]'>$fakultas[1]</option>>";
									}
								} 
							?>
                            </select>
                        </div>
                    </div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
            	</form>
        	</div> 
        </div>
    </div>
</div>

<?php 
		}
	} else  {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}
?>