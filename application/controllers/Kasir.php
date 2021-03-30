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
		$data['count_belum_diambil'] = count($this->M_Transaksi->getTransaksiBelumDiambil());
		$data['count_sudah_diambil'] = count($this->M_Transaksi->getTransaksiSudahDiambil());
		$data['count_hutang'] = count($this->M_Transaksi->getTransaksiHutang());
		// var_dump($data['count_belum_diambil']);

		// exit();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirDashboard', $data);
		$this->load->view('Admin/footer');
	}

	function inputTransaksi()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$user = $this->db->get_where('tbl_user', ['user_nama' =>
		$this->session->userdata('user_nama')])->row_array();

		//  Percobaan fungsi input transaksi
		$kode_tanggal = 'T' . date('ymd', time());
		$count_nota_today = $this->M_Transaksi->getTransaksiLikeId($kode_tanggal);
		$antrian = $count_nota_today + 1;
		if ($antrian < 10) {
			$kode_antrian = "00" . $antrian;
		} else if ($antrian < 100) {
			$kode_antrian = "0" . $antrian;
		}
		$id_transaksi_raw = $kode_tanggal . $kode_antrian;
		$transaksi_id = $id_transaksi_raw;

		$p_id = time();
		$p_nama = $this->input->post('p_nama');
		$p_nohp = $this->input->post('p_nohp');

		if ($p_nama) {
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>INPUT TRANSAKSI GAGAL!</strong> Nama Pelanggan Tidak boleh kosong         
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
			redirect('Kasir');
		}


		// var_dump($p_id . $p_nama . $p_nohp);

		$desain_id = $user['user_id'];
		$total = 0;
		$diskon = 0;
		$diskon_status = 0;
		$uang = 0;
		$uang_status = 'cash';

		// var_dump($id_transaksi);
		// exit();

		$this->M_Transaksi->insertPelanggan($p_id, $p_nama, $p_nohp);

		$this->M_Transaksi->insertTransaksi(
			$transaksi_id,
			$desain_id,
			$p_id,
			$total,
			$diskon,
			$diskon_status,
			$uang,
			$uang_status
		);

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>INPUT TRANSAKSI BERHASIL!</strong> Silahkan lengkapi data transaksi ' . $p_nama . ' pada form dibawah ini         
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
		redirect('Kasir/ubahDetailTransaksi/' . $transaksi_id);
	}

	function ubahDetailTransaksi($transaksi_id)
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Form Input Transaksi";
		$data['jajal'] = "Desain";
		$data['namamenu'] = "Desain";
		$data['martis'] = "";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['transaksi_id'] = $transaksi_id;
		$data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);

		$data_dtr = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);
		$data['total_harga'] = 0;
		foreach ($data_dtr as $dtr) {
			$data['total_harga'] = $data['total_harga'] + $dtr['dtr_total'];
		}

		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirDetailTransaksi', $data);
		$this->load->view('Admin/footer');

		$kode_tanggal = 'T' . date('ymd', time());
		$count_nota_today = $this->M_Transaksi->getTransaksiLikeId($kode_tanggal);
		$antrian = $count_nota_today + 1;
		if ($antrian < 10) {
			$kode_antrian = "00" . $antrian;
		} else if ($antrian < 100) {
			$kode_antrian = "0" . $antrian;
		}
		$id_transaksi_raw = $kode_tanggal . $kode_antrian;
		$id_transaksi = $id_transaksi_raw;
		// var_dump($count_nota_today);
		// var_dump($id_transaksi);
	}

	function actionUbahDetailTransaksi($transaksi_id)
	{
		$data_dtr = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);
		$trs = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$tr_total = 0;
		foreach ($data_dtr as $dtr) {
			$tr_total = $tr_total + $dtr['dtr_total'];
		}
		$dtNow = date('Y-m-d H:i:s', time());
		$data_tr = [
			"tr_total" => $tr_total,
			"tr_tgl_update" => $dtNow
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);

		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
         Terima Kasir, Ubah Detail Transaksi atas nama <strong>' . $trs['p_nama'] . '</strong> telah berhasil              
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
		redirect('Kasir/ubahPembayaran/' . $transaksi_id);
	}

	function insertDetailTransaksi($transaksi_id)
	{
		// $transaksi_id = 'T210225001';
		$barang_id = $this->input->post('barang_id');;
		$barang = $this->M_barang->getBarangDetail($barang_id);

		$panjang = 100;
		$lebar = 100;
		$jumlah = 1;
		$harga = $barang['barang_harjul'];
		$total = $barang['barang_harjul'];
		$keterangan = 'skip';
		$this->M_Transaksi->insertDetailTransaksi(
			$transaksi_id,
			$barang_id,
			$panjang,
			$lebar,
			$jumlah,
			$harga,
			$total,
			$keterangan
		);

		echo $this->isiKeranjang($transaksi_id);
	}

	function hapusDetailTransaksi()
	{
		$dtr_id = $this->input->post('det_id');
		$this->M_Transaksi->deleteDetailTransaksi($dtr_id);
	}

	function tampilIsiKeranjang($id_transaksi)
	{
		echo $this->isiKeranjang($id_transaksi);
	}

	public function isiKeranjang($id_transaksi)
	{
		$cart_list = $this->M_Transaksi->getDetailTransaksiById($id_transaksi);

		$output = '';
		$output .= '<div class="overflow-auto" style="overflow-x:auto;">';
		$output .= '<table class="table" id="cartTable">
                        <thead>
                            <tr>
                                <th style="width:25%">Nama Barang</th>
                                <th style="width:15%">Nama Barang</th>
                                <th style="width:10%">Panjang (cm)</th>
                                <th style="width:10%">Lebar (cm)</th>
                                <th style="width:10%">Jumlah Cetak(pcs)</th>
                                <th style="width:10%" class="text-right">Harga satuan</th>
                                <th style="width:10%" class="text-right">Total Harga</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbKeranjang">';
		$nmbr = 0;
		if ($cart_list) {
			foreach ($cart_list as $cl) {
				$nmbr = $nmbr + 1;
				if ($cl['barang_satuan'] == 1) {
					$output .= '<tr class="records" id="row' . $nmbr . '">
					<td style="width:10%"> <textarea class=" form-control form-control-sm" onchange="updateNama(' . $nmbr . ')" name="" id="dtr_nama" style="text-align: left;" type="text" value=""> ' . $cl['dtr_nama_file'] . '</textarea> </td>
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden> <input id="dtr_satuan" type="text" value="' . $cl['sat_barang_id'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '"> </td>
                                <td style="width:12%"> <input class=" form-control form-control-sm dtr-harga" onchange="sum(' . $nmbr . ')" name="" id="dtr_harga" style="text-align: right;" type="text" value="' . $cl['dtr_harga'] . '">  </td>
                                <td class="pt-3 dtr-total text-right" id="vdtr_total">' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
				} else if ($cl['barang_satuan'] == 2) {
					$output .= '<tr class="records" id="row' . $nmbr . '">
					<td style="width:10%"> <textarea class=" form-control form-control-sm" onchange="updateNama(' . $nmbr . ')" name="" id="dtr_nama" style="text-align: left;" type="text" value=""></textarea> </td>
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden> <input id="dtr_satuan" type="text" value="' . $cl['sat_barang_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '"> </td>
                                <td style="width:12%"> <input class=" form-control form-control-sm dtr-harga" onchange="sum(' . $nmbr . ')" name="" id="dtr_harga"  style="text-align: right; "type="text" value="' . $cl['dtr_harga'] . '" >  </td>
                                <td class="pt-3 dtr-total text-right" id="vdtr_total">' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
				} else if ($cl['barang_satuan'] == 3) {
					$output .= '<tr class="records" id="row' . $nmbr . '">
					<td style="width:10%"> <textarea class=" form-control form-control-sm" onchange="updateNama(' . $nmbr . ')" name="" id="dtr_nama" style="text-align: left;" type="text" value=""> ' . $cl['dtr_nama_file'] . '</textarea> </td>
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden> <input id="dtr_satuan" type="text" value="' . $cl['sat_barang_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '" hidden> </td>
                                <td style="width:12%"> <input class=" form-control form-control-sm dtr-harga" onchange="sum(' . $nmbr . ')" name="" id="dtr_harga" style="text-align: right; style="text-align: left;" type="text" value="' . $cl['dtr_harga'] . '">  </td>
                                <td class="pt-3 dtr-total text-right" id="vdtr_total" >' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
				} else {
					$output .= '<tr class="records" id="row' . $nmbr . '">
					<td style="width:10%"> <textarea class=" form-control form-control-sm" onchange="updateNama(' . $nmbr . ')" name="" id="dtr_nama" style="text-align: left;" type="text" value="">' . $cl['dtr_nama_file'] . '</textarea> </td>
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden> <input id="dtr_satuan" type="text" value="' . $cl['sat_barang_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '"> </td>
                                <td style="width:12%"> <input class=" form-control form-control-sm dtr-harga" onchange="sum(' . $nmbr . ')" name="" id="dtr_harga" style="text-align: right;" type="text" value="' . $cl['dtr_harga'] . '">  </td>
                                <td class="pt-3 dtr-total text-right" id="vdtr_total">' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
				}
			};
			$output .= '</tbody></table> </div>';
		} else {
			$output .= '</tbody></table>';
			$output .= '<div class="col-lg-12" id="info_cartKosong">
                                                <div class="alert alert-default border border-warning" role="alert">
                                                    <b>Informasi!</b> Belum ada pembelian ditambahkan
                                                </div>
                                            </div>';
		}
		$output .= "<script>
    $(function() {
        $('.dtr-harga').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });

	$(function() {
        $('.dtr-total').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });
</script>";


		return $output;
	}

	function updateDataKeranjang($detail_transaksi_id)
	{
		$data_dtr = $this->M_Transaksi->getDetailTransaksiByIdRow($detail_transaksi_id);
		$data_barang = $this->M_barang->getBarangDetail($data_dtr['barang_id']);

		$dtr_panjang = $this->input->post('dtr_panjang');
		$dtr_lebar = $this->input->post('dtr_lebar');
		$dtr_jumlah = $this->input->post('dtr_jumlah');
		$dtr_harga = $this->input->post('dtr_harga');
		$dtr_harga = str_replace('.', '', $this->input->post('dtr_harga'));

		// if ($data_dtr['barang_satuan'] == 2) {
		// 	if ($dtr_jumlah <= 50) {
		// 		$harjul = $data_dtr['barang_harjul'];
		// 	} elseif ($dtr_jumlah <= 100) {
		// 		$harjul = $data_dtr['barang_harjul2'];
		// 	} else {
		// 		$harjul = $data_dtr['barang_harjul3'];
		// 	}
		// } elseif ($data_dtr['barang_satuan'] == 3) {
		// 	$harjul = $dtr_harga;
		// } else {
		// 	$harjul = $data_dtr['barang_harjul'];
		// }

		$harjul = $dtr_harga;

		if ($data_barang['sat_barang_id'] == 4) {
			$dtr_total = $harjul;
		} else {
			$dtr_total = $dtr_panjang * $dtr_lebar / 10000 * $dtr_jumlah * $harjul;
		}


		$data_dtr = [
			"dtr_panjang" => $dtr_panjang,
			"dtr_lebar" =>  $dtr_lebar,
			"dtr_jumlah" =>  $dtr_jumlah,
			"dtr_harga" =>  $harjul,
			"dtr_total" =>  $dtr_total,
		];
		// var_dump($data_dtr);
		// exit();
		$this->M_Transaksi->updateDetailTransaksi($data_dtr, $detail_transaksi_id);
		echo $harjul;
	}

	function updateNamaFileKeranjang($detail_transaksi_id)
	{
		$nama_file = $this->input->post('dtr_nama');;

		$data_dtr = [
			"dtr_nama_file" => $nama_file
		];
		// var_dump($data_dtr);
		// exit();
		$this->M_Transaksi->updateDetailTransaksi($data_dtr, $detail_transaksi_id);
		echo $nama_file;
	}

	function transaksiBelumDiambil()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Daftar Transaksi Belum Diambil";
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

	function transaksiSudahDiambil()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Daftar Transaksi Sudah Diambil";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['martis'] = "";
		$data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();
		$data['transaksi'] = $this->M_Transaksi->getTransaksiSudahDiambil();
		// var_dump($transaksi);
		// exit();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirListTransaksi', $data);
		$this->load->view('Admin/footer');
	}

	function transaksiHutang()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Daftar Transaksi Sudah Diambil";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['martis'] = "";
		$data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();
		$data['transaksi'] = $this->M_Transaksi->getTransaksiHutang();
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
		$data_tr = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		// var_dump($data_dtr);

		$output = '';

		$output .= '<div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nama Pelanggan</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="' . $data_tr['p_nama'] . '" placeholder="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nomor HP</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="' . $data_tr['p_nohp'] . '" placeholder="0" disabled>
                                            </div>
                                        </div>
                                    </div>';
		$output .= '<div class="row">
                                <div class="col-lg-12">
                                    <div class="overflow-auto" style="overflow-x:auto;">
								
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Layanan</th>
                                                <th>Nama File</th>
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
				$panjang = '-';
				$lebar = '-';
			}

			if ($dtr['barang_satuan'] == 3) {
				$jumlah = '-';
			} else {
				$jumlah = $dtr['dtr_jumlah'];
			}

			if ($dtr['dtr_nama_file']) {
				$nama_file = $dtr['dtr_nama_file'];
			} else {
				$nama_file = '-';
			}
			$output .= '                    <tr>
                                            <td> ' . $no . '</td>
                                            <td> ' . $dtr['barang_nama'] . '</td>
                                            <td> ' . $nama_file . '</td>
                                            <td class="text-center"> ' . $panjang . '</td>
                                            <td class="text-center"> ' . $lebar . '</td>
                                            <td class="text-center"> ' . $jumlah . '</td>
                                            <td class="text-right"> ' . money($dtr['dtr_harga'])  . '</td>
                                            <td class="text-right"> ' . money($dtr['dtr_total'])  . '</td>
                                        </tr>';
		}
		$output .= '        </table></div>
                                </div>';
		if ($data_tr['tr_status_pengerjaan'] == 2) {
			$output .= ' <div class="col-lg-12">
								<form action="' . base_url() . 'Kasir/ubahPembayaran/' . $transaksi_id . '" method="POST">
                                    <input type="submit" value="Detail Transaksi" class="ml-3 btn btn-success float-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								</form>
                            </div>';
		} else {
			$output .= ' <div class="col-lg-12">
								<form action="' . base_url() . 'Kasir/ubahPembayaran/' . $transaksi_id . '" method="POST">
                                    <input type="submit" value="Proses Pembayaran" class="ml-3 btn btn-success float-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								</form>
                            </div>';
		}

		$output .= '</div>';

		return $output;
	}

	function ubahPembayaran($transaksi_id)
	{
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$data_dtr = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);

		// hitung total harga terbaru
		$subtotal = 0;
		foreach ($data_dtr as $dtr) {
			$subtotal = $subtotal + $dtr['dtr_total'];
		}

		//hitung nominal diskon
		$nom_diskon = 0;
		if ($transaksi['tr_diskon_status'] == 1) {
			$nom_diskon = $transaksi['tr_diskon'] * $subtotal / 100;
		} else {
			$nom_diskon = $transaksi['tr_diskon'];
		}

		// deteksi lunas atau belum 
		$dpp_total = $subtotal - $nom_diskon;
		$ppn_nom = $transaksi['tr_ppn'] * $dpp_total / 100;
		$grand_total = $dpp_total + $ppn_nom;

		if ($grand_total < 1) {
			if ($transaksi['tr_status_pembayaran'] == 3) {
				//status tetep hutang
				$s_pembayaran = 3;
			} else {
				//status belum lunas
				$s_pembayaran = 1;
			}
		} else {
			if ($transaksi['tr_uang'] >= $grand_total) {
				// ini lunas
				$s_pembayaran = 4;
			} else {
				if ($transaksi['tr_status_pembayaran'] == 3) {
					//status tetep hutang
					$s_pembayaran = 3;
				} else {
					//status belum lunas
					$s_pembayaran = 1;
				}
			}
		}


		// perhitunga kembalian
		$kembalian = 0;
		$raw_kembalian = $transaksi['tr_uang'] - $grand_total;
		if ($raw_kembalian < 1) {
			$kembalian = 0;
		} else {
			$kembalian = $raw_kembalian;
		}

		// var_dump('Subtotal : ' . $subtotal);
		// var_dump('Nominal diskon : ' . $nom_diskon);
		// var_dump('Bayar : ' . $transaksi['tr_uang']);
		// var_dump('Status : ' . $s_pembayaran);
		// var_dump('Kembalian : ' . $kembalian);

		// exit();
		$data_tr = [
			"tr_total" => $subtotal,
			"tr_status_pembayaran" => $s_pembayaran,
			"tr_kembalian" => $kembalian
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);

		$data['grand_total'] = $grand_total;

		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Form Ubah Pembayaran";
		$data['jajal'] = "Kasir";
		$data['namamenu'] = "Kasir";
		$data['martis'] = "";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['transaksi_id'] = $transaksi_id;
		$data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$data['data_dtr'] = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);

		$data['bayar_hidden'] = '';
		$data['hutang_hidden'] = '';
		$data['ambil_hidden'] = '';

		if ($data['transaksi']['tr_status_pembayaran'] < 3 || $data['transaksi']['tr_status_pengerjaan'] == 2) {
			$data['ambil_hidden'] = ' hidden';
		} else {
			$data['ambil_hidden'] = ' ';
		}

		if ($data['transaksi']['tr_status_pembayaran'] < 3) {
			$data['hutang_hidden'] = ' ';
		} else {
			$data['hutang_hidden'] = ' hidden';
		}

		if ($data['transaksi']['tr_status_pembayaran'] == 4) {
			$data['p_disabled'] = ' disabled';
		} else {
			$data['p_disabled'] = ' ';
		}


		$data['r_belum'] = ' hidden';
		$data['r_hutang'] = ' hidden';
		$data['r_lunas'] = ' hidden';

		if ($data['transaksi']['tr_status_pembayaran'] == 3) {
			$data['r_belum']  = ' hidden';
			$data['r_hutang'] = ' ';
			$data['r_lunas']  = ' hidden';
		} elseif ($data['transaksi']['tr_status_pembayaran'] == 4) {
			$data['r_belum']  = ' hidden';
			$data['r_hutang'] = ' hidden';
			$data['r_lunas']  = ' ';
		} else {
			$data['r_belum']  = ' ';
			$data['r_hutang'] = ' hidden';
			$data['r_lunas']  = ' hidden';
		}

		$data['done_hidden'] = ' hidden';
		$data['print_hidden'] = ' ';
		if ($data['transaksi']['tr_status_pengerjaan'] == 2) {
			$data['done_hidden'] = ' ';
			$data['print_hidden'] = ' ';
		}

		$data['info_hidden'] = ' ';
		if ($data['transaksi']['tr_status_pengerjaan'] == 2 || $data['transaksi']['tr_status_pembayaran'] == 4 || $data['transaksi']['tr_status_pembayaran'] == 3) {
			$data['info_hidden'] = ' hidden';
		}

		$data['form_hidden'] = '';
		$data['bayar_hidden'] = '';
		$data['p_disabled'] = ' ';
		if ($data['transaksi']['tr_status_pengerjaan'] == 2 &&  $data['transaksi']['tr_status_pembayaran'] == 4) {
			$data['form_hidden'] = ' hidden';
			$data['bayar_hidden'] = ' hidden';
			$data['p_disabled'] = ' disabled';
		}

		$data['hapus_hidden'] = ' ';
		if ($data['transaksi']['tr_status_pengerjaan'] == 2 && $data['transaksi']['tr_status_pembayaran'] == 4) {
			$data['hapus_hidden'] = ' hidden';
		}

		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirUbahPembayaran', $data);
		$this->load->view('Admin/footer');
		// var_dump($data['dtr']);
	}

	function actionUbahPembayaran($transaksi_id)
	{
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		// $nom_bayar = $this->input->post('nom_bayar');
		// $diskon = $this->input->post('diskon');
		$diskon_status = $this->input->post('diskon_status');
		$uang_status = $this->input->post('jenis_bayar');
		$nom_bayar = str_replace('.', '', $this->input->post('nom_bayar'));
		$diskon = str_replace('.', '', $this->input->post('diskon'));
		$ppn = $this->input->post('ppn');
		$nama = $this->input->post('nama');
		$nohp = $this->input->post('nohp');
		// if ($diskon_status == 1) {
		// 	$diskon = $diskon * $transaksi['tr_total'] / 100;
		// }

		$uang = $transaksi['tr_uang'] + $nom_bayar;
		$kembalian = $transaksi['tr_total'] - $uang;
		if ($kembalian < 0) {
			$kembalian = 0;
		}

		$dtNow = date('Y-m-d H:i:s', time());

		$pelanggan_id = $transaksi['p_id'];
		$data_pl = [
			"p_nama" => $nama,
			"p_nohp" => $nohp,
		];
		$this->M_Transaksi->updatePelanggan($data_pl, $pelanggan_id);

		// var_dump($transaksi);
		$data_tr = [
			"tr_uang" => $uang,
			"tr_diskon" => $diskon,
			"tr_diskon_status" => $diskon_status,
			"tr_ppn" => $ppn,
			"tr_kembalian" => $uang,
			"tr_uang_status" => $uang_status,
			"tr_tgl_update" => $dtNow,
			"tr_tgl_bayar" => $dtNow,
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);



		// var_dump($data_tr);
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                       Pembayaran Transaksi atas nama <strong>' . $transaksi['p_nama'] . '</strong> Berhasil
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
		redirect('Kasir/ubahPembayaran/' . $transaksi_id);
	}

	function actionAmbil($transaksi_id)
	{
		echo 'ini adalah action ambil';
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$dtNow = date('Y-m-d H:i:s', time());
		$data_tr = [
			"tr_status_pengerjaan" => 2,
			"tr_tgl_selesai" => $dtNow,
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);
		redirect('Kasir/printNota/' . $transaksi_id);
		// $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
		//                Terima Kasih, Pengambilan Transaksi atas nama <strong>' . $transaksi['p_nama'] . '</strong> Telah Berhasil Dikonfirmasi
		//                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		//                     <span aria-hidden="true">&times;</span>
		//                 </button>
		//             </div>');
		// redirect('Kasir/ubahPembayaran/' . $transaksi_id);
	}

	function actionHutang($transaksi_id)
	{
		echo 'ini adalah action hutang';
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$dtNow = date('Y-m-d H:i:s', time());
		$data_tr = [
			"tr_status_pembayaran" => 3,
			"tr_tgl_update" => $dtNow,
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                       Status Transaksi atas nama <strong>' . $transaksi['p_nama'] . '</strong> berhasil diubah menjadi <strong>Hutang</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
		redirect('Kasir/ubahPembayaran/' . $transaksi_id);
	}

	function cetakNota($transaksi_id)
	{
		$date = date('d-M-Y');
		//	$pegawai=$this->db->query("select * from tb_d_user")->result();
		include_once APPPATH . '/third_party/fpdf/fpdf.php';
		$pdf = new FPDF('L', 'mm', 'A5');

		$pdf->AddPage();

		$pdf->SetFont('Helvetica', 'B', 16);
		$pdf->Cell(0, 7, 'Nota Penjualan', 0, 1, 'C');
		// $pdf->Cell(10,7,'',0,1);

		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(50,6,'No.Transaksi: IS110.210303.0002',0,0);
		// $pdf->Cell(90,6,'',0,0);
		// $pdf->Cell(50,6,'Tanggal: '.$date,0,1);

		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(10,6,'No',1,0,'C');
		// $pdf->Cell(80,6,'Keterangan',1,0,'C');
		// $pdf->Cell(20,6,'Jumlah',1,0,'C');
		// $pdf->Cell(40,6,'Harga',1,0,'C');
		// $pdf->Cell(40,6,'Total',1,1,'C');
		// $pegawai = $this->db->get('tb_d_user')->result();
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$dtr = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);
		$ts_today = time();
		$dt_today = date('Y-m-d', $ts_today);
		$tgl_today = date_indo($dt_today);
		$jam_today = date('H:i', $ts_today);
		// $no=0;
		// foreach ($pegawai as $data){
		//     $no++;
		//     $pdf->Cell(10,6,$no,1,0, 'C');
		//     $pdf->Cell(80,6,$data->alamat,1,0,'L');
		//     $pdf->Cell(20,6,'5',1,0,'C');
		//     $pdf->Cell(40,6,'Rp. 200,000',1,0,'R');
		//     $pdf->Cell(40,6,'Rp. 200,000',1,1,'R');
		// }
		$pdf->SetFont('Helvetica', 'B', 14);

		//Cell(width , height , text , border , end line , [align] )

		$pdf->Cell(130, 5, 'Insan Digital Printing', 0, 0);
		$pdf->Cell(59, 5, '', 0, 1); //end of line

		//set font jadi arial, regular, 12pt
		$pdf->SetFont('Helvetica', '', 12);

		$pdf->Cell(130, 5, 'No Nota       : ' . $transaksi['tr_id'], 0, 0);
		$pdf->Cell(59, 5, '', 0, 1); //end of line

		$pdf->Cell(130, 5, 'Nama Customer :' . $transaksi['p_nama'], 0, 0);
		// $pdf->Cell(25, 5, 'Nama Cutomer'. , 0, 0);
		$pdf->Cell(34, 5, '', 0, 1); //end of line

		$pdf->Cell(130, 5, 'Phone         : ' . $transaksi['p_nohp'], 0, 0);
		$pdf->Cell(25, 5, '', 0, 0);
		$pdf->Cell(34, 5, $tgl_today, 0, 1); //end of line

		$pdf->Cell(130, 5, '', 0, 0);
		$pdf->Cell(25, 5, '', 0, 0);
		$pdf->Cell(34, 5, $jam_today, 0, 1); //end of line

		//buat dummy cell untuk memberi jarak vertikal
		$pdf->Cell(189, 10, '', 0, 1); //end of line


		//buat dummy cell untuk memberi jarak vertikal
		$pdf->Cell(189, 10, '', 0, 1); //end of line

		//invoice 
		$pdf->SetFont('Courier', '', 12);

		$pdf->Cell(80, 5, 'Keterangan', 1, 0);
		$pdf->Cell(20, 5, 'Panjang', 1, 0);
		$pdf->Cell(20, 5, 'Lebar', 1, 0);
		$pdf->Cell(33, 5, 'Jumlah Cetak', 1, 0);
		$pdf->Cell(34, 5, 'Total', 1, 1); //end of line

		$pdf->SetFont('Courier', '', 12);

		//Angka diratakan kanan, jadi kita beri property 'R'

		foreach ($dtr as $data) {
			if ($data['barang_satuan'] == 2) {
			} else {
				$data['dtr_panjang'] = '-';
				$data['dtr_lebar'] = '-';
			}

			$pdf->Cell(80, 5, $data['barang_nama'], 1, 0);
			$pdf->Cell(20, 5, $data['dtr_panjang'], 1, 0);
			$pdf->Cell(20, 5, $data['dtr_lebar'], 1, 0);
			$pdf->Cell(33, 5, $data['dtr_jumlah'], 1, 0);
			$pdf->Cell(34, 5, $data['dtr_total'], 1, 1, 'R'); //end of line
		}
		$pdf->Cell(153, 5, 'Total Harga', 1, 0, 'C');
		$pdf->Cell(34, 5, $transaksi['tr_total'], 1, 0, 'R');
		// $pdf->Cell(130 ,5,'Supaclean Diswasher',1,0);
		// $pdf->Cell(25 ,5,'-',1,0);
		// $pdf->Cell(34 ,5,'1,200',1,1,'R');//end of line

		// $pdf->Cell(130 ,5,'Something Else',1,0);
		// $pdf->Cell(25 ,5,'-',1,0);
		// $pdf->Cell(34 ,5,'1,000',1,1,'R');//end of line
		$pdf->Cell(189, 10, '', 0, 1);

		$pdf->SetFont('Courier', '', 14);

		$pdf->Cell(130, 5, 'Kasir', 0, 0);
		$pdf->Cell(59, 5, 'Gudang', 0, 1); //end of line
		$pdf->Output();
	}



	function daftarHargaGudang()
	{
		$data['user_nama'] = $this->session->userdata('user_nama');
		$data['titel'] = "Persediaan";
		$data['jajal'] = "Persediaan";
		$data['namamenu'] = "Persediaan";
		$data['martis'] = "data_gudang";
		$data['barang'] = $this->M_barang->getBarangAll();
		$data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();
		// var_dump($data['satuan_barang']);
		// exit();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirListBarang', $data);
		$this->load->view('Admin/footer');
	}

	function printNota($transaksi_id)
	{
		// $transaksi_id = 'T210309001';
		$data['transaksi'] = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);
		$data['detail_transaksi'] = $this->M_Transaksi->getDetailTransaksiById($transaksi_id);

		$dt_today = date('Y-m-d', time());
		$tgl_today = date_indo($dt_today);
		$data['tgl_today'] = $tgl_today;
		$this->load->view('Kasir/kasirNotaPdf', $data);
	}

	function hapusTransaksi($transaksi_id)
	{
		$transaksi = $this->M_Transaksi->getTransaksiByIdRow($transaksi_id);

		echo $transaksi_id;
		$data_tr = [
			"tr_status_pengerjaan" => 9,
			"tr_status_pembayaran" => 9,
		];
		$this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Terima Kasih</strong> Transaksi atas nama ' . $transaksi['p_nama'] . ' nama berhasil dihapus        
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
		redirect('Kasir');
	}
}
