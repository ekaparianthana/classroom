<?php 
	if ((isset($_SESSION['userlogin'])) && ($_SESSION['hak'] == 1)) { 
	$fakultas = $_SESSION['fakultas'];
	$admin = $_SESSION['user_id'];
	$query = mysql_query("SELECT jenis_aktivitas, nama_aktivitas, id_aktivitas FROM aktivitas 
						INNER JOIN jenis_aktivitas USING(id_jenis_aktivitas) 
						WHERE id_jurusan='$fakultas' 
						ORDER BY nama_aktivitas ASC");
	$qr_jurusan = mysql_query("SELECT * FROM jurusan WHERE id_fakultas = '$fakultas' ORDER BY id_jurusan");
	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar, smt");
	$qr_aktivitas = mysql_query("SELECT * FROM jenis_aktivitas ORDER BY jenis_aktivitas ASC");
	$qr_dosen = mysql_query("SELECT * FROM dosen");	

include 'edit-jadwal.php';
?>
<input id="id_fakultas" type="hidden" value="<?php echo $fakultas; ?>" />
<input id="id_admin" type="hidden" value="<?php echo $admin; ?>" />

<div id="modal-file" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
	<form action="index.php?page=jadwal/simpan-file.php" method="post" class="form-horizontal form-bordered form-validate" enctype="multipart/form-data" >
   	 	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Tambah Jadwal Dari File CSV</h3>
		</div>
    	<div class="modal-body">
                        <input type="hidden" name="idTahunAjar" id="idTahunAjar" value="" />
                		<input type="hidden" name="page" id="page" value="kelas"  />
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

<div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">Tambah Jadwal</h3>
			</div>
            <form action="index.php?page=jadwal/simpan-jadwal.php&id=kelas" method="post" class="form-horizontal form-bordered form-validate" id="bb">
            	<input type="hidden" name="idThnAjar" id="idThnAjar" value="" />
                <input type="hidden" name="kelas" id="kelas" value=""  />
				<div class="modal-body">
                	<div class="control-group">
                		<label for="j_aktivitas" class="control-label"> Jenis Aktivitas </label>
                    	<div class="controls">
                    		<select name="j_aktivitas" id="j_aktivitas" class='input-large' data-rule-required="true" data-placeholder="- Pilih Jenis Aktivitas -">
                            	<option value="">- Pilih Jenis Aktivitas </option>
                            <?php
								while ($data=mysql_fetch_array($qr_aktivitas)) {
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
                    <div class="control-group" id="col-dosen">
                		<label for="dosen" class="control-label"> Dosen Pengajar </label>
                    	<div class="controls">
                        	<select id="dosen" name="dosen" class="select2-me input-xlarge" data-placeholder="-- Pilih Dosen --" data-rule-required="true">
                    			<option value=""></option>
                        		 <?php
										while ($data=mysql_fetch_array($qr_dosen)) {
											echo "<option value='$data[1]'> $data[2]</option>";
										}
								?>
                   			 </select>                    
                        </div>
                	</div>
                    <div class="control-group">
                    	<label for="idRuangan" class="control-label"> Ruangan </label>
                        <div class="controls">
                    		<select name="idRuangan" id="idRuangan" class="choosen-select input-large" data-rule-required="true">
                            <option value=""></option>
                            </select>
                    	</div>
                    </div>
                     <div class="control-group">
                    	<label class="control-label"> Repetisi </label>
                        <div class="controls">
                    		<div class"radio-col" style="width:90px;float:left">
                            	<label class='radio'><input type="radio" name="repetisi" value="0" data-rule-required="true"> Satu Hari </label>
                            </div>
                            <!--<div class"radio-col" style="width:100px;float:left">
                            	<label class='radio'><input type="radio" name="repetisi" value="1" data-rule-required="true"> Setiap Hari </label>
                            </div>-->
                            <div class"radio-col" style="width:120px;float:left">
                            	<label class='radio'><input type="radio" name="repetisi" value="2" data-rule-required="true"> Setiap Minggu </label>
                            </div>
                    	</div>
                    </div>
                    <div class="control-group" id="col-hari">
                    	<label for="hari" class="control-label"> Hari </label>
                        <div class="controls">
                    		<select name="hari" id="hari" class="choosen-select input-small" data-rule-required="true" data-placeholder="-Pilih Hari-">
                            <option value=""></option>
                            <input id="hidden-hari" type="hidden" name="hari" value="" disabled="disabled" />
                            </select>
                    	</div>
                    </div>
                    <div class="control-group" id="col-tanggal">
                    	<label for="tanggal" class="control-label"> Tanggal </label>
                        <div class="controls">
                    		<input type="text" name="tanggal" id="tanggal" class="input-medium datepick">
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
                    <div class="control-group">
                    	<label for="keterangan" class="control-label"> Keterangan </label>
                        <div class="controls">
                    		<textarea name="keterangan" id="keterangan" rows="4" class="input-block-level"> </textarea>
                    	</div>
                    </div>
			</div>
			<div class="modal-footer">
            	<div class="pull-left">
            		<a href="#modal-file" id="btn-file"  data-toggle="modal" data-dismiss="modal" class="btn btn-primary">Dari File CSV</a>
                </div>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
			</div>
          </form>
</div>

<div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:400px">
	<form action="#" method="post" class="form-horizontal form-bordered form-validate" id="bb">
   	 	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Edit List Kelas</h3>
		</div>
    	<div class="modal-body">
        	<div class="control-group" id='input-kelas'>
                <label for="tambah-kelas" class="control-label"> Tambah Kelas </label>
                <div class="controls">                   	
                	<input name="tambah-kelas" id="tambah-kelas" class='input-small' data-rule-required="true"  data-rule-maxlength="3" style="text-transform:uppercase"/>
                    <button class="btn btn-primary" id='simpan-kelas' aria-hidden="true">Simpan</button>
                 </div>                	
             </div>
             <div class="control-group" id='delete-kelasContainer'>
                <label for="hapus-kelas" class="control-label"> Hapus Kelas </label>
                  	<div class="controls">                   	
                  		<select name="hapus-kelas" id="hapus-kelas" class='choosen-select input-small opsi-kelas' data-rule-required="true"  data-placeholder="-Pilih Kelas-">
                        <option value=''></option>
                        </select>
                        <button class="btn btn-primary" id='delete-kelas' aria-hidden="true" disabled="disabled">Hapus</button>
                     </div>                	
             </div>
    	</div>
    	<div class="modal-footer">
    	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Kembali</button>
		</div>
	</form>
</div>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
                <h2> <i class="icon-reorder"></i> Jadwal Kelas 
                    </h2>
                    
                    <select name="jurusan" id="jurusan" class="chosen-select input-small" data-placeholder="-- Pilih Jurusan --">
                    	<option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($qr_jurusan)) {
									echo "<option value='$data[0]' data-jurusan=$data[0]> $data[1] </option>";
								}
							?>
                    </select>
                    <br />
                    <select name="semester" id="semester" class="chosen-select input-small" data-placeholder="-- Pilih Semester --">
                    	<option value=""></option>
                        <option value="1">Ganjil</option>
                        <option value="2">Genap</option>
                    </select>
                    <br />
                     <select name="tahun" id="tahun" class="chosen-select input-small" data-placeholder="-- Pilih Tahun Ajaran --">
                    	<option value=""></option>
                            <?php
								$thn_now=(integer)date("Y");
								for ($thn=$thn_now-1; $thn<=($thn_now+1); $thn++) {
									echo "<option value='$thn'>$thn</option>";
								}
							?>
                    </select>               
             </div>
            <div class="pull-right">
            	<div id="dwnload" style="float:left;padding-right:30px">
                	<a id="dwnload-excel" href=""><h2><i class="icon-download"></i></h2></a>
                </div>
        		<div id="input" style="padding-right:50px;float:right">
                	<a id="input-jadwal" href="#modal-1" data-toggle="modal"> <h2> <i class="icon-plus-sign"></i></h2> </a>
                </div>
        	</div>
        </div>
        <div>
        	<ul>
            	<li> Kotak merah = Ruangan sudah terpakai pada jam tersebut</li>
                <li> Kotak kuning = Dosen sudah mempunyai jadwal pada jam tersebut</li>
                <li> Event Biru = Jadwal Setiap Minggu </li>
                <li> Event Hijau = Jadwal Satu Hari </li>
            </ul>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
                <h3 id="judul">  JADWAL KELAS  </h3> 
            </div>
        	<div class="box-content nopadding">
            	<div class="tabs-container"> 
                	<ul id="listKelas" class="tabs tabs-inline tabs-left" style="height:792px;overflow-y:scroll"><li><a href="#">Pilih Semester/Thn Ajar</a></li></ul>
                </div>
            	<div class="tab-content padding tab-content-inline"> <div id="calendar"></div></div>
            </div>
        </div>
    </div>
</div>

	<script>
		$(document).ready(function() {
			var rootURL = "/classroom_schedules/api/";
			var id_fakultas =  document.getElementById("id_fakultas").value;
			var listHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
			var listJamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"]; 
			
			$('#input-jadwal').hide();
			$('#dwnload-excel').hide();
			
			/*
			$('#thn_ajar').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				getKelas('list', id_jurusan);
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_kelas = $("#listKelas .active a").data('identity');
				$('#idThnAjar').val(id);
				$('#idTahunAjar').val(id);
				getKelas('option', id_jurusan);
				$('#dwnload-excel').show();
				$('#input-jadwal').attr("href","#modal-file");
				$('#input-jadwal').show();
			}); */
			
			// Mendapatkan list kelas
			$('#jurusan').change(function() {
				var jur =  document.getElementById("jurusan");
				var jurusan = jur.options[jur.selectedIndex].value;
				var smt = document.getElementById("semester");
				var semester = smt.options[smt.selectedIndex].value;
				var thn = document.getElementById("tahun");
				var tahun = thn.options[thn.selectedIndex].value;
				
				if ((tahun != null) && (semester != null)) {getKelas('list', jurusan,tahun, semester);}
				$('#calendar').fullCalendar('removeEvents');
			});
			
			$('#semester').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				var jur =  document.getElementById("jurusan");
				var jurusan = jur.options[jur.selectedIndex].value;
				var smt = document.getElementById("semester");
				var semester = smt.options[smt.selectedIndex].value;
				var thn = document.getElementById("tahun");
				var tahun = thn.options[thn.selectedIndex].value;
				
				if ((jurusan != null) && (tahun != null)) {getKelas('list', jurusan,tahun, semester);}
				
			});
			
			$('#tahun').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				var jur =  document.getElementById("jurusan");
				var jurusan = jur.options[jur.selectedIndex].value;
				var smt = document.getElementById("semester");
				var semester = smt.options[smt.selectedIndex].value;
				var thn = document.getElementById("tahun");
				var tahun = thn.options[thn.selectedIndex].value;
				
				if ((jurusan != null) && (semester != null)) {getKelas('list', jurusan,tahun, semester);}
				
			});
			 
			// Memilih Kelas
			$('#listKelas').on('click', 'a', function() {
				var jur =  document.getElementById("jurusan");
				var jurusan = jur.options[jur.selectedIndex].value;
				var smt = document.getElementById("semester");
				var semester = smt.options[smt.selectedIndex].value;
				var thn = document.getElementById("tahun");
				var tahun = thn.options[thn.selectedIndex].value;
				var idKelas = $(this).data('identity');
				var id_kelas = $(this).data('id');
				
				$('#kelas').val(id_kelas); // id kelas untuk simapn from form
				$('#idKelas').val(id_kelas); //id kelas untuk di simpan from file
				$('#judul').empty();
				$('#judul').append("JADWAL KELAS " + idKelas);
				
				if (jurusan == "" && semester == "" && idKelas != 'edit-list') { 
					alert("Pilih Semester dan Tahun ajar"); 
				} else if (idKelas != 'edit-list' && idKelas != 'laporan'){
					console.log(idKelas);
					$('#input-jadwal').attr("href","#modal-1"); 
					$("#input-jadwal").show();
					$('#dwnload-excel').show();
					getJadwalKelas(idKelas,semester,tahun,jurusan,'event');
				}  else if (idKelas == 'laporan') {
					window.location = '/classroom_schedules/jadwal/dwnload-excel.php?smt=' + id;
				}
			});
			
			//download excel
			$('#dwnload-excel').click(function(event){
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_kelas = $("#listKelas .active a").data('id');
				event.preventDefault();
				window.location = '/classroom_schedules/jadwal/dwnload-excel.php?smt=' + id + '&data=jadwal';
			});
			
			// Membuat tampilan kalender
			$('#calendar').fullCalendar({
				header: {
				left: 'month,agendaWeek,agendaDay',
				center: 'title',
				right: 'prev,next today'
			},
			//defaultDate: '2015-02-12',
			defaultView: 'agendaWeek',
			selectable: true,
			selectHelper : true,
			eventStartEditable : true,
			eventOverlap : false,
			eventLimit: true, // allow "more" link when too many events
			axisFormat: 'HH:mm',
			minTime: "07:30:00",
			maxTime: "23:00:00",
			select : function(start, end) {
					var menit = start.format('mm');
					if (menit == '30') {
						var id_thnAjar = thn_ajar.options[thn_ajar.selectedIndex].value;
						var id_kelas = $("#listKelas .active a").data('identity');
						
						if (id_thnAjar != null && id_kelas != null) {
							var date = new Date(moment(start).format());
							var hari = listHari[date.getDay()];
							var tanggal = moment(start).format('MM/DD/YYYY');
							var jam = getJamAwal(moment(start).format('HH:mm:ss'));
							var jamGaBoleh = $.grep(listJamKul, function(n,i) {return i < $.inArray(jam, listJamKul);});
							
							getRuangan('option', id_jurusan);
							cekJadwalKelas(hari, jam, id_thnAjar);
							clearModal('#modal-1');

							$('#col-hari').hide();
							$('#col-tanggal').hide();
							$('#col-jam').hide();
							$('#col-dosen').hide();
							$('#dosen').data('rule-required', false);
							
							$('#hari').prop({value:hari,disabled:true});
							$('#hidden-hari').prop({value:hari, disabled:false});
							$('#tanggal').prop({value:tanggal, readonly:true});
							
							$('#'+jam).addClass('jamSet');
							$('#'+jam).prop({readonly:true, checked:true});
							$('#'+jam).on('click', function(){return false});
							
							$.each(jamGaBoleh, function(index, value) {
								$('#'+value).prop('disabled',true);
							});	
														
							$('#modal-1').modal('show');
						
						} else {
							$('#calendar').fullCalendar('unselect');
						}
					} else {
						console.log('Ga bisa disini cuy');
						$('#calendar').fullCalendar('unselect');
					}
				},
			eventClick: function(calEvent, jsEvent, view) {
					$(this).popover({
						html		: true,
						container 	: 'body',
						trigger 	: 'focus',
						placement	: function() {
										var hari = new Date(moment(calEvent.start).format('YYYY/MM/DD'));
										return (hari.getDay()) < 4 ? 'right' : 'left';
										},
						title		: function() {
										return $('#popover-head').html();
										},
						content		: function() {
										return $('#popover-content').html();
										},
					});
					$(this).popover('toggle');
					//$('input#edit-nama-aktivitas').val("tes coy");					
					getJadwalById(calEvent.id);
					
					$('.popover #btn-edit-keterangan').click(function() {
						
						var data = JSON.stringify({'keterangan' : $('.popover #edit-keterangan').val()});
						updateKeterangan(calEvent.id,data);
						
						return false;
					});
					
					$('a#btn-hapus-aktivitas').click(function() {
						$('p#pertanyaan').empty();
						$('p#pertanyaan').append(document.createTextNode('Anda yakin ingin menghapus jadwal '+calEvent.title+'?'));
						this.href = '#modal-3';
					});
					
					$('button#btn-hapus-jadwal').click(function() {
						var getHari = new Date(moment(calEvent.start).format('YYYY/MM/DD'));
						var tanggal = calEvent.start.format('YYYY-MM-DD');
						var hari = listHari[getHari.getDay()];
						var jamMulai = calEvent.start.format('HH:mm:ss');
						var jamSelesai = calEvent.end.format('HH:mm:ss');
						var jam = getJam(jamMulai, jamSelesai);
						
						var kegiatan = 'Hapus Jadwal';
						var tgl = moment().format('YYYY-MM-DD HH:mm:ss');
						var kelas = $('#listKelas .active a').data('id');
						var id_admin = $('#id_admin').val();
					
						var dataHistory = JSON.stringify({'id_jadwal':calEvent.id, 
														  'kegiatan':kegiatan,  
														  'tanggal':tgl, 
														  'id_ruangan':calEvent.id_ruangan,
														  'id_aktivitas':calEvent.id_aktivitas,
														  'id_kelas': kelas,
														  'id_dosen':calEvent.id_dosen,
														  'hariJadwal':hari, 
														  'jamJadwal':jam, 
														  'tglJadwal':tanggal });
						//console.log(dataHistory);
						updateHistory(dataHistory);
					
						deleteJadwal(calEvent.id,'kelas');						
					});

				},
				eventDragStart : function(calEvent, jsEvent, ui, view) {
					console.log("Di Drag Coy");
					var id_thnAjr = thn_ajar.options[thn_ajar.selectedIndex].value;
					var ruangan = calEvent.title.split('/');
			
					getJadwalRuangan(ruangan[1],id_thnAjr,'background');
					if(calEvent.id_dosen != '00000') {
						getJadwalDosen(calEvent.id_dosen,id_thnAjr,'background');
					}
				},
				eventDragStop : function(calEvent, jsEvent, ui, view) {
				
					$('#calendar').fullCalendar('removeEvents', isBackground);
				},
				eventDrop : function(calEvent, delta, revertFunc, jsEvent, ui, view) {
					//console.log('Aktivitas di pindahkan ke '+ calEvent.start.format('YYYY-MM-DD'));
					var menit = calEvent.start.format('mm');
					if (menit == '30') {
						var getHari = new Date(moment(calEvent.start).format('YYYY/MM/DD'));
						var tanggal = calEvent.start.format('YYYY-MM-DD');
						var hari = listHari[getHari.getDay()];
						var jamMulai = calEvent.start.format('HH:mm:ss');
						var jamSelesai = calEvent.end.format('HH:mm:ss');
						var jam = getJam(jamMulai, jamSelesai);
						var data = JSON.stringify({'tanggal':tanggal,'hari':hari,'jam':jam});
						
						var tgl = moment().format('YYYY-MM-DD HH:mm:ss');
						var kelas = $('#listKelas .active a').data('id');
						var id_admin = $('#id_admin').val();
						var kegiatan = 'Edit Jadwal';
						var dataHistory = JSON.stringify({'id_jadwal':calEvent.id, 
														  //'id_admin':id_admin,
														  'kegiatan':kegiatan,  
														  'tanggal':tgl, 
														  'id_ruangan':calEvent.id_ruangan,
														  'id_aktivitas':calEvent.id_aktivitas,
														  'id_kelas': kelas,
														  'id_dosen':calEvent.id_dosen, 
														  'hariJadwal':hari, 
														  'jamJadwal':jam, 
														  'tglJadwal':tanggal });
														  
						updateJadwal(calEvent.id, data);
						updateHistory(dataHistory);
					} else {
						revertFunc();
					}	
				},
			});
			
			// ========= Bagian Input ============ //
			opsiHari();
			$('#file').change(function(){
				$('#btnFile').prop('disabled',false);
			});
			
			$('#j_aktivitas').change(function() {
				var penawaran = $("#thn_ajar option:selected").data('semester');
				listMatkul("j_aktivitas",id_jurusan,penawaran);
			});
			
			$('#input').on('click', 'a', function(){
				clearModal('#modal-1');
				getRuangan('option',id_jurusan);
				$('#col-hari').hide();
				$('#col-tanggal').hide();
				$('#col-jam').hide();
				$('#col-dosen').hide();
				$('#dosen').data('rule-required', false);
			});
			
			$("input[name='repetisi']").change(function(){
				var check = $("input[name='repetisi']:checked");
				if(check.val() == 0){
					$('#col-hari').hide();
					$('#col-tanggal').show();
					$('#col-jam').show();
				} else 
				if(check.val() == 2) {
					$('#col-tanggal').hide();
					$('#col-hari').show();
					$('#col-jam').show();
				}
			});
			
			$('#hari').change(function(){
				var id_kelas = $('#kelas').val();
				var id_ruangan = $('#idRuangan option:selected').val();
				var hari = $('#hari').val();
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				setCheckbox(id_ruangan, id_kelas, hari, id);
			});
			
			$('#tanggal').change(function() {
				var id_kelas = $('#kelas').val();
				var id_ruangan = $('#idRuangan option:selected').val();
				var date = $('#tanggal').val().split("/");
				var getHari = new Date(Number(date[2]), Number(date[0]) - 1, Number(date[1]));
				var	hari = listHari[getHari.getDay()];
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				setCheckbox(id_ruangan, id_kelas, hari,id);
			});
			
			$('#idRuangan').change(function() {
				var id_kelas = $('#kelas').val();
				var id_ruangan = $('#idRuangan option:selected').val();
				var hari = $('#hari').val();
				if ($('#hari').is(':hidden')) {
					var date = $('#tanggal').val().split("/");
					var getHari = new Date(Number(date[2]), Number(date[0]) -1, Number(date[1]));
					hari = listHari[getHari.getDay()];
				} else {
					hari = $('#hari').val();
				} 
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				setCheckbox(id_ruangan, id_kelas, hari, id);
			});
						
			$(document).on('change','#Aktivitas',function() {
				var sks = $('#Aktivitas option:selected').data('sks');
				var counter = 1; 
				$('#col-jam input:checkbox').change(function() {
					var id_kelas = $('#kelas').val();
					var id_ruangan = $('#idRuangan option:selected').val();
					var hari = $('#hari').val();
				
					cekSks(sks, counter, id_ruangan, id_kelas, hari);
					counter++; 
				});
			});
			
			$('#hapus-kelas').change(function() {
				var kelas = $('#hapus-kelas option:selected').text();
				if ( kelas == '-' || kelas == "") {
					$('#delete-kelas').prop('disabled',true);
				} else {
					$('#delete-kelas').prop('disabled',false);
				}
			});
			
			$('#simpan-kelas').click(function() {
				var kelas = $('#tambah-kelas').val().toUpperCase();
				
				if(kelas == "") {
					$('#input-kelas span').remove();
					$('#input-kelas').append('<span style="color:red">This field required. </span>');
				} else {
					$.ajax({
						type	: 'GET',
						url		: rootURL + '/cek/' + kelas + '/' + id_jurusan,
						dataType: "json",
						success	: function(data, textStatus, jqXHR){
									var cek = data == false ? true : false;
									console.log(cek);
									if(cek) {
										simpanKelas(kelas, id_jurusan);
									} else {
										$('#input-kelas span').remove();
										$('#input-kelas').append('<span style="color:red">Kelas '+ kelas +' sudah ada. </span>');
									}
						  		  }
					});
				}
				
				return false;
			});
			
			$('#delete-kelas').click(function() {
				var id_kls = $('#hapus-kelas option:selected').val();
				hapusKelas(id_kls,id_jurusan);
				return false;
			});
			
			$(document).on('hide', function(e) {
				var target = $(e.target);
				target.removeData('modal').find('.modal-content').html('');
			}); 
			
		});	
    </script>
    
<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>
