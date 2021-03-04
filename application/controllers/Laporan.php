<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_barang');
        $this->load->model('M_Transaksi');
        if ($this->session->userdata('status') != "kemasukan") {
            redirect(base_url());
        }
    }

    function index()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanDashboard', $data);
        $this->load->view('Admin/footer');
    }
}
