<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 5)){ 
		$jurusan = $_SESSION['jurusan'];
?>
<div id="modal-file" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
	<form action="index.php?page=matkul/simpan-file.php" method="post" class="form-horizontal form-bordered form-validate" enctype="multipart/form-data" >
   	 	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Tambah Data Mata Kuliah</h3>
		</div>
    	<div class="modal-body">
                        <input type="hidden" name="idJurusan" value="<?php echo $jurusan; ?>" />
                  		<input type="file" name="file" id="file" class="input-block-level" data-rule-required="true" />
                        <span class="help-block">Hanya bisa membaca file.csv</span>
       
    	</div>
    	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
         <input id="btnFile" type="submit" class="btn btn-primary" name="simpan-file" value="Simpan" disabled="disabled"/>
		</div>
	</form>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-plus-sign"></i> Tambah Data Mata Kuliah </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		<form action="index.php?page=matkul/simpan.php" method="post" class="form-horizontal form-validate form-striped" id="bb">
                	<div class="control-group">
                		<label for="id_matkul" class="control-label"> Kode Mata Kuliah </label>
                    	<div class="controls">
                    		<input type="text" name="id_matkul" id="id_matkul" class="input-xlarge" data-rule-required="true" data-rule-minlength="7" data-rule-maxlength="7">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="matkul" class="control-label"> Mata Kuliah </label>
                    	<div class="controls">
                    		<input type="text" name="matkul" id="matkul" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="sks" class="control-label"> Jumlah SKS </label>
                    	<div class="controls">
                    		<input type="text" name="sks" id="sks" class="input-xlarge" data-rule-required="true" data-rule-maxlength="1">
                    	</div>
                	</div>
                    <div class="control-group">
                		<label for="penawaran" class="control-label"> Penawaran </label>
                    	<div class="controls">
                    		<select name="penawaran" id="penawaran" data-rule-required="true" class="input-small">
                            	<option value=""></option>
                                <option value="Ganjil"> Ganjil </option>
                                <option value="Genap"> Genap </option>
                                <option value="-"> Ganjil - Genap </option>
                            </select>
                    	</div>
                	</div>
                	<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="Simpan">
                        <div class="pull-right">
                        	<a href="#modal-file" data-toggle="modal" class="btn  btn-primary">Tambah Data dari file .csv</a>
                        </div>
					</div>
            	</form>
        	</div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('#file').change(function(){
			$('#btnFile').prop('disabled',false);
		});
	});
</script>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>