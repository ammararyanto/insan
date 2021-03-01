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
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.Barang</th>
                                                <th>Nama</th>
                                                <th>Satuan</th>
                                                <th>Jumlah</th>
                                                <th>Kategori</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <?php
foreach($barang as $b){
    ?>
                                        <tr>
                                            <td><?=$b->barang_id?></td>
                                            <td><?=$b->barang_nama?></td>
                                            <td><?=$b->barang_satuan?></td>
                                            <td><?=$b->barang_stok?></td>
                                            <td><?=$b->kategori_nama?></td>
                                            <td><button onclick="edit('<?=$b->barang_id?>')" type="button"
                                                    class="btn btn-dangers btn-xs"><span
                                                        class="fas fa-file"></span></button><button onclick="alert('Hapus Hubungi Admin')" type="button"
                                                    class="btn btn-dangers btn-xs"><span
                                                        class="fas fa-trash"></span></button></td>
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
        <div class="modal fade" id="editbarang">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Barang </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="fetched-data"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="modal-default">
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
                            <input class="form-control form-control-sm" type="text" placeholder="kode" id="kabar"
                                name="kabar" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nabar">Nama Barang</label>
                            <input class="form-control form-control-sm" type="text" placeholder="nama" id="nabar"
                                name="nabar" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Nama Satuan</label>
                            <input class="form-control form-control-sm" type="text" placeholder="ssatuan" id="satuan"
                                name="satuan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Harga Pokok</label>
                            <input class="form-control form-control-sm" type="text" placeholder="Harga Pokok"
                                id="satuan" name="satuan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Harga Jual</label>
                            <input class="form-control form-control-sm" type="text" placeholder="Harga Jual" id="satuan"
                                name="satuan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Nama Barang</label>
                            <input class="form-control form-control-sm" type="text" placeholder="Harga Grosir"
                                id="satuan" name="satuan" autocomplete="off">
                        </div>
                        <div class='form-group'>
                            <label>Kategori</label>
                            <select class='form-control form-control-sm' id='katgori' name='katgori'>
                                <option>Pilih Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
    <!-- /.content -->
</div>

<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="#">Laziz</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?php echo date('M');?>
    </div>
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/moment.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
    });
});
</script>
<script>
function edit(id) {
    //alert(id);
    Swal.fire('Loading');
    Swal.showLoading();
    $.ajax({
        type: 'post',
        url: 'GetDetailBarang',
        data: {
            id: id
        },
        success: function(konsol) {
            swal.close();
            $('#editbarang').modal('show');
            $('.fetched-data').html(konsol); ///menampilkan data ke dalam modal
        }
    });
}

function tampil() {
    $('#modal-default').modal('show');
}
</script>