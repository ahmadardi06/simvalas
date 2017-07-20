<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading text-center">Tentukan Pencarian Tiap Jenis Valas</div>
    <div class="panel-body text-center">
        <div class="form-inline">
            <?php
            $sql = $db->prepare("SELECT jenisvalas FROM saldovalas GROUP BY jenisvalas");
            $sql->execute();
            $data = $sql->fetchAll();
            ?>
            <div class="form-group">
                <label for="email">Jenis Valas : </label>
                <select name="jenis_valas" id="jenis_valas" class="form-control">
                    <?php
                    foreach($data as $dd){
                        echo "<option value='".$dd['JENISVALAS']."'>".$dd['JENISVALAS']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pwd"> Pilih Tanggal : </label>
                <input value="<?php echo date('d-m-Y');?>" type="text" name="tgl_valas" id="tgl_valas" class="form-control datePicker" />
            </div>
            <button type="submit" class="btn btn-success" id="cariLaporanJenisValas">Submit Query</button>
            <a href="?mod=jenisvalas" class="btn btn-primary" id="refreshHalamanLaporanHarian">Refresh Halaman</a>
        </div>
        <br/>
        <div id="cekLaporanJenisValas"></div>
    </div>
</div>