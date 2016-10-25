
<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM ruangan WHERE id_ruangan='$id'");
		$fquery = mysql_query("SELECT * FROM fakultas ORDER BY id_fakultas ASC");
		$data = mysql_fetch_array($query);	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Edit Ruangan </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=ruangan/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="ruangan" class="control-label"> ruangan </label>
                    	<div class="controls">
                        	<input type="hidden" name="id_ruangan" ud="id_ruangan" value="<?php echo "$data[0]";?>"  />
                    		<input type="text" name="ruangan" id="ruangan" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="fakultas" class="control-label"> Nama Fakultas </label>
                    	<div class="controls">
                    		<select name="fakultas" id="fakultas" class="select2-me input-xlarge" data-rule-required="true">
                            <?php
								while ($dfak=mysql_fetch_array($fquery)) {
									if ($dfak[0]==$data[3]) {
										echo "<option value='$dfak[0]' selected='selected'>$dfak[1]</option>";
									} else {
										echo "<option value='$dfak[0]'>$dfak[1]</option>";
									}
								}
							?>
                            </select>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sruangan" class="control-label"> Status Ruangan </label>
                    	<div class="controls">
                    		<select name="sruangan" id="sruangan" class="select2-me input-xlarge" data-rule-required="true">
                            <option value="Jurusan" <?php if($data[2]=="Jurusan"){echo "selected='selected'";}?>>Jurusan</option>
                            <option value="Umum" <?php if($data[2]=="Umum"){echo "selected='selected'";}?>>Umum</option>                            
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
	} else  {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}
?>