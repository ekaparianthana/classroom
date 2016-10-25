<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM dosen WHERE id_dosen='$id'");
		$data = mysql_fetch_array($query); 
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-edit"></i> Edit Data Dosen Pengajar </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=data_dosen/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="id_dosen" class="control-label"> ID Dosen </label>
                    	<div class="controls">
                        	<input type="hidden" name="id_lama" id="id_lama" value="<?php echo "$data[0]";?>" />
                    		<input type="text" name="id_dosen" id="id_dosen" class="input-xlarge" data-rule-required="true" data-rule-minlength="3" data-rule-maxlength="18" value="<?php echo "$data[0]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="dosen" class="control-label"> Nama </label>
                    	<div class="controls">
                    		<input type="text" name="nama_dosen" id="nama_dosen" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Alamat </label>
                    	<div class="controls">
                    		<textarea name="alamat" id="alamat" class="input-xlarge" data-rule-required="true"  rows="4"  class="input-block-level"><?php echo "$data[2]";?></textarea>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Jenis Kelamin </label>
                    	<div class="controls">
                        	<div class"radio-col" style="width:90px;float:left">
                    			<label class='radio'><input type="radio" name="jk" value="Pria" data-rule-required="true" <?php if($data[3] == "Pria"){echo "checked='checked'";}?> /> Pria </label>
                            </div>
                            <div class"radio-col" style="width:120px;float:left">
                            	<label class='radio'><input type="radio" name="jk" value="Wanita" data-rule-required="true" <?php if($data[3] == "Wanita"){echo "checked='checked'";}?>/> Wanita </label>
                            </div>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Email </label>
                    	<div class="controls">
                    		<input type="text" name="email" id="email" class="input-xlarge" data-rule-required="true" data-rule-email="true" value="<?php echo "$data[4]";?>"/>
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