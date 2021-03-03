<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
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
		$data['titel'] = "Dashboard Kasir";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['martis'] = "";
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirDashboard', $data);
		$this->load->view('Admin/footer');
	}

	function transaksiBelumDiambil()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Daftar Transaksi Belum Dibayar";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['martis'] = "";
		$data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();
		$data['transaksi'] = $this->M_Transaksi->getTransaksiBelumDiambil();
		// var_dump($transaksi);
		// exit();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirListTransaksi', $data);
		$this->load->view('Admin/footer');
	}

	function tampilDetailTransaksi($transaksi_id)
	{
		echo $this->detailTransaksi($transaksi_id);
	}

	function detailTransaksi($transaksi_id)
	{
		$data_dtr = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);
		// var_dump($data_dtr);

		$output = '<div class="row">
                                <div class="col=lg-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang / Layanan</th>
                                                <th>Panjang</th>
                                                <th>Lebar</th>
                                                <th style="width: 5%;">Jumlah Cetak(pcs)</th>
                                                <th>Harga Satuan</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>';

		$no = 0;
		foreach ($data_dtr as $dtr) {
			$no = $no + 1;
			if ($dtr['barang_satuan'] == 1) {
				$panjang = $dtr['dtr_panjang'];
				$lebar = $dtr['dtr_lebar'];
			} else {
				$panjang = '';
				$lebar = '';
			}

			if ($dtr['barang_satuan'] == 3) {
				$jumlah = '';
			} else {
				$jumlah = $dtr['dtr_jumlah'];
			}
			$output .= '                    <tr>
                                            <td> ' . $no . '</td>
                                            <td> ' . $dtr['barang_nama'] . '</td>
                                            <td> ' . $panjang . '</td>
                                            <td> ' . $lebar . '</td>
                                            <td> ' . $jumlah . '</td>
                                            <td> ' . $dtr['dtr_harga'] . '</td>
                                            <td> ' . $dtr['dtr_total'] . '</td>
                                        </tr>';
		}
		$output .= '        </table>
                                </div>
                                <div class="col-lg-12">
								<form action="' . base_url() . 'kasir/ubahPembayaran/' . $transaksi_id . '" method="POST">
                                    <input type="submit" value="Proses Pembayaran" class="ml-3 btn btn-success float-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
</form>
                                </div>
                        </div>';
		$output .= '';

		return $output;
	}

	function ubahPembayaran($transaksi_id)
	{

		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Form Ubah Pembayaran";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['martis'] = "";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['transaksi_id'] = $transaksi_id;
		$data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$data['data_dtr'] = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);

		// var_dump($data['transaksi']);
		// var_dump($data['dtr']);
		// exit();

		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirUbahPembayaran', $data);
		$this->load->view('Admin/footer');
		// var_dump($data['dtr']);
	}

	function actionUbahPembayaran($transaksi_id)
	{
		if ($this->input->post('submit') == 2 || $this->input->post('submit') == '2') {
			// disini kasih redirect ke fucntion untuk cetak nota
		} else {
			$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
			$nom_bayar = $this->input->post('nom_bayar');
			$diskon = $this->input->post('diskon');
			$diskon_status = $this->input->post('diskon_status');

			// if ($diskon_status == 1) {
			// 	$diskon = $diskon * $transaksi['tr_total'] / 100;
			// }

			$uang = $transaksi['tr_uang'] + $nom_bayar;
			$kembalian = $transaksi['tr_total'] - $uang;
			if ($kembalian < 0) {
				$kembalian = 0;
			}

			$data_tr = [
				"tr_uang" => $uang,
				"tr_diskon" => $diskon,
				"tr_diskon_status" => $diskon_status,
				"tr_kembalian" => $uang,
			];
			$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);

			// var_dump($data_tr);
			$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                       Pembayaran Transaksi atas nama <strong>' . $transaksi['p_nama'] . '</strong> Berhasil
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
			redirect('kasir/ubahPembayaran/' . $transaksi_id);
		}
	}
}
