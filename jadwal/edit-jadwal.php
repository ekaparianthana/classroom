<div id="modal-3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Perhatian!</h3>
	</div>
	<div class="modal-body">
		<p id="pertanyaan">Anda yakin ingin menghapus jadwal </p> 
	</div>
	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal">Tidak</button>
		<button id="btn-hapus-jadwal" class="btn btn-primary" data-dismiss="modal">Iya</button>
	</div>
</div> 
        
<div id="popover-head" class="hide">Informasi Aktivitas</div>
<div id="popover-content" class="hide">
	<form id='edit-jadwal' class="form-vertical form-bordered form-validate" >
    	<div class="control-group">
        	<label class="control-label"> Jenis Aktivitas </label>
        	<div class="controls"> 
    			<select id="edit-jenis-aktivitas" name="jenis-aktivitas" disabled="disabled">
                	<option value="" disabled="disabled" selected="selected" style="display:none;">Jenis Aktivitas</option>
                    <option value="1">Kuliah</option>
                    <option value="2">Lain-lain</option>
                </select>
        	</div>
        </div>
        
        <div class="control-group hide">
        	<label class="control-label"> Aktivitas </label>
        	<div class="controls"> 
    			<textarea id="edit-nama-aktivitas" name="nama-aktivitas" class="input" placeholder="Nama Aktivitas" value=""  disabled>
                </textarea>
        	</div>
        </div>
      
 		<div class="control-group hide">
        	<label class="control-label"> Kelas </label>
        	<div class="controls"> 
    			<input id="edit-kelas" name="kelas" placeholder="Kelas" class="input-small"value=""  disabled/>
        	</div>
        </div>
         
        <div class="control-group">
        	<label class="control-label"> Repetisi </label>
        	<div class="controls"> 
    			<input id="edit-repetisi" name="repetisi" placeholder="Repetisi" class="input-small" value=""  disabled/> 
        	</div>
        </div>
        
 		<div class="control-group hide">
        	<div class="controls"> 
    			<input id="edit-hari" name="hari" placeholder="Hari" value=""  />
        	</div>
        </div>
        
        <div class="control-group hide">
        	<div class="controls"> 
    			<input id="edit-tanggal" name="tanggal" placeholder="tanggal" value=""  />
        	</div>
        </div>
        
        <div class="control-group hide">
        	<div class="controls"> 
    			<input id="edit-jam" name="jam" placeholder="Jam" value=""  />
        	</div>
        </div>
        
        <div class="control-group">
        	<label class="control-label"> Dosen Pengajar </label>
        	<div class="controls"> 
    			<input id="edit-dosen" name="edit-dosen" placeholder="dosen" class="input-large" value=""  disabled/> 
        	</div>
        </div>
        
        <div class="control-group">
        	<label class="control-label"> Keterangan/Pengumuman </label>
        	<div class="controls" id="ket"> 
    			<textarea id="edit-keterangan" name="keterangan" placeholder="Keterangan" value=""></textarea>
        	</div>
        </div> 
        <a id="btn-hapus-aktivitas" class="btn" role="button" href="#modal-3" data-toggle="modal">Hapus Aktivitas</a>
        <button id="btn-edit-keterangan" class="btn btn-primary">Edit Keterangan</button>     
    </form>
</div>

