<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Laporan Transaksi </h1>
                </div><!-- /.col -->

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <a href="<?= base_url('Laporan') ?>" class="btn btn-secondary mr-2 float-left"> <i class="fas fa-arrow-circle-left"></i> Kembali</a>
                    <input value="<?= $time1MonthBefore ?>" type="text" class="form-control" id="timeStart" placeholder="" hidden>
                    <input value="<?= $timeToday ?>" type="text" class="form-control" id="timeEnd" placeholder="" hidden>
                </div>
                <div class="col-md-12">
                    <?= $this->session->flashdata('message'); ?>
                    <!-- /.card -->
                    <div class="row">
                        <!-- <div class="col-lg-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Data Tidak Ditemukan
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="card">
                                <div class="card-header bg-info ui-sortable-handle">
                                    <!-- <button type="button" class="btn btn-warning" onclick="tampil()">
                                        Tambah Barang
                                    </button> -->
                                    <h6 class="m-0 font-weight-bold ">
                                        <span class="breadcrumb-item">Daftar Transaksi</span>

                                        </span>
                                    </h6>


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-lg-2 col-12">
                                            <div class="form-group">
                                                <label>Pilih Status Pembayaran</label>
                                                <select class='form-control' id='s_bayar' name='s_bayar'">
                                                    <option value='4'>Lunas</option>
                                                    <!-- <option value='3'>Hutang</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class=" col-lg-8 col-12 ">
                                            <a href=" #" class="btn btn-primary float-left mt-3 mr-2" onclick="pembelianHariIni()"> <i class="fas fa-calendar-day"></i> Hari Ini</a>
                                                    <a href="#" class="btn btn-primary float-left mt-3 mr-2" onclick="pembelianBulanIni()"> <i class="fas fa-calendar-alt"></i> 1 Bulan Kebelakang</a>
                                                    <a href="#" class="btn btn-primary float-left mt-3 mr-2" onclick="tampilFormWaktu()"> <i class="fas fa-calendar"></i> Waktu Custom</a>
                                                    <a href="#" class="btn btn-success float-left mt-3 mr-2" onclick="viewModalExcel()"> <i class="fas fa-file-excel"></i> Download</a>
                                            </div>
                                        </div>
                                        <div class="row" id="view_tabel">

                                        </div>


                                        <div class="modal fade" id="modal-waktu">

                                            <form action="#" method="POST">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Tambah Data Pengeluaran</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="nabar">Tanggal Awal</label>
                                                                        <input class="form-control form-control-sm" type="date" placeholder="" id="tgl_awal" name="tgl_awal" autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="nabar">Tanggal Akhir</label>
                                                                        <input class="form-control form-control-sm" type="date" placeholder="" id="tgl_akhir" name="tgl_akhir" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>




                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                            <a href="#" class="btn btn-primary float-right mr-2" onclick="pembelianCustom()"> Submit</a>

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
    </section>
    <!-- /.content -->
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



            </div>
            <!-- /.modal-content -->
        </div>

        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="modal-excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Silahkan Pilih Tipe Laporan Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-success float-left mt-3 mr-2" onclick="printExcel()"> <i class="fas fa-file-excel"></i> Laporan Transaksi (Simple)</a>
                <a href="#" class="btn btn-success float-left mt-3 mr-2" onclick="printExcelDetail()"> <i class="fas fa-file-excel"></i> Laporan Transaksi (Detail)</a>

            </div>
        </div>
    </div>
</div>

<footer class=" main-footer">
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
</script>
<script>
    function viewListPembelian(time1, time2, s_bayar) {
        $('#view_tabel').html('<tr><td colspan="4"> <center>Sedang memuat data...  <i class="fas fa-hourglass-start fa-spin"></i></center></td></tr>');
        $('#view_tabel').load("<?= base_url() ?>Laporan/tampilDataTransaksi/" + time1 + "/" + time2 + "/" + s_bayar);
        // alert('jjj ' + s_bayar);
    }

    function tampilFormWaktu() {
        $('#modal-waktu').modal('show');
    }

    function pembelianHariIni() {
        var time1 = "<?= $timeToday ?>";
        var time2 = "<?= $timeToday ?>";
        var s_bayar = document.getElementById('s_bayar').value;
        $('#timeStart').val(time1);
        $('#timeEnd').val(time2);
        viewListPembelian(time1, time2, s_bayar);
    }

    function pembelianBulanIni() {
        var time1 = "<?= $time1MonthBefore  ?>";
        var time2 = "<?= $timeToday ?>";
        var s_bayar = document.getElementById('s_bayar').value;

        $('#timeStart').val(time1);
        $('#timeEnd').val(time2);
        // var s_bayar = "4";

        // alert(s_bayar);
        viewListPembelian(time1, time2, s_bayar);
    }

    function pembelianCustom() {
        var time1 = document.getElementById('tgl_awal').value;
        var time2 = document.getElementById('tgl_akhir').value;
        var s_bayar = document.getElementById('s_bayar').value;

        $('#timeStart').val(time1);
        $('#timeEnd').val(time2);
        $('#modal-waktu').modal('hide');
        viewListPembelian(time1, time2, s_bayar);
    }

    function viewDetail(id) {
        $('#modal-detail').modal('show');
        // alert(id);
        $('#form-detail').load("<?= base_url() ?>kasir/tampilDetailTransaksi/" + id);
    }

    function printExcel() {
        var time1 = document.getElementById('timeStart').value;
        var time2 = document.getElementById('timeEnd').value;

        // window.load('<?= base_url() ?>admin/gudang/excelBarangKeluar/' + time1 + '/' + time2, '_blank');
        window.location.href = "<?= base_url() ?>laporan/excelTransaksi/" + time1 + '/' + time2;
    }

    function printExcelDetail() {
        var time1 = document.getElementById('timeStart').value;
        var time2 = document.getElementById('timeEnd').value;

        // window.load('<?= base_url() ?>admin/gudang/excelBarangKeluar/' + time1 + '/' + time2, '_blank');
        window.location.href = "<?= base_url() ?>laporan/excelTransaksiDetail/" + time1 + '/' + time2;
    }

    function viewModalExcel(id) {
        $('#modal-excel').modal('show');
    }
</script>