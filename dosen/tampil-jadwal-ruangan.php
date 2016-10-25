<?php 
	if (isset($_SESSION['dosen_login'])) { 
	$jurusan = $_SESSION['jurusan_dosen'];
	$id_dosen = $_SESSION['id_dosen'];
	
	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar");

include 'edit-jadwal.php';
?>
<input id="id_jurusan" type="hidden" value="<?php echo $jurusan; ?>" />
<input id="id_admin" type="hidden" value="<?php echo $admin; ?>" />

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
                <h2> <i class="icon-reorder"></i> Jadwal 
                <select name="thn_ajar" id="thn_ajar" class="chosen-select input-small" data-placeholder="-- Pilih Semester/Tahun Ajar --">
                    	<option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($qr_thn_ajar)) {
									echo "<option value='$data[0]' data-semester=$data[1]> Semester $data[1] - $data[2] </option>";
								}
							?>
                    </select>
                    </h2>               
             </div>
             <div class="pull-right">
             	<div id="dwnload" style="float:left;padding-right:30px">
                	<a id="dwnload-excel" href=""><h2><i class="icon-download"></i></h2></a>
                </div>
        	</div>
        </div>
        <div>
        	<ul>
            	<li> Event Biru = Jadwal Setiap Minggu </li>
                <li> Event Hijau = Jadwal Satu Hari </li>
            </ul>
        </div>
        
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
                <h3 id="judul">  JADWAL RUANGAN  </h3> 
            </div>
        	<div class="box-content nopadding">
            	<div class="tabs-container"> 
                	<ul id="listRuangan" class="tabs tabs-inline tabs-left" style="height:792px;overflow:scroll"></ul>
                </div>
            	<div class="tab-content padding tab-content-inline"> 
                	<div id="calendar" class="tab-pane active"></div>
                    <div id="qrcode-generators" class="tab-pane" style="height:750px;width:935px">
                    	<div class="span5"> 
                        	<div class="control-group">
                            	<label for="rJurusan" class="control-label"> Pilih Ruangan </label>
								<div class="controls">
									<select multiple="multiple" id="rJurusan" name="rJurusan[]" class='multiselect ms-ruangan' data-selectionheader="Buat QR Code" data-selectableheader="Ruangan Jurusan">
									</select>
								</div>
							</div>
                            <div class="control-group">
								<label for="slider" class="control-label"> Ukuran (pixel)</label>
								<div class="controls">
									<div id='ukuran' class="slider" data-step="50" data-min="100" data-max="500">
										<div class="amount"></div>
										<div class="slide"></div>
									</div>
								</div>
							</div>
                        </div>
                        <div class="span7">
                            <div>
                            	<p > Hasil QR Code </p>
                                <a id="download" href="#"><button class="btn btn-primary qr">Download</button></a> 
                            	<button id="print" class="btn btn-primary qr">Print</button>
                            </div> 
                            <div id='container' style="height:700px;overflow:scroll"> </div>
                            <div class="hidden" id="print-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<script>
		$(document).ready(function() {
			var id_jurusan =  document.getElementById("id_jurusan").value;
			var listHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
			var listJamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"]; 
			var sks; 
			
			$('#dialog').dialog({autoOpen:false});
			$('#dialog').droppable();
			$('.qr').prop('disabled', true);
			
			// Mendapatkan list Ruangan kelas
			getRuangan('list', id_jurusan);
			getRuanganFakultas(id_jurusan);
			getRuangan('multiselect', id_jurusan);
			
			//$('#input-jadwal').hide();
			$('#dwnload-excel').hide();
			
			$('#thn_ajar').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_ruangan = $("#listRuangan .active a").data('identity');
				$('#idThnAjar').val(id);
				getJadwalRuangan(id_ruangan,id,'event');
				if (id_ruangan != null) {$('#input-jadwal').show();}
			});
			 
			// Memilih Ruangan
			$('#listRuangan').on('click', 'a', function() {
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var idRuangan = $(this).data('identity');
				var id_ruangan = $(this).data('id');
				
				$('#judul').empty();
				$('#judul').append("JADWAL RUANGAN " + idRuangan);
				$('#idRuangan').val(id_ruangan);
				console.log(idRuangan);
				if (id == "" && idRuangan != 'edit-list' && idRuangan != 'qrCode') { 
					console.log(idRuangan);
					alert("Pilih Semester dan Tahun ajar"); 
				} else if (idRuangan != 'edit-list' && idRuangan != 'qrCode'){ 
					//$("#input-jadwal").show();
					$('#dwnload-excel').show();
					getJadwalRuangan(idRuangan,id,'event');
				} else  {
					$('#input-jadwal').hide();
				} 
			});
			
			// Ruangan UMUM
				$('#ubah').on('change', '#Aktivitas', function(){
					if ($('#listRuangan .active a').data('status') === "Umum"){
						var aktivitas = $('#Aktivitas').val();
						$('#Aktivitas').val(aktivitas + "/" + id_jurusan);
					}
				});
			
			//download excel
			$('#dwnload-excel').click(function(event){
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_ruangan = $("#listRuangan .active a").data('id');
				event.preventDefault();
				window.location = '/classroom_schedules/jadwal/dwnload-excel.php?smt=' + id + '&ruangan=' + id_ruangan;
			});
// ================== Membuat tampilan kalender ========================= ///
			$('#calendar').fullCalendar({
				header: {
				left: 'month,agendaWeek,agendaDay',
				center: 'title',
				right: 'prev,next today'
				},
				defaultView: 'agendaWeek',
				selectable: false,
				selectHelper : false,
				eventStartEditable : false,
				eventOverlap : false,
				allDaySlot : false,
				slotDuration: '00:30:00',
				eventLimit: true, // allow "more" link when too many events
				axisFormat: 'HH:mm',
				minTime: "07:30:00",
				maxTime: "23:30:00",
				select : function(start, end) {
					var menit = start.format('mm');
					if (menit == '30') {
						var id_thnAjar = thn_ajar.options[thn_ajar.selectedIndex].value;
						var id_ruangan = $("#listRuangan .active a").data('identity');
						
						if (id_thnAjar != null && id_ruangan != null) {
							var date = new Date(moment(start).format());
							var hari = listHari[date.getDay()];
							var tanggal = moment(start).format('MM/DD/YYYY');
							var jam = getJamAwal(moment(start).format('HH:mm:ss'));
							var jamGaBoleh = $.grep(listJamKul, function(n,i) {return i < $.inArray(jam, listJamKul);});
							
							getKelas('option', id_jurusan);
							cekJadwalKelas(hari, jam);
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
						var ruangan = $("#listRuangan .active a").data('id');
						var id_admin = $('#id_admin').val();
					
						var dataHistory = JSON.stringify({'id_jadwal':calEvent.id, 
														  'id_admin':id_admin,
														  'kegiatan':kegiatan,  
														  'tanggal':tgl, 
														  'id_ruangan':ruangan,
														  'id_aktivitas':calEvent.id_aktivitas,
														  'id_kelas':calEvent.id_kelas,
														  'id_dosen':calEvent.id_dosen, 
														  'hariJadwal':hari, 
														  'jamJadwal':jam, 
														  'tglJadwal':tanggal });
						//console.log(dataHistory);
						updateHistory(dataHistory);
						deleteJadwal(calEvent.id,'ruangan');						
					});

				},
				eventDragStart : function(calEvent, jsEvent, ui, view) {
					console.log("Di Drag Coy");
					var id_thnAjr = thn_ajar.options[thn_ajar.selectedIndex].value;
					var kls = calEvent.title.split('/');
					//$('#dialog').dialog('open');
					
					
					getJadwalKelas(kls[1],id_thnAjr,id_jurusan,'background');
					if (calEvent.id_dosen != '00000') {
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
						var ruangan = $("#listRuangan .active a").data('id');
						var id_admin = $('#id_admin').val();
						var kegiatan = 'Edit Jadwal';
						var dataHistory = JSON.stringify({'id_jadwal':calEvent.id, 
														  'id_admin':id_admin,
														  'kegiatan':kegiatan,  
														  'tanggal':tgl, 
														  'id_ruangan':ruangan,
														  'id_aktivitas':calEvent.id_aktivitas,
														  'id_kelas':calEvent.id_kelas,
														  'id_dosen':calEvent.id_dosen, 
														  'hariJadwal':hari, 
														  'jamJadwal':jam, 
														  'tglJadwal':tanggal });
														  
						updateJadwal(calEvent.id, data);
						updateHistory(dataHistory);
					} else {
						revertFunc();
					}	
					if ($('#listRuangan .active a').data('status') === "Umum") {
						var jur = calEvent.title.split('/');
						if(jur[1] != id_jurusan) {
							revertFunc();
						}
					}
				},
			});
			
			// ========= Bagian Input ============ //
			opsiHari();
			
			$('#j_aktivitas').on('change', function() {
				var penawaran = $("#thn_ajar option:selected").data('semester');
				listMatkul("j_aktivitas",id_jurusan,penawaran);
			});
			
			$('#input').on('click', 'a', function(e){
				clearModal('#modal-1');
				
				getKelas('option', id_jurusan);
				$('#col-hari').hide();
				$('#col-tanggal').hide();
				$('#col-jam').hide();
				$('#col-dosen').hide();
				$('#dosen').data('rule-required',false);
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
				var id_ruangan = $('#idRuangan').val();
				var id_kelas = $('#kelas option:selected').val();
				var hari = $('#hari').val();
				setCheckbox(id_ruangan, id_kelas, hari);
			});
			
			$('#kelas').change(function() {
				var id_ruangan = $('#idRuangan').val();
				var id_kelas = $('#kelas option:selected').val();
				var hari = $('#hari').val();
				setCheckbox(id_ruangan, id_kelas, hari);
			}); 
			
			$(document).on('change','#Aktivitas',function() {
				sks = $('#Aktivitas option:selected').data('sks');
				var counter = 1; 
				$('#col-jam input:checkbox').change(function() {
					var id_ruangan = $('#idRuangan').val();
					var id_kelas = $('#kelas option:selected').val();
					var hari = $('#hari').val();
				
					cekSks(sks, counter, id_ruangan, id_kelas, hari);
					counter++; 
				});
			});
			
		// =============== Bagian Membuat QR Code ===================//
			var listRuangan = []; 
			var idRuangan = [];
			$('#rJurusan :selected').each(function(i,selected){listRuangan[i] = $(selected).text();});
			idRuangan = $('#rJurusan').val();
			$('#ukuran').slider({value:200});
			
			$('#rJurusan').change(function(){
				$('.qr').prop('disabled', false);
				var listPilihan = [];
				var idPilihan = [];
				$('#rJurusan :selected').each(function(i,selected){listPilihan[i] = $(selected).text();});
				idPilihan = $('#rJurusan').val();
				
				if (listPilihan.length > listRuangan.length) {
					var ruangan = $.grep(listPilihan, function(el) {return $.inArray(el, listRuangan) == -1;});
					var id = 'ruangan' + $.grep(idPilihan, function(el) {return $.inArray(el, idRuangan) == -1;});
					
					console.log('Buat QR Code Ruangan '+ ruangan);
					var text = ruangan.toString();
					var ukuran = $('#ukuran').slider('option','value');
					
					$('#container').append('<a class="kodeQR" id="'+id+'" style="float:left"></a');
					var el = document.getElementById(id);
					generateQRCode(id,text,ukuran);
					setLink(el, id, text);			

					listRuangan = listPilihan;
					idRuangan = idPilihan;
				} else {
					var ruangan = $.grep(listRuangan, function(el) {return $.inArray(el, listPilihan) == -1;});
					var id = $.grep(idRuangan, function(el) {return $.inArray(el, idPilihan) == -1;});
					console.log('Hapus QR Code Ruangan '+ ruangan);
					
					$('#ruangan'+id).remove();
					
					listRuangan = listPilihan;
					idRuangan = idPilihan;
				}
			});
			
			$('#ukuran').slider({
				change : function(event, ui) {
					for (var i=0; i < idRuangan.length; i++) {
						console.log('id ruangan : '+ idRuangan[i]+', Nama Ruangan : '+ listRuangan[i]+', ukuran :'+ ui.value);
						var id = 'ruangan'+idRuangan[i];
						generateQRCode(id,listRuangan[i],ui.value);
					}
				}
			});
				
			$('a#download').click(function() {
				var zip = new JSZip();
				for(var i =0; i < idRuangan.length; i++) {
					var QRCode = $('#ruangan'+idRuangan[i]).attr('href');
					
					zip.file(listRuangan[i]+'.png', QRCode.substring(QRCode.indexOf(',')+1), {base64: true});	
					var content = zip.generate();
				}
				
				this.href = window.URL.createObjectURL(zip.generate({type:"blob"}));
				this.download = 'QRCode.zip';
				//return false;		
			});
				
			$('button#print').on('click', function(){
				var canvas = $('canvas');
				var img = [];
				for (var i = 0; i < canvas.length; i++){
					//console.log(canvas[i]);
					img[i] = canvas[i].toDataURL("image/png");
					$('#print-container').append('<img src="'+img[i]+'"/>');	
				}
	
				var printcontent = $('#print-container').html();
				var myWindow = window.open('', 'Print QRCode', 'height=800,width=1200');
				myWindow.document.write('<html><head><title>Print QRCode</title>');
				myWindow.document.write('<style>img{float:left; padding:5px;}</style>');
				myWindow.document.write('</head><body>');
				myWindow.document.write(printcontent);
				myWindow.document.write('</body></html>');
				
				myWindow.document.close(); // perlu pada IE >= 10
        		myWindow.focus(); // perlu pada IE >= 10
				
				myWindow.print();
       			myWindow.close();
				
				$('#print-container').empty();
       			return true; 
			});
			
		});	
			
    </script>
    
<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>
