<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_barang');
		$this->load->model('M_Transaksi');
		if ($this->session->userdata('status') != "kemasukan") {
			redirect(base_url());
		}
	}

	function index()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Beranda";
		$data['jajal'] = "Dashboard";
		$data['namamenu'] = "Dashboard";
		$data['martis'] = "";
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Admin/Beranda', $data);
		$this->load->view('Admin/footer');
	}

	function Persediaan()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Persediaan";
		$data['martis'] = "Barang";
		$data['barang'] = $this->m_barang->get_barang();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Admin/Barang', $data);
		$this->load->view('Admin/footer');
	}

	function Pembelian()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Persediaan";
		$data['martis'] = "Pembelian";
		$data['barang'] = $this->m_barang->get_barang();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Admin/Pembelian', $data);
		$this->load->view('Admin/footer');
	}

	function Stok()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Persediaan";
		$data['martis'] = "Stok";
		$data['barang'] = $this->m_barang->get_barang();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Admin/Stok', $data);
		$this->load->view('Admin/footer');
	}
	function GetDetailBarang()
	{
		$id = $this->input->post('id');
		$data = $this->m_barang->get_barangdetail($id);
		$kategori = $this->m_barang->get_kategori();
		$output = "";
		$output .= "<div class='form-group'>
		<label for='kabar'>Kode Barang</label>
		<input class='form-control form-control-sm' type='text' placeholder='kode'
		id='kabar' name='kabar' readonly autocomplete='off' value='" . $data['barang_id'] . "'>
	</div>
	<div class='form-group'>
	<label for='nabar'>Nama Barang</label>
	<input class='form-control form-control-sm' type='text' placeholder='nama'
	id='nabar' name='nabar' autocomplete='off' value='" . $data['barang_nama'] . "'>
	</div>
	<div class='form-group'>
	<label for='satuan'>Nama Barang</label>
	<input class='form-control form-control-sm' type='text' placeholder='satuan'
	id='satuan' name='satuan' autocomplete='off' value='" . $data['barang_satuan'] . "'>
	</div>
	<div class='form-group'>
	<label for='satuan'>Harga Pokok</label>
	<input class='form-control form-control-sm' type='text' placeholder='satuan'
	id='satuan' name='satuan' autocomplete='off' value='" . $data['barang_harpok'] . "'>
	</div>
	<div class='form-group'>
	<label for='satuan'>Harga Jual</label>
	<input class='form-control form-control-sm' type='text' placeholder='satuan'
	id='satuan' name='satuan' autocomplete='off' value='" . $data['barang_harjul'] . "'>
	</div>
	<div class='form-group'>
	<label for='satuan'>Harga Grosir</label>
	<input class='form-control form-control-sm' type='text' placeholder='satuan'
	id='satuan' name='satuan' autocomplete='off' value='" . $data['barang_harjul_grosir'] . "'>
	</div>
	<div class='form-group'>
    <label>Kategori</label>
	<select class='form-control form-control-sm' id='katgori' name='katgori'>
	<option>Pilih Kategori</option>	
	";
		foreach ($kategori as $k) {
			$output .= "<option>$k->kategori_nama</option>";
		}
		$output .= "</select>
	</div>";
		echo $output;
	}
	function Penjualan()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Penjualan";
		$data['martis'] = "Barang";
		$data['barang'] = $this->m_barang->get_barang();

		// $jajalan = $this->M_Transaksi->getBarangByLike('antena');
		// var_dump($jajalan);
		// exit();
		$this->form_validation->set_rules('uang_cash', 'Nominal Tunai', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('Admin/header', $data);
			$this->load->view('Admin/Menu', $data);
			$this->load->view('Admin/formPenjualan', $data);
			$this->load->view('Admin/footer');
		} else {
			$user = $this->db->get_where('tbl_user', ['user_nama' =>
			$this->session->userdata('user_nama')])->row_array();


			$id_barang = $this->input->post('barang_id[]');
			$qty_barang = $this->input->post('barang_qty[]');
			$harga_barang = $this->input->post('barang_harga[]');
			$total_barang = $this->input->post('barang_total[]');

			if ($id_barang == '' || $qty_barang == '' || $harga_barang == '' || $total_barang == '') {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button> 
        Anda belum memilih data barang yang dibeli </div>');
				redirect(base_url('admin/Penjualan'));
			}
			$user_id = $user['user_id'];

			$total = 0;
			for ($a = 0; $a < count($id_barang); $a++) {
				$total = $total + $total_barang[$a];
			}

			$diskon = $this->input->post('diskon');
			$uang = $this->input->post('uang_cash');
			$kembalian = $uang - $total;

			$kode_tanggal = date('Tymd', time());
			$count_nota_today = $this->M_Transaksi->getTransaksiLikeId($kode_tanggal);
			$antrian = $count_nota_today + 1;
			if ($antrian < 10) {
				$kode_antrian = "00" . $antrian;
			} else if ($antrian < 100) {
				$kode_antrian = "0" . $antrian;
			}
			$id_transaksi_raw = (int)$kode_tanggal . $kode_antrian;
			$id_transaksi = (int)$id_transaksi_raw;

			// input ke tbl_jual (transaksi)
			$this->M_Transaksi->insertTransaksi($id_transaksi, $total, $uang, $kembalian, $user_id);

			// input ke tbl_detail_jual
			for ($x = 0; $x < count($id_barang); $x++) {
				$detail_barang = $this->M_Transaksi->getBarangDetail($id_barang[$x]);
				// var_dump($detail_barang['barang_nama']);
				$this->M_Transaksi->insertDetailTransaksi(
					$id_barang[$x],
					$detail_barang['barang_nama'],
					$detail_barang['barang_harpok'],
					$detail_barang['barang_harjul'],
					$qty_barang[$x],
					$total_barang[$x],
					$id_transaksi
				);
			}
			// 	$this->session->set_flashdata('message', '<div class="alert alert-success " role="alert">
			// <button type="button" class="close" data-dismiss="alert">&times;</button> 
			// <b>Terima Kasih <b>, Input transaksi penjualan baru telah berhasil </div>');
			redirect(base_url('admin/printNota/' . $id_transaksi));
		}
	}

	public function fetch()
	{
		$output = '';
		$query = '';
		$this->load->model('M_Transaksi');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_Transaksi->getBarangByLike($query);

		if ($data->num_rows() > 0) {
			$nmbr = 0;
			foreach ($data->result() as $row) {
				$nmbr = $nmbr + 1;

				$output .= '<div class="col-lg-12 mt-3">
                                                    <div class="card" style="width: auto;">
                                                        <div class="card-body p-1">
                                                            <div class="row p-1">
                                                                <div class="col-lg-9">
                                                                    <div class="row ">
                                                                        <div class="col-lg-12">
                                                                            <div class="text font-weight-bold">' . $row->barang_nama . '</div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="text font-weight-light">' . $row->barang_harjul . '</div>
                                                                        </div>
                                                                        <div class="col-lg-12 mt-1">
                                                                            <div class="text-xs">Stok 99 </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mt-1 align-items-end">
                                                                    <button type="button" onclick="tambahKerajang(' . $nmbr . ')" class="ml-3 btn btn-sm btn-primary btn_add' . $nmbr . '" name="btn_add" data-barangnama="' . $row->barang_nama . '" data-barangharga="' . $row->barang_harjul . '" data-barangid="' . $row->barang_id . '"><i class="fas fa-fw fa-plus"></i> </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
			}
		} else {
			$output .= '<div class="col-lg-12">
                                            <div class="alert alert-danger" role="alert">
                                                Maaf barang "' . $query . '" tidak ditemukan. Periksa keyword barang yang dimasukan
                                            </div>
                                        </div>';
		}
		echo $output;
	}

	public function fetchx()
	{
		$output = '';
		$query = '';
		$this->load->model('M_Transaksi');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_Transaksi->getBarangByLike($query);

		if ($data->num_rows() > 0) {
			$nmbr = 0;
			foreach ($data->result() as $row) {
				$nmbr = $nmbr + 1;

				$output .= '<div class="col-lg-12 mt-3">
                                                    <div class="card" style="width: auto;">
                                                        <div class="card-body p-1">
                                                            <div class="row p-1">
                                                                <div class="col-lg-9">
                                                                    <div class="row ">
                                                                        <div class="col-lg-12">
                                                                            <div class="text font-weight-bold">' . $row->barang_nama . '</div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="text font-weight-light">' . $row->barang_harjul . '</div>
                                                                        </div>
                                                                        <div class="col-lg-12 mt-1">
                                                                            <div class="text-xs">Stok 99 </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mt-1 align-items-end">
                                                                    <button type="button" onclick="tambahKerajang(' . $nmbr . ')" class="ml-3 btn btn-sm btn-primary btn_add' . $nmbr . '" name="btn_add" data-barangnama="' . $row->barang_nama . '" data-barangharga="' . $row->barang_harjul . '" data-barangid="' . $row->barang_id . '"><i class="fas fa-fw fa-plus"></i> </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
			}
		} else {
			$output .= '<div class="col-lg-12">
                                            <div class="alert alert-danger" role="alert">
                                                Maaf barang "' . $query . '" tidak ditemukan. Periksa keyword barang yang dimasukan
                                            </div>
                                        </div>';
		}
		echo $output;
	}

	public function printNota($id_transaksi)
	{
		$this->load->model('M_Transaksi');
		// $data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow(1210208023);
		// $data['d_transaksi'] = $this->M_Transaksi->getDetailTransaksiById(1210208023);
		$data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow($id_transaksi);
		$data['d_transaksi'] = $this->M_Transaksi->getDetailTransaksiById($id_transaksi);
		// $data['siswa'] = $this->siswa_model->getData();

		$ts_transaksi = strtotime($data['transaksi']['jual_tanggal']);
		$dt_transaksi = date('Y-m-d', $ts_transaksi);
		$data['tgl_transaksi'] = date_indo($dt_transaksi);

		// var_dump($data['transaksi']);
		// var_dump($data['d_transaksi']);
		// exit();
		$this->load->library('pdf');
		$customPaper = array(0, 0, 300, 560);
		$this->pdf->setPaper($customPaper);
		$this->pdf->filename = "nota-" . $id_transaksi . ".pdf";
		$this->pdf->load_view('admin/notaPdf', $data);
	}

	function grafikLaporan()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Persediaan";
		$data['martis'] = "Stok";
		$data['barang'] = $this->m_barang->get_barang();

		$data_barang = ['Barang 1', 'Barang 2', 'Barang 3', 'Barang 4', 'Barang 5'];
		$data_jumlah = [10, 20, 30, 40, 50];

		//proses data nama barang ke chart
		$string_nama = "";
		for ($a = 0; $a < count($data_barang); $a++) {
			$string_nama = $string_nama . '"' . $data_barang[$a] . '"' . ',';
		}
		$string_nama = substr($string_nama, 0, -1);
		$data['string_nama'] = $string_nama;


		// proses data jumlah barang ke chart
		$string_jumlah = "";
		for ($a = 0; $a < count($data_jumlah); $a++) {
			$string_jumlah = $string_jumlah . $data_jumlah[$a] . ',';
		}
		$string_jumlah = substr($string_jumlah, 0, -1);
		$data['string_jumlah'] = $string_jumlah;


		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Admin/laporanChart', $data);
		$this->load->view('Admin/footer');
	}
}
