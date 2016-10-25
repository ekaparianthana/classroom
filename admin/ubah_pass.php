<?php 
	if (isset($_SESSION['userlogin'])) {
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM admin WHERE id_admin='$id'");
		$data = mysql_fetch_array($query);	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Pengaturan Akun </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=admin/proses_pass.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="nama" class="control-label"> Nama </label>
                    	<div class="controls">
                    		<input type="text" name="nama" id="nama" class="input-xlarge" value="<?php echo "$data[1]";?>" readonly="readonly">
                        	<input type="hidden" name="id_admin" id="id_admin" value="<?php echo "$data[0]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="username" class="control-label"> Username </label>
                    	<div class="controls">
                    		<input type="text" name="username" id="username" class="input-xlarge" value="<?php echo "$data[4]";?>" data-rule-minlength="4" data-rule-maxlength="12">
                            <input type="hidden" name="username_lama" id="username_lama" value="<?php echo "$data[4]";?>">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="pass_lama" class="control-label"> Password Lama </label>
                    	<div class="controls">
                    		<input type="password" name="pass_lama" id="pass_lama" class="input-xlarge" data-rule-required="true" data-rule-maxlength="20">
                    	</div>
                	</div>
                	<div class="control-group">
						<label for="pass_baru" class="control-label"> Password Baru </label>
						<div class="controls">
							<input type="password" name="pass_baru" id="pass_baru" class="input-xlarge" data-rule-required="true" data-rule-maxlength="20">
						</div>
					</div>
                	<div class="control-group">
                		<label for="pass_konfirmasi" class="control-label"> Konfirmasi Password </label>
                    	<div class="controls">
                    		<input type="password" name="pass_konfirmasi" id="pass_konfirmasi" class="input-xlarge" data-rule-required="true" data-rule-maxlength="20" data-rule-equalTo="#pass_baru">
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