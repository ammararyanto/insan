<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller
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
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanDashboard', $data);
        $this->load->view('Admin/footer');
    }

    function laporanTransaksi()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";
        $data['pengeluaran'] = $this->M_barang->getPengeluaranAll();
        $data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();

        $data['timeToday'] = date('Y-m-d', time());
        $data['time1MonthBefore'] = date('Y-m-d', strtotime('-30 days', time()));

        // $data_tr = $this->M_Transaksi->getLaporanTransaksi();

        //membuat list semua data detail transaksi menjadi satu
        // $dtr_index = 0;
        // $data_dtr = [];
        // foreach ($data_tr as $tr) {
        //     $dtr_index = $dtr_index + 1;
        //     $dtr[$dtr_index] = $this->M_Transaksi->getDetailTransaksiById($tr['tr_id']);
        //     $data_dtr = array_merge($data_dtr, $dtr[$dtr_index]);
        // };

        $dtr_id_acuan = '';

        // proses pengolahan data transaksi final
        // $tr_fix = [];
        // $no = 0;
        // for ($i = 0; $i < count($data_dtr); $i++) {
        //     if ($i == 0) {
        //         $dtr_id_acuan = $data_dtr[0]['dtr_transaksi_id'];
        //         $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);

        //         if ($tr['tr_diskon_status'] == 0) {
        //             $diskon_fix = $tr['tr_diskon'];
        //         } else {
        //             $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
        //         }
        //         $g_total = $tr['tr_total'] - $diskon_fix;

        //         $no = $no + 1;

        //         if ($data_dtr[$i]['barang_satuan'] == 1) {
        //             $panjang = $data_dtr[$i]['dtr_panjang'];
        //             $lebar = $data_dtr[$i]['dtr_lebar'];
        //         } else {
        //             $panjang = '-';
        //             $lebar = '-';
        //         }

        //         if ($data_dtr[$i]['barang_satuan'] == 3) {
        //             $jumlah = '-';
        //         } else {
        //             $jumlah = $data_dtr[$i]['dtr_jumlah'];
        //         }

        //         $tr_fix[$i] = [
        //             "tr_no" => strval($no),
        //             "tr_id" => $tr['tr_id'],
        //             "dtr_id" => $data_dtr[$i]['dtr_id'],
        //             "p_nama" => $tr['p_nama'],
        //             "barang_nama" => $data_dtr[$i]['barang_nama'],
        //             "dtr_panjang" => $panjang,
        //             "dtr_lebar" => $lebar,
        //             "dtr_jumlah" => $jumlah,
        //             "dtr_harga" => $data_dtr[$i]['dtr_harga'],
        //             "dtr_total" =>  $data_dtr[$i]['dtr_total'],
        //             "tr_total" => $tr['tr_total'],
        //             "tr_diskon" => $diskon_fix,
        //             "g_total" => $g_total
        //         ];
        //         // var_dump('pertama');
        //     } else {
        //         if ($data_dtr[$i]['dtr_transaksi_id'] == $dtr_id_acuan) {
        //             if ($data_dtr[$i]['barang_satuan'] == 1) {
        //                 $panjang = $data_dtr[$i]['dtr_panjang'];
        //                 $lebar = $data_dtr[$i]['dtr_lebar'];
        //             } else {
        //                 $panjang = '-';
        //                 $lebar = '-';
        //             }

        //             if ($data_dtr[$i]['barang_satuan'] == 3) {
        //                 $jumlah = '-';
        //             } else {
        //                 $jumlah = $data_dtr[$i]['dtr_jumlah'];
        //             }

        //             $tr_fix[$i] = [
        //                 "tr_no" => '',
        //                 "tr_id" => '',
        //                 "dtr_id" => $data_dtr[$i]['dtr_id'],
        //                 "p_nama" => '',
        //                 "barang_nama" => $data_dtr[$i]['barang_nama'],
        //                 "dtr_panjang" => $panjang,
        //                 "dtr_lebar" => $lebar,
        //                 "dtr_jumlah" => $jumlah,
        //                 "dtr_harga" => $data_dtr[$i]['dtr_harga'],
        //                 "dtr_total" =>  $data_dtr[$i]['dtr_total'],
        //                 "tr_total" => '',
        //                 "tr_diskon" => '',
        //                 "g_total" => ''
        //             ];
        //             // var_dump('kosong');
        //         } else {
        //             $dtr_id_acuan = $data_dtr[$i]['dtr_transaksi_id'];
        //             $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);
        //             if ($tr['tr_diskon_status'] == 0) {
        //                 $diskon_fix = $tr['tr_diskon'];
        //             } else {
        //                 $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
        //             }
        //             $g_total = $tr['tr_total'] - $diskon_fix;
        //             $no = $no + 1;

        //             if ($data_dtr[$i]['barang_satuan'] == 1) {
        //                 $panjang = $data_dtr[$i]['dtr_panjang'];
        //                 $lebar = $data_dtr[$i]['dtr_lebar'];
        //             } else {
        //                 $panjang = '-';
        //                 $lebar = '-';
        //             }

        //             if ($data_dtr[$i]['barang_satuan'] == 3) {
        //                 $jumlah = '-';
        //             } else {
        //                 $jumlah = $data_dtr[$i]['dtr_jumlah'];
        //             }

        //             $tr_fix[$i] = [
        //                 "tr_no" => strval($no),
        //                 "tr_id" => $tr['tr_id'],
        //                 "dtr_id" => $data_dtr[$i]['dtr_id'],
        //                 "p_nama" => $tr['p_nama'],
        //                 "barang_nama" => $data_dtr[$i]['barang_nama'],
        //                 "dtr_panjang" => $panjang,
        //                 "dtr_lebar" => $lebar,
        //                 "dtr_jumlah" => $jumlah,
        //                 "dtr_harga" => $data_dtr[$i]['dtr_harga'],
        //                 "dtr_total" =>  $data_dtr[$i]['dtr_total'],
        //                 "tr_total" => $tr['tr_total'],
        //                 "tr_diskon" => $diskon_fix,
        //                 "g_total" => $g_total
        //             ];
        //             // var_dump('pertama x');
        //         }
        //     }
        // }

        // for ($i = 0; $i < count($data_dtr); $i++) {
        //     if ($i == 0) {
        //         $dtr_id_acuan = $data_dtr[0]['dtr_transaksi_id'];
        //         $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);
        //         $tr_fix[$i] = $tr['p_nama'];
        //         var_dump('pertama');
        //     } else {
        //         if ($data_dtr[$i]['dtr_transaksi_id'] == $dtr_id_acuan) {
        //             $tr_fix[$i] = '';
        //             var_dump('kosong');
        //         } else {
        //             $dtr_id_acuan = $data_dtr[$i]['dtr_transaksi_id'];
        //             $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);
        //             $tr_fix[$i] = $tr['p_nama'];
        //             var_dump('pertama x');
        //         }
        //     }
        // }

        // $data['data_lt'] = $tr_fix;
        // var_dump($data['data_lt']);
        // exit();

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanListTransaksi', $data);
        $this->load->view('Admin/footer');
    }

    function tampilDataTransaksi($tgl_awal, $tgl_akhir, $s_bayar)
    {
        echo $this->dataTransaksi($tgl_awal, $tgl_akhir, $s_bayar);
    }

    function dataTransaksi($tgl_awal, $tgl_akhir, $s_bayar)
    {
        $data_tr = $this->M_Transaksi->getLaporanTransaksi($tgl_awal, $tgl_akhir, $s_bayar);

        // var_dump($data_tr);
        // exit();
        //membuat list semua data detail transaksi menjadi satu
        $dtr_index = 0;
        $data_dtr = [];
        foreach ($data_tr as $tr) {
            $dtr_index = $dtr_index + 1;
            $dtr[$dtr_index] = $this->M_Transaksi->getDetailTransaksiById($tr['tr_id']);
            $data_dtr = array_merge($data_dtr, $dtr[$dtr_index]);
        };

        $dtr_id_acuan = '';

        // proses pengolahan data transaksi final
        $tr_fix = [];
        $no = 0;
        for ($i = 0; $i < count($data_dtr); $i++) {
            if ($i == 0) {
                $dtr_id_acuan = $data_dtr[0]['dtr_transaksi_id'];
                $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);

                if ($tr['tr_diskon_status'] == 0) {
                    $diskon_fix = $tr['tr_diskon'];
                } else {
                    $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
                }
                $g_total = $tr['tr_total'] - $diskon_fix;

                $no = $no + 1;

                if ($data_dtr[$i]['barang_satuan'] == 1) {
                    $panjang = $data_dtr[$i]['dtr_panjang'];
                    $lebar = $data_dtr[$i]['dtr_lebar'];
                } else {
                    $panjang = '-';
                    $lebar = '-';
                }

                if ($data_dtr[$i]['barang_satuan'] == 3) {
                    $jumlah = '-';
                } else {
                    $jumlah = $data_dtr[$i]['dtr_jumlah'];
                }

                $tr_fix[$i] = [
                    "tr_no" => strval($no),
                    "tr_id" => $tr['tr_id'],
                    "dtr_id" => $data_dtr[$i]['dtr_id'],
                    "p_nama" => $tr['p_nama'],
                    "barang_nama" => $data_dtr[$i]['barang_nama'],
                    "dtr_panjang" => $panjang,
                    "dtr_lebar" => $lebar,
                    "dtr_jumlah" => $jumlah,
                    "dtr_harga" => $data_dtr[$i]['dtr_harga'],
                    "dtr_total" =>  $data_dtr[$i]['dtr_total'],
                    "tr_total" => $tr['tr_total'],
                    "tr_diskon" => $diskon_fix,
                    "g_total" => $g_total
                ];
                // var_dump('pertama');
            } else {
                if ($data_dtr[$i]['dtr_transaksi_id'] == $dtr_id_acuan) {
                    if ($data_dtr[$i]['barang_satuan'] == 1) {
                        $panjang = $data_dtr[$i]['dtr_panjang'];
                        $lebar = $data_dtr[$i]['dtr_lebar'];
                    } else {
                        $panjang = '-';
                        $lebar = '-';
                    }

                    if ($data_dtr[$i]['barang_satuan'] == 3) {
                        $jumlah = '-';
                    } else {
                        $jumlah = $data_dtr[$i]['dtr_jumlah'];
                    }

                    $tr_fix[$i] = [
                        "tr_no" => '',
                        "tr_id" => '',
                        "dtr_id" => $data_dtr[$i]['dtr_id'],
                        "p_nama" => '',
                        "barang_nama" => $data_dtr[$i]['barang_nama'],
                        "dtr_panjang" => $panjang,
                        "dtr_lebar" => $lebar,
                        "dtr_jumlah" => $jumlah,
                        "dtr_harga" => $data_dtr[$i]['dtr_harga'],
                        "dtr_total" =>  $data_dtr[$i]['dtr_total'],
                        "tr_total" => '',
                        "tr_diskon" => '',
                        "g_total" => ''
                    ];
                    // var_dump('kosong');
                } else {
                    $dtr_id_acuan = $data_dtr[$i]['dtr_transaksi_id'];
                    $tr = $this->M_Transaksi->getTransaksiByIdRow($dtr_id_acuan);
                    if ($tr['tr_diskon_status'] == 0) {
                        $diskon_fix = $tr['tr_diskon'];
                    } else {
                        $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
                    }
                    $g_total = $tr['tr_total'] - $diskon_fix;
                    $no = $no + 1;

                    if ($data_dtr[$i]['barang_satuan'] == 1) {
                        $panjang = $data_dtr[$i]['dtr_panjang'];
                        $lebar = $data_dtr[$i]['dtr_lebar'];
                    } else {
                        $panjang = '-';
                        $lebar = '-';
                    }

                    if ($data_dtr[$i]['barang_satuan'] == 3) {
                        $jumlah = '-';
                    } else {
                        $jumlah = $data_dtr[$i]['dtr_jumlah'];
                    }

                    $tr_fix[$i] = [
                        "tr_no" => strval($no),
                        "tr_id" => $tr['tr_id'],
                        "dtr_id" => $data_dtr[$i]['dtr_id'],
                        "p_nama" => $tr['p_nama'],
                        "barang_nama" => $data_dtr[$i]['barang_nama'],
                        "dtr_panjang" => $panjang,
                        "dtr_lebar" => $lebar,
                        "dtr_jumlah" => $jumlah,
                        "dtr_harga" => $data_dtr[$i]['dtr_harga'],
                        "dtr_total" =>  $data_dtr[$i]['dtr_total'],
                        "tr_total" => $tr['tr_total'],
                        "tr_diskon" => $diskon_fix,
                        "g_total" => $g_total
                    ];
                    // var_dump('pertama x');
                }
            }
        }

        $data['data_lt'] = $tr_fix;

        if ($tr_fix) {
            $output = '';
            $omset = 0;
            foreach ($tr_fix as $x) {
                if ($x['g_total'] == '') {
                    $x['g_total'] = 0;
                }
                $omset = $omset + $x['g_total'];
            }

            $output .= '<div class="col-lg-12">
                                            <div class="callout callout-info py-1">
                                                <h5 class="mb-1 font-weight-bold">Total Omset : ' . rupiah($omset)  . ' </h5>
                                            </div>

                                        </div>';
            $output .= '<div class="col-lg-12 col-12">';
            $output .= '<div class="overflow-auto" style="overflow-x:auto;">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th hidden>No</th>
                                                    <th>No</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Detail Transaksi</th>
                                                    <th>Panjang</th>
                                                    <th>Lebar</th>
                                                    <th>Qty</th>
                                                    <th>Harga Satuan </th>
                                                    <th>Harga Total </th>
                                                    <th>Total Awal </th>
                                                    <th>Diskon </th>
                                                    <th>Total Akhir </th>
                                                </tr>
                                            </thead>';

            $no = 0;
            foreach ($tr_fix as $tf) {
                $no = $no + 1;

                if ($tf['tr_total']) {
                    $total = money($tf['tr_total']);
                } else {
                    $total = $tf['tr_total'];
                }

                if ($tf['tr_diskon']) {
                    $diskon = money($tf['tr_diskon']);
                } else {
                    $diskon = $tf['tr_diskon'];
                }

                if ($tf['g_total']) {
                    $g_total = money($tf['g_total']);
                } else {
                    $g_total = $tf['g_total'];
                }

                // $ts_masuk = strtotime($tf['tr_tgl_selesai']);
                // $dt_masuk = date('Y-m-d', $ts_masuk);
                // $tgl_masuk = date_indo($dt_masuk);



                $output .=
                    '<tr>
                                                <td hidden> ' . $no . ' </td>
                                                <td> ' . $tf['tr_no'] . ' </td>
                                                <td> ' . $tf['p_nama'] . ' </td>
                                                <td> ' . $tf['barang_nama'] . ' </td>
                                                <td> ' . $tf['dtr_panjang'] . ' </td>
                                                <td> ' . $tf['dtr_lebar'] . ' </td>
                                                <td> ' . $tf['dtr_jumlah'] . ' </td>
                                                <td> ' . money($tf['dtr_harga']) . ' </td>
                                                <td> ' . money($tf['dtr_total']) . ' </td>
                                                <td> ' . $total . ' </td>
                                                <td> ' . $diskon . ' </td>
                                                <td> ' . $g_total . ' </td>
                                            </tr>';
            }





            $output .= '</table>
                                    </div>';
            $output .= '</div>';

            $output .= '<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>';
        } else {
            $output = '';
            $output .= '
            <div class="col-lg-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Data Tidak Ditemukan
                            </div>
                        </div>';
        }


        return $output;
    }

    // ============================== Function untuk fitur Laporan Pembelian barang ==================
    function laporanPembelianBarang()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";
        // $data['pengeluaran'] = $this->M_barang->getPengeluaranAll();
        $data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();

        $data['laporan_pembelian'] = $this->M_barang->getLaporanPembelian(0, 0);

        $data['timeToday'] = date('Y-m-d', time());
        $data['time1MonthBefore'] = date('Y-m-d', strtotime('-30 days', time()));

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanListPembelian', $data);
        $this->load->view('Admin/footer');
    }

    function tampilDataPembelian($tgl1, $tgl2)
    {
        echo $this->dataPembelian($tgl1, $tgl2);
    }

    function dataPembelian($tgl1, $tgl2)
    {
        $data_pembelian = $this->M_barang->getLaporanPembelian($tgl1, $tgl2);
        if ($data_pembelian) {

            $total_pembelian = 0;
            foreach ($data_pembelian as $x) {
                if ($x['bm_biaya'] == '') {
                    $x['bm_biaya'] = 0;
                }
                $total_pembelian = $total_pembelian + $x['bm_biaya'];
            }

            $output = '<div class="col-lg-12">
                                            <div class="callout callout-success py-1">
                                                <h5 class="mb-1 font-weight-bold">Total Pembelian Barang : ' . rupiah($total_pembelian)  . '</h5>
                                            </div>
                                        </div>';


            $output .= '';
            $output .= '<div class="col-lg-12 col-12">';
            $output .= '<div class="overflow-auto" style="overflow-x:auto;">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>';

            $no = 0;
            foreach ($data_pembelian as $dp) {
                $no = $no + 1;

                $ts_masuk = strtotime($dp['bm_tanggal_masuk']);
                $dt_masuk = date('Y-m-d', $ts_masuk);
                $tgl_masuk = date_indo($dt_masuk);

                $output .=
                    '<tr>
                                                <td> ' . $no . ' </td>
                                                <td> ' . $tgl_masuk . '</td>
                                                <td> ' . $dp['bm_nama'] . ' </td>
                                                <td> ' . $dp['bm_jumlah'] . '</td>
                                                <td> ' . $dp['bm_satuan'] . ' </td>
                                                <td class="text-right"> ' . money($dp['bm_biaya'])  . ' </td>

                                            </tr>';
            }





            $output .= '</table>
                                    </div>';
            $output .= '</div>';

            $output .= '<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>';
        } else {
            $output = '';
            $output .= '
            <div class="col-lg-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Data Tidak Ditemukan
                            </div>
                        </div>';
        }



        return $output;
    }

    // ============================== Function untuk fitur Laporan Pengeluaran ==================
    function laporanPengeluaran()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";
        // $data['pengeluaran'] = $this->M_barang->getPengeluaranAll();
        $data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();

        $data['laporan_pengeluaran'] = $this->M_barang->getLaporanPengeluaran('2021-03-09', '2021-03-10');

        // var_dump($data['laporan_pengeluaran']);
        // exit();

        $data['timeToday'] = date('Y-m-d', time());
        $data['time1MonthBefore'] = date('Y-m-d', strtotime('-30 days', time()));

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanListPengeluaran', $data);
        $this->load->view('Admin/footer');
    }

    function tampilDataPengeluaran($tgl1, $tgl2)
    {
        echo $this->dataPengeluaran($tgl1, $tgl2);
    }

    function dataPengeluaran($tgl1, $tgl2)
    {
        $data_pengeluaran = $this->M_barang->getLaporanPengeluaran($tgl1, $tgl2);
        if ($data_pengeluaran) {
            $output = '';

            $total_pengeluaran = 0;
            foreach ($data_pengeluaran as $x) {
                if ($x['peng_biaya'] == '') {
                    $x['peng_biaya'] = 0;
                }
                $total_pengeluaran = $total_pengeluaran + $x['peng_biaya'];
            }
            $output .= '<div class="col-lg-12">
                                            <div class="callout callout-danger py-1">
                                                <h5 class="mb-1 font-weight-bold">Total Pengeluaran Operasional : ' . rupiah($total_pengeluaran)  . '</h5>
                                            </div>

                                        </div>';
            $output .= '<div class="col-lg-12 col-12">';
            $output .= '<div class="overflow-auto" style="overflow-x:auto;">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Pengeluaran</th>
                                                    <th>Biaya</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>';

            $no = 0;
            foreach ($data_pengeluaran as $dp) {
                $no = $no + 1;

                $ts_masuk = strtotime($dp['peng_tanggal']);
                $dt_masuk = date('Y-m-d', $ts_masuk);
                $tgl_masuk = date_indo($dt_masuk);

                $output .=
                    '<tr>
                                                <td> ' . $no . ' </td>
                                                <td> ' . $tgl_masuk . '</td>
                                                <td> ' . $dp['peng_nama'] . ' </td>
                                                <td class="text-right"> ' . money($dp['peng_biaya'])  . ' </td>
                                                <td> ' . $dp['peng_keterangan'] . ' </td>

                                            </tr>';
            }
            $output .= '</table>
                                    </div>';
            $output .= '</div>';

            $output .= '<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>';
        } else {
            $output = '';
            $output .= '
            <div class="col-lg-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Data Tidak Ditemukan
                            </div>
                        </div>';
        }
        return $output;
    }

    // ============================== Function untuk fitur Laporan Rekapan ==================

    function laporanRekap()
    {
        $data['user_nama'] = $this->session->userdata('user_nama');
        $data['titel'] = "Persediaan";
        $data['jajal'] = "Persediaan";
        $data['namamenu'] = "Laporan";
        $data['martis'] = "";
        // $data['pengeluaran'] = $this->M_barang->getPengeluaranAll();
        $data['satuan_barang'] = $this->M_barang->getSatuanBarangAll();

        $data['laporan_pengeluaran'] = $this->M_barang->getLaporanPengeluaran('2021-03-09', '2021-03-10');

        // $date_list = $this->M_Transaksi->getDatesFromRange('2021-03-08', '2021-03-09');

        // $data_rekap = [];
        // for ($i = 0; $i < count($date_list); $i++) {

        //     $transaksi = $this->M_Transaksi->getTransaksiLikeTanggal($date_list[$i]);
        //     $total_transaksi = 0;
        //     foreach ($transaksi as $tr) {
        //         if ($tr['tr_diskon_status'] == 0) {
        //             $diskon_fix = $tr['tr_diskon'];
        //         } else {
        //             $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
        //         }
        //         $g_total = $tr['tr_total'] - $diskon_fix;

        //         $total_transaksi = $total_transaksi + $g_total;
        //     }

        //     $pembelian = $this->M_Transaksi->getPembelianLikeTanggal($date_list[$i]);
        //     $total_pembelian = 0;
        //     foreach ($pembelian as $pb) {
        //         $total_pembelian = $total_pembelian + $pb['bm_biaya'];
        //     }

        //     $pengeluaran = $this->M_Transaksi->getPengeluaranLikeTanggal($date_list[$i]);
        //     $total_pengeluaran = 0;
        //     foreach ($pengeluaran as $pl) {
        //         $total_pengeluaran = $total_pengeluaran + $pl['peng_biaya'];
        //     }

        //     $data_rekap[$i] = [
        //         "tanggal" =>  $date_list[$i],
        //         "g_total" => $total_transaksi,
        //         "bm_biaya" => $total_pembelian,
        //         "peng_biaya" => $total_pengeluaran,
        //     ];

        //     // var_dump($total_pengeluaran);
        //     // var_dump($pembelian);
        //     // var_dump($pengeluaran);
        // }
        // var_dump($data_rekap);

        // exit();

        $data['timeToday'] = date('Y-m-d', time());
        $data['time1MonthBefore'] = date('Y-m-d', strtotime('-30 days', time()));

        $this->load->view('Admin/header', $data);
        $this->load->view('Admin/Menu', $data);
        $this->load->view('Laporan/laporanListRekap', $data);
        $this->load->view('Admin/footer');
    }

    function tampilDataRekap($tgl_awal, $tgl_akhir)
    {
        echo $this->dataRekap($tgl_awal, $tgl_akhir);
    }

    function dataRekap($tgl_awal, $tgl_akhir)
    {
        $date_list = $this->M_Transaksi->getDatesFromRange($tgl_awal, $tgl_akhir);

        $data_rekap = [];
        for ($i = 0; $i < count($date_list); $i++) {

            $transaksi = $this->M_Transaksi->getTransaksiLikeTanggal($date_list[$i]);
            $total_transaksi = 0;
            foreach ($transaksi as $tr) {
                if ($tr['tr_diskon_status'] == 0) {
                    $diskon_fix = $tr['tr_diskon'];
                } else {
                    $diskon_fix = $tr['tr_diskon'] * $tr['tr_total'] / 100;
                }
                $g_total = $tr['tr_total'] - $diskon_fix;

                $total_transaksi = $total_transaksi + $g_total;
            }

            $pembelian = $this->M_Transaksi->getPembelianLikeTanggal($date_list[$i]);
            $total_pembelian = 0;
            foreach ($pembelian as $pb) {
                $total_pembelian = $total_pembelian + $pb['bm_biaya'];
            }

            $pengeluaran = $this->M_Transaksi->getPengeluaranLikeTanggal($date_list[$i]);
            $total_pengeluaran = 0;
            foreach ($pengeluaran as $pl) {
                $total_pengeluaran = $total_pengeluaran + $pl['peng_biaya'];
            }

            $data_rekap[$i] = [
                "tanggal" =>  $date_list[$i],
                "g_total" => $total_transaksi,
                "bm_biaya" => $total_pembelian,
                "peng_biaya" => $total_pengeluaran,
            ];

            // var_dump($total_pengeluaran);
            // var_dump($pembelian);
            // var_dump($pengeluaran);
        }

        if ($data_rekap) {
            $output = '';

            $total_omset = 0;
            $total_pembelian = 0;
            $total_pengeluaran = 0;
            foreach ($data_rekap as $x) {
                // if ($x['g_total'] == '') {
                //     $x['g_total'] = 0;
                // }

                // if ($x['bm_biaya'] == '') {
                //     $x['bm_biaya'] = 0;
                // }

                // if ($x['peng_biaya'] == '') {
                //     $x['peng_biaya'] = 0;
                // }
                $total_omset = $total_omset + $x['g_total'];
                $total_pembelian = $total_pembelian + $x['bm_biaya'];
                $total_pengeluaran = $total_pengeluaran + $x['peng_biaya'];
            }

            $output .= '<div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="callout callout-info py-1">
                                                    <p class="mb-1 font-weight-normal ">Total Omset </p>
                                            <p id="display_total" id="vdiskon" class="mb-1 font-weight-bold">' . rupiah($total_omset) . '</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="callout callout-success py-1">
                                                    <p class="mb-1 font-weight-normal">Total Pembelian Barang </p>
                                            <p id="display_total" id="vdiskon" class="mb-1 font-weight-bold">' . rupiah($total_pembelian) . '</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="callout callout-danger py-1">
                                                    <p class="mb-1 font-weight-normal">Total Pengeluaran Operasional </p>
                                            <p id="display_total" id="vdiskon" class="mb-1 font-weight-bold">' . rupiah($total_pengeluaran) . '</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

            $output .= '<div class="col-lg-12 col-12">';
            $output .= '<div class="overflow-auto" style="overflow-x:auto;">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Total Omset</th>
                                                    <th>Total Pembelian Barang</th>
                                                    <th>Total Pengeluaran</th>
                                                </tr>
                                            </thead>';

            $no = 0;
            foreach ($data_rekap as $dr) {
                $no = $no + 1;

                // $ts_masuk = strtotime($dr['tanggal']);
                $dt_masuk = $dr['tanggal'];
                $tgl_masuk = date_indo($dt_masuk);

                $output .=
                    '<tr>
                                                <td> ' . $no . ' </td>
                                                <td> ' . $tgl_masuk . '</td>
                                                <td class="text-right"> ' . money($dr['g_total'])  . ' </td>
                                                <td class="text-right"> ' . money($dr['bm_biaya'])  . ' </td>
                                                <td class="text-right"> ' . money($dr['peng_biaya'])  . ' </td>

                                            </tr>';
            }
            $output .= '</table>
                                    </div>';
            $output .= '</div>';

            $output .= '<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>';
        } else {
            $output = '';
            $output .= '
            <div class="col-lg-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Data Tidak Ditemukan
                            </div>
                        </div>';
        }



        return $output;
    }

    function test()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        var_dump($tgl_awal . ' === ' . $tgl_akhir);

        $dtTimeStart =  date('Y-m-d H:i:s', strtotime($tgl_awal));
        $dtTimeEnd =  date('Y-m-d 23:59:59', strtotime($tgl_akhir));

        var_dump($dtTimeStart . ' === ' . $dtTimeEnd);
    }
    function excelPembelian($tgl1, $tgl2)
    {
        $data_pembelian = $this->M_barang->getLaporanPembelian($tgl1, $tgl2);


        $indo_tgl1 = date_indo($tgl1);
        $indo_tgl2 = date_indo($tgl2);

        if ($tgl1 == $tgl2) {
            $tanggal = $indo_tgl1;
        } else {
            $tanggal = $indo_tgl1 . ' - ' . $indo_tgl2;
        }

        // ============================== START STYLING CELL ==================================

        $style_title = array(
            'font' => [
                'bold' => true,
                'size' => 15
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        );

        $style_date = array(
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        );

        $style_head = array(
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );
        // ---------------------------------- END STYLING CELL --------------------------------

        $style_row = array(
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );

        $style_money = array(
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'numberFormat' => [
                'formatCode' => '#,##0'
            ]
        );

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);


        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray($style_title);
        $sheet->setCellValue('A1', 'Daftar Pembelian Barang');

        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->applyFromArray($style_date);
        $sheet->setCellValue('A2', $tanggal);


        $sheet->getStyle('A4')->applyFromArray($style_head);
        $sheet->getStyle('B4')->applyFromArray($style_head);
        $sheet->getStyle('C4')->applyFromArray($style_head);
        $sheet->getStyle('D4')->applyFromArray($style_head);
        $sheet->getStyle('E4')->applyFromArray($style_head);
        $sheet->getStyle('F4')->applyFromArray($style_head);


        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Tanggal');
        $sheet->setCellValue('C4', 'Nama Barang');
        $sheet->setCellValue('D4', 'Jumlah');
        $sheet->setCellValue('E4', 'Satuan');
        $sheet->setCellValue('F4', 'Biaya');

        // ================= Loop list data ==========================
        $no = 1;
        $x = 5;
        $total_pembelian = 0;
        foreach ($data_pembelian as $dp) {
            $total_pembelian = $total_pembelian + $dp['bm_biaya'];
            $ts_masuk = strtotime($dp['bm_tanggal_masuk']);
            $dt_masuk = date('Y-m-d', $ts_masuk);
            $tgl_masuk = date_indo($dt_masuk);

            $biaya = money($dp['bm_biaya']);

            $sheet->getStyle('A' . $x)->applyFromArray($style_row);
            $sheet->getStyle('B' . $x)->applyFromArray($style_row);
            $sheet->getStyle('C' . $x)->applyFromArray($style_row);
            $sheet->getStyle('D' . $x)->applyFromArray($style_row);
            $sheet->getStyle('E' . $x)->applyFromArray($style_row);
            $sheet->getStyle('F' . $x)->applyFromArray($style_money);

            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $tgl_masuk);
            $sheet->setCellValue('C' . $x, $dp['bm_nama']);
            $sheet->setCellValue('D' . $x, $dp['bm_jumlah']);
            $sheet->setCellValue('E' . $x, $dp['bm_satuan']);
            $sheet->setCellValue('F' . $x, $dp['bm_biaya']);
            $x++;
        }

        // ===================== SUM Operation ===========================
        $sheet->getStyle('E' . $x)->applyFromArray($style_head);
        $sheet->getStyle('F' . $x)->applyFromArray($style_money);

        $sheet->setCellValue('E' . $x, 'Total');
        $sheet->setCellValue('F' . $x, $total_pembelian);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pembelian ' . $tgl1 . ' sampai ' . $tgl2;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
