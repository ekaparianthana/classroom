<?php

    require_once('assets/html2pdf_v4.03/html2pdf.class.php');

    // get the HTML
    ob_start();
    
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
                        <img src="undiksha.png" style="width: 100%">
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
            <p style="text-align:center;">Nomor    : 41/UN48.11.7/PP/2015</p>

            <br>
            
            <div style="padding: 0 100px 0 70px;">
                
<table width="500px">
    <tr>
        <td style="width: 600px;">
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan No 165/UN48.7.10/VIII/2015 Perihal: Permohonan Dosen Pengampu Mata Kuliah ICT di Nama Jurusan Terkait, maka saya sebagai Ketua Nama Jurusan Terkait, Nama Fakultas, Universitas Pendidikan Ganesha menugaskan:
                </p>
            </td>
        </tr>
</table>
<table width="500px">
<tr>
    <td style="width:600px;">
                <p style="margin-left:100px;">
                    Nama        : 
                </p>
    </td>
</tr>
</table>
<table width="500px">
    <tr>
        <td style="width: 600px;">
                <p>
                    Untuk mengampu Mata Kuliah Nama mata kuliah dan semerter pada hari 
                    Demikian surat tugas ini di buat agar dapat dipergunakan sebagaimana mestinya.

                </p>
            </td>
        </tr>
</table>

                <div style="margin-left: 450px; margin-top:250px;">
                    Singaraja, 2 September 2016<br>
                    Ketua Jurusan 
                </div>


            </div>
    </page>

    <?php


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
