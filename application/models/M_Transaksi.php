<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Transaksi extends CI_Model
{
	function get_barang()
	{
		return	$this->db->query("select * from tbl_barang")->result();
	}

	function getBarangByLike($keyword)
	{
		$this->db->select('*');
		// $this->db->where('stok_barang >', 0);
		$this->db->limit(10);
		$this->db->from('tbl_barang');
		if ($keyword != '') {
			$this->db->like('barang_nama', $keyword);
			$this->db->or_like('barang_id', $keyword);
			// $this->db->where('stok_barang >', 0);
		}
		return $this->db->get();
		// return $this->db->get()->result_array();
	}

	public function getTransaksiLikeId($id)
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_id like', $id . '%');
		return $this->db->count_all_results();
	}

	function insertPelanggan($p_id, $p_nama, $p_nohp)
	{
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"p_id"   => $p_id,
			"p_nama" => $p_nama,
			"p_nohp" => $p_nohp,
		];
		$this->db->insert('tbl_pelanggan', $data);
	}

	function updatePelanggan($data_pl, $pelanggan_id)
	{
		$this->db->where('p_id', $pelanggan_id);
		$this->db->update('tbl_pelanggan', $data_pl);
	}

	function insertTransaksi(
		$transaksi_id,
		$desain_id,
		$p_id,
		$total,
		$diskon,
		$diskon_status,
		$uang,
		$uang_status
	) {
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"tr_id" => $transaksi_id,
			"tr_kasir_id" => '',
			"tr_desain_id" => $desain_id,
			"tr_pelanggan_id" => $p_id,
			"tr_tgl_masuk" => $dtNow,
			"tr_tgl_update" => $dtNow,
			"tr_tgl_selesai" => '',
			"tr_total" => $total,
			"tr_diskon" => $diskon,
			"tr_diskon_status" => $diskon_status,
			"tr_ppn" => 0,
			"tr_uang" => $uang,
			"tr_uang_status" => $uang_status,
			"tr_kembalian" => 0,
			"tr_status_pengerjaan" => 1,
			"tr_status_pembayaran" => 1,
		];

		$this->db->insert('tbl_transaksi', $data);
	}

	function updateTransaksi($data_tr, $transaksi_id)
	{
		$this->db->where('tr_id', $transaksi_id);
		$this->db->update('tbl_transaksi', $data_tr);
	}


	function insertDetailTransaksi(
		$transaksi_id,
		$barang_id,
		$panjang,
		$lebar,
		$jumlah,
		$harga,
		$total,
		$keterangan
	) {
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"dtr_id" => '',
			"dtr_transaksi_id" => $transaksi_id,
			"dtr_barang_id" => $barang_id,
			"dtr_panjang" => $panjang,
			"dtr_lebar" => $lebar,
			"dtr_jumlah" => $jumlah,
			"dtr_harga" => $harga,
			"dtr_total" => $total,
			"dtr_tanggal" => $dtNow,
			"dtr_keterangan" => $keterangan,
			"dtr_status" => 1
		];
		$this->db->insert('tbl_detail_transaksi', $data);
	}

	function updateDetailTransaksi($data_dtr, $detail_transaksi_id)
	{
		$this->db->where('dtr_id', $detail_transaksi_id);
		$this->db->update('tbl_detail_transaksi', $data_dtr);
	}

	function deleteDetailTransaksi($detail_transaksi_id)
	{
		$this->db->where('dtr_id', $detail_transaksi_id);
		$this->db->delete('tbl_detail_transaksi');
	}

	function getTransaksiByIdRow($id_transaksi)
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_id', $id_transaksi);
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id= tbl_transaksi.tr_status_pengerjaan');
		return $this->db->get()->row_array();
	}

	function getDetailTransaksiById($id_transaksi)
	{
		$this->db->select("*");
		$this->db->from("tbl_detail_transaksi");
		$this->db->where('dtr_transaksi_id', $id_transaksi);
		$this->db->join('tbl_barang', 'tbl_barang.barang_id = tbl_detail_transaksi.dtr_barang_id');
		$this->db->join('tbl_satuan_barang', 'tbl_satuan_barang.sat_barang_id = tbl_barang.barang_satuan');
		$this->db->order_by('dtr_id', 'ASC');
		return $this->db->get()->result_array();
	}

	function getDetailTransaksiByIdRow($dtr_id)
	{
		$this->db->select("*");
		$this->db->from("tbl_detail_transaksi");
		$this->db->where('dtr_id', $dtr_id);
		$this->db->join('tbl_barang', 'tbl_barang.barang_id = tbl_detail_transaksi.dtr_barang_id');
		return $this->db->get()->row_array();
	}

	function getTransaksiBelumDiambil()
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pengerjaan', 1);
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id = tbl_transaksi.tr_status_pengerjaan');
		$this->db->join('tbl_status_pembayaran', 'tbl_status_pembayaran.s_pmb_id = tbl_transaksi.tr_status_pembayaran');
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		// $this->db->order_by('tr_tgl_masuk', 'ASC');
		return $this->db->get()->result_array();
	}

	function getTransaksiSudahDiambil()
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pengerjaan', 2);
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id = tbl_transaksi.tr_status_pengerjaan');
		$this->db->join('tbl_status_pembayaran', 'tbl_status_pembayaran.s_pmb_id = tbl_transaksi.tr_status_pembayaran');
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		// $this->db->order_by('tr_tgl_masuk', 'ASC');
		return $this->db->get()->result_array();
	}

	function getTransaksiHutang()
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pembayaran', 3);
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id = tbl_transaksi.tr_status_pengerjaan');
		$this->db->join('tbl_status_pembayaran', 'tbl_status_pembayaran.s_pmb_id = tbl_transaksi.tr_status_pembayaran');
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		// $this->db->order_by('tr_tgl_masuk', 'ASC');
		return $this->db->get()->result_array();
	}

	function getTransaksiSudahDiambilByTime($tgl_awal, $tgl_akhir)
	{
		$dtTimeStart =  date('Y-m-d H:i:s', strtotime($tgl_awal));
		$dtTimeEnd =  date('Y-m-d 23:59:59', strtotime($tgl_akhir));
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pengerjaan', 2);
		$this->db->where('tr_tgl_selesai between "' . $dtTimeStart . '" and "' . $dtTimeEnd . '"');
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id = tbl_transaksi.tr_status_pengerjaan');
		$this->db->join('tbl_status_pembayaran', 'tbl_status_pembayaran.s_pmb_id = tbl_transaksi.tr_status_pembayaran');
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		// $this->db->order_by('tr_tgl_masuk', 'ASC');
		return $this->db->get()->result_array();
	}

	function getLaporanTransaksi($tgl_awal, $tgl_akhir, $s_bayar)
	{
		$dtTimeStart =  date('Y-m-d H:i:s', strtotime($tgl_awal));
		$dtTimeEnd =  date('Y-m-d 23:59:59', strtotime($tgl_akhir));
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pembayaran', $s_bayar);
		if ($s_bayar == 4) {
			$this->db->where('tr_tgl_bayar between "' . $dtTimeStart . '" and "' . $dtTimeEnd . '"');
		} else {
			$this->db->where('tr_tgl_selesai between "' . $dtTimeStart . '" and "' . $dtTimeEnd . '"');
		}
		$this->db->join('tbl_status_transaksi', 'tbl_status_transaksi.s_tr_id = tbl_transaksi.tr_status_pengerjaan');
		$this->db->join('tbl_status_pembayaran', 'tbl_status_pembayaran.s_pmb_id = tbl_transaksi.tr_status_pembayaran');
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.p_id= tbl_transaksi.tr_pelanggan_id');
		$this->db->order_by('tr_tgl_selesai', 'ASC');
		return $this->db->get()->result_array();
	}

	public function getAwalBulan()
	{
		// setiap tanggal 10 pada bulan ini



	}

	public function getAkhirBulan()
	{
		// setiap tanggal 9 pada bulan ini

	}

	function getDatesFromRange($start, $end, $format = 'Y-m-d')
	{

		// Declare an empty array 
		$array = array();

		// Variable that store the date interval 
		// of period 1 day 
		$interval = new DateInterval('P1D');

		$realEnd = new DateTime($end);
		$realEnd->add($interval);

		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

		// Use loop to store date into array 
		foreach ($period as $date) {
			$array[] = $date->format($format);
		}

		// Return the array elements 
		return $array;
	}

	function getTransaksiLikeTanggal($tanggal)
	{
		$this->db->select("*");
		$this->db->from("tbl_transaksi");
		$this->db->where('tr_status_pembayaran', 4);
		$this->db->where('tr_tgl_bayar like', $tanggal . '%');
		return $this->db->get()->result_array();
	}

	function getPembelianLikeTanggal($tanggal)
	{
		$this->db->select("*");
		$this->db->from("tbl_barang_masuk");
		$this->db->where('bm_tanggal_masuk like', $tanggal . '%');
		return $this->db->get()->result_array();
	}

	function getPengeluaranLikeTanggal($tanggal)
	{
		$this->db->select("*");
		$this->db->from("tbl_pengeluaran");
		$this->db->where('peng_tanggal like', $tanggal . '%');
		return $this->db->get()->result_array();
	}
}
