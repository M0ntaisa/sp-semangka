<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // proteksi halaman
        // $this->auth->cek_login();

        // load model
        $this->load->model('Penyakit_model');
        $this->load->model('Gejala_model');
        $this->load->model('Konsultasi_model');
    }

    public function index()
    {
        $user = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $this->session->unset_userdata('gagal');
        $gejala = $this->Gejala_model->getGejala();
        $penyakit = $this->Penyakit_model->getPenyakit();

        $data = [
            'title' =>  "Konsultasi",
            'gejala'    =>  $gejala,
            'penyakit'  =>  $penyakit,
            'user'  =>  $user,
            'isi'   =>  "user/konsultasi"
        ];

        $this->load->view('layout/wrapper', $data, FALSE);
        

    }

    public function Proses()
    {
        // $gejala = $this->input->post('gejala[]');
        // var_dump($gejala);
        // echo count($gejala);
        $user = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        if(isset($_POST['gejala'])){

            if(count($_POST['gejala'])<2){
                
                $this->session->set_flashdata('failed', 'Metode Dempster Shafer membutuhkan setidaknya 2 gejala untuk diproses!');
                redirect(base_url('konsultasi'), 'refresh');

            }else{
                $this->Konsultasi_model->rank();
                $data_ds = $this->Konsultasi_model->cloneProsesDs();
                $data_cf = $this->Konsultasi_model->cloneProsesCf();

                // echo "<pre>";
                // print_r($data_cf['hasilakhir_cf']);
                // print_r($data_ds);
                // print_r($data_cf);die;
                $nilai_rank_cf = 0;
                $nilai_rank_ds= 0;
                $nilai_rank_cf = $data_cf['hasilakhir_cf'][0]['nilai'];
                $nilai_rank_ds = $data_ds['hasil']['nilai'];

                if ($nilai_rank_cf > $nilai_rank_ds) {
                    for ($i=0; $i < count($data_cf['hasilakhir_cf']); $i++) { 
                        
                        $penyakit = $data_cf['hasilakhir_cf'][$i]['ph'];
                        $nilai = $data_cf['hasilakhir_cf'][$i]['nilai'];
                        
                        $rank_penyakit[] = [
                            "metode"=>"Certainty Factor",
                            "penyakit" => $penyakit,
                            "nilai" => $nilai,
                            'user'  =>  $user,
                            "ket"  => $data_cf['hasilakhir_cf'][$i]['solusi']['ket'],
                            "solusi"  => $data_cf['hasilakhir_cf'][$i]['solusi']['solusi']
                        ];
                    }
                    
                    // $rank_nilai[] = $data_cf['hasilakhir_cf'][0]['nilai'];
                    // $rank_penyakit[] = $nilai_rank_cf;
                } elseif ($nilai_rank_ds > $nilai_rank_cf) {
                    $rank_penyakit[] = [
                        'user'  =>  $user,
                        "metode"=>"Dempster Shafer",
                        "penyakit" => $data_ds['hasil']['penyakit_ds'],
                        "nilai" => $data_ds['hasil']['nilai'],
                        "ket" => $data_ds['ket'][0]['ket'],
                        "solusi" => $data_ds['ket'][0]['solusi'],
                    ];
                    // $rank_nilai[] = $data_ds['hasil']['nilai'];
                    // $rank_penyakit[] = $data_ds['hasil']['penyakit_ds'];
                }
                $penyakit=$data_cf['hasilakhir_cf'][0]['ph'];
                if ($nilai_rank_ds == $nilai_rank_cf) {
                    if ($penyakit == $data_ds['hasil']['penyakit_ds']) {
                       $peny=$penyakit;
                       $sol=$data_cf['hasilakhir_cf'][$i]['solusi']['solusi'];
                       $kett=$data_ds['ket'][0]['ket'];
                    }
                    else {
                        $peny=$penyakit.' & '.$data_ds['hasil']['penyakit_ds'];
                        $sol =$data_cf['hasilakhir_cf'][0]['solusi']['solusi'].' & '.$data_ds['ket'][0]['solusi'];
                        $kett=$data_ds['ket'][0]['ket'].' & '.$data_cf['hasilakhir_cf'][0]['solusi']['ket'];
                    }
                    $rank_penyakit[] = [
                        'kett'=>1,
                        'user'  =>  $user,
                        "metode"=>"Dempster Shafer dan Certainty Factor",
                        "penyakit" => $peny,
                        "nilai" => $data_ds['hasil']['nilai'],
                        "ket" => $kett,
                        "solusi" => $sol,
                    ];
                }
                
                
                // print_r($rank_penyakit);die;

                // echo $rank_nilai = max($data_ds['hasil']['nilai'], $data_cf['hasil']['nilai']);die;
                // $rank_penyakit = $data_cf['hasil']['penyakit_ds'];
                
                
                $data = [
                    'title' =>  "Hasil Konsultasi",
                    'data_ds' => $data_ds,
                    'data_cf' => $data_cf,
                    'rank_penyakit' => $rank_penyakit,
                    'user'  =>  $user,
                    'isi'   =>  "user/hasil_konsultasi"
                ];
    
                $this->load->view('layout/wrapper', $data, FALSE);
                
            }   

        } else {
            $this->session->set_flashdata('warning', 'Anda Belum Memilih Gejala');
            redirect(base_url('konsultasi'), 'refresh');
        }
        
    }

    public function cetak()
    {
        $id_user = $_GET['id'];
        $data_konsult = $this->Konsultasi_model->getKonsulAkhirUser($id_user);
        // print_r(json_decode($data_konsult[0]['prob_penyakit_ds']));
        $prob_ds = implode(',',json_decode($data_konsult[0]['prob_penyakit_ds']));
        $prob_cf = implode(',',json_decode($data_konsult[0]['prob_penyakit_cf']));
        $kode_prob_ds = str_replace(",", "','", $prob_ds);
        $kode_prob_cf = str_replace(",", "','", $prob_cf);
        $kode_gejala = str_replace(",", "','", $data_konsult[0]['kode_gejala']);
        $pilihanGejala = $this->Konsultasi_model->getNamaGejalaByKode($kode_gejala);
        $prob_ds = $this->Konsultasi_model->getNamaPenyakit($kode_prob_ds);
        $prob_cf = $this->Konsultasi_model->getNamaPenyakit($kode_prob_cf);
        $rank_ds = $this->Konsultasi_model->getRankPenyakit($data_konsult[0]['kode_penyakit_ds']);
        $rank_cf = $this->Konsultasi_model->getRankPenyakit($data_konsult[0]['kode_penyakit_cf']);
        // echo "<pre>";
        // print_r($pilihanGejala);
        // print_r($prob_ds);
        // print_r($prob_cf);
        // print_r($rank_ds);die;
        // print_r($rank_cf);
        // print_r($data_konsult);

        $data = [
            "title"             => "CETAK LAPORAN",
            "prob_ds"           => $prob_ds,
            "prob_cf"           => $prob_cf,
            "rank_ds"           => $rank_ds,
            "rank_cf"           => $rank_cf
        ];

        $this->load->view('user/cetak_hasil/cetak', $data, FALSE);
        
    }

}

/* End of file Konsultasi.php */
