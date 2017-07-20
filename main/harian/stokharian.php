<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading text-center">Laporan Stok Harian</div>
    <div class="panel-body text-center">
        <div class="form-inline">
            <div class="form-group">
                <label for="email">Cari Tanggal : </label>
                <input value="<?php echo date('d-m-Y');?>" type="text" name="tglStokHarian" id="tglStokHarian" class="form-control datePicker" />
            </div>
            <button type="button" id="cariLaporanStokHarian" class="btn btn-success">Submit Query</button>
            <a href="?mod=laporanstokharian" class="btn btn-primary" id="refreshHalamanLaporanHarian">Refresh Halaman</a>
        </div>

        <br/>
        <div id="cekLaporanStokHarian"></div>
    </div>
</div>