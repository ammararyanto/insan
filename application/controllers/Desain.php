<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desain extends CI_Controller
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
        $data['titel'] = "Dashboard Desain";
        $data['jajal'] = "Desain";
        $data['namamenu'] = "Desain";
        $data['martis'] = "";
        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Desain/desainDashboard', $data);
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

        var_dump($p_id . $p_nama . $p_nohp);

        $desain_id = $user['user_id'];
        $total = 0;
        $diskon = 0;
        $diskon_status = 0;
        $uang = 0;
        $uang_status = 1;

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

        redirect('desain/ubahDetailTransaksi/' . $transaksi_id);
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

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Desain/desainFormTransaksi', $data);
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
        $tr_total = 0;
        foreach ($data_dtr as $dtr) {
            $tr_total = $tr_total + $dtr['dtr_total'];
        }
        $data_tr = [
            "tr_total" => $tr_total
        ];
        $this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                       Terima Kasih, Transaksi atas nama <strong>Nama Pelanggan</strong> Berhasilkan diinputkan, silahkan melanjutan ke kasir proses pembayaran
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
        redirect('desain');
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
        $output .= '<table class="table" id="cartTable">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th style="width:10%">Panjang (cm)</th>
                                <th style="width:10%">Lebar (cm)</th>
                                <th style="width:10%">Jumlah Cetak(pcs)</th>
                                <th style="width:10%">Harga satuan</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbKeranjang">';
        $nmbr = 0;
        if ($cart_list) {
            foreach ($cart_list as $cl) {
                $nmbr = $nmbr + 1;
                if ($cl['barang_satuan'] == 1) {
                    $output .= '<tr class="records" id="row' . $nmbr . '">
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '"> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '"> </td>
                                <td class="pt-3" id="vdtr_harga"> ' . $cl['dtr_harga'] . ' <input name="" id="dtr_harga" type="text" value="' . $cl['dtr_harga'] . '" hidden>  </td>
                                <td class="pt-3" id="vdtr_total">' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
                } else if ($cl['barang_satuan'] == 2) {
                    $output .= '<tr class="records" id="row' . $nmbr . '">
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '"> </td>
                                <td class="pt-3" id="vdtr_harga"> ' . $cl['dtr_harga'] . ' <input name="" id="dtr_harga" type="text" value="' . $cl['dtr_harga'] . '" hidden>  </td>
                                <td class="pt-3" id="vdtr_total">' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
                } else {
                    $output .= '<tr class="records" id="row' . $nmbr . '">
                                <td class="pt-3">' . $cl['barang_nama'] . ' <input class=" form-control form-control-sm" id="dtr_total" type="text" value="' . $cl['dtr_total'] . '" hidden> <input class=" form-control form-control-sm" name="" id="dtr_id" type="text" value="' . $cl['dtr_id'] . '" hidden></td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_panjang" style="text-align: center;" type="text" value="' . $cl['dtr_panjang'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_lebar" style="text-align: center;" type="text" value="' . $cl['dtr_lebar'] . '" hidden> </td>
                                <td style="width:10%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_jumlah" style="text-align: center;" type="text" value="' . $cl['dtr_jumlah'] . '" hidden> </td>
                                <td style="width:15%"> <input class=" form-control form-control-sm" onchange="sum(' . $nmbr . ')" name="" id="dtr_harga" style="text-align: left;" type="text" value="' . $cl['dtr_harga'] . '">  </td>
                                <td class="pt-3" id="vdtr_total" >' . $cl['dtr_total'] . ' </td>
                                <td> <a href="#" onclick="hapusKeranjang(' . $nmbr . ')" class="badge badge-danger btn_del' . $nmbr . '" data-detid="' . $cl['dtr_id'] . '" data-detnama="' . $cl['barang_nama'] . '">Hapus</a> </td>
                            </tr>';
                }
            };
            $output .= '</tbody></table>';
        } else {
            $output .= '</tbody></table>';
            $output .= '<div class="col-lg-12" id="info_cartKosong">
                                                <div class="alert alert-default border border-warning" role="alert">
                                                    <b>Informasi!</b> Belum ada pembelian ditambahkan
                                                </div>
                                            </div>';
        }


        return $output;
    }

    function updateDataKeranjang($detail_transaksi_id)
    {
        $data_dtr = $this->M_Transaksi->getDetailTransaksiByIdRow($detail_transaksi_id);

        $dtr_panjang = $this->input->post('dtr_panjang');
        $dtr_lebar = $this->input->post('dtr_lebar');
        $dtr_jumlah = $this->input->post('dtr_jumlah');
        $dtr_harga = $this->input->post('dtr_harga');

        if ($data_dtr['barang_satuan'] == 2) {
            if ($dtr_jumlah <= 50) {
                $harjul = $data_dtr['barang_harjul'];
            } elseif ($dtr_jumlah <= 100) {
                $harjul = $data_dtr['barang_harjul2'];
            } else {
                $harjul = $data_dtr['barang_harjul3'];
            }
        } elseif ($data_dtr['barang_satuan'] == 3) {
            $harjul = $dtr_harga;
        } else {
            $harjul = $data_dtr['barang_harjul'];
        }
        $dtr_total = $dtr_panjang * $dtr_lebar / 10000 * $dtr_jumlah * $harjul;

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

    function inputDT()
    {
        // Percobaan fitur input detail transasksi
        $transaksi_id = 'T210225001';
        $barang_id = 'B001';
        $panjang = 100;
        $lebar = 300;
        $jumlah = 1;
        $harga = 5000;
        $total = 60000;
        $keterangan = 'Banner acara gathering family PT UHU UHU';
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

        // echo 'Function Aktif';

        //Percobaan fitur edit detail transaksi
        // $detail_transaksi_id = '1';
        // $data_dtr = [
        //     "dtr_panjang" => 80,
        //     "dtr_lebar" => 250
        // ];
        // $this->M_Transaksi->updateDetailTransaksi($data_dtr, $detail_transaksi_id);
        // echo 'Function Update Detail Transaksi Aktif';

        // $this->M_Transaksi->deleteDetailTransaksi('1');
    }

    function inputT()
    {
        // //  Percobaan fungsi input transaksi
        // $transaksi_id = 'T210225001';
        // $desain_id = 1;
        // $total = 60000;
        // $diskon = 15;
        // $diskon_status = 1;
        // $uang = 51000;
        // $uang_status = 1;
        // $this->M_Transaksi->insertTransaksi(
        //     $transaksi_id,
        //     $desain_id,
        //     $total,
        //     $diskon,
        //     $diskon_status,
        //     $uang,
        //     $uang_status
        // );
        // echo 'Function Input Transaksi Aktif';

        //  Percobaan fungsi edit transaksi
        $transaksi_id = 'T210225001';
        $data_tr = [
            "tr_uang" => 69000,
            "tr_diskon_status" => 0
        ];
        $this->M_Transaksi->updateTransaksi($data_tr, $transaksi_id);

        echo 'Function Update Transaksi Aktif';
    }

    function inputBarang()
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
