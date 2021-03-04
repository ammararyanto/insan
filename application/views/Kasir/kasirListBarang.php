<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Harga INSAN Advertising</h1>
                </div><!-- /.col -->

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->session->flashdata('message'); ?>
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
                                                    <th>No</th>
                                                    <th>ID Barang</th>
                                                    <th>Nama Barang </th>
                                                    <th>Satuan</th>

                                                    <th>Harga Jual 1</th>
                                                    <th>Harga Jual 2</th>
                                                    <th>Harga Jual 3</th>
                                                    <th>Stok</th>

                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 0;
                                            foreach ($barang as $b) {
                                                $no = $no + 1;
                                                $ts_create = strtotime($b['barang_tgl_create']);
                                                $dt_create = date('Y-m-d', $ts_create);
                                                $tgl_create = date_indo($dt_create);
                                                $jam_create = date('H:i', $ts_create);

                                                $ts_update = strtotime($b['barang_tgl_create']);
                                                $dt_update = date('Y-m-d', $ts_update);
                                                $tgl_update = date_indo($dt_update);
                                                $jam_update = date('H:i', $ts_update);

                                            ?>
                                                <tr>
                                                    <td> <?= $no ?></td>
                                                    <td> <?= $b['barang_id'] ?></td>
                                                    <td> <?= $b['barang_nama'] ?></td>
                                                    <td> <?= $b['sat_barang_nama'] ?></td>

                                                    <td> <?= $b['barang_harjul'] ?></td>
                                                    <td> <?= $b['barang_harjul2'] ?></td>
                                                    <td> <?= $b['barang_harjul3'] ?></td>
                                                    <td> <?= $b['barang_stok'] ?></td>



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

        <div class="modal fade" id="modal-tambah">

            <form action=<?= base_url('gudang/inputBarang') ?> method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data Barang Baru</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kabar">Kode Barang</label>
                                <input class="form-control form-control-sm" type="text" placeholder="kode" id="b_id" name="b_id" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="nabar">Nama Barang</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan nama barang / layanan -" id="b_nama" name="b_nama" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Jenis Satuan</label>
                                <select class='form-control form-control-sm' id='b_satuan' name='b_satuan' onchange="hide_harjul_input()">
                                    <option>Pilih Satuan Barang</option>
                                    <?php foreach ($satuan_barang as $sb) { ?>
                                        <option value="<?= $sb['sat_barang_id'] ?>"><?= $sb['sat_barang_nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Harga Pokok</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan harga pokok/beli barang -" id="b_harpok" name="b_harpok" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="satuan" id="txharjul" style="display: none;">Harga Jual</label>
                                <label for="satuan" id="tyharjul">Harga Jual 1 (1-50 Lembar)</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan harga penjualan barang untuk cetak 1-50 lembar -" id="b_harjul" name="b_harjul" autocomplete="off">
                            </div>

                            <div class="form-group" id="vharjul2">
                                <label for="satuan">Harga Jual 2 (51-100 Lembar)</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan harga penjualan barang untuk cetak 51-100 lembar - " id="b_harjul2" name="b_harjul2" autocomplete="off">
                            </div>
                            <div class="form-group" id="vharjul3">
                                <label for="satuan">Harga Jual 3 (> 100 Lemabr)</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan harga penjualan barang untuk cetak lebih dari 100 lembar -" id="b_harjul3" name="b_harjul3" autocomplete="off">
                            </div>

                            <div id="field_stok" class="form-group">
                                <label for="satuan">Stok Awal</label>
                                <input class="form-control form-control-sm" type="text" placeholder="- masukan stok awal barang -" id="b_stok" name="b_stok" autocomplete="off">
                            </div>
                            <div id="unl_stok" class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="b_unlimited" name="b_unlimited" value="1" onchange="hide_stok_input()">
                                <label class="custom-control-label" for="b_unlimited">Stok Unlimited</label>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </form>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-edit">

            <form action=<?= base_url('gudang/editBarang') ?> method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ubah Data Barang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="form-edit">

                        </div>
                        <!-- /.modal-content -->
                    </div>
            </form>
            <!-- /.modal-dialog -->
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
    function edit(id) {
        $('#modal-edit').modal('show');
        $('#form-edit').load("<?= base_url() ?>gudang/tampilDetailBarangEdit/" + id);
    }

    function tampil() {
        $('#modal-tambah').modal('show');
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