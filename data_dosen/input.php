<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){ 
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Dosen Pengajar </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=data_dosen/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="id_matkul" class="control-label"> ID Dosen </label>
                    	<div class="controls">
                    		<input type="text" name="id_dosen" id="id_dosen" class="input-xlarge" data-rule-required="true" data-rule-minlength="2" data-rule-maxlength="15">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="matkul" class="control-label"> Nama </label>
                    	<div class="controls">
                    		<input type="text" name="nama_dosen" id="nama_dosen" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="username" class="control-label"> Username </label>
                    	<div class="controls">
                    		<input type="text" name="username" id="username" class="input-xlarge" data-rule-minlength="4" data-rule-maxlength="12">
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="pass_lama" class="control-label"> Password  </label>
                    	<div class="controls">
                    		<input type="password" name="pass" id="pass" class="input-xlarge" data-rule-required="true" data-rule-maxlength="20">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="pass_konfirmasi" class="control-label"> Konfirmasi Password </label>
                    	<div class="controls">
                    		<input type="password" name="pass_konfirmasi" id="pass_konfirmasi" class="input-xlarge" data-rule-required="true" data-rule-maxlength="20" data-rule-equalTo="#pass">
                    	</div>
                	</div>

                    <div class="control-group">
                		<label for="sks" class="control-label"> Alamat </label>
                    	<div class="controls">
                    		<textarea name="alamat" id="alamat" class="input-xlarge" data-rule-required="true" rows="4" class="input-block-level"> </textarea>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Jenis Kelamin </label>
                    	<div class="controls">
                        	<div class"radio-col" style="width:90px;float:left">
                    			<label class='radio'><input type="radio" name="jk" value="Pria" data-rule-required="true"> Pria </label>
                            </div>
                            <div class"radio-col" style="width:120px;float:left">
                            	<label class='radio'><input type="radio" name="jk" value="Wanita" data-rule-required="true"> Wanita </label>
                            </div>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Email </label>
                    	<div class="controls">
                    		<input type="text" name="email" id="email" class="input-xlarge" data-rule-required="true" data-rule-email="true">
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