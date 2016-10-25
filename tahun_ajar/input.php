
<?php
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-plus-sign"></i> Tambah Data Tahun Ajar </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
         	</div>
        	<div class="box-content">
        		<form action="index.php?page=tahun_ajar/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="semester" class="control-label"> Semester </label>
                    	<div class="controls">
                    		<select name="semester" id="semester" class='select2-me input-xlarge' data-rule-required="true" data-placeholder="- Pilih Semester -">
                                <option value=""></option>
                                <option value="Ganjil"> Ganjil </option>
                                <option value="Genap">	Genap </option>
                            </select>
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="thn_ajar" class="control-label"> Tahun Ajar </label>
                    	<div class="controls">
                    		<select name="thn_ajar" id="thn_ajar" class='select2-me input-xlarge' data-rule-required="true" data-placeholder="- Pilih Tahun Ajar -">
                            	<option value=""></option>
                            <?php
								$thn_now=(integer)date("Y");
								for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
									$thn_next = $thn+1;
									echo "<option value='$thn/$thn_next'>$thn/$thn_next</option>";
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

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>
