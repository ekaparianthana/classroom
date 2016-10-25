
<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){ 
		$query = mysql_query("SELECT * FROM jenis_aktivitas ORDER BY jenis_aktivitas ASC");
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Aktivitas </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=aktivitas/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<input type="hidden" name="jurusan" value="<?php echo $_SESSION['jurusan']; ?>" />
                    <div class="control-group">
                		<label for="j_aktivitas" class="control-label"> Jenis Aktivitas </label>
                    	<div class="controls">
                    		<select name="j_aktivitas" id="j_aktivitas" class='select2-me input-xlarge' data-rule-required="true" data-placeholder="- Pilih Jenis Aktivitas -" onchange="list_kul(this.id)">
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
                		<label for="aktivitas" class="control-label"> Nama Aktivitas </label>
                    	<div id="ubah" class="controls">
                        	<input type="text" name="Aktivitas" id="Aktivitas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50"/>                    
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