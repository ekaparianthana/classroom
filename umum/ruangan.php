<?php 
	$qr_thn_ajar = mysql_query("SELECT * FROM thn_ajar ORDER BY thn_ajar");
	$qr_jurusan = mysql_query("SELECT * FROM jurusan");
	include 'edit-jadwal.php';
?>

<div class="span12">
	<div class="box">
    	<div class="box-title">
            <div class="pull-left">
                <h2> <i class="icon-reorder"></i> Jadwal Ruangan </h2>               
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
									echo "<option value='$data[0]' data-semester=$data[1]> Semester $data[1] - $data[2] </option>";
								}
							?>
                    </select>
                    </li>
                </ul>
            </div>
        	<div class="box-content nopadding">
            	<div class="tabs-container"> 
                	<ul id="listRuangan" class="tabs tabs-inline tabs-left" style="height:792px;overflow:scroll"></ul>
                </div>
            	<div class="tab-content padding tab-content-inline"> 
                	<div id="calendar" class="tab-pane active"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
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

				},
	});
	
	$('#dwnload-excel').hide();
	
	$('#jurusan').on('change', function(){
		$('#calendar').fullCalendar('removeEvents');
		
		var jurusan = $(this, 'option:selected').val();
		var smt = $('#thn_ajar option:selected').val();
		getRuangan('list', jurusan);
		$('#listRuangan li.admin').hide();
		if (smt != "" ) {$('#dwnload-excel').show();}
	});
	
	$('#listRuangan').on('click', 'a', function() {
		var thn_ajar = document.getElementById("thn_ajar");
		var id = thn_ajar.options[thn_ajar.selectedIndex].value;
		var idRuangan = $(this).data('identity');
						
		if (id == "" && idRuangan != 'edit-list' && idRuangan != 'qrCode') { 
			alert("Pilih Semester dan Tahun ajar"); 
		} else if (idRuangan != 'edit-list' && idRuangan != 'qrCode'){ 
			getJadwalRuangan(idRuangan,id,'event');
		} 
	});
	
	$('#thn_ajar').change(function() {
		$('#calendar').fullCalendar('removeEvents');
		var thn_ajar = document.getElementById("thn_ajar");
		var id = thn_ajar.options[thn_ajar.selectedIndex].value;
		var id_ruangan = $("#listRuangan .active a").data('identity');
		var jurusan = $('#jurusan option:selected').val();
		getJadwalRuangan(id_ruangan,id,'event');
		if (jurusan != "") {$('#dwnload-excel').show();}
	});
	
			//download excel
			$('#dwnload-excel').click(function(event){
				var thn_ajar = document.getElementById("thn_ajar");
				var id = thn_ajar.options[thn_ajar.selectedIndex].value;
				var jurusan = $('jurusan option:selected').val();
				event.preventDefault();
				window.location = '/classroom_schedules/jadwal/dwnload-excel.php?smt=' + id + '&jurusan=' + jurusan + '&data=jadwal';
			});
			
});
	
</script>