<?php 
	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar");
	$qr_jurusan = mysql_query("SELECT * FROM jurusan");

include 'edit-jadwal.php';
?>
<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
                <h2> <i class="icon-reorder"></i> Jadwal Dosen</h2>               
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
                <ul class="tabs tabs-left">
                	<li>
                    <select name="jurusan" id="jurusan" class="select2-me input-large" data-placeholder="-- Pilih Jurusan --">
                    	<option value=""></option>
                            <?php
								while ($data=mysql_fetch_array($qr_jurusan)) {
									echo "<option value='$data[0]' > $data[1] </option>";
								}
							?>
                    </select>
                    </li> 
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
                    <li class='opsi-dosen'>
                    
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
			
			$('#thn_ajar').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_dosen = $("#pilih-dosen option:selected").val();
				//$('#idThnAjar').val(id);
				getJadwalDosen(id_dosen,id,'event');
				//if (id_ruangan != null) {$('#input-jadwal').show();}
			});
			
			// Memilih Jurusan
			$('#jurusan').change(function(){
				$('#calendar').fullCalendar('removeEvents');
				var jurusan = this.options[this.selectedIndex].value;
				
				getDosen(jurusan);
			});
			
			//Memilih Dosen
			 $('li.opsi-dosen').on('change', '#pilih-dosen', function(){
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
			});
		});	
    </script>
    
