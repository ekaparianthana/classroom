<?php 
	if (isset($_SESSION['dosen_login'])) { 
	$jurusan = $_SESSION['jurusan_dosen'];
	$id_dosen = $_SESSION['id_dosen'];
	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar");
	$qr_dosen = mysql_query("SELECT * FROM dosen WHERE id_jurusan = '$jurusan'");

include 'edit-jadwal.php';
?>
<input id="id_jurusan" type="hidden" value="<?php echo $jurusan; ?>" />
<input id="id_dosen" type="hidden" value="<?php echo $id_dosen; ?>" />

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
                <h2> <i class="icon-reorder"></i> Jadwal Dosen </h2>               
             </div>
        </div>
        <div class="box box-color box-bordered">
        	<div class="box-title">
            	<h3> <i class="icon-th"></i> </h3>
                <ul class="tabs tabs-left"> 
                	<li>
                	<select name="thn_ajar" id="thn_ajar" class="select2-me" data-placeholder="-- Pilih Semester/Tahun Ajar --">
                    	<option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($qr_thn_ajar)) {
									echo "<option value='$data[0]' data-semester=$data[1]>Semester $data[1]-$data[2]</option>";
								}
							?>
                    </select>
                    </li>
                    <li>
                    <select id="pilih-dosen" name="pilih-dosen" class="select2-me input-xlarge" data-placeholder="-- Pilih Dosen --">
                    	<option value=""></option>
                         <?php
								while ($data=mysql_fetch_array($qr_dosen)) {
									echo "<option value='$data[0]'> $data[1]</option>";
								}
							?>
                    </select>
                    </li>
                </ul>
            </div>
        	<div class="box-content padding">
            	<div class="tab-content padding">
                	<div id="calendar" class="tab-pane active"></div>
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
			
			
			$('#thn_ajar').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_dosen = $("#pilih-dosen option:selected").val();
				//$('#idThnAjar').val(id);
				getJadwalDosen(id_dosen,id,'event');
				//if (id_ruangan != null) {$('#input-jadwal').show();}
			});
			
			//Memilih Dosen
			 $('#pilih-dosen').on('change', function(){
			 	var thn_ajar = $('#thn_ajar option:selected').val();
				var dosen = $('#pilih-dosen option:selected').val();
				
				if (thn_ajar == '') {alert("Pilih Semester dan Tahun Ajar!");}
				else {getJadwalDosen(dosen,thn_ajar,'event');}
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
				eventRender: function(calEvent, element) {
					element.find('.fc-title').append('<br/><br/>' + "Ruangan " + calEvent.ruangan);
				},
				select : function(start, end) {
					var menit = start.format('mm');
					if (menit == '30') {
						var id_thnAjar = thn_ajar.options[thn_ajar.selectedIndex].value;
						var id_ruangan = $("#listRuangan .active a").data('identity');
						
						if (id_thnAjar != null && id_ruangan != null) {
							var date = new Date(moment(start).format());
							var hari = listHari[date.getDay()];
							var tanggal = moment(start).format('MM/DD/YYYY');
							var jam = getJamAwal(moment(start).format('hh:mm:ss'));
							var jamGaBoleh = $.grep(listJamKul, function(n,i) {return i < $.inArray(jam, listJamKul);});
							
							getKelas('option', id_jurusan);
							cekJadwalKelas(hari, jam);
							clearModal('#modal-1');

							$('#col-hari').hide();
							$('#col-tanggal').hide();
							$('#col-jam').hide()
							
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
					
					
					getJadwalKelas(kls[1],id_thnAjr,'background');
					
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
		
		});
			
    </script>
    
<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>
