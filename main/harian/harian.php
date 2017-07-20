<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading text-center">Laporan Transaksi Harian</div>
    <div class="panel-body text-center">
        <form action="print/laporanharian.php" method="get" target="_blank" class="form-inline"></form>

        <div class="form-inline">
            <div class="form-group">
                <label for="email">Cari Tanggal : </label>
                <input value="<?php echo date('d-m-Y');?>" type="text" name="tglStartHarian" id="tglStartHarian" class="form-control datePicker" />
            </div>
            <button type="button" id="cariLaporanHarian" class="btn btn-success">Submit Query</button>
            <a href="?mod=laporanharian" class="btn btn-primary" id="refreshHalamanLaporanHarian">Refresh Halaman</a>
        </div>

        <br/>
        <div id="cekLaporanHarian"></div>
    </div>
</div>