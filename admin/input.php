<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 9)){ 
	$query = mysql_query("SELECT * FROM jurusan ORDER BY id_jurusan ASC");
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Admin </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=admin/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="nama" class="control-label"> Nama </label>
                    	<div class="controls">
                    		<input type="text" name="nama" id="nama" class="input-xlarge" data-rule-required="true" data-rule-maxlength="30">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="alamat" class="control-label"> Alamat </label>
                    	<div class="controls">
                    		<input type="text" name="alamat" id="alamat" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                	<div class="control-group">
						<label for="email" class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email" id="email" class="input-xlarge" data-rule-email="true" data-rule-required="true">
						</div>
					</div>
                	<div class="control-group">
                		<label for="username" class="control-label"> Username </label>
                    	<div class="controls">
                    		<input type="text" name="username" id="username" class="input-xlarge" data-rule-required="true" data-rule-minlength="4" data-rule-maxlength="12">
                    	</div>
                	</div>
                	<div class="control-group">
						<label for="password" class="control-label">Password</label>
						<div class="pw controls">
							<input type="password" name="password" id="password" class="input-xlarge" data-rule-required="true" data-rule-minlength="4" data-rule-maxlength="20">
						</div>
					</div>
                	<div class="control-group">
						<label for="konfirmasi" class="control-label">Konfirmasi password</label>
						<div class="pw controls">
							<input type="password" name="konfirmasi" id="konfirmasi" class="input-xlarge" data-rule-equalTo="#password" data-rule-required="true">
						</div>
					</div>
                	<div class="control-group">
                		<label for="jurusan" class="control-label"> Jurusan </label>
                    	<div class="controls">
                    		<select name="jurusan" id="jurusan" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="- Pilih Jurusan -">
                            <option value=""></option>
                            <?php
								while ($data_jurusan=mysql_fetch_array($query)) {
									echo "<option value='$data_jurusan[0]'>$data_jurusan[1]</option>";
								}
							?>
                            </select>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="status" class="control-label"> Status </label>
                    	<div class="controls">
                    		<select name="status" id="status" class="input-xlarge" data-rule-required="true" data-placeholder="- Pilih Status -">
                            	<option value="1"> Admin Jurusan </option>
                                <option value="9"> Super Admin </option>
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

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>