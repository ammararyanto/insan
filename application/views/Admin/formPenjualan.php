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
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Silahkan cari barang disini</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg searchTeknisi" id="searchBarang" placeholder="misal : indomie ">
                                        <!-- <input type="text" name="searchTeknisi" id="searchTeknisi" class="form-control bg-light border-0 small searchTeknisi" placeholder="Cari..." aria-label="Cari" aria-describedby="basic-addon2"> -->

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 ">
                                    <!-- Untuk menampilkan data barang yang dicari -->
                                    <div class="row mt-4">
                                        <div class="col-md-12 overflow-auto" style="max-height: 450px; min-height : 20px ;">
                                            <div class="row" id="resultBarang">


                                            </div>
                                            <div class="row">
                                                <div class="card-body">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Barang</th>
                                                                <th style="width:20%">Harga</th>
                                                                <th style="width:10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <td>Klem</td>
                                                            <td>10000</td>
                                                            <td><button type="button" onclick="tambahKerajang(' . $nmbr . ')" class="ml-3 btn btn-sm btn-primary btn_add' . $nmbr . '" name="btn_add" data-barangnama="' . $row->barang_nama . '" data-barangharga="' . $row->barang_harjul . '" data-barangid="' . $row->barang_id . '"><i class="fas fa-fw fa-plus"></i> </button></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Untuk menampilkan apabila barang tidak ditemukan -->


                                    </div>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="<?= base_url('admin/Penjualan') ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <input id="nomor" type="text" value="0" hidden>
                                <input id="total" type="text" value="0" hidden>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Detail Pembelian</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="virtual_cart">

                                            </div>
                                            <div class="col-lg-12" id="info_cartKosong">
                                                <div class="alert alert-default border border-warning" role="alert">
                                                    <b>Informasi!</b> Belum ada pembelian ditambahkan
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="tb_Detail" style="display:none">
                                                <table class="table" id="cartTable">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th style=" width: 10px">#</th> -->
                                                            <th>Item</th>
                                                            <th>Qty</th>
                                                            <th>Harga Satuan</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbKeranjang">


                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Pembayaran</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-info py-1">
                                                    <p class="mb-1">Total Biaya </p>
                                                    <h5 id="display_total" class="mb-1 font-weight-bold">0</h5>
                                                </div>
                                            </div>


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
                                            <div class="col-lg-12">
                                                <input type="submit" value="Proses Pembayaran" class="ml-3 btn btn-success float-right">
                                                <a href="<?= base_url('admin') ?>" class="btn btn-secondary float-right">Batal</a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>




                <div class="col-lg-6 col-sm-12" hidden>
                    <?= $this->session->flashdata('message'); ?>
                    <!-- /.card -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="card">
                                <div class="card-header bg-blue ui-sortable-handle">
                                    <a class="btn btn-warning btn-sm" href="TambahBarang">Tambahkan</a>
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
                                                <th>No.Barang</th>
                                                <th>Nama</th>
                                                <th>Jumlah</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>

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
    $(this).ready(function() {
        load_data();

        function load_data(query) {
            $.ajax({
                url: "<?= base_url() ?>admin/fetch",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#resultBarang').html(data);
                }
            })
        }

        $('.searchTeknisi').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        })
    });

    $(function() {
        $("#example1").DataTable({
            "responsive": true,
        });
    });
</script>

<script>
    function tambahKerajang(nmbr) {
        var barang_id = $('.btn_add' + nmbr).data("barangid");
        var barang_nama = $('.btn_add' + nmbr).data("barangnama");
        var barang_harga = $('.btn_add' + nmbr).data("barangharga");
        // var barang_qty = $('#' + barang_id).val();
        var barang_qty = 1;
        var barang_total = barang_harga * barang_qty;
        var nomor = document.getElementById('nomor').value;
        var urutan = parseInt(nomor) + 1;
        var total = document.getElementById('total').value;
        var harga_total = parseInt(total) + parseInt(barang_total);

        alert(barang_qty + " pcs " + barang_nama + " Berhasil ditambahkan");

        $('#tbKeranjang').append(
            '<tr class="records" id="row' + urutan + '"> <td class="pt-3">' + barang_nama + ' <input name="barang_id[]" type = "text" value = "' + barang_id + '" hidden></td>' +
            '<td style="width:15%"> <input class=" form-control form-control-sm" onkeyup="sum(' + urutan + ')" onchange="sum(' + urutan + ')" name="barang_qty[]" id="barang_qty" style="text-align: center;" type = "number" value = "' + barang_qty + '"> </td>' +
            '<td class="pt-3">' + barang_harga + ' <input name="barang_harga[]" id="barang_harga" type = "text" value = "' + barang_harga + '" hidden> <input name="barang_total[]" id="barang_total"type = "text" value = "' + barang_total + '" hidden> </td>' +
            '<td class="pt-3" id="total' + urutan + '">' + barang_total + '</td>' +
            '<td> <a href="#" onclick="deleteRow(this)" class="badge badge-danger">Hapus</a> </td> </tr>'
        )

        $('#nomor').val(urutan);
        $('#total').val(harga_total);
        totalharga();

        document.getElementById('tb_Detail').style.display = 'block';
        document.getElementById('info_cartKosong').style.display = 'none';


    }

    function deleteRow(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("cartTable").deleteRow(i);
    }

    function sum(urutan) {
        var $rows = $('#row' + urutan);
        var $qty = parseInt($($rows).find('#barang_qty').val());
        var $harga = parseInt($($rows).find('#barang_harga').val());
        var $subtot = $qty * $harga;

        if (!isNaN($subtot)) {
            $($rows).find('#barang_total').val($subtot);
            $('#total' + urutan).html($subtot);

            // var total=$subtot;  	
            totalharga();
        } else {
            $($rows).find('#barang_total').val('0');
            $('#total' + urutan).html($subtot);

            //var total='0';  	
            totalharga();
        }
    };

    function sumChange(urutan) {
        var $rows = $('#row' + urutan);
        var $qty = parseInt($($rows).find('#barang_qty').val());
        var $harga = parseInt($($rows).find('#barang_harga').val());
        var $subtot = $qty * $harga;

        if (!isNaN($subtot)) {
            $($rows).find('#barang_total').val($subtot);
            // var total=$subtot;  	
            totalharga();
        } else {
            $($rows).find('#barang_total').val('0');
            //var total='0';  	
            totalharga();
        }
    }

    function totalharga() {
        var sum = 0;
        var ct = 0;
        $(".records").each(function() {
            var $jumlah = $(this).find('#barang_total').val();
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

        // $('#totals').val(rupiah);
        // $('#hoho').val(sum);
    };
</script>