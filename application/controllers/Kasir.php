<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_barang');
		if($this->session->userdata('status') != "kemasukan"){
			redirect(base_url());
		}
		
	}

	function index()
	{
		$data['titel']="Beranda";
		$data['jajal']="Dashboard";
		$data['namamenu']="Dashboard";
		$data['martis']="";
		$data['menu'] = $this->m_barang->get_barang();
        $this->load->view('Admin/header',$data);
		$this->load->view('Admin/Menu',$data);
		$this->load->view('Admin/footer');
    }
    
}
