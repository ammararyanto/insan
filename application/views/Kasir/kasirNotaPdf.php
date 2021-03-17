<html>

<head>
    <title>Faktur Pembayaran</title>
    <style>
        #tabel {
            font-size: 20px;
            border-collapse: collapse;
        }

        #tabel td {
            padding-left: 5px;
            border: 1px solid black;
        }

        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
</head>

<body style='font-family:tahoma; font-size:12pt; margin-top:20pt'>
    <center>
        <table style='width:700px; font-size:12pt; font-family:calibri; border-collapse: collapse;' border='0'>

            <td width='70%' align='left' style='padding-right:80px; vertical-align:top;'>
                <img src="<?php echo base_url() . 'assets/kop_insan.png' ?>" alt="" height=80 width=360></img>
                <!-- <span style='font-size:20pt'><b>INSAN DIGITAL PRINTING</I></b></span> -->
                </br>
                Jl. Raya Bobotari Karanganyar Km 1 - Purbalingga </br>
                Telp : (Admin)0852 9078 2792 - 0813 1393 7345
            </td>
            <td style='vertical-align:top' width='30%' align='left'>
                <b><span style='font-size:20pt'>NOTA PENJUALAN</span></b></br>
                No Trans : <?= $transaksi['tr_id'] ?></br>
                Customer : <?= $transaksi['p_nama'] ?></br>
                No Telp : <?= $transaksi['p_nohp'] ?></br>
                Tanggal : <?= $tgl_today ?>
            </td>
        </table>
        <table style='width:700px; font-size:12pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
                Email : Insanoffset7@gmail.com</br>
                Facebook : Insan Offsett
            </td>
            <td style='vertical-align:top' width='30%' align='left'>

            </td>
        </table>
        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:10pt' border="0">

            <tr align='center' style="border: 1px solid black;">
                <td width='20%' style="border: 1px solid black;">Nama Layanan</td>
                <td width='30%' style="border: 1px solid black;">Nama File</td>
                <td width='10%' style="border: 1px solid black;">Ukuran</td>
                <td width='5%' style="border: 1px solid black;">Quantity</td>
                <td width='12%' style="border: 1px solid black;">Harga Satuan</td>
                <td width='12%' style="border: 1px solid black;">Sub Total</td>
            </tr>

            <?php
            $total = 0;
            foreach ($detail_transaksi as $dtr) {
                $total = $total + $dtr['dtr_total'];

                if ($dtr['sat_barang_id'] == 1) {
                    $ukuran = $dtr['dtr_panjang'] . 'x' . $dtr['dtr_lebar'];
                    $qty = $dtr['dtr_jumlah'];
                    $hrg_satuan = money($dtr['dtr_harga']);
                } else if ($dtr['sat_barang_id'] == 2) {
                    $ukuran = '-';
                    $qty = $dtr['dtr_jumlah'];
                    $hrg_satuan = money($dtr['dtr_harga']);
                } elseif ($dtr['sat_barang_id'] == 3) {
                    $ukuran = '-';
                    $qty = '-';
                    $hrg_satuan = '- ';
                } else {
                    $ukuran = $dtr['dtr_panjang'] . 'x' . $dtr['dtr_lebar'];
                    $qty = $dtr['dtr_jumlah'];
                    $hrg_satuan = '- ';
                }

                if ($dtr['dtr_nama_file']) {
                    $nama_file = $dtr['dtr_nama_file'];
                } else {
                    $nama_file = '-';
                }
            ?>
                <tr style="border: 1px solid black;">
                    <td style='text-align:left;border: 1px solid black;'><?= $dtr['barang_nama'] ?></td>
                    <td style='text-align:left;border: 1px solid black;'><?= $nama_file ?></td>
                    <td style='text-align:center;border: 1px solid black;'><?= $ukuran ?></td>
                    <td style='text-align:center;border: 1px solid black;'><?= $qty ?></td>
                    <td style='text-align:right;border: 1px solid black;'><?= $hrg_satuan ?></td>
                    <td style='text-align:right;border: 1px solid black;'><?= money($dtr['dtr_total'])  ?></td>
                </tr>
            <?php } ?>


            <?php
            if ($transaksi['tr_diskon_status'] == 0) {
                $diskon_fix = $transaksi['tr_diskon'];
            } else {
                $diskon_fix = $transaksi['tr_diskon'] * $transaksi['tr_total'] / 100;
            }

            $dpp_total = $transaksi['tr_total'] - $diskon_fix;
            $ppn_nom = $transaksi['tr_ppn'] * $dpp_total / 100;
            $g_total = $dpp_total + $ppn_nom;


            if ($transaksi['tr_status_pembayaran'] == 4) {
                $status_pembayaran = 'LUNAS';
            } else {
                $status_pembayaran = 'BELUM LUNAS';
            } ?>

            <tr style="border-bottom-width: thin; border: 1px solid black; background-color:black;">
                <td colspan="3"></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align:center;"> Penerima Order</td>
                <td style="text-align:center;" colspan="2"> Pemberi Order</td>
                <td colspan="2" style="border: 1px solid black; text-align:left">Total Rp</td>
                <td style="border: 1px solid black; text-align:right"><?= money($total) ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="border: 1px solid black; text-align:left">Diskon/Potongan Rp </td>
                <td style="border: 1px solid black; text-align:right"><?= money($diskon_fix) ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="border: 1px solid black; text-align:left">PPN <?= $transaksi['tr_ppn'] ?>% </td>
                <td style="border: 1px solid black; text-align:right"><?= money($ppn_nom) ?></td>
            </tr>
            <tr>
                <td style="text-align:center;"> (........................)</td>
                <td style="text-align:center;" colspan="2"> (........................)</td>
                <td colspan="2" style="border: 1px solid black;text-align:right;text-align:left;font-weight:bold">Total Keseluruhan Rp </td>
                <td style="border: 1px solid black; text-align:right;;font-weight:bold"><?= money($g_total) ?></td>
            </tr>
        </table>


        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:5pt;' border='0' hidden>
            <?php
            if ($transaksi['tr_diskon_status'] == 0) {
                $diskon_fix = $transaksi['tr_diskon'];
            } else {
                $diskon_fix = $transaksi['tr_diskon'] * $transaksi['tr_total'] / 100;
            }

            $g_total = $transaksi['tr_total'] - $diskon_fix;

            if ($transaksi['tr_status_pembayaran'] == 4) {
                $status_pembayaran = 'LUNAS';
            } else {
                $status_pembayaran = 'BELUM LUNAS';
            }


            ?>

            <tr>
                <td width='25%'></td>
                <td width='25%'></td>
                <td width='10%'></td>
                <td width='5%'></td>
                <td width='12%'></td>
                <td width='12%'></td>
            </tr>

            <tr>

                <td width='25%' style='text-align:center'>Penerima Order</td>
                <td width='25%' style='text-align:center'>Pemberi Order</td>
                <td colspan='3'>
                    <div style='text-align:right'>Total : </div>
                </td>
                <td style='text-align:right' width='15%'><?= money($total) ?></td>
            </tr>
            <tr>

                <td colspan='5'>
                    <div style='text-align:right'>Diskon / Potongan : </div>
                </td>
                <td style='text-align:right' width='15%'><?= money($diskon_fix)  ?></td>
            </tr>
            <tr>
                <td colspan='5'>
                    <div style='text-align:right;'>PPN : </div>
                </td>
                <td style='text-align:right;' width='15%'>34.500</td>
            </tr>
            <!-- <tr>
                <td colspan='5'>
                    <div style='text-align:right;font-weight:bold'>Total Keseluruhan : </div>
                </td>
                <td style='text-align:right;font-weight:bold' width='15%'><?= money($g_total)  ?></td>
            </tr> -->

            <tr>
                <td width='25%'></td>
                <td width='25%'></td>
                <td width='10%'></td>
                <td width='5%'></td>
                <td width='12%'></td>
                <td width='12%'></td>
            </tr>

            <!-- <tr style="margin-top:10pt;">
                <td colspan='5'>
                    <div style='text-align:right'>Terbayar : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($transaksi['tr_uang']) ?></td>
            </tr> -->
            <!-- <tr>

                <td colspan='5'>
                    <div style='text-align:right'>Kembalian : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($transaksi['tr_kembalian']) ?></td>
            </tr> -->
        </table>
        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:5pt;' border='0' hidden>

            <tr>
                <td width='25%'></td>
                <td width='25%'></td>
                <td width='10%'></td>
                <td width='5%'></td>
                <td width='12%'></td>
                <td width='12%'></td>
            </tr>
            <tr>
                <td width='25%' style='text-align:center'>(........................)</td>
                <td width='25%' style='text-align:center'>(........................)</td>
                <td colspan='3' style="border: 1px solid black;">
                    <div style='text-align:right;font-weight:bold'>Total Keseluruhan : </div>
                </td>
                <td style='text-align:right;font-weight:bold;border: 1px solid black;' width='15%'><?= rupiah($g_total)  ?></td>
            </tr>
        </table>


    </center>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>