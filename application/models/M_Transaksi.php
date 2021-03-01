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

	function insertTransaksi(
		$transaksi_id,
		$desain_id,
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
			"tr_tgl_masuk" => $dtNow,
			"tr_tgl_update" => $dtNow,
			"tr_tgl_selesai" => '',
			"tr_total" => $total,
			"tr_diskon" => $diskon,
			"tr_diskon_status" => $diskon_status,
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
		$this->db->from("tbl_jual");
		$this->db->where('jual_nofak', $id_transaksi);
		$this->db->join('tbl_user', 'tbl_user.user_id = tbl_jual.jual_user_id');
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

	function getTransaksiByTime($time_start, $time_end)
	{
		$this->db->select("*");
		$this->db->from("tbl_jual");

		$this->db->join('tbl_user', 'tbl_user.user_id = tbl_jual.jual_user_id');
		return $this->db->get()->result_array();
	}
}
