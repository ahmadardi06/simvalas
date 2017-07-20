<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading text-center">Tentukan Pencarian Laporan Bulanan</div>
    <div class="panel-body text-center">
        <div class="form-inline">
            <?php $bulan = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni',
                                    '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'); ?>
            <div class="form-group">
                <label for="email">Pilih Bulan : </label>
                <select name="bulan" id="bulan" class="form-control">
                    <?php
                        foreach ($bulan as $bln => $value)
                        {
                            echo '<option value="'.$bln.'">'.$value.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pwd"> Pilih Tahun : </label>
                <input value="<?php echo date('Y');?>" type="text" name="tahun" id="tahun" class="form-control" />
            </div>
            <button type="submit" class="btn btn-success" id="cariLaporanBulanan">Submit Query</button>
            <a href="?mod=laporanbulanan" class="btn btn-primary" id="refreshHalamanLaporanHarian">Refresh Halaman</a>
        </div>
        <br/>
        <div id="cekLaporanOmzetBulanan"></div>
    </div>
</div>