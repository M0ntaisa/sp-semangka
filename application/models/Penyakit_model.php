<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit_model extends CI_Model {

    //Fungsi Lihat Data Penyakit / Hama
    public function getPenyakit() {
        return $this->db->get('tb_penyakit')->result_array();
    }

    // fungsi mengambil data hanya penyakit
    public function getOnlyPenyakit()
    {
        // $query = $this->db->query("SELECT * FROM tb_penyakit WHERE id_jenis = 2");

        $results = array();
        $this->db->select('*');
        $this->db->from('tb_penyakit');
        $this->db->where('id_jenis', 2);

        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $results = $query->result_array();
        }
        return $results;
    }

    // fungsi mengambil data hanya hama
    public function getOnlyHama()
    {
        // $query = $this->db->query("SELECT * FROM tb_penyakit WHERE id_jenis = 1");

        
        $results = array();
        $this->db->select('*');
        $this->db->from('tb_penyakit');
        $this->db->where('id_jenis', 1);

        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $results = $query->result_array();
        }
        return $results;
    }

    // fungsi mengambil nama penyakit dengan kode penyakit
    public function getNamaPenyakit($kode_penyakit)
    {
        $query = $this->db->query("SELECT nama_penyakit FROM tb_penyakit WHERE kode_penyakit IN('$kode_penyakit')");

        $nm_penyakit = array();
        foreach ($query->result() as $row)
        {
            $nm_penyakit[] = $row->nama_penyakit;
        }
        return $nm_penyakit;
    }

    // fungsi tambah Penyakit / Hama
    public function tambahPenyakit($data)
    {
        //Cek apakah ada Penyakit / Hama dengan Kode sama
        $filter = $this->db->select('*')->from('tb_penyakit')->where('kode_penyakit', $data['kode_penyakit'])->get()->num_rows();
        if ($filter < 1) {
            $insert = $this->db->insert('tb_penyakit', $data);
        } else {
            // set flashdata
            $this->session->set_flashdata('gagal', 'Data Penyakit / Hama gagal ditambahkan.');
            redirect(base_url('admin/penyakit'), 'refresh');
        }
    }

    // fungsi edit Penyakit / Hama
    public function editPenyakit($data)
    {
        $this->db->where('kode_penyakit', $data['kode_penyakit']);
        $update = $this->db->update('tb_penyakit', $data);
    }

    // fungsi hapus Penyakit / Hama
    public function hapusPenyakit($kode_penyakit)
    {
        $this->db->delete('tb_penyakit', ['kode_penyakit' => $kode_penyakit]);
    }

}

/* End of file Penyakit_model.php */
