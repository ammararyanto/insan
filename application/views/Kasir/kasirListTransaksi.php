<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $titel ?></h1>
                </div><!-- /.col -->

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <a href="<?= base_url('kasir') ?>" class="btn btn-secondary mr-2 float-left"> <i class="fas fa-arrow-circle-left"></i> Kembali</a>
                        </div>
                        <div class="col-lg-12">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="card">
                                <div class="card-header bg-blue ui-sortable-handle">
                                    <!-- <button type="button" class="btn btn-warning" onclick="tampil()">
                                        Tambah Barang
                                    </button> -->

                                    <div class="card-tools">
                                        <!--<span class="badge badge-danger">8 New Members</span>-->
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="overflow-auto" style="overflow-x:auto;" m>

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Pelanggan</th>
                                                    <th style="width: 15%;">Tanggal Masuk</th>
                                                    <th style="width: 5%;">Jam Masuk</th>
                                                    <th>Total</th>
                                                    <th>Diskon</th>
                                                    <th style="width: 5%;">Status Transaksi</th>
                                                    <th style="width: 5%;">Status Pembayaran</th>


                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 0;
                                            foreach ($transaksi as $tr) {
                                                $no = $no + 1;
                                                $ts_masuk = strtotime($tr['tr_tgl_masuk']);
                                                $dt_masuk = date('Y-m-d', $ts_masuk);
                                                $tgl_masuk = date_indo($dt_masuk);
                                                $jam_masuk = date('H:i', $ts_masuk);

                                                // $ts_update = strtotime($b['barang_tgl_create']);
                                                // $dt_update = date('Y-m-d', $ts_update);
                                                // $tgl_update = date_indo($dt_update);
                                                // $jam_update = date('H:i', $ts_update);

                                            ?>
                                                <tr>
                                                    <!-- <td><button onclick="edit()" type="button" class="badge"><span class="fas fa-file"></span></button></td> -->
                                                    <td><a onclick="viewDetail('<?= $tr['tr_id'] ?>')" class="btn btn-secondary btn-sm" href="#" data-toggle="tooltip" title="Bayar"><i class="fas fa-eye"></i></i></a></td>
                                                    <td> <?= $tr['p_nama'] ?></td>
                                                    <td> <?= $tgl_masuk ?> </td>
                                                    <td> <?= $jam_masuk ?></td>
                                                    <td> <?= $tr['tr_total'] ?></td>
                                                    <td> <?= $tr['tr_diskon'] ?></td>
                                                    <td> <?= $tr['s_tr_nama'] ?></td>
                                                    <td> <?= $tr['s_pmb_nama'] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--/.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <!-- /.card -->
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal-detail">


            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Transaksi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="form-detail">
                        <!-- <div class="row">
                                <div class="col=lg-12">
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

                                        <tr>

                                            <td> 1</td>
                                            <td> 2</td>
                                            <td> 3</td>
                                            <td> 4</td>
                                            <td> 5</td>
                                            <td> 6</td>
                                            <td> 7</td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text font-weight-bold" class="form-control" id="tr_total_harga" name="tr_total_harga" value="009">
                                    <input type="submit" value="Proses Pembayaran" class="ml-3 btn btn-success float-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

                                </div>
                            </div> -->


                    </div>
                    <!-- /.modal-content -->
                </div>

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
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>
<script>
    function viewDetail(id) {
        $('#modal-detail').modal('show');
        // alert(id);
        $('#form-detail').load("<?= base_url() ?>kasir/tampilDetailTransaksi/" + id);
    }

    function hide_harjul_input() {
        var $b_satuan = document.getElementById("b_satuan").value;
        if ($b_satuan == 2) {
            document.getElementById('vharjul2').style.display = 'block';
            document.getElementById('vharjul3').style.display = 'block';
            document.getElementById('txharjul').style.display = 'none';
            document.getElementById('tyharjul').style.display = 'block';
        } else {
            document.getElementById('vharjul2').style.display = 'none';
            document.getElementById('vharjul3').style.display = 'none';
            document.getElementById('txharjul').style.display = 'block';
            document.getElementById('tyharjul').style.display = 'none';
        }
        return
    }

    function hide_stok_input() {
        // var $unl = document.getElementById("b_unlimited").value;
        // alert('YES');

        if ($("#unl_stok input:checkbox:checked").length > 0) {
            // any one is checked
            document.getElementById('field_stok').style.display = 'none';


        } else {
            // alert('Anda belum memilih kerusakan yang dibatalkan');
            // event.preventDefault();
            // none is checked
            document.getElementById('field_stok').style.display = 'block';

        }
    }

    function hide_harjul_edit() {
        var $b_satuan = document.getElementById("b_satuan_edit").value;
        if ($b_satuan == 2) {
            document.getElementById('vharjul2_edit').style.display = 'block';
            document.getElementById('vharjul3_edit').style.display = 'block';
            document.getElementById('txharjul_edit').style.display = 'none';
            document.getElementById('tyharjul_edit').style.display = 'block';

        } else {
            document.getElementById('vharjul2_edit').style.display = 'none';
            document.getElementById('vharjul3_edit').style.display = 'none';
            document.getElementById('txharjul_edit').style.display = 'block';
            document.getElementById('tyharjul_edit').style.display = 'none';
        }
        return
    }
</script>