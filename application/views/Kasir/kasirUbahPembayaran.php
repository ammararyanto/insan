<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Form Pembayaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="<?= base_url() ?>kasir/actionUbahPembayaran/<?= $transaksi['tr_id'] ?>" method="POST">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="callout callout-info py-1">
                                            <p class="mb-1 font-weight-normal text-info">Total Biaya </p>
                                            <p id="display_total" id="vtotal" class="mb-1 font-weight-bold"><?= money($transaksi['tr_total']) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <?php
                                        if ($transaksi['tr_diskon_status'] == 0) {
                                            $diskon_fix = $transaksi['tr_diskon'];
                                        } else {
                                            $diskon_fix = $transaksi['tr_diskon'] * $transaksi['tr_total'] / 100;
                                        }
                                        ?>
                                        <div class="callout callout-danger py-1">
                                            <p class="mb-1 font-weight-normal text-danger">Diskon </p>
                                            <p id="display_total" id="vdiskon" class="mb-1 font-weight-bold"><?= $diskon_fix ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="callout callout-success py-1">
                                            <p class="mb-1 font-weight-normal text-success">Terbayar </p>
                                            <p id="display_total" id="vuang" class="mb-1 font-weight-bold"><?= money($transaksi['tr_uang']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-end">

                                    <div class="col-md-6">
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
                                    <div class="col-lg-auto">
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
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label-sm" for="nama">Nominal Dibayarkan</label>
                                            <input type="text font-weight-bold" class="form-control uang_cash" id="nom_bayar" name="nom_bayar" value="" placeholder="0">
                                            <small class="text-danger"><?= form_error('uang_cash') ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <!-- <input type="submit" value="Bayar" class="ml-3 btn btn-success float-right">
                                    <input type="submit" value="Bayar" class="ml-3 btn btn-success float-right"> -->
                                        <?php
                                        if ($transaksi['tr_status_pembayaran'] == 4) {
                                        } else {
                                            # code...
                                        }
                                        ?>

                                        <button type="submit" name="submit" value="1" class="btn btn-primary btn-icon-split float-right">
                                            <span class="text">Submit Pembayaran</span>
                                        </button>
                                        <button type="submit" name="submit" value="2" class="btn btn-info btn-icon-split float-right mr-2">
                                            <span class="text">Konfirmasi Pengambilan</span>
                                        </button>
                                        <a href="<?= base_url('admin') ?>" class="btn btn-secondary mr-2 float-right">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- /.card-body -->
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pelanggan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nama Pelanggan</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="<?= $transaksi['p_nama'] ?>" placeholder="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nomor HP</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="<?= $transaksi['p_nohp'] ?>" placeholder="0" disabled>
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
                                        </thead>
                                        <?php
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

                                        ?>
                                            <tr>
                                                <td> <?= $no ?></td>
                                                <td> <?= $dtr['barang_nama'] ?></td>
                                                <td> <?= $panjang ?></td>
                                                <td> <?= $lebar ?></td>
                                                <td> <?= $jumlah ?></td>
                                                <td> <?= $dtr['dtr_harga'] ?></td>
                                                <td> <?= $dtr['dtr_total'] ?></td>
                                            </tr>
                                        <?php } ?>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>
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