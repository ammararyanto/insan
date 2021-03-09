<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Pembelian Barang </h1>
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
                                    <button type="button" class="btn btn-warning mb-3" onclick="tampilFormTambah()">
                                        <i class="fas fa-plus"> </i> Input Barang Masuk
                                    </button>

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
                                    <div class="overflow-auto" style="overflow-x:auto;">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah </th>
                                                    <th>Satuan</th>
                                                    <th class="text-right">Biaya</th>
                                                    <th class="text-center">Action</th>


                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 0;
                                            foreach ($barang as $b) {
                                                $no = $no + 1;
                                                $ts_create = strtotime($b['bm_tanggal_masuk']);
                                                $dt_create = date('Y-m-d', $ts_create);
                                                $tgl_create = date_indo($dt_create);
                                                $jam_create = date('H:i', $ts_create);

                                                $ymdNow = date('Y-m-d', time());
                                                if ($dt_create == $ymdNow) {
                                                    $action_hidden = '';
                                                } else {
                                                    $action_hidden = ' hidden';
                                                }
                                            ?>
                                                <tr>
                                                    <td> <?= $no ?></td>
                                                    <td> <?= $tgl_create ?></td>
                                                    <td> <?= $b['bm_nama'] ?></td>
                                                    <td> <?= $b['bm_jumlah'] ?></td>
                                                    <td> <?= $b['bm_satuan'] ?></td>
                                                    <td class="text-right"> <?= money($b['bm_biaya'])  ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example" <?= $action_hidden ?>>
                                                            <a onclick="tampilFormEdit('<?= $b['bm_id'] ?>')" class="btn btn-secondary btn-sm" href="#" data-toggle="tooltip" title="Bayar"><i class="fas fa-edit"></i></i></a>
                                                            <a class="btn btn-secondary btn-sm konfirmasi-hapus" href="<?= base_url() ?>/Gudang/hapusBarangMasuk/<?= $b['bm_id'] ?>" data-toggle="tooltip" id="" title="Bayar"><i class="fas fa-trash"></i></i></a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    </div>

                                    <div class="modal fade" id="modal-tambah">

                                        <form action=<?= base_url('gudang/inputBarangMasuk') ?> method="POST">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data Barang Baru</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="nabar">Nama Barang</label>
                                                                    <input class="form-control form-control-sm" type="text" placeholder="- masukan nama barang / layanan -" id="ms_nama" name="ms_nama" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label for="satuan">Jumlah / Quantity </label>
                                                                    <input class="form-control form-control-sm" type="text" placeholder="- masukan Quantity -" id="ms_jumlah" name="ms_jumlah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-6">
                                                                <div class="form-group">
                                                                    <label>Jenis Satuan Pembelian</label>
                                                                    <select class='form-control form-control-sm' id='ms_satuan' name='ms_satuan' onchange="hide_harjul_input()">
                                                                        <option>Pilih Satuan Barang</option>
                                                                        <?php foreach ($jenis_satuan as $js) { ?>
                                                                            <option value="<?= $js['js_nama'] ?>"><?= $js['js_nama'] ?></option>
                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-12">
                                                                <div class="form-group" id="vharjul2">
                                                                    <label for="satuan">Biaya</label>
                                                                    <input class="form-control form-control-sm" type="text" placeholder="- masukan biaya pembelian barang - " id="ms_biaya" name="ms_biaya" autocomplete="off">
                                                                </div>
                                                            </div>
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

        <div class="modal fade" id="modal-ubah">

            <form action=<?= base_url('gudang/ubahBarangMasuk') ?> method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ubah Data Barang Masuk</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="form-ubah">

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

        <div class="modal fade" id="modal-hapus">

            <form action=<?= base_url('gudang/editBarang') ?> method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
<script type="text/javascript" src="<?php echo base_url() . 'assets/jquery.price_format.min.js' ?>"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>


<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });

    $(function() {
        $('#ms_biaya').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });
</script>
<script>
    function tampilFormEdit(id) {
        $('#modal-ubah').modal('show');

        $('#form-ubah').load("<?= base_url() ?>gudang/tampilDetailBarangMasuk/" + id);
        $("#vnama-fitur").html('Awewe');
        $("#vnama-stok").html('Olala');
    }

    function tampilFormTambah() {
        $('#modal-tambah').modal('show');
    }

    function konfirmasiHapus() {
        $('#modal-hapus').modal('show');
    }

    $('.konfirmasi-hapus').on('click', function(e) {
        // alert('terpencet');
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    });
</script>

<script>
    $(function() {
        $('#ms_biaya_e').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });
</script>