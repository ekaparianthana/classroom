<?php
	if ((isset($_SESSION['userlogin']))&&($_SESSION['hak']==1)) {
		$id_jur = $_GET['idjur'];
		$id_fak = $_GET['idfak'];
		if (isset($_POST['ruangan'])) {
			foreach ($_POST['ruangan'] as $key=>$val) {
				mysql_query("INSERT INTO ruang_jurusan (id_jurusan, id_ruangan) VALUES ('$id_jur','$val')");
			}
		}
		$q_ruangan = mysql_query("SELECT * FROM ruangan WHERE id_fakultas='$id_fak' && status='jurusan'");
		$q_jur = mysql_query("SELECT * FROM jurusan WHERE id_jurusan='$id_jur'");
		$data_jur = mysql_fetch_array($q_jur);		
?>
<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Daftar Ruangan dari Jurusan <?php echo "$data_jur[1]" ?>  </h2>
             </div>
        	</div>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
            </div>
            <div class="box-content">
            	<form method="post" class="form-vertical row-border" class="ValidForm">
                	<div class="control-group">
						<div class="controls">
							<select multiple="multiple" id="ruangan" name="ruangan[]" class='multiselect' data-selectableheader="Daftar ruangan fakultas" data-selectionheader="Daftar ruangan jurusan">
                        	<?php
								while ($data_ruangan=mysql_fetch_array($q_ruangan)) {
									$query = mysql_query("SELECT * FROM ruang_jurusan WHERE id_jurusan='$id_jur' && id_ruangan='$data_ruangan[0]'");
									if (mysql_num_rows($query)>0) {
										echo "<option value='$data_ruangan[0]' selected='selected'>$data_ruangan[1]</option>";
									} else {
										echo "<option value='$data_ruangan[0]'>$data_ruangan[1]</option>";
									}
								}
							?>
							</select>
							</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-3 control-label"> </label>
						<div class="col-sm-3">
       					<button class="btn-primary btn" type="submit" name="simpan">Simpan</button>
    					</div>
					</div>
                </form>
            </div>
        </div>
    </div> 
</div>
<?php } else {echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>