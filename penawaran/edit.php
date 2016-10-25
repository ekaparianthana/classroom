<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)){
		$id = $_GET['id'];
        $fakultas = $_SESSION['fakultas'];
		$query = mysql_query("SELECT jurusan.jurusan, penawaran.semester, jadwal.id_thn_ajar, matkul.id_matkul, penawaran.Id_Kelas, dosen.nama, jadwal.hari, jadwal.jam, ruangan.ruangan, jadwal.keterangan
                FROM penawaran
                INNER JOIN pengampu
                USING ( Id_Penawaran )
                INNER JOIN dosen ON dosen.nip = pengampu.nip_dosen
                INNER JOIN jurusan ON dosen.id_jurusan = jurusan.id_jurusan
                INNER JOIN jadwal ON penawaran.Id_Penawaran = jadwal.Id_Penawaran
                INNER JOIN ruangan ON jadwal.id_ruangan = ruangan.id_ruangan
                INNER JOIN matkul ON matkul.id_matkul = penawaran.Id_MataKuliah
                WHERE penawaran.Id_Penawaran = '$id'");
		$dataedit = mysql_fetch_array($query); 
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <h2> <i class="icon-edit"></i> Edit Data Penawaran </h2>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th-list"></i> </h3>
            </div>
        	<div class="box-content">
        		
            <form action="index.php?page=penawaran/update.php&id=<?php echo $id; ?>" method="post" class="form-horizontal form-bordered form-validate" id="bb">
                <div class="modal-body">
                    <div class="control-group">
                        <label for="jurusan" class="control-label"> Prodi </label>
                        <div class="controls">
                            <select name="jurusan" id="data-jurusan" class='select2-me input-large' data-rule-required="true" data-placeholder="- Pilih Prodi -">
                                <option value=""> </option>
                            <?php
                                $query_jurusan = mysql_query("SELECT * From jurusan WHERE id_fakultas = '$fakultas'");
                                $b='';
                                while ($data=mysql_fetch_array($query_jurusan)) {
                                    ?>
                                     <option value='<?php echo $data[0]; ?>' <?php echo ($data[1] ==$dataedit['jurusan'])?'selected="Selected"':'';?>><?php echo $data[1]; ?></option>;
                                    <?php
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
                                <option value="1" <?php echo (1 ==$dataedit['semester'])?'selected="Selected"':'';?>> Ganjil </option>
                                <option value="2" <?php echo (2 ==$dataedit['semester'])?'selected="Selected"':'';?>> Genap </option>
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
                                    ?>

                                    <option value='<?php echo $thn;?>' <?php echo ($thn ==$dataedit['id_thn_ajar'])?'selected="Selected"':'';?>><?php echo $thn;?></option>";
                                    <?php
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
                                            ?>
                                             <option value='<?php echo $data[0];?>' <?php echo ($data[0] ==$dataedit['id_matkul'])?'selected="Selected"':'';?> > <?php echo $data[1]; ?></option>
                                            <?php
                                        }
                                ?>
                             </select>                    
                        </div>
                    </div>
                                                           
                    <div class="control-group">
                        <label for="kelas" class="control-label"> Kelas </label>
                        <div class="controls">
                            <select name="kelas" id="data-kelas" class="input-small opsi-kelas" data-rule-required="true" data-placeholder='-Pilih kls-'>                               <option value=""></option>
                                <?php
                                    for($i='A'; $i<='G'; $i++){
                                        ?>
                                        <option value='<?php echo $i; ?>'  <?php echo ($i ==$dataedit['Id_Kelas'])?'selected="Selected"':'';?>><?php echo $i; ?></option>
                                        <?php
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group" id='col-dosen'>
                        <label for="dosen" class="control-label"> Dosen Pengajar </label>
                        <div class="controls">
                            <select id="data-dosen" name="nip_dosen" class="select2-me input-xlarge" data-placeholder="-- Pilih Dosen --" data-rule-required="true">
                                <option value=""></option>
                                 <?php
                                        $qr_dosen = mysql_query("SELECT * FROM dosen");
                                        while ($data=mysql_fetch_array($qr_dosen)) {
                                            ?>
                                            <option value='<?php echo $data[1]; ?>'  <?php echo ($data[2] ==$dataedit['nama'])?'selected="Selected"':'';?>> <?php echo $data[2]; ?> </option>
                                            <?php
                                        }
                                ?>
                             </select>                    
                        </div>
                    </div>
                    
                    <div class="control-group" id="col-hari">
                        <label for="hari" class="control-label"> Hari </label>
                        <div class="controls">
                            <select name="hari" id="data-hari" class="input-small"  data-placeholder="-Pilih Hari-">
                                <option value=""></option>
                                <?php
                                    $hari = array("Minggu","Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
                                    //echo "<option value='$hari[1]'>$hari[1]</option>";
                                    for ($i=0; $i<count($hari); $i++) {
                                        ?>
                                        <option value='<?php echo $hari[$i] ?>' <?php echo ($hari[$i] ==$dataedit['hari'])?'selected="Selected"':'';?>><?php echo $hari[$i] ;?></option>
    
                                        <?php
                                    }
                                ?>
                            </select>
                            <input id='hidden-hari' name="hari" type="hidden" value="" disabled="disabled" />
                        </div>
                    </div>
                    
                    <?php 
                        
                    
                     function jamsatuancom($jamcompare,$jamxxx){
                        $jamsatuanxx=explode(",", $jamxxx);
                        
                        foreach ($jamsatuanxx as $key => $value) {
                            if($jamcompare == $value){
                                echo 'checked="checked"';
                            }else{
                                echo '';
                            }
                           
                        }
                     }

                    ?>
                    <div class="control-group" id="col-jam">
                        <label class="control-label"> Jam </label>
                        <div class="controls">
                            <div class="check-col" style="width:100px;float:left">
                                <label class='checkbox A'>
                                    <input id="A" type="checkbox" name="jam[]" value="A" <?php  jamsatuancom('A', $dataedit['jam']);?>> A [07:30]
                                </label>
                                <label class='checkbox B'>
                                    <input id="B" type="checkbox" name="jam[]" value="B" <?php  jamsatuancom('B', $dataedit['jam']);?> > B [08:30]
                                </label>
                                <label class='checkbox C'>
                                    <input id="C" type="checkbox" name="jam[]" value="C" <?php  jamsatuancom('C', $dataedit['jam']);?> > C [09:30]
                                </label>
                                <label class='checkbox D'>
                                    <input id="D" type="checkbox" name="jam[]" value="D" <?php  jamsatuancom('D', $dataedit['jam']);?>> D [10:30]
                                </label>
                                <label class='checkbox E'>
                                    <input id="E" type="checkbox" name="jam[]" value="E" <?php  jamsatuancom('E', $dataedit['jam']);?>> E [11:30]
                                </label>
                            </div>
                            <div class="check-col" style="width:100px;float:left">
                                <label class='checkbox F'>
                                    <input id="F" type="checkbox" name="jam[]" value="F" <?php  jamsatuancom('F', $dataedit['jam']);?> > F [12:30]
                                </label>
                                <label class='checkbox G'>
                                    <input id="G" type="checkbox" name="jam[]" value="G" <?php  jamsatuancom('G', $dataedit['jam']);?> > G [13:30]
                                </label>
                                <label class='checkbox H'>
                                    <input id="H" type="checkbox" name="jam[]" value="H" <?php  jamsatuancom('H', $dataedit['jam']);?> > H [14:30]
                                </label>
                                <label class='checkbox I'>
                                    <input id="I" type="checkbox" name="jam[]" value="I" <?php  jamsatuancom('I', $dataedit['jam']);?>> I [15:30]
                                </label>
                                <label class='checkbox J'>
                                    <input id="J" type="checkbox" name="jam[]" value="J" <?php  jamsatuancom('J', $dataedit['jam']);?> > J [16:30]
                                </label>
                            </div>
                            <div class="check-col" style="width:100px;float:left">
                                <label class='checkbox K'>
                                    <input id="K" type="checkbox" name="jam[]" value="K" <?php  jamsatuancom('K', $dataedit['jam']);?> > K [17:30]
                                </label>
                                <label class='checkbox L'>
                                    <input id="L" type="checkbox" name="jam[]" value="L"  <?php  jamsatuancom('L', $dataedit['jam']);?> > L [18:30]
                                </label>
                                <label class='checkbox M'>
                                    <input id="M" type="checkbox" name="jam[]" value="M" <?php  jamsatuancom('M', $dataedit['jam']);?> > M [19:30]
                                </label>
                                <label class='checkbox N'>
                                    <input id="N" type="checkbox" name="jam[]" value="N" <?php  jamsatuancom('N', $dataedit['jam']);?> > N [20:30]
                                </label>
                                <label class='checkbox O'>
                                    <input id="O" type="checkbox" name="jam[]" value="O" <?php  jamsatuancom('O', $dataedit['jam']);?> > O [21:30]
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="control-group" id='col-ruangan'>
                        <label for="ruangan" class="control-label"> Ruangan </label>
                        <div class="controls">
                            <select id="data-ruangan" name="ruangan" class="select2-me input-xlarge" data-placeholder="-- Pilih Ruangan --" >
                                <option value=""></option>
                                 <?php
                                        $qr_ruangan = mysql_query("SELECT * FROM ruangan");
                                        while ($data=mysql_fetch_array($qr_ruangan)) {
                                            ?>
                                            <option value='<?php echo $data[0] ?>'  <?php echo ($data[1] ==$dataedit['ruangan'])?'selected="Selected"':'';?>> <?php echo $data[1] ?></option>
                                            <?php
                                        }
                                ?>
                             </select>                    
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="keterangan" class="control-label"> Keterangan </label>
                        <div class="controls">
                            <textarea name="keterangan" id="keterangan" rows="4" class="input-block-level"> <?php echo $dataedit['keterangan']?></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a class="btn" href="index.php?page=penawaran/tampil.php">Batal</a>
                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
            </div>
          </form>
        	</div>
        </div>
    </div>
</div>

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>