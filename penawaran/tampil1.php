<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	$fakultas = $_SESSION['fakultas'];
   // $sql = "SELECT Id_MataKuliah, matkul, Id_Kelas, Tahun, penawaran.Semester FROM penawaran INNER JOIN matkul ON (matkul.id_matkul = penawaran.Id_MataKuliah)  WHERE (SELECT LEFT(Id_MataKuliah,2) as fak FROM penawaran GROUP BY fak) = '$fakultas' ORDER BY Id_Matkul, Id_Kelas ASC";
    $sql = "SELECT Id_MataKuliah, matkul, Id_Kelas, Tahun, penawaran.Semester FROM penawaran INNER JOIN matkul ON (matkul.id_matkul = penawaran.Id_MataKuliah)  
            ORDER BY Id_Matkul, Id_Kelas ASC";
    //echo $sql;
	$query = mysql_query($sql);
	$query_jurusan = mysql_query("SELECT * From jurusan WHERE id_fakultas = '$fakultas'");
	
?>
<div id="dialog-confirm" title="Hapus Data Penawaran?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><div id="modalPesan"></div></p>
</div>

<div id="modal-file" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
	<form action="index.php?page=penawaran/import_excel.php" method="post" class="form-horizontal form-bordered form-validate" enctype="multipart/form-data" >
   	 	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Tambah Data Mata Penawaran</h3>
		</div>
    	<div class="modal-body">
                    <div class="control-group">
                		<label for="File" class="control-label"> File </label>
                    	<div class="controls">
                    		<!--<input type="hidden" name="idJurusan" value="<?php //echo $jurusan; ?>" /> -->
                  			<input type="file" name="file" id="file" class="input-block-level" data-rule-required="true" />
                        	<span class="help-block">Hanya bisa membaca file.csv</span>
                    	</div>
                	</div>       
    	</div>
    	<div class="modal-footer">
         
    	 <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
         <input id="btnFile" type="submit" class="btn btn-primary" name="simpan-file" value="Simpan" disabled="disabled"/>
		</div>
	</form>
</div>

<div id="modal-surat" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
    <form action="penawaran/cetak_sk.php" method="post" class="form-horizontal form-bordered" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="myModalLabel">Download Surat Tugas</h3>
        </div>
        <div class="modal-body">

                    <div class="control-group">
                        <label for="jurusan" class="control-label"> Prodi </label>
                        <div class="controls">
                            <select name="jurusan" id="sk-jurusan" class='select2-me input-large' data-rule-required="true" data-placeholder="- Pilih Prodi -">
                                <option value=""> </option>
                            <?php
                                while ($data=mysql_fetch_array($query_jurusan)) {
                                    echo "<option value='$data[0]/$data[2]/$data[1]'>$data[1]</option>";
                                }
                            ?>
                            </select>
                        </div>                  
                    </div>

                    <div class="control-group">
                        <label for="jurusan" class="control-label"> Dosen </label>
                        <div class="controls">
                            <select name="nip" class='select2-me input-large' data-rule-required="true" data-placeholder="- Pilih Prodi -">
                                <option value=""> </option>
                            <?php
                                $query_dosen = mysql_query("SELECT * FROM dosen");
                                while ($data=mysql_fetch_assoc($query_dosen)) {
                                    echo "<option value='$data[nip]'>$data[nama]</option>";
                                }
                            ?>
                            </select>
                        </div>                  
                    </div>
                    
                    <div class="control-group">
                        <label for="thn_ajar" class="control-label"> Tahun Ajar </label>
                        <div class="controls">
                            <select name="sk-tahun" id="sk-tahun" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Tahun Ajar -">
                                <option value=""></option>
                            <?php
                                $thn_now=(integer)date("Y");
                                for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
                                    //$thn_next = $thn+1;
                                    echo "<option value='$thn'>$thn</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="semester" class="control-label"> Semester </label>
                        <div class="controls">
                            <select name="sk-semester" id="sk-semester" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Semester -">
                                <option value=""></option>
                                <option value="1"> Ganjil </option>
                                <option value="2"> Genap </option>
                            </select>
                        </div>
                    </div>  
        </div>
        <div class="modal-footer">
         
            <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
             <button class="btn-primary"> Download</button>
        </div>
    </form>
</div>

<div id="modal-sk" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
	<form action="penawaran/dwnload-excel.php" method="get" class="form-horizontal form-bordered" >
   	 	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Download SK Mengajar</h3>
		</div>
    	<div class="modal-body">
        			<div class="control-group">
                		<label for="jurusan" class="control-label"> Prodi </label>
                    	<div class="controls">
                    		<select name="jurusan" id="sk-jurusan" class='select2-me input-large' data-rule-required="true" data-placeholder="- Pilih Prodi -">
                            	<option value=""> </option>
                            <?php
                                $sql = "SELECT * From jurusan WHERE id_fakultas = '$fakultas'";
                                $query_jurusan = mysql_query($sql);
								while ($data=mysql_fetch_array($query_jurusan)) {
									echo "<option value='$data[0]'>$data[1]</option>";
								}
							?>
                            </select>
                    	</div>                	
                    </div>
                    
        			<div class="control-group">
                		<label for="thn_ajar" class="control-label"> Tahun Ajar </label>
                    	<div class="controls">
                    		<select name="tahun" id="sk-tahun" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Tahun Ajar -">
                            	<option value=""></option>
                            <?php
								$thn_now=(integer)date("Y");
								for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
									//$thn_next = $thn+1;
									echo "<option value='$thn'>$thn</option>";
								}
							?>
                            </select>
                    	</div>
                	</div>
                    
        			<div class="control-group">
                		<label for="semester" class="control-label"> Semester </label>
                    	<div class="controls">
                    		<select name="semester" id="sk-semester" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Semester -">
                                <option value=""></option>
                                <option value="1"> Ganjil </option>
                                <option value="2"> Genap </option>
                            </select>
                    	</div>
                	</div>  
    	</div>
    	<div class="modal-footer">
         
    	 	<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
         	 <button id="skmengajar1" type="submit" class="btn-primary"> Download</button>
		</div>
	</form>
</div>

<div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">Tambah Penawaran</h3>
			</div>
            <form action="index.php?page=penawaran/simpan-penawaran.php&id=ruangan" method="post" class="form-horizontal form-bordered form-validate" id="bb">
				<div class="modal-body">
                	<div class="control-group">
                		<label for="jurusan" class="control-label"> Prodi </label>
                    	<div class="controls">
                    		<select name="jurusan" id="data-jurusan" class='select2-me input-large' data-rule-required="true" data-placeholder="- Pilih Prodi -">
                            	<option value=""> </option>
                            <?php
								$query_jurusan = mysql_query("SELECT * From jurusan WHERE id_fakultas = '$fakultas'");
								while ($data=mysql_fetch_array($query_jurusan)) {
									echo "<option value='$data[0]'>$data[1]</option>";
								}
							?>
                            </select>
                    	</div>                	
                    </div>
                    
                    <div class="control-group">
                		<label for="semester" class="control-label"> Semester </label>
                    	<div class="controls">
                    		<select name="semester" id="data-semester" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Semester -">
                                <option value=""></option>
                                <option value="1"> Ganjil </option>
                                <option value="2"> Genap </option>
                            </select>
                    	</div>
                	</div>
                    
                    <div class="control-group">
                    <label for="thn_ajar" class="control-label"> Tahun Ajar </label>
                    	<div class="controls">
                    		<select name="thn_ajar" id="data-thn_ajar" class='select2-me input-medium' data-rule-required="true" data-placeholder="- Pilih Tahun Ajar -">
                            	<option value=""></option>
                            <?php
								$thn_now=(integer)date("Y");
								for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
									//$thn_next = $thn+1;
									echo "<option value='$thn'>$thn</option>";
								}
							?>
                            </select>
                    	</div>
                	</div>
                    
                     <div class="control-group" id='col-matkul'>
                		<label for="dosen" class="control-label"> Mata Kuliah </label>
                    	<div class="controls">
                        	<select id="data-matkul" name="matkul" class="select2-me input-xlarge" data-placeholder="-- Pilih Matakuliah --" data-rule-required="true">
                    			<option value=""></option>
                        		 <?php
								 		$qr_matkul = mysql_query("SELECT * FROM matkul");
										while ($data=mysql_fetch_array($qr_matkul)) {
											echo "<option value='$data[0]'> $data[1]</option>";
										}
								?>
                   			 </select>                    
                        </div>
                	</div>
                                                           
                    <div class="control-group">
                    	<label for="kelas" class="control-label"> Kelas </label>
                        <div class="controls">
                    		<select name="kelas" id="data-kelas" class="input-small opsi-kelas" data-rule-required="true" data-placeholder='-Pilih kls-'>								<option value=""></option>
                            	<?php
									for($i='A'; $i<='G'; $i++){
										echo "<option value='$i'>$i</option>";
									} 
								?>
                            </select>
                    	</div>
                    </div>
                    
                    <div class="control-group" id='col-dosen'>
                		<label for="dosen" class="control-label"> Dosen Pengajar </label>
                    	<div class="controls">
                        	<select id="data-dosen" name="dosen" class="select2-me input-xlarge" data-placeholder="-- Pilih Dosen --" data-rule-required="true">
                    			<option value=""></option>
                        		 <?php
								 		$qr_dosen = mysql_query("SELECT * FROM dosen");
										while ($data=mysql_fetch_array($qr_dosen)) {
											echo "<option value='$data[0]'> $data[1]</option>";
										}
								?>
                   			 </select>                    
                        </div>
                	</div>
                    
                    <div class="control-group" id="col-hari">
                    	<label for="hari" class="control-label"> Hari </label>
                        <div class="controls">
                    		<select name="hari" id="data-hari" class="input-small" data-rule-required="true" data-placeholder="-Pilih Hari-">
                           		<option value=""></option>
                                <?php
									$hari = array("Minggu","Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
									//echo "<option value='$hari[1]'>$hari[1]</option>";
									for ($i=0; $i<count($hari); $i++) {
										echo "<option value='$hari[$i]'>$hari[$i]</option>";
									}
								?>
                            </select>
                            <input id='hidden-hari' name="hari" type="hidden" value="" disabled="disabled" />
                    	</div>
                    </div>
                    
                    <div class="control-group" id="col-jam">
                    	<label class="control-label"> Jam </label>
                        <div class="controls">
                        	<div class="check-col" style="width:100px;float:left">
                    			<label class='checkbox A'>
									<input id="A" type="checkbox" name="jam[]" value="A" data-rule-required="true"> A [07:30]
								</label>
                                <label class='checkbox B'>
									<input id="B" type="checkbox" name="jam[]" value="B" data-rule-required="true"> B [08:30]
								</label>
                                <label class='checkbox C'>
									<input id="C" type="checkbox" name="jam[]" value="C" data-rule-required="true"> C [09:30]
								</label>
                                <label class='checkbox D'>
									<input id="D" type="checkbox" name="jam[]" value="D" data-rule-required="true"> D [10:30]
								</label>
                                <label class='checkbox E'>
									<input id="E" type="checkbox" name="jam[]" value="E" data-rule-required="true"> E [11:30]
								</label>
                            </div>
                            <div class="check-col" style="width:100px;float:left">
                    			<label class='checkbox F'>
									<input id="F" type="checkbox" name="jam[]" value="F" data-rule-required="true"> F [12:30]
								</label>
                                <label class='checkbox G'>
									<input id="G" type="checkbox" name="jam[]" value="G" data-rule-required="true"> G [13:30]
								</label>
                                <label class='checkbox H'>
									<input id="H" type="checkbox" name="jam[]" value="H" data-rule-required="true"> H [14:30]
								</label>
                                <label class='checkbox I'>
									<input id="I" type="checkbox" name="jam[]" value="I" data-rule-required="true"> I [15:30]
								</label>
                                <label class='checkbox J'>
									<input id="J" type="checkbox" name="jam[]" value="J" data-rule-required="true"> J [16:30]
								</label>
                            </div>
                            <div class="check-col" style="width:100px;float:left">
                    			<label class='checkbox K'>
									<input id="K" type="checkbox" name="jam[]" value="K" data-rule-required="true"> K [17:30]
								</label>
                                <label class='checkbox L'>
									<input id="L" type="checkbox" name="jam[]" value="L" data-rule-required="true"> L [18:30]
								</label>
                                <label class='checkbox M'>
									<input id="M" type="checkbox" name="jam[]" value="M" data-rule-required="true"> M [19:30]
								</label>
                                <label class='checkbox N'>
									<input id="N" type="checkbox" name="jam[]" value="N" data-rule-required="true"> N [20:30]
								</label>
                                <label class='checkbox O'>
									<input id="O" type="checkbox" name="jam[]" value="O" data-rule-required="true"> O [21:30]
								</label>
                            </div>
                    	</div>
                    </div>
                    
                    <div class="control-group" id='col-ruangan'>
                		<label for="ruangan" class="control-label"> Ruangan </label>
                    	<div class="controls">
                        	<select id="data-ruangan" name="ruangan" class="select2-me input-xlarge" data-placeholder="-- Pilih Ruangan --" data-rule-required="true">
                    			<option value=""></option>
                        		 <?php
								 		$qr_ruangan = mysql_query("SELECT * FROM ruangan");
										while ($data=mysql_fetch_array($qr_ruangan)) {
											echo "<option value='$data[0]'> $data[1]</option>";
										}
								?>
                   			 </select>                    
                        </div>
                	</div>
                    
                    <div class="control-group">
                    	<label for="keterangan" class="control-label"> Keterangan </label>
                        <div class="controls">
                    		<textarea name="keterangan" id="keterangan" rows="4" class="input-block-level"> </textarea>
                    	</div>
                    </div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
			</div>
          </form>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
        		<h2> <i class="icon-reorder"></i> Data Penawaran </h2>
             </div>
            <div class="pull-right" >
            	<div id="dwnload" style="float:left;padding-right:30px">
                	<a href="#modal-1" data-toggle="modal" > <h2> <button class="btn-primary" > Tambah Data </button></h2> </a>
                </div>
            	<div id="input" style="padding-right:30px;float:left">
                	<a href="#modal-file" data-toggle="modal" style="float:left"> <h2> <button class="btn-primary" > Tambah File </button></h2> </a>
                </div>
                <div id="input" style="padding-right:30px;float:right">
                    <a href="#modal-surat" data-toggle="modal" style="float:left"> <h2> <button class="btn-primary" > Surat Tugas </button></h2> </a>
                </div>
                <div id="input" style="padding-right:30px;float:right">
                	<a href="#modal-sk" data-toggle="modal" style="float:left"> <h2> <button class="btn-primary" > SK Mengajar </button></h2> </a>
                </div>
        	</div>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
            </div>
        	<div class="box-content nopadding">
        		<table class="table table-hover table-nomargin table-bordered dataTable">
            		<thead>
                		<tr>
                    		<th style="text-align:center"> No </th>
                        	<th style="text-align:center"> Kode Mata Kuliah </th>
                            <th style="text-align:center"> Mata Kuliah </th>
                            <th style="text-align:center"> Kelas </th>
                            <th style="text-align:center"> Tahun </th>
                            <th style="text-align:center"> Semester </th>
                        	<th style="text-align:center"> Pilihan </th>
                    	</tr>
                	</thead>
                    <tbody>
                    	<?php
							$i = 1;
							while ($data_matkul = mysql_fetch_array($query)) {
						?>
                        
                        <tr>
                        	<td style="text-align:center"> <?php echo "$i"; ?> </td>
                            <td> <?php echo "$data_matkul[0]"; ?> </td>
                            <td> <?php echo "$data_matkul[1]"; ?> </td>
                            <td> <?php echo "$data_matkul[2]"; ?> </td>
                            <td> <?php echo "$data_matkul[3]"; ?> </td>
                            <td> <?php echo "$data_matkul[4]"; ?> </td>
                            <td style="text-align:center">
                            	<a href="index.php?page=matkul/edit.php&&id=<?php echo "$data_matkul[0]"; ?>" class="btn" rel="tooltip" title="Edit"><i class="icon-edit"></i></a>
								
                                 <a href="javascript:;" onclick="return konfirmasi('index.php?page=matkul/hapus.php&&id=<?php echo "$data_matkul[0]";?>','Apakah anda yakin akan menghapus data ini?')" class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a>
                            </td>
                        </tr>
                        
                        <?php $i++; } ?>
                    </tbody>
            	</table>
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
    

    
	
	$('#skmengajar').click(function(event){
				var jur =  document.getElementById("sk-jurusan");
				var jurusan = jur.options[jur.selectedIndex].value;
				var smt = document.getElementById("sk-semester");
				var semester = smt.options[smt.selectedIndex].value;
				var thn = document.getElementById("sk-tahun");
				var tahun = thn.options[thn.selectedIndex].value;
				console.log(semester);
				event.preventDefault();
				$('#modal-sk').modal('hide');
				window.location = '/classroom_schedules/penawaran/dwnload-excel.php?jurusan=' + jurusan + '&tahun=' + tahun + '&semester=' +semester;
	
			});
</script>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>

