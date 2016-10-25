<?php

    require_once('../assets/html2pdf_v4.03/html2pdf.class.php');
    require_once('../config.php');
    // include dirname(__FILE__)."/config.php";
    // get the HTML
    ob_start();
    $kode_jurusanfak=$_POST['jurusan'];
    $kode=explode('/', $kode_jurusanfak);
    $kode_jurusan=$kode[0];
    $kode_fak=$kode[1];
    $nama_jur=$kode[2];
    $sql="SELECT * FROM fakultas where id_fakultas='$kode_fak'";
    
    $query = mysql_query("SELECT * FROM fakultas where id_fakultas='$kode_fak'");
    $data = mysql_fetch_array($query);  
    //$result=mysql_query($sql);
    //$data=mysql_fetch_assoc($result);
//print_r($data);
    $fakultas=$data[1];


    $sql_detail_dosen = mysql_query("SELECT * FROM dosen WHERE nip = '$_POST[nip]'");
    $dosen = mysql_fetch_assoc($sql_detail_dosen);

      $sql_matku="SELECT *, jadwal.hari as hariJadwal
            FROM pengampu
            INNER JOIN penawaran USING( Id_Penawaran )
            INNER JOIN dosen ON pengampu.Nip_Dosen = dosen.nip
            INNER JOIN jadwal ON penawaran.Id_Penawaran = jadwal.Id_Penawaran
            INNER JOIN matkul ON penawaran.Id_MataKuliah = matkul.id_matkul
            WHERE nip = '$_POST[nip]'";
    // echo $sql_matkul;
    // exit(); 
        $sql_matkul = mysql_query($sql_matku);


        $selectkejur="SELECT *
                FROM jurusan
                INNER JOIN dosen ON jurusan.ketua_jur = dosen.nip
                WHERE jurusan.id_jurusan = '$kode_jurusan'";
                
        $res=mysql_query($selectkejur);
        $datakejur = mysql_fetch_array($res); 



    
    ?>

        <style type="text/css">
            h3, h2{
                padding: 0;
                margin: 0;
            }
            h3{
                font-size: 16px;
            }
            h2{
                font-size: 20px;
            }
            .hr{
                height: 2px;
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
                width: 90%;
                margin: 10px 0;
            }
        </style>
    <page>
        
        <div style="padding: 70px; padding-bottom : 0;">
            
            <table style="width: 100%; text-align:center;">
                <tr>
                    <td style="width: 80px;">
                        <img src="../undiksha.png" style="width: 100%">
                    </td>
                    <td style="text-align: center; width: 550px;">
                        <h3>KEMENTRIAN RISET TEKNOLOGI & PERGURUAN TINGGI</h3>
                        <h2>UNIVERSITAS PENDIDIKAN GANESHA</h2>
                        <h2>FAKULTAS TEKNIK DAN KEJURUAN</h2>
                        <h2>JURUSAN PENDIDIKAN TEKNIK INFORMATIKA</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Alamat : Jalan Udayana (Kampus Tengah) Singaraja-Bali Telp. (0362)27213 Fax.(0362)25571
                    </td>
                </tr>
            </table>

            <div class="hr"></div>

        </div>
            
            <h2 style="text-align:center;"><u>SURAT TUGAS</u></h2>
            <p style="text-align:center;">Nomor    : &nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;/<?php echo $_POST['sk-tahun'] ?></p>

            <br>
            
            <div style="padding: 0 100px 0 70px;">
                
<table width="500px">
    <tr>
        <td style="width: 600px;">
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan No 165/UN48.7.10/VIII/2015 Perihal: Permohonan Dosen Pengampu Mata Kuliah ICT di Jurusan <?php echo $nama_jur;?>, maka saya sebagai Ketua Jurusan 
                    <?php echo $nama_jur;?>, <?php echo $fakultas;?>, Universitas Pendidikan Ganesha menugaskan:
                </p>
            </td>
        </tr>
</table>
<table width="500px">
<tr>
    <td style="width:600px;">
                <p style="margin-left:100px;">
                    Nama        : <?php echo $dosen['nama'] ?>
                </p>
    </td>
</tr>
</table>
<table width="500px">
    <tr>
        <td style="width: 600px;">
                <p>
                    Untuk mengampu Mata Kuliah sebagai berikut:

                </p>
            </td>
        </tr>
        <tr>
            <td>
            <ol>
               <?php 
                while($rsql_matkul= mysql_fetch_array($sql_matkul)){
                    echo '<li>'.$rsql_matkul['id_matkul'].' '.$rsql_matkul['matkul'].' pada hari '.$rsql_matkul['hariJadwal'].'</li>';
                }

               ?>  
           </ol>
            </td>
        </tr>
</table>

                <div style="margin-left: 450px; margin-top:250px;">
                    Singaraja, 25 September 2016<br>
                    Ketua Jurusan 
                    <br>
                    <br><br>
                    <br>
                    <br>
                    <br>

                    <?php echo $datakejur['nama']?>
                </div>


            </div>
    </page>

    <?php

    // exit();
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->setDefaultFont('times');

        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');

        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // add the automatic index
        // $html2pdf->createIndex('Sommaire', 30, 12, false, true, 2);

        // send the PDF
        $html2pdf->Output('sk.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
