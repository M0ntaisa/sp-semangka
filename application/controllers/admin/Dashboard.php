<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gejala_model');
        $this->load->model('Penyakit_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data_user = $this->User_model->getUserWithRiwayat();

        // $jumlah_user = count($data_user);
        $jumlah_user_konsul = 0;
        for ($i=0; $i < count($data_user) ; $i++) { 
            if ($data_user[$i]['konsul_count'] != 0) {
                $jumlah_user_konsul += 1;
            }
        }

        // echo "<pre>";
        // print_r($data_user);die;

        $gejala = $this->Gejala_model->getGejala();
        $penyakit = $this->Penyakit_model->getOnlyPenyakit();
        $hama = $this->Penyakit_model->getOnlyHama();
        
        $data = [
            "subtitle"  => "Dashboard",
            "gejala" => $gejala,
            "penyakit" => $penyakit,
            "hama" => $hama,
            "data_user" => $data_user,
            "jumlah_user_konsul" => $jumlah_user_konsul,
            "isi"   =>  "admin/dashboard/list"
        ];

        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

}

/* End of file Dashboard.php */
