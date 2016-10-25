
<?php 
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==9)) {
		$id = $_GET['id'];
		$query = mysql_query("SELECT * FROM thn_ajar WHERE id_thn_ajar='$id'");
		$data = mysql_fetch_array($query);	
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
        	<h2> <i class="icon-edit"></i> Edit Data Tahun Ajar </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=tahun_ajar/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
            		<div class="control-group">
                		<label for="semester" class="control-label"> Semester </label>
                    	<div class="controls">
                        	<input type="hidden" name="id_thn_ajar" id="id_thn_ajar" value="<?php echo "$data[0]"; ?>"  />
                    		<select name="semester" id="semester" class='select2-me input-xlarge' data-rule-required="true">
                                <option value="Ganjil" <?php if($data[1]=="Ganjil"){echo "selected='selected'";}?> > Ganjil </option>
                                <option value="Genap" <?php if($data[1]=="Genap"){echo "selected='selected'";}?> >	Genap </option>
                            </select>
                    	</div>
                	</div>
                	<div class="control-group">
                		<label for="thn_ajar" class="control-label"> Tahun Ajar </label>
                    	<div class="controls">
                    		<select name="thn_ajar" id="thn_ajar" class='select2-me input-xlarge' data-rule-required="true">
                            <?php
								$thn_now=(integer)date("Y");
								for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
									$thn_next = $thn+1;
									if ($data[2]=="$thn/$thn_next") {
										echo "<option value='$thn/$thn_next' selected='selected'>$thn/$thn_next</option>";	
									} else {
										echo "<option value='$thn/$thn_next'>$thn/$thn_next</option>";
									}
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

<?php
	} else  {
		echo "<meta http-equiv='refresh' content='1; url=index.php'>";
	}
?>