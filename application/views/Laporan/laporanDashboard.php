<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Laporan</h1>
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



                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="<?= base_url() ?>Laporan/laporanTransaksi" class="small-box bg-info">
                        <div class="inner">
                            <h4 class="mt-3">Laporan</h4>
                            <h5>Transaksi Percetakan</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="<?= base_url() ?>Laporan/laporanPembelianBarang" class="small-box bg-success">
                        <div class="inner">
                            <h4 class="mt-3">Laporan</h4>
                            <h5>Pembelian Barang</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="<?= base_url() ?>Laporan/laporanPengeluaran" class="small-box bg-danger">
                        <div class="inner">
                            <h4 class="mt-3">Laporan</h4>
                            <h5>Pengeluaran Operasional</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comment-dollar"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="<?= base_url() ?>Laporan/laporanRekap" class="small-box bg-primary">
                        <div class="inner">
                            <h4 class="mt-3">Laporan</h4>
                            <h5>Rekapitulasi</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6" hidden>
                    <!-- small box -->
                    <a href="<?= base_url() ?>kasir/daftarHargaGudang" class="small-box bg-success py-2">
                        <div class="inner">
                            <h4 class="mt-3"></h4>
                            <h5>Harga Gudang</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                    </a>
                </div>

            </div>
            <div class="modal fade" id="modal-pelanggan">
                <form action=<?= base_url('kasir/inputTransaksi') ?> method="POST">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Input Transaksi Baru</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="form-edit">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nabar">Nama Pelanggan</label>
                                            <input class="form-control form-control" type="text" placeholder="- masukan nama pelanggan -" id="p_nama" name="p_nama" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="nabar">No HP</label>
                                            <input class="form-control form-control" type="text" placeholder="- masukan no hp pelanggan -" id="p_nohp" name="p_nohp" autocomplete="off" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); " maxlength="13">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="modal-footer justify-content-between px-0">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                </form>
                <!-- /.modal-dialog -->
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

<script>
    function inputPelanggan() {
        $('#modal-pelanggan').modal('show');
    }
</script>