<?php 
	if (isset($_SESSION['dosen_login'])) { 
	$jurusan = $_SESSION['jurusan_dosen'];
	$id_dosen = $_SESSION['id_dosen'];

	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar");
	
include 'edit-jadwal.php';
?>
<input id="id_jurusan" type="hidden" value="<?php echo $jurusan; ?>" />
<input id="id_dosen" type="hidden" value="<?php echo $id_dosen; ?>" />

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
			var rootURL = "http://localhost/classroom_schedules/api/";
			var id_jurusan =  document.getElementById("id_jurusan").value;
			var listHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
			var listJamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"]; 
			
			//$('#input-jadwal').hide();
			$('#dwnload-excel').hide();
			
			$('#thn_ajar').change(function() {
				$('#calendar').fullCalendar('removeEvents');
				getKelas('list', id_jurusan);
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_kelas = $("#listKelas .active a").data('identity');
				$('#idThnAjar').val(id);
				$('#idTahunAjar').val(id);
				getKelas('option', id_jurusan);
			});
			 
			// Memilih Kelas
			$('#listKelas').on('click', 'a', function() {
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var idKelas = $(this).data('identity');
				var id_kelas = $(this).data('id');
				
				$('#kelas').val(id_kelas); // id kelas untuk simapn from form
				$('#idKelas').val(id_kelas); //id kelas untuk di simpan from file
				$('#judul').empty();
				$('#judul').append("JADWAL KELAS " + idKelas);
				
				if (id == "" && idKelas != 'edit-list') { 
					alert("Pilih Semester dan Tahun ajar"); 
				} else if (idKelas != 'edit-list'){
					console.log(idKelas); 
					//$("#input-jadwal").show();
					$('#dwnload-excel').show();
					getJadwalKelas(idKelas,id,id_jurusan,'event');
				} 
			});
			
			//download excel
			$('#dwnload-excel').click(function(event){
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var id_kelas = $("#listKelas .active a").data('id');
				event.preventDefault();
				window.location = '/classroom_schedules/jadwal/dwnload-excel.php?smt=' + id + '&kelas=' + id_kelas;
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
			selectable: false,
			selectHelper : false,
			eventStartEditable : false,
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
						var kelas = $('#listKelas .active a').data('id');
						var id_admin = $('#id_admin').val();
					
						var dataHistory = JSON.stringify({'id_jadwal':calEvent.id, 
														  'id_admin':id_admin,
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
														  'id_admin':id_admin,
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
				setCheckbox(id_ruangan, id_kelas, hari);
			});
			
			$('#idRuangan').change(function() {
				var id_kelas = $('#kelas').val();
				var id_ruangan = $('#idRuangan option:selected').val();
				var hari = $('#hari').val();
				setCheckbox(id_ruangan, id_kelas, hari);
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
