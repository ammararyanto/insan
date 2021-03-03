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
}
