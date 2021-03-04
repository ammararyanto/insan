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
		// var_dump($data['count_belum_diambil']);

		// exit();
		$this->load->view('Admin/header', $data);
		$this->load->view('Admin/Menu', $data);
		$this->load->view('Kasir/kasirDashboard', $data);
		$this->load->view('Admin/footer');
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
                                </div>';
		if ($data_tr['tr_status_pengerjaan'] == 3) {
		} else {
			$output .= ' <div class="col-lg-12">
								<form action="' . base_url() . 'kasir/ubahPembayaran/' . $transaksi_id . '" method="POST">
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
			redirect('kasir/cetakNota/' . $transaksi_id);
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
}
