<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 5)){
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM matkul WHERE id_matkul='$id'");
		$data = mysql_fetch_array($query); 
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-edit"></i> Edit Data Mata Kuliah </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=matkul/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="id_matkul" class="control-label"> Kode Mata Kuliah </label>
                    	<div class="controls">
                        	<input type="hidden" name="id_lama" id="id_lama" value="<?php echo "$data[0]";?>" />
                    		<input type="text" name="id_matkul" id="id_matkul" class="input-xlarge" data-rule-required="true" data-rule-minlength="7" data-rule-maxlength="7" value="<?php echo "$data[0]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="matkul" class="control-label"> Mata Kuliah </label>
                    	<div class="controls">
                    		<input type="text" name="matkul" id="matkul" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50" value="<?php echo "$data[1]";?>">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Jumlah SKS </label>
                    	<div class="controls">
                    		<input type="text" name="sks" id="sks" class="input-xlarge" data-rule-required="true" data-rule-maxlength="1" value="<?php echo "$data[2]";?>">
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