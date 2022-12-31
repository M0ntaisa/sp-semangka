<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // fungsi get users
    public function getUser()
    {
        $query = $this->db->query("SELECT * FROM users WHERE role_id = 2");

        return $query->result_array();
    }

    // fungsi get user with riwayat
    public function getUserWithRiwayat()
    {
        $query = $this->db->query("SELECT
            nama,
            tanggal_dibuat,
        ( SELECT COUNT( id_user ) FROM tb_riwayat WHERE id_user = C.id_user ) AS konsul_count
        FROM
            users C
        WHERE role_id = 2");

        return $query->result_array();
    }

    public function add_user()
    {
        $email = $this->input->post('email', true);
        $data = [
            'nama'              => htmlspecialchars($this->input->post('nama', true)),
            'email'             => htmlspecialchars($email),
            'password'          => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id'           => 2,
            'status'            => 0,
            'tanggal_dibuat'    =>  time()
        ];

        // token
        $token = base64_encode(random_bytes(32));
        $user_token = [
            'email' =>  $email,
            'token' => $token,
            'tanggal_dibuat' => time()
        ];

        $this->db->insert('users', $data);
        $this->db->insert('user_token', $user_token);

        $this->_sendEmail($token, 'verify');
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'   =>  'ssmtp',
            'smtp_host'  =>  'tls://ssmtp.gmail.com',
            'smtp_user'  =>  '',
            'smtp_pass'  =>  '',
            'smtp_port'  =>  465,
            'smtp_timeout' => 7,
            'mailtype'   =>  'html',
            'charset'    =>  'utf-8',
            'wordwrap'   =>  TRUE,
            'validation' =>  TRUE,
            'newline'    =>  "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('', 'Account Verification');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {   
            $this->email->subject('Account Verification');
            $this->email->message('Klik link ini untuk verifikasi akun anda : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>');
        }
            
        if($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify_user()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['tanggal_dibuat'] < (60*60*24)) {
                    $this->db->set('status', 1);
                    $this->db->where('email', $email);
                    $this->db->update('users');

                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('pesan', '<script>alert("Aktivasi berhasil! Silahkan Login!")</script>');
            
                    redirect('auth/login','refresh');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('pesan', '<script>alert("Aktivasi akun gagal! *Token telah kadaluwarsa")</script>');
            
                    redirect('auth/regis','refresh');
                }
            } else {
                $this->session->set_flashdata('pesan', '<script>alert("Aktivasi akun gagal! *Token tidak valid")</script>');
            
                redirect('auth/regis','refresh');
            }
        } else {
            $this->session->set_flashdata('pesan', '<script>alert("Aktivasi akun gagal! *Wrong email!")</script>');
            
            redirect('auth/regis','refresh');
        }
    }

}

/* End of file User_model.php */
