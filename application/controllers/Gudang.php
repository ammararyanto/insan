<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
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

    function dataBarang()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Persediaan";
        $data['martis'] = "Barang";
        $data['barang'] = $this->M_barang->getBarangAll();
        $data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();
        // var_dump($data['satuan_barang']);
        // exit();
        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Gudang/listBarang', $data);
        $this->load->view('Admin/footer');
    }


    function tampilDetailBarangEdit($barang_id)
    {
        echo $this->detailBarangEdit($barang_id);
    }

    function detailBarangEdit($barang_id)
    {
        $data_barang = $this->M_barang->getBarangDetail($barang_id);
        $list_satuan = $this->M_barang->getSatuanBarangAll();

        $output = '';
        $output .= '<div class="form-group">
                                <label for="kabar">Kode Barang ddd</label>
                                <input value="' . $data_barang['barang_id'] . '" class="form-control form-control-sm" type="text" placeholder="kode" id="" name="" autocomplete="off" disabled>
                                <input value="' . $data_barang['barang_id'] . '" class="form-control form-control-sm" type="text" placeholder="kode" id="b_id_edit" name="b_id_edit" autocomplete="off" hidden>
                            </div>
                            <div class="form-group">
                                <label for="nabar">Nama Barang</label>
                                <input value="' . $data_barang['barang_nama'] . '" class="form-control form-control-sm" type="text" placeholder="nama" id="b_nama_edit" name="b_nama_edit" autocomplete="off">
                            </div>';

        $output .= '<div class="form-group">
                                <label>Jenis Satuan</label>
                                <select class="form-control form-control-sm" id="b_satuan_edit" name="b_satuan_edit">
                                    <option value="' . $data_barang['barang_satuan'] . '">' . $data_barang['sat_barang_nama'] . '</option>';
        foreach ($list_satuan as $ls) {
            if ($ls['sat_barang_id'] == $data_barang['barang_satuan']) {
            } else {
                $output .= '<option value="' . $ls['sat_barang_id'] . '">' . $ls['sat_barang_nama'] . '</option>';
            }
        }
        $output .= '</select>
                    </div>';


        $output .= '<div class="form-group">
                                <label for="satuan">Harga Pokok</label>
                                <input value="' . $data_barang['barang_harpok'] . '" class="form-control form-control-sm" type="text" placeholder="Harga Pokok" id="b_harpok_edit" name="b_harpok_edit" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="satuan">Harga Jual</label>
                                <input value="' . $data_barang['barang_harjul'] . '" class="form-control form-control-sm" type="text" placeholder="Harga Jual" id="b_harjul_edit" name="b_harjul_edit" autocomplete="off">
                            </div>
                            </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>';
        return $output;
    }

    function inputBarang()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $user = $this->db->get_where('tbl_user', ['user_nama' =>
        $this->session->userdata('user_nama')])->row_array();

        //proses pembuatan kode / id barang
        $kode_tanggal = 'B' . date('ymd', time());
        $count_nota_today = $this->M_barang->getBarangLikeId($kode_tanggal);
        $antrian = $count_nota_today + 1;
        if ($antrian < 10) {
            $kode_antrian = "00" . $antrian;
        } else if ($antrian < 100) {
            $kode_antrian = "0" . $antrian;
        }
        $barang_id_raw = $kode_tanggal . $kode_antrian;
        $barang_id = $barang_id_raw;
        $id = $barang_id;

        $nama = $this->input->post('b_nama');
        $satuan = $this->input->post('b_satuan');
        $harpok = $this->input->post('b_harpok');
        $harjul = $this->input->post('b_harjul');
        $stok = $this->input->post('b_stok');
        $user_id = $user['user_id'];
        if ($satuan == 3) {
            $is_unlimited = 1;
        } else {
            $is_unlimited = 0;
        }

        $this->M_Barang->insertBarang(
            $id,
            $nama,
            $satuan,
            $harpok,
            $harjul,
            $stok,
            $user_id,
            $is_unlimited
        );

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>' . $nama . ' </strong> berhasil diinputkan ke data gudang
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
        redirect('gudang/dataBarang');
    }

    function editBarang()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $user = $this->db->get_where('tbl_user', ['user_nama' =>
        $this->session->userdata('user_nama')])->row_array();

        $id = $this->input->post('b_id_edit');
        $nama = $this->input->post('b_nama_edit');
        $satuan = $this->input->post('b_satuan_edit');
        $harpok = $this->input->post('b_harpok_edit');
        $harjul = $this->input->post('b_harjul_edit');
        $user_id = $user['user_id'];
        if ($satuan == 3) {
            $is_unlimited = 1;
        } else {
            $is_unlimited = 0;
        }

        $data_barang = [
            "barang_nama" => $nama,
            "barang_satuan" => $satuan,
            "barang_harpok" => $harpok,
            "barang_harjul" => $harjul,
            "barang_tgl_update" => date('Y-m-d H:i:s', time()),
            "barang_user_id" => $user_id,
            "barang_is_unlimited" => $is_unlimited,

        ];
        $this->M_barang->updateBarang($data_barang, $id);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        data <strong>' . $nama . ' </strong> berhasil diubah
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
        redirect('gudang/dataBarang');
    }

    function inputBarangx()
    {
        //  Percobaan fungsi input barang
        // $id = 'B001';
        // $nama = 'kertas Asturo';
        // $satuan = 2;
        // $harpok = 500;
        // $harjul = 750;
        // $stok = 5;
        // $user_id = 1;
        // $is_unlimited = 0;

        // $this->M_Transaksi->insertBarang(
        //     $id,
        //     $nama,
        //     $satuan,
        //     $harpok,
        //     $harjul,
        //     $stok,
        //     $user_id,
        //     $is_unlimited
        // );

        // echo 'Function Insert barang aktif';

        //  Percobaan fungsi edit barang
        $barang_id = 'B210224002';
        $data_barang = [
            "barang_nama" => 'Ivory A3 Premium',
            "barang_harpok" => 3000,
            "barang_harjul" => 4000,
        ];
        $this->M_Transaksi->updateBarang($data_barang, $barang_id);

        echo 'Function Update Barang Aktif';
    }
}
