<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $userid = $this->input->post('username');
        $str = $this->input->post('pass');

        $user = $this->db->get_where('tbl_user', ['user_username' => $userid])->row_array();

        if ($user) {
            //jika usernya aktif
            if ($pwcek == $user['password']) {
                if ($user['user_level'] == 1) {
                    //$this->session->sess_destroy();
                    $data = [
                        'user_nama' => $user['user_nama'],
                        'status' => "kemasukan"
                    ];
                    $this->session->set_userdata($data);
                    redirect('Kasir');
                } else {
                    $data = [
                        'usern_nama' => $user['usern_nama'],
                        'status' => "muser"
                    ];
                    $this->session->set_userdata($data);
                    redirect('Kasir');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong password.</div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email Tidak Terdaftar</div>');
            redirect('Auth');
        }
    }
}
