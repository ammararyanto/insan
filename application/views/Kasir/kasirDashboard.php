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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="<?= base_url() ?>kasir/transaksiBelumDiambil" class="small-box bg-info">
                        <div class="inner">
                            <h3 class="mt-3">12</h3>
                            <h5>Belum Dibayar</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="" class="small-box bg-success">
                        <div class="inner">
                            <h3 class="mt-3">14</h3>
                            <h5>Sudah Dibayar</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="" class="small-box bg-success py-2">
                        <div class="inner">
                            <h4 class="mt-3">Daftar</h4>
                            <h5>Harga Gudang</h5>

                            <p> </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="modal fade" id="modal-pelanggan">
                <form action=<?= base_url('desain/inputTransaksi') ?> method="POST">
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
                                            <input class="form-control form-control" type="text" placeholder="- masukan nama pelanggan -" id="b_nama" name="b_nama" autocomplete="off">
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