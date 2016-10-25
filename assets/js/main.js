var rootURL = "/classroom_schedules/api";	

//==== fungsi-fungsi ====//
	// fungsi get data dosen jurusan
	function getDosen(id_jurusan) {
		console.log('Dosen Jurusan ' + id_jurusan);
		$.ajax({
			type		: 'GET',
			url			: rootURL + '/dosen/' + id_jurusan, 
			dataType	: 'json',
			success		: renderOpsiDosen
		});
	}
	
	// fungsi update history
	function updateHistory(dataHistory) {
		$.ajax({
			type		: 'POST',
			contentType	: 'application/json',
			url			: rootURL + '/history',
			dataType	: 'json',
			data		: dataHistory,
			success		: function(data, textStatus, jqXHR) {console.log('History berhasil ditambah');},
			error		: function(jqXHR, textStatus, errorThrown) {console.log('updateHistory error: ' + textStatus);} 
		});
	}
	
	// fungsi update jadwal waktu
	function updateJadwal(id,data){
		console.log('Update Jadwal');
		$.ajax({
			type		: 'PUT',
			contentType : 'application/json',
			url			: rootURL + '/jadwal/' + id,
			dataType	: 'json',
			data		: data,
			success		: function(data, textStatus, jqXHR){
							console.log('Jadwal updated successfully');
							
						},
			error		: function(jqXHR, textStatus, errorThrown){
							alert('updateJadwal error: ' + textStatus);
						} 
		});
	}
	
	// fungsi delete jadwal
	function deleteJadwal(id,jadwal) {
		console.log('Hapus Jadwal');
		$.ajax({
			type	: 'DELETE',
			url		: rootURL + '/jadwal/' + id,
			success : function () {
						console.log('Data berhasil di hapus');
						if(jadwal == 'ruangan') {
								var id = thn_ajar.options[thn_ajar.selectedIndex].value;
								var id_ruangan = $("#listRuangan .active a").data('identity');
						
								getJadwalRuangan(id_ruangan,id,'event');
							} else if (jadwal == 'kelas'){
								var id = thn_ajar.options[thn_ajar.selectedIndex].value;
								var id_kelas = $("#listKelas .active a").data('identity');
						
								getJadwalKelas(id_kelas,id,'event');
							} else {
								var id = thn_ajar.options[thn_ajar.selectedIndex].value;
								var dosen = $('#id_dosen').val();
								
								getJadwalDosen(dosen,id,'event');
							}
						$('.popover').popover('hide');
				},
			error	: function(jqXHR, textStatus, errorThrown) {
						alert('deleteJadwal error: ' + textStatus);
				}
		});
	}
	
	// fungsi update keterangan aktivitas 
	function updateKeterangan(id,data) {
		console.log('Update Keterangan');
		$.ajax({
			type		: 'PUT',
			contentType : 'application/json',
			url			: rootURL + '/jadwal/keterangan/' + id,
			dataType	: 'json',
			data		: data,
			success		: function(data, textStatus, jqXHR){
							console.log('Keterangan updated successfully');
							
							$('.popover').popover('hide');
						},
			error		: function(jqXHR, textStatus, errorThrown){
							alert('updateKeterangan error: ' + textStatus);
						} 
		});
	}
	// fungsi untuk mendapatkan data jadwa berdasarkan id
	function getJadwalById(id) {
		console.log('Get Jadwal By Id '+id);
		$.ajax({
			type	: 'GET',
			url		: rootURL + '/jadwal/' + id,
			dataType: "json",
			success : function(data) {
						$('select#edit-jenis-aktivitas option[value="'+data.id_jenis_aktivitas+'"]').prop('selected','selected');
						$('textarea#edit-nama-aktivitas').val(data.nama_aktivitas);
						$('input#edit-kelas').val(data.kelas);
						data.repetisi == 0 ? $('input#edit-repetisi').val('Satu Kali') : $('input#edit-repetisi').val('Setiap Minggu');
						$('input#edit-hari').val(data.hari);
						$('input#edit-tanggal').val(data.tanggal);
						$('input#edit-jam').val(data.jam);
						$('input#edit-dosen').val(data.nama);
						$('textarea#edit-keterangan').val(data.keterangan);
					  }
		});
	}
			
	//fungsi untuk mendapatkan data ruangan fakultas
	function getRuanganFakultas(id_jurusan){
		console.log('List Ruangan Fakultas');
		$.ajax({
			type	: 'GET',
			url		: rootURL + '/ruangan/fakultas/' + id_jurusan,
			dataType: "json",
			success	: renderOpsiRuangan
		});
	}
			
	//fungsi untuk mendapatkan data kelas suatu jurusan
	function getKelas(opsi, id_jurusan, tahun, semester){
		$.ajax({
			type	: 'GET',
			url		: rootURL + '/kelas/' + id_jurusan + '/' + tahun + '/' + semester,
			dataType: "json",
			success	: function(data, textStatus, jqXHR){
						renderKelas(opsi,data);
					  }
		});
	}
							
	//fungsi untuk mendapatkan data ruangan suatu jurusan
	function getRuangan(opsi, id_jurusan) {
		console.log('List Ruangan Kelas dari Jurusan: ' + id_jurusan );
		$.ajax({
			type	 : 'GET',
			url		 : rootURL + '/ruangan/jurusan/' + id_jurusan,
			dataType : "json",
			success	: function(data, textStatus, jqXHR){
						renderListRuangan(opsi, data);
					  }
		});
	}
	
	//fungsi untuk mendapatkan data jadwal dosen
	function getJadwalDosen(id_dosen, id_thn_ajar, opsi) {
		console.log('Data Jadwal Dosen: '+ id_dosen);
		$.ajax({
			type		: 'GET',
			url			: rootURL + '/jadwal/dosen/' + id_dosen + '/' + id_thn_ajar,
			dataType	: 'json',
			success		: function(data) {renderJadwalDosen(data,opsi);}
		});
	}
			
	//fungsi untuk mendapatkan data jadwal ruangan kelas
	function getJadwalRuangan(id_ruangan, semester, tahun, opsi) {
		console.log('Data Jadwal Ruangan: ' + id_ruangan);
		$.ajax({
			type	 : 'GET',
			url		 : rootURL + '/jadwal/ruangan/' + id_ruangan + '/' + semester + '/' + tahun,
			dataType : "json",
			success	 : function(data) {renderJadwalRuangan(data,opsi)} 
		});
	}
	
	//fungsi untuk mendapatkan data jadwal kelas 
	function getJadwalKelas(id_kelas, semester, tahun, id_jurusan, opsi) {
		console.log('Data Jadwal Kelas: ' + id_kelas);
		$.ajax({
			type	 : 'GET',
			url		 : rootURL + '/jadwal/kelas/' + id_kelas + '/' + semester + '/' + tahun + '/' + id_jurusan,
			dataType : "json",
			success	 : function (data) {renderJadwalKelas(data,opsi)}
		});
	}
	
	  // Render Option dosen 
  function renderOpsiDosen(data) {
	  var list = data == null ? [] : (data.dosen instanceof Array ? data.dosen : [data.dosen]);
	  $('.opsi-dosen').empty();
	  $('.opsi-dosen').append('<select id="pilih-dosen" name="pilih-dosen" class="input-xlarge" data-placeholder="-- Pilih Dosen --"></select>');
	  $('#pilih-dosen').append('<option value=""></option>');
	 
	 $.each(list, function(index, dosen) {
	  	$('#pilih-dosen').append('<option value="'+dosen.id_dosen+'">'+dosen.nama+'</option>');
	  });
	  
	  $('#pilih-dosen').select2();
  }
			
	//fungsi untuk menampilkan List Ruangan
	function renderListRuangan(opsi, data) {
		// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
		var list = data == null ? [] : (data.ruangan instanceof Array ? data.ruangan : [data.ruangan]);
		
		if (opsi == 'option') {
			$('#idRuangan option').remove();
			$('#idRuangan').append('<option value="">- Pilih Ruangan -</option>');
			$.each(list, function(index, ruangan){
				$('#idRuangan').append('<option value="'+ruangan.id_ruangan+'">'+ruangan.ruangan+'</option>');
			});
		} else if (opsi == 'list') {
			$('#listRuangan li').remove();
			$('#listRuangan').append('<li class="admin"><a href="#qrcode-generators" data-toggle="tab" data-identity="qrCode" style="background-color:#a3c2ff"> <i class="icon-qrcode"></i> QR Code </a></li>');
			$('#listRuangan').append('<li class="admin"><a data-identity="laporan" href="#" style="background-color:#a3c2ff"><i class="icon-print"></i> Print Laporan </a></li>');
			$('#listRuangan').append('<li class="admin"><a href="#modal-2" data-toggle="modal" data-identity="edit-list" style="background-color:#a3c2ff"> <i class="icon-cogs" ></i> LIST RUANGAN </a></li>');
			$.each(list, function(index, ruangan) {
				$('#listRuangan').append('<li><a href="#calendar" data-toggle="tab" data-id="'+ruangan.id_ruangan+'" data-identity="' + ruangan.ruangan + '" data-status="'+ ruangan.status +'">'+ruangan.ruangan+'</a></li>');
			});
		} else if (opsi == 'multiselect') {
			$.each(list, function(index, ruangan){
				$('.ms-ruangan').multiSelect('addOption', {value : ruangan.id_ruangan, text: ruangan.ruangan});
			});
		}
	}
			
	//fungsi untuk menampilkan Opsi Ruangan Pada Edit List Ruangan
	function renderOpsiRuangan(data) {
		// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
		var list = data == null ? [] : (data.ruanganFakultas instanceof Array ? data.ruanganFakultas : [data.ruanganFakultas]);
		var id_jurusan =  document.getElementById("jurusan").value;
				
		$.each(list, function(index, ruanganFakultas) {
			if (ruanganFakultas.id_jurusan == id_jurusan) {
				$('#my-select').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});
				$('.selectKelas').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});
				$('#my-select').multiSelect('select',[ruanganFakultas.id_ruangan]);
				
				// $('.selectKelas').multiSelect('addOption', [])

			} else if (ruanganFakultas.id_jurusan == null ) {
				$('.selectKelas').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});

				$('#my-select').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});
			} else if (ruanganFakultas.status == "Umum" && ruanganFakultas.id_jurusan != id_jurusan) {
				$('.selectKelas').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});
				
				$('#my-select').multiSelect('addOption',{value : ruanganFakultas.id_ruangan, text: ruanganFakultas.ruangan});
			}
		});
				
		//Edit List Ruangan
		var selected 
		$('#my-select').val() == null? selected = [] : selected = $('#my-select').val();
		$('#my-select').change(function(){
			var newSelected; 
			$(this).val() == null ? newSelected = [] : newSelected = $(this).val();
			if(newSelected.length > selected.length){
				var baru = $.grep(newSelected, function(el) {return $.inArray(el, selected) == -1;});
				console.log("SELECTED "+ baru);
						
				$.ajax({
					type		: 'POST',
					contentType	: 'application/json',
					url			: rootURL + '/ruangan/' + id_jurusan + '/' + baru,
					success		: function(data, textStatus, jqXHR){
									getRuangan('list',id_jurusan);
									getRuangan('multiselect', id_jurusan);
								  },
					error		: function(jqXHR, textStatus, errorThrown){
								console.log('addRuangan error: ' + textStatus);
								  }
				});
						
				selected = newSelected;
			} else {
				var baru = $.grep(selected, function(el) {return $.inArray(el, newSelected) == -1;});
				console.log("DESELECTED " + baru);
						
				$.ajax({
					type	: 'DELETE',
					url		: rootURL + '/ruangan/' + id_jurusan + '/' + baru,
					success	: function(data, textStatus, jqXHR){
								getRuangan('list',id_jurusan);
								getRuangan('multiselect', id_jurusan);
							  },
					error	: function(jqXHR, textStatus, errorThrown){
								console.log('deleteRuangan error');
							  }
				});
				selected = newSelected;
			}
		});
	}
			
	// fungsi untuk menampilkan List / Option Kelas sesuai dengan Semester genap/ganjil
	function renderKelas(opsi, data) {
		// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
		var list = data == null ? [] : (data.kelas instanceof Array ? data.kelas : [data.kelas]);
		//var semester = $('#thn_ajar option:selected').data('semester');
		
		if (opsi == 'option') {
			$('.opsi-kelas option').remove();
			$('.opsi-kelas').append('<option value="">-Pilih Kls-</option>');
			$.each(list, function(index, kelas){
				var kls = kelas.kelas;
				if (kls == '-') {
					$('.opsi-kelas').append('<option value=' + kelas.id_kelas + '>' + kls + '</option>');
				} else if(semester == 'Ganjil'){
					if(parseInt(kls.substring(0,kls.length-1))%2!=0){
						$('.opsi-kelas').append('<option value=' + kelas.id_kelas + '>' + kls + '</option>');
					}
				} else {
					if(parseInt(kls.substring(0,kls.length-1))%2==0){
						$('.opsi-kelas').append('<option value=' + kelas.id_kelas + '>' + kls + '</option>');
					}
				}
			});
		} else if (opsi == 'list') {
			$('#listKelas li').remove();
			$('#listKelas').append('<li><a href="#modal-2" data-toggle="modal" data-identity="edit-list" style="background-color:#a3c2ff"> <i class="icon-cogs"></i> LIST Kelas</a></li>');
			$('#listKelas').append('<li class="admin"><a data-identity="laporan" href="#" style="background-color:#a3c2ff"><i class="icon-print"></i> Print Laporan </a></li>');
			$.each(list, function(index, kelas){
				var kls = kelas.Kelas;
				$('#listKelas').append('<li><a href="#" data-toggle="tab" data-id="'+kls+'" data-identity="' + kls + '">'+kls+'</a></li>');
			});
		}
	} 
	
	//fungsi untuk mengubah format data jadwal dosen sesuai dengan format JQuery fullcalendar lalu menampilkannya
	function renderJadwalDosen(data,opsi) {
		var list = data == null ? [] : (data.jadwal instanceof Array ? data.jadwal : [data.jadwal]);
		var eventHarian = [];
		var backgroundHarian = [];
				
		$.each(list, function(index, jadwal) {
			if (jadwal.repetisi == 0){
				if (opsi == 'event') {
					eventHarian.push({
						id 	  : jadwal.id_jadwal,
						title : (jadwal.kelas == '-') ? jadwal.nama_aktivitas : (jadwal.nama_aktivitas + "/" + jadwal.kelas),
						start : (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	  : (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						dosen : jadwal.nama,
						ruangan: jadwal.ruangan,
						//id_dosen	 : jadwal.id_dosen,
						id_ruangan	 : jadwal.id_ruangan,
						id_kelas  	 : jadwal.id_kelas,
						id_penawaran : jadwal.Id_Pktivitas,
						color : 'green'
					});
				} else {
					backgroundHarian.push({
						id 	  : jadwal.id_jadwal,
						title : (jadwal.kelas == '-') ? jadwal.nama_aktivitas : (jadwal.nama_aktivitas + "/" + jadwal.kelas),
						start : (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	  : (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						rendering : 'background',
						color : 'yellow',
					});
				}
					
			} 
		});
				
		//tampilkan jadwal dengan repetisi setiap minggu (2)
		$('#calendar').fullCalendar('addEventSource', function(start, end, timezone, callback) {
				var eventMingguan = [];
				var backgroundMingguan = [];					
				for (loop = start.toDate().getTime(); loop <= end.toDate().getTime(); loop = loop + (24 * 60 * 60 * 1000)) {
					var test_date = new Date(loop);
					var thn = test_date.getFullYear();
					var	bln = ((test_date.getMonth()+1) > 9)? (test_date.getMonth()+1) : '0' + (test_date.getMonth()+1);
					var tgl = (test_date.getDate() > 9 )? test_date.getDate() : '0' + test_date.getDate();
							
					$.each(list, function(index, jadwal) {					
						if (jadwal.repetisi == 2){
							if (opsi == 'event') {
								if (test_date.getDay() == convertHari(jadwal.hari)){
									eventMingguan.push({
										id 	  :jadwal.id_jadwal,
										title :(jadwal.kelas === null) ? jadwal.nama_aktivitas : (jadwal.nama_aktivitas + "/" + jadwal.kelas),
										start :(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
								 		end	  :(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
										dosen : jadwal.nama,
										//id_dosen	 : jadwal.id_dosen,
										ruangan 	 : jadwal.ruangan,
										id_ruangan	 : jadwal.id_ruangan,
										id_kelas  	 : jadwal.id_kelas,
										id_penawaran : jadwal.Id_Penawaran,
									});
								} //endif
							} else {
								if (test_date.getDay() == convertHari(jadwal.hari)){
									backgroundMingguan.push({
										id 	  :jadwal.id_jadwal,
										title :(jadwal.kelas === null) ? jadwal.nama_aktivitas : (jadwal.nama_aktivitas + "/" + jadwal.kelas),
										start :(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
								 		end	  :(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
										rendering : 'background',
										color : 'yellow',
									});
								} //endif
							}// endif opsi
						} //end if  
					}); //end each
				} // end loop	
				//returns events generated
				if (opsi == 'event') {
					$('#calendar').fullCalendar('removeEvents');
					$('#calendar').fullCalendar('addEventSource', eventHarian);
					callback(eventMingguan);
				} else {
					//$('#calendar').fullCalendar('removeEvents');
					$('#calendar').fullCalendar('addEventSource', backgroundHarian);
					callback(backgroundMingguan);
				}
		}); 
				
	}
			
	//fungsi untuk mengubah format data jadwal ruangan sesuai dengan format JQuery fullcalendar lalu menampilkannya
	function renderJadwalRuangan(data,opsi) {
		var list = data == null ? [] : (data.jadwal instanceof Array ? data.jadwal : [data.jadwal]);
		var eventHarian = [];
		var backgroundHarian = [];
				
		$.each(list, function(index, jadwal) {
			if (jadwal.repetisi == 0){
				if (opsi == 'event') {
					eventHarian.push({
						id 	  : jadwal.id_jadwal,
						title : (jadwal.kelas == '-') ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.kelas),
						start : (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	  : (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						dosen : jadwal.nama,
						id_dosen 	: jadwal.id_dosen,
						id_kelas 	: jadwal.id_kelas,
						id_penawaran: jadwal.Id_Penawaran,
						color : 'green'
					});
				} else {
					backgroundHarian.push({
						id 	  : jadwal.id_jadwal,
						title : (jadwal.kelas == '-') ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.kelas),
						start : (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	  : (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						rendering : 'background',
						color : 'red',
					});
				}
					
			} 
		});
				
		//tampilkan jadwal dengan repetisi setiap minggu (2)
		$('#calendar').fullCalendar('addEventSource', function(start, end, timezone, callback) {
				var eventMingguan = [];
				var backgroundMingguan = [];					
				for (loop = start.toDate().getTime(); loop <= end.toDate().getTime(); loop = loop + (24 * 60 * 60 * 1000)) {
					var test_date = new Date(loop);
					var thn = test_date.getFullYear();
					var	bln = ((test_date.getMonth()+1) > 9)? (test_date.getMonth()+1) : '0' + (test_date.getMonth()+1);
					var tgl = (test_date.getDate() > 9 )? test_date.getDate() : '0' + test_date.getDate();
							
					$.each(list, function(index, jadwal) {					
						if (jadwal.repetisi == 2){
							if (opsi == 'event') {
								if (test_date.getDay() == convertHari(jadwal.hari)){
									eventMingguan.push({
										id 	  :jadwal.id_jadwal,
										title :(jadwal.kelas === null) ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.kelas),
										start :(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
								 		end	  :(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
										dosen : jadwal.nama,
										id_dosen 	: jadwal.id_dosen,
										id_kelas 	: jadwal.id_kelas,
										id_penawaran: jadwal.Id_Penawaran,
									});
								} //endif
							} else {
								if (test_date.getDay() == convertHari(jadwal.hari)){
									backgroundMingguan.push({
										id 	  :jadwal.id_jadwal,
										title :(jadwal.kelas === null) ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.kelas),
										start :(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
								 		end	  :(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
										rendering : 'background',
										color : 'red',
									});
								} //endif
							}// endif opsi
						} //end if  
					}); //end each
				} // end loop	
				//returns events generated
				if (opsi == 'event') {
					$('#calendar').fullCalendar('removeEvents');
					$('#calendar').fullCalendar('addEventSource', eventHarian);
					callback(eventMingguan);
				} else {
					//$('#calendar').fullCalendar('removeEvents');
					$('#calendar').fullCalendar('addEventSource', backgroundHarian);
					callback(backgroundMingguan);
				}
		}); 
		
		 $('.fc-draggable').draggable({
 			//appendTo : 'body',
			zIndex	 : 100,
			containment : $('document'),
			helper	 : 'clone'
		});
				
	}
	
	//fungsi untuk mengubah format data jadwal kelas sesuai dengan format JQuery fullcalendar lalu menampilkannya
	function renderJadwalKelas(data,opsi) {
		var list = data == null ? [] : (data.jadwal instanceof Array ? data.jadwal : [data.jadwal]);
		var eventHarian = [];
		var backgroundHarian = [];
		
		$.each(list, function(index, jadwal) {
			if (jadwal.repetisi == 0){
				if (opsi == 'event') {
					eventHarian.push({
						id 	    	: jadwal.id_jadwal,
						title   	: (jadwal.ruangan == '-') ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.ruangan),
						start   	: (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	    	: (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						ruangan 	: jadwal.id_ruangan,
						dosen   	: jadwal.nama,
						id_dosen	: jadwal.id_dosen,
						id_ruangan 	: jadwal.id_ruangan,
						id_penawaran: jadwal.Id_Penawaran,
						color : 'green'
					});
				} else {
					backgroundHarian.push({
						id 	  : jadwal.id_jadwal,
						title : (jadwal.ruangan == '-') ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.ruangan),
						start : (jadwal.tanggal + convertJamMulai(jadwal.jam)),
						end	  : (jadwal.tanggal + convertJamSelesai(jadwal.jam)),
						rendering : 'background',
						color : 'green',
					});
				}
			} 
		});
				
		//tampilkan jadwal dengan repetisi setiap minggu (2)
		$('#calendar').fullCalendar('addEventSource', function(start, end, timezone, callback) {
			//when requested, dynamically generate virtual events for every week.
			var eventMingguan = [];
			var backgroundMingguan = [];					
			for (loop = start.toDate().getTime(); loop <= end.toDate().getTime(); loop = loop + (24 * 60 * 60 * 1000)) {
				var test_date = new Date(loop);
				var thn = test_date.getFullYear();
				var	bln = ((test_date.getMonth()+1) > 9)? (test_date.getMonth()+1) : '0' + (test_date.getMonth()+1);
				console.log(bln);
				var tgl = (test_date.getDate() > 9 )? test_date.getDate() : '0' + test_date.getDate();
				console.log(tgl);	
				$.each(list, function(index, jadwal) {					
					if (jadwal.repetisi == 2){
						if (opsi == 'event') {
							if (test_date.getDay() == convertHari(jadwal.hari)){
								eventMingguan.push({
									id 	  		:jadwal.id_jadwal,
									title 		:(jadwal.ruangan === null) ? jadwal.matkul : (jadwal.matkul+"/"+jadwal.ruangan),
									start 		:(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
							 		end	  		:(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
									ruangan		: jadwal.id_ruangan,
									dosen 		: jadwal.nama,
									id_dosen	: jadwal.id_dosen,
									id_ruangan	: jadwal.id_ruangan,
									id_aktivitas: jadwal.Id_Penawaran,
								});
							} //endif
						} else {
							if (test_date.getDay() == convertHari(jadwal.hari)){
								backgroundMingguan.push({
									id 	  :jadwal.id_jadwal,
									title :(jadwal.ruangan === null) ? jadwal.matkul : (jadwal.matkul + "/" + jadwal.ruangan),
									start :(thn + "-" + bln + "-" + tgl + convertJamMulai(jadwal.jam)),
							 		end	  :(thn + "-" + bln + "-" + tgl + convertJamSelesai(jadwal.jam)),
									rendering : 'background',
									color : 'green',
								});
							} //endif
						}//endif opsi
					} //end if  
				}); //end each
			} // end loop	
			//returns events generated
			if (opsi == 'event') {
				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource', eventHarian);
				callback(eventMingguan);
			} else {
				//$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource', backgroundHarian);
				callback(backgroundMingguan);
			}
		}); 
		
	}
			
	//Tampilkan pilihan Hari
	function opsiHari(){
		var hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
		for(var i=0; i<=hari.length-1; i++){
			$('#hari').append('<option value='+ hari[i] + '>' + hari[i] + '</option>');
		}
	}
	
	// fungsi untuk menyesuaikan format jam mulai di database dengan jam di fullcalendar
	function convertJamMulai(jam) {
		var jamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"];
		var time = ["T07:30:00", "T08:30:00", "T09:30:00", "T10:30:00", "T11:30:00", "T12:30:00", "T13:30:00", "T14:30:00", "T15:30:00", "T16:30:00", "T17:30:00", "T18:30:00", "T19:30:00", "T20:30:00", "T21:30:00"];
				
		var waktu = jam.split(",");
		var i=0;
		var sama = false;
		do {
			if (waktu[0] === jamKul[i]) {
				var start = time[i]; 
				sama = true;
			}
			i++;
		} while(!sama);
		return start;
	}
	
	// fungsi untuk menyesuaikan format jam mulai di database dengan jam di fullcalendar
	function convertJamSelesai(jam) {
		var jamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"];
		var time = ["T08:30:00", "T09:30:00", "T10:30:00", "T11:30:00", "T12:30:00", "T13:30:00", "T14:30:00", "T15:30:00", "T16:30:00", "T17:30:00", "T18:30:00", "T19:30:00", "T20:30:00", "T21:30:00", "T22:30:00"];
				
		var waktu = jam.split(",");
		var i=0;
		var sama = false;
		do {
			if (waktu[waktu.length-1] === jamKul[i]) {
				var end = time[i]; 
				sama = true;
			}
			i++;
		} while(!sama);
		return end;
	}
			
	// fungsi untuk menyesuaikan format hari di database dengan format fullcalendar
	function convertHari(day) {
		var hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
		var i = 0;
		var sama = false;
		do { 
			if (hari[i] === day) {
				var hasil = i;
				sama = true;
			} 
			i++;
		} while (!sama);
		return hasil;
	}
	
	// fungsi untuk membuat Opsi Matkul
	function createOptions(data){
		var list = data == null ? [] : (data.matkul instanceof Array ? data.matkul : [data.matkul]);

		$('#Aktivitas').remove();
		$('#ubah').append('<select name="Aktivitas" id="Aktivitas" class="select2-me input-xlarge" data-rule-required="true" data-placeholder="- Pilih Mata Kuliah -"> </select>');
		$('#Aktivitas').append('<option value="" slected="selected"></option>');
		$.each(list, function(index, matkul) {
			$('#Aktivitas').append('<option value="'+matkul.id_matkul+' - '+matkul.matkul+'" data-sks="' + matkul.sks + '">' + matkul.id_matkul + ' - ' + matkul.matkul + '</option>');
		});
		$(".select2-me").select2();
		$('#dosen').data('rule-required',true);
		$('#col-dosen').show();
	}

	// fungsi untuk menentukan Form Nama Aktivitas
	function listMatkul(s1,s2,s3){
		var s1 = document.getElementById(s1);
	
		if(s1.options[s1.selectedIndex].text == "Kuliah"){
			console.log("Get Mata Kuliah");
			$.ajax({
				type: "GET",
				url: rootURL + "/matkul/" + s2 + "/" + s3,
				dataType: 'json',
				success: createOptions
			});
		} else {
			$('#s2id_Aktivitas').remove();
			$("#Aktivitas").replaceWith('<input type="text" name="Aktivitas" id="Aktivitas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50"/>');
			$('#col-dosen').hide();
		}
	}

	// fungsi untuk menampilkan Tanggal hari ini
	function currentTime(){
		var $el = $(".stats .icon-calendar").parent(),
		currentDate = new Date(),
		monthNames = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ],
		dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

		$el.find(".details .big").html(monthNames[currentDate.getMonth()] + " " + currentDate.getDate() + ", " + currentDate.getFullYear());
		$el.find(".details span").last().html(dayNames[currentDate.getDay()] + ", " + currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2));
		setTimeout(function(){
			currentTime();
		}, 10000);
	}
	
// fungsi validasi form input jadwal 

	// fungsi validasi cek jam kuliah
	function cekJamKuliah(id_ruangan, id_kelas, hari, thnAjar) {
		console.log('cek jadwal');
		$.ajax({
			type	 : "GET",
			url		 : rootURL + '/jadwal/cek/' + id_ruangan + '/' + id_kelas + '/' + hari + '/' + thnAjar,
			dataType : 'json', 
			success  : disableJamKuliah
		});
	}
	
	function disableJamKuliah(data) {
		var jam_isi = data == [] ? [] : data.jam.split(',');
							
		for(var i=0; i<jam_isi.length; i++) {
			var checkbox = document.getElementById(jam_isi[i]);
			checkbox.disabled = true;
			$('.'+jam_isi[i]).css({'color':'grey'});
		}
	}
	
	function setCheckbox(id_ruangan, id_kelas, hari, thnAjar) {
		$('input:checkbox').prop('checked', false);
		$('input:checkbox').removeAttr('disabled');
		$('.checkbox').css({'color':'black'});
		$('.jamSet').prop('checked', true);
		cekJamKuliah(id_ruangan, id_kelas, hari, thnAjar);	
	}
	
	function cekSks(sks, counter, id_ruangan, id_kelas, hari, thnAjar) {
		var count = $('input[name="jam[]"]:checked').length;
		if (count >= sks) {
			$('.checkbox input:not(:checked)').prop('disabled', true);
		} else if(counter >= sks) {
			$('.checkbox input:checkbox').removeAttr('disabled');
			cekJamKuliah(id_ruangan, id_kelas, hari, thnAjar);
		}
	}
		
// fungsi simpan data kelas 
	function simpanKelas(kelas, id_jurusan) {
		console.log('Simpan kelas ' + kelas + ' Jurusan ' + id_jurusan);
		$.ajax({
			type		: 'POST',
			contentType : 'application/json',
			url			: rootURL + '/kelas/simpan/' + kelas + '/' + id_jurusan,
			success		: function(data, textStatus, jqXHR){
							$('#input-kelas span').remove();
							$('#input-kelas').append('<span style="color:green">Kelas '+ kelas +' berhasil disimpan. </span>');
							getKelas('list', id_jurusan);
						  },
			error		: function(jqXHR, textStatus, errorThrown){
							console.log('addKelas error: ' + textStatus);
						  }
		});	
	}

// fungsi hapus kelas
	function hapusKelas(id_kls,id_jurusan) {
		console.log('Hapus kelas dengan id ' + id_kls);
		$.ajax({
					type	: 'DELETE',
					url		: rootURL + '/kelas/hapus/' + id_kls,
					success	: function(data, textStatus, jqXHR){
								$('#delete-kelasContainer span').remove();
								$('#delete-kelasContainer').append('<span style="color:green">Kelas berhasil dihapus. </span>');
								getKelas('list', id_jurusan);
						  	   },
					error	: function(jqXHR, textStatus, errorThrown){
								console.log('deleteKelas error: ' + textStatus);
						  	  }
		});
	}

// fungsi membuat qrcode
	function generateQRCode(id,text,ukuran) {
		var options = {
			render: 'canvas',
            ecLevel: 'H',
            minVersion: 6,

            fill: '#000',
            background: '#fff',
            // fill: $('#img-buffer')[0],

            text: text,
            size: ukuran,
            radius: 0.5,
            quiet: 1,

            mode: 2,

            mSize: 0.1,
            mPosX: 0.5,
            mPosY: 0.5,

            label: text,
			fontname :'ubuntu',
			fontcolor: '#000'

		};
		$('#'+id).empty().qrcode(options);
		
	} 

// fungsi download qrcode as image
 function setLink(link, id, filename) {
	 link.href = $('#'+id+' canvas')[0].toDataURL();
	 link.download = filename + '.png';
 }
 
 // fungsi convert waktu fullcalendar ke data jam di database
 function getJam(mulai,akhir) {
	var jamMulai = ["07:30:00", "08:30:00", "09:30:00", "10:30:00", "11:30:00", "12:30:00", "13:30:00", "14:30:00", "15:30:00", "16:30:00", "17:30:00", "18:30:00", "19:30:00", "20:30:00", "21:30:00"];
	var jamSelesai = ["08:30:00", "09:30:00", "10:30:00", "11:30:00", "12:30:00", "13:30:00", "14:30:00", "15:30:00", "16:30:00", "17:30:00", "18:30:00", "19:30:00", "20:30:00", "21:30:00", "22:30:00", "23:30:00", "00:30:00"];
	var jamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"];
	
	var jam = $.grep(jamKul, function (n,i) {return (i >= $.inArray(mulai, jamMulai) && i <= $.inArray(akhir, jamSelesai));});
	return jam.toString();
 }
 
 // fungsi convert jam mulai fullcalendar ke jam mulai di database
 function getJamAwal(start) {
 	var jamKul = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"];
	var jamMulai = ["07:30:00", "08:30:00", "09:30:00", "10:30:00", "11:30:00", "12:30:00", "13:30:00", "14:30:00", "15:30:00", "16:30:00", "17:30:00", "18:30:00", "19:30:00", "20:30:00", "21:30:00"];
	
	return jamKul[$.inArray(start, jamMulai)];
 }
 
  // filter background events
  function isBackground(event){
	  return event.rendering == 'background';
  }
  
  function clearModal(id) {
	  $(id + ' select').prop({value:'', disabled:false});
	  $(id + ' option').prop({selected:false});
	  $(id + ' input[type="text"]').prop({value:'', disabled:false, readonly:false});
	  $(id + ' input[type="checkbox"]').prop({checked:false, disabled:false, readonly:false});
	  $(id + ' input[type="checkbox"]').off('click');
	  $(id + ' input[type="checkbox"]').removeClass('jamSet');
	  $(id + ' input[type="radio"]').prop({checked:false});
	  $(id + ' textarea').prop({value:''});
	  
	  $('#hidden-hari').prop({value:'', disabled:true});
	  $('#Aktivitas').remove();
	  $('#s2id_Aktivitas').remove();
	  $('#ubah').append('<input type="text" name="Aktivitas" id="Aktivitas" class="input-xlarge" data-rule-required="true" data-rule-maxlength="50"/>');
  	  
  }
  
  // Mencari kelas dengan jadwal hari tertentu dan waktu tertentu
  function cekJadwalKelas(hari, jam, thnAjar) {
	console.log('Cek Jadwal Kelas');
	$.ajax({
		type	 : 'GET',
		url		 : rootURL + '/jadwal/cek_kelas/' + hari + '/' + jam + '/' + thnAjar, // on progress
		dataType : 'json',
		success  : 	function(data) {
					$.each(data, function(index, list) {
					if (list.id_kelas != 1) {
						$('select#kelas option[value="'+list.id_kelas+'"]').prop('disabled',true);
						$('select#kelas option[value="'+list.id_kelas+'"]').css('background-color','#cccccc');						
					}
					
					if (list.id_dosen != '00000') {
						$('select#dosen option[value="'+list.id_dosen+'"]').prop('disabled',true);
					}
					
						$('select#idRuangan option[value="'+list.id_ruangan+'"]').prop('disabled',true);
						$('select#idRuangan option[value="'+list.id_ruangan+'"]').css('background-color','#cccccc');
					});
				}
	});
  }
  
  //fungsi menampilkan konfirmasi hapus record data
  function konfirmasi(url, pesan) {
	  ret = false;
	  $("#modalPesan").html(pesan);
	  $("#dialog-confirm").dialog({
	  	resizable:false,
		height:200,
		modal:true,
		buttons:{
		  "Hapus":function(){
			  $(this).dialog("close");
			  window.location=url;
		  },
		  "Batal":function(){
			  $(this).dialog("close");
			  ret=false;						  
		  }
		}
	  });
	  return ret;
  }

 
 $('html').on('click', function(e){
	$('[data-original-title]').each(function() {
		if(!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			$(this).popover('hide');
		}
	});
	
 });
 
 $(document).ready(function(){ currentTime(); });
 
 
