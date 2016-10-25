
<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){ 
		if ($_GET['data']=='jur') {
			$query = mysql_query("SELECT * FROM fakultas ORDER BY id_fakultas ASC");
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Jurusan </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=jurusan/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="id_jurusan" class="control-label"> Kode Jurusan </label>
                    	<div class="controls">
                    		<input type="text" name="id_jurusan" id="id_jurusan" class="input-xlarge" data-rule-required="true" data-rule-maxlength="15">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="jurusan" class="control-label"> Nama Jurusan </label>
                    	<div class="controls">
                    		<input type="text" name="jurusan" id="jurusan" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                    <div class="control-group">
                    	<label for="fakultas" class="control-label"> Fakultas </label>
                        <div class="controls">
                        	<select name="fakultas" id="fakultas" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="--Pilih Fakultas--">
                            <option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($query)) {
									echo "<option value='$data[0]'>$data[1]</option>>";
								} 
							?>
                            </select>
                        </div>
                    </div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan" name="data_jurusan">
					</div>
            	</form>
        	</div>
        </div>
    </div>
</div>

<?php } 
	if ($_GET['data']=='fak') {
?>
<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Fakultas </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=jurusan/simpan.php&&data=fakultas" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="id_fakultas" class="control-label"> Kode Fakultas </label>
                    	<div class="controls">
                    		<input type="text" name="id_fakultas" id="id_fakultas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="15">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="fakultas" class="control-label"> Nama Fakultas </label>
                    	<div class="controls">
                    		<input type="text" name="fakultas" id="fakultas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan" name="data_fakultas">
					</div>
            	</form>
        	</div>
        </div>
    </div>
</div>
<?php
	}
} else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>