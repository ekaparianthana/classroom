<?php if (isset($_SESSION['userlogin'])) { ?>
<style>
hr.style {
    height: 30px;
    border-style: solid;
    border-color: black;
    border-width: 1px 0 0 0;
    border-radius: 20px;
}
hr.style:before { /* Not really supposed to work, but does */
    display: block;
    content: "";
    height: 30px;
    margin-top: -31px;    
    border-style: solid;
    border-color: black;
    border-width: 0 0 1px 0;
    border-radius: 20px;
}
</style>
<div class="span12">
   	<div class="box">
    	<div class="box-title">
        	<h3> <i class="icon-reorder"></i> Halaman Sambutan </h3>
        </div>
        <div class="box-content">
        	<div class="span4" style="float:left">
				<img src="assets/img/logo-app-big.png" height="85%" width="85%" />
    		</div>
           	<div class="span8" style="float:left">
    			<div align="left" style="margin-left:20px"><h3>Selamat Datang di Sistem Web Classroom Schedule and Activity Information</h3></div>
           		 <hr class="style"/>
           		 <div align="left" style="margin-left:20px">
              	  <p>Selamat datang, <?php echo $_SESSION['username'];?></p><br />
               	 Ini halaman sambutan ketika berhasil login.<br />
               	 Pilih menu yang tersedia di atas untuk memanfaatkan fasilitas pada sistem web ini.
           	 </div>	
        
   	 </div>
        </div>
     </div>
</div> 

<?php } else { echo "<meta http-equiv='refresh' content='1; url=index.php'>";} ?>