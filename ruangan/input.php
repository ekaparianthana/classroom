
<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){ 
	$query = mysql_query("SELECT * FROM fakultas ORDER BY id_fakultas ASC");
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Ruangan </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=ruangan/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                	<div class="control-group">
                		<label for="ruangan" class="control-label"> Nama Ruangan </label>
                    	<div class="controls">
                    		<input type="text" name="ruangan" id="ruangan" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="fakultas" class="control-label"> Nama Fakultas </label>
                    	<div class="controls">
                    		<select name="fakultas" id="fakultas" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="-- Pilih Fakultas --">
                            <option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($query)) {
									echo "<option value='$data[0]'>$data[1]</option>";
								}
							?>
                            </select>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sruangan" class="control-label"> Status Ruangan </label>
                    	<div class="controls">
                    		<select name="sruangan" id="sruangan" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="-- Pilih Status --">
                            <option value=""></option>
                            <option value="Jurusan">Jurusan</option>
                            <option value="Umum">Umum</option>                            
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

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>