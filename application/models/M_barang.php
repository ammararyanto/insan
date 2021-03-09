<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{
	function get_barasng()
	{
		return	$this->db->query("SELECT * FROM tbl_barang a
		JOIN tbl_kategori b ON a.`barang_kategori_id`=b.`kategori_id`")->result();
	}
	function get_barangdetaisl($id)
	{
		return	$this->db->query("SELECT * FROM tbl_barang a
		JOIN tbl_kategori b ON a.`barang_kategori_id`=b.`kategori_id` where barang_id='$id'")->row_array();
	}
	function get_kategori()
	{
		return	$this->db->query("SELECT * FROM tbl_kategori")->result();
	}

	function getBarangAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_barang');
		$this->db->join('tbl_satuan_barang', 'tbl_satuan_barang.sat_barang_id = tbl_barang.barang_satuan');
		$this->db->join('tbl_user', 'tbl_user.user_id = tbl_barang.barang_user_id');
		return $this->db->get()->result_array();
	}

	function getBarangDetail($barang_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_barang');
		$this->db->where('barang_id', $barang_id);
		$this->db->join('tbl_satuan_barang', 'tbl_satuan_barang.sat_barang_id = tbl_barang.barang_satuan');
		return $this->db->get()->row_array();
	}

	function getSatuanBarangAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_satuan_barang');
		return $this->db->get()->result_array();
	}

	public function getBarangLikeId($id)
	{
		$this->db->select("*");
		$this->db->from("tbl_barang");
		$this->db->where('barang_id like', $id . '%');
		return $this->db->count_all_results();
	}

	function insertBarang(
		$id,
		$nama,
		$satuan,
		$harpok,
		$harjul,
		$harjul2,
		$harjul3,
		$stok,
		$user_id,
		$is_unlimited
	) {
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"barang_id" => $id,
			"barang_nama" => $nama,
			"barang_satuan" => $satuan,
			"barang_harpok" => $harpok,
			"barang_harjul" => $harjul,
			"barang_harjul2" => $harjul2,
			"barang_harjul3" => $harjul3,
			"barang_stok" => $stok,
			"barang_tgl_create" => $dtNow,
			"barang_tgl_update" => $dtNow,
			"barang_user_id" => $user_id,
			"barang_is_unlimited" => $is_unlimited,
		];
		$this->db->insert('tbl_barang', $data);
	}

	function updateBarang($data_barang, $barang_id)
	{
		$this->db->where('barang_id', $barang_id);
		$this->db->update('tbl_barang', $data_barang);
	}

	function deleteBarang($barang_id)
	{
		$this->db->where('dtr_id', $barang_id);
		$this->db->delete('tbl_barang');
	}


	function getJenisSatuanAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_jenis_satuan');
		return $this->db->get()->result_array();
	}

	// ========================== operasi data tabel barang masuk ==============================
	function getBarangMasukAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_barang_masuk');
		$this->db->order_by('bm_tanggal_masuk', 'DESC');
		return $this->db->get()->result_array();
	}

	function getBarangMasukByIdRow($bm_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_barang_masuk');
		$this->db->where('bm_id', $bm_id);
		return $this->db->get()->row_array();
	}

	function createBarangMasuk(
		$ms_nama,
		$ms_jumlah,
		$ms_satuan,
		$ms_biaya
	) {
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"bm_id" => '',
			"bm_tanggal_masuk" => $dtNow,
			"bm_nama" => $ms_nama,
			"bm_jumlah" => $ms_jumlah,
			"bm_satuan" => $ms_satuan,
			"bm_biaya" => $ms_biaya
		];
		$this->db->insert('tbl_barang_masuk', $data);
	}

	function updateBarangMasuk($data_barang, $ms_id)
	{
		$this->db->where('bm_id', $ms_id);
		$this->db->update('tbl_barang_masuk', $data_barang);
	}

	function deleteBarangMasuk($ms_id)
	{
		$this->db->where('bm_id', $ms_id);
		$this->db->delete('tbl_barang_masuk');
	}

	// ====================== operasi data tabel pengeluaran ==========================
	function getPengeluaranAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_pengeluaran');
		$this->db->order_by('peng_tanggal', 'DESC');
		return $this->db->get()->result_array();
	}

	function getPengeluaranByIdRow($peng_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_pengeluaran');
		$this->db->where('peng_id', $peng_id);
		return $this->db->get()->row_array();
	}

	function createPengeluaran(
		$pl_nama,
		$pl_biaya,
		$pl_keterangan
	) {
		$dtNow = date('Y-m-d H:i:s', time());
		$data = [
			"peng_id" => '',
			"peng_nama" => $pl_nama,
			"peng_tanggal" => $dtNow,
			"peng_biaya" => $pl_biaya,
			"peng_keterangan" => $pl_keterangan,
		];
		$this->db->insert('tbl_pengeluaran', $data);
	}

	function updatePengeluaran($data_pengeluaran, $peng_id)
	{
		$this->db->where('peng_id', $peng_id);
		$this->db->update('tbl_pengeluaran', $data_pengeluaran);
	}

	function deletePengeluaran($peng_id)
	{
		$this->db->where('peng_id', $peng_id);
		$this->db->delete('tbl_pengeluaran');
	}

	// ================================= operasi laporan barang ==========================================
	function getLaporanPembelian($tgl_awal, $tgl_akhir)
	{
		// $tgl_awal = '2021-03-01';
		// $tgl_akhir = '2021-03-10';
		$dtTimeStart =  date('Y-m-d H:i:s', strtotime($tgl_awal));
		$dtTimeEnd =  date('Y-m-d 23:59:59', strtotime($tgl_akhir));
		$this->db->select('*');
		$this->db->from('tbl_barang_masuk');
		$this->db->where('bm_tanggal_masuk between "' . $dtTimeStart . '" and "' . $dtTimeEnd . '"');
		$this->db->order_by('bm_tanggal_masuk', 'ASC');
		return $this->db->get()->result_array();
	}

	function getLaporanPengeluaran($tgl_awal, $tgl_akhir)
	{
		$dtTimeStart =  date('Y-m-d H:i:s', strtotime($tgl_awal));
		$dtTimeEnd =  date('Y-m-d 23:59:59', strtotime($tgl_akhir));
		$this->db->select('*');
		$this->db->from('tbl_pengeluaran');
		$this->db->where('peng_tanggal between "' . $dtTimeStart . '" and "' . $dtTimeEnd . '"');
		$this->db->order_by('peng_tanggal', 'DESC');
		return $this->db->get()->result_array();
	}
}
