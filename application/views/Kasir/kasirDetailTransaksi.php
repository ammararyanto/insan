<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Input Penjualan</h1>
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
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary mb-3" onclick="tampilModal()">
                                <i class="fas fa-plus"> </i> Tambah Produk atau Layanan
                            </button>
                        </div>
                    </div>



                    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:700px; ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Silahkan pilih Produk atau Layanan dibawah ini</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Satuan</th>
                                                        <th style="width:20%">Harga</th>
                                                        <th style="width:10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $nmbr = 0;
                                                foreach ($barang as $brg) {
                                                    $nmbr =  $nmbr + 1; ?>
                                                    <tr>
                                                        <td><?= $brg['barang_nama'] ?></td>
                                                        <td><?= $brg['sat_barang_nama'] ?></td>
                                                        <td><?= $brg['barang_harjul'] ?></td>
                                                        <td><button type="button" onclick="tambahKeranjang(<?= $nmbr ?>)" class="ml-3 btn btn-sm btn-primary btn_add<?= $nmbr ?>" name="btn_add" data-barangid="<?= $brg['barang_id'] ?>" data-barangnm="<?= $brg['barang_nama'] ?>"><i class="fas fa-fw fa-plus"></i> </button></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pelanggan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="callout callout-info py-1">
                                                <p class="mb-1">Total Biaya </p>
                                                <h5 id="display_total" class="mb-1 font-weight-bold"><?= money($total_harga) ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nama Pelanggan</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="<?= $transaksi['p_nama'] ?>" placeholder="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
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
                        <div class="col-lg-9 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Detail Pembelian</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-lg-12" id="cart_col">
                                                    <!-- Isi Keranjang  -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <form action="<?= base_url() ?>kasir/actionUbahDetailTransaksi/<?= $transaksi['tr_id'] ?>" method="POST">
                                        <input type="text font-weight-bold" class="form-control" id="tr_total_harga" name="tr_total_harga" value="<?= $transaksi['tr_total'] ?>" hidden>

                                        <input type="submit" value="Submit Perubahan" class="ml-3 btn btn-success float-right">
                                        <a href="<?= base_url('kasir/ubahPembayaran/' . $transaksi_id) ?>" class="btn btn-secondary float-right">Batal</a>

                                    </form>
                                </div>
                            </div>

                        </div>

                        <!-- <div class="col-lg-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Pembayaran</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    </div>
                                    <div class="row align-items-end" hidden>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="diskon">Diskon</label>
                                                <input type="text" class="form-control diskon" id="diskon" name="diskon" value="" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div class="form-inline ml-0 mb-4">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="nominal" name="discnom" value="0" class="custom-control-input discnom">
                                                    <label class="custom-control-label" for="nominal">Rp</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-3">
                                                    <input type="radio" id="prosentase" name="discnom" value="1" class="custom-control-input discnom" checked>
                                                    <label class="custom-control-label" for="prosentase">%</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label-sm" for="nama">Nominal Tunai</label>
                                                <input type="text font-weight-bold" class="form-control uang_cash" id="uang_cash" name="uang_cash" value="" placeholder="0">
                                                <small class="text-danger"><?= form_error('uang_cash') ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                    </div>

                                </div>
                            </div>
                        </div> -->
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
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/jquery.price_format.min.js'; ?>"></script>

<script>
    $('#cart_col').load("<?php echo base_url() ?>kasir/tampilIsiKeranjang/<?= $transaksi_id ?>");


    $(function() {
        $('.xoxo').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.',
        });
    });

    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>

<script>
    function tambahKeranjang(nmbr) {
        var barang_id = $('.btn_add' + nmbr).data("barangid");
        var barang_nama = $('.btn_add' + nmbr).data("barangnm");
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $.ajax({
            url: "<?= base_url(); ?>kasir/insertDetailTransaksi/<?= $transaksi_id ?>",
            method: "POST",
            data: {
                barang_id: barang_id,
            },
            success: function(data) {
                // alert("Produk ditambahkan");
                Toast.fire({
                    icon: 'success',
                    title: barang_nama + ' berhasil ditambahkan'
                })
                $('#cart_col').html(data);
                loadKeranjang();
                totalharga();
            }
        });

    }

    function hapusKeranjang(nmbr) {
        var det_id = $('.btn_del' + nmbr).data("detid");
        var det_nama = $('.btn_del' + nmbr).data("detnama");
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if (confirm("Yakin akan menghapus " + det_nama + " dari keranjang ?")) {
            $.ajax({
                url: "<?= base_url(); ?>kasir/hapusDetailTransaksi/<?= $transaksi_id ?>",
                method: "POST",
                data: {
                    det_id: det_id,
                },
                success: function(data) {
                    // alert(det_nama + " Dihapus Dari Keranjang ");
                    loadKeranjang();
                    totalharga();
                    Toast.fire({
                        icon: 'warning',
                        title: det_nama + ' Dihapus dari keranjang'
                    })
                    // totalharga();

                }
            });
        } else {
            return false;
        }

    }

    function loadKeranjang() {
        $('#cart_col').load("<?php echo base_url() ?>kasir/tampilIsiKeranjang/<?= $transaksi_id ?>");

    }
</script>


<script>
    function updateNama(urutan) {
        var $rows = $('#row' + urutan);
        var $nama_file = ($rows).find('#dtr_nama').val();
        var $dtr_id = parseInt($($rows).find('#dtr_id').val());


        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // alert('halo' + $nama_file);
        $.ajax({
            url: "<?= base_url(); ?>kasir/updateNamaFileKeranjang/" + $dtr_id,
            method: "POST",
            data: {
                dtr_nama: $nama_file,
            },
            success: function(data) {

                Toast.fire({
                    icon: 'success',
                    title: 'Nama File Berhasil Diubah'
                })

                $($rows).find('#dtr_nama').val(data);

            }
        });

    }

    function sum(urutan) {
        var $rows = $('#row' + urutan);
        // alert('Hore berhasill');
        var $dtr_id = parseInt($($rows).find('#dtr_id').val());
        var $panjang = parseInt($($rows).find('#dtr_panjang').val());
        var $lebar = parseInt($($rows).find('#dtr_lebar').val());
        var $jumlah = parseInt($($rows).find('#dtr_jumlah').val());
        var $harga = ($rows).find('#dtr_harga').val();
        var $satuan = ($rows).find('#dtr_satuan').val();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });


        $.ajax({
            url: "<?= base_url(); ?>kasir/updateDataKeranjang/" + $dtr_id,
            method: "POST",
            data: {
                dtr_panjang: $panjang,
                dtr_lebar: $lebar,
                dtr_jumlah: $jumlah,
                dtr_harga: $harga,
            },
            success: function(data) {
                var $harjul = data;
                // alert($harjul);

                if ($satuan == 4) {
                    var $subtot = $harjul;
                } else {
                    var $subtot = $panjang * $lebar * $jumlah * $harjul / 10000;
                }
                // alert($harjul);
                if (!isNaN($subtot)) {
                    // $($rows).find('#vdtr_harga').html($harjul);
                    $($rows).find('#vdtr_total').html($subtot);
                    $($rows).find('#vdtr_total').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.',
                    });

                    $($rows).find('#dtr_harga').val($harjul);
                    $($rows).find('#dtr_total').val($subtot);
                    $($rows).find('#dtr_harga').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.',
                    });

                    // var total=$subtot;  	
                    totalharga();
                } else {
                    // $($rows).find('#vdtr_harga').html($harjul);
                    $($rows).find('#vdtr_total').html($subtot);
                    $($rows).find('#vdtr_total').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.',
                    });

                    $($rows).find('#dtr_harga').val($harjul);
                    $($rows).find('#dtr_total').val($subtot);
                    $($rows).find('#dtr_harga').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.',
                    });
                    //var total='0';  	
                    totalharga();
                }

                Toast.fire({
                    icon: 'success',
                    title: 'Pengubahan Data Berhasil'
                })
            }
        });
    };

    function totalharga() {
        var sum = 0;
        var ct = 0;
        $(".records").each(function() {
            var $jumlah = $(this).find('#dtr_total').val();
            sum += parseInt($jumlah);
        });

        var number_string = sum.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        $("#display_total").html(rupiah);
        $('#tr_total_harga').val(sum);
        // $('#hoho').val(sum);
    };

    function tampilModal() {
        $('#modal-default').modal('show');
    }
</script>