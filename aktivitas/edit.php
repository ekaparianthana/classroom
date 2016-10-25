<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){
		$jurusan = $_SESSION['jurusan'];
		$id = $_GET['id'];
		$qAktivitas = mysql_query("SELECT * FROM jenis_aktivitas ORDER BY jenis_aktivitas ASC");
		$qMataKuliah = mysql_query("SELECT matkul FROM matkul WHERE id_jurusan='$jurusan' ORDER BY matkul ASC");
		$query = mysql_query("SELECT id_jenis_aktivitas, jenis_aktivitas, nama_aktivitas FROM aktivitas INNER JOIN jenis_aktivitas USING(id_jenis_aktivitas) WHERE id_aktivitas='$id'");
		$data_aktivitas = mysql_fetch_array($query); 
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-edit"></i> Edit Data Aktivitas </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=aktivitas/update.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="jenis_aktivitas" class="control-label"> Jenis Aktivitas </label>
                    	<div class="controls">
                        	<input type="hidden" id="id_aktivitas" name="id_aktivitas" value="<?php echo $id;?>" />
                    		<select name="j_aktivitas" id="j_aktivitas" class='select2-me input-xlarge' data-rule-required="true" data-placeholder="- Pilih Jenis Aktivitas -" onchange="list_kul(this.id)">
                            	<option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($qAktivitas)) {
									if ($data[0] == $data_aktivitas[0]){
										echo "<option value='$data[0]' selected='selected'>$data[1]</option>";
									} else {
										echo "<option value='$data[0]'>$data[1]</option>";
									}
								}
							?>
                            </select>
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="Aktivitas" class="control-label"> Nama Aktivitas </label>
                    	<div id="ubah" class="controls">
                        	<?php
								if ($data_aktivitas[1]== "Kuliah") {
                           			echo '<select name="Aktivitas" id="Aktivitas" class="select-me input-xlarge" data-rule-required="true" data-placeholder="- Pilih Mata Kuliah -">';
                   
									while ($data=mysql_fetch_array($qMataKuliah)) {
										if ($data[0]==$data_aktivitas[2]) {
											echo "<option value='$data[0]' selected='selected'>$data[0]</option>";
										} else {
											echo "<option value='$data[0]'>$data[0]</option>";
										}
									}
			                		echo "</select>";
								} else {
							
                    				echo "<input type='text' name='Aktivitas' id='Aktivitas' class='input-xlarge' data-rule-required='true' data-rule-maxlength='50' value='$data_aktivitas[2]'/>";                 
								}
							?>
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