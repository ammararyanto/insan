<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Barang</h1>
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
                                    <button type="button" class="btn btn-warning" onclick="tampil()">
                                        Tambah Barang
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
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Satuan</th>
                                                <th>Harga Pokok</th>
                                                <th>Harga Jual</th>
                                                <th>Stok</th>
                                                <th>Tanggal Input</th>
                                                <th>Terakhir Update</th>
                                                <th>Penginput</th>
                                                <th>Action</th>
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
                                                <td> <?= $b['barang_harpok'] ?></td>
                                                <td> <?= $b['barang_harjul'] ?></td>
                                                <td> <?= $b['barang_stok'] ?></td>
                                                <td> <?= $tgl_create . ' ' . $jam_create ?></td>
                                                <td> <?= $tgl_update . ' ' . $jam_update ?></td>
                                                <td> <?= $b['user_nama'] ?></td>
                                                <td><button onclick="edit('<?= $b['barang_id'] ?>')" type="button" class="btn btn-dangers btn-xs"><span class="fas fa-file"></span></button><button onclick="alert('Hapus Hubungi Admin')" type="button" class="btn btn-dangers btn-xs"><span class="fas fa-trash"></span></button></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
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
                            <h4 class="modal-title">Default Modal</h4>
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
                                <input class="form-control form-control-sm" type="text" placeholder="nama" id="b_nama" name="b_nama" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Jenis Satuan</label>
                                <select class='form-control form-control-sm' id='b_satuan' name='b_satuan'>
                                    <option>Pilih Kategori</option>
                                    <?php foreach ($satuan_barang as $sb) { ?>
                                        <option value="<?= $sb['sat_barang_id'] ?>"><?= $sb['sat_barang_nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Harga Pokok</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Harga Pokok" id="b_harpok" name="b_harpok" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="satuan">Harga Jual</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Harga Jual" id="b_harjul" name="b_harjul" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="satuan">Stok Awal</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Harga Grosir" id="b_stok" name="b_stok" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                            <h4 class="modal-title">Default Modal</h4>
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
    function editx(id) {
        //alert(id);
        $('#modal-edit').modal('show');
        Swal.fire('Loading');
        Swal.showLoading();
        $.ajax({
            type: 'post',
            url: "gudang/viewDetailBarang",
            data: {
                id: id
            },
            success: function(konsol) {
                swal.close();
                alert(id);
                $('#editbarang').modal('show');
                $('.fetched-data').html(konsol); ///menampilkan data ke dalam modal
            }
        });
    }

    function edit(id) {
        alert('berhasil boyy');
        $('#modal-edit').modal('show');
        $('#form-edit').load("<?= base_url() ?>gudang/tampilDetailBarangEdit/" + id);

    }

    function tampil() {
        $('#modal-tambah').modal('show');
    }
</script>