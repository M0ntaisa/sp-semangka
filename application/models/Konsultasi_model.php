<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi_model extends CI_Model {

    public function proses()
    {
        $gejala=array();
                $query = $this->db->query("SELECT GROUP_CONCAT(b.kode_penyakit), a.cf
                FROM tb_aturan a
                JOIN tb_penyakit b ON a.id_penyakit=b.id_penyakit
                WHERE a.id_gejala IN(".implode(',',$_POST['gejala']).") 
                GROUP BY a.id_gejala");
                foreach ($query->result_array() as $row)
                {
                    $gejala[]=$row;
                }
                $jumlah_g = count($gejala);
                for ($i=0; $i < $jumlah_g ; $i++) { 
                    $gejala[$i] = array_values($gejala[$i]);
                }

                $query = $this->db->query("SELECT nama_gejala FROM tb_gejala WHERE id_gejala IN (".implode(',',$_POST['gejala']).") 
                GROUP BY id_gejala");
                // echo "<br>";
                // echo "<h4>Gejala yang dipilih :</h4><br>";
                // $no = 1;
                // foreach ($query->result_array() as $row)
                // {
                //     echo $no++.". ".$row['nama_gejala']."<br>";
                // }
                
                // echo "<pre>";
                // print_r($gejala);
                //-- masukkan kode perhitungannya di sini

                //--- menentukan environement
                $query = $this->db->query("SELECT GROUP_CONCAT(kode_penyakit) FROM tb_penyakit");
                $row = $query->result_array();
                $fod = array_values($row[0]);
                // echo "<pre>";
                // print_r($fod);exit;

                //--- menentukan nilai densitas
                $densitas_baru=array();
                $riwayat = array();
                $riwayat_x = array();
                $r = 0;
                $densi = 3;
                // echo "<hr>";
                while(!empty($gejala)){
                    $densitas1[0]=array_shift($gejala);
                    // print_r($densitas1);
                    $densitas1[1]=array($fod[0],1-$densitas1[0][1]);
                    // print_r($densitas1);exit;
                    $densitas2=array();
                    if(empty($densitas_baru)){
                        $densitas2[0]=array_shift($gejala);
                    }else{
                        foreach($densitas_baru as $k=>$r){
                            if($k!="&theta;"){
                                $densitas2[]=array($k,$r);
                            }
                        }
                    }
                    // print_r($densitas2);exit;
                    $theta=1;
                    foreach($densitas2 as $d) $theta-=$d[1];
                    $densitas2[]=array($fod[0],$theta);
                    // print_r($densitas2);exit;
                    $m=count($densitas2);
                    $densitas_baru=array();
                    $densi_x = $densi-2;
                    $densi_y = $densi-1;
                    // echo "Menentukan Nilai Densitas (m$densi) dari Densitas (m$densi_x) dan Densitas (m$densi_y)!"."<br>";
                    // echo "Menentukan Nilai Densitas (m) baru!"."<br>";
                    
                    for($y=0;$y<$m;$y++){
                        for($x=0;$x<2;$x++){
                          // echo "<hr>";
                            if(!($y==$m-1 && $x==1)){
                                // print_r($densitas1);exit;
                                $v=explode(',',$densitas1[$x][0]);
                                $w=explode(',',$densitas2[$y][0]);
                                sort($v);
                                sort($w);
                                $vw=array_intersect($v,$w);
                                
                                if(empty($vw)){
                                    $k="&theta;";
                                }else{
                                    $k=implode(',',$vw);
                                }
                                // print_r($densitas1);
                                // print_r($densitas2);
                                
                                if(!isset($densitas_baru[$k])){
                                    $densitas_baru[$k]=$densitas1[$x][1]*$densitas2[$y][1];
                                    // echo $densitas2[$y][0]."<br>";
                                    // echo $densitas1[$x][0]." x ".$densitas2[$y][0]." = ".$densitas1[$x][0].",".$densitas2[$y][0]."<br>";
                                    // echo $densitas1[$x][1]." x ".$densitas2[$y][1]." = ".$densitas_baru[$k]."<br>";
                                  }else{
                                    $densitas_baru[$k]+=$densitas1[$x][1]*$densitas2[$y][1];
                                    // echo $densitas1[$x][1]." x ".$densitas2[$y][1]." = ".$densitas_baru[$k]."<br>";
                                  }
                                  
                            }
                        } 
                    } 
                    
                    // echo "<br>-----------------------------<br>";
                    // echo "Proses densitas baru (m)"."<br>";
                    $densi = $densi + 2;
                    foreach($densitas_baru as $k=>$d){
                      
                        if($k!="&theta;"){
                            $densitas_baru[$k]=$d/(1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0));
                            
                            $k." = ".round($d,2)." / ".round((1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0)),2)." = ".round($densitas_baru[$k],2)."<br>";
                        }
                        
                        // print_r($densitas_baru);
                        $riwayat = $densitas_baru;
                        $r++;
                    }
                    
                    $riwayat_x[] = $riwayat;
                    // echo "<hr><br>";
                }
                
                // echo "<pre>";
                // print_r($riwayat_x);
                // echo "<hr><br>";
                //--- perangkingan
                unset($densitas_baru["&theta;"]);
                arsort($densitas_baru);
                // echo "<pre>";
                // print_r($densitas_baru);die;
                // echo "<br>=============================================================<br>";
                $kd_penyakit = array();
                foreach ($densitas_baru as $key => $value) {
                  $kd_penyakit[] = $key;
                }
                
                $kds_penyakit = implode(',',$kd_penyakit);
                $kds = str_replace(",", "','", $kds_penyakit);

                // $query = $this->db->query("SELECT nama_penyakit FROM tb_penyakit WHERE kode_penyakit IN ('$kds')");
                // echo "<br>";
                // echo "<h4>Kemungkinan Penyakit / Hama :</h4><br>";
                // $no = 1;
                // foreach ($query->result_array() as $row)
                // {
                //     echo $no++.". ".$row['nama_penyakit']."<br>";
                // }
                

                $kode_penyakit = array_keys($densitas_baru)[0];
                $kode = str_replace(",", "','", $kode_penyakit);
                // echo $kode;die;
                $rank = $this->Penyakit_model->getNamaPenyakit($kode);
                // $kode = explode(' , ', $kode_penyakit);
                // print_r($densitas_baru);die;
                // print_r($rank);
                // echo "<hr>";
                if (count($rank) > 1) {
                  // $hasil_bagi = array_values($densitas_baru)[0]/count($rank);
                  for ($i=0; $i < count($rank); $i++) { 
                    echo "<b>Nilai tertinggi dari perhitungan metode Dempster Shafer adalah <strong>".$rank[$i]."</strong>, dengan nilai = <strong>".round(array_values($densitas_baru)[0],2)."</strong></b><br>";
                  }
                } else {
                    echo "<b>Nilai tertinggi dari perhitungan metode Dempster Shafer adalah <strong>".$rank[0]."</strong>, dengan nilai = <strong>".round(array_values($densitas_baru)[0],2)."</strong></b>";
                }
                // echo "<hr>";
                // $query = $this->db->query("SELECT ket, solusi FROM tb_penyakit WHERE kode_penyakit = '$kode_penyakit'");
                // echo "<br>";
                // foreach ($query->result_array() as $row)
                // {
                //     echo "<h4>Keterangan :</h4><br>";
                //     echo $row['ket']."<br>";
                    
                //     echo "<br><h4>Solusi :</h4><br>";
                //     echo $row['solusi']."<br>";
                // }
                
                return $codes = $kode_penyakit;
                // $data = [
                //     'title' =>  "Hasil Konsultasi",
                //     'riwayat'    =>  $riwayat_x,
                //     'h_akhir'  =>  $densitas_baru,
                //     'isi'   =>  "user/hasil_konsultasi"
                // ];
    
                // $this->load->view('layout/wrapper', $data, FALSE);
    }

    public function prosesCF()
    {
        // group kemungkinan terdapat penyakit
        $groupKemungkinanPenyakit = $this->Konsultasi_model->getGroupAturan(implode(",", $_POST['gejala']));
        // $gejalaYangDipilih = array();
        $kds_gejala = implode(",", $_POST['gejala']);
        $kds = str_replace(",", "','", $kds_gejala);
        $gejalaYangDipilih = $this->Konsultasi_model->getNamaGejala($kds);

        // for ($i=0; $i < count($_POST['gejala']); $i++) { 
        //   $gejalaYangDipilih[] = $this->Konsultasi_model->getNamaGejala($_POST['gejala'][$i]);
        // }

        // echo "<br>";
        // echo "<h4>Gejala yang dipilih :</h4><br>";
        // $no = 1;
        // foreach ($gejalaYangDipilih as $row)
        // {
        //     echo $no++.". ".$row['nama_gejala']."<br>";
        // }

        // menampilkan kode gejala yang di pilih
        $sql = $_POST['gejala'];

        if (isset($sql)) {
          // mencari data penyakit kemungkinan dari gejala
          for ($h=0; $h < count($sql); $h++) {
            $kemungkinanPenyakit[] = $this->Konsultasi_model->getKemungkinanPenyakit($sql[$h]);
            for ($x=0; $x < count($kemungkinanPenyakit[$h]); $x++) {
              for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) {
                $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
                if ($kemungkinanPenyakit[$h][$x]['nama_penyakit'] == $namaPenyakit) {
                  // list di kemungkinan dari gejala
                  $listIdKemungkinan[$namaPenyakit][] = $kemungkinanPenyakit[$h][$x]['id_aturan'];
                }
              }
            }
          }

          // echo "<br>";
          // echo "<h4>Kemungkinan Penyakit / Hama :</h4><br>";
          // $no = 1;
          // foreach ($groupKemungkinanPenyakit as $row)
          // {
          //     echo $no++.". ".$row['nama_penyakit']."<br>";
          // }

          $id_penyakit_terbesar = '';
          $nama_penyakit_terbesar = '';
          // list penyakit kemungkinan
          for ($h=0; $h < count($groupKemungkinanPenyakit); $h++) { 
            $namaPenyakit = $groupKemungkinanPenyakit[$h]['nama_penyakit'];
            // echo "<hr><br/>Proses Penyakit ".$h.".".$namaPenyakit."<br/>========================================================<br/>";
            // echo "Jumlah Gejala = ".
                      count($listIdKemungkinan[$namaPenyakit])."<br/>";
            // list penyakit kemungkinan dari gejala
            for ($x=0; $x < count($listIdKemungkinan[$namaPenyakit]); $x++) { 
              $daftarKemungkinanPenyakit = $this->Konsultasi_model->getListPenyakit($listIdKemungkinan[$namaPenyakit][$x]);
              $proc = $x+1;
              
              // echo "<br/>proses ".$proc."<br/>------------------------------------<br/>";
                      
              for ($i=0; $i < count($daftarKemungkinanPenyakit); $i++) {
                  
                  if (count($listIdKemungkinan[$namaPenyakit]) == 1) {
                    // echo "Jumlah Gejala = ".
                    //   count($listIdKemungkinan[$namaPenyakit])."<br/>";
                        
                    // bila list kemungkinan terdapat 1
                    $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                    $md = $daftarKemungkinanPenyakit[$i]['md'];
                    $cf = $mb - $md;
                    $daftar_cf[$namaPenyakit][] = $cf;

                    // echo "<br/>proses 1<br/>------------------------<br/>";
                    // echo "mb = ".$mb."<br/>";
                    // echo "md = ".$md."<br/>";
                    // echo "cf = mb - md = ".$mb." - ".$md." = ".$cf."<br/><br/><br/>";
                    // end bila list kemungkinan terdapat 1
                  } else {
                    // list kemungkinanan lebih dari satu
                    if ($x == 0)
                    {
                      // echo "Jumlah Gejala = ".
                      // count($listIdKemungkinan[$namaPenyakit])."<br/>";
                      // record md dan mb sebelumnya
                      $mblama = $daftarKemungkinanPenyakit[$i]['mb'];
                      $mdlama = $daftarKemungkinanPenyakit[$i]['md'];
                      // md yang di esekusi
                      $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                      $md = $daftarKemungkinanPenyakit[$i]['md'];
                      // echo "<br/>";
                      // echo "mb_baru = ".$mb."<br/>";
                      // echo "md_baru = ".$md."<br/>";
                      $cf = $mb - $md;
                      // echo "cf = mb - md = ".$mb." - ".$md." = ".$cf."<br/><br/><br/>";

                      $daftar_cf[$namaPenyakit][] = $cf;
                    } 
                    else
                    {
                      $mbbaru = $daftarKemungkinanPenyakit[$i]['mb'];
                      $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];
                      // echo "mb_baru = ".$mbbaru."<br/>";
                      // echo "md_baru = ".$mdbaru."<br/>";
                      $mbsementara = $mblama + ($mbbaru * (1 - $mblama));
                      $mdsementara = $mdlama + ($mdbaru * (1 - $mdlama));
                      // echo "mb_sementara = mb_lama + (mb_baru * (1 - mb_lama)) = $mblama + ($mbbaru * (1 - $mblama)) = ".$mbsementara."<br/>";
                      // echo "md_sementara = md_lama + (md_baru * (1 - md_lama)) = $mdlama + ($mdbaru * (1 - $mdlama)) = ".$mdsementara."<br/>";

                      $mb = $mbsementara;
                      $md = $mdsementara;
                      $cf = $mb - $md;
                      // echo "cf = mb_sementara - md_sementara = ".$mb." - ".$md." = ".$cf."<br/><br/><br/>";
                      $daftar_cf[$namaPenyakit][] = $cf;;
                    }
                    // end list kemungkinanan lebih dari satu
                  }
                }
              }  
            }
          }
          // echo "<br/>===================================================================<br/>";
        // echo "<hr>";
        // $this->Konsultasi_model->hasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit);
        $this->Konsultasi_model->hasilAkhir($daftar_cf,$groupKemungkinanPenyakit);
        

    }

    public function cloneProsesCf()
    {
      // group kemungkinan terdapat penyakit
      $groupKemungkinanPenyakit = $this->Konsultasi_model->getGroupAturan(implode(",", $_POST['gejala']));

      $kds_gejala = implode(",", $_POST['gejala']);
      $kds = str_replace(",", "','", $kds_gejala);
      $gejalaYangDipilih = $this->Konsultasi_model->getNamaGejala($kds);

      $no = 1;
      $pilihanGejala = array();
      foreach ($gejalaYangDipilih as $row)
      {
        $pilihanGejala[] = $row['nama_gejala'];
      }

      // menampilkan kode gejala yang di pilih
      $sql = $_POST['gejala'];

      if (isset($sql)) {
        // mencari data penyakit kemungkinan dari gejala
        for ($h=0; $h < count($sql); $h++) {
          $kemungkinanPenyakit[] = $this->Konsultasi_model->getKemungkinanPenyakit($sql[$h]);
          for ($x=0; $x < count($kemungkinanPenyakit[$h]); $x++) {
            for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) {
              $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
              if ($kemungkinanPenyakit[$h][$x]['nama_penyakit'] == $namaPenyakit) {
                // list di kemungkinan dari gejala
                $listIdKemungkinan[$namaPenyakit][] = $kemungkinanPenyakit[$h][$x]['id_aturan'];
              }
            }
          }
        }

        $listPenyakit = array();
        foreach ($groupKemungkinanPenyakit as $row)
        {
            $listPenyakit[] = $row['nama_penyakit'];
        }

        

        $id_penyakit_terbesar = '';
        $nama_penyakit_terbesar = '';
        // list penyakit kemungkinan
        for ($h=0; $h < count($groupKemungkinanPenyakit); $h++) { 
          $namaPenyakit = $groupKemungkinanPenyakit[$h]['nama_penyakit'];

                    count($listIdKemungkinan[$namaPenyakit])."<br/>";
          // list penyakit kemungkinan dari gejala
          for ($x=0; $x < count($listIdKemungkinan[$namaPenyakit]); $x++) { 
            $daftarKemungkinanPenyakit = $this->Konsultasi_model->getListPenyakit($listIdKemungkinan[$namaPenyakit][$x]);
            $proc = $x+1;
                    
            for ($i=0; $i < count($daftarKemungkinanPenyakit); $i++) {
                
                if (count($listIdKemungkinan[$namaPenyakit]) == 1) {
                      
                  // bila list kemungkinan terdapat 1
                  $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                  $md = $daftarKemungkinanPenyakit[$i]['md'];
                  $cf = $mb - $md;
                  $daftar_cf[$namaPenyakit][] = $cf;

                } else {
                  // list kemungkinanan lebih dari satu
                  if ($x == 0)
                  {

                    // record md dan mb sebelumnya
                    $mblama = $daftarKemungkinanPenyakit[$i]['mb'];
                    $mdlama = $daftarKemungkinanPenyakit[$i]['md'];
                    // md yang di esekusi
                    $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                    $md = $daftarKemungkinanPenyakit[$i]['md'];

                    $cf = $mb - $md;

                    $daftar_cf[$namaPenyakit][] = $cf;
                  } 
                  else
                  {
                    $mbbaru = $daftarKemungkinanPenyakit[$i]['mb'];
                    $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];

                    $mbsementara = $mblama + ($mbbaru * (1 - $mblama));
                    $mdsementara = $mdlama + ($mdbaru * (1 - $mdlama));

                    $mb = $mbsementara;
                    $md = $mdsementara;
                    $cf = $mb - $md;

                    $daftar_cf[$namaPenyakit][] = $cf;;
                  }
                  // end list kemungkinanan lebih dari satu
                }
              }
            }  
          }
        }

      $hasilCF = $this->Konsultasi_model->cloneHasilAkhir($daftar_cf,$groupKemungkinanPenyakit);

      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
          $merubahIndexCF[$i] = max($daftar_cf[$namaPenyakit]);
        }
      }

      $listKemungkinanPenyakit = array();
      for ($i=0; $i < count($listPenyakit) ; $i++) { 
        $listKemungkinanPenyakit[$i]['nama_penyakit'] = $listPenyakit[$i];  
        $listKemungkinanPenyakit[$i]['nilai'] = $merubahIndexCF[$i];  
      }
      
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $hasilMax = max($merubahIndexCF);
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        if ($merubahIndexCF[$i] === $hasilMax) {

          $query = $this->db->query("SELECT ket, solusi FROM tb_penyakit WHERE nama_penyakit = '$namaPenyakit'");
          $ket = array();
          foreach ($query->result_array() as $row)
          {

              $hasilakhir_cf[] = [
                "ph"  => $namaPenyakit,
                "nilai" => $merubahIndexCF[$i],
                "solusi" => $row
              ];
          }
        }
      }
      
      $data = [
        "gejala" => $pilihanGejala,
        "list_penyakit" => $listKemungkinanPenyakit,
        "hasil" => [
          "penyakit_ds" => $hasilCF['penyakit_cf'],
          "nilai" => $hasilCF['nilai']
        ],
        "hasilakhir_cf" => $hasilakhir_cf
      ];
      
      return $data;
      
    }

    public function cloneProsesDs()
    {
      $gejala=array();
                $query = $this->db->query("SELECT GROUP_CONCAT(b.kode_penyakit), a.cf
                FROM tb_aturan a
                JOIN tb_penyakit b ON a.id_penyakit=b.id_penyakit
                WHERE a.id_gejala IN(".implode(',',$_POST['gejala']).") 
                GROUP BY a.id_gejala");
                foreach ($query->result_array() as $row)
                {
                    $gejala[]=$row;
                }
                $jumlah_g = count($gejala);
                for ($i=0; $i < $jumlah_g ; $i++) { 
                    $gejala[$i] = array_values($gejala[$i]);
                }

                $query = $this->db->query("SELECT nama_gejala FROM tb_gejala WHERE id_gejala IN (".implode(',',$_POST['gejala']).") 
                GROUP BY id_gejala");

                $pilihanGejala = array();
                foreach ($query->result_array() as $row)
                {
                    $pilihanGejala[] = $row['nama_gejala'];
                }

                //-- masukkan kode perhitungannya di sini

                //--- menentukan environement
                $query = $this->db->query("SELECT GROUP_CONCAT(kode_penyakit) FROM tb_penyakit");
                $row = $query->result_array();
                $fod = array_values($row[0]);

                //--- menentukan nilai densitas
                $densitas_baru=array();
                $riwayat = array();
                $riwayat_x = array();
                $r = 0;
                $densi = 3;

                while(!empty($gejala)){
                    $densitas1[0]=array_shift($gejala);

                    $densitas1[1]=array($fod[0],1-$densitas1[0][1]);

                    $densitas2=array();
                    if(empty($densitas_baru)){
                        $densitas2[0]=array_shift($gejala);
                    }else{
                        foreach($densitas_baru as $k=>$r){
                            if($k!="&theta;"){
                                $densitas2[]=array($k,$r);
                            }
                        }
                    }

                    $theta=1;
                    foreach($densitas2 as $d) $theta-=$d[1];
                    $densitas2[]=array($fod[0],$theta);

                    $m=count($densitas2);
                    $densitas_baru=array();
                    $densi_x = $densi-2;
                    $densi_y = $densi-1;

                    for($y=0;$y<$m;$y++){
                        for($x=0;$x<2;$x++){

                            if(!($y==$m-1 && $x==1)){

                                $v=explode(',',$densitas1[$x][0]);
                                $w=explode(',',$densitas2[$y][0]);
                                sort($v);
                                sort($w);
                                $vw=array_intersect($v,$w);
                                
                                if(empty($vw)){
                                    $k="&theta;";
                                }else{
                                    $k=implode(',',$vw);
                                }

                                
                                if(!isset($densitas_baru[$k])){
                                    $densitas_baru[$k]=$densitas1[$x][1]*$densitas2[$y][1];

                                  }else{
                                    $densitas_baru[$k]+=($densitas1[$x][1]*$densitas2[$y][1]);

                                  }
                                  
                            }
                        } 
                    } 

                    $densi = $densi + 2;
                    foreach($densitas_baru as $k=>$d){
                      
                        if($k!="&theta;"){

                            $densitas_baru[$k] = $d / (1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0));

                        }
                        
                        $riwayat = $densitas_baru;
                        $r++;
                    }
                    
                    $riwayat_x[] = $riwayat;
                }
                
                //--- perangkingan
                unset($densitas_baru["&theta;"]);
                arsort($densitas_baru);

                $kd_penyakit = array();
                foreach ($densitas_baru as $key => $value) {
                  $kd_penyakit[] = $key;
                }
                
                    
                $kds_penyakit = implode(',',$kd_penyakit);
                $kds = str_replace(",", "','", $kds_penyakit);

                $query = $this->db->query("SELECT nama_penyakit FROM tb_penyakit WHERE kode_penyakit IN ('$kds')");
                $nama_penyakit = $query->result_array();
                $listPenyakit = array();
                $no=0;
                $densitas = array_values($densitas_baru);
                
                foreach ($nama_penyakit as $row)
                {
                    $listPenyakit[$no]['nama_penyakit'] = $row['nama_penyakit'];
                    
                    $no++;
                }
                

                $kode_penyakit = array_keys($densitas_baru)[0];
                $kode = str_replace(",", "','", $kode_penyakit);

                $rank = $this->Penyakit_model->getNamaPenyakit($kode);

                $hasil = [];
                if (count($rank) > 1) {

                  for ($i=0; $i < count($rank); $i++) { 

                    $hasil = [
                      "penyakit_ds" => $rank[i],
                      "nilai" => round(array_values($densitas_baru)[0],2)
                    ];
                  }
                } else {

                    $penyakit_ds = $rank[0];
                    $nilai = round(array_values($densitas_baru)[0],2);
                }
                
                $query = $this->db->query("SELECT ket, solusi FROM tb_penyakit WHERE kode_penyakit = '$kode_penyakit'");
                $ket = array();
                foreach ($query->result_array() as $row)
                {
                    $ket[] = $row;
                }

                if (empty($hasil)) {
                  $data = [
                    "gejala" => $pilihanGejala,
                    "list_penyakit" => $listPenyakit,
                    "hasil" => [
                      "penyakit_ds" => $penyakit_ds,
                      "nilai" => $nilai
                    ],
                    "ket" => $ket
                  ];
                } else {
                  $data = [
                    "gejala" => $pilihanGejala,
                    "list_penyakit" => $listPenyakit,
                    "hasil" => $hasil,
                    "ket" => $ket
                  ];
                }
                
                return $data;
    }

    public function getKonsulAkhirUser($id_user)
    {
      $query = $this->db->query("SELECT * FROM tb_riwayat WHERE id_user = $id_user ORDER BY id_riwayat DESC LIMIT 1");

      return $query->result_array();
    }

    public function rank()
    {
          $gejala=array();
                $query = $this->db->query("SELECT GROUP_CONCAT(b.kode_penyakit), a.cf
                FROM tb_aturan a
                JOIN tb_penyakit b ON a.id_penyakit=b.id_penyakit
                WHERE a.id_gejala IN(".implode(',',$_POST['gejala']).") 
                GROUP BY a.id_gejala");
                foreach ($query->result_array() as $row)
                {
                    $gejala[]=$row;
                }
                $jumlah_g = count($gejala);
                for ($i=0; $i < $jumlah_g ; $i++) { 
                    $gejala[$i] = array_values($gejala[$i]);
                }
                
                // echo "<pre>";
                // print_r($gejala);
                //-- masukkan kode perhitungannya di sini

                //--- menentukan environement
                $query = $this->db->query("SELECT GROUP_CONCAT(kode_penyakit) FROM tb_penyakit");
                $row = $query->result_array();
                $fod = array_values($row[0]);
                // echo "<pre>";
                // print_r($fod);exit;

                //--- menentukan nilai densitas
                $densitas_baru=array();
                $riwayat = array();
                $riwayat_x = array();
                $r = 0;
                $densi = 3;
                while(!empty($gejala)){
                    $densitas1[0]=array_shift($gejala);
                    // print_r($densitas1);
                    $densitas1[1]=array($fod[0],1-$densitas1[0][1]);
                    // print_r($densitas1);exit;
                    $densitas2=array();
                    if(empty($densitas_baru)){
                        $densitas2[0]=array_shift($gejala);
                    }else{
                        foreach($densitas_baru as $k=>$r){
                            if($k!="&theta;"){
                                $densitas2[]=array($k,$r);
                            }
                        }
                    }
                    // print_r($densitas2);exit;
                    $theta=1;
                    foreach($densitas2 as $d) $theta-=$d[1];
                    $densitas2[]=array($fod[0],$theta);
                    // print_r($densitas2);exit;
                    $m=count($densitas2);
                    $densitas_baru=array();
                    $densi_x = $densi-2;
                    $densi_y = $densi-1;
                    // echo "Menentukan Nilai Densitas (m$densi) dari Densitas (m$densi_x) dan Densitas (m$densi_y)!"."<br>";
                    // echo "Menentukan Nilai Densitas (m) baru!"."<br>";
                    
                    for($y=0;$y<$m;$y++){
                        for($x=0;$x<2;$x++){
                          // echo "<hr>";
                            if(!($y==$m-1 && $x==1)){
                                // print_r($densitas1);exit;
                                $v=explode(',',$densitas1[$x][0]);
                                $w=explode(',',$densitas2[$y][0]);
                                sort($v);
                                sort($w);
                                $vw=array_intersect($v,$w);
                                
                                if(empty($vw)){
                                    $k="&theta;";
                                }else{
                                    $k=implode(',',$vw);
                                }
                                // print_r($densitas1);
                                // print_r($densitas2);
                                
                                if(!isset($densitas_baru[$k])){
                                    $densitas_baru[$k]=$densitas1[$x][1]*$densitas2[$y][1];
                                    // echo $densitas2[$y][0]."<br>";
                                    // echo $densitas1[$x][0]." x ".$densitas2[$y][0]." = ".$densitas1[$x][0].",".$densitas2[$y][0]."<br>";
                                    // echo $densitas1[$x][1]." x ".$densitas2[$y][1]." = ".$densitas_baru[$k]."<br>";
                                  }else{
                                    $densitas_baru[$k]+=$densitas1[$x][1]*$densitas2[$y][1];
                                    // echo $densitas1[$x][1]." x ".$densitas2[$y][1]." = ".$densitas_baru[$k]."<br>";
                                  }
                                  
                            }
                        } 
                    } 
                    
                    $densi = $densi + 2;
                    foreach($densitas_baru as $k=>$d){
                      
                        if($k!="&theta;"){
                            $densitas_baru[$k]=$d/(1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0));
                            
                        }
                        
                        // print_r($densitas_baru);
                        $riwayat = $densitas_baru;
                        $r++;
                    }
                    
                    $riwayat_x[] = $riwayat;
                    // echo "<hr><br>";
                }
                
                // echo "<pre>";
                // print_r($riwayat_x);die;
                // echo "<hr><br>";
                //--- perangkingan
                unset($densitas_baru["&theta;"]);
                arsort($densitas_baru);
                // print_r($densitas_baru);die;
                $kode_ds = array_keys($densitas_baru)[0];

            // cf
            // group kemungkinan terdapat penyakit
            $groupKemungkinanPenyakit = $this->Konsultasi_model->getGroupAturan(implode(",", $_POST['gejala']));

            // menampilkan kode gejala yang di pilih
            $sql = $_POST['gejala'];
            if (isset($sql)) {
              // mencari data penyakit kemungkinan dari gejala
              for ($h=0; $h < count($sql); $h++) {
                $kemungkinanPenyakit[] = $this->Konsultasi_model->getKemungkinanPenyakit($sql[$h]);
                for ($x=0; $x < count($kemungkinanPenyakit[$h]); $x++) {
                  for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) {
                    $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
                    // $kodes_p = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
                    if ($kemungkinanPenyakit[$h][$x]['nama_penyakit'] == $namaPenyakit) {
                      // list di kemungkinan dari gejala
                      $listIdKemungkinan[$namaPenyakit][] = $kemungkinanPenyakit[$h][$x]['id_aturan'];
                    }
                  }
                }
              }

              // echo "<pre>";
              // print_r($listIdKemungkinan);
              $nama_p = array();
              foreach ($listIdKemungkinan as $key => $value) {
                $nama_p[] = $key;
              }
              // print_r($nama_p);
              $kodes_p = array();
              for ($i=0; $i < count($nama_p); $i++) { 
                $kodes_p[] = $this->Konsultasi_model->getKodePenyakit($nama_p[$i]);
              }

              $kodes = array();
              for ($i=0; $i < count($kodes_p) ; $i++) { 
                $kodes[] = $kodes_p[$i]['kode_penyakit'];
              }


              // echo $kodes_p = json_encode($kodes);

              // print_r($kodes);die;

              $id_penyakit_terbesar = '';
              $nama_penyakit_terbesar = '';
              // list penyakit kemungkinan
              for ($h=0; $h < count($groupKemungkinanPenyakit); $h++) { 
                $namaPenyakit = $groupKemungkinanPenyakit[$h]['nama_penyakit'];
                // list penyakit kemungkinan dari gejala
                for ($x=0; $x < count($listIdKemungkinan[$namaPenyakit]); $x++) { 
                  $daftarKemungkinanPenyakit = $this->Konsultasi_model->getListPenyakit($listIdKemungkinan[$namaPenyakit][$x]);
                  $proc = $x+1;
                          
                  for ($i=0; $i < count($daftarKemungkinanPenyakit); $i++) {
                      
                      if (count($listIdKemungkinan[$namaPenyakit]) == 1) {
                        // echo "Jumlah Gejala = ".
                        //   count($listIdKemungkinan[$namaPenyakit])."<br/>";
                            
                        // bila list kemungkinan terdapat 1
                        $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                        $md = $daftarKemungkinanPenyakit[$i]['md'];
                        $cf = $mb - $md;
                        $daftar_cf[$namaPenyakit][] = $cf;
                        // end bila list kemungkinan terdapat 1
                      } else {
                        // list kemungkinanan lebih dari satu
                        if ($x == 0)
                        {
                          // echo "Jumlah Gejala = ".
                          // count($listIdKemungkinan[$namaPenyakit])."<br/>";
                          // record md dan mb sebelumnya
                          $mblama = $daftarKemungkinanPenyakit[$i]['mb'];
                          $mdlama = $daftarKemungkinanPenyakit[$i]['md'];
                          // md yang di esekusi
                          $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                          $md = $daftarKemungkinanPenyakit[$i]['md'];
                          $cf = $mb - $md;

                          $daftar_cf[$namaPenyakit][] = $cf;
                        } 
                        else
                        {
                          $mbbaru = $daftarKemungkinanPenyakit[$i]['mb'];
                          $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];

                          $mbsementara = $mblama + ($mbbaru * (1 - $mblama));
                          $mdsementara = $mdlama + ($mdbaru * (1 - $mdlama));

                          $mb = $mbsementara;
                          $md = $mdsementara;
                          $cf = $mb - $md;

                          $daftar_cf[$namaPenyakit][] = $cf;;
                        }
                        // end list kemungkinanan lebih dari satu
                      }
                    }
                  }  
                }
              }
            // $this->Konsultasi_model->cloneHasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit);
            // $this->Konsultasi_model->cloneHasilAkhir($daftar_cf,$groupKemungkinanPenyakit);

            // for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
            //   $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
            //   for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
            //     $merubahIndexCF = max($daftar_cf[$namaPenyakit]);
            //   }
            // }

            $merubahIndexCF = array();
            for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
              $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
              for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
                $merubahIndexCF[$i] = max($daftar_cf[$namaPenyakit]);
              }
            }
            
            for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
              $hasilMax = max($merubahIndexCF);
              $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
              if ($merubahIndexCF[$i] === $hasilMax) {  
                
                $query = $this->db->query("SELECT kode_penyakit
                      FROM tb_penyakit
                      WHERE nama_penyakit = '$namaPenyakit'
                ");
      
                $kode_penyakit =array();
                foreach ($query->result() as $row)
                {
                    $kode_penyakit[] = $row->kode_penyakit;
                }
              }
            }
            $kode_p = array();
            foreach ($densitas_baru as $key => $value) {
              $kode_p[] = $key;
            }

            // echo $kodes = implode(',',$kode_p);die;
            $kode_cf = implode(',',$kode_penyakit);
            
            $ids = implode(',',$_POST['gejala']);
            $kode_gejala = $this->Gejala_model->getKode($ids);
            $codes = implode(',',$kode_gejala);

            $data = [
                'id_user' => $this->session->userdata('id_user'),
                'kode_gejala' => $codes,
                'prob_penyakit_ds' => json_encode($kode_p),
                'prob_penyakit_cf' => json_encode($kodes),
                'kode_penyakit_ds' => $kode_ds,
                'kode_penyakit_cf' => $kode_cf,
                'tanggal_konsul' => time()
            ];

            // print_r($data);die;

            $this->db->insert('tb_riwayat', $data);
    }

     /**
     * Gets the group tb_aturan.
     *
     * mengambil salah satu nama penyakit bila terdapat nama penyakit sama
     */
    public function getGroupAturan($value)
    {
      // p, g , pyt merupakan inisialisasi dari tabel yang dituju
      $query = $this->db->query("SELECT
            pyt.nama_penyakit 
        FROM
            tb_aturan p
            JOIN tb_gejala g ON p.id_gejala = g.id_gejala
            JOIN tb_penyakit pyt ON p.id_penyakit = pyt.id_penyakit 
        WHERE
            p.id_gejala IN ( $value ) 
        GROUP BY
            p.id_penyakit 
        ORDER BY
            p.id_penyakit");

      return $query->result_array();

    //   if (isset($result)) {
    //     // merubah data tabel menjadi array
    //     $row = [];
    //     while ($row = $result->fetch_assoc()) {
    //       $rows[] = $row;
    //     }

    //     return $rows;
    //   }

    }

    /**
     * Gets the kemungkinan penyakit.
     *
     * mengambil data tb_aturan bila terdapat gejala
     */
    public function getKemungkinanPenyakit($sql)
    {
      // p, g , pyt merupakan inisialisasi dari tabel yang dituju
      $query = $this->db->query("SELECT pyt.kode_penyakit, pyt.nama_penyakit, p.id_aturan FROM tb_aturan p
        JOIN tb_gejala g ON p.id_gejala = g.id_gejala
        JOIN tb_penyakit pyt ON p.id_penyakit = pyt.id_penyakit
        WHERE g.id_gejala IN ($sql)");
      
      return $query->result_array();

    //   if (isset($result)) {
    //     // merubah data tabel menjadi array
    //     $row = [];
    //     while ($row = $result->fetch_assoc()) {
    //       $rows[] = $row;
    //     }

    //     return $rows;
    //   }

    }

    public function getListPenyakit($value)
    {
      // p, g , pyt merupakan inisialisasi dari tabel yang dituju
      $query = $this->db->query("SELECT * FROM tb_aturan p
        JOIN tb_gejala g ON p.id_gejala = g.id_gejala
        JOIN tb_penyakit pyt ON p.id_penyakit = pyt.id_penyakit
        WHERE p.id_aturan IN ($value)");
      
      return $query->result_array();

    // if (isset($result)) {
    //     // merubah data tabel menjadi array
    //     $row = [];
    //     while ($row = $result->fetch_assoc()) {
    //     $rows[] = $row;
    //     }

    //     return $rows;
    // }
    }

    public function getKodePenyakit($value)
    {
      $query = $this->db->query("SELECT kode_penyakit FROM tb_penyakit WHERE nama_penyakit = '$value'");

      return $query->row_array();
    }

    public function getNamaPenyakit($kode)
    {
      $query = $this->db->query("SELECT nama_penyakit FROM tb_penyakit WHERE kode_penyakit IN ('$kode')");

      return $query->result_array();
    }

    public function getRankPenyakit($kode)
    {
      $query = $this->db->query("SELECT nama_penyakit, ket, solusi FROM tb_penyakit WHERE kode_penyakit = '$kode'");

      return $query->row_array();
    }

    public function getNamaGejala($value)
    {
      $query = $this->db->query("SELECT nama_gejala FROM tb_gejala
        WHERE id_gejala IN ('$value')");
      
      return $query->result_array();
    }

    public function getNamaGejalaByKode($value)
    {
      $query = $this->db->query("SELECT nama_gejala FROM tb_gejala
        WHERE kode_gejala IN ('$value')");
      
      return $query->result_array();
    }

    public function hasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit)
    {
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        // echo "<br/>Nama Penyakit = ".$namaPenyakit."<br/>";
        for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
          $merubahIndexCF = max($daftar_cf[$namaPenyakit]);
        }

        echo "Nilai CF Tertinggi Di Kandidat Penyakit = ".$merubahIndexCF."<br>";
        // echo "<br/>-------------------------------------------------------------------------<br/>";
      }
    }

    public function hasilAkhir($daftar_cf,$groupKemungkinanPenyakit)
    {
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
          $merubahIndexCF[$i] = max($daftar_cf[$namaPenyakit]);
        }
      }
      
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $hasilMax = max($merubahIndexCF);
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        if ($merubahIndexCF[$i] === $hasilMax) {
          // $hasilakhir_cf[$i] = [
          //     "ph"  => $namaPenyakit,
          //     "nilai" => $merubahIndexCF[$i]
          // ];
          echo "<b>Nilai tertinggi dari perhitungan metode Certainty Factor adalah <strong>".$namaPenyakit."</strong>, dengan nilai = <strong>".$merubahIndexCF[$i]."</strong></b><br>";  
          
          // echo "<hr>";
          // $query = $this->db->query("SELECT ket, solusi FROM tb_penyakit WHERE nama_penyakit = '$namaPenyakit'");
          // echo "<br>";
          // foreach ($query->result_array() as $row)
          // {
          //     echo "<h4>Keterangan :</h4><br>";
          //     echo $row['ket']."<br>";
              
          //     echo "<br><h4>Solusi :</h4><br>";
          //     echo $row['solusi']."<br>";
          // }
        }
      }
      // echo "<pre>";
      // print_r($hasilakhir_cf);

    }

    public function cloneHasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit)
    {
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
          $merubahIndexCF = max($daftar_cf[$namaPenyakit]);
        }
      }
    }

    public function cloneHasilAkhir($daftar_cf,$groupKemungkinanPenyakit)
    {
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        for ($x=0; $x < count($daftar_cf[$namaPenyakit]); $x++) {
          $merubahIndexCF[$i] = max($daftar_cf[$namaPenyakit]);
        }
      }
      
      for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) { 
        $hasilMax = max($merubahIndexCF);
        $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];
        if ($merubahIndexCF[$i] === $hasilMax) {  
          $penyakit_cf = $namaPenyakit;
          $nilai = $merubahIndexCF[$i];
          
        }
      }

      return array(
        'penyakit_cf' => $penyakit_cf,
        'nilai' => $nilai,
    );

    }

}

/* End of file Konsultasi_model.php */
