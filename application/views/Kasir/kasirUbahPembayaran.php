<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form Pembayaran Transaksi</h1>
                </div><!-- /.col -->

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="<?= base_url() ?>kasir/actionUbahPembayaran/<?= $transaksi['tr_id'] ?>" method="POST">

                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <a href="<?= base_url('kasir/transaksiBelumDiambil') ?>" class="btn btn-secondary mr-2 float-left"> <i class="fas fa-arrow-circle-left"></i> Kembali</a>
                        <a <?= $hapus_hidden ?> href="<?= base_url('kasir/hapusTransaksi/') . $transaksi['tr_id'] ?>" class="btn btn-danger mr-2 float-right konfirmasi-hapus"> <i class="fas fa-trash-alt"></i> Hapus Transaksi</a>

                    </div>
                    <div class="col-lg-12">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Pelanggan</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body py-2">
                                        <div class="row">
                                            <div class="col-lg-4 col-4">
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="nama">Nama Pelanggan</label>
                                                    <input <?= $p_disabled ?> type="text font-weight-bold" class="form-control" id="" name="nama" value="<?= $transaksi['p_nama'] ?>" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-4 ">
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="nama">Nomor HP</label>
                                                    <input <?= $p_disabled ?> type="text font-weight-bold" class="form-control" id="" name="nohp" value="<?= $transaksi['p_nohp'] ?>" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="nama">Status Transaksi</label>
                                                    <input type="text font-weight-bold" class="form-control" id="" name="" value="<?= $transaksi['s_tr_nama'] ?>" placeholder="0" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Detail Transaksi</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3" <?= $form_hidden ?>>
                                                <a href="<?= base_url() ?>kasir/ubahDetailTransaksi/<?= $transaksi_id ?>" class="btn btn-primary mr-2 float-left"><i class="fas fa-shopping-cart"></i> Ubah Detail Transaksi</a>
                                            </div>
                                            <div class="col-12">
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
                                                        </thead>
                                                        <?php
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

                                                        ?>
                                                            <tr>
                                                                <td> <?= $no ?></td>
                                                                <td> <?= $dtr['barang_nama'] ?></td>
                                                                <td> <?= $nama_file ?></td>
                                                                <td class="text-center"> <?= $panjang ?></td>
                                                                <td class="text-center"> <?= $lebar ?></td>
                                                                <td class="text-center"> <?= $jumlah ?></td>
                                                                <td class="text-right"> <?= money($dtr['dtr_harga'])  ?></td>
                                                                <td class="text-right"> <?= money($dtr['dtr_total'])  ?></td>
                                                            </tr>
                                                        <?php } ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="ribbon-wrapper ribbon-lg" <?= $r_belum ?>>
                                <div class="ribbon bg-info">
                                    Belum Lunas
                                </div>
                            </div>

                            <div class="ribbon-wrapper ribbon-lg" <?= $r_hutang ?>>
                                <div class="ribbon bg-warning text-lg">
                                    Hutang
                                </div>
                            </div>
                            <div class="ribbon-wrapper ribbon-lg" <?= $r_lunas ?>>
                                <div class="ribbon bg-success text-lg">
                                    Lunas
                                </div>
                            </div>



                            <div class="card-header">
                                <h3 class="card-title"> Form Pembayaran</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row my-2">
                                    <div class="col-lg-4 col-4">
                                        <div class="callout callout-info py-1">
                                            <p class="mb-1 font-weight-normal text-info">Total Biaya </p>
                                            <p id="display_total" id="vtotal" class="mb-1 font-weight-bold"><?= money($grand_total) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <?php
                                        if ($transaksi['tr_diskon_status'] == 0) {
                                            $diskon_fix = $transaksi['tr_diskon'];
                                        } else {
                                            $diskon_fix = $transaksi['tr_diskon'] * $transaksi['tr_total'] / 100;
                                        }
                                        ?>
                                        <div class="callout callout-danger py-1">
                                            <p class="mb-1 font-weight-normal text-danger">Diskon </p>
                                            <p id="display_total" id="vdiskon" class="mb-1 font-weight-bold"><?= money($diskon_fix)  ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="callout callout-success py-1">
                                            <p class="mb-1 font-weight-normal text-success">Terbayar </p>
                                            <p id="display_total" id="vuang" class="mb-1 font-weight-bold"><?= money($transaksi['tr_uang']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-end" <?= $form_hidden ?>>

                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label class="col-form-label-sm" for="diskon">Diskon</label>
                                            <input type="text" class="form-control diskon" id="diskon" name="diskon" value="<?= $transaksi['tr_diskon'] ?>" placeholder="0">
                                        </div>
                                    </div>

                                    <?php
                                    if ($transaksi['tr_diskon_status'] == 0) {
                                        $n_cheked = 'checked';
                                        $p_cheked = '';
                                    } else {
                                        $n_cheked = '';
                                        $p_cheked = 'checked';
                                    }
                                    ?>
                                    <div class="col-lg-6 col-6">
                                        <div class="form-inline ml-0 mb-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="nominal" name="diskon_status" value="0" class="custom-control-input diskon_status" <?= $n_cheked ?>>
                                                <label class="custom-control-label" for="nominal">Rp</label>
                                            </div>
                                            <div class="custom-control custom-radio ml-3">
                                                <input type="radio" id="prosentase" name="diskon_status" value="1" class="custom-control-input diskon_status" <?= $p_cheked ?>>
                                                <label class="custom-control-label" for="prosentase">%</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label-sm" for="diskon">PPN(%)</label>
                                            <input type="text" class="form-control diskon" id="ppn" name="ppn" value="<?= $transaksi['tr_ppn'] ?>" placeholder="0">
                                        </div>
                                    </div>
                                </div>



                                <div class="row" <?= $form_hidden ?>>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label class="col-form-label-sm" for="nama">Nominal Bayar</label>
                                            <input type="text font-weight-bold" class="form-control uang_cash" id="nom_bayar" name="nom_bayar" value="" placeholder="0">
                                            <small class="text-danger"><?= form_error('uang_cash') ?></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <div class="form-group">
                                            <label class="col-form-label-sm" for="nama">Jenis Pembayaran</label>
                                            <select class='form-control' id='jenis_bayar' name='jenis_bayar' onchange="hide_harjul_input()">

                                                <?php if ($transaksi['tr_uang_status'] == 'Cash') { ?>
                                                    <option value="Cash">Cash / Tunai</option>
                                                    <option value="Transfer">Transfer</option>
                                                <?php } else { ?>
                                                    <option value="Transfer">Transfer</option>
                                                    <option value="Cash">Cash / Tunai</option>
                                                <?php    } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12" <?= $ambil_hidden ?>>
                                        <div class="alert alert-success" role="alert">
                                            <p class="text-justify"> <strong>Informasi,</strong> Anda dapat melakukan Konfirmasi pengambilan cetakan dengan menekan tombol dibawah ini</p>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="<?= base_url('kasir/actionAmbil/') . $transaksi_id ?>" target="_blank" class="btn btn-primary float-right"><i class="fas fa-handshake"> </i> Konfirmasi Pengambilan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" <?= $done_hidden ?>>

                                        <?php
                                        $ts_ambil = strtotime($transaksi['tr_tgl_selesai']);
                                        $dt_ambil = date('Y-m-d', $ts_ambil);
                                        $tgl_ambil = date_indo($dt_ambil);
                                        $jam_ambil = date('H:i', $ts_ambil);
                                        ?>

                                        <div class="alert alert-info" role="alert">
                                            <p class="text-justify"> <strong>Informasi,</strong> Transaksi ini sudah diambil oleh pelanggan pada tanggal <strong> <?= $tgl_ambil ?></strong> dan pukul <strong><?= $jam_ambil ?></strong></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" <?= $info_hidden ?>>
                                        <div class="alert alert-info" role="alert">
                                            <p class="text-justify"> <strong>Informasi !</strong> Pengambilan barang dapat dilakukan jika pembayaran transaksi sudah mencapai <strong>KELUNASAN</strong> atau transaksi sudah terkonfirmasi sebagai <strong>HUTANG</strong> </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <!-- <input type="submit" value="Bayar" class="ml-3 btn btn-success float-right">
                                    <input type="submit" value="Bayar" class="ml-3 btn btn-success float-right"> -->

                                        <button type="submit" name="submit" value="1" class="btn btn-success btn-icon-split float-right ml-2" <?= $bayar_hidden ?>>
                                            <span class="text">Submit Pembayaran</span>
                                        </button>

                                        <a href="<?= base_url('kasir/actionHutang/') . $transaksi_id ?>" class="btn btn-warning float-right ml-2" <?= $hutang_hidden ?>> Hutang</a>
                                        <a href="<?= base_url('kasir/printNota/') . $transaksi_id ?>" target="_blank" class="btn btn-primary float-right" <?= $print_hidden ?>> Cetak Nota</a>




                                    </div>
                                </div>

                            </div>

                            <!-- /.card-body -->
                        </div>

                    </div>

                </div>


        </div>
        </form>
    </section>
    <!-- /.content -->
</div>

<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">Laziz</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?php echo date('M'); ?>
    </div>
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/moment.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/jquery.price_format.min.js' ?>"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>


<script>
    $(function() {
        $('#nom_bayar').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });

    $(function() {
        $('#diskon').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });
</script>

<script>
    $('.konfirmasi-hapus').on('click', function(e) {
        // alert('terpencet');
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Akan menghapus transaksi atas nama <?= $transaksi['p_nama'] ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    });
</script>