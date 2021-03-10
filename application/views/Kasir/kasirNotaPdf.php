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
            <td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
                <span style='font-size:20pt'><b>INSAN DIGITAL PRINTING</I></b></span></br>
                Jl. Raya Bobotari Karanganyar Km 1 - Purbalingga </br>
                Telp : 0852 2745 4529 - 0813 1393 7345
            </td>
            <td style='vertical-align:top' width='30%' align='left'>
                <b><span style='font-size:20pt'>NOTA PENJUALAN</span></b></br>
                No Trans : <?= $transaksi['tr_id'] ?></br>
                Customer : <?= $transaksi['p_nama'] ?></br>
            </td>
        </table>
        <table style='width:700px; font-size:12pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
                Email : Insanoffset7@gmail.com</br>
                Facebook : Insan Offsett
            </td>
            <td style='vertical-align:top' width='30%' align='left'>
                No Telp : <?= $transaksi['p_nohp'] ?>
            </td>
        </table>
        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:10pt' border='1'>

            <tr align='center'>
                <td width='50%'>Nama Barang / Layanan</td>
                <td width='10%'>Ukuran</td>
                <td width='5%'>Quantity</td>
                <td width='12%'>Harga Satuan</td>
                <td width='12%'>Sub Total</td>
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
            ?>
                <tr>
                    <td style='text-align:left'><?= $dtr['barang_nama'] ?></td>
                    <td style='text-align:center'><?= $ukuran ?></td>
                    <td style='text-align:center'><?= $qty ?></td>
                    <td style='text-align:right'><?= $hrg_satuan ?></td>
                    <td style='text-align:right'><?= money($dtr['dtr_total'])  ?></td>
                </tr>
            <?php } ?>
            <?php ?>
        </table>


        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:5pt;' border='0'>
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
            } ?>



            <tr>
                <td width='25%'></td>
                <td width='25%'></td>
                <td width='10%'></td>
                <td width='5%'></td>
                <td width='12%'></td>
                <td width='12%'></td>
            </tr>

            <tr>


                <td colspan='5'>
                    <div style='text-align:right'>Total : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($total) ?></td>
            </tr>
            <tr>
                <td width='25%' style='text-align:center'>Penerima Order</td>
                <td width='25%' style='text-align:center'>Pemberi Order</td>
                <td colspan='3'>
                    <div style='text-align:right'>Diskon / Potongan : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($diskon_fix)  ?></td>
            </tr>
            <tr>
                <td colspan='5'>
                    <div style='text-align:right'>Total Keseluruhan : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($g_total)  ?></td>
            </tr>

            <tr>
                <td width='25%'></td>
                <td width='25%'></td>
                <td width='10%'></td>
                <td width='5%'></td>
                <td width='12%'></td>
                <td width='12%'></td>
            </tr>

            <tr style="margin-top:10pt;">
                <td colspan='5'>
                    <div style='text-align:right'>Terbayar : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($transaksi['tr_uang']) ?></td>
            </tr>
            <tr>

                <td colspan='5'>
                    <div style='text-align:right'>Kembalian : </div>
                </td>
                <td style='text-align:right' width='15%'><?= rupiah($transaksi['tr_kembalian']) ?></td>
            </tr>
        </table>
        <table cellspacing='0' style='width:700px; font-size:12pt; font-family:calibri;  border-collapse: collapse; margin-top:5pt;' border='0'>

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
                <td colspan='3'>
                    <div style='text-align:right'>Status Transaksi </div>
                </td>
                <td style='text-align:right; font-weight:bold' width='15%'><?= $status_pembayaran ?></td>
            </tr>
        </table>


    </center>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>