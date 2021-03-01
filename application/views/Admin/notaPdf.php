<h4>
    <center>Nama Toko</center>
</h4>
<p style="margin-bottom: 0pt;margin-top: 0pt;">==================================</p>
<table border="0" width="100%">
    <tr>
        <td style="width: 50%; text-align:left;">Kasir</td>
        <td style="width: 50%; text-align:right;"><?= $transaksi['user_nama'] ?></td>
    </tr>
    <tr>
        <td style="width: 50%; text-align:left;">Waktu</td>
        <td style="width: 50%; text-align:right;"><?= $tgl_transaksi ?></td>
    </tr>
    <tr>
        <td style="width: 50%; text-align:left;">No. Struk</td>
        <td style="width: 50%; text-align:right;"><?= $transaksi['jual_nofak'] ?></td>
    </tr>
</table>
<p style="margin-bottom: 0pt;margin-top: 0pt;">==================================</p>
<table border="0" width="100%">
    <?php foreach ($d_transaksi as $dt) {
    ?>
        <tr>
            <td style="width: 50%; text-align:left;"><?= $dt['d_jual_barang_nama'] ?></td>
            <td style="width: 10%; text-align:right;"><?= $dt['d_jual_qty'] ?></td>
            <td style="width: 20%; text-align:right;"><?= money($dt['d_jual_barang_harjul']) ?></td>
            <td style="width: 20%; text-align:right;"><?= money($dt['d_jual_total']) ?></td>
        </tr>

    <?php } ?>
</table>
<p style="margin-bottom: 0pt;margin-top: 1pt;">----------------------------------------------------------</p>
<table border="0" width="100%">
    <tr>
        <td style="width: 50%; text-align:left;">Total</td>
        <td style="width: 50%; text-align:right;"><?= money($transaksi['jual_total'])  ?></td>
    </tr>
    <tr>
        <td style="width: 50%; text-align:left;">Tunai</td>
        <td style="width: 50%; text-align:right;"><?= money($transaksi['jual_jml_uang'])  ?></td>
    </tr>
    <tr>
        <td style="width: 50%; text-align:left;">Kembalian</td>
        <td style="width: 50%; text-align:right;"><?= money($transaksi['jual_kembalian'])  ?></td>
    </tr>
</table>
<p style="margin-bottom: 0pt;margin-top: 0pt;">==================================</p>
<table border="0" width="100%">
    <tr>
        <td style="width: 100%; text-align:center;">Terima kasih atas kunjungan anda</td>
    </tr>
    <tr>
        <td style="width: 100%; text-align:center;  margin-top: 0pt;">Periksa barang sebelum dibeli</td>
    </tr>
    <tr>
        <td style="width: 100%; text-align:center;">Barang yang sudah dibeli tidak bisa ditukar atau dikembalikan</td>
    </tr>
    <tr>
        <td style="width: 100%; text-align:center;">Kritik & Saran - 089646773772</td>
    </tr>
</table>