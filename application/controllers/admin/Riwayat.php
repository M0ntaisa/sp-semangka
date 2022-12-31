<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // load model
        // $this->load->model('Penyakit_model');
        // $this->load->model('Gejala_model');
        $this->load->model('Riwayat_model');
    }
    public function index()
    {
        $riwayat = $this->Riwayat_model->getRiwayat();
        // echo "<pre>";
        // print_r($riwayat);die;

        $data = [
            'subtitle' =>  "Riwayat Konsultasi",
            'riwayat'    =>  $riwayat,
            'isi'   =>  "admin/riwayat/list"
        ];

        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    // unduh laporan
    public function unduh()
    {
        // ambil id_riwayat yang telah dipilih
        $id_riwayat = $_GET['id_riwayat'];
        // ambil nama riwayat dalam tabel
        $riwayat = $this->Riwayat_model->getDetailRiwayat($id_riwayat);
        $nama = $riwayat[0]['nama'];

        $gejala_terpilih = $this->Riwayat_model->getGejalaTerpilih($riwayat[0]['kode_gejala']);
        $penyakit_ds = $this->Riwayat_model->getPenyakitTerpilih($riwayat[0]['kode_penyakit_ds']);
        $penyakit_cf = $this->Riwayat_model->getPenyakitTerpilih($riwayat[0]['kode_penyakit_cf']);
        
        // echo "<pre>";
        // print_r($riwayat);
        // print_r($gejala_terpilih);
        // print_r($penyakit_cf);
        // print_r($penyakit_ds);die;
        
        $data = array(  
            'title'         =>      'Riwayat Konsultasi',
            'riwayat'       =>      $riwayat,
            'gejala_terpilih'      =>      $gejala_terpilih,
            'penyakit_ds'   =>      $penyakit_ds,
            'penyakit_cf'   =>      $penyakit_cf
        );

        $html = $this->load->view('admin/riwayat/laporan/isi', $data, TRUE);
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();

        // Define the Header before writing anything so they appear on the first page
        $mpdf->SetHTMLHeader($this->load->view('admin/riwayat/laporan/header', $data, TRUE));
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Define the Footer 
        $mpdf->SetHTMLFooter($this->load->view('admin/riwayat/laporan/footer', $data, TRUE));

        // Output a PDF file directly to the browser
        $nama_file_pdf = url_title("Laporan Hasil Konsultasi $nama",'dash','true').'-'.date('j-m-y').'.pdf';
        $mpdf->Output($nama_file_pdf,'I');
    }

    //print out laporan
    public function cetak()
    {
        $data_user = $this->User_model->getUserWithRiwayat();
        $data_riwayat = $this->Riwayat_model->getRiwayat();
        
        $jumlah_user = count($data_user);
        $jumlah_user_konsul = 0;
        for ($i=0; $i < count($data_user) ; $i++) { 
            if ($data_user[$i]['konsul_count'] != 0) {
                $jumlah_user_konsul += 1;
            }
        }

        $persentase = round($jumlah_user_konsul/$jumlah_user*100,2);

        // echo "<pre>";
        // print_r($data_user);
        // print_r($data_riwayat);die;

        $data = [
            "subtitle"      => 'Laporan Konsultasi',
            "data_user"     => $data_user,
            "data_riwayat"  => $data_riwayat,
            "jumlah_user"   => $jumlah_user,
            "jumlah_user_konsul" => $jumlah_user_konsul,
            "persentase"    => $persentase
        ];

        $this->load->view('admin/riwayat/cetak_laporan/cetak', $data);
    }

}

/* End of file Riwayat.php */
