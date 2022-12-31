<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_model extends CI_Model {

    public function getRiwayat()
    {
        $query = $this->db->query("SELECT
                tb_riwayat.id_riwayat,
                tb_riwayat.id_user,
                users.nama,
                tb_riwayat.tanggal_konsul
                FROM
                tb_riwayat
                INNER JOIN users ON tb_riwayat.id_user = users.id_user
        ");

        return $query->result_array();
    }

    public function getDetailRiwayat($id_riwayat)
    {
        $query = $this->db->query("SELECT 
                tb_riwayat.*,
                users.nama 
                FROM 
                tb_riwayat 
                INNER JOIN users ON tb_riwayat.id_user = users.id_user 
                WHERE id_riwayat = '$id_riwayat'
        ");

        return $query->result_array();
    }

    public function getGejalaTerpilih($kode_gejala)
    {
        $kode = str_replace(",", "','", $kode_gejala);

        $query = $this->db->query("SELECT 
                tb_gejala.kode_gejala,
                tb_gejala.nama_gejala
                FROM
                tb_gejala
                WHERE 
                tb_gejala.kode_gejala IN ('$kode')
        ");

        return $query->result_array();
    }

    public function getPenyakitTerpilih($kode_penyakit)
    {
        $kode = str_replace(",", "','", $kode_penyakit);

        $query = $this->db->query("SELECT 
                tb_penyakit.kode_penyakit,
                tb_penyakit.nama_penyakit,
                tb_penyakit.ket,
                tb_penyakit.solusi
                FROM
                tb_penyakit
                WHERE 
                tb_penyakit.kode_penyakit IN ('$kode')
        ");

        return $query->result_array();
    }

}

/* End of file Riwayat_model.php */
