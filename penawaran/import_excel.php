<?php
    require_once 'assets/PHPExcel/Classes/PHPExcel/IOFactory.php';


    $file_name  = $_FILES['file']['tmp_name'];
    $result = true;

    $objPHPExcel = PHPExcel_IOFactory::load($file_name);
    
    $temp_tim[]=0;
    $temp_jam[]=0;
    $temp_dosen[]='';
    $temp_hari[]='';
    $temp_ruangan[]='';
    $temp_matkul[]='';
    $pesanError[]='';
    $temp_jamHari[] = '';
    $ulang = 0;
    $sql_penawaran="";
    $sql_jadwal="";
    $sql_pengampu="";


    function cariIndexDiarray($value, $array){
        foreach ($array as $key => $value1) {
            if ($value == $value1){
                return $key;
            }
        }
        return false;
    }


    function checkJamHarisama($hari, $jam, $temp_jamHari){
        // $dataJamA=explode(",", $temp_jam[$indexNipSama]);
        // $dataJamB=explode(",", $val[9]);
        
        //  $hasil=compareJam($dataJamA, $dataJamB);
        
        foreach ($temp_jamHari[$hari] as $key => $value) {
            $jamA = explode(',', $jam);
            $jamB = explode(',', $value);
            if (compareJam($jamA, $jamB)){
                return true;
            }
        }   

        return false;
    }

    function compareJam($jamA, $jamB){
        foreach ($jamA as $a1 ) {
            foreach ($jamB as $b1 ) {
                if($a1 == $b1){
                    return true;
                }
            }
        }
        return false;
    }



foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    
    for ($row = 2; $row <= $highestRow; ++ $row) {

        $val=array();
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val[] = $cell->getValue();                                
        }

        //cek data duplikat
        $ar_angka_romawi = array(
            '',
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IV' => 4,
            'V' => 5,
            'VI' => 6,
            'VII' => 7,
            'VIII' => 8,
            'IX'=>9,
            'X'=>10
        );
        $kodeMatkul = $val[2];
        $sql_duplikat = "SELECT * FROM matkul WHERE RIGHT(id_matkul, 7) = '$kodeMatkul'";
        $query = mysql_query($sql_duplikat);
        $matkulDb = mysql_fetch_assoc($query);
        $thn_ajar=date('Y');
        $id_matakuliah = $matkulDb['id_matkul'];
        $hari=$val[8];
        $jam=$val[9];
        // echo $val[4];
        // echo '<br>';
        // exit;
        $semester = $val[4];
        $kelas = $val[3];
        $nama_ruang = $val[10];

        //mencari id ruang
        $sql_ruangan="SELECT * FROM ruangan WHERE ruangan='$nama_ruang'";
        $row_ruang=mysql_fetch_array(mysql_query($sql_ruangan));
        $id_ruang=$row_ruang[0];
       
        //id penawaran
        $id_penawaran =$id_matakuliah . substr($thn_ajar,2,2) . $semester . $kelas;
                
        //cek keberaddan data id_penawaran
        $query_penawaran = mysql_query("SELECT Id_Penawaran FROM penawaran WHERE Id_Penawaran = '$id_penawaran' ");
        $cek_penawran = mysql_num_rows($query_penawaran);


        if($cek_penawran > 0){
                    $id_penawaran = mysql_result($query_penawaran,0);
                    // echo '
                    // <div class="alert alert-danger">
                    //     <button type="button" class="close" data-dismiss="alert">&times;</button>
                    //     <strong>Pemberitahuan!</strong>  Data Penawaran '.$id_matakuliah.' Duplikat
                    // </div>
                    // ';
                    $pesanError[sizeof($pesanError)]='Data Penawaran '.$id_matakuliah.' Duplikat';

        }else{

                
             
                if ($val[6] != '')
                {

                  
                    if(in_array($val[0], $temp_tim)){

                        $indexTimSama = cariIndexDiarray($val[0], $temp_tim);
                       
                       //id tim sama
                        if($temp_tim[$indexTimSama] == $val[0]){

                            //matkul sama
                            if($temp_matkul[$indexTimSama] == $val[2]){

                                //ruang sama    
                                if($temp_ruangan[$indexTimSama] == $val[10]){

                                    if ($ulang == 0){

                                       $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                       $sql_pengampu.="('','$id_penawaran','$temp_dosen[$indexTimSama]',''),";
                                    
                                        $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                        //echo "tim nip ".$temp_dosen[$indexTimSama];
                                            
                                        $ulang = 1;
                                    }
                                    $sql_pengampu.="('','$id_penawaran','$val[6]',''),";

                                   // echo "tim nip ".$val[6]. "<br>";
                                    


                                }
                                else{

                                    $pesanError[sizeof($pesanError)]='Salah Input, Tidak Bertim karena Id tim '.$val[0].' Sama, Matakuliah '.$val[2].' Sama, Tapi Ruangan tidak sama';
                                    
                                }


                                $pesanError[sizeof($pesanError)]='Salah Input, Tidak Bertim karena Id tim '.$val[0].' Sama, tapi Matakuliah tidak Sama';
                            }

                            $pesanError[sizeof($pesanError)]='Salah Input, Tidak Bertim karena Id tim '.$val[0].' tidak Sama';

                            
                        }


                    }
                    else

                    {


                        //lihat apakah dosen sebelumnya sama
                            if (in_array($val[6], $temp_dosen)){
                                    


                                    $indexNipSama = cariIndexDiarray($val[6], $temp_dosen);

                                    
                                        //lihat apakah hari sama
                                    if ($temp_hari[$indexNipSama] == $val[8]){


                                        //lihat apakah jam sama
                                        $hari = strtolower($val[8]);


                                        if(sizeof($temp_jamHari[$hari]) > 0 && checkJamHarisama($hari, $val[9], $temp_jamHari)){
                                            $pesanError[sizeof($pesanError)]='Matakuliah '.$val[2].' bentrok dosen, hari dan Jam sama';

                                            // echo 'error jam sama pada hari '.$hari.' dan '.$val[9].'<br>';
                                        }
                                        else{
                                            $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                            $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                            
                                            $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                        }



                                    }
                                    //dosen saja yang sama
                                    else
                                    {
                                         $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                        $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                            
                                        $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                    }

                                }
                                //compare ruangan
                           else if(in_array($val[10], $temp_ruangan)){

                                $indexRuanganSama = cariIndexDiarray($val[10], $temp_ruangan);

                                
                                    //lihat apakah hari sama
                                if ($temp_hari[$indexRuanganSama] == $val[8]){

                                     //lihat apakah jam sama
                                        $hari = strtolower($val[8]);


                                        if(sizeof($temp_jamHari[$hari]) > 0 && checkJamHarisama($hari, $val[9], $temp_jamHari)){
                                            $pesanError[sizeof($pesanError)]='Matakuliah '.$val[2].' bentrok ruangan, hari dan Jam sama';

                                            // echo 'error jam sama pada hari '.$hari.' dan '.$val[9].'<br>';
                                        }
                                        else{
                                            $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                            $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                            
                                            $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                        }


                                     // $dataJamA=explode(",", $temp_jam[$indexRuanganSama]);
                                     //    $dataJamB=explode(",", $val[9]);
                                     //    //jam
                                     //     $hasil=compareJam($dataJamA,$dataJamB);

                                     //    if($hasil){
                                     //        $pesanError[sizeof($pesanError)]='Matakuliah '.$val[2].' bentrok dengan '.$temp_matkul[$indexRuanganSama].' Ruangan, hari dan Jam sama';
                                        
                                     //    }
                                     //    //hanya hari dan ruangan sama tidak bentrok 
                                     //    else
                                     //    {
                                     //        $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                     //        $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                            
                                     //        $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                     //    }



                                }
                                //hanya ruangan sama tidak bentrok 
                              else
                                {
                                    $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                    $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                            
                                    $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                                 }
                            }
                            //dosen tidak sama dan juga ruangan tidak sama (tidak masuk ke kondisi diatasnya)
                            else 
                            {
                                 $sql_penawaran.="('','$id_penawaran','$id_matakuliah','$kelas','$thn_ajar','$semester','','','',''),";

                                $sql_pengampu.="('','$id_penawaran','$val[6]',''),";
                                    
                                $sql_jadwal.="('','$id_ruang','$id_penawaran','$hari','$jam','2','','$thn_ajar',''),";
                               
                            }



                   }

                    $temp_matkul[sizeof($temp_matkul)]=$val[2];
                    $temp_tim[sizeof($temp_tim)]=$val[0];
                    $temp_jam[sizeof($temp_jam)]=$val[9];
                    $temp_dosen[sizeof($temp_dosen)]=$val[6];
                    $temp_hari[sizeof($temp_hari)]=$val[8];
                    $temp_ruangan[sizeof($temp_ruangan)]=$val[10];

                    $hari = strtolower($val[8]);
                    if (isset($temp_jamHari[$hari])){
                        $temp_jamHari[$hari][sizeof($temp_jamHari[$hari])] = $val[9];
                    }
                    else{
                        $temp_jamHari[$hari][0] = $val[9];
                    }

                // }
            }
            
        }

    
    }
  

}


// print_r($pesanError);
// echo sizeof($pesanError);
if(sizeof($pesanError) > 1){
    
    echo '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>';
                       
                foreach ($pesanError as $key => $error) {
                    if($key == 0){
                        echo '';
                    }else{

                     echo '<ul>
                            <li> <strong>Pemberitahuan!</strong> '.$key.' '.$error.'</li>
                        </ul>';
                    }
                }
    echo '<div style="text-align:right;"><a style="text-align:right;" href="index.php?page=penawaran/tampil.php">Kembali</a></div>';
    echo '</div>';
    //mysql_query($sql);
}else{
    
    $sql_penawaranfix='INSERT INTO penawaran VALUES'.substr($sql_penawaran, 0,-1);
    $sql_pengampufix='INSERT INTO pengampu VALUES'.substr($sql_pengampu, 0,-1);
    $sql_jadwalfix='INSERT INTO jadwal VALUES'.substr($sql_jadwal, 0,-1);
    // echo $sql_penawaranfix;
    // echo $sql_pengampufix;
    // echo $sql_jadwalfix;
    mysql_query($sql_penawaranfix);
    mysql_query($sql_pengampufix);
    mysql_query($sql_jadwalfix);

    echo '
            <div class="alert alert-success">
            <p>
                Data berhasil diinput.Tunggu beberapa saat halaman sedang dialihkan ...
            <p>
            </div>

    ';
    echo '<meta http-equiv="refresh" content="2; url=index.php?page=penawaran/tampil.php" />';
    //header("Location: index.php?page=penawaran/tampil.php");
    
   
}

?>

